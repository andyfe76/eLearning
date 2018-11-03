<?php

	if ($_SESSION['prefs'][PREF_MENU] == 1){
?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" summary="">
<tr>
	<td valign="top">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr><td width="18">
			<?php print_popup_help(AT_HELP_GLOBAL_MENU); ?></td>
		<td background="images/menu/tbl_bg.gif">
			<?php echo '<a class="white" href="'.$_my_uri.'disable='.PREF_MENU.'" accesskey="7" title="'.$_template['close_global_menu'].': Alt-7">'.$_template['close_global_menu'].'</a>'; ?></td>
		<td width="8" align="right">
			<img src="images/menu/tbl_end.gif" border="0"></td>
		</tr></table>
	</td>
</tr>
<?php  
						
	if ($_SESSION['is_admin'] || $_SESSION['c_instructor']) {
		echo '<tr>';
		echo '<td class="mrow1" ALIGN="LEFT">';
	    echo '<a href="editor/add_new_content.php" class="breadcrumbs"><img src="images/menu/add_chapterpage.gif" class="menuimage" alt="'.$_template['add_top_level_page'].'" border="0" /></a> <a class="breadcrumbs" href="editor/add_new_content.php">'.$_template['add_top_level_page'].'</a>';
		echo '</td></tr>';
		echo '<tr><td class="mrow2" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	}

		echo '<tr>';
		echo '<td valign="top" class="mrow2" align="left" nowrap="nowrap">';
	
		if (is_array($path)) {
			$temp_path = $path;
		} else {
			$temp_path = $contentManager->getContentPath($_SESSION['s_cid']);
		}
		echo '&nbsp;<a class="breadcrumbs" href="./?g=9">'.$_template['home'].'</a><br />';

		/* @See lib/content_functions.inc.php	*/
		/* @See classes/ContentManager.class.php	*/
		$x = $contentManager->getContent();
		print_menu_collapse(0,  $x, 0, '', array(), 3);

		echo '<img src="images/tree/tree_split.gif" alt="" width="16" height="16" /> ';
		echo '<img src="images/glossary.gif" alt="" /> <a class="breadcrumbs" href="glossary/">'.$_template['glossary'].'</a>';

		echo '<br />';

		echo '<img src="images/tree/tree_end.gif" alt="" width="16" height="16" /> ';
		echo '<img src="images/toc.gif" alt="" /> <a class="breadcrumbs" href="tools/sitemap/">'.$_template['sitemap'].'</a>';

		echo '</td></tr>';

?></table><?php


} else {
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mcat2" >';
	echo '<tr><td class="cata" valign="top">';
		echo '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="18">';
			print_popup_help(AT_HELP_GLOBAL_MENU);
		echo '</td><td background="images/menu/tbl_bg.gif">';
			echo '<a class="white" href="'.$_my_uri.'enable='.PREF_MENU.'" accesskey="7" title="'.$_template['open_global_menu'].': Alt-7">';
			echo $_template['open_global_menu'].'';
			echo '</a>';
		echo '<td width="8" align="right"><img src="images/menu/tbl_end.gif" border="0"></td>';
		echo '</tr></table>';
	echo '</td></tr></table>';
} 

?>
