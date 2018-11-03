<?php
	if ($_SESSION['is_guest'] || !$_SESSION['member_id']) {
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<title><?php echo SITE_NAME; ?> - <?php echo $_template['administration']; ?></title>
	<base href="<?php echo $_base_href; ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" href="stylesheet.css" type="text/css" />
	<!--link rel="stylesheet" href="<?php echo $stylesheet; ?>" type="text/css" /-->
	<!--link rel="stylesheet" href="<?php echo $font; ?>" type="text/css" /-->
	<style type="text/css">
		* {font-size: 8pt}
	</style>
</head>
<body <?php echo $onload; ?>><table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr>
	<td colspan="2" class="topbar" valign="middle">
	<b><?php echo SITE_NAME; ?>
<?php echo $_template['administration']; ?></b> <?php
	if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 2) {
		echo '<a href="users/index.php" title="'.$_template['logout'].'" target="_top"><img src="images/logout.gif" border="0" height="14" width="15" alt="'.$_template['logout'].'" class="menuimage" /></a>';
	}
	if ($_SESSION['prefs'][PREF_LOGIN_ICONS] != 1) {
		echo ' <a href="users/index.php">'.$_template['logout'].'</a>';
	}
	?>
	</td>
</tr>
<tr><td colspan="2" class="row3" height="1"><img src="images/clr.gif" height="1" width="1"></td></tr>
</table>
<table border="0" cellspacing="2" cellpadding="3" width="100%" summary="">
<tr>
	<td class="bodyline" valign="top" width="140"><a name="navigation"></a>
	* <a href="users/admin/"><?php echo $_template['home']; ?></a><br />
	* <a href="users/admin/users.php"><?php echo $_template['users']; ?></a><br />
	* <a href="users/admin/courses.php"><?php echo $_template['courses']; ?></a><br />
	* <a href="users/index.php"><?php echo $_template['logout']; ?></a><br />
	</td>
<td valign="top"><a name="content"></a>
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
?>
