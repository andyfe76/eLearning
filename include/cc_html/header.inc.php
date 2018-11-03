<?php
	if ($_SESSION['is_guest'] || !$_SESSION['member_id']) {
		exit;
	}

if(ereg("Mozilla" ,$HTTP_USER_AGENT) && ereg("4.", $BROWSER["Version"])){
	$help[]= AT_HELP_NETSCAPE4;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<title><?php echo SITE_NAME; ?></title>
	<base href="<?php echo $_base_href; ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" href="stylesheet.css" type="text/css" />
	
	<link rel="stylesheet" href="<?php echo $_base_href.'css/'.$_colours[$_SESSION['prefs'][PREF_STYLESHEET]]['FILE']; ?>.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_base_href.'css/'.$_fonts[$_SESSION['prefs'][PREF_FONT]]['FILE']; ?>.css" type="text/css" />

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<style type="text/css">
		* {font-size: 8pt}
	</style>

</head>
<body bgcolor="#F0F0F2" <?php echo $onload; ?>>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script language="JavaScript" src="overlib.js" type="text/javascript"><!-- overLIB (c) Erik Bosrup --></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F0F0F5">
<tr><td width="100%" align="center">

<table cellpadding="0" cellspacing="0" border="0" bgcolor="white" width="96%" align="center"><tr><td>

<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
	<TR>
		<TD COLSPAN="3">
			<IMG SRC="images/spacer.gif" WIDTH="730" HEIGHT="1"></TD>
	</TR>
	
	<?php require($_include_path.'html/user_bar.inc.php'); ?>
	
	<tr><td colspan="3" class="row3" height="1"><img src="images/clr.gif" height="1" alt="" width="1" /></td>
	</tr>
</table>

<table border="0" cellspacing="2" cellpadding="3" width="100%" summary="">
<TR>
	<TD colspan="2">
		<IMG SRC="images/spacer.gif" WIDTH="700" HEIGHT="1"></TD>
</TR>
	
<tr>
	<td valign="top" width="40">
		<img src="images/spacer.gif" width="40" height="1">
	</td>
	
	<td valign="top" align="left"><a name="content"></a>
	<?php 

	if ($_GET['f']) {
		$f = intval($_GET['f']);
		if ($f > 0) {
			print_feedback($f);
		} else {
			/* it's probably an array */
			$f = unserialize(urldecode($_GET['f']));
			print_feedback($f);
		}

	}	
print_feedback($feedback);
print_errors($errors);
print_infos($infos);
?>