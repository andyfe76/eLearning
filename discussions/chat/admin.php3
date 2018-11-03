<?php
// Get the names and values for vars sent to the admin script
if (isset($HTTP_GET_VARS))
{
	while(list($name,$value) = each($HTTP_GET_VARS))
	{
		$$name = $value;
	};
};

// Get the names and values for post vars
if (isset($HTTP_POST_VARS))
{
	while(list($name,$value) = each($HTTP_POST_VARS))
	{
		$$name = $value;
	};
};

// Fix a security hole
if (isset($L) && !is_dir('./localization/'.$L)) exit();
	
// avoid server configuration for magic quotes
set_magic_quotes_runtime(0);

// Var used in the login.lib.php3 script required bellow
$MUST_BE_ADMIN = true;
if (isset($user)) $AUTH_USERNAME = $user;
if (isset($pswd)) $AUTH_PASSWORD = $pswd;

require("./config/config.lib.php3");
require("./lib/release.lib.php3");
require("./lib/database/".C_DB_TYPE.".lib.php3");

// Check for administration language file
if (!isset($What) || $What == "")
{ 
	if (!isset($L)) include("./localization/languages.lib.php3");
	include("./localization/${L}/localized.chat.php3");
	if (!file_exists("./localization/${L}/localized.admin.php3"))
	{
		unset($L);
		$Charset_Sav = $Charset;
		$FontName_Sav = (isset($FontName) ? $FontName : "");
		$FontSize_Sav = $FontSize;
		include("./localization/admin.lib.php3");
	};
};
require("./localization/${L}/localized.admin.php3");
if (isset($Charset_Sav))
{
	$Charset = $Charset_Sav; unset($Charset_Sav);
	$FontName = $FontName_Sav; unset($FontName_Sav);
	$FontSize = $FontSize_Sav; unset($FontSize_Sav);
};

// Login stuff
require("./lib/login.lib.php3");

// Special cache instructions for IE5+
$CachePlus	= "";
if (ereg("MSIE [56789]", (isset($HTTP_USER_AGENT)) ? $HTTP_USER_AGENT : getenv("HTTP_USER_AGENT"))) $CachePlus = ", pre-check=0, post-check=0, max-age=0";
// Do not cache this page
$now		= gmdate('D, d M Y H:i:s') . ' GMT';
header("Expires: $now");
header("Last-Modified: $now");
header("Cache-Control: no-cache, must-revalidate".$CachePlus);
header("Pragma: no-cache");

// Define charset
header("Content-Type: text/html; charset=${Charset}");

// ** Load the frame when the $what var indicate one
if (isset($What) && $What != "") include("./admin/admin".$What.".php3");


// ** Define url query **

// Get the name of the current script;
if (!isset($PHP_SELF)) $PHP_SELF = $HTTP_SERVER_VARS["PHP_SELF"];
$From = basename($PHP_SELF);

// Define the sheet to open
if (!isset($sheet)) $sheet = "1";
$ToOpen = "admin".$sheet.".php3";

// Set username of the admin to a convenient format
$AUTH_USERNAME = urlencode(htmlspecialchars(stripslashes($AUTH_USERNAME)));

// Define URL queries to be sent to frames
$URLQueryTop = "From=$From&What=Top&L=$L&user=$AUTH_USERNAME&pswd=$PWD_Hash&sheet=$sheet";
$Add2Body = (isset($First) ? "" : "&First=1");
$Add2Body .= (isset($sortBy) ? "&sortBy=$sortBy" : "&sortBy=username").(isset($sortOrder) ? "&sortOrder=$sortOrder" : "&sortOrder=DESC");
$Add2Body .= (isset($startReg) ? "&startReg=$startReg" : "");
$Add2Body .= (isset($ReqVar) ? "&ReqVar=$ReqVar" : "");
$URLQueryBody = "From=$From&What=Body&L=$L&user=$AUTH_USERNAME&pswd=$PWD_Hash&sheet=$sheet".$Add2Body;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo(($Charset == "windows-1256") ? "RTL" : "LTR"); ?>">

<HEAD>
<TITLE><?php echo(APP_NAME); ?></TITLE>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript1.2">
<!--
// Define the URL for the fix for NN4+ resize bug
if (document.layers)
{
	var NNResize_URL = "<?php echo("$From?L=$L&user=".urlencode($AUTH_USERNAME)."&pswd=$PWD_Hash&sheet=$sheet"); ?>";
	var sortBy = "<?php echo(isset($sortBy) ? "&sortBy=$sortBy" : ""); ?>";
	var sortOrder = "<?php echo(isset($sortOrder) ? "&sortOrder=$sortOrder" : ""); ?>";
	var startReg = "<?php echo((isset($startReg) && $startReg != "") ? "&startReg=$startReg" : ""); ?>";
};
// -->
</SCRIPT>
</HEAD>

<FRAMESET ROWS="50,*" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" OnResize="if (document.layers) document.location = NNResize_URL + sortBy + sortOrder">
	<FRAME SRC="<?php echo("$From?$URLQueryTop"); ?>" NAME="adminTop" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH="3" MARGINHEIGHT="3" SCROLLING="NO">
	<FRAME SRC="<?php echo("$From?$URLQueryBody"); ?>" NAME="adminBody" FRAMEBORDER="0" BORDER="0" FRAMESPACING="0" MARGINWIDTH=0 MARGINHEIGHT=0 NORESIZE>
</FRAMESET>

</HTML>