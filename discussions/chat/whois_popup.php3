<?php
// Get the names and values for vars sent by input.php3
if (isset($HTTP_GET_VARS))
{
	while(list($name,$value) = each($HTTP_GET_VARS))
	{
		$$name = $value;
	};
};

// Fix a security hole
if (isset($L) && !is_dir('./localization/'.$L)) exit();
	
require("./config/config.lib.php3");
require("./localization/".$L."/localized.chat.php3");
require("./lib/release.lib.php3");
require("./lib/database/".C_DB_TYPE.".lib.php3");
require("./lib/clean.lib.php3");

// Special cache instructions for IE5+
$CachePlus	= "";
if (ereg("MSIE [56789]", (isset($HTTP_USER_AGENT)) ? $HTTP_USER_AGENT : getenv("HTTP_USER_AGENT"))) $CachePlus = ", pre-check=0, post-check=0, max-age=0";
$now		= gmdate('D, d M Y H:i:s') . ' GMT';

header("Expires: $now");
header("Last-Modified: $now");
header("Cache-Control: no-cache, must-revalidate".$CachePlus);
header("Pragma: no-cache");
header("Content-Type: text/html; charset=${Charset}");

$Latin1 = ($Charset == "iso-8859-1");
function special_char($str,$lang)
{
	return ($lang ? htmlentities($str) : htmlspecialchars($str));
};

// For translations with an explicit charset (not the 'x-user-defined' one)
if (!isset($FontName)) $FontName = "";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo(($Charset == "windows-1256") ? "RTL" : "LTR"); ?>">

<HEAD>
<TITLE><?php echo(special_char(stripslashes($U),$Latin1)); ?></TITLE>
<LINK REL="stylesheet" HREF="config/style.css.php3?<?php echo("Charset=${Charset}&medium=${FontSize}&FontName=${FontName}"); ?>" TYPE="text/css">
<style type="text/css">
* {font-size: 8pt}
</style>
<SCRIPT TYPE="text/javascript" LANGUAGE="javascript1.1">
<!--
// Put the focus at the message box in the input frame
function put_focus()
{
	if (typeof(window.opener.window) == 'undefined'
		|| typeof(window.opener.window.document) != 'object')
		return;
	if (window.opener.window.document.title == "Hidden Input frame")
		targetFrame = window.opener.window.parent.frames['input'].window;
	else
		targetFrame = window.opener.window;

	with (targetFrame)
	{
		focus();
		if (document.forms['MsgForm'] && document.forms['MsgForm'].elements['M'])
			document.forms['MsgForm'].elements['M'].focus();
	};
};
// -->
</SCRIPT>
</HEAD>

<BODY CLASS="frame" onUnload="if (window.opener && !window.opener.closed) put_focus();">
<CENTER>

<?php
$DbLink = new DB2;
$DbLink->query("SELECT latin1,firstname,lastname,country,website,email,showemail,perms,rooms,ip,gender FROM ".C_REG_TBL." WHERE username='$U' LIMIT 1");
list($Latin1,$firstname,$lastname,$country,$website,$email,$showemail,$perms,$rooms,$ip,$gender) = $DbLink->next_record();
$DbLink->clean_results();
$DbLink->close();

// ** Get the status of the users
$tag_open = "<I>";
$tag_close = "</I>";
switch ($perms)
{
	case "moderator":
		$roomsTab = explode(",",$rooms);
		for (reset($roomsTab); $room_name=current($roomsTab); next($roomsTab))
		{
			if (strcasecmp(stripslashes($R), $room_name) == 0)
			{
				$perms = L_WHOIS_MODER;
				$Found = 1;
				break;
			};
		};
		unset($roomsTab);
		if (!isset($Found))
		{
			$perms = L_WHOIS_USER;
			$tag_open = "";
			$tag_close = "";
		}
		break;
	case "admin":
		$perms = L_WHOIS_ADMIN;
		if ($power == "medium") $power = "weak";
		break;
	default:
		$perms = L_WHOIS_USER;
		$tag_open = "";
		$tag_close = "";
}
?>
<P CLASS="title"><?php echo($tag_open.special_char(stripslashes($U),$Latin1).$tag_close); ?></P>
<P></P>
<TABLE BORDER=0>
<TR>
	<TD CLASS="whois" nowrap><?php echo(L_REG_30); ?>: </TD>
	<TD CLASS="whois" nowrap><?php echo(special_char($firstname,$Latin1)); ?></TD>
</TR>
<TR>
	<TD CLASS="whois" nowrap><?php echo(L_REG_31); ?>: </TD>
	<TD CLASS="whois" nowrap><?php echo(special_char($lastname,$Latin1)); ?></TD>
</TR>
<?php
if ($gender != "0")
{
	$gender = ($gender == "1" ? L_REG_46 : L_REG_47);
	?>
	<TD CLASS="whois" nowrap><?php echo(L_REG_45); ?>: </TD>
	<TD CLASS="whois" nowrap><?php echo($gender); ?></TD>
	<?php
};

if ($country)
{
	?>
	<TR>
		<TD CLASS="whois" nowrap><?php echo(L_REG_36); ?>: </TD>
		<TD CLASS="whois" nowrap><?php echo(special_char($country,$Latin1)); ?></TD>
	</TR>
	<?php
};

if ($showemail || $power != "weak")
{
	?>
	<TR>
		<TD CLASS="whois" nowrap>e-mail: </TD>
		<TD nowrap><A HREF="mailto:<?php echo(htmlspecialchars($email)); ?>"><?php echo(htmlspecialchars($email)); ?></A></TD>
	</TR>
	<?php
};

if ($website)
{
	$prefix = (strpos($website,"://") ? "" : "http://");
	?>
	<TR>
		<TD CLASS="whois" nowrap><?php echo(L_REG_32); ?>: </TD>
		<TD nowrap><A HREF="<?php echo($prefix.htmlspecialchars(str_replace("javascript:", "", $website))); ?>" TARGET="_blank"><?php echo($prefix.htmlspecialchars($website)); ?></A></TD>
	</TR>
	<?
};

if ($power != "weak")
{
	if (substr($ip, 0, 1) == "p") $ip = substr($ip, 1)." (proxy)";
	?>
	<TR>
		<TD CLASS="whois" nowrap>IP: </TD>
		<TD CLASS="whois" nowrap><?php echo($ip); ?></TD>
	</TR>
	<?php
};
?>
</TABLE>
<BR>
<SPAN CLASS="whois"><?php echo("> ${tag_open}${perms}${tag_close} <"); ?></SPAN>

</CENTER>
</BODY>

</HTML>
<?php

?>