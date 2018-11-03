<?php

	$_include_path	='include/';
	$_section = 'Home';
	require($_include_path.'vitals.inc.php');
	require($_include_path.'header.inc.php');
	require($_include_path.'lib/forum_codes.inc.php');
	
	echo '<TR><TD colspan="5" valign="top">';
	
	print_feedback($feedback);

	function is_alpha($input) {
		return (("a" <= $input && $input <= "z") || ("A" <= $input && $input <= "Z"))?true:false;
	}


	if ($cid == 0){
		echo '<table cellspacing="0" cellpadding="0" border="0" width="98%" class="announcements"><tr><td align="left">';
		require($_include_path.'html/announcements.inc.php');
		echo '</td></tr></table>';
	} else {
		$result =& $contentManager->getContentPage($cid);

		if ($row =& mysql_fetch_array($result)) {
			/* the "heading navigation": */

			$parent_headings = '';
			for ($i=0; $i<count($path)-1; $i++) {
				$content_info = $path[$i];
				$h = ($i>5) ? 6 : $i+1;
				$parent_headings .= '<h'.$h.'>';
				$fsize = 13 - intval($h);
				if ($fsize <7) {
					$fsize = 7;
				}
				$parent_headings .= '<a class="breadcrumbs" href="./index.php?cid='.$content_info['content_id'].SEP.'g=11"><span style="font-size: '.$fsize.'pt;">';
				if ($_SESSION['prefs'][PREF_NUMBERING]) {
					if ($contentManager->_menu_info[$content_info['content_id']]['content_parent_id'] == 0) {
						$top_num = $contentManager->_menu_info[$content_info['content_id']]['ordering'];

						$parent_headings .= $top_num;
					} else {
						$top_num = $top_num.'.'.$contentManager->_menu_info[$content_info['content_id']]['ordering'];

						$parent_headings .= $top_num;
					}
					$parent_headings .= ' ';
				}
				$parent_headings .= $content_info['title'].'</span></a>'."\n";
				$parent_headings .= '</h'.$h.'>'."\n";
			}

			if ($_SESSION['prefs'][PREF_HEADINGS] && ($parent_headings != '')) {
				//echo $parent_headings;
				//echo '<hr />'."\n";
			}

			/* the page title: */
			echo '<table border="0" width="95%" align="center">';
			
			/* TOC: */
			/* if ($_SESSION['prefs'][PREF_TOC] != BOTTOM) {
				ob_start();

				$p = $contentManager->getContent();
				print_menu_collapse($cid, $p, 1, $top_num.'.', array(), 13, false, false);

				$content_stuff = ob_get_contents();
				ob_end_clean();

				if ($content_stuff != '') {
					echo '<br />'.$_template['contents'].':<br />'."\n";
					echo $content_stuff;
					echo '<br />'."\n";
				}
			} */
			
			if (($_SESSION['is_admin'])) {
				//nothing
			} else {
				//echo '</table>';
			}
			
		
			$next_prev_links = $contentManager->generateSequenceCrumbs($cid);
			// here: TODO: parse $next_prev_links and shrink when necessary
			
			if ($_SESSION['prefs'][PREF_SEQ] != BOTTOM) {
				echo '<table cellpadding="0" cellspacing="0" border="0" bgcolor="white" width="95%" align="center">';
				echo '<tr>';
				//echo '<div align="right" id="seqtop">';
				echo $next_prev_links;
				//echo '</div>';
				echo '</tr></table>';
			}
			echo '<br>';
			
			echo '<tr><td align="left">';
				echo '<h1>';
				if ($_SESSION['prefs'][PREF_NUMBERING]) {
					if ($top_num != '') {
						$top_num = $top_num.'.'.$row['ordering'];
						echo $top_num.' ';
					} else {
						$top_num = $row['ordering'];
						echo $top_num.' ';
					}
				}
				echo $row['title'].'</h1>'."\n";
			echo '</td></tr>';
			
			if (($_SESSION['c_instructor'])) {
				echo '<tr><td align="left">';
				echo "\n".'<small class="spacer">';
				echo  $_template['last_modified'].': '.$row['last_modified'];
				echo ' | ';
				echo  $_template['revision'].': '.$row['revision'];
				echo ' | ';
				echo $_template['release_date'].': '.$row['release_date'];
				echo '</small></p>'."\n";
				echo '</td></tr>';
				
				echo '<tr><td>';
				
				echo '<table cellspacing="1" cellpadding="0" width="98%">';
				echo '<tr><td>';
				echo '<hr>';
				echo '</td><td width="120" align="right" valign="top">';
				echo '<small class="bigspacer">';
				echo '<a href="editor/edit_content.php?cid='.$cid.'"><img src="images/kedit.jpg" border="0" alt="'.$_template['edit_page'].'"></a>'."\n";
				echo '<img src="images/menu/menu_sepg1.gif">';
				echo '<a href="editor/add_new_content.php?pid='.$cid.'"><img src="images/kadd_sub.jpg" border="0" alt="'.$_template['sub_page'].'"></a>'."\n";
				echo '<img src="images/menu/menu_sepg1.gif"> ';
				echo '<a href="tools/tests/add_test.php?pid='.$cid.'"><img src="images/kadd_test.jpg" border="0" alt="'.$_template['add_test'].'"></a>'."\n";
				echo '</td><td width="80" align="right">';
				echo '<a href="editor/delete_content.php?cid='.$cid.'"><img src="images/kdelete.jpg" border="0" alt="'.$_template['delete_page'].'"></a></small>'."\n";
				echo '</td></tr></table>';
			}  else {
				echo '</td></tr><tr><td>';
			}
			
			echo '<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center"><tr><td align="left">';

			/* if i'm an admin then let me see content, otherwise only if released */
			if (($row['r_date'] <= $row['n_date']) || ($_SESSION['is_admin'])) {
				if ($row['text'] == '') {
					$infos[]=AT_INFOS_NO_PAGE_CONTENT;
					print_infos($infos);
				} else {
					if ($row['r_date'] > $row['n_date']) {
						$infos[]=array(AT_INFOS_NOT_RELEASED, $row['r_date']);
						print_infos($infos);
					}

					require($_include_path.'lib/format_content.inc.php');

					/* @See: ./include/lib/format_content.inc.php */
					echo format_content($row['text'], $row['formatting']);
					//echo $row['text'];
				}
			} else {
				$errors[]=array(AT_ERROR_NOT_RELEASED, '<small>('.$_template['release_date'].': '.$row['release_date'].')</small>');
				print_errors($errors);
			}
			
			echo '</td></tr><table>';

			/* TOC: */
			/*echo '<table border="0" cellspacing="1" cellpadding="0" width="98%">';
			echo '<tr><td class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
			echo '</table>';*/
			
			echo '<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center"><tr><td align="left">';
			
			if ($_SESSION['prefs'][PREF_TOC] != TOP) {
				ob_start();

				$p = $contentManager->getContent();

				/* print_menu_collapse(parent_id, _menu, depth, path, children, g, truncate, [ignore_state]) */

				print_menu_collapse($cid, $p, 1, $top_num.'.', array(), 13, false);

				$content_stuff = ob_get_contents();
				ob_end_clean();

				if ($content_stuff != '') {
					echo '<br /><hr><br /><b>'.$_template['contents'].':</b><br><br />'."\n";
					echo $content_stuff;
				}
			}
			
			echo '</td></tr><table>';

		} else {
			$errors[] = AT_ERROR_PAGE_NOT_FOUND;
			echo '<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center"><tr><td>';
			print_errors($errors);
			echo '</td></tr><table>';
		}
	}
	
	if (($_SESSION['prefs'][PREF_MAIN_MENU] == 1) && ($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] != MENU_LEFT)) {
		/* the right menu is open: */
		/* don't close the table yet */
	}
	else{ 
		echo '</td></tr></table>';
	}
	//echo '</td></tr></table>';

	require ($_include_path.'footer.inc.php');
?>
