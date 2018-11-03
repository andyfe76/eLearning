<?php
require("./config/config.lib.php3");
require("./lib/release.lib.php3");

if (isset($HTTP_GET_VARS["L"])) $L = $HTTP_GET_VARS["L"];
if (!isset($L))
{
	$L = "";
}
// Fix a security hole
else if (!is_dir('./localization/'.$L))
{
	exit();
}
	
if ($L == "" || !file_exists("./localization/${L}/localized.tutorial.php3"))
{
	unset($L);
	include("./localization/tutorial.lib.php3");
};
require("./localization/${L}/localized.tutorial.php3");
?>