<?

?>
<P CLASS=title><?php echo(S_SETUP4_1); ?></P>

<TABLE BORDER=0 WIDTH=500 CELLPADDING=3 CELLSPACING=0 CLASS=table>
<TR>
	<TD>
		<?php echo(S_SETUP4_2); ?>
	</TD>
</TR>
<TR><TD>&nbsp;</TD></TR>
<FORM NAME="HSelect">
<TR>
	<TD ALIGN=CENTER>
		<INPUT TYPE=button VALUE="<?php echo(S_SETUP4_3); ?>" onClick="document.forms['HSelect'].elements['txt'].focus();document.forms['HSelect'].elements['txt'].select();">
	</TD>
</TR>
<TR>
	<TD ALIGN=CENTER>
<TEXTAREA NAME="txt" ROWS=20 COLS=75 WRAP=OFF>
<?php include("./install/preconfig.php3"); ?>
</TEXTAREA>
	<TD>
<TR>
</FORM>
</TABLE>

<P CLASS=whois>
	<?php echo(sprintf(S_SETUP4_4, APP_NAME)); if (!@mail('','','')) echo(S_SETUP4_4m); ?>
</P>
<P CLASS=error>
	<?php echo(sprintf(S_SETUP4_5, APP_NAME)); ?>
</P>
<P><A NAME="warn"></A></P>
<?php

?>