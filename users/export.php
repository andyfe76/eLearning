<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'classes/pclzip.lib.php');

$course = intval($_GET['course']);

if ($course==0) $course = intval($_POST['course']);

$sql	= "SELECT * FROM courses WHERE course_id=$course";
$result	= $db->query($sql);
$row2 = $result->fetchRow(DB_FETCHMODE_ASSOC);

if ($_POST['cancel']) {
	Header('Location: index.php?f='.AT_FEEDBACK_EXPORT_CANCELLED);
	exit;
}

function quote_csv($line) {
	$line = str_replace('"', '""', $line);

	$line = str_replace("\n", '\n', $line);
	$line = str_replace("\r", '\r', $line);
	$line = str_replace("\x00", '\0', $line);

	return '"'.$line.'"';
}

function save_csv($name, $sql, $fields) {
	global $db;

	$content = '';
	$num_fields = count($fields);

	$result = $db->query($sql);
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		for ($i=0; $i< $num_fields; $i++) {
			if ($fields[$i][1] == NUMBER) {
				$content .= $row[$fields[$i][0]] . ',';
			} else {
				$content .= quote_csv($row[$fields[$i][0]]) . ',';
			}
		}
		$content = substr($content, 0, strlen($content)-1);
		$content .= "\n";
	}
	$result->free(); 

	$fp = @fopen('../content/export/'.$name.'.csv', 'w');
	if (!$fp) {
		$errors[]=array(AT_ERROR_CSV_FAILED, $name);
		print_errors($errors);
		exit;
	}
	@fputs($fp, $content); @fclose($fp);
}

if ($_POST['submit']) {
	$row2['TITLE'] = str_replace(' ',  '_', $row2['TITLE']);
	$row2['TITLE'] = str_replace('%',  '',  $row2['TITLE']);
	$row2['TITLE'] = str_replace('\'', '',  $row2['TITLE']);
	$row2['TITLE'] = str_replace('"',  '',  $row2['TITLE']);
	$row2['TITLE'] = str_replace('`',  '',  $row2['TITLE']);

	/* check if ../content/export/ exists */
	if (!is_dir('../content/export/')) {
		if (!@mkdir('../content/export', 0700)) {
			$errors[]=AT_ERROR_EXPORTDIR_FAILED;
			print_errors($errors);
			exit;
		}
	}

	define('NUMBER',	1);
	define('TEXT',		2);

	/* content.csv */
	$sql	= 'SELECT * FROM content WHERE course_id='.$course.' ORDER BY content_parent_id, ordering';

	$fields = array();
	$fields[0] = array('CONTENT_ID',		NUMBER);
	$fields[1] = array('CONTENT_PARENT_ID', NUMBER);
	$fields[2] = array('ORDERING',			NUMBER);
	$fields[3] = array('LAST_MODIFIED',		TEXT);
	$fields[4] = array('REVISION',			NUMBER);
	$fields[5] = array('FORMATTING',		NUMBER);
	$fields[6] = array('RELEASE_DATE',		TEXT);
	$fields[7] = array('TITLE',				TEXT);
	$fields[8] = array('TEXT',				TEXT);

	save_csv('content', $sql, $fields);
	/****************************************************/

	/* forums.csv */
	$sql	= 'SELECT * FROM forums WHERE course_id='.$course.' ORDER BY forum_id ASC';
	$fields = array();
	$fields[0] = array('TITLE',			TEXT);
	$fields[1] = array('DESCRIPTION',	TEXT);

	save_csv('forums', $sql, $fields);
	/****************************************************/

	/* related_content.csv */
	$sql	= 'SELECT R.content_id, R.related_content_id FROM related_content R, content C WHERE C.course_id='.$course.' AND R.content_id=C.content_id ORDER BY R.content_id ASC';
	$fields = array();
	$fields[0] = array('CONTENT_ID',			NUMBER);
	$fields[1] = array('RELATED_CONTENT_ID',	NUMBER);

	save_csv('related_content', $sql, $fields);
	/****************************************************/

	/* glossary.csv */
	$sql	= 'SELECT * FROM glossary WHERE course_id='.$course.' ORDER BY word_id ASC';
	$fields = array();
	$fields[0] = array('WORD_ID',			NUMBER);
	$fields[1] = array('WORD',				TEXT);
	$fields[2] = array('DEFINITION',		TEXT);
	$fields[3] = array('RELATED_WORD_ID',	NUMBER);

	save_csv('glossary', $sql, $fields);
	/****************************************************/

	/* resource_categories.csv */
	$sql	= 'SELECT * FROM resource_categories WHERE course_id='.$course.' ORDER BY CatID ASC';
	$fields = array();
	$fields[0] = array('CATID',		NUMBER);
	$fields[1] = array('CATNAME',	TEXT);
	$fields[2] = array('CATPARENT', NUMBER);

	save_csv('resource_categories', $sql, $fields);
	/****************************************************/

	/* resource_links.csv */
	$sql	= 'SELECT L.* FROM resource_links L, resource_categories C WHERE C.course_id='.$course.' AND L.CatID=C.CatID ORDER BY LinkID ASC';
	$fields = array();
	$fields[0] = array('CATID',			NUMBER);
	$fields[1] = array('URL',			TEXT);
	$fields[2] = array('LINKNAME',		TEXT);
	$fields[3] = array('DESCRIPTION',	TEXT);
	$fields[4] = array('APPROVED',		NUMBER);
	$fields[5] = array('SUBMITNAME',	TEXT);
	$fields[6] = array('SUBMITEMAIL',	TEXT);
	$fields[7] = array('SUBMITDATE',	TEXT);
	$fields[8] = array('HITS',			NUMBER);

	save_csv('resource_links', $sql, $fields);
	/****************************************************/

	/* news.csv */
	$sql	= 'SELECT * FROM news WHERE course_id='.$course.' ORDER BY news_id ASC';
	$fields = array();
	$fields[0] = array('DATA',		TEXT);
	$fields[1] = array('FORMATTING',NUMBER);
	$fields[2] = array('TITLE',		TEXT);
	$fields[3] = array('BODY',		TEXT);
	
	save_csv('news', $sql, $fields);
	/****************************************************/

	/* tests.csv */
	$sql	= 'SELECT * FROM tests WHERE course_id='.$course.' ORDER BY test_id ASC';
	$fields = array();
	$fields[] = array('TEST_ID',			NUMBER);
	$fields[] = array('TITLE',				TEXT);
	$fields[] = array('FORMAT',				NUMBER);
	$fields[] = array('START_DATE',			TEXT);
	$fields[] = array('END_DATE',			TEXT);
	$fields[] = array('RANDOMIZE_ORDER',	NUMBER);
	$fields[] = array('NUM_QUESTIONS',		NUMBER);
	$fields[] = array('INSTRUCTIONS',		TEXT);
	save_csv('tests', $sql, $fields);
	/****************************************************/

	/* tests_questions.csv */
	$sql	= 'SELECT * FROM tests_questions WHERE course_id='.$course.' ORDER BY test_id ASC';
	$fields = array();
	//$fields[0] = array('question_id',		NUMBER);
	$fields[] = array('TEST_ID',			NUMBER);
	$fields[] = array('ORDERING',			NUMBER);
	$fields[] = array('TYPE',				NUMBER);
	$fields[] = array('WEIGHT',				NUMBER);
	$fields[] = array('REQUIRED',			NUMBER);
	$fields[] = array('FEEDBACK',			TEXT);
	$fields[] = array('QUESTION',			TEXT);
	$fields[] = array('CHOICE_0',			TEXT);
	$fields[] = array('CHOICE_1',			TEXT);
	$fields[] = array('CHOICE_2',			TEXT);
	$fields[] = array('CHOICE_3',			TEXT);
	$fields[] = array('CHOICE_4',			TEXT);
	$fields[] = array('CHOICE_5',			TEXT);
	$fields[] = array('CHOICE_6',			TEXT);
	$fields[] = array('CHOICE_7',			TEXT);
	$fields[] = array('CHOICE_8',			TEXT);
	$fields[] = array('CHOICE_9',			TEXT);
	$fields[] = array('ANSWER_0',			NUMBER);
	$fields[] = array('ANSWER_1',			NUMBER);
	$fields[] = array('ANSWER_2',			NUMBER);
	$fields[] = array('ANSWER_3',			NUMBER);
	$fields[] = array('ANSWER_4',			NUMBER);
	$fields[] = array('ANSWER_5',			NUMBER);
	$fields[] = array('ANSWER_6',			NUMBER);
	$fields[] = array('ANSWER_7',			NUMBER);
	$fields[] = array('ANSWER_8',			NUMBER);
	$fields[] = array('ANSWER_9',			NUMBER);
	$fields[] = array('ANSWER_SIZE',		NUMBER);

	save_csv('tests_questions', $sql, $fields);
	/****************************************************/


	/* copy the content for archiving */
	$exec = 'cd ../content/; cp -R '.$course.'/ export/content';
	$result = system ( $exec );
	
	$exec = 'cd ../content/export/';
	$result = system ( $exec );

	$path = '../content/export/';

	$sql = "SELECT title FROM courses WHERE course_id=$course";
	$res = $db->query($sql);
	$cline = $res->fetchRow();
	
	/* create the archive */
	$archive = new PclZip($path.escapeshellcmd($row2['TITLE']).'.zip');
	// $list = $archive->add($path.'content/ '.$path.'content.csv '.$path.'forums.csv '.$path.'related_content.csv '.$path.'glossary.csv '.$path.'resource_categories.csv '.$path.'resource_links.csv '.$path.'news.csv '.$path.'tests.csv '.$path.'tests_questions.csv', PCLZIP_OPT_REMOVE_PATH, $path);
	$list = $archive->add($path.'content.csv '.$path.'forums.csv '.$path.'related_content.csv '.$path.'glossary.csv '.$path.'resource_categories.csv '.$path.'resource_links.csv '.$path.'news.csv '.$path.'tests.csv '.$path.'tests_questions.csv', PCLZIP_OPT_REMOVE_PATH, $path);

	if ($list == 0) {
		debug($archive);
		die ("Unrecoverable error '".$archive->errorInfo()."'");
	}
	
	/*
	$exec = 'cd ../content/export/; tar -cf '.escapeshellcmd ($row2['title']).'.tar content/ content.csv forums.csv  related_content.csv glossary.csv resource_categories.csv resource_links.csv news.csv tests.csv tests_questions.csv';
	//echo 'print something';
	$result = system ( $exec );
	if ($result === false) {
		$errors[] = AT_ERRORS_TARFILE_FAILED;
		print_errors($errors);
		exit;
	}
	*/

	/*
	/* gzip the archive *
	$exec = 'cd ../content/export; gzip '.escapeshellcmd ($row2['title']).'.tar';
	$result = system ( $exec );
	if ($result === false) {
		$errors[]=AT_ERROR_TARGZFILE_FAILED;
		print_errors($errors);
		exit;
	}
	*/

	$exec = 'cd ../content/export; \rm -r content/';
	$result = system ( $exec );

	@unlink('../content/export/content.csv');
	@unlink('../content/export/forums.csv');
	@unlink('../content/export/related_content.csv');
	@unlink('../content/export/glossary.csv');
	@unlink('../content/export/resource_categories.csv');
	@unlink('../content/export/resource_links.csv');
	@unlink('../content/export/news.csv');
	@unlink('../content/export/tests.csv');
	@unlink('../content/export/tests_questions.csv');
	
	header('Content-Type: application/x-zip-compressed');
    header('Content-Disposition: inline; filename="'.escapeshellcmd($row2['TITLE']).'.zip"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');


	@readfile('../content/export/'.escapeshellcmd ($row2['TITLE']).'.zip');
	@unlink('../content/export/'.escapeshellcmd ($row2['TITLE']).'.zip');

	exit;
}

$_SESSION['done'] = 0;
session_write_close();

require($_include_path.'cc_html/header.inc.php');
$help[]=AT_HELP_IMPORT_EXPORT;
$help[]=AT_HELP_IMPORT_EXPORT1;
?>
<?php print_help($help);  ?>
<h2><?php echo $_template['import_course']; ?></h2>

<p>Importing into <b><?php echo $row2['TITLE']; ?></b>.</p>

<form name="form1" method="post" action="users/import.php" enctype="multipart/form-data" onsubmit="openWindow('<?php echo $_base_href; ?>tools/prog.php');">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />

<input type="hidden" name="course" value="<?php echo $course; ?>">

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td class="row1" colspan="2"><?php echo $_template['import_about']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2"><strong><?php echo $_template['import_course']; ?></strong>: <input type="file" name="file" class="formfield" /><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="center" colspan="2"><input type="submit" name="submit" value="<?php echo $_template['import']; ?>" class="button" /> - <input type="submit" name="cancel" value="<?php echo $_template['cancel']; ?>" class="button" /></td>
</table>
</form>

<br /><br />

<h2><?php echo $_template['export_course']; ?></h2>
<p><?php echo $_template['exporting']; ?><b><?php echo $row2['TITLE']; ?></b>.</p>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<input type="hidden" name="course" value="<?php echo $course; ?>">

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td class="row1"><p><?php echo $_template['export_about']; ?></p></td>
</tr>
<tr><td height="1" class="row2"></td></tr>
<tr><td height="1" class="row2"></td></tr>
<tr>
	<td class="row1" align="center"><input type="submit" name="submit" value="<?php echo $_template['export']; ?>" class="button" /> - <input type="submit" name="cancel" value="<?php echo $_template['cancel']; ?>" class="button" /></td>
</table>
</form>

<script language="javascript">
function openWindow(page) {
	newWindow = window.open(page, "progWin", "width=400,height=200,toolbar=no,location=no");
	newWindow.focus();
}
</script>


<?php
	require ($_include_path.'cc_html/footer.inc.php'); 
?>