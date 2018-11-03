<?php

if ($_GET['submit']) {
	$save_pref = true;
}

$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
$_section[0][0] = $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] = $_template['course_default_prefs'];


require($_include_path.'header.inc.php');

if (!$_SESSION['is_admin']) {
	$errors[]=AT_ERROR_PREFS_NO_ACCESS;
	print_errors($errors);
	exit;
}

?>
<h2><a href="tools/" class="hide" ><?php echo  $_template['tools']; ?></a></h2>
<h3><?php echo $_template['course_default_prefs']; ?></h3>
<p>You can assign your <a href="tools/preferences.php">current preferences</a> to be used as the course default.</p>
<p><a href="tools/preferences.php?save=4"><?php echo $_template['save_default_prefs']; ?></a>.</p>
<?php

	require($_include_path.'footer.inc.php');
?>
