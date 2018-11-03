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

$section = 'help';
$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');

$_section[0][0] = $_template['help'];

require ($_include_path.'header.inc.php');
?>

<h2><?php  echo $_template['help']; ?></h2>

<?php

require($_include_path.'language/en_helppage.inc.php');

require($_include_path.'footer.inc.php');
?>
