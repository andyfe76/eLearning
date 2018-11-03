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

$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] = $_template['glossary'];

require ($_include_path.'header.inc.php');
print_feedback($feedback);
?>
<h2><a href="tools/?g=11"><?php echo $_template['tools']; ?></a></h2>
<h3><?php echo $_template['glossary']; ?></h3>
<p>Browse the glossary by letter or view all.</p>
<br />

<?php
	
	$letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', $_template['others'], $_template['all']);

	echo '<div align="center">';

	$letter			 = '';
	$letter_sql		 = '';
	$next_letter_sql = '';
	//jump over the glossary index
	echo '<a href="glossary/#list"><img src="images/clr.gif" border="0" height="1" width="1" alt="'.$_template['skip_index'].'" /></a>';
	for($i=0; $i<28; $i++) {
		echo '<a href="'.$PHP_SELF.'?L='.$letters[$i].'#list">';
		if ($letters[$i] == $_GET['L']) {
			echo '<b>'.$letters[$i].'</b>';

			$letter = $letters[$i];
			if ($i < 26) {
				$letter_sql = " AND word>='$letter'";
			}
			if ($i < 25) { 
				$next_letter_sql = " AND word<'{$letters[$i+1]}'";
			}
		} else {
			echo $letters[$i];
		}

		echo '</a>';
		
		if ($i < 27) {
			echo ' | ';
		}
	}

	echo '</div>';

	/* admin editing options: */
	if (($_SESSION['is_admin']) && ($_SESSION['prefs'][PREF_EDIT])) {
		echo '<br />';
		echo '<a href="editor/add_new_glossary.php">'.$_template['add_glossary'].'</a>';
		echo '<br />';
		echo '<br />';
	}

	echo '<a name="list"></a>';
	if ($letter != '') {
		if ($letter == 'Other') {
			$letter_sql = 'AND word<\'a\' || word>\'zzzz\'';
		}

		$sql	= "SELECT word_id, related_word_id FROM glossary WHERE related_word_id>0 AND course_id=$_SESSION[course_id] ORDER BY related_word_id";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)) {
			$glossary_related[$row['related_word_id']][] = $row['word_id'];
		}

		$sql	= "SELECT * FROM glossary WHERE course_id=$_SESSION[course_id] $letter_sql $next_letter_sql ORDER BY word";
		$result= mysql_query($sql);
		if(mysql_num_rows($result) > 0){
		
			$current_letter = '';
			while ($row = mysql_fetch_array($result)) {
				if ($current_letter != strtoupper(substr($row['word'], 0, 1))) {
					$current_letter = strtoupper(substr($row['word'], 0, 1));
					echo '<h3>- '.$current_letter.' -</h3>';
				}
				echo '<p>';
				echo '<a name="'.urlencode($row['word']).'"></a>';

				echo '<b>'.stripslashes($row['word']);

				if (	($row['related_word_id'] != 0) 
					|| 
						(is_array($glossary_related[$row['word_id']]) )) {

					echo ' ('.$_template['see'].': ';

					$output = false;

					if ($row['related_word_id'] != 0) {
						echo '<a href="'.$PHP_SELF.'?L='.strtoupper(substr($glossary_ids[$row['related_word_id']], 0, 1)).'#'.urlencode($glossary_ids[$row['related_word_id']]).'">'.$glossary_ids[$row['related_word_id']].'</a>';
						$output = true;
					}

					if (is_array($glossary_related[$row['word_id']]) ) {
						$my_related = $glossary_related[$row['word_id']];

						$num_related = count($my_related);
						for ($i=0; $i<$num_related; $i++) {
							if ($output) {
								echo ', ';
							}

							echo '<a href="'.$PHP_SELF.'?L='.strtoupper(substr($glossary_ids[$my_related[$i]], 0, 1)).'#'.urlencode($glossary_ids[$my_related[$i]]).'">'.$glossary_ids[$my_related[$i]].'</a>';

							$output = true;
						}
					}

					echo ')';
				}
				echo '</b>';

				/* admin editing options: */
				if (($_SESSION['is_admin']) && ($_SESSION['prefs'][PREF_EDIT])) {
					echo ' <small>(';
					echo '<a href="editor/edit_glossary.php?gid='.$row['word_id'].'">'.$_template['edit_this_term'].'</a>';
					echo ' | ';
					echo '<a href="editor/delete_glossary.php?gid='.$row['word_id'].SEP.'t='.urlencode($row['word']).'">'.$_template['delete_this_term'].'</a>';
					echo ')</small>';
				}


				echo '<br />';
				echo stripslashes($row['definition']);
				echo '</p>';
				echo '<br />';
			}
		}else{
			$infos[]=array(AT_INFOS_NO_TERMS, $_GET['L']);
			print_infos($infos);

		}
	}

	require($_include_path.'footer.inc.php');
?>
