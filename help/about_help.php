<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
$_section[0][0] = 'Help';
$_section[0][1] = 'help/';
$_section[1][0] = 'About klore Help';
if($_SESSION['course_id'] == 0){
	require($_include_path.'cc_html/header.inc.php');
}else{
	require($_include_path.'header.inc.php');
}
if($_SESSION['course_id']!=0){
echo '<a href="help/?g=11"><h2>Help</h2></a>';
}
?>

<h3>About klore Help</h3>

<p> klore Help is available in various forms:</p>

<ul>
<li><strong><em>klore Help Boxes</em></strong>: Help boxes are scattered throughout klore to explain how tools work, and to provide tips for getting the most effective use out of these tools. <strong><em>Enable or disable klore Help</em></strong> boxes by adjusting this setting in the Display Options of your
<?php
if($_SESSION['course_id'] == 0){
	echo '<a href="users/preferences.php?g=12;h=1">preferences</a>.';
}else{
	echo '<a href="tools/preferences.php?g=12">preferences</a>.';
}

?>

 After you have become familiar with klore, you may wish to disabled the Help Boxes. Help is still easily accessible by clicking on the Help icons.<?php $help[]=AT_HELP_DEMO_HELP2; print_help($help);  ?><br /><br /></li>
<li><strong><em>Context Sensitive Help</em></strong>: On tools pages the mini help icon [
<?php
if($_SESSION['prefs']['PREF_MINI_HELP']==1){
	print_popup_help(AT_HELP_DEMO_HELP, '');
}else{
echo  ' <img src="images/help3.gif" alt=" " /> '; 
}
?>
 ]will appear beside various fields to indicate how a field is intended to be used. Hover over the icon with a mouse pointer to display the accompanying help, or click on the icon to open the help in a new window. For browsers that support the "<strong>title</strong>" attribute in various HTML elements, holding a mouse pointer over an icon or a link will often give you extra information about the tool, such as its accesskey.<br /><br /></li>
</ul>
<?php
if($_SESSION['course_id'] == 0){
	require($_include_path.'cc_html/footer.inc.php');
}else{
	require($_include_path.'footer.inc.php');
}
//require($_include_path.'footer.inc.php');
?>
