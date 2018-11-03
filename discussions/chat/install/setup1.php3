<?php
require("./config/config.lib.php3");

$C_DB_TYPE = (isset($C_DB_TYPE) ? $C_DB_TYPE : C_DB_TYPE);
$C_DB_HOST = (isset($C_DB_HOST) ? htmlspecialchars(stripslashes($C_DB_HOST)) : C_DB_HOST);
$C_DB_NAME = (isset($C_DB_NAME) ? htmlspecialchars(stripslashes($C_DB_NAME)) : C_DB_NAME);
$C_DB_USER = (isset($C_DB_USER) ? htmlspecialchars(stripslashes($C_DB_USER)) : C_DB_USER);
if (!isset($Create)) $Create = 3;
$C_MSG_TBL = (isset($C_MSG_TBL) ? htmlspecialchars(stripslashes($C_MSG_TBL)) : C_MSG_TBL);
$C_REG_TBL = (isset($C_REG_TBL) ? htmlspecialchars(stripslashes($C_REG_TBL)) : C_REG_TBL);
$C_USR_TBL = (isset($C_USR_TBL) ? htmlspecialchars(stripslashes($C_USR_TBL)) : C_USR_TBL);
$C_BAN_TBL = (isset($C_BAN_TBL) ? htmlspecialchars(stripslashes($C_BAN_TBL)) : C_BAN_TBL);
?>

<P CLASS=title><?php echo(S_SETUP1_1); ?></P>

<FORM ACTION="<?php echo($From."?Lang=${Lang}"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Params">
<INPUT type=hidden name="Form_Send" value="1">
<TABLE BORDER=0 CELLPADDING=3 CLASS=table>
<TR>
	<TD ALIGN=CENTER>
		<TABLE BORDER=0>
		<TR>
			<TH COLSPAN=2 CLASS=tabtitle><?php echo(S_SETUP1_2); ?></TH>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP1_3); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE="radio" NAME="C_DB_TYPE" VALUE="mysql" <?php if ($C_DB_TYPE == "mysql") echo("CHECKED"); ?>> MySQL<BR>
				<INPUT TYPE="radio" NAME="C_DB_TYPE" VALUE="pgsql" <?php if ($C_DB_TYPE == "pgsql") echo("CHECKED"); ?>> PostgreSQL<BR>
				<INPUT TYPE="radio" NAME="C_DB_TYPE" VALUE="odbc" <?php if ($C_DB_TYPE == "odbc") echo("CHECKED"); ?> DISABLED> ODBC
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP1_4); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="C_DB_HOST" SIZE=11 MAXLENGTH=30 VALUE="<?php echo($C_DB_HOST); ?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP1_5); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="C_DB_NAME" SIZE=11 MAXLENGTH=30 VALUE="<?php echo($C_DB_NAME); ?>">
				&nbsp;<?php echo(S_SETUP1_6); ?>
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP1_7); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="C_DB_USER" SIZE=11 MAXLENGTH=30 VALUE="<?php echo($C_DB_USER); ?>">
			</TD>
		</TR>
		<TR>
			<TD ALIGN=RIGHT VALIGN=TOP NOWRAP><?php echo(S_SETUP1_8); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=password NAME="C_DB_PASS" SIZE=11 MAXLENGTH=30>
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR>
			<TH COLSPAN=2 CLASS=tabtitle><?php echo(S_SETUP1_9); ?></TH>
		<TR>
		<TR>
			<TD ALIGN=LEFT COLSPAN=2 NOWRAP><?php echo(S_SETUP1_10); ?><TD>
		</TR>
		<TR>
			<TD ALIGN=LEFT VALIGN=TOP COLSPAN=2 NOWRAP>
				&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="Create" VALUE="3" <?php if ($Create == 3) echo("CHECKED"); ?>> <?php echo(sprintf(S_SETUP1_11, APP_NAME)); ?><BR>
				&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="Create" VALUE="2" <?php if ($Create == 2) echo("CHECKED"); ?>> <?php echo(S_SETUP1_12); ?><BR>
				&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="Create" VALUE="1" <?php if ($Create == 1) echo("CHECKED"); ?>> <?php echo(S_SETUP1_20); ?><BR>
				&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="Create" VALUE="0" <?php if ($Create == 0) echo("CHECKED"); ?>> <?php echo(S_SETUP1_13); ?><BR>
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR>
			<TH COLSPAN=2><?php echo(S_SETUP1_14); ?><TH>
		</TR>
		</TABLE>
		<TABLE BORDER=0>
		<TR>
			<TD VALIGN=TOP NOWRAP>&nbsp;&nbsp;-&nbsp;<?php echo(S_SETUP1_15); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="C_MSG_TBL" SIZE=11 MAXLENGTH=16 VALUE="<?php echo($C_MSG_TBL); ?>">
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP NOWRAP>&nbsp;&nbsp;-&nbsp;<?php echo(S_SETUP1_16); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="C_REG_TBL" SIZE=11 MAXLENGTH=16 VALUE="<?php echo($C_REG_TBL); ?>">
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP NOWRAP>&nbsp;&nbsp;-&nbsp;<?php echo(S_SETUP1_17); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="C_USR_TBL" SIZE=11 MAXLENGTH=16 VALUE="<?php echo($C_USR_TBL); ?>">
			</TD>
		</TR>
		<TR>
			<TD VALIGN=TOP NOWRAP>&nbsp;&nbsp;-&nbsp;<?php echo(S_SETUP1_21); ?></TD>
			<TD VALIGN=TOP>
				<INPUT TYPE=text NAME="C_BAN_TBL" SIZE=11 MAXLENGTH=16 VALUE="<?php echo($C_BAN_TBL); ?>">
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=2 CLASS=small>
				<FONT COLOR="#000000"><?php echo(S_SETUP1_18); ?></FONT>
			<TD>
		</TR>
		</TABLE>
		<P>
		<INPUT TYPE="submit" VALUE="<?php echo(S_SETUP1_19); ?>">
	</TD>
</TR>
</TABLE>
<?php

?>