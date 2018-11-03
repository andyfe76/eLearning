<?php
require("./lib/release.lib.php3");
if (!isset($Lang) && isset($HTTP_GET_VARS["Lang"])) $Lang = $HTTP_GET_VARS["Lang"];
require("./install/languages/languages.setup.php3");
require("./install/languages/${Lang}.setup.php3");

// Special cache instructions for IE5+
$CachePlus	= "";
if (ereg("MSIE [56789]", (isset($HTTP_USER_AGENT)) ? $HTTP_USER_AGENT : getenv("HTTP_USER_AGENT"))) $CachePlus = ", pre-check=0, post-check=0, max-age=0";
$now		= gmdate('D, d M Y H:i:s') . ' GMT';

header("Expires: $now");
header("Last-Modified: $now");
header("Cache-Control: no-cache, must-revalidate".$CachePlus);
header("Pragma: no-cache");
header("Content-Type: text/html; charset=${S_Charset}");

// Get the names and values for post vars
if (isset($HTTP_POST_VARS))
{
	while(list($name,$value) = each($HTTP_POST_VARS))
	{
		$$name = $value;
	};
};

if (!isset($Form_Send)) $Form_Send = 0;

if ($Form_Send == 1)
{
	$old_error_reporting = error_reporting (E_ERROR | E_WARNING | E_PARSE); 
	include("./localization/languages.lib.php3");
	error_reporting($old_error_reporting); 

	$Error = (trim($C_DB_NAME) == "" || trim($C_MSG_TBL) == "" || trim($C_REG_TBL) == "" || trim($C_USR_TBL) == "" || trim($C_BAN_TBL) == "");

	if (!$Error && (trim($C_DB_USER) == "" || trim($C_DB_PASS) == ""))
	{
		if (trim($C_DB_HOST) != "" && trim($C_DB_HOST) != "localhost" && trim($C_DB_HOST) != "127.0.0.1")
		{
			$Error = true;
		}
		else
		{
			$Val1 = urlencode(htmlspecialchars(stripslashes($C_DB_HOST)));
			$Val2 = urlencode(htmlspecialchars(stripslashes($C_DB_NAME)));
			$Val3 = urlencode(htmlspecialchars(stripslashes($C_DB_USER)));
			$Val4 = urlencode(htmlspecialchars(stripslashes($C_MSG_TBL)));
			$Val5 = urlencode(htmlspecialchars(stripslashes($C_REG_TBL)));
			$Val6 = urlencode(htmlspecialchars(stripslashes($C_USR_TBL)));
			$Val7 = urlencode(htmlspecialchars(stripslashes($C_BAN_TBL)));
			$Qs = "C_DB_TYPE=${C_DB_TYPE}";
			if ($Val1 != "") $Qs .= "&C_DB_HOST=${Val1}";
			$Qs .= "&C_DB_NAME=${Val2}";
			if ($Val3 != "") $Qs .= "&C_DB_USER=${Val3}";
			$Qs .= "&Create=${Create}&C_MSG_TBL=${Val4}&C_REG_TBL=${Val5}&C_USR_TBL=${Val6}&C_BAN_TBL=${Val7}";
			$Qs .= "&next=1";
			if (!isset($PHP_SELF)) $PHP_SELF = $HTTP_SERVER_VARS["PHP_SELF"];
			$From = basename($PHP_SELF);
			$url = $From."?Lang=$Lang&".$Qs;

			$jsTbl[] = "<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\">";
			$jsTbl[] = "<!--";
			$jsTbl[] = "msgconf = \"".S_MAIN_1."\";";
			$jsTbl[] = "if (!confirm(msgconf)) window.location = \"$url\";";
			$jsTbl[] = "// -->";
			$jsTbl[] = "</SCRIPT>";
		}
	}

	if (!$Error)
	{
		define("C_DB_TYPE", "${C_DB_TYPE}");
		define("C_DB_HOST", "${C_DB_HOST}");
		define("C_DB_NAME", "${C_DB_NAME}");
		define("C_DB_USER", "${C_DB_USER}");
		define("C_DB_PASS", "${C_DB_PASS}");

		if ($Create != 0) 
		{
			include("./lib/database/${C_DB_TYPE}.lib.php3");
			include("./install/database/${C_DB_TYPE}.dump.php3");

			$DbLink = new DB2;
			switch ($Create)
			{
				case '1':
					$Todo = $Upd2_Tab;
					break;
				case '2':
					$Todo = $Upd_Tab;
					break;
				case '3':
					$Todo = $Create_Tab;
			};
			for (reset($Todo); $query=current($Todo); next($Todo))
			{
				$DbLink->query($query);
			};
			if ($Create != 3 && C_DB_TYPE == "mysql")
			{
				$DbLink->optimize($C_MSG_TBL);
				$DbLink->optimize($C_USR_TBL);
				$DbLink->optimize($C_REG_TBL);
				$DbLink->optimize($C_BAN_TBL);
			};
			$DbLink->close();
			$ErrorMsg = S_MAIN_2;
		}
		else
		{
			$ErrorMsg = S_MAIN_3;
		}

		$next = 2;
	}
	else
	{
		$ErrorMsg = S_MAIN_4;
		$next = 1;
	}
}

if ($Form_Send == 2)
{
	$Error = true;
	if (trim($C_MSG_DEL) == "" || trim($C_USR_DEL) == "" || trim($C_REG_DEL) == "")
	{
		$ErrorMsg = S_MAIN_5;
	}
	elseif (trim($C_PUB_CHAT_ROOMS) == "")
	{
		$ErrorMsg = S_MAIN_6;
	}
	elseif (ereg("[\]", stripslashes($C_PUB_CHAT_ROOMS)) || ereg("[\]", stripslashes($C_PRIV_CHAT_ROOMS)))
	{
		$ErrorMsg = S_MAIN_7;
	}
	elseif (trim($C_TMZ_OFFSET) == "")
	{
		$ErrorMsg = S_MAIN_8;
	}
	elseif (trim($C_MSG_NB) == "" || trim($C_MSG_REFRESH) == "")
	{
		$ErrorMsg = S_MAIN_9;
	}
	else
	{
		if (!isset($C_MULTI_LANG)) $C_MULTI_LANG = 0;
		if (!isset($C_REQUIRE_REGISTER)) $C_REQUIRE_REGISTER = 0;
		if (!isset($C_EMAIL_PASWD)) $C_EMAIL_PASWD = 0;
		if (!isset($C_SHOW_ADMIN)) $C_SHOW_ADMIN = 0;
		if (!isset($C_SHOW_DEL_PROF)) $C_SHOW_DEL_PROF = 0;
		if (!isset($C_MSG_ORDER)) $C_MSG_ORDER = 0;
		if (!isset($C_SHOW_TIMESTAMP)) $C_SHOW_TIMESTAMP = 0;
		if (!isset($C_USE_SMILIES)) $C_USE_SMILIES = 0;
		if (!isset($C_HTML_TAGS_KEEP)) $C_HTML_TAGS_KEEP = "none";
		if (!isset($C_HTML_TAGS_SHOW)) $C_HTML_TAGS_SHOW = 0;
		if (!isset($C_BANISH) || $C_BANISH == "") $C_BANISH = 0;
		if (!isset($C_NO_SWEAR)) $C_NO_SWEAR = 0;
		if (trim($C_SAVE) == "") $C_SAVE = "*";
		if (!isset($C_NOTIFY)) $C_NOTIFY = 0;
		if (!isset($C_WELCOME)) $C_WELCOME = 0;

		$Error = false;
		$next = 3;
		$ErrorMsg = S_MAIN_11;
	}
	
	if ($Error)
	{
		$next = 2;
		$old_error_reporting = error_reporting (E_ERROR | E_WARNING | E_PARSE); 
		include("./localization/languages.lib.php3");
		error_reporting($old_error_reporting); 
	}
}

if ($Form_Send == 3)
{
	if ($submit_type != S_SETUP3_12)
	{	
		$Error = true;
		if (trim($ADM_LOG) == "")
		{
			$ErrorMsg = S_MAIN_12;
		}
		elseif (ereg("[\, ]", stripslashes($ADM_LOG)))
		{
			$ErrorMsg = S_MAIN_13;
		}
		elseif ($ADM_PASS == "")
		{
			$ErrorMsg = S_MAIN_14;
		}
		else
		{
			if (!isset($SHOWEMAIL)) $SHOWEMAIL = 0;
			$Error = false;
		}
	}
	else
	{
		$Error = false;

	}

	if (!$Error && $submit_type != S_SETUP3_12)
	{	
		define("C_DB_TYPE", "${C_DB_TYPE}");
		define("C_DB_HOST", "${C_DB_HOST}");
		define("C_DB_NAME", "${C_DB_NAME}");
		define("C_DB_USER", "${C_DB_USER}");
		define("C_DB_PASS", "${C_DB_PASS}");
		$admin_pwd = md5(stripslashes($ADM_PASS));

		include("./lib/database/${C_DB_TYPE}.lib.php3");

		$DbLink = new DB2;
		$DbLink->query("SELECT password FROM ${C_REG_TBL} WHERE username = '${ADM_LOG}' AND perms != 'admin' LIMIT 1");
		if ($DbLink->num_rows() > 0)
		{
			list($Old_password) = $DbLink->next_record();
			$DbLink->clean_results();
			if ($Old_password != $admin_pwd)
			{
				$Error = true;
				$ErrorMsg = sprintf(S_MAIN_15, $ADM_LOG);
				$next = 3;
			}
			else
			{
				if ($Exist_Adm) $DbLink->query("DELETE FROM ${C_REG_TBL} WHERE perms='admin'");
				$DbLink->query("UPDATE ${C_REG_TBL} SET perms='admin' WHERE username='${ADM_LOG}'");
				$Exist_Adm = true;
			}
		}
		else
		{
			$DbLink->clean_results();
		}
		$DbLink->close();

		if (!$Error)
		{
			if (!isset($ADM_GENDER)) $ADM_GENDER = "";
			include("./lib/get_IP.lib.php3");		// Set the $IP var
			if (!$Exist_Adm)
			{
				include("./install/database/${C_DB_TYPE}.dump.php3");
				$Adm_Query = $Create_Adm;
			}
			else
			{
				$Adm_Query = "UPDATE ${C_REG_TBL} SET username='${ADM_LOG}', password='${admin_pwd}', firstname='${ADM_FNAME}', lastname='${ADM_LNAME}', country='${ADM_LANG}', website='${ADM_WEB}', email='${ADM_EMAIL}', showemail=${SHOWEMAIL}, reg_time=".time().", ip='${IP}', gender='${ADM_GENDER}' WHERE perms='admin'";
			}

			$DbLink = new DB2;
			$DbLink->query($Adm_Query);
			$DbLink->close();

			$ErrorMsg = S_MAIN_16;
			$next = 4;
		}
	}
	elseif (!$Error)
	{
		$ErrorMsg = S_MAIN_17;
		$next = 4;
	}		
	else
	{
		$next = 3;
	}
}

if (!isset($next)) $next = 0;

// For translations with an explicit charset (not the 'x-user-defined' one)
if (!isset($S_FontName)) $S_FontName = "";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo(($Charset == "windows-1256") ? "RTL" : "LTR"); ?>">

<HEAD>
<TITLE><?php echo(APP_NAME." ".APP_VERSION." ".S_MAIN_18); ?></TITLE>
<LINK REL="stylesheet" HREF="config/style.css.php3?<?php echo("Charset=${S_Charset}&medium=${S_FontSize}&FontName=${S_FontName}"); ?>" TYPE="text/css">
<style type="text/css">
* {font-size: 8pt}
</style>
<?php
if (isset($jsTbl))
{
	for (reset($jsTbl); $jsInst=current($jsTbl); next($jsTbl))
	{
		echo("$jsInst\n");
	};
	unset($jsTbl);
};
?>
</HEAD>

<BODY STYLE="background-color: #666699">
<CENTER>

<?php
if (!isset($PHP_SELF)) $PHP_SELF = $HTTP_SERVER_VARS["PHP_SELF"];
$From = basename($PHP_SELF);

$TagClass = ((isset($Error) && $Error) ? "error" : "whois"); 
if (isset($ErrorMsg) && $ErrorMsg) echo("<P CLASS=${TagClass}>$ErrorMsg</P>");

include("./install/setup${next}.php3");

?>
</CENTER>
</BODY>

</HTML>