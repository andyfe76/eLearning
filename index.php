<?php

	//include('include/no_student.inc.php');

/*$allow[]=STATUS_STUDENT;
$allow[]=STATUS_TRAINER;
$allow[]=STATUS_GROUP_MANAGER;
$allow[]=STATUS_COORDINATOR;
$allow[]=STATUS_ADMINISTRATOR;
$allow[]=STATUS_TRAINING_MANAGER;*/ //undefined constants 

$allow=array(0,1,2,3,4,5);




	$_include_path	='include/';
	$_section = 'Home';
	require($_include_path.'vitals.inc.php');


//print_r($_SESSION);

	if (!$_GET['print_vres']) {
	
	if ($_GET['sinteza'] == 'f') $_SESSION['presentation'] = false;
	if ($_SESSION['presentation'] == true) {
		
		require($_include_path.'s_html/header.inc.php');
		echo '<div align="center"><a href="index.php?sinteza=f"><b>Iesire sinteza</b></a></div>';
	}	
	else require($_include_path.'header.inc.php');
	//echo "<div align=right><a href=$PHP_SELF?print_vres=1&cid=$cid&g=$g>".$_template['simple_view']."</a></div>";
	}else echo '<div align="center">[<a href='.$PHP_SELF.'?cid='.$cid.'&g='.$g.'>'.$_template['normal_view'].'</a>]</div>';
	require($_include_path.'lib/forum_codes.inc.php');
	//echo $_SESSION['member_id'];
	echo '<TR><TD colspan="5" valign="top">';
	
	print_feedback($feedback);

	if ($cid == 0){
		echo '<table cellspacing="0" cellpadding="0" border="0" width="98%" class="announcements"><tr><td align="left">';
		require($_include_path.'html/announcements.inc.php');
		echo '</td></tr></table>';
	} else {
		
		
		$result =& $contentManager->getContentPage($cid);
		if ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
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
				//echo '<hr />'."\n<br><br><br>";
			}

			/* the page title: */
			echo '<table border="0" width="95%" align="center">';
			
			if (($_SESSION['is_admin'])) {
				//nothing
			} else {
				//echo '</table>';
			}
			
		
			$next_prev_links = $contentManager->generateSequenceCrumbs($cid);
			
			if ($_SESSION['prefs'][PREF_SEQ] != BOTTOM) {
				echo '<table cellpadding="0" cellspacing="0" border="0" bgcolor="white" width="95%" align="center">';
				echo '<tr>';
				//echo '<div align="right" id="seqtop">';
				if ($_GET['NO_SEQ'] !='1') echo $next_prev_links;
				//echo '</div>';
				echo '</tr></table>';
			}
			echo '<br>';
			
			echo '<tr><td align="left">';
				echo '<h1>';
				if ($_SESSION['prefs'][PREF_NUMBERING]) {
					if ($top_num != '') {
						$top_num = $top_num.'.'.$row['ORDERING'];
						echo $top_num.' ';
					} else {
						$top_num = $row['ORDERING'];
						echo $top_num.' ';
					}
				}
				if (!$_SESSION['presentation']) {
					echo $row['TITLE'];
				}
				echo '</h1>'."\n<br><br>";
			echo '</td></tr>';
			
			if (($_SESSION['c_instructor']) || ($_SESSION['is_admin'])) {
				echo '<tr><td align="left">';
				echo "\n".'<small class="spacer">';
				echo  $_template['last_modified'].': '.$row['LAST_MODIFIED'];
				echo ' | ';
				echo  $_template['revision'].': '.$row['REVISION'];
				echo ' | ';
				echo $_template['release_date'].': '.$row['R_DATE'];
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
			$r_day   = substr($row['R_DATE'], 0, 2);
			$r_mon   = substr($row['R_DATE'], 3, 2);
			$r_year  = substr($row['R_DATE'], 6, 4);
			$r_hour  = substr($row['R_DATE'], 11, 2);
			$r_min   = substr($row['R_DATE'], 14, 2);
			
			$n_day   = substr($row['N_DATE'], 0, 2);
			$n_mon   = substr($row['N_DATE'], 3, 2);
			$n_year  = substr($row['N_DATE'], 6, 4);
			$n_hour  = substr($row['N_DATE'], 11, 2);
			$n_min   = substr($row['N_DATE'], 14, 2);
			
			$rdate = mktime($r_hour, $r_min, 0, $r_mon, $r_day, $r_year);
			$ndate = mktime($n_hour, $n_min, 0, $n_mon, $n_day, $n_year);
			if (($rdate <= $ndate) || ($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
				if ($row['TEXT'] == '') {
					$infos[]=AT_INFOS_NO_PAGE_CONTENT;
					print_infos($infos);
				} else {
					if ($rdate > $ndate) {
						$infos[]=array(AT_INFOS_NOT_RELEASED, $row['R_DATE']);
						print_infos($infos);
					}

					require($_include_path.'lib/format_content.inc.php');

					/* @See: ./include/lib/format_content.inc.php */
					
						if ($row['FORMATTING']==2){
							$chf_text='<br><br><div align=center>'.$_template['test'].' : '.$row['TITLE'].'</div>';
							
						}else {	
							$fh = fopen($row['TEXT'], 'r');  
        					$chf_text = fread($fh, filesize($row['TEXT']));
        					fflush($fh);
     						fclose($fh);
						}

					
					echo format_content($chf_text, 1, 'get');
					//echo $row['TEXT'];
				}
			} else {
				$errors[]=array(AT_ERROR_NOT_RELEASED, '<small>('.$_template['release_date'].': '.$row['R_DATE'].')</small>');
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
	if (!$_GET['print_vres']) {
	if ($_SESSION['presentation']) require($_include_path.'s_html/footer.inc.php');
	else require ($_include_path.'footer.inc.php');
	}
?>
