<?php

//All languages require this file
require('en_defs.inc.php');

//See what language is set and get the appropriate translation file

$_SESSION['lang'] = "en";
if($_SESSION['lang'] = "en"){
require('en_template.inc.php');
require('en_tools.inc.php');
	require('en_lang.inc.php');

} else if ($_SESSION['lang'] = "fr") {

	require('fr_lang.inc.php');
}
?>