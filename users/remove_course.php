<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'cc_html/header.inc.php');
?>
<h2>Remove Course</h2>

<?php

	$course = intval($_GET['course']);

	if (!$d) {
	$warnings[]=array(AT_WARNING_REMOVE_COURSE,$system_courses[$course][title]);
	print_warnings($warnings);

?>

		<a href="<?php echo $PHP_SELF.'?course='.$course.SEP.'d=1'; ?>">Yes, Delete</a> | <a href="users/?f=<?php echo urlencode_feedback(AT_FEEDBACK_CANCELLED); ?>">No, Cancel</a>
<?php
	} else {
		$sql	= "DELETE FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";

		$result = $db->query($sql);
		

		if ($result) {
			$feedback[]=AT_FEEDBACK_COURSE_REMOVED;
			print_feedback($feedback);
		} else {
			$errors[]=AT_ERROR_REMOVE_COURSE;
			print_errors($errors);
		}
		echo '<br />Return <a href="users/">home</a>.';
	}

require ($_include_path.'cc_html/footer.inc.php'); 
?>
