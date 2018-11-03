<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002, 2003 by Greg Gay & Joel Kronenberg       */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/
?>
<?php
require('include/vitals.inc.php')
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<title><?php echo $_template['file_manager_frame']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
</head>
<frameset cols="20%, *" border="1" frameborder="0" framespacing="0">
	<frame marginwidth="0" marginheight="0" frameborder="0" src="tools/file_manager.php?frame=1" name="frame" title="<?php echo $_template['file_manager_frame']; ?>">
	<frame marginwidth="0" marginheight="0" frameborder="0" src="<?php echo urldecode($_GET['p']); ?>" name="content" title="<?php echo $_template['file_content_frame']; ?>">
	<noframes>
      <p><?php echo $_template['frame_contains']; ?><br />
	  * <a href="tools/file_manager.php"><?php echo $_template['file_manager']; ?></a>
	  * <a href="<?php echo urldecode($_GET['p']); ?>"><?php echo $_template['klore_content']; ?>/a>
	  </p>
  </noframes>
</frameset>
</html>
