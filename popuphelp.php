<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



	$_include_path = 'include/';
	$_section[0][0] = 'Pop-Up Help';

	$_ignore_page = true; /* used for the close the page option */
	require ($_include_path.'vitals.inc.php');

	$_GET['h'] = intval($_GET['h']);


	//require ($_include_path.'header.inc.php');
	?>

<html>
<head><title><?php echo $_template['klore_help_window']; ?></title>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<style type="text/css">
* {font-size: 8pt}
</style>
</head>
<body>
[<a href="javascript:window.close()"><?php echo $_template['close_help_window']; ?></a>]
	<?php

	print_help($_GET['h']);

//	require ($_include_path.'footer.inc.php');
?>
</body>
</html>
