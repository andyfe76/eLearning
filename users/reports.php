<?php
$section = 'users';
$_include_path = '../include/';

	require($_include_path.'vitals.inc.php');
		echo '<frameset rows="103,*" framespacing="0" border="0" frameborder="0">';
  		echo '<frame name="header" scrolling="no" noresize target="main" src="'.$_include_path.'cc_html/header.inc.php'.'">';
		echo '<frame name="main" src="'.SERVER_IIS.'">';
?>
  <noframes>
  <body>
  <p>This page uses frames, but your browser doesn't support them.</p>

  </body>
  </noframes>
</frameset>
