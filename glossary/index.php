<?php
/****************************************************************/
/* klore														*/
/****************************************************************/

$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] = $_template['glossary'];

require ($_include_path.'header.inc.php');
print_feedback($feedback);
?>
<h3><?php echo $_template['glossary']; ?></h3>
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
			$letter = $letters[$i];
			
			echo '<b>'.$letter.'</b>';

			if ($i < 26) {
				if ($letters[$i+1] == $_template['others']) {
					$letter_sql = " AND (((word>='z') AND (word<'1'))";
					$next_letter_sql = " OR ((word>='Z') AND (word<'a')))";
				} else {
					$letter_sql = " AND (((word>='".strtolower($letter)."') AND (word<'".strtolower($letters[$i+1])."'))";
				}
			}
			if ($i < 25) { 
				if ($letters[$i+1] == $_template['others']) {
					$letter_sql = " AND (((word>='z') AND (word<'1'))";
					$next_letter_sql = " OR ((word>='Z') AND (word<'a')))";
				} else {
					$next_letter_sql = " OR ((word>='".strtoupper($letter)."') AND (word<'".strtoupper($letters[$i+1])."')))";
				}
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
	if (($_SESSION['status']==STATUS_INSTRUCTOR) || ($_SESSION['status']==STATUS_ADMIN) || ($_SESSION['status']=STATUS_TRAINING_MANAGER)) {
		echo '<br />';
		echo '<a href="editor/add_new_glossary.php">'.$_template['add_glossary'].'</a>';
		echo '<br />';
		echo '<br />';
	}

	echo '<a name="list"></a>';
	if (isset($_GET['L'])) $letter = $_GET['L'];
	if ($letter != '') {
		if (($letter == $_template['others']) || ($letter<'A') || ($letter>'zzzz')) {
			$letter_sql = 'AND ((word<\'A\') OR (word>\'zzzz\'))';
		}

		$sql	= "SELECT word_id, related_word_id FROM glossary WHERE related_word_id>0 AND course_id=$_SESSION[course_id] ORDER BY related_word_id";
		$result = $db->query($sql);
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$glossary_related[$row['RELATED_WORD_ID']][] = $row['WORD_ID'];
		}

		$sql	= "SELECT * FROM glossary WHERE course_id=$_SESSION[course_id] $letter_sql $next_letter_sql ORDER BY word";
		$result= $db->query($sql);
		
		
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		if($count0[0] > 0){
		
			$current_letter = '';
			while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				if ($current_letter != strtoupper(substr($row['WORD'], 0, 1))) {
					$current_letter = strtoupper(substr($row['WORD'], 0, 1));
					echo '<h3>- '.$current_letter.' -</h3>';
				}
				echo '<p>';
				echo '<a name="'.urlencode($row['WORD']).'"></a>';

				echo '<b>'.stripslashes($row['WORD']);

				if (	($row['RELATED_WORD_ID'] != 0) 
					|| 
						(is_array($glossary_related[$row['WORD_ID']]) )) {

					echo ' ('.$_template['see'].': ';

					$output = false;

					if ($row['RELATED_WORD_ID'] != 0) {
						echo '<a href="'.$PHP_SELF.'?L='.strtoupper(substr($glossary_ids[$row['RELATED_WORD_ID']], 0, 1)).'#'.urlencode($glossary_ids[$row['RELATED_WORD_ID']]).'">'.$glossary_ids[$row['RELATED_WORD_ID']].'</a>';
						$output = true;
					}

					if (is_array($glossary_related[$row['WORD_ID']]) ) {
						$my_related = $glossary_related[$row['WORD_ID']];

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
				if (($_SESSION['status']==STATUS_INSTRUCTOR) || ($_SESSION['status']==STATUS_ADMIN) || ($_SESSION['status']=STATUS_TRAINING_MANAGER)) {
					echo ' <small>(';
					echo '<a href="editor/edit_glossary.php?gid='.$row['WORD_ID'].'">'.$_template['edit_this_term'].'</a>';
					echo ' | ';
					echo '<a href="editor/delete_glossary.php?gid='.$row['WORD_ID'].SEP.'t='.urlencode($row['WORD']).'">'.$_template['delete_this_term'].'</a>';
					echo ')</small>';
				}


				echo '<br />';
				echo stripslashes($row['DEFINITION']);
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
