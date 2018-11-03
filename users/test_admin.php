<?php
$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');
$_SESSION['s_is_super_admin'] = false;

if ($_POST['ok']){
	$sql = "SELECT * FROM course_options";
	$res = $db->query($sql);
	while( $row =$res->fetchRow(DB_FETCHMODE_ASSOC) ){
		$value = $_POST[$row['NAME']];
		$sql = "UPDATE course_options SET value='$value' WHERE name='$row[NAME]'";
		$update = $db->query($sql);
		if(PEAR::isError($update)) {
			print_r($update);
			exit;
		}
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
	$res = $db->query($sql);
	echo '<form name="test_admin" action="'.$PHP_SELF.'" method="post">';
	echo '<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="350" summary="">';
	echo '<tr><th colspan="2">';
	echo '<h3>'.$_template['test_options'].':</h3>';
	echo '</th></tr>';
	while( $row =$res->fetchRow(DB_FETCHMODE_ASSOC) ) {
		echo '<tr><td class="row1">';
		if( $row['TYPE'] == 'checkbox' ){
			echo '<input type="checkbox" name="'.$row['NAME'].'" value="1"';
			if ($row['VALUE'] <> '') echo ' checked="checked"';
			echo '>';
		} else if( $row['TYPE'] == 'radio' ) {
			
		} else if( $row['TYPE'] == 'select' ) {
			
		} else if( $row['TYPE'] == 'text' ) {
			echo '&nbsp;';
		}
	
		echo '</td><td class="row1">';

		if( $row['TYPE'] == 'checkbox' ){
			echo $_template[ $row['NAME'] ];
		} else if( $row['TYPE'] == 'radio' ){
			echo $_template[ $row['NAME'] ];
		} else if( $row['TYPE'] == 'text' ) {
			echo '<br><input type="text" name="'.$row['NAME'].'" value="'.$row['VALUE'].'">';
		} else if( $row['TYPE'] == 'select' ) {
			echo '<br><input type="select" name="'.$row['NAME'].'" class="dropdown">';
			echo $row['VALUE'];
		}
		
		echo '</td></tr>';
	}
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td colspan="2" align="center" class="row1"><input type="submit" name="ok" id="ok" class="button" value="'.$_template['submit'].'"></td></tr>';		
	echo '</table><br>';
	echo '</form>';

	require ($_include_path.'cc_html/footer.inc.php');
?>
