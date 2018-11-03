<?php
$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');
$_SESSION['s_is_super_admin'] = false;

if ($_POST['ok']){
	$sql = "SELECT * FROM course_options";
	$res = mysql_query($sql, $db);
	while( $row = mysql_fetch_array($res) ){
		$value = $_POST[$row['name']];
		$sql = "UPDATE course_options SET value='$value' WHERE name='$row[name]'";
		$update = mysql_query($sql, $db);
	}
	Header ('Location: '.$_base_href.'users/coursemng.php?f='.urlencode_feedback(AT_FEEDBACK_COURSE_OPTIONS));
}

require($_include_path.'cc_html/header.inc.php');

print_errors($errors);
?>
<h1 class="center"><?php echo $_template['control_centre'].' - '.$_template['course_management'];  ?></h1><br>
<br>

<?php
	$sql = "SELECT * FROM course_options";
	$res = mysql_query($sql, $db);
	echo '<form name="test_admin" action="'.$PHP_SELF.'" method="post">';
	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="350" summary="">';
	echo '<tr><th colspan="2">';
	echo '<h3>'.$_template['test_options'].':</h3>';
	echo '</th></tr>';
	while( $row = mysql_fetch_array($res) ) {
		echo '<tr><td class="row1">';
		if( $row['type'] == 'checkbox' ){
			echo '<input type="checkbox" name="'.$row['name'].'" value="1"';
			if ($row['value'] <> '') echo ' checked="checked"';
			echo '>';
		} else if( $row['type'] == 'radio' ) {
			
		} else if( $row['type'] == 'select' ) {
			
		} else if( $row['type'] == 'text' ) {
			echo '&nbsp;';
		}
	
		echo '</td><td class="row1">';

		if( $row['type'] == 'checkbox' ){
			echo $_template[ $row['name'] ];
		} else if( $row['type'] == 'radio' ){
			echo $_template[ $row['name'] ];
		} else if( $row['type'] == 'text' ) {
			echo '<br><input type="text" name="'.$row['name'].'" value="'.$row['value'].'">';
		} else if( $row['type'] == 'select' ) {
			echo '<br><input type="select" name="'.$row['name'].'" class="dropdown">';
			echo $row['value'];
		}
		
		echo '</td></tr>';
	}
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td colspan="2" align="center" class="row1"><input type="submit" name="ok" id="ok" class="button" value="'.$_template['submit'].'"></td></tr>';		
	echo '</table><br>';
	echo '</form>';

	require ($_include_path.'cc_html/footer.inc.php');
?>