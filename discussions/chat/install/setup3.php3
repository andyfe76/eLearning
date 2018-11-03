<?php
//Check for an admin yet defined in db.
define("C_DB_TYPE", "${C_DB_TYPE}");
define("C_DB_HOST", "${C_DB_HOST}");
define("C_DB_NAME", "${C_DB_NAME}");
define("C_DB_USER", "${C_DB_USER}");
define("C_DB_PASS", "${C_DB_PASS}");
include("./lib/database/${C_DB_TYPE}.lib.php3");

$Exist_Adm = false;
$DbLink = new DB2;
$DbLink->query("SELECT username,password,firstname,lastname,country,website,email,showemail,gender FROM ${C_REG_TBL} WHERE perms='admin' LIMIT 1");
if ($DbLink->num_rows() != 0)
{
	list($ADM_LOG,$ADM_PASS,$ADM_FNAME, $ADM_LNAME, $ADM_LANG, $ADM_WEB, $ADM_EMAIL, $SHOWEMAIL, $ADM_GENDER) = $DbLink->next_record();
	$Msg = S_SETUP3_1;
	$Exist_Adm = true;
}
else
{
	$ADM_LOG = "";
	$ADM_PASS = "";
	$ADM_FNAME = "";
	$ADM_LNAME = "";
	$ADM_LANG = "";
	$ADM_WEB = "";
	$ADM_EMAIL = "";
	$SHOWEMAIL = "";
	$ADM_GENDER = "";
};

$DbLink->clean_results();
$DbLink->close();
?>

<P CLASS=title><?php echo(S_SETUP3_2); ?></P>

<?php
if (isset($Msg)) echo("<P CLASS=whois>${Msg}</P>");
?>
	
<FORM ACTION="<?php echo($From."?Lang=${Lang}"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Params">
<INPUT type=hidden name="Form_Send" value="3">
<INPUT type=hidden name="Exist_Adm" value="<?php echo($Exist_Adm); ?>">

<INPUT TYPE=hidden NAME="C_DB_TYPE" VALUE="<?php echo($C_DB_TYPE); ?>">
<INPUT TYPE=hidden NAME="C_DB_HOST" VALUE="<?php echo(stripslashes($C_DB_HOST)); ?>">
<INPUT TYPE=hidden NAME="C_DB_NAME" VALUE="<?php echo(stripslashes($C_DB_NAME)); ?>">
<INPUT TYPE=hidden NAME="C_DB_USER" VALUE="<?php echo(stripslashes($C_DB_USER)); ?>">
<INPUT TYPE=hidden NAME="C_DB_PASS" VALUE="<?php echo(stripslashes($C_DB_PASS)); ?>">
<INPUT TYPE=hidden NAME="C_MSG_TBL" VALUE="<?php echo(stripslashes($C_MSG_TBL)); ?>">
<INPUT TYPE=hidden NAME="C_REG_TBL" VALUE="<?php echo(stripslashes($C_REG_TBL)); ?>">
<INPUT TYPE=hidden NAME="C_USR_TBL" VALUE="<?php echo(stripslashes($C_USR_TBL)); ?>">
<INPUT TYPE=hidden NAME="C_BAN_TBL" VALUE="<?php echo(stripslashes($C_BAN_TBL)); ?>">
<INPUT TYPE=hidden NAME="C_MSG_DEL" VALUE="<?php echo($C_MSG_DEL); ?>">
<INPUT TYPE=hidden NAME="C_USR_DEL" VALUE="<?php echo($C_USR_DEL); ?>">
<INPUT TYPE=hidden NAME="C_REG_DEL" VALUE="<?php echo($C_REG_DEL); ?>">
<INPUT TYPE=hidden NAME="C_LANGUAGE" VALUE="<?php echo($C_LANGUAGE); ?>">
<INPUT TYPE=hidden NAME="C_MULTI_LANG" VALUE="<?php echo($C_MULTI_LANG); ?>">
<INPUT TYPE=hidden NAME="C_REQUIRE_REGISTER" VALUE="<?php echo($C_REQUIRE_REGISTER); ?>">
<INPUT TYPE=hidden NAME="C_EMAIL_PASWD" VALUE="<?php echo($C_EMAIL_PASWD); ?>">
<INPUT TYPE=hidden NAME="C_SHOW_ADMIN" VALUE="<?php echo($C_SHOW_ADMIN); ?>">
<INPUT TYPE=hidden NAME="C_SHOW_DEL_PROF" VALUE="<?php echo($C_SHOW_DEL_PROF); ?>">
<INPUT TYPE=hidden NAME="C_TMZ_OFFSET" VALUE="<?php echo($C_TMZ_OFFSET); ?>">
<INPUT TYPE=hidden NAME="C_MSG_ORDER" VALUE="<?php echo($C_MSG_ORDER); ?>">
<INPUT TYPE=hidden NAME="C_MSG_NB" VALUE="<?php echo($C_MSG_NB); ?>">
<INPUT TYPE=hidden NAME="C_MSG_REFRESH" VALUE="<?php echo($C_MSG_REFRESH); ?>">
<INPUT TYPE=hidden NAME="C_SHOW_TIMESTAMP" VALUE="<?php echo($C_SHOW_TIMESTAMP); ?>">
<INPUT TYPE=hidden NAME="C_USE_SMILIES" VALUE="<?php echo($C_USE_SMILIES); ?>">
<INPUT TYPE=hidden NAME="C_HTML_TAGS_KEEP" VALUE="<?php echo($C_HTML_TAGS_KEEP); ?>">
<INPUT TYPE=hidden NAME="C_HTML_TAGS_SHOW" VALUE="<?php echo($C_HTML_TAGS_SHOW); ?>">
<INPUT TYPE=hidden NAME="C_PUB_CHAT_ROOMS" VALUE="<?php echo(htmlspecialchars(stripslashes($C_PUB_CHAT_ROOMS))); ?>">
<INPUT TYPE=hidden NAME="C_PRIV_CHAT_ROOMS" VALUE="<?php echo(htmlspecialchars(stripslashes($C_PRIV_CHAT_ROOMS))); ?>">
<INPUT TYPE=hidden NAME="C_VERSION" VALUE="<?php echo($C_VERSION); ?>">
<INPUT TYPE=hidden NAME="C_BANISH" VALUE="<?php echo($C_BANISH); ?>">
<INPUT TYPE=hidden NAME="C_NO_SWEAR" VALUE="<?php echo($C_NO_SWEAR); ?>">
<INPUT TYPE=hidden NAME="C_SAVE" VALUE="<?php echo($C_SAVE); ?>">
<INPUT TYPE=hidden NAME="C_NOTIFY" VALUE="<?php echo($C_NOTIFY); ?>">
<INPUT TYPE=hidden NAME="C_WELCOME" VALUE="<?php echo($C_WELCOME); ?>">

<TABLE BORDER=0 CELLPADDING=3 CLASS=table>
<TR>
	<TD ALIGN=CENTER>
		<TABLE BORDER=0>
		<TR>
			<TH COLSPAN=2><?php echo(S_SETUP3_3); ?></TH>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_4); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="ADM_LOG" SIZE=11 MAXLENGTH=10 VALUE="<?echo(htmlspecialchars(stripslashes($ADM_LOG)))?>">
				<SPAN CLASS=error>*</SPAN>
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_5); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=password NAME="ADM_PASS" SIZE=11 MAXLENGTH=16>
				<SPAN CLASS=error>*</SPAN>
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_6); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="ADM_FNAME" SIZE=11 MAXLENGTH=64 VALUE="<?echo(htmlspecialchars(stripslashes($ADM_FNAME)))?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_7); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="ADM_LNAME" SIZE=11 MAXLENGTH=64 VALUE="<?echo(htmlspecialchars(stripslashes($ADM_LNAME)))?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_14); ?> :</TD>
			<TD VALIGN=TOP>
				<INPUT TYPE="radio" NAME="ADM_GENDER" VALUE="1" <?php if ($ADM_GENDER == "1") echo("CHECKED"); ?>>&nbsp;<?php echo(S_SETUP3_15); ?><BR>
				<INPUT TYPE="radio" NAME="ADM_GENDER" VALUE="2" <?php if ($ADM_GENDER == "2") echo("CHECKED"); ?>>&nbsp;<?php echo(S_SETUP3_16); ?>
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_8); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="ADM_LANG" SIZE=11 MAXLENGTH=64 VALUE="<?echo(htmlspecialchars(stripslashes($ADM_LANG)))?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_9); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="ADM_WEB" SIZE=11 MAXLENGTH=64 VALUE="<?echo(htmlspecialchars(stripslashes($ADM_WEB)))?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP3_10); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="ADM_EMAIL" SIZE=11 MAXLENGTH=64 VALUE="<?echo(htmlspecialchars(stripslashes($ADM_EMAIL)))?>">
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR>
			<TD COLSPAN=2 ALIGN=center>
				<INPUT type=checkbox name="SHOWEMAIL" value="1" <?if($SHOWEMAIL) echo("checked")?>>
				&nbsp;<?php echo(S_SETUP3_11); ?>
			</TD>
		</TR>
		</TABLE>
		<P>
		<INPUT TYPE="submit" NAME="submit_type" VALUE="<?php echo(S_SETUP1_19); ?>">
		&nbsp;
		<INPUT TYPE="submit" NAME="submit_type" VALUE="<?php echo(S_SETUP3_12); ?>">
	</TD>
</TR>
</TABLE>

<P CLASS=whois>
	<?php echo(sprintf(S_SETUP3_13, APP_NAME)); ?>
<P> 
<?php

?>