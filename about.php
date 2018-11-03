<?php
$section = 'users';
$page    = 'about';
$_public	= true;
$_include_path = 'include/';
require($_include_path.'/vitals.inc.php');
require($_include_path.'basic_html/header.php');
session_destroy();
echo '<TR><TD COLSPAN="5">';
?>
<br><br><h3><?php echo $_template['welcome_to_klore']; ?></h3><br>
<p><?php echo $_template['klore_is'];  ?></p>

<h3><?php echo $_template['more_information']; ?></h3><br>
<p><?php echo $_template['find_latest']; ?></p>
</TD></TR>

<?php
	require ($_include_path.'basic_html/footer.php'); 
?>