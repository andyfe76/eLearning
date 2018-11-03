<?php

/** @See editor/edit_content.php, editor/add_new_content.php 
 * @return void
 * @param parent_id unknown
 * @param $_menu unknown
 * @param related_content_id unknown
 * @param depth unknown
 * @param path unknown
 * @desc Print selected menu
*/
function print_select_menu($parent_id, &$_menu, $related_content_id, $depth=0, $path='') {
	global $cid;

	$top_level = $_menu[$parent_id];

	if ( is_array($top_level) ) {
		$counter = 1;
		foreach ($top_level as $x => $content) {
			if ($cid != $content['content_id']) {
				echo '<option value="'.$content['content_id'].'"';
				if ($related_content_id == $content['content_id']) {
					echo ' selected="selected"';
				}
				echo '>';
				echo str_pad('', $depth, '-');
				echo $path.$counter;
				echo ' '.$content['title'];
				echo '</option>';
			}
			print_select_menu($content['content_id'], &$_menu, $related_content_id, $depth+1, $path.$counter.'.');
					
			$counter++;
		}
	}
}

/* @See editor/edit_content.php										*/
function print_move_select($parent_id, &$_menu, $my_parent_id, $depth=0, $path='') {
	global $cid, $_template;

	if ( $cid == $parent_id) {
		return;
	}

	$top_level = $_menu[$parent_id];

	if ( is_array($top_level) ) {
		$counter = 1;
		foreach ($top_level as $x => $content) {
			if ($cid != $content['content_id']) {
				echo '<option value="'.$content['content_id'].'">';
				echo str_pad('', $depth, '-');
				echo $_template['child_of'].': ';
				echo $path.$counter;
				echo ' '.$content['title'];
				echo '</option>';
			}
			print_move_select($content['content_id'], $_menu, $my_parent_id, $depth+1, $path.$counter.'.');
								
			$counter++;
		}
	}
}


/* @See include/html/menu_menu.inc.php	*/
/** @See tools/sitemap/index.php			
 * @desc Prints the main menu when browsing course content
*/
function print_menu_collapse($parent_id,
							 &$_menu, 
							 $depth, 
							 $path='',
							 $children,
							 $g,
							 $truncate = true, 
							 $ignore_state = false) {
	
	global $temp_path, $cid, $PHP_SELF, $_my_uri, $_template, $item_type;

	$top_level = $_menu[$parent_id];

	if ( is_array($top_level) ) {
		$counter = 1;
		$num_items = count($top_level);
		
		foreach ($top_level as $x => $content) {

			$link = '';
			$on = false;

			if ( ($_SESSION['s_cid'] != $content['content_id']) || ($_SESSION['s_cid'] != $cid) ) {
				if (is_array($temp_path)) {
					$this = current($temp_path);
					if ($content['content_id'] == $this['content_id']) {
						$this = next($temp_path);
						$link .= '<b>';
						$on = true;
						$_SESSION['menu'][$content['content_id']] = 1;
					}
				}
				
				// start (check display rights)
				if (($_SESSION['linear_index'][$content['content_id']] <= $_SESSION['access_index']) || ($_SESSION['c_instructor']) || ($_SESSION['access_index'] == -1)) {
					if ($content['formatting'] == 2) {
						$link .= ' <a class="breadcrumbs" href="./tools/tests/prepare_test.php?cid='.$content['content_id'].SEP.'g='.$g.'" title="'.$content['title'].'">';
					} else {
						$link .= ' <a class="breadcrumbs" href="./?cid='.$content['content_id'].SEP.'g='.$g.'" title="'.$content['title'].'">';
					}
					if ($truncate && (strlen($content['title']) > (26-$depth*4))) {
						$content['title'] = rtrim(substr($content['title'], 0, (26-$depth*4)-4)) . '...';
					}
					$link .= $content['title'];
					$link .= '</a>';
					if ($on) {
						$link .= '</b>';
					}
					
				// else print only the title --> no href
				} else {
					//$link .= ' <b title="'.$content['title'].'">';
					if ($truncate && (strlen($content['title']) > (26-$depth*4)) ) {
						$content['title'] = rtrim(substr($content['title'], 0, (26-$depth*4)-4)).'...';
					}
					$link .= $content['title'];//.'</b>';
					// $on = true;
				}
				// end (check display rights)

			} else {
				$link .= ' <b title="'.$content['title'].'">';
				if ($truncate && (strlen($content['title']) > (26-$depth*4)) ) {
					$content['title'] = rtrim(substr($content['title'], 0, (26-$depth*4)-4)).'...';
				}
				$link .= $content['title'].'</b>';
				$on = true;
			}

			if ($ignore_state) {
				$on = true;
			}

			if ( is_array($_menu[$content['content_id']]) ) {
				/* has children */

				for ($i=0; $i<$depth; $i++) {
					if ($children[$i] == 1) {
						echo '<img src="images/tree/tree_vertline.gif" alt="" border="0" width="16" height="16" />';
					} else {
						echo '<img src="images/tree/tree_space.gif" alt="" border="0" width="16" height="16" />';
					}
				}

				if (($counter == $num_items) && ($depth > 0)) {
					echo '<img src="images/tree/tree_end.gif" alt="" border="0" width="16" height="16" />';
					$children[$depth] = 0;
				} else {
					echo '<img src="images/tree/tree_split.gif" alt="" border="0" width="16" height="16" />';
					$children[$depth] = 1;
				}

				if ($_SESSION['s_cid'] == $content['content_id']) {
					$_SESSION['menu'][$content['content_id']] = 1;
				}

				if ($_SESSION['menu'][$content['content_id']] == 1) {
					if ($on) {
						echo '<img src="images/tree/tree_disabled.gif" alt="'.$_template['toggle_disabled'].'" border="0" width="16" height="16" title="'.$_template['toggle_disabled'].'"/>';
					} else {
						echo '<a href="'.$_my_uri.'collapse='.$content[content_id].'">';
						echo '<img src="images/tree/tree_collapse.gif" alt="'.$_template['collapse'].'" border="0" width="16" height="16" title="'.$_template['collapse'].'"/>';
						echo '</a>';
					}
				} else {
					if ($on) {
						echo '<img src="images/tree/tree_disabled.gif" alt="'.$_template['toggle_disabled'].'" border="0" width="16" height="16" title="'.$_template['toggle_disabled'].'" />';
					} else {
						echo '<a href="'.$_my_uri.'expand='.$content[content_id].'">';
						echo '<img src="images/tree/tree_expand.gif" alt="'.$_template['expand'].'" border="0" width="16" height="16" 	title="'.$_template['expand'].'"/>';
						echo '</a>';
					}
				}

			} else {
				/* doesn't have children */
				if ($counter == $num_items) {
					for ($i=0; $i<$depth; $i++) {
						if ($children[$i] == 1) {
							echo '<img src="images/tree/tree_vertline.gif" alt="" border="0" width="16" height="16" />';
						} else {
							echo '<img src="images/tree/tree_space.gif" alt="" border="0" width="16" height="16" />';
						}
					}
					if ($parent_id == 0) {
						// special case for the last one:
						echo '<img src="images/tree/tree_split.gif" alt="" border="0" />';
					} else {
						echo '<img src="images/tree/tree_end.gif" alt="" border="0" />';
					}
				} else {
					for ($i=0; $i<$depth; $i++) {
						if ($children[$i] == 1) {
							echo '<img src="images/tree/tree_vertline.gif" alt="" border="0" width="16" height="16" />';
						} else {
							echo '<img src="images/tree/tree_space.gif" alt="" border="0" width="16" height="16" />';
						}
					}
	
					echo '<img src="images/tree/tree_split.gif" alt="" border="0" width="16" height="16" />';
				}
				echo '<img src="images/tree/tree_space.gif" alt="" border="0" width="16" height="16" />';
			
			}

			if ($content['formatting'] == 2) {
				// obsolete formatting; now this attribute is used to indicate page/test type information
				echo '<img src="images/menu_testitem.jpg" alt="" border="0" />';
				$item_type = 'test';
			} else {
				$item_type = 'page';
			}
			
			if ($_SESSION['prefs'][PREF_NUMBERING]) {
				echo $path.$counter;
			}
			
			echo $link;
			
			echo '<br />'."\n";
			if ( (($_SESSION['menu'][$content['content_id']] != '') 
				   || ($_SESSION['s_cid'] == $content['content_id'])
				 )
				|| $ignore_state )
			{
				print_menu_collapse($content['content_id'],
									$_menu, 
									$depth+1, 
									$path.$counter.'.', 
									$children,
									$g, 
									$truncate, 
									$ignore_state);

			}
			$counter++;
		}
	}
}

?>