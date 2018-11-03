<?php

$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'classes/pclzip.lib.php');
$course = intval($_GET['course']);

if ($_POST['cancel']) {
	Header('Location: index.php?f='.AT_FEEDBACK_EXPORT_CANCELLED);
	exit;
}

if ($course == 0) {
	$course = intval($_POST['course']);
}

/* make sure we own this course that we're exporting */
$sql	= "SELECT * FROM courses WHERE course_id=$course AND member_id=$_SESSION[member_id]";
$result	= mysql_query($sql, $db);
if (!$row2 = mysql_fetch_array($result)) {
	require($_include_path.'cc_html/header.inc.php');
	$errors[] = AT_ERROR_NOT_OWNER;
	print_errors($errors);
	require ($_include_path.'cc_html/footer.inc.php'); 
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

	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_array($result)) {
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
	@mysql_free_result($result); 

	$fp = @fopen('../content/export/'.$name.'.csv', 'w');
	if (!$fp) {
		$errors[]=array(AT_ERROR_CSV_FAILED, $name);
		print_errors($errors);
		exit;
	}
	@fputs($fp, $content); @fclose($fp);
}

if ($_POST['submit']) {
	$row2['title'] = str_replace(' ',  '_', $row2['title']);
	$row2['title'] = str_replace('%',  '',  $row2['title']);
	$row2['title'] = str_replace('\'', '',  $row2['title']);
	$row2['title'] = str_replace('"',  '',  $row2['title']);
	$row2['title'] = str_replace('`',  '',  $row2['title']);

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
	$fields[0] = array('content_id',		NUMBER);
	$fields[1] = array('content_parent_id', NUMBER);
	$fields[2] = array('ordering',			NUMBER);
	$fields[3] = array('last_modified',		TEXT);
	$fields[4] = array('revision',			NUMBER);
	$fields[5] = array('formatting',		NUMBER);
	$fields[6] = array('release_date',		TEXT);
	$fields[7] = array('title',				TEXT);
	$fields[8] = array('text',				TEXT);

	save_csv('content', $sql, $fields);
	/****************************************************/

	/* forums.csv */
	$sql	= 'SELECT * FROM forums WHERE course_id='.$course.' ORDER BY forum_id ASC';
	$fields = array();
	$fields[0] = array('title',			TEXT);
	$fields[1] = array('description',	TEXT);

	save_csv('forums', $sql, $fields);
	/****************************************************/

	/* related_content.csv */
	$sql	= 'SELECT R.content_id, R.related_content_id FROM related_content R, content C WHERE C.course_id='.$course.' AND R.content_id=C.content_id ORDER BY R.content_id ASC';
	$fields = array();
	$fields[0] = array('content_id',			NUMBER);
	$fields[1] = array('related_content_id',	NUMBER);

	save_csv('related_content', $sql, $fields);
	/****************************************************/

	/* glossary.csv */
	$sql	= 'SELECT * FROM glossary WHERE course_id='.$course.' ORDER BY word_id ASC';
	$fields = array();
	$fields[0] = array('word_id',			NUMBER);
	$fields[1] = array('word',				TEXT);
	$fields[2] = array('definition',		TEXT);
	$fields[3] = array('related_word_id',	NUMBER);

	save_csv('glossary', $sql, $fields);
	/****************************************************/

	/* resource_categories.csv */
	$sql	= 'SELECT * FROM resource_categories WHERE course_id='.$course.' ORDER BY CatID ASC';
	$fields = array();
	$fields[0] = array('CatID',		NUMBER);
	$fields[1] = array('CatName',	TEXT);
	$fields[2] = array('CatParent', NUMBER);

	save_csv('resource_categories', $sql, $fields);
	/****************************************************/

	/* resource_links.csv */
	$sql	= 'SELECT L.* FROM resource_links L, resource_categories C WHERE C.course_id='.$course.' AND L.CatID=C.CatID ORDER BY LinkID ASC';
	$fields = array();
	$fields[0] = array('CatID',			NUMBER);
	$fields[1] = array('Url',			TEXT);
	$fields[2] = array('LinkName',		TEXT);
	$fields[3] = array('Description',	TEXT);
	$fields[4] = array('Approved',		NUMBER);
	$fields[5] = array('SubmitName',	TEXT);
	$fields[6] = array('SubmitEmail',	TEXT);
	$fields[7] = array('SubmitDate',	TEXT);
	$fields[8] = array('hits',			NUMBER);

	save_csv('resource_links', $sql, $fields);
	/****************************************************/

	/* news.csv */
	$sql	= 'SELECT * FROM news WHERE course_id='.$course.' ORDER BY news_id ASC';
	$fields = array();
	$fields[0] = array('date',		TEXT);
	$fields[1] = array('formatting',NUMBER);
	$fields[2] = array('title',		TEXT);
	$fields[3] = array('body',		TEXT);
	
	save_csv('news', $sql, $fields);
	/****************************************************/

	/* tests.csv */
	$sql	= 'SELECT * FROM tests WHERE course_id='.$course.' ORDER BY test_id ASC';
	$fields = array();
	$fields[] = array('test_id',			NUMBER);
	$fields[] = array('title',				TEXT);
	$fields[] = array('format',				NUMBER);
	$fields[] = array('start_date',			TEXT);
	$fields[] = array('end_date',			TEXT);
	$fields[] = array('randomize_order',	NUMBER);
	$fields[] = array('num_questions',		NUMBER);
	$fields[] = array('instructions',		TEXT);
	save_csv('tests', $sql, $fields);
	/****************************************************/

	/* tests_questions.csv */
	$sql	= 'SELECT * FROM tests_questions WHERE course_id='.$course.' ORDER BY test_id ASC';
	$fields = array();
	//$fields[0] = array('question_id',		NUMBER);
	$fields[] = array('test_id',			NUMBER);
	$fields[] = array('ordering',			NUMBER);
	$fields[] = array('type',				NUMBER);
	$fields[] = array('weight',				NUMBER);
	$fields[] = array('required',			NUMBER);
	$fields[] = array('feedback',			TEXT);
	$fields[] = array('question',			TEXT);
	$fields[] = array('choice_0',			TEXT);
	$fields[] = array('choice_1',			TEXT);
	$fields[] = array('choice_2',			TEXT);
	$fields[] = array('choice_3',			TEXT);
	$fields[] = array('choice_4',			TEXT);
	$fields[] = array('choice_5',			TEXT);
	$fields[] = array('choice_6',			TEXT);
	$fields[] = array('choice_7',			TEXT);
	$fields[] = array('choice_8',			TEXT);
	$fields[] = array('choice_9',			TEXT);
	$fields[] = array('answer_0',			NUMBER);
	$fields[] = array('answer_1',			NUMBER);
	$fields[] = array('answer_2',			NUMBER);
	$fields[] = array('answer_3',			NUMBER);
	$fields[] = array('answer_4',			NUMBER);
	$fields[] = array('answer_5',			NUMBER);
	$fields[] = array('answer_6',			NUMBER);
	$fields[] = array('answer_7',			NUMBER);
	$fields[] = array('answer_8',			NUMBER);
	$fields[] = array('answer_9',			NUMBER);
	$fields[] = array('answer_size',		NUMBER);

	save_csv('tests_questions', $sql, $fields);
	/****************************************************/


	/* copy the content for archiving */
	$exec = 'cd ../content/; cp -R '.$course.'/ export/content';
	$result = system ( $exec );
	
	$exec = 'cd ../content/export/';
	$result = system ( $exec );

	$path = '../content/export/';

	/* create the archive */
	$archive = new PclZip($path.escapeshellcmd($row2['title']).'.zip');
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
    header('Content-Disposition: inline; filename="'.escapeshellcmd($row2['title']).'.zip"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');


	@readfile('../content/export/'.escapeshellcmd ($row2['title']).'.zip');
	@unlink('../content/export/'.escapeshellcmd ($row2['title']).'.zip');

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

<p>Importing into <b><?php echo $row2['title']; ?></b>.</p>

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
<p><?php echo $_template['exporting']; ?><b><?php echo $row2['title']; ?></b>.</p>
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