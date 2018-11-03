<?php

$_include_path = '../include/';
require($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['tools'];

require($_include_path.'header.inc.php');


?>

<h2><?php echo $_template['tools'];  ?></h2>
<?php
include($_include_path.'language/en_studenttools_page.inc.php');

if ($_SESSION['is_admin']) {
	echo '<h2>'.$_template['instructor_tools'].'</h2>';
	include($_include_path.'language/en_instrtools_page.inc.php');
}

	require($_include_path.'footer.inc.php');
?>
