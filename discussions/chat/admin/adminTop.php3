<?php
// Remove some var from the url query
$URLQueryTop = "L=$L&user=".urlencode($user)."&pswd=$pswd";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo(($Charset == "windows-1256") ? "RTL" : "LTR"); ?>">

<HEAD>
<TITLE> </TITLE>
<LINK REL="stylesheet" HREF="config/admin.css.php3?<?php echo("Charset=${Charset}&medium=${FontSize}&FontName=${FontName}"); ?>" TYPE="text/css">
<style type="text/css">
* {font-size: 8pt}
</style>
</HEAD>

<BODY>
<TABLE ALIGN=RIGHT BORDER=0 CELLPADDING=3 CELLSPACING=0 CLASS="menu">
<TR>
	<TD ALIGN=LEFT VALIGN=bottom NOWRAP CLASS="menuTitle">
		<IMG SRC="images/selColor.gif" WIDTH=5><?php echo(sprintf(A_MENU_0,APP_NAME)."\n"); ?>
	</TD>
	<TD ALIGN=LEFT VALIGN=bottom WIDTH=1500 CLASS="menuTitle">
		<IMG SRC="images/selColor.gif" WIDTH=5>
	</TD>
	<TD ALIGN=CENTER NOWRAP CLASS="thumbIndex">
		&nbsp;<A HREF="<?php echo("$From?$URLQueryTop&sheet=1"); ?>" TARGET="_parent"<?php if ($sheet == "1") echo(" CLASS=\"selected\""); ?>><?php echo(A_MENU_1); ?></A>&nbsp;
	</TD>
	<TD WIDTH=1><IMG SRC="images/selColor.gif" WIDTH=1></TD>
	<TD ALIGN=CENTER NOWRAP CLASS="thumbIndex">
		&nbsp;<A HREF="<?php echo("$From?$URLQueryTop&sheet=2"); ?>" TARGET="_parent"<?php if ($sheet == "2") echo(" CLASS=\"selected\""); ?>><?php echo(A_MENU_2); ?></A>&nbsp;
	</TD>
	<TD WIDTH=1><IMG SRC="images/selColor.gif" WIDTH=1></TD>
	<TD ALIGN=CENTER NOWRAP CLASS="thumbIndex">
		&nbsp;<A HREF="<?php echo("$From?$URLQueryTop&sheet=3"); ?>" TARGET="_parent"<?php if ($sheet == "3") echo(" CLASS=\"selected\""); ?>><?php echo(A_MENU_3); ?></A>&nbsp;
	</TD>
	<?php
	include('./admin/mail4admin.lib.php3');
	if ($MailFunctionOn)
	{
		$ReqVar = ($Completed ? "" : "&ReqVar=1");
		?>
		<TD WIDTH=1><IMG SRC="images/selColor.gif" WIDTH=1></TD>
		<TD ALIGN=CENTER NOWRAP CLASS="thumbIndex">
			&nbsp;<A HREF="<?php echo("$From?$URLQueryTop&sheet=4".$ReqVar); ?>" TARGET="_parent"<?php if ($sheet == "4") echo(" CLASS=\"selected\""); ?>><?php echo(A_MENU_4); ?></A>&nbsp;
		</TD>
		<?php
	};
	?>
	<TD WIDTH=2>
		<IMG SRC="images/selColor.gif" WIDTH=2>
	</TD>
</TR>
</TABLE>
</P>

</BODY>
</HTML>
<?php
exit();
?>