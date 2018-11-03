<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

	$_include_path = '../../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['sitemap'];


	require($_include_path.'header.inc.php');
	echo '<h2><a href="tools/?g=11">'.$_template['tools'].'</a></h2>';
	echo '<h3>'.$_template['sitemap'].'</h3><p>';

	echo '<a href="./">'.$_template['home'].'</a><br />';
	echo '<img src="images/tree/tree_split.gif" alt="" /> ';
	echo $_template['content'].'<br />';

	/* @See lib/content_functions.inc.php	*/
	/* @See classes/ContentManager.class.php	*/
	
	print_menu_collapse(0, $contentManager->getContent(), 1, '', array(1), 8, false, true);



	echo '<img src="images/tree/tree_split.gif" alt="" /> <a href="tools/">'.$_template['tools'].'</a>';
	echo '<br />';
	echo '<img src="images/tree/tree_vertline.gif" alt="" />';
	echo '<img src="images/tree/tree_split.gif" alt="" /> <a href="tools/preferences.php">'.$_template['preferences'].'</a>';
	echo '<br />';
	echo '<img src="images/tree/tree_vertline.gif" alt="" />';
	echo '<img src="images/tree/tree_split.gif" alt="" /><img src="images/glossary.gif" alt="" /> <a href="glossary/">'.$_template['glossary'].'</a>';
	echo '<br />';
	echo '<img src="images/tree/tree_vertline.gif" alt="" />';
	if ($_SESSION['is_admin']) {
		echo '<img src="images/tree/tree_split.gif" alt="" />';
	} else {
		echo '<img src="images/tree/tree_end.gif" alt="" /> ';
	}
	echo '<img src="images/toc.gif" alt="" /> <a href="tools/sitemap/">'.$_template['sitemap'].'</a>';

	if ($_SESSION['is_admin']) {
		echo '<br />';
		echo '<img src="images/tree/tree_vertline.gif" alt="" />';
		echo '<img src="images/tree/tree_end.gif" alt="" /> <a href="tools/file_manager.php">'.$_template['file_manager'].'</a>';
	}

	echo '<br />';
	echo '<img src="images/tree/tree_split.gif" alt="" /> <a href="resources/">'.$_template['resources'].'</a>';
	echo '<br />';
	echo '<img src="images/tree/tree_vertline.gif" alt="" />';
	echo '<img src="images/tree/tree_end.gif" alt="" /> <a href="resources/links/">'.$_template['links_database'].'</a>';

	echo '<br />';
	echo '<img src="images/tree/tree_split.gif" alt="" /> <a href="discussions/">'.$_template['discussions'].'</a>';
	echo '<br />';
	echo '<img src="images/tree/tree_vertline.gif" alt="" />';
	echo '<img src="images/tree/tree_split.gif" alt="" /> '.$_template['forums'].' ';

	$sql	= "SELECT * FROM forums WHERE course_id=$_SESSION[course_id] ORDER BY title";
	$result = mysql_query($sql, $db);
	$num_forums = mysql_num_rows($result);
	if ($row = mysql_fetch_array($result)) {
		do {
			$count++;
			echo '<br />';
			echo '<img src="images/tree/tree_vertline.gif" alt="" />';
			echo '<img src="images/tree/tree_vertline.gif" alt="" />';

			if ($count < $num_forums) {
				echo '<img src="images/tree/tree_split.gif" alt="" />';
			} else {
				echo '<img src="images/tree/tree_end.gif" alt="" />';
			}
			echo ' <a href="forum/?fid='.$row['forum_id'].'">'.$row['title'].'</a>';
		} while ($row = mysql_fetch_array($result));
	} else {
		echo '<br />';
		echo '<img src="images/tree/tree_vertline.gif" alt="" />';
		echo '<img src="images/tree/tree_vertline.gif" alt="" />';
		echo '<img src="images/tree/tree_end.gif" alt="" />';
		echo $_template['no_forums'];
	}

	echo '<br />';
	echo '<img src="images/tree/tree_vertline.gif" alt="" />';
	echo '<img src="images/tree/tree_end.gif" alt="" /> <a href="discussions/chat/">'.$_template['chat'].'</a>';

	echo '<br />';
	echo '<img src="images/tree/tree_end.gif" alt="" /> <a href="help/">'.$_template['help'].'</a>';

	echo '</p>';

	require($_include_path.'footer.inc.php');
?>
