<?php

/* system configuration options: */
require($_include_path.'config.inc.php');
require($_include_path.'constants.inc.php');
require_once('DB.php');

require($_include_path.'grab_globals.lib.php');

/* constants: */
require($_include_path.'lib/constants.inc.php');

/* session variables: */
require($_include_path.'session.inc.php');

/* _feedback, _help, _errors constants definitions */
require($_include_path.'lib/lang_constants.inc.php');

/* template language variables */
if ($_POST['lang']) $_SESSION['lang'] = $_POST['lang'];
if (isset($_SESSION) && ($_SESSION['lang'] == 'en')){
	require($_include_path.'language/template_en.inc.php');
	require($_include_path.'language/tools_en.inc.php');
} else {
	$_SESSION['lang'] = 'ro';
	//require($_include_path.'language/en_lang.inc.php');
	require($_include_path.'language/template_ro.inc.php');
	require($_include_path.'language/tools_ro.inc.php');
}

/* date functions */
require($_include_path.'lib/date_functions.inc.php');

/* browser detector: */
require($_include_path.'AEBrowser.php');

$dsn = "oci8://klore:k@KLORE";

$db = DB::connect($dsn);
if (DB::isError($db)) {
	$_errors[] = AT_ERROR_NO_DB_CONNECT;
	print_errors($_errors);
	exit;
}

global $db;

   if (isset($_REQUEST['jump']) && $_REQUEST['jump'] && $_POST['form_course_id']) {
		if ($_POST['form_course_id'] == 0) {
			Header('Location: users/');
			exit;
		}

		Header('Location: bounce.php?course='.$_POST['form_course_id']);
		exit;
   }
   
/* cache library: */
include($_include_path.'phpCache/phpCache.inc.php');

/* content formatting library: */
require($_include_path.'lib/content_functions.inc.php');

/* content management class: */
require($_include_path.'classes/ContentManager.class.php');

/* preference switches for K-Lore HowTo: */
require($_include_path.'lib_howto/howto_switches.inc.php');


$contentManager = new ContentManager($db, $_SESSION['course_id']);
$contentManager->initContent( );
/**************************************************/


if (($_SESSION['course_id'] == 0) && ($section != 'users') && ($section != 'prog') && !$_GET['h']) {
	Header('Location: users/');
	exit;
}

// set debug true to show messages and step info
$_SESSION['debug'] = true;

/********************************************************************/
/* the system course information									*/
/* system_courses[course_id] = array(title, description, subject)	*/
$system_courses = array();

if ( !($et_l=cache(CACHE_TIME_OUT, 'system_courses', 'system_courses')) ) {

	$sql = "SELECT * FROM courses ORDER BY title";
	$result = $db->query($sql);
	while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$system_courses[$row['COURSE_ID']] = array(	'title' => $row['TITLE'], 
													'description' => $row['DESCRIPTION'], 
													'subject' => $row['SUBJECT']);
	}

	cache_variable('system_courses');
	endcache(true, true);
}

/*																	*/
/********************************************************************/

if ($_SESSION['course_id'] != 0) {
	$sql = "SELECT * FROM glossary WHERE course_id=$_SESSION[course_id] ORDER BY word";
	$result = $db->query($sql);
	$glossary = array();
	$glossary_ids = array();
	while ($row_g =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$glossary[$row_g['WORD']] = str_replace("'", "\'",$row_g['DEFINITION']);
		$glossary_ids[$row_g['WORD_ID']] = $row_g['WORD'];
	}
}

function debug($value) {
	if (!DEBUG) {
		return;
	}
	echo '<pre style="border: 1px black solid; padding: 0px; margin: 10px;">';
	
	ob_start();
	print_r($value);
	$str = ob_get_contents();
	ob_clean();

	$str = str_replace('<', '&lt;', $str);

	$str = str_replace('[', '<span style="color: red; font-weight: bold;">[', $str);
	$str = str_replace(']', ']</span>', $str);
	$str = str_replace('=>', '<span style="color: blue; font-weight: bold;">=></span>', $str);
	$str = str_replace('Array', '<span style="color: purple; font-weight: bold;">Array</span>', $str);
	echo $str;
	echo '</pre>';
}


function getMessage($codes, &$type) {
	$lib =& $type;

	if (is_array($codes)) {
		/* this is an array with terms to replace */
		$code		= array_shift($codes);
		$message	= $lib[$code];
		$terms		= $codes;

		/* replace the tokens with the terms */
		foreach ($terms as $index => $term) {
			$search[] = '%'.($index + 1);
		}
		$message = str_replace($search, $terms, $message);
	} else {
		$message = $lib[$codes];

		if ($message == '') {
			$message = $codes;
		}
		$code = $codes;
	}
	return $message;
}


function print_errors( $errors ) {
	global $_template;
	if (empty($errors)) {
		return;
	}

	global $_include_path;
	if (isset($_SESSION) && ($_SESSION['lang'] == 'ro')){
		include($_include_path.'language/errors_ro.inc.php');
	} else {
		include($_include_path.'language/errors_en.inc.php');
	}

	?>	
	<br />
	<table border="0" class="errbox" cellpadding="3" width="90%" cellspacing="2" summary="" align="center">
		<tr class="errbox">
		<td align="left">
			<h3><img src="images/error_x.gif" align="top" alt="<?php echo $_template['error']; ?>" /><?php echo $_template['error']; ?></h3><hr />
			<?php
				print_items($errors, $_errors);
			?>
			</td>
		</tr>
	</table>
	<br />
<?php
}

function print_feedback( $feedback ) {
	global $_template;
	if (empty($feedback)) {
		return;
	}
	global $_include_path;
	if (isset($_SESSION) && ($_SESSION['lang'] == 'ro')){
		include($_include_path.'language/feedback_ro.inc.php');
	} else {
		include($_include_path.'language/feedback_en.inc.php');
	}

	?>	<br />
	<table border="0" class="fbkbox" cellpadding="3" cellspacing="2" width="90%" summary="" align="center">
	<tr class="fbkbox">
	<td align="left">
		<table border="0"><tr><td>
			<img src="images/feedback_x.gif" align="top" alt="<?php echo $_template['feedback']; ?>" />
		</td><td>
		<?php

			print_items($feedback, $_feedback);

		?>
		</td>
		</tr>
		</table></td>
	</tr>
	</table>
	<br />
<?php
}

function print_help( $help ) {
	global $_template;
	if (empty($help)) {
		return;
	}

	global $_include_path, $_my_uri;
	if (isset($_SESSION) && ($_SESSION['lang'] == 'ro')){
		include($_include_path.'language/help_ro.inc.php');
	} else {
		include($_include_path.'language/help_en.inc.php');
	}

	if (!$_GET['e'] && !$_SESSION['prefs'][PREF_HELP] && !$_GET['h']) {

		echo '<a href="'.$_my_uri.'e=1"><img src="images/help.gif" align="top" alt="'.$_template['help'].'" border="0" /></a>';
		return;
	}
	?>	<br />
	<table border="0" class="hlpbox" cellpadding="3" cellspacing="2" width="90%" summary="" align="center">
	<tr class="hlpbox">
	<td align="left">
		<h3><?php
			if ($_GET['e']) {
				echo '<a href="'.$_my_uri.'">';
				echo '<img src="images/help.gif" align="top" alt="'.$_template['close_help'].'" border="0" title="'.$_template['close_help'].'"/></a> ';
			} else {
				echo '<img src="images/help.gif" align="top" alt="'.$_template['help'].'" border="0" /> ';
			}
			echo $_template['help'].'</h3><hr />';

			print_items($help, $_help);

		?>
		<!--div align="right"><br /><small><a href="help/about_help.php?h=1"><?php echo $_template['about_help']; ?></a>.</small></div-->
		</td>
	</tr>
	</table>
	<br />
<?php
}

function print_warnings( $warnings ) {
	global $_template;
	if (empty($warnings)) {
		return;
	}

	global $_include_path;
	if ($_SESSION['lang'] == 'en') {
		include($_include_path.'language/en_lang.inc.php');
	} else {
		include($_include_path.'language/ro_lang.inc.php');
	}

	?>	<br />
	<table border="0" class="wrnbox" cellpadding="3" cellspacing="2" width="90%" summary="" align="center">
	<tr class="wrnbox">
	<td align="left">
		<h3><img src="images/warning_x.gif" align="top" alt="<?php echo $_template['warning']; ?>" /><?php echo $_template['warning']; ?></h3><hr />
		<?php

			print_items($warnings, $_warning);

		?>
		</td>
	</tr>
	</table>
	<br />
<?php
}

function print_infos( $infos ) {
	global $_template;
	if (empty($infos)) {
		return;
	}
	
	global $_include_path;
	include($_include_path.'language/en_lang.inc.php');

	?>
	<table border="0" cellpadding="3" cellspacing="2" width="90%" summary="" align="center"  class="hlpbox">
	<tr class="hlpbox">
	<td align="left"><h3><img src="images/infos.gif" align="top" alt="<?php echo $_template['info']; ?>" /><?php echo $_template['info']; ?></h3><hr /><?php

	print_items($infos, $_infos);

	?>
	</td>
	</tr></table>

<?php
}

function print_items( $items, &$type ) {
	if (!$items) {
		return;
	}

	if (is_object($items)) {
		/* this is a PEAR::ERROR object.	*/
		/* for backwards compatability.		*/
		echo $items->getMessage();
		echo '.<p>';
		echo '<small>';
		echo $items->getUserInfo();
		echo '</small></p>';

	} else if (is_array($items)) {
		/* this is an array of errors */
		echo '<ul>';
		foreach($items as $e => $info){
			echo '<li>'.getMessage($info, $type).'</li>';
		}
		echo'</ul>';
	} else if (is_int($items)){
		/* this is a single error not an array of errors */
		/* echo '<ul>';
		echo '<li>'.getMessage($items, &$type).'</li>';
		echo '</ul>'; */
		echo getMessage($items, &$type);
	
	} else {
		/* not really sure what this is.. some kind of string.	*/
		/* for backwards compatability							*/
		/*echo '<ul>';
		echo '<li>'.$items.'</li>';
		echo'</ul>';*/
		echo $items;
	}
}

function print_popup_help($help, $align='left') {
	global $_help;
	global $_template;

	if (!$_SESSION['prefs'][PREF_MINI_HELP]) {
		return;
	}

	global $_include_path;
	if ($_SESSION['lang'] == 'en') {
		include($_include_path.'language/help_en.inc.php');
	} else {
		include($_include_path.'language/help_ro.inc.php');
	}

	if (!is_array($help)) {
		$text = $_help[$help];
		$text = str_replace('"','&quot;',$text);
		$text = str_replace("'",'&#8217;',$text);
		$text = str_replace('`','&#8217;',$text);
		$text = str_replace('<','&lt;',$text);
		$text = str_replace('>','&gt;',$text);

		$align="left";
		echo '<a href="popuphelp.php?h='.$help.'" target="_'.$help.'" onmouseover="return overlib(\'&lt;small&gt;'.$text.'&lt;/small&gt;\', CSSCLASS, FGCLASS, \'row1ph\', BGCLASS, \'cat2ph\', TEXTFONTCLASS, \'row1ph\', CENTER, OFFSETY, 20);" onmouseout="return nd();"><img src="images/help3.gif" border="0" align="'.$align.'"/></a>';
	}
}

function add_user_online() {
	if ($_SESSION['member_id'] == 0) {
		return;
	}
	global $db;

    $expiry = time() + 900; // 15min
    $sql = "SELECT COUNT(member_id) FROM users_online WHERE member_id=$_SESSION[member_id]";
    $res = $db->query($sql);
    $row = $res->fetchRow();
    if ($row[0] >0) {
    	$sql = "UPDATE users_online SET course_id=$_SESSION[course_id], expiry=$expiry WHERE member_id=$_SESSION[member_id]";
    	$res = $db->query($sql);
    } else {
	    $sql    = "INSERT INTO users_online VALUES ($_SESSION[member_id], $_SESSION[course_id], '$_SESSION[login]', $expiry)";
    	$result = $db->query($sql);
    }

	/* should garbage collect and optimize the table every so often */
	mt_srand((double) microtime() * 1000000);
	$rand = mt_rand(1, 20);
	if ($rand == 1) {
		$sql = 'DELETE FROM users_online WHERE expiry<'.time();
		$result = @$db->query($sql);

		$sql = "OPTIMIZE TABLE users_online";
		$result = @$db->query($sql);
	}
}

function get_login($id){
	global $db;

	$id		= intval($id);

	$sql	= "SELECT login FROM members WHERE member_id=$id";
	$result	= $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);

	return $row['LOGIN'];
}

function get_forum($fid){
	global $db;

	$fid = intval($fid);

	$sql	= "SELECT title FROM forums WHERE forum_id=$fid AND course_id=$_SESSION[course_id]";
	$result	= $db->query($sql);
	$row	=$result->fetchRow(DB_FETCHMODE_ASSOC);

	return $row['TITLE'];
}

/* this function will be removed soon. and replaced with usage of AT_date() */
function message_date($in_date) {

	$year	= substr($in_date,0,4);
	$month	= substr($in_date,5,2);
	$day	= substr($in_date,8,2);
	$hour	= substr($in_date,11,2);
	$min	= substr($in_date,14,2);
	$sec	= substr($in_date,17,2);
	$date	=  date('D, M j - H:i', mktime($hour,$min,$sec,$month,$day,$year));	

	return $date;
}

/**********
 * the learning concepts
 * $learning_concepts[concept_id] = array (title, description, icon_name)
 * $learning_concept_tags[tag]	  = array (concept_id, title, description, icon_name)
 */
$learning_concept_tags = array();
if ($_SESSION['course_id'] != '') {
	if ( !($et_l=cache(0, 'learning_concepts', $_SESSION['course_id'])) ) {
		$sql = "SELECT * FROM learning_concepts ORDER BY title";
		$result = $db->query($sql);
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$learning_concept_tags[$row['TAG']] = array('concept_id'  => $row['CONCEPT_ID'],
														'title'		  => $row['TITLE'],
														'description' => $row['DESCRIPTION'],
														'icon_name'	  => $row['ICON_NAME']);
		}

		cache_variable('learning_concept_tags');
		endcache(true, false);
	} /* end learning concepts cache */
}

	/* defaults: */
	if ( $_SESSION['prefs'] == '' ) {
		$temp_prefs = get_prefs(4);
		assign_session_prefs($temp_prefs);
		save_prefs();
	}
	/*
	debug($_SESSION['prefs']);
	$data	= addslashes(serialize($_SESSION['prefs']));
	debug($data);
	//exit;
	*/

	/* takes the array of valid prefs and assigns them to the current session */
	function assign_session_prefs ($prefs) {
		//if ($_SESSION['valid_user'] || $_SESSION['is_guest']) {
		if (is_array($prefs)) {
			foreach($prefs as $pref_name => $value) {
				$_SESSION['prefs'][$pref_name] = $value;
			}
		}
	}

	/* returns the unserialized prefs array */
	function get_prefs($pref_id) {
		global $db;

		$sql	= "SELECT preferences FROM theme_settings WHERE theme_id=$pref_id";
		$result	= $db->query($sql);

		if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			return unserialize(stripslashes($row['PREFERENCES']));
		}

		return false;
	}

/****************************************************/
/* change menu state								*/
if (isset($_GET['enable'])) {
	$_SESSION['prefs'][$_GET['enable']] = 1;
	save_prefs();

} else if (isset($_GET['disable'])) {
	$_SESSION['prefs'][$_GET['disable']] = 0;
	save_prefs();

} else if (isset($_GET['expand'])) {
	$_SESSION['menu'][intval($_GET['expand'])] = 1;

} else if (isset($_GET['collapse'])) {
	unset($_SESSION['menu'][intval($_GET['collapse'])]);
}

if (isset($_GET['cid'])) {
	$_SESSION['s_cid'] = intval($_GET['cid']);
}

function save_prefs($override = false) {
	global $db;

	if ($_SESSION['valid_user'] && $_SESSION['enroll'] && $_SESSION['course_id'] && !$override) {
		// save for this course only
		$data	= addslashes(serialize($_SESSION['prefs']));
		$sql	= "REPLACE INTO preferences VALUES ($_SESSION[member_id], $_SESSION[course_id], '$data')";
		$result = $db->query($sql);

	} else if ($_SESSION['valid_user']) {

		$data	= addslashes(serialize($_SESSION['prefs']));
		$sql	= "UPDATE members SET preferences='$data' WHERE member_id=$_SESSION[member_id]";
		$result = $db->query($sql); 

		/* these prefs will become global, but must also override this course's prefs	*/
		/* to override this course's prefs, just delete it to take the global.			*/
		$sql	= "DELETE FROM preferences WHERE member_id=$_SESSION[member_id]";
		$result	= $db->query($sql);
	}

	/* else, we're not a valid user so nothing to save. */
}

function urlencode_feedback($f) {
	if (is_array($f)) {
		return urlencode(serialize($f));
	}
	return $f;
}

/****************************************************/
/* check the availability of course/page			*/
function check_availability($row, $start){
	$ret = 0;
	global $db;
	
	$t_index = $db->nextId("AUTO_TMP_DATE_TMP");
	$sql = "INSERT INTO tmp_date VALUES(SYSDATE, $t_index)";
	$result = $db->query($sql);
	$sql = "SELECT TO_CHAR(data, 'DD/MM/YYYY HH24:MI:SS') AS data FROM tmp_date WHERE tmp=$t_index";
	$result = $db->query($sql);
	$row1 =$result->fetchRow(DB_FETCHMODE_ASSOC);
	$now_mysql = $row1['DATA'];
	
	$timestamp 	= $now_mysql;
	$hour		= substr($timestamp,11,2);
    $minute		= substr($timestamp,14,2);
    $second		= substr($timestamp,17,2);
    $month		= substr($timestamp,3,2);
    $day		= substr($timestamp,0,2);
    $year		= substr($timestamp,6,4);
    $now		= mktime($hour, $minute, $second, $month, $day, $year); 
    
	$timestamp = $row['START_DATE'];
	
	$hour		= substr($timestamp,11,2);
    $minute		= substr($timestamp,14,2);
    $second		= substr($timestamp,17,2);
    $month		= substr($timestamp,3,2);
    $day		= substr($timestamp,0,2);
    $year		= substr($timestamp,6,4);
    $start_date	= mktime($hour, $minute, $second, $month, $day, $year); 
    
    $timestamp = $row['END_DATE'];
    
	$hour		= substr($timestamp,11,2);
    $minute		= substr($timestamp,14,2);
    $second		= substr($timestamp,17,2);
    $month		= substr($timestamp,3,2);
    $day		= substr($timestamp,0,2);
    $year		= substr($timestamp,6,4);
    $end_date	= mktime($hour, $minute, $second, $month, $day, $year); 

    //echo 'END: '.$end_date.': now='.$now.' -- checked: '.($row['END_DATE']<>0).'<br>';
		
	if (($row['START_DATE']<>0) && ($start_date >$now)) {
		$sql = "DELETE FROM tmp_date WHERE tmp=$t_index";
		$res = $db->query($sql);
		$ret = -1;
	} 
	//echo 'exp: '.($end_date <$now).'end: '.$end_date.' - '.$now.'<br>';
	if (($row['END_DATE']<>0) && ($end_date <$now)) {
		//echo 'ok. Ret =1';
		$sql = "DELETE FROM tmp_date WHERE tmp=$t_index";
		$res = $db->query($sql);
		$ret = 1;
	}
	
	$timestamp = $row['START_DATE'];
	
	$hour		= substr($timestamp,11,2);
    $minute		= substr($timestamp,14,2);
    $second		= substr($timestamp,17,2);
    $month		= substr($timestamp,3,2);
    $day		= substr($timestamp,0,2);
    $year		= substr($timestamp,6,4);
    
    $p_day 	= mktime($hour, $minute, $second, $month, $day +intval($row['PERIOD']), $year);
    //echo 'A: '.$now.': '.$start_date.'<br>';
            
	if (($start>0) && ($now >$p_day)) {
		$ret = 1;
	}
	$sql = "DELETE FROM tmp_date WHERE tmp=$t_index";
	$res = $db->query($sql);
	
	return $ret;
}


/****************************************************/
/* check the availability of course/page			*/
/* NOTE: For some reason mktime returns only the 	*/
/* 		 date part, while time is of no importance	*/
function passwd_expired($status, $created, $modified){
	$ret = 0;
	global $db;

	$t_index = $db->nextId("AUTO_TMP_DATE_TMP");
	$sql = "INSERT INTO tmp_date VALUES(SYSDATE, $t_index)";
	$result = $db->query($sql);
	$sql = "SELECT TO_CHAR(data, 'DD/MM/YYYY HH24:MM:SS') AS data FROM tmp_date WHERE tmp=$t_index";
	$result = $db->query($sql);
	$row1 = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$now_mysql = $row1['DATA'];
	$status++; // the status is recorded in older versions as 0 based index. TBC.
	$sql = "SELECT pass_expiry FROM mpass WHERE status=$status";
	$res = $db->query($sql);
	$p_row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	$p_day = intval($p_row['PASS_EXPIRY']);
	
	/* DEBUG: 
	echo 'NOW: '.$now_mysql.'<br>';
	echo 'Created: '.$created.'<br>';
	echo 'Modified: '.$modified.'<br>';*/
	
	$timestamp 	= $now_mysql;
	$hour		= substr($timestamp,11,2);
    $minute		= substr($timestamp,14,2);
    $second		= substr($timestamp,17,2);
    $month		= substr($timestamp,3,2);
    $day		= substr($timestamp,0,2);
    $year		= substr($timestamp,6,4);
    $now		= mktime($hour, $minute, $second, $month, $day, $year); 
    // DEBUG: echo '<br>NOW: '.$now.' (mysql: '.$timestamp.' = '.$day.'-'.$month.'-'.$year.' - '.$hour.':'.$minute.':'.$second.')';
    
	$timestamp = $modified;
	if ($timestamp == 0) {
		$timestamp = $created;
	}
	
	$hour		= intval(substr($timestamp,11,2));
    $minute		= intval(substr($timestamp,14,2));
    $second		= intval(substr($timestamp,17,2));
    $month		= intval(substr($timestamp,3,2));
    $day		= intval(substr($timestamp,0,2));
    $year		= intval(substr($timestamp,6,4));
    $modif_date	= mktime($hour, $minute, $second, $month, $day, $year); 
    $plus_date	= add_time($timestamp, 0, 0, 0, $p_day, 0, 0);
    $exp_date	= $modif_date + $plus_date;
    /* DEBUG: 
    echo '<BR>MOD: '.$modif_date.' (mysql: '.$timestamp.' = '.$day.'-'.$month.'-'.$year.')';
    echo '<BR>PLUS: '.$plus_date.' (days: '.$p_day.')';
    echo '<BR>EXPR: '.$exp_date;  */
    
    //$diff = $exp_date - $now;
    // DEBUG: echo 'NOW - EXP = '.$diff.'<br>';
    if ($now <= $exp_date) {
    	if (($exp_date - $now) < (3*86400)) {
    		$ret = 1; // warn the user to change passwd
    	} else {
    		$ret = 0;
    	} 
	} else {
		$ret = -1;
	}
	
	$sql = "DELETE FROM tmp_date WHERE tmp=$t_index";
	$res = $db->query($sql);
	
	return $ret;
}

/****************************************************/
/* adds time to a date-time							*/
function add_time($timestamp, $seconds,$minutes,$hours,$days,$months,$years) {
	$mytime	= mktime(1+$hours,0+$minutes,0+$seconds,1+$months,1+$days,1970+$years);
	$times	= $timestamp + $mytime;
	if ($months!=0) {
		$year	= date('Y',$times)*12+date('n',$times)*1;
		$year2	= $year+$months;
		$year3	= floor($year2/12);
		$month3 = abs($year2-$year3*12);
		$times	= mktime (date('H',$times),date('i',$times),date('s',$times), $month3,date('j',$times),date('Y',$times));
	} 
	return $times;
}


/****************************************************/
/* update the user online list						*/
	$new_minute = time()/60;
	$diff       = abs($_SESSION['last_updated'] - $new_minute);
	if ($diff > ONLINE_UPDATE) {
		$_SESSION['last_updated'] = $new_minute;
		add_user_online();
	}

/****************************************************/
/* compute the $_my_uri variable					*/
	$bits	  = explode(SEP, getenv('QUERY_STRING'));
	$num_bits = count($bits);
	$_my_uri  = '';

	for ($i=0; $i<$num_bits; $i++) {
		if (	(strpos($bits[$i], 'enable=')	=== 0) 
			||	(strpos($bits[$i], 'disable=')	=== 0)
			||	(strpos($bits[$i], 'expand=')	=== 0)
			||	(strpos($bits[$i], 'g=')		=== 0)
			||	(strpos($bits[$i], 'collapse=')	=== 0)
			||	(strpos($bits[$i], 'f=')		=== 0)
			||	(strpos($bits[$i], 'e=')		=== 0)
			||	(strpos($bits[$i], 'save=')		=== 0)
			) {
			/* we don't want this variable added to my_uri */
			continue;
		}

		if (($_my_uri == '') && ($bits[$i] != '')) {
			$_my_uri .= '?';
		} else if ($bits[$i] != ''){
			$_my_uri .= SEP;
		}
		$_my_uri .= $bits[$i];
	}
	if ($_my_uri == '') {
		$_my_uri .= '?';
	} else {
		$_my_uri .= SEP;
	}
	$_my_uri = $PHP_SELF.$_my_uri;


/****************************************************/
/* update the g database							*/
if (!isset($_GET['cid'])) {
	$_GET['cid'] = 0;
}
if (!isset($_POST['g'])) {
	$_POST['g'] = 0;
}
if (!isset($_GET['g'])) {
	$_GET['g'] = 0;
}

	$new_cid = intval($_GET['cid']);
	$g		 = intval($_POST['g']);
	if ($g === 0) {
		$g = intval($_GET['g']);
	}
	;
	if ($_SESSION['track_me']
		&& $_SESSION['valid_user']
		&& !$_SESSION['is_admin'] 
		&& ($g !== 0)
		&& $_SESSION['course_id'])
	{
		$now = time();
		$sql	= "INSERT INTO g_click_data VALUES ($_SESSION[member_id],
					$_SESSION[course_id],
					$_SESSION[from_cid],
					$new_cid,
					$g,
					$now,
					0)";
		$result = @$db->query($sql);
		//calculate duration and update the previous record
		if($_SESSION['pretime']){
			$duration = ($now-$_SESSION['pretime']);
			//echo $duration;
		} else {
			$duration = 0;
		}

		if (!$_SESSION['pretime']) $_SESSION['pretime'] = '0';
		$sql2 = "UPDATE g_click_data SET duration=$duration WHERE timestamp=$_SESSION[pretime] AND member_id=$_SESSION[member_id]";
		$_SESSION['pretime'] = $now;
		if(!$result2 = @$db->query($sql2)){
			$errors[]="Database was not updated";
		}
	}


/****************************************************/
/* builds string representation of array			*/
function getval($row) {
	$ret = '';
	$ret = $row[0];
	$c = intval(count($row)/2);
	for ($i=1; $i<$c; $i++) {
		$ret = $ret.", '".$row[$i]."'";
	}
	return $ret;
}
	
/****************************************************/

$_SESSION['from_cid'] = intval($_GET['cid']);

if (!isset($_ignore_page)) {
	$_SESSION['my_referer'] = $_SERVER['REQUEST_URI'];
}
/****

$i = 1;
//Uncomment this foreach statement to display language ids
foreach($_template as $k => $v) {
	$_template[$k] = $v.'-'.$i++;
}
***/


if (!isset($_SESSION['prefs'][PREF_STACK])) {
	$_SESSION['prefs'][PREF_STACK] = array(0, 1, 2, 3, 4);
}

$_stacks = array('local_menu', 'menu_menu', 'related_topics', 'users_online', 'glossary');


/**
 * @return md5($pass.KEY) 
 * @desc encrytps the password 
 */
function hash_pass($pass) {
	
	if (isset($pass)) {
			return md5($pass.'KPass');
	}else return false;
}

function check_pass($mid,$pass) {
		
	$sql='SELECT password FROM members WHERE member_id='.$mid;
	$result =@$db->query($sql);
	$row =$result->fetchRow();
	if (md5($pass.'KPass')==$row[0]) {return true;}
	else {return false;}
}


include ($_include_path.'policy_check.inc.php');
// error_reporting(E_NOTICE | E_WARNNING | E_PARSE | E_ERROR );
?>
