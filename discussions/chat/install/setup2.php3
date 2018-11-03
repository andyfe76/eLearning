<?php
$old_error_reporting = error_reporting (E_ERROR | E_WARNING | E_PARSE); 
require("./config/config.lib.php3");
error_reporting($old_error_reporting); 

$C_MSG_DEL = (isset($C_MSG_DEL) ? $C_MSG_DEL : C_MSG_DEL);
$C_USR_DEL = (isset($C_USR_DEL) ? $C_USR_DEL : C_USR_DEL);
$C_REG_DEL = (isset($C_REG_DEL) ? $C_REG_DEL : C_REG_DEL);
$C_LANGUAGE = (isset($C_LANGUAGE) ? $C_LANGUAGE : C_LANGUAGE);
$R0 = "";
for (reset($DefaultChatRooms); $room=current($DefaultChatRooms); next($DefaultChatRooms))
{
	if ($R0 != "") $R0 .= ",";
	$R0 .= htmlspecialchars($room); 
}
$C_PUB_CHAT_ROOMS = (isset($C_PUB_CHAT_ROOMS) ? htmlspecialchars(stripslashes($C_PUB_CHAT_ROOMS)) : $R0);
$R0 = "";
for (reset($DefaultPrivateRooms); $room=current($DefaultPrivateRooms); next($DefaultPrivateRooms))
{
	if ($R0 != "") $R0 .= ",";
	$R0 .= htmlspecialchars($room); 
}
$C_PRIV_CHAT_ROOMS = (isset($C_PRIV_CHAT_ROOMS) ? htmlspecialchars(stripslashes($C_PRIV_CHAT_ROOMS)) : $R0);
$C_VERSION = (isset($C_VERSION) ? $C_VERSION : C_VERSION);
$C_BANISH = (isset($C_BANISH) ? $C_BANISH : C_BANISH);
$C_SAVE = (isset($C_SAVE) ? $C_SAVE : C_SAVE);
$C_TMZ_OFFSET = (isset($C_TMZ_OFFSET) ? $C_TMZ_OFFSET : C_TMZ_OFFSET);
$C_MSG_NB = (isset($C_MSG_NB) ? $C_MSG_NB : C_MSG_NB);
$C_MSG_REFRESH = (isset($C_MSG_REFRESH) ? $C_MSG_REFRESH : C_MSG_REFRESH);
if (!$Error)
{
	$C_MULTI_LANG = C_MULTI_LANG;
	$C_REQUIRE_REGISTER = C_REQUIRE_REGISTER;
	$C_EMAIL_PASWD = C_EMAIL_PASWD;
	$C_SHOW_ADMIN = C_SHOW_ADMIN;
	$C_SHOW_DEL_PROF = C_SHOW_DEL_PROF;
	$C_MSG_ORDER = C_MSG_ORDER;
	$C_SHOW_TIMESTAMP = C_SHOW_TIMESTAMP;
	$C_USE_SMILIES = C_USE_SMILIES;
	$C_HTML_TAGS_KEEP = (C_HTML_TAGS_KEEP == "simple");
	$C_HTML_TAGS_SHOW = C_HTML_TAGS_SHOW;
	$C_NO_SWEAR = C_NO_SWEAR;
	$C_NOTIFY = C_NOTIFY;
	$C_WELCOME = C_WELCOME;
}
?>

<P CLASS=title><?php echo(S_SETUP2_1); ?></P>

<FORM ACTION="<?php echo($From."?Lang=${Lang}"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Params">
<INPUT TYPE=hidden NAME="Form_Send" VALUE="2">
<INPUT TYPE=hidden NAME="C_DB_TYPE" VALUE="<?php echo($C_DB_TYPE); ?>">
<INPUT TYPE=hidden NAME="C_DB_HOST" VALUE="<?php echo(stripslashes($C_DB_HOST)); ?>">
<INPUT TYPE=hidden NAME="C_DB_NAME" VALUE="<?php echo(stripslashes($C_DB_NAME)); ?>">
<INPUT TYPE=hidden NAME="C_DB_USER" VALUE="<?php echo(stripslashes($C_DB_USER)); ?>">
<INPUT TYPE=hidden NAME="C_DB_PASS" VALUE="<?php echo(stripslashes($C_DB_PASS)); ?>">
<INPUT TYPE=hidden NAME="C_MSG_TBL" VALUE="<?php echo(stripslashes($C_MSG_TBL)); ?>">
<INPUT TYPE=hidden NAME="C_REG_TBL" VALUE="<?php echo(stripslashes($C_REG_TBL)); ?>">
<INPUT TYPE=hidden NAME="C_USR_TBL" VALUE="<?php echo(stripslashes($C_USR_TBL)); ?>">
<INPUT TYPE=hidden NAME="C_BAN_TBL" VALUE="<?php echo(stripslashes($C_BAN_TBL)); ?>">

<TABLE BORDER=0 CELLPADDING=3 CLASS=table>
<TR>
	<TD ALIGN=CENTER>

		<TABLE WIDTH=500 BORDER=0>
		<TR>
			<TH COLSPAN=2 CLASS=tabtitle><?php echo(S_SETUP2_2); ?></TH>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=MIDDLE NOWRAP>
				<?php echo(S_SETUP2_3); ?>&nbsp;
			</TD>
			<TD VALIGN=MIDDLE WIDTH=110 NOWRAP>
				<INPUT TYPE=text NAME="C_MSG_DEL" SIZE=3 MAXLENGTH=4 VALUE="<?php echo($C_MSG_DEL); ?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=MIDDLE NOWRAP>
				<?php echo(S_SETUP2_4); ?>&nbsp;
			</TD>
			<TD VALIGN=MIDDLE NOWRAP>
				<INPUT TYPE=text NAME="C_USR_DEL" SIZE=3 MAXLENGTH=4 VALUE="<?php echo($C_USR_DEL); ?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=MIDDLE NOWRAP>
				<?php echo(S_SETUP2_5); ?>&nbsp;
			</TD>
			<TD VALIGN=BOTTOM NOWRAP>
				<INPUT TYPE=text NAME="C_REG_DEL" SIZE=3 MAXLENGTH=4 VALUE="<?php echo($C_REG_DEL); ?>">
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		</TABLE>

		<TABLE WIDTH=500 BORDER=0>
		<TR>
			<TH COLSPAN=2 CLASS=tabtitle><?php echo(S_SETUP2_6); ?></TH>
		</TR>
		<TR ALIGN=CENTER>
			<TD ALIGN=RIGHT NOWRAP><?php echo(S_SETUP2_46); ?>&nbsp;</TD>
			<TD>
				<INPUT TYPE=text NAME="C_PUB_CHAT_ROOMS" SIZE=50 MAXLENGTH=128 VALUE="<?php echo($C_PUB_CHAT_ROOMS); ?>">
			</TD>
		</TR>
		<TR ALIGN=CENTER>
			<TD ALIGN=RIGHT NOWRAP><?php echo(S_SETUP2_47); ?>&nbsp;</TD>
			<TD>
				<INPUT TYPE=text NAME="C_PRIV_CHAT_ROOMS" SIZE=50 MAXLENGTH=128 VALUE="<?php echo($C_PRIV_CHAT_ROOMS); ?>">
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=2 ALIGN=CENTER VALIGN=MIDDLE NOWRAP><?php echo(S_SETUP2_7); ?></TD>
		</TR>
		<TR><TD COLSPAN=2>&nbsp;</TD></TR>
		</TABLE>

		<TABLE WIDTH=500 BORDER=0>
		<TR>
			<TH CLASS=tabtitle><?php echo(S_SETUP2_8); ?></TH>
		</TR>
		<TR>
			<TD ALIGN=CENTER VALIGN=TOP>
				<INPUT TYPE="checkbox" NAME="C_MULTI_LANG" VALUE="1" 
				<?php if ($C_MULTI_LANG) echo("CHECKED"); ?>> <?php echo(S_SETUP2_9); ?>
			</TD>
		</TR>
		<TR>
			<TD ALIGN=CENTER NOWRAP>
				<?php echo(S_SETUP2_10); ?> 
				<SELECT NAME="C_LANGUAGE">
					<?php
					asort($AvailableLanguages);
					reset($AvailableLanguages);
					while(list($key, $name) = each($AvailableLanguages))
					{
						echo("<OPTION VALUE=\"${name}\"");
						if ($C_LANGUAGE == $name) echo(" SELECTED");
						echo(">".ucfirst(str_replace("_"," ",$name))."</OPTION>");
					}
					?>
				</SELECT>
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		</TABLE>

		<TABLE WIDTH=500 BORDER=0>
		<TR>
			<TH COLSPAN=2 CLASS=tabtitle><?php echo(S_SETUP2_43); ?></TH>
		</TR>
		<TR>
			<TD COLSPAN=2>
				<TABLE WIDTH=100% BORDER=0>
				<TR>
					<TD>
						<INPUT TYPE="checkbox" NAME="C_REQUIRE_REGISTER" VALUE="1" 
						<?php if ($C_REQUIRE_REGISTER) echo("CHECKED"); ?>> 
					</TD>
					<TD>
						<?php echo(S_SETUP2_14); ?>
					</TD>
				</TR>
				<?php
				if (@mail('','',''))
				{
					?>
					<TR>
						<TD VALIGN=TOP>
							<INPUT TYPE="checkbox" NAME="C_EMAIL_PASWD" VALUE="1"
							<?php if ($C_EMAIL_PASWD) echo("CHECKED"); ?>> 
						</TD>
						<TD>
							<?php echo(S_SETUP2_44); ?>
						</TD>
					</TR>
					<?php
				}
				else
				{
					?>
					<TR>
						<TD VALIGN=TOP>&nbsp;</TD>
						<TD>
							<?php echo(S_SETUP2_45); ?>
						</TD>
					</TR>
					<?php
				};
				?>
				</TABLE>
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		</TABLE>

		<TABLE WIDTH=500 BORDER=0>
		<TR>
			<TH COLSPAN=2 CLASS=tabtitle><?php echo(S_SETUP2_11); ?></TH>
		</TR>
		<TR>
			<TD COLSPAN=2 VALIGN=TOP>
				<INPUT TYPE="checkbox" NAME="C_SHOW_ADMIN" VALUE="1"
				<?php if ($C_SHOW_ADMIN) echo("CHECKED"); ?>> <?php echo(S_SETUP2_12); ?>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=2 VALIGN=TOP>
				<INPUT TYPE="checkbox" NAME="C_SHOW_DEL_PROF" VALUE="1"
				<?php if ($C_SHOW_DEL_PROF) echo("CHECKED"); ?>> <?php echo(S_SETUP2_13); ?>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=2 VALIGN=TOP NOWRAP>
				<BR><?php echo(S_SETUP2_15); ?><BR>
				&nbsp;&nbsp;<INPUT TYPE="radio" NAME="C_VERSION" VALUE="0" <?php if ($C_VERSION == "0") echo("CHECKED"); ?>> <?php echo(S_SETUP2_16); ?><BR>
				&nbsp;&nbsp;<INPUT TYPE="radio" NAME="C_VERSION" VALUE="1" <?php if ($C_VERSION == "1") echo("CHECKED"); ?>>	<?php echo(S_SETUP2_17); ?><BR>
				&nbsp;&nbsp;<INPUT TYPE="radio" NAME="C_VERSION" VALUE="2" <?php if ($C_VERSION == "2") echo("CHECKED"); ?>>	<?php echo(S_SETUP2_18); ?>
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR>
			<TD VALIGN=MIDDLE>
				<?php echo(S_SETUP2_42); ?>&nbsp;
			</TD>
			<TD VALIGN=BOTTOM WIDTH=70>
				<INPUT TYPE=text NAME="C_BANISH" SIZE=5 MAXLENGTH=11 VALUE="<?php echo($C_BANISH); ?>">
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=2 VALIGN=TOP><BR>
				<INPUT TYPE="checkbox" NAME="C_NO_SWEAR" VALUE="1"
				<?php if ($C_NO_SWEAR) echo("CHECKED"); ?>> <?php echo(S_SETUP2_36); ?>
			</TD>
		</TR>
		<TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR>
			<TD VALIGN=MIDDLE>
				<?php echo(S_SETUP2_41); ?>&nbsp;
			</TD>
			<TD VALIGN=BOTTOM WIDTH=70>
				<INPUT TYPE=text NAME="C_SAVE" SIZE=2 MAXLENGTH=2 VALUE="<?php echo($C_SAVE); ?>">
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		</TABLE>

		<TABLE WIDTH=500 BORDER=0>
		<TR>
			<TH CLASS=tabtitle><?php echo(S_SETUP2_19); ?></TH>
		</TR>
		<TR>
			<TD VALIGN=TOP>
				<INPUT TYPE="checkbox" NAME="C_USE_SMILIES" VALUE="1"
				<?php if ($C_USE_SMILIES) echo("CHECKED"); ?>> <?php echo(S_SETUP2_20); ?>
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP>
				<INPUT TYPE="checkbox" NAME="C_HTML_TAGS_KEEP" VALUE="simple"
				<?php if ($C_HTML_TAGS_KEEP) echo("CHECKED"); ?>> <?php echo(S_SETUP2_21); ?>
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP>
				<INPUT TYPE="checkbox" NAME="C_HTML_TAGS_SHOW" VALUE="1"
				<?php if ($C_HTML_TAGS_SHOW) echo("CHECKED"); ?>> <?php echo(S_SETUP2_22); ?>
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		</TABLE>

		<TABLE WIDTH=500 BORDER=0>
		<TR>
			<TH CLASS=tabtitle COLSPAN=2><?php echo(S_SETUP2_23); ?></TH>
		</TR>
		<TR>
			<TD VALIGN=TOP COLSPAN=2 NOWRAP>
				<?php echo(S_SETUP2_24); ?>&nbsp;
				<INPUT TYPE=text NAME="C_TMZ_OFFSET" SIZE=3 MAXLENGTH=3 VALUE="<?php echo($C_TMZ_OFFSET); ?>">
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP COLSPAN=2 NOWRAP>
				<?php echo(S_SETUP2_25); ?>&nbsp;<BR>
				&nbsp;&nbsp;<INPUT TYPE="radio" NAME="C_MSG_ORDER" VALUE="0" <?php if ($C_MSG_ORDER== "0") echo("CHECKED"); ?>> <?php echo(S_SETUP2_26); ?><BR>
				&nbsp;&nbsp;<INPUT TYPE="radio" NAME="C_MSG_ORDER" VALUE="1" <?php if ($C_MSG_ORDER== "1") echo("CHECKED"); ?>> <?php echo(S_SETUP2_27); ?>
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP COLSPAN=2 NOWRAP>
				<?php echo(S_SETUP2_28); ?>&nbsp;
				<INPUT TYPE=text NAME="C_MSG_NB" SIZE=3 MAXLENGTH=3 VALUE="<?php echo($C_MSG_NB); ?>">
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP COLSPAN=2 NOWRAP>
				<?php echo(S_SETUP2_29); ?>&nbsp;
				<INPUT TYPE=text NAME="C_MSG_REFRESH" SIZE=3 MAXLENGTH=3 VALUE="<?php echo($C_MSG_REFRESH); ?>">
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP COLSPAN=2>
				<INPUT TYPE="checkbox" NAME="C_SHOW_TIMESTAMP" VALUE="1"
				<?php if ($C_SHOW_TIMESTAMP) echo("CHECKED"); ?>> <?php echo(S_SETUP2_30); ?>
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP COLSPAN=2>
				<INPUT TYPE="checkbox" NAME="C_NOTIFY" VALUE="1"
				<?php if ($C_NOTIFY) echo("CHECKED"); ?>> <?php echo(S_SETUP2_31); ?>
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP>
				<INPUT TYPE="checkbox" NAME="C_WELCOME" VALUE="1"<?php if ($C_WELCOME) echo( "CHECKED"); ?>>
			</TD>
			<TD>
			 	<?php echo(S_SETUP2_48); ?>
			</TD>
		</TR>

		<TR><TD>&nbsp;</TD></TR>
		</TABLE>
		<P>
		<INPUT TYPE="submit" VALUE="<?php echo(S_SETUP1_19); ?>">
	</TD>
</TR>
</TABLE>
<?php

?>