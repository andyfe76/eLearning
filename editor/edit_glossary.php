<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	if ($_POST['cancel']) {
		Header('Location: ../glossary/?L='.strtoupper(substr($_POST['word'], 0, 1)).SEP.'f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
		exit;
	}

	if ($_POST['submit']) {
		$_POST['word']			= str_replace('<', '&lt;', trim($_POST['word']));
		$_POST['definition']	= str_replace('<', '&lt;', trim($_POST['definition']));

		if ($_POST['word'] == '') {
			$errors[]=AT_ERROR_TERM_EMPTY;
		}

		if ($_POST['definition'] == '') {
			$errors[]=AT_ERROR_DEFINITION_EMPTY;

		}

		$_POST['related_term'] = intval($_POST['related_term']);

		/*
		if ($glossary[$_POST['word']] != '' ) {
			$error .= '<li>The term already exists.</li>';
		}
		*/

		if (!$errors) {
			$sql = "UPDATE glossary SET word='$_POST[word]', definition='$_POST[definition]', related_word_id=$_POST[related_term] WHERE word_id=$_POST[gid] AND course_id=$_SESSION[course_id]";
			
			$result = $db->query($sql);

			Header('Location: ../glossary/?L='.strtoupper(substr($_POST['word'], 0, 1)).SEP.'f='.urlencode_feedback(AT_FEEDBACK_GLOS_UPDATED));
			exit;
		}
	}

	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';
	$_section[1][0] = $_template['glossary'];
	$_section[1][1] = 'glossary/';
	$_section[2][0] = $_template['edit_glossary'];

	$onload = 'onLoad="document.form.title.focus()"';

	require($_include_path.'header.inc.php');

	echo '<h2>'.$_template['edit_glossary'].'</h2>';

	if ($_POST['submit']) {
		$gid = intval($_POST['gid']);
	} else {
		$gid = intval($_GET['gid']);
	}

	if ($gid == 0) {
		$errors[]=ERROR_GLOS_ID_MISSING;
		print_errors($errors);
		require ($_include_path.'footer.inc.php');
		exit;
	}


	print_errors($errors);


	echo '<form action="'.$PHP_SELF.'" method="post" name="form">';

	$result = $db->query("SELECT * FROM glossary WHERE word_id=$gid");

	if (!( $row =$result->fetchRow(DB_FETCHMODE_ASSOC)) ) {
		$errors[]=AT_ERROR_TERM_NOT_FOUND;
		print_errors($errors);
		require ($_include_path.'footer.inc.php');
		exit;
	}

	if ($_POST['submit']) {
		$row['WORD']		= $_POST['word'];
		$row['DEFINITION']  = $_POST['definition'];
	}

?>
<input type="hidden" name="gid" value="<?php echo $gid; ?>">
<p>
<table cellspacing="1" cellpadding="0" border="0" class="bodyline" summary="" align="center">
<tr>
	<th colspan="2" class="left"><?php echo $_template['edit_glossary'];  ?></th>
</tr>
<tr>
	<td align="right" class="row1"><b><label for="title"><?php echo $_template['glossary_term'];  ?>:</label></b></td>
	<td class="row1"><input type="text" name="word" size="40" id="title" class="formfield" value="<?php echo $row['WORD']; ?>"></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td valign="top" align="right" class="row1"><b><label for="body"><?php echo $_template['glossary_definition'];?>:</label></b></td>
	<td class="row1"><textarea name="definition" class="formfield" cols="55" rows="7" id="body" wrap="wrap"><?php echo $row['DEFINITION']; ?></textarea></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td valign="top" align="right" class="row1"><b><?php echo $_template['glossary_related'];  ?>:</b></td>
	<td class="row1"><?php

			$sql = "SELECT * FROM glossary WHERE course_id=$_SESSION[course_id] AND word_id<>$gid ORDER BY word";
			$result = $db->query($sql);
			if ($row_g =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				echo '<select name="related_term">';
				echo '<option value="0"></option>';
				do {
					if ($row_g['WORD_ID'] == $row['WORD_ID']) {
						continue;
					}
					echo '<option value="'.$row_g[WORD_ID].'"';
					if ($row_g['WORD_ID'] == $row['RELATED_WORD_ID']) {
						echo ' selected';
					}
					echo '>'.$row_g[WORD].'</option>';
				} while ($row_g =$result->fetchRow(DB_FETCHMODE_ASSOC));
				echo '</select>';
			} else {
				echo 'None available.';
			}
	?><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td colspan="2" align="center" class="row1"><br /><input type="submit" name="submit" value="<?php echo $_template['edit_glossary'];  ?>[Alt-s]" accesskey="s" class="button"> - <input type="submit" name="cancel" class="button" value="<?php echo $_template['cancel'];  ?>" /></td>
</tr>
</table>

</p>
</form>

<?php
	require ($_include_path.'footer.inc.php');
?>
