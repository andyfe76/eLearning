<?php

$section = 'users';
$_public	= true;
$_include_path = 'include/';
require ('include/vitals.inc.php');

$sql = "DELETE FROM users_online WHERE member_id=$_SESSION[member_id]";
$result = @mysql_query($sql, $db);

session_destroy(); 
session_unset();

require($_include_path.'basic_html/header.php');
echo '<tr><td colspan="5">';
echo $_template['logged_out'];

require($_include_path.'basic_html/footer.php'); 

?>