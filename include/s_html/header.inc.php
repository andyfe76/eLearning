<?php
	global $db;
	if (isset($_GET['cid'])) {
		$cid = intval($_GET['cid']);
	} else {
		$cid = intval($_POST['cid']);
	}

	if ($cid != 0) {
		$path = $contentManager->getContentPath($cid);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<title><?php echo SITE_NAME; ?> - <?php echo $_SESSION['course_title'];
	if ($cid != 0) {
		$myPath = $path;
		$num_path = count($myPath);
		for ($i =0; $i<$num_path; $i++) {
			echo ' - ';
			echo $myPath[$i]['title'];
		}
	} else if (is_array($_section) ) {
		$num_sections = count($_section);
		for($i = 0; $i < $num_sections; $i++) {
			echo ' - ';
			echo $_section[$i][0];
		}
	}
	?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<base href="<?php echo $_base_href; ?>" />
	<link rel="stylesheet" href="../stylesheet.css" type="text/css" />
	
	<?php

		$css_filename = $_include_path.'../content/'.$_SESSION['course_id'].'/stylesheet.css';
		if ($_SESSION['prefs'][PREF_OVERRIDE] && file_exists($css_filename)) {
			echo '<link rel="stylesheet" href="content/'.$_SESSION['course_id'].'/stylesheet.css" type="text/css" />'."\n";
		} else {
			/* font theme */
			echo '<link rel="stylesheet" href="css/'.$_fonts[$_SESSION['prefs'][PREF_FONT]]['FILE'].'.css" type="text/css" />'."\n";

			/* colour theme */
			echo '<link rel="stylesheet" href="css/'.$_colours[$_SESSION['prefs'][PREF_STYLESHEET]]['FILE'].'.css" type="text/css" />'."\n";
		}
	?>
	<link rel="stylesheet" type="text/css" href="../print.css" media="print" />
	<!-- style type="text/css">
	* {font-size: 8pt}
	</style -->
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />

</head> 
<body bgcolor="#D0D0F5" <?php echo $onload; ?>>
<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F0F0F5">
<tr><td width="100%" align="center">

<table cellpadding="0" cellspacing="0" border="0" bgcolor="white" width="96%" align="center"><tr><td>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="" align="center">
	<TR>
		<TD COLSPAN="5">
			<IMG SRC="../images/spacer.gif" WIDTH="730" HEIGHT="1"></TD>
	</TR>
	<?php require($_include_path.'s_html/user_bar.inc.php'); ?>
	<tr>
		<td align="left" class="mcat2" colspan="4" bgcolor="White">
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" bgcolor="White">
			<TR>
				<TD>
					<IMG SRC="../images/spacer.gif" WIDTH=60 HEIGHT=1></TD>
				<TD>
					<IMG SRC="../images/spacer.gif" WIDTH=28 HEIGHT=1></TD>
				<TD>
					<IMG SRC="../images/spacer.gif" WIDTH=169 HEIGHT=1></TD>
				<TD>
					<IMG SRC="../images/spacer.gif" WIDTH=492 HEIGHT=1></TD>
				<TD width="100%">
					<IMG SRC="../images/spacer.gif"></TD>
			</TR>
			</TABLE>
		
		<?php
		// Check to see if this course has a header defined. If yes, insert it in
		// place of the default course title
		$sql_head="select header from courses where course_id=$_SESSION[course_id]";
		if($result=$db->query($sql_head)){
			while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
				if(strlen($row['HEADER'])>0){
					$custom_head = $row['HEADER'];
					$custom_head = str_replace("CONTENT_DIR", "content/".$_SESSION['course_id'], $custom_head);
				}
			}
		} 
		if(strlen($custom_head)>0){
			echo '<b>'.$custom_head.'</b>';
			/*
			if (!$_SESSION['is_admin'] && !$_SESSION['enroll']) {
				echo ' - ';
				echo '<a href="./enroll.php?course='.$_SESSION[course_id].'">'.$_template['enroll'].'</a>';
			}
			*/
		}else{
			//echo '<b>'.$_SESSION['course_title'];
			/* check if we're enrolled in this course if not implemented yet. will be cached in the future. */
			/*
			if (!$_SESSION['is_admin'] && !$_SESSION['enroll']) {
				echo ' - ';
				echo '<a href="./enroll.php?course='.$_SESSION[course_id].'">'.$_template['enroll'].'</a>';
			}
			*/
			echo '</b>';
		} 
		//echo ' - <a href="bounce.php">'.$_template['exit_course'].'</a>';
		?>
		</td>
	</tr>
	
	</table>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="" id="content">
	<tr><?php
		//echo '<td width="3"><img src="images/clr.gif" width="3" height="3" alt="" /></td>';
		if (($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] == MENU_LEFT) || ($_SESSION['prefs'][PREF_MAIN_MENU] == 0)) {
			echo '<td valign="top" width="100%">';
		} else {
			echo '<td valign="top" width="75%">';
	
		}
		?>
		
		<a name="content"></a>
		
		<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F8FA">
		<tr>
		<td align="left">
			<?php
			echo '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td width="100%" align="right">';
			echo '<input type="button" class="button" id="top" name="print" value="'.$_template['print_this_page'].'" onclick="javascript:void(window.print());">';
			echo '</td></tr></table>';
		
			$cid = intval($_GET['cid']);
		
			if ($_GET['f']) {
				$f = intval($_GET['f']);
				if ($f > 0) {
					print_feedback($f);
				} else {
					/* it's probably an array */
					$f = unserialize(urldecode(stripslashes($_GET['f'])));
					print_feedback($f);
				}
			}
		
			if(ereg('Mozilla' ,$HTTP_USER_AGENT) && ereg('4.', $BROWSER['Version'])){
				$help[]= AT_HELP_NETSCAPE4;
				//print_help($help);
			}

?>
