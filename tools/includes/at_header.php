<?php if ($_GET['frame'] == 1) {
	$_header_file = 'html/frameset/header.inc.php';
	$_footer_file = 'html/frameset/footer.inc.php';
} else {
	$_header_file = 'header.inc.php';
	$_footer_file = 'footer.inc.php';
}

require($_include_path.$_header_file);

if (!$_SESSION['is_admin']) {
	$errors[]=AT_ERROR_ACCESS_DENIED;
	print_errors($errors);
	require($_include_path.$_footer_file);
	exit;
}
?>