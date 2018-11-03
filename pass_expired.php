<?php
$section = 'users';
$page    = 'passwd_expired';
$_public	= false;
$_include_path = 'include/';
require($_include_path.'/vitals.inc.php');
require($_include_path.'basic_html/header.php');
echo '<TR><TD COLSPAN="5">';

echo '<br><br>'.$_template['password_expired'].'<br><br>';
echo '</TD></TR>';
session_destroy();

require ($_include_path.'basic_html/footer.php'); 
?>