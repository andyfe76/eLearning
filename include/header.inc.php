<?php

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
	<link rel="stylesheet" href="stylesheet.css" type="text/css" />
	
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
	<link rel="stylesheet" type="text/css" href="print.css" media="print" />
	<!-- style type="text/css">
	* {font-size: 8pt}
	</style -->
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

</head> 
<body bgcolor="#D0D0F5" <?php echo $onload; ?>>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script language="JavaScript" src="overlib.js" type="text/javascript"><!-- overLIB (c) Erik Bosrup --></script>
<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F0F0F5">
<tr><td width="100%" align="center">

<table cellpadding="0" cellspacing="0" border="0" bgcolor="white" width="96%" align="center"><tr><td>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="" align="center">
	<TR>
		<TD COLSPAN="5">
			<IMG SRC="images/spacer.gif" WIDTH="730" HEIGHT="1"></TD>
	</TR>
	<?php require($_include_path.'html/user_bar.inc.php'); ?>
	<tr>
		<td colspan="5" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td>
	</tr>
	<tr>
		<td align="left" class="mcat2" colspan="4" bgcolor="White">
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" bgcolor="White">
			<TR>
				<TD>
					<IMG SRC="images/spacer.gif" WIDTH=60 HEIGHT=1></TD>
				<TD>
					<IMG SRC="images/spacer.gif" WIDTH=28 HEIGHT=1></TD>
				<TD>
					<IMG SRC="images/spacer.gif" WIDTH=169 HEIGHT=1></TD>
				<TD>
					<IMG SRC="images/spacer.gif" WIDTH=492 HEIGHT=1></TD>
				<TD width="100%">
					<IMG SRC="images/spacer.gif"></TD>
			</TR>
			<TR>
				<TD COLSPAN=3>
					<IMG SRC="images/course/c_title_03.jpg" WIDTH=257 HEIGHT=33></TD>
				<TD COLSPAN=2>
					<IMG SRC="images/spacer.gif" WIDTH=511 HEIGHT=33></TD>
			</TR>
			<TR>
				<TD>
					<IMG SRC="images/course/c_title_06.jpg"></TD>
				<TD COLSPAN="2" background="images/course/c_title_green.jpg" width="300" align="left">
				<TABLE cellpadding="0" cellspacing="0" border="0" width="300" align="left">
					<TR>
						<TD width="28"><IMG SRC="images/course/c_title_start.jpg"></TD>
						<TD align="left"><font color="FFFFFF"><?php echo '<b>'.$_SESSION['course_title']; ?></font</TD>
					</TR></TABLE>
				</TD>
				<TD background="images/course/c_title_grey.jpg" width="100%" align="center" valign="top">
				<TABLE cellpadding="0" cellspacing="0" border="0" align="right">
				<tr>
					<?php
					/* home */
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 2) {
						echo '<td><a href="./index.php?g=14" accesskey="1" title="'.$_template['home'].' ALT-1"><img src="images/course/c_home.jpg" class="menuimage" border="0" alt="'.$_template['home'].'" /></a></td>'."\n";
					}
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 1) {
						echo '<td> <b><a class="noline" href="./index.php?g=14" accesskey="1" title="Accesskey ALT=1">'.$_template['home'].'</a></b></td>'."\n";
					}
		
					/* tools */
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 2) {
						echo '<td><a href="tools/?g=15" accesskey="2" title="'.$_template['tools'].' ALT-2"><img src="images/course/c_tools.jpg" class="menuimage" border="0" alt="'.$_template['tools'].'" /></a></td>'."\n";
					}
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 1) {
						echo '<td> <b><a class="noline" href="tools/?g=15" accesskey="2" title="'.$_template['accesskey'].' ALT-2">'.$_template['tools'].'</a></b></td>'."\n";
					}
		
					/* resources */
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 2) {
						echo '<td><a href="resources/?g=16" accesskey="3" title="'.$_template['resources'].' ALT-3"><img src="images/course/c_resources.jpg" class="menuimage" border="0" alt="'.$_template['resources'].'" /></a></td>';
					}
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 1) {
						echo '<td> <b><a class="noline" href="resources/?g=16" accesskey="3" title="'.$_template['accesskey'].' ALT-3">'.$_template['resources'].'</a><b></td>'."\n";
					}
		
					/* discussions */
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 2) {
						echo '<td><a href="discussions/?g=17" accesskey="4" title="'.$_template['discussions'].'ALT-4"><img src="images/course/c_discussions.jpg" class="menuimage" border="0" alt="'.$_template['discussions'].'" /></a></td>';
					}
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 1) {
						echo '<td> <b><a class="noline" href="discussions/?g=17" accesskey="4" title="'.$_template['accesskey'].' ALT-4">'.$_template['discussions'].'</a></b></td>'."\n";
					}
					/* help */
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 2) {
						echo '<td align="right"><a href="help/?g=18" accesskey="5" title="'.$_template['help'].' ALT-5"><img src="images/course/c_help.jpg" class="menuimage" border="0" alt="'.$_template['help'].'" /></a></td>'."\n";
					}
					if ($_SESSION['prefs'][PREF_NAV_ICONS] != 1) {
						echo '<td align="right"> <b><a class="noline" href="help/?g=18" accesskey="5" title="'.$_template['accesskey'].' ALT-5">'.$_template['help'].'</a></b></td>'."\n";
					}	
					?>
						</tr></table>
					</TD>
				<TD>
					<IMG SRC="images/course/c_title_09.jpg"></TD>
			</TR>
			<TR>
				<TD COLSPAN=2>
					<IMG SRC="images/course/c_title_10.jpg" WIDTH=88 HEIGHT=30></TD>
				<?php if ($_SESSION['prefs'][PREF_BREADCRUMBS]) { ?>
				<td valign="middle" colspan="3">
					<table cellspacing="0" cellpadding="0" border="0">
					<tr><td>
						<IMG SRC="images/course/path.gif"></td>
					<td>
						<?php require($_include_path.'html/breadcrumbs.inc.php'); ?></td>
					</tr></table>
				</td>
				<?php } ?>
			</TR>
			</TABLE>
		
		<?php
		// Check to see if this course has a header defined. If yes, insert it in
		// place of the default course title
		$sql_head="select header from courses where course_id='$_SESSION[course_id]'";
		if($result=mysql_query($sql_head, $db)){
			while($row=mysql_fetch_row($result)){
				if(strlen($row[0])>0){
					$custom_head = $row[0];
					$custom_head = str_replace("CONTENT_DIR", "content/".$_SESSION['course_id'], $custom_head);
				}
			}
		} 
		if(strlen($custom_head)>0){
			// echo '<b>'.$custom_head.'</b>';
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
		if (($_SESSION['prefs'][PREF_MAIN_MENU] == 1) && ($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] == MENU_LEFT)
			) {
			/* the menu is open: */
			echo '<td id="menu" width="25%" valign="top" rowspan="2" style="padding-top: 1px;">';
	
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
			echo '	<tr><td class="cata" valign="top">';
				echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
					print_popup_help(AT_HELP_MAIN_MENU);
				echo '</td><td background="images/menu/tbl_bg.gif">';
					echo '<a name="menu"></a><a class="white" href="'.$_my_uri.'disable='.PREF_MAIN_MENU.'" accesskey="6" title="'.$_template['close_menu'].': '.$_template['accesskey'].' ALT-6">';
					echo $_template['close_menus'].'';
					echo '</a>';
				echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
				echo '</tr></table>';
			echo '</td></tr></table>';
	
			if (isset($_SESSION['prefs'][PREF_STACK])) {
				foreach ($_SESSION['prefs'][PREF_STACK] as $stack_id) {
					echo '<img src="images/clr.gif" height="1" width="1" alt="" />';
					require($_include_path.'html/dropdowns/'.$_stacks[$stack_id].'.inc.php');
				}
			}
	
			echo '</td>';
		}
		//echo '<td width="3"><img src="images/clr.gif" width="3" height="3" alt="" /></td>';
		if (($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] == MENU_LEFT) || ($_SESSION['prefs'][PREF_MAIN_MENU] == 0)) {
			echo '<td valign="top" width="100%">';
		} else {
			echo '<td valign="top" width="75%">';
	
		}
		?>
		<table border="0" cellspacing="0" cellpadding="0" width="100%" summary="">
		<tr><?php

			if (($_SESSION['prefs'][PREF_MAIN_MENU] != 1)
				&& ($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] == MENU_LEFT)) {
				echo '<td width="25%" valign="top" class="hide">';
	
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
				echo '<tr><td class="cata" valign="top">';
					echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
						print_popup_help(AT_HELP_MAIN_MENU);
					echo '</td><td background="images/menu/tbl_bg.gif">';
						echo '<a name="menu"></a><a class="white" href="'.$_my_uri.($_SESSION['prefs'][PREF_MAIN_MENU] ? 'disable' : 'enable').'='.PREF_MAIN_MENU.$cid_url.'" accesskey="6" title="'.$_template['open_menus'].': '.$_template['accesskey'].' ALT-6">'.$_template['open_menus'].'</a>';
					echo '<td width="8" align="right" valign="top"><img src="images/menu/tbl_end.gif" border="0"></td>';
					echo '</tr></table>';
				echo '</td></tr></table>';

				echo '</td>';
			}
		?>
			<td width="75%" valign="top"></td>
		<?php

			if (($_SESSION['prefs'][PREF_MAIN_MENU] != 1)
				&& ($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] != MENU_LEFT)) {
				echo '<td width="25%" valign="top" class="hide">';

				echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">';
				echo '<tr><td class="cata" valign="top">';
					echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
						print_popup_help(AT_HELP_MAIN_MENU);
					echo '<td><td background="images/menu/tbl_bg.gif">';
						echo '<a name="menu"></a><a class="white" href="'.$_my_uri.($_SESSION['prefs'][PREF_MAIN_MENU] ? 'disable' : 'enable').'='.PREF_MAIN_MENU.$cid_url.'" accesskey="6" title="'.$_template['open_menus'].': '.$_template['accesskey'].' ALT-6">'.$_template['open_menus'].'</a>';
					echo '<td width="8" align="right" valign="top"><img src="images/menu/tbl_end.gif" border="0"></td>';
					echo '</tr></table>';
				echo '</td></tr></table>';

				echo '</td>';
			}?>
		</tr></table>
		<a name="content"></a>
		
		<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F8FA">
		<tr>
		<td align="left">
			<?php
		
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
