<?php
global $db;
		
	echo '<table border="0" align="center" width="100%"><tr><td align="center">';
	echo '<small class="spacer">';
	echo AT_date($_SESSION['lang'], $_template['announcement_date_format']);
	echo '</small>';

	echo '<h1>'.$_SESSION[course_title];
	if (!$_SESSION['is_admin'] && !$_SESSION['enroll']) {
		echo '<small> - ';
		echo '<a href="./enroll.php?course='.$_SESSION[course_id].'">'.$_template['enroll'].'</a></small>';
	}
	echo ' - '.$_template['announcements'];
	echo '</h1>';
	echo '</td></tr></table>';
	?>
	<center>
	<a href="/start_course.php"><img border="0" src="images/start_curs.jpg"></a>
	</center>
	
	<?php 
	//help for content pages
	if ($_SESSION['is_admin'] || $_SESSION['c_instructor']) {
		if ($_SESSION['prefs'][PREF_MENU]==1){
			$help[] = AT_HELP_ADD_ANNOUNCEMENT2;
		} else {
			$help[] = AT_HELP_ADD_ANNOUNCEMENT;
		}
		$help[] = AT_HELP_ADD_TOP_PAGE;
	}
	echo '<br>';
	echo '<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td>';
	
	print_help($help);
	
	if (($_SESSION['is_admin'] == 1)) {
		echo '&nbsp;&nbsp;&nbsp;<small class="bigspacer"><a href="editor/add_news.php"><img src="images/newa.gif" border="0" alt="'.$_template['add_announcement'].'"></a>&nbsp;<a href="editor/add_new_content.php"><img src="images/new.gif" border="0" alt="'.$_template['add_top_page'].'"></a></small>';
	}


	/* cache $news here. */
	$sql = "SELECT * FROM news WHERE course_id=$_SESSION[course_id] ORDER BY data";
	$result = $db->query($sql);
	
	//echo '<table border="0" cellspacing="1" cellpadding="0" width="98%">';
	//echo '<tr><td class="row3" height="1" valign="top"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	//echo '</table>';
//	echo '<br>';
	$countsql = "SELECT COUNT(*) FROM (".$sql.")";
	$countres = $db->query($countsql);
	$count0 = $countres->fetchRow();

	if ($count0[0] == 0) {
		echo '<i>'.$_template['no_announcements'].'</i>';
	} else {
		$news = array();

		
		/* $news[] = array(news_id, course_id, member_id, date, title, body, author) */
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			
					
		//***
									
			$fh = fopen($row['BODY'], 'r');  
        	$row['BODY'] = fread($fh, filesize($row['BODY']));
        	fflush($fh);
     		fclose($fh);
		
		//***
		
			$news[] = array('news_id'	=> $row['NEWS_ID'], 
							'course_id' => $row['COURSE_ID'],
							'data'		=> AT_date(	$_SESSION['lang'], 
													$_template['announcement_date_format'], 
													$row['DATA'], 
													AT_MYSQL_DATETIME),
 							'title'		=> $row['TITLE'],
							'body'		=> $row['BODY'],
							'formatting'=> $row['FORMATTING']);
		}
		
		echo '<table border="0" cellspacing="1" cellpadding="0" width="98%" summary="">';
		
		require($_include_path.'lib/format_content.inc.php');

		foreach ($news as $x => $news_item) {
			echo '<tr>';
			echo '<td>';
			echo '<br>';
			echo '<table border="0" cellspacing="1" cellpadding="0" class="bodyline" width="98%"><tr><td>';
			echo '<h2>'.$news_item['title'].'&nbsp;&nbsp;&nbsp;';
			if (($_SESSION['is_admin'])) {
				echo '<small class="bigspacer"><a href="editor/edit_news.php?aid='.$news_item['news_id'].'"><img src="images/kedit.jpg" border="0" alt="'.$_template['edit'].'"></a>';
				echo '</td><td align="right">';
				echo '&nbsp;<a href="editor/delete_news.php?aid='.$news_item['news_id'].'"><img src="images/kdelete.jpg" border="0" alt="'.$_template['delete'].'"></a></small>';
			}
			echo '</td></tr></table>';
			echo '</h2>';
			echo '<small class="date">'.$_template['posted'].' '.$news_item['date'].'</small><br><br>';
 
			$news_item['body'] = str_replace('CONTENT_DIR', 'content/'.$_SESSION['course_id'], $news_item['body']);
			$news_item['body'] = str_replace('\"', '"', $news_item['body']);

			echo '<table border="0" cellspacing="1" cellpadding="0" width="98%"><tr><td>';
			echo format_content($news_item['body'], $news_item['formatting']);
			echo '</td></tr></table>';
			echo '<br>';
			echo '</td>';
			echo '</tr>';
			//echo '<tr><td class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
		}
		echo '</table>';
	}
	//echo '</td></tr></table>';

?>
