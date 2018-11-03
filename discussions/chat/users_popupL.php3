<?php
// Get the names and values for vars sent by the script that called this one
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
$CachePlus = "";
if (ereg("MSIE [56789]", (isset($HTTP_USER_AGENT)) ? $HTTP_USER_AGENT : getenv("HTTP_USER_AGENT"))) $CachePlus = ", pre-check=0, post-check=0, max-age=0";
$now		= gmdate('D, d M Y H:i:s') . ' GMT';

header("Expires: $now");
header("Last-Modified: $now");
header("Cache-Control: no-cache, must-revalidate".$CachePlus);
header("Pragma: no-cache");
header("Content-Type: text/html; charset=${Charset}");

$DbLink = new DB2;


// ** Check for user entrance to beep **
// Initialize some vars if necessary and put beep on/off in a cookie
if (isset($HTTP_COOKIE_VARS["CookieBeep"])) $CookieBeep = $HTTP_COOKIE_VARS["CookieBeep"];
if (!isset($B)) $B = (isset($CookieBeep) ? $CookieBeep : "1");
setcookie("CookieBeep", $B, time() + 60*60*24*365);		// cookie expires in one year
$BeepRoom = "0";
if (!isset($LastCheck) || $B == "0") $LastCheck = time();

if ($B > 0)
{
	$DbLink->query("SELECT m_time FROM ".C_MSG_TBL." WHERE m_time > '$LastCheck' AND username = 'SYS enter' AND type = 1 ORDER BY m_time DESC LIMIT 1");
	if ($DbLink->num_rows() > 0)
	{
		$BeepRoom = "1";
		list($LastCheck) = $DbLink->next_record();
	};
	$DbLink->clean_results();
}

// ** Prepare the http refresh header **
$URL_Query = (isset($QUERY_STRING)) ? $QUERY_STRING : getenv("QUERY_STRING");
if (!ereg("LastCheck", $URL_Query))
{
	$Refresh = $URL_Query."&LastCheck=${LastCheck}&B=${B}";
}
else
{
	$Refresh = ereg_replace("LastCheck=([0-9]+)","LastCheck=".$LastCheck, $URL_Query);
}

// ** Compute the beeps/nobeeps reload query used when the sound icon is clicked **
$B1 =  ($B > 0 ? "0" : "1");
$ChangeBeeps_Reload = ereg_replace("&B=([0-2])","&B=${B1}",$Refresh);

// For translations with an explicit charset (not the 'x-user-defined' one)
if (!isset($FontName)) $FontName = "";
// Text direction
$textDirection = ($Charset == "windows-1256") ? "RTL" : "LTR";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo($textDirection); ?>">

<HEAD>
<?php
function special_char($str,$lang,$type)
{
	$tag_open = (($type == 'a' || $type == 'm') ? "<I>":"");
	$tag_close = ($tag_open != "" ? "</I>":"");
	return $tag_open.($lang ? htmlentities($str) : htmlspecialchars($str)).$tag_close;
}

// ** count rooms **
$DbLink->query("SELECT DISTINCT u.room FROM ".C_USR_TBL." u, ".C_MSG_TBL." m WHERE u.room = m.room AND m.type = 1");
$NbRooms = $DbLink->num_rows();
$DbLink->clean_results();

if ($NbRooms > 0)
{
	// ** count users **
	$DbLink->query("SELECT DISTINCT u.username, u.latin1 FROM ".C_USR_TBL." u, ".C_MSG_TBL." m WHERE u.room = m.room AND m.type = 1 ORDER BY username");
	$NbUsers = $DbLink->num_rows();
	if($NbUsers > 3)
	{
		echo("<TITLE>".$NbUsers." ".($NbUsers > 1 ? L_USERS : L_USER)."/".$NbRooms." ".($NbRooms > 1 ? L_ROOMS : L_ROOM)."</TITLE>");
	}
	else
	{
		echo("<TITLE>");
		$Term = "";
		while(list($Username,$Latin1) = $DbLink->next_record())
		{
			echo($Term.special_char($Username,$Latin1,''));
			$Term = ", ";
		}
		echo("</TITLE>");
	};
	$DbLink->clean_results();
}
else
{
	echo("<TITLE>".L_NO_USER."</TITLE>");
}
?>
<META HTTP-EQUIV="Refresh" CONTENT="30; URL=users_popupL.php3?<?php echo($Refresh); ?>">
<LINK REL="stylesheet" HREF="config/style.css.php3?<?php echo("Charset=${Charset}&medium=${FontSize}&FontName=${FontName}"); ?>" TYPE="text/css">
<style type="text/css">
* {font-size: 8pt}
</style>
</HEAD>

<BODY CLASS="frame" onClick="self.focus();">
<CENTER>
	<A HREF="<?php echo("$From?Ver=L&L=$L"); ?>" TARGET="_blank"><?php echo(L_CHAT); ?></A>
	<P><A HREF="users_popupL.php3?<?php echo($ChangeBeeps_Reload); ?>"><IMG SRC="images/<?php if ($B == "0") echo("no"); ?>sound.gif" WIDTH=13 HEIGHT=13 ALIGN=MIDDLE BORDER=0 ALT="<?php echo(L_BEEP); ?>"></A></P>
</CENTER>
<P>
<?php

// ** Build users list **
if(isset($NbUsers) && $NbUsers > 0)
{
	if($DbLink->query("SELECT DISTINCT room FROM ".C_MSG_TBL." WHERE type = 1 ORDER BY room"))
	{
		if($DbLink->num_rows() > 0)
		{
			$Users = new DB2;
			while(list($Other) = $DbLink->next_record())
			{
				if($Users->query("SELECT username, latin1, status FROM ".C_USR_TBL." WHERE room = '".addslashes($Other)."' ORDER BY username"))
				{
					if($Users->num_rows() > 0)
					{
						echo("<B>".htmlspecialchars($Other)."</B><SPAN CLASS=\"small\"><BDO dir=\"${textDirection}\"></BDO>&nbsp;(".$Users->num_rows().")</SPAN><BR>");
						while(list($Username,$Latin1,$status) = $Users->next_record())
						{
							echo("-&nbsp;".special_char($Username,$Latin1,$status)."<BR>");
						}
					}
				}
				$Users->clean_results();
				echo("</P><P>");
			}
		}
	}
}
else
{
	echo("<CENTER>".L_NO_USER."</CENTER>");
}

$DbLink->close();
?>
</P>

<?php
// ** Beeps if necessary **
if ($B > 0 && $BeepRoom)
{
	?>
	<!-- Sound for user entrance -->
	<EMBED SRC="images/beep.wav" HIDDEN="true" AUTOSTART="true" LOOP="false" NAME="Beep" MASTERSOUND>
		<NOEMBED><BGSOUND SRC="images/beep.wav" LOOP=1></NOEMBED>
	</EMBED>
	<?php
}
?>
</BODY>

</HTML>
<?php

?>