<?php

?>
<P>
	<A HREF="<?php echo($From."?Lang=argentinian_spanish"); ?>"><IMG SRC="localization/argentinian_spanish/flag.gif" BORDER=0 WIDTH=24 HEIGHT=16 ALT="Español para Argentina"></A>&nbsp;&nbsp;&nbsp;
	<A HREF="<?php echo($From."?Lang=czech"); ?>"><IMG SRC="localization/czech/flag.gif" BORDER=0 WIDTH=24 HEIGHT=16 ALT="Czech"></A>&nbsp;&nbsp;&nbsp;
	<A HREF="<?php echo($From."?Lang=english"); ?>"><IMG SRC="localization/english/flag.gif" BORDER=0 WIDTH=24 HEIGHT=16 ALT="English"></A>&nbsp;&nbsp;&nbsp;
	<A HREF="<?php echo($From."?Lang=french"); ?>"><IMG SRC="localization/french/flag.gif" BORDER=0 WIDTH=24 HEIGHT=16 ALT="Français"></A>&nbsp;&nbsp;&nbsp;
	<A HREF="<?php echo($From."?Lang=italian"); ?>"><IMG SRC="localization/italian/flag.gif" BORDER=0 WIDTH=24 HEIGHT=16 ALT="Italiano"></A>&nbsp;&nbsp;&nbsp;
	<A HREF="<?php echo($From."?Lang=spanish"); ?>"><IMG SRC="localization/spanish/flag.gif" BORDER=0 WIDTH=24 HEIGHT=16 ALT="Español"></A>
</P>

<P CLASS=whois>
	<?php echo(sprintf(S_SETUP0_1, APP_NAME)); ?>
</P>
</CENTER>
<OL STYLE="color: #FFFFFF">
	<?php echo(S_SETUP0_2); ?><BR><BR>
	<LI><?php echo(sprintf(S_SETUP0_3, APP_NAME)); ?>
	<BR><BR>
	<LI><?php echo(sprintf(S_SETUP0_4, APP_NAME)); ?>
	<BR><BR>
	<LI><?php echo(S_SETUP0_5); ?>
	<?php
	if (!@mail('','',''))
	{
		?>
		<BR><BR>
		<LI><?php echo(S_SETUP0_5m); ?>
		<?php
	};
	?>
</OL>
<BR>
<CENTER>
<P CLASS="error">
	<?php echo(sprintf(S_SETUP0_8, APP_NAME)); ?>
</P><BR>
<P CLASS=whois>
	<?php echo(S_SETUP0_6); ?>
</P>
<FORM ACTION="<?php echo($From."?Lang=${Lang}"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Params">
	<INPUT TYPE=hidden NAME="next" value="1">
	<INPUT TYPE="submit" VALUE="<?php echo(S_SETUP0_7); ?>">
</FORM>
<?php

?>