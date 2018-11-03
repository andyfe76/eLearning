<?php
// Get the names and values for vars sent to this script
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
header("Content-Type: text/html; charset=".$Charset);

// Text direction
$textDirection = ($Charset == "windows-1256") ? "RTL" : "LTR";

// For translations with an explicit charset (not the 'x-user-defined' one)
if (!isset($FontName)) $FontName = "";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo($textDirection); ?>">

<HEAD>
<TITLE><?php echo(APP_NAME); ?></TITLE>
<?php
echo('<meta HTTP-EQUIV="Refresh" CONTENT="30; URL=usersL.php3?' . ((isset($QUERY_STRING)) ? $QUERY_STRING : getenv('QUERY_STRING')) . '">');
?>
<LINK REL="stylesheet" HREF="config/style.css.php3?<?php echo("Charset=${Charset}&medium=${FontSize}&FontName=${FontName}"); ?>" TYPE="text/css">
<style type="text/css">
* {font-size: 8pt}
</style>
</HEAD>

<BODY CLASS="frame">
<P>
<?php
// Special formats depending on users status
function special_char($str,$lang,$type)
{
	$tag_open = (($type == 'a' || $type == 'm') ? "<I>":"");
	$tag_close = ($tag_open != "" ? "</I>":"");
	return $tag_open.($lang ? htmlentities($str) : htmlspecialchars($str)).$tag_close;
}

// Used inside javascript links 
function special_char2($str,$lang)
{
	return ($lang ? htmlentities(addslashes($str)) : htmlspecialchars(addslashes($str)));
}

$ImgNum = "0";

$DbLink = new DB2;

//** Display users list for the current room **
if (C_DB_TYPE == 'mysql')
{
	$currentRoomQuery	= 'SELECT usr.username, usr.latin1, usr.status, reg.gender '
						. 'FROM ' . C_USR_TBL . ' usr LEFT JOIN ' . C_REG_TBL . ' reg ON usr.username = reg.username '
						. 'WHERE usr.room = \'' . $R . '\' '
						. 'ORDER BY username';
}
else if (C_DB_TYPE == 'pgsql')
{
	$currentRoomQuery	= 'SELECT usr.username, usr.latin1, usr.status, reg.gender '
						. 'FROM ' . C_USR_TBL . ' usr, ' . C_REG_TBL . ' reg '
						. 'WHERE usr.room = \'' . $R . '\' AND usr.username = reg.username '
						. 'UNION '
						. 'SELECT usr.username, usr.latin1, usr.status, NULL AS gender '
						. 'FROM ' . C_USR_TBL . ' usr '
						. 'WHERE usr.username NOT IN (SELECT reg.username FROM ' . C_REG_TBL . ' reg) AND usr.room = \'' . $R . '\' '
						. 'ORDER BY username';
}
else
{
	$currentRoomQuery	= 'SELECT usr.username, usr.latin1, usr.status, NULL AS gender '
						. 'FROM ' . C_USR_TBL . ' usr '
						. 'WHERE usr.room = \'' . $R . '\' '
						. 'ORDER BY username';
}

$DbLink->query($currentRoomQuery);
echo("<B>".htmlspecialchars(stripslashes($R))."</B><SPAN CLASS=\"small\"><BDO dir=\"${textDirection}\"></BDO>&nbsp;(".$DbLink->num_rows().")</SPAN><BR>\n");
while(list($User, $Latin1, $status, $gender) = $DbLink->next_record())
{
	// Put an icon when there is a profile for the user
	if($gender == 0)
		$gender = 'undefined';
	elseif($gender == 1)
		$gender = 'boy';
	elseif($gender == 2)
		$gender = 'girl';
	else
		$gender = 'none';
	if ($status != "u" && $status != "k" && $status != "d" && $status != "b")
	{
		$Cmd2Send = ($User == stripslashes($U) ? "'PROFILE',''" : "'WHOIS','".special_char2($User,$Latin1)."'");
		echo('<a href="#" onClick="window.parent.runCmd('.$Cmd2Send.'); return false;" class="user"><img src="images/gender_'.$gender.'.gif" width="14" height="14" border="0" alt="'.L_PROFILE.'"></a>&nbsp;');
	}
	else
	{
		echo('<img src="images/gender_none.gif" width="14" height="14" border="0" alt="' . L_NO_PROFILE . '">&nbsp;');
	};
	if($User != $U)
	{
		echo("<A HREF=\"javascript:window.parent.userClick('".special_char2($User,$Latin1)."',false);\" CLASS=\"user\">".special_char($User,$Latin1,$status)."</A><BR>\n");
	}
	else
	{
		echo(special_char($User,$Latin1,$status)."<BR>\n");
	};
}
$DbLink->clean_results();
?>
</P>
<P>
<?php

//** Display users list for other rooms **
$AddPwd2Link = (isset($PWD_Hash) && $PWD_Hash != "") ? "&PWD_Hash=$PWD_Hash" : "";
$DbLink->query("SELECT DISTINCT room FROM ".C_MSG_TBL." WHERE room != '$R' AND type = 1 ORDER BY room");
if($DbLink->num_rows() > 0)
{
	$OthersUsers = new DB2;
	while(list($Other) = $DbLink->next_record())
	{
		if (C_DB_TYPE == 'mysql')
		{
			$otherRoomsQuery	= 'SELECT usr.username, usr.latin1, usr.status, reg.gender '
								. 'FROM ' . C_USR_TBL . ' usr LEFT JOIN ' . C_REG_TBL . ' reg ON usr.username = reg.username '
								. 'WHERE usr.room = \'' . addslashes($Other) . '\' '
								. 'ORDER BY username';
		}
		else if (C_DB_TYPE == 'pgsql')
		{
			$otherRoomsQuery	= 'SELECT usr.username, usr.latin1, usr.status, reg.gender '
								. 'FROM ' . C_USR_TBL . ' usr, ' . C_REG_TBL . ' reg '
								. 'WHERE usr.room = \'' . addslashes($Other) . '\' AND usr.username = reg.username '
								. 'UNION '
								. 'SELECT usr.username, usr.latin1, usr.status, NULL AS gender '
								. 'FROM ' . C_USR_TBL . ' usr '
								. 'WHERE usr.username NOT IN (SELECT reg.username FROM ' . C_REG_TBL . ' reg) AND usr.room = \'' . addslashes($Other) . '\' '
								. 'ORDER BY username';
		}
		else
		{
			$otherRoomsQuery	= 'SELECT usr.username, usr.latin1, usr.status, NULL AS gender '
								. 'FROM ' . C_USR_TBL . ' usr '
								. 'WHERE usr.room = \'' . addslashes($Other) . '\' '
								. 'ORDER BY username';
		}

		$OthersUsers->query($otherRoomsQuery);
		if($OthersUsers->num_rows() > 0)
		{
			$notEmptyRooms[$Other] = 1;
			echo("<A HREF=\"$From?Ver=L&L=$L&U=".urlencode(stripslashes($U))."$AddPwd2Link&R1=".urlencode($Other)."&T=1&D=$D&N=$N&E=".urlencode(stripslashes($R))."&EN=$T\" TARGET=\"_parent\">".htmlspecialchars($Other)."</A><SPAN CLASS=\"small\"><BDO dir=\"${textDirection}\"></BDO>&nbsp;(".$OthersUsers->num_rows().")</SPAN><BR>\n");
			while(list($OtherUser, $Latin1, $status, $gender) = $OthersUsers->next_record())
			{
				// Put an icon when there is a profile for the user
				if($gender == 0)
					$gender = 'undefined';
				elseif($gender == 1)
					$gender = 'boy';
				elseif($gender == 2)
					$gender = 'girl';
				else
					$gender = 'none';
				if ($status != "u" && $status != "k" && $status != "d" && $status != "b")
				{
					echo('<a href="#" onClick="window.parent.runCmd(\'WHOIS\',\''.special_char2($OtherUser,$Latin1).'\'); return false;" class="user"><img src="images/gender_'.$gender.'.gif" width="14" height="14" border="0" alt="'.L_PROFILE.'"></a>&nbsp;');
				}
				else
				{
					echo('<img src="images/gender_none.gif" width="14" height="14" border="0" alt="' . L_NO_PROFILE . '">&nbsp;');
				};
				echo("<A HREF=\"javascript:window.parent.userClick('".special_char2($OtherUser,$Latin1)."',false);\" CLASS=\"user\">".special_char($OtherUser,$Latin1,$status)."</A><BR>\n");
			}
			echo("</P><P>");
		}
		$OthersUsers->clean_results();
	}
}
$DbLink->clean_results();
$DbLink->close();


// Display all rest default rooms
for($k = 0; $k < count($DefaultChatRooms); $k++)
{
	$tmpRoom = stripslashes($DefaultChatRooms[$k]);

	// Display this room name when it hadn't been displayed yet
	if (strcasecmp($tmpRoom, stripslashes($R)) != 0 && (!isset($notEmptyRooms) || !isset($notEmptyRooms[$tmpRoom])))
	{
		echo("<A HREF=\"$From?Ver=L&L=$L&U=".urlencode(stripslashes($U))."$AddPwd2Link&R0=".urlencode($tmpRoom)."&T=1&D=$D&N=$N&E=".urlencode(stripslashes($R))."&EN=$T\" TARGET=\"_parent\">".htmlspecialchars($tmpRoom)."</A><SPAN CLASS=\"small\"><BDO dir=\"${textDirection}\"></BDO>&nbsp;(0)</SPAN><BR>\n");
    };
};

?>
</P>
</BODY>

</HTML>
<?php

?>