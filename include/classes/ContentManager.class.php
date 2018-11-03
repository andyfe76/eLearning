<?php



class ContentManager
{
	/* db handler	*/
	var $db;

	/*	array		*/
	var $_menu;
	
	/*	array		*/
	var $_menu_info;
	
	/* int			*/
	var $course_id;

	// private
	var $magic_quotes;

	// private
	var $allowed_tags = '<p><b><i><a><em><br><strong><blockquote><tt><li><ol><ul><img><hr>';

	// private
	var $num_sections;

	// private
	var $max_depth;

	// private
	var $content_length;

	/* constructor	*/
	function ContentManager(&$db, $course_id) {
		$this->db = $db;

		$this->course_id = $course_id;

		if (get_magic_quotes_gpc() == 1) {
			$this->magic_quotes = true;
		} else {
			$this->magic_quotes = false;
		}
	}


	function initLinearIndex($parent_id,
							 &$_menu, 
							 $depth, 
							 $path='',
							 $children,
							 $g,
							 $truncate = true, 
							 $ignore_state = false) {
	
		global $temp_path, $cid, $PHP_SELF, $_my_uri, $_template, $_linear;
		
		$_linear = intval($_linear);
		
		$top_level = $_menu[$parent_id];
				
		if ( is_array($top_level) ) {
			$counter = 1;
			$num_items = count($top_level);
			
			foreach ($top_level as $x => $content) {
	
				$link = '';
				$on = false;
				$_SESSION['linear_index'][$content['content_id']] = $_linear;
	
				if ( ($_SESSION['s_cid'] != $content['content_id']) || ($_SESSION['s_cid'] != $cid) ) {
					if (is_array($temp_path)) {
						$this = current($temp_path);
						if ($content['content_id'] == $this['content_id']) {
							$this = next($temp_path);
							$on = true;
							$_SESSION['menu'][$content['content_id']] = 1;
						}
					}
					
				} else {
					if ($truncate && (strlen($content['title']) > (26-$depth*4)) ) {
						$content['title'] = rtrim(substr($content['title'], 0, (26-$depth*4)-4)).'...';
					}
					$on = true;
				}
	
				if ($ignore_state) {
					$on = true;
				}
	
				if ( is_array($_menu[$content['content_id']]) ) {
					/* has children */
	
					if (($counter == $num_items) && ($depth > 0)) {
						$children[$depth] = 0;
					} else {
						$children[$depth] = 1;
					}
	
					if ($_SESSION['s_cid'] == $content['content_id']) {
						$_SESSION['menu'][$content['content_id']] = 1;
					}
	
				} else {
				
				}
				
				if ($content['formatting'] == 2) {
					// this page is actually a test
					$tmp_cid = intval($content['content_id']);
					$sql = "SELECT text FROM content WHERE content_id=$tmp_cid";
					$res = mysql_query($sql);
					$test_row = mysql_fetch_array($res);
					$test_id = intval( $test_row['text'] );
					if ($test_id == 0) {
						$_SESSION['access_index'] = -1;
						// error; No test defined.
					} else {
						$sql = "SELECT * FROM tests_status WHERE member_id=$_SESSION[member_id] AND test_id=$test_id";
						$res = mysql_query($sql);
						if (!$res) {
							$passed = "no"; 
							$_SESSION['access_index'] = $_linear;
						} else if (mysql_num_rows($res)>1) {
							$tmp_row = mysql_fetch_array($res);
							$passed = $tmp_row['passed'];
							if ($passed == '') {
								$passed = "yes";
							}
						}
						if ($passed == "yes") {
							// echo 'PASSED... <br>';
						} else if ($_SESSION['access_index'] == -1) {
							$_SESSION['access_index'] = $_linear;
						}
					}
				}
				
				$_linear++;
				
				if ( (($_SESSION['menu'][$content['content_id']] != '') 
					   || ($_SESSION['s_cid'] == $content['content_id'])
					 )
					|| $ignore_state )
				{
					$this->initLinearIndex($content['content_id'],
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
	
	
	function initContent( ) {
		if ($this->course_id == '') {
			return;
		}
		$sql = "SELECT content_id, content_parent_id, ordering, title, formatting FROM content WHERE course_id=$this->course_id ORDER BY content_parent_id, ordering";
		$result = mysql_query($sql);

		/* x could be the ordering or even the content_id	*/
		/* don't really need the ordering anyway.			*/
		/* $_menu[content_parent_id][x] = array('content_id', 'ordering', 'title') */
		$_menu = array();
		
		/*	$_menu_parents[content_id] = array('content_parent_id', 'title')	*/
		$_menu_parents = array();

		/* number of content sections */
		$num_sections = 0;
		
		$max_depth = array();
		
		/* index of last page accessible; a value of -1 indicates all pages are accessible. */
		$display_access_index = -1;
		
		while ($row = mysql_fetch_array($result)) {
			$num_sections++;
			$_menu[$row['content_parent_id']][] = array('content_id'=> $row['content_id'],
														'ordering'	=> $row['ordering'], 
														'title'		=> $row['title'],
														'formatting' => $row['formatting']);
														
			$_menu_info[$row['content_id']] = array('content_parent_id' => $row['content_parent_id'],
													'title'				=> $row['title'],
													'ordering'			=> $row['ordering'],
													'formatting' => $row['formatting']);

			if ($row['content_parent_id'] == 0){
				$max_depth[$row['content_id']] = 1;
			} else {
				$max_depth[$row['content_id']] = $max_depth[$row['content_parent_id']]+1;
			}
		}
		
		$_SESSION['access_index'] = -1;
		$this->_linear_index = array();
		$this->initLinearIndex(0,  $_menu, 0, '', array(), 3, true, true);
		//echo 'access page: '.$_SESSION['access_index'];
		
		$this->_menu = $_menu;

		$this->_menu_info =  $_menu_info;

		$this->num_sections = $num_sections;

		if (count($max_depth) > 1) {
			$this->max_depth = max($max_depth);
		} else {
			$this->max_depth = 0;
		}

		$this->content_length = count($_menu[0]);
		
		$sql = "SELECT member_id FROM courses WHERE course_id=$this->course_id";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		if ($row['member_id'] == $_SESSION['member_id']) {
			$_SESSION['c_instructor'] = true;
		}
	

	}


	function getContent($parent_id=-1, $length=-1) {
		if ($parent_id == -1) {
			$my_menu_copy = $this->_menu;
			if ($length != -1) {
				$my_menu_copy[0] = array_slice($my_menu_copy[0], 0, $length);
			}
			return $my_menu_copy;
		}
		return $this->_menu[$parent_id];
	}


	function &getContentPath($content_id) {
		$path = array();
		$path[] = array('content_id' => $content_id, 'title' => $this->_menu_info[$content_id]['title']);

		$this->getContentPathRecursive($content_id, &$path);

		$path = array_reverse($path);
		return $path;
	}


	function getContentPathRecursive($content_id, &$path) {
		$parent_id = $this->_menu_info[$content_id]['content_parent_id'];

		if ($parent_id > 0) {
			$path[] = array('content_id' => $parent_id, 'title' => $this->_menu_info[$parent_id]['title']);
			$this->getContentPathRecursive($parent_id, &$path);
		}
	}


	function addContent($course_id, $content_parent_id, $ordering, $title, $text, $related, $formatting, $release_date) {
		if ( ($_SESSION['is_admin'] != 1) || ($_SESSION['c_instructor'] != 1) ) {
			return false;
		}

		/* get the maximum ordering for this content_parent_id */
		$parents	  = $this->getContent($content_parent_id);
		if (is_array($parents)) {
			$max_ordering = count($parents);
		} else {
			$max_ordering = 0;
		}
		if ($ordering == $max_ordering) {
			/* we're adding at the end or the first topic							 */
			/* example: max_ordering = 0, insert at 1 if empty, max_ordering+1 o/w */
			$ordering++;
		} else {
			/* we're inserting in the beginning or middle, so shift					 */
			/* example: ordering = 2, shift those >2, insert at 3					 */
			$sql = "UPDATE content SET ordering=ordering+1 WHERE ordering > $ordering AND course_id=$course_id AND content_parent_id=$content_parent_id";
			$err = mysql_query($sql, $this->db);
			$ordering++;
    	}

		/* cleanup the body: */
		//$text = strip_tags($text, $this->getAllowedTags());

		/* main topics all have minor_num = 0 */
		$sql = "INSERT INTO content VALUES (0,$course_id, $content_parent_id, $ordering, NOW(), 0, $formatting, '$release_date','$title','$text')";
		$err = mysql_query($sql, $this->db);

		/* insert the related content */
		$cid = mysql_insert_id($this->db);
		$sql = '';
		if (is_array($related)) {
			foreach ($related as $x => $related_content_id) {
				$related_content_id = intval($related_content_id);

				if ($related_content_id != 0) {
					if ($sql != '') {
						$sql .= ', ';
					}
					$sql .= '('.$cid.', '.$related_content_id.')';
					$sql .= ', ('.$related_content_id.', '.$cid.')';
				}
			}

			if ($sql != '') {
				$sql	= 'INSERT INTO related_content VALUES '.$sql;
				$result	= mysql_query($sql, $this->db);
			}
		}

		return $cid;
	}


	function editContent($content_id, $title, $text, $new_ordering, $related, $formatting, $move, $release_date) {
		if ( $_SESSION['is_admin'] != 1) {
			return false;
		}

		/* first get the content to make sure it exists	*/
		$sql	= "SELECT ordering, content_parent_id FROM content WHERE content_id=$content_id AND course_id=$_SESSION[course_id]";
		$result	= mysql_query($sql, $this->db);
		if (!($row = mysql_fetch_array($result)) ) {
			return false;
		}

		$old_ordering		= $row['ordering'];
		$content_parent_id	= $row['content_parent_id'];
		$new_content_parent_id = $content_parent_id;
		$new_content_ordering  = $row['ordering'];

		if ($move != -1) {
			if ($move == 0) {
				$new_content_parent_id = 0;
				$new_content_ordering  = 1;

			} else {
				$new_content_parent_id = $move;
				$new_content_ordering  = 1;
			}

			/* step 1:											*/
			/* remove the gap left by the moved content			*/
			$sql = "UPDATE content SET ordering=ordering-1 WHERE ordering>=$old_ordering AND content_parent_id=$content_parent_id AND content_id<>$content_id AND course_id=$_SESSION[course_id]";
			$result = mysql_query($sql, $this->db);

			/* step 2:											*/
			/* shift the new neighbouring content down			*/
			$sql = "UPDATE content SET ordering=ordering+1 WHERE ordering>=$new_content_ordering AND content_parent_id=$new_content_parent_id AND content_id<>$content_id AND course_id=$_SESSION[course_id]";
			$result = mysql_query($sql, $this->db);

			/* step 3:											*/
			/* insert the new content at the bottom				*/

		} else if ($new_ordering != -1) {
			/* this content will be moved */

			if ($old_ordering < $new_ordering) {
				/* move it down				      */
				$start = $old_ordering;
				$end   = $new_ordering;

				/* and shift everything else up   */
				$sign = '-';
			} else {
				/* move it up					  */
				$start = $new_ordering;
				$end   = $old_ordering;

				/* and shift everything else down */
				$sign = '+';
			}

			$sql = "UPDATE content SET ordering=ordering $sign 1 WHERE ordering>=$start AND ordering<=$end AND content_parent_id=$content_parent_id AND course_id=$_SESSION[course_id]";
			$result = mysql_query($sql, $this->db);

			$new_content_ordering = $new_ordering;
		} /* end moving block */

		/* cleanup the body: */
		//$text = strip_tags($text, $this->getAllowedTags());

		/* update the title, text of the newly moved (or not) content */
		$sql	= "UPDATE content SET title='$title', text='$text', formatting=$formatting, content_parent_id=$new_content_parent_id, ordering=$new_content_ordering, revision=revision+1, last_modified=NOW(), release_date='$release_date' WHERE content_id=$content_id AND course_id=$_SESSION[course_id]";
		$result	= mysql_query($sql, $this->db);

		/* update the related content */
		$result	= mysql_query("DELETE FROM related_content WHERE content_id=$content_id OR related_content_id=$content_id", $this->db);
		$sql = '';
		if (is_array($related)) {
			foreach ($related as $x => $related_content_id) {
				$related_content_id = intval($related_content_id);

				if ($related_content_id != 0) {
					if ($sql != '') {
						$sql .= ', ';
					}
					$sql .= '('.$content_id.', '.$related_content_id.')';
					$sql .= ', ('.$related_content_id.', '.$content_id.')';
				}
			}

			if ($sql != '') {
				/* delete the old related content */
				$result	= mysql_query("DELETE FROM related_content WHERE content_id=$content_id OR related_content_id=$content_id", $this->db);

				/* insert the new, and the old related content again */
				$sql	= 'INSERT INTO related_content VALUES '.$sql;
				$result	= mysql_query($sql, $this->db);
			}
		}
	}


	function deleteContent($content_id) {
		if ( $_SESSION['is_admin'] != 1) {
			return false;
		}

		/* check if exists */
		$sql	= "SELECT ordering, content_parent_id FROM content WHERE content_id=$content_id AND course_id=$_SESSION[course_id]";
		$result	= mysql_query($sql, $this->db);
		if (!($row = mysql_fetch_array($result)) ) {
			return false;
		}
		$ordering			= $row['ordering'];
		$content_parent_id	= $row['content_parent_id'];

		/* check if this content has sub content	*/
		$children = $this->_menu[$content_id];

		if (is_array($children) && (count($children)>0) ) {
			/* delete its children recursively first*/
			foreach ($children as $x => $info) {
				$this->deleteContentRecursive($info['content_id']);
			}
		}

		/* delete this content page					*/
		$sql	= "DELETE FROM content WHERE content_id=$content_id AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $this->db);

		/* delete this content page					*/
		$sql	= "DELETE FROM related_content WHERE content_id=$content_id OR related_content_id=$content_id";
		$result = mysql_query($sql, $this->db);

		/* re-order the rest of the content */
		$sql = "UPDATE content SET ordering=ordering-1 WHERE ordering>=$ordering AND content_parent_id=$content_parent_id AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $this->db);
		/* end moving block */

		return true;
	}


	/* private. call from deleteContent only. */
	function deleteContentRecursive($content_id) {
		/* check if this content has sub content	*/
		$children = $this->_menu[$content_id];

		if (is_array($children) && (count($children)>0) ) {
			/* delete its children recursively first*/
			foreach ($children as $x => $info) {
				$this->deleteContent($info['content_id']);
			}
		}

		/* delete this content page					*/
		$sql	= "DELETE FROM content WHERE content_id=$content_id AND course_id=$_SESSION[course_id]";
		$result = mysql_query($sql, $this->db);

		$sql	= "DELETE FROM related_content WHERE content_id=$content_id OR related_content_id=$content_id";
		$result = mysql_query($sql, $this->db);
	}


	function & getContentPage($content_id) {
		$sql	= "SELECT *, release_date+0 AS r_date, NOW()+0 AS n_date FROM content WHERE content_id=$content_id AND course_id=$this->course_id";
		$result = mysql_query($sql, $this->db);

		return $result;
	}


	function getRelatedContent($content_id, $all=false) {
		if ($content_id == '') {
			return;
		}
		$related_content = array();

		if ($all) {
			$sql = "SELECT * FROM related_content WHERE content_id=$content_id OR related_content_id=$content_id";
		} else {
			$sql = "SELECT * FROM related_content WHERE content_id=$content_id";
		}
		$result = mysql_query($sql, $this->db);

		while ($row = mysql_fetch_array($result)) {
			if ($row['related_content_id'] != $content_id) {
				$related_content[] = $row['related_content_id'];
			} else {
				$related_content[] = $row['content_id'];
			}
		}

		return $related_content;
	}


	function & cleanOutput($value) {
		return stripslashes(htmlspecialchars($value));
	}

	function getAllowedTags() {
		return $this->allowed_tags;
	}

	function getNumSections() {
		return $this->num_sections;
	}

	function getMaxDepth() {
		return $this->max_depth;
	}

	function getContentLength() {
		return $this->content_length;
	}

	function getLocationPositions($parent_id, $content_id) {
		$siblings = $this->getContent($parent_id);
		for($i=0;$i<count($siblings); $i++){
			if ($siblings[$i]['content_id'] == $content_id) {
				return $i;
			}
		}
		return 0;	
	}

	function getPreviousContent($content_id, $order=0) {
		$myParent = $this->_menu_info[$content_id]['content_parent_id'];
		$myOrder  = $this->_menu_info[$content_id]['ordering'];

		if (($this->_menu[$myParent][$myOrder-2] != '') && ($order==0)) {
			// has sibling: checking if sibling has children
			
			$mySibling = $this->_menu[$myParent][$myOrder-2];
			
			if ( is_array($this->_menu[$mySibling[content_id]]) && ($order==0) ) {
				$num_children = count($this->_menu[$mySibling[content_id]]);

				// sibling has $num_children children
				
				return ($this->getPreviousContent($this->_menu[$mySibling[content_id]][$num_children-1][content_id], 1));
			} else {
				// sibling has no children. return it
				return($this->_menu[$myParent][$myOrder-2]);
			}

		} else {
			if ($myParent == 0) {
				/* we're at the top */
				return '';
			}

			// No more siblings
			if ($order == 0) {
				return(array('content_id'=> $myParent,
					 	 'ordering'	=> $this->_menu_info[$myParent]['ordering'],
						'title'		=> $this->_menu_info[$myParent]['title']));
			} else {
				if ( is_array($this->_menu[$content_id]) ) {
					$num_children = count($this->_menu[$content_id]);
					return ($this->getPreviousContent($this->_menu[$content_id][$num_children-1][content_id], 1));
				} else {
					// no children
					return(array('content_id'=> $content_id,
					 	 'ordering'	=> $this->_menu_info[$content_id]['ordering'],
						 'title'		=> $this->_menu_info[$content_id]['title']));
				}
			}
		}
	}

	function getNextContent($content_id, $order=0) {
		$myParent = $this->_menu_info[$content_id]['content_parent_id'];
		$myOrder  = $this->_menu_info[$content_id]['ordering'];

		// if this content has children, then take the first one.
		if ( is_array($this->_menu[$content_id]) && ($order==0) ) {
			// has children
			return($this->_menu[$content_id][0]);
		}

		else {
			// no children
			if ($this->_menu[$myParent][$myOrder] != '') {
				// Has sibling
				return($this->_menu[$myParent][$myOrder]);
			} else {
				// No more siblings
				if ($myParent != 0) {
					return ($this->getNextContent($myParent, 1));
				}
			}
		}
	}

	function generateSequenceCrumbs($cid) {
		$next_prev_links = '';
		global $_template;

		/* previous link */
		$previous = $this->getPreviousContent($_SESSION['s_cid']);
		
		$next_prev_links .= '<td>';
		$next_prev_links .= '<table border="0" width="100%" cellspacing="0" cellpadding="0" background="images/menu/nextprev_bg.gif"><tr>';

		if ($previous != '') {
			$previous['title'] = rtrim(substr($previous['title'], 0, 30)).'...';
			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 2) {
				$next_prev_links .= '<td width="18"><a href="./?cid='.$previous['content_id'].SEP.'g=7" accesskey="8" title="'.$_template['previous'].': '.$previous['title'].' ALT-8"><img src="images/previous.gif" class="menuimage" border="0" alt="'.$_template['previous'].': '.$previous['title'].'" /></a></td>'."\n";
			}

			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 1) {
				$next_prev_links .= ' <td align="left">&nbsp;<a class="breadcrumbs" href="./?cid='.$previous['content_id'].SEP.'g=7" accesskey="8" title="'.$_template['previous'].': ALT-8"> '.$_template['previous'].': '.$previous[title].'</a></td></td>'."\n";
			}
		} else if ($cid != 0) {
			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 2) {
				$next_prev_links .= '<td width="18"><a href="./?g=7" accesskey="8" title="'.$_template['previous'].': Home"><img src="images/previous.gif" class="menuimage" border="0" alt="'.$_template['previous'].': '.$_template['home'].' ALT-8" /></a></td>'."\n";
			}

			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 1) {
				$next_prev_links .= ' <td align="left">&nbsp;<a class="breadcrumbs" href="./?g=7" accesskey="8" title="'.$_template['previous'].' ALT-8"> '.$_template['previous'].': '.$_template['home'].'</a></td>'."\n";
			}
		} else {
			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 2) {
				$next_prev_links .= '<td width="18"><img src="images/previous.gif" class="menuimage" border="0" alt="'.$_template['previous_none'].'" title="'.$_template['previous_none'].'" style="filter:alpha(opacity=40);-moz-opacity:0.4" /></td>'."\n";
			}
			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 1) {
				$next_prev_links .= ' <td align="left">&nbsp;<small class="bigspacer"> '.$_template['previous_none'].'</small></td>';
			}
		}
		
		//$next_prev_links .= '</td><td>';


		//$next_prev_links .= ' <span class="spacer">|</span> ';

		/* resume link */
		if ($_SESSION['s_cid'] != $cid) {
			$next_prev_links .= ' ';
			$rtitle = ($this->_menu_info[$_SESSION['s_cid']]['title']);
			$rtitle = rtrim(substr($rtitle, 0, 30)).'...';
			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 2) {
				$next_prev_links .= '<td align="right"><a href="./?cid='.$_SESSION['s_cid'].SEP.'g=7" accesskey="0" title="'.$_template['resume'].': '.$rtitle.' ALT-0"><img src="images/resume.gif" class="menuimage" border="0" alt="'.$_template['resume'].': '.($this->_menu_info[$_SESSION['s_cid']]['title']).' ALT-0"/></a></td>'."\n";
			}

			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 1) {
				$next_prev_links .= ' <td align="right"><a href="./?cid='.$_SESSION['s_cid'].SEP.'g=7" accesskey="0" title="'.$_template['resume'].': Accesskey ALT-0">'.$_template['resume'].': '.rtitle.'</a></td>'."\n";
			}

			//$next_prev_links .= ' <span class="spacer">|</span> ';
		}
		
		$next_prev_links .= '</td><td>';

		/* next link */
		$next = $this->getNextContent($_SESSION['s_cid'] ? $_SESSION['s_cid'] : 0);

		if ($next != '') {
			$next['title'] = rtrim(substr($next['title'], 0, 30)).'...';
			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 1) {
				$next_prev_links .= '<td align="right"><a class="breadcrumbs" href="./?cid='.$next['content_id'].SEP.'g=7" accesskey="9" title="'.$_template['next'].':  ALT-9">'.$_template['next'].': '.$next['title'].' </a>&nbsp;</td>'."\n";
			}

			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 2) {
				$next_prev_links .= ' <td width="18"><a href="./?cid='.$next['content_id'].SEP.'g=7" accesskey="9" title="'.$_template['next'].': '.$next['title'].'  ALT-9"><img src="images/next.gif" class="menuimage" border="0" alt="'.$_template['next'].': '.$next['title'].'"/></a></td>'."\n";
			}
		} else {
			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 1) {
				$next_prev_links .= '<td align="right"><small class="bigspacer">'.$_template['next_none'].' </small>&nbsp;</td> ';
			}

			if ($_SESSION['prefs'][PREF_SEQ_ICONS] != 2) {
				$next_prev_links .= '<td width="18"><img src="images/next.gif" class="menuimage" border="0" alt="'.$_template['next_none'].'" style="filter:alpha(opacity=40);-moz-opacity:0.4" /></td>'."\n";
			}
		}
		$next_prev_links .= '</tr></table>';
		$next_prev_links .= '</td>';

		return $next_prev_links."\n";
	}
}
