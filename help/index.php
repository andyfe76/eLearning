<?php
/****************************************************************/
/* klore														*/
/****************************************************************/



$section = 'help';
$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['help'];

require ($_include_path.'header.inc.php');
?>

<h2><?php  echo $_template['help']; ?></h2>

<?php

require($_include_path.'language/ro_helppage.inc.php');

require($_include_path.'footer.inc.php');
?>
