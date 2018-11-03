<?php

 /******************************************************************
  *
  * Terracotta Personal Edition (published under GNU/GPL)
  * Version 0.6 Created on 12th October 2002
  * This project is proudly sponsored by Eternity Technologies
  * vist them at http://eternitytechnologies.com/
  *
  * Created by Devraj MUKHERJEE (devraj@eternitytechnologies.com)
  * Copyright (c) 2002 Eternity Technologies
  *
  * All source code published as a part of the Terracotta PE project
  * is copyright Eternity Technologies. All source code related to this
  * project is released under the GNU/GPL and free use is thereby granted
  * for commerical and personal use.
  *
  * This product does not comes with any garuntee or support. Please use
  * it at your own risk. Official resources for support may be obtained
  * from http://terracotta.sourceforge.net/
  *
  * For further information get in touch with the Terracotta Open
  * Source Edn Team at terracotta-devel@lists.sourceforge.net or
  * visit Terracotta on the web at http://terracotta.sourceforge.net/
  *
  * File:        verify_functions.php
  * Created by:  Devraj MUKHERJEE
  * Created on:  4th November 2002
  *
  * Summary:     Produces a report if all the required functions
  *              are available in the PHP installation.
  *
  ******************************************************************/
  
  $RequiredVersionOfPHPEngine = "4.1.0";
  
  $FunctionList = array("array_search",
                        "is_dir",
                        "closedir",
                        "rmdir",
                        "mkdir",
                        "unlink",
                        "substr",
                        "strlen",
                        "str_replace",
                        "set_time_limit",
                        "set_magic_quotes_runtime",
                        "uniqid",
                        "strrchr"
                       );

?>

<html>
<head>
 <title>Terracotta 0.6 PHP Function validation utility</title>
</head>


<body bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000">
<font face="Verdana" size="2">
<b>Terracotta 0.6 PHP Function validation utility</b><br/>
Author: Devraj Mukherjee (devraj@eternitytechnologies.com)<br/>
<a href="http://terracotta.sourceforge.net/">http://terracotta.sourceforge.net/</a><br/><br/>

This script will produce a list of all functions required by Terracotta 0.6 to run
on your server and will let you know if you can get around it by changing settings
in the configuration file. This script does not depend on the libraires provided by
the Terracotta project and is thus not available in multiple languages. <i>We also
recommend that you delete this script once you have successfully installed the product
on your server.</i><br/><br/>

<b>Server Information:</b> <?php echo $_SERVER["SERVER_SOFTWARE"]; ?> on <?php echo php_uname(); ?><br/>
<b>Server Protocol Information:</b> <?php echo $_SERVER["SERVER_PROTOCOL"]; ?><br/><br/>

<?php 

 if($RequiredVersionOfPHPEngine > phpversion()) {
   echo "Terracotta 0.6 was developed on the specfications of PHP $RequiredVersionOfPHPEngine";
 }
 else {
   echo "The PHP Engine version has been found compatible with the recommedation of Terracotta 0.6 (Recommended version $RequiredVersionOfPHPEngine and above, your server is running ".phpversion().")"; 
 }

?>

<br/><br/>

<table border="0" cellpadding="2" cellspacing="2" width="40%">

<tr>
 <td bgcolor="#000000">
  <font face="Verdana" size="2" color="#FFFFFF">
  <b>Function Name</b>
  </font>
 </td>
 <td bgcolor="#000000">
  <font face="Verdana" size="2" color="#FFFFFF">
   <b>Status</b>
  </font>
 </td>
</tr>

<?php

 foreach($FunctionList as $Function) {

?>

<tr>
 <td bgcolor="#DDDDDD">
  <font face="Verdana" size="2">
  <b><?php echo $Function; ?></b>
  </font>
 </td>
 <td bgcolor="#EEEEEE">
  <font face="Verdana" size="2">
   <?php if(function_exists($Function)) echo "Available"; else echo "<b>Not Available</b>"; ?>
  </font>
 </td>
</tr>

<?php

 }
 
?>
</table>
<br/><br/>

<?php phpinfo(INFO_MODULES); ?>

<br/><br/>

This is just to give you a general idea of your PHP installation, this report does not
garuntee anything and has been designed to help you out with debugging and finding
solutions to installation problems<br/><br/>

This report was generated for the web server running on <?php echo $_SERVER["SERVER_NAME"]; ?><br/>
&copy; 2002 The Terracotta Project and Eternity Technologies<br/>
Distributed under GNU/GPL<br/><br/>

</font>
</body>
</html>