<?php

 /*******************************************************************
  *
  * The Terracotta Document Management System
  * Personal Edition 0.6 Document Type declarations
  * http://terracotta.sourceforge.net
  *
  * Open Source Edition, released under the GNU/GPL
  *
  * Unless contributing to development of Terracotta please only modify
  * what is require to configure Terracotta to run on your web site.
  *
  * Created By Devraj Mukherjee (devraj@eternitytechnologies.com)
  * Copyright (c) 2002 Eternity Technologies
  *
  * This configuration is a sample configuration file, please configure
  * it to suit your needs, if you need to modify the template
  * please look in the template library
  *
  * This configuration file does require some knowledge of your OS and
  * PHP scripting. If you are not sure then please contact your ISP or
  * shoot your questions on the list serve.
  *
  * By default all settings are made for UNIX based servers
  * running the Apache web server 1.3.x (http://httpd.apache.org/)
  *
  * You can use international characters while writing the descriptive
  * names of the document type declarations.
  *
  *******************************************************************/

  /* This array declares the file types in the system
     please only edit if you are sure of what you are doing */

  $file_type_list = array(

    "folder"  => array("Folder","folder.gif"),
    "article" => array("Article","article.gif"),
    "link"    => array("Internet Link","link.gif"),

    "doc"     => array("Microsoft Word Document","ms-word.gif"),
    "ppt"     => array("Microsoft Powerpoint Presentation","ms-ppt.gif"),
    "xls"     => array("Microsoft Excel Spread Sheet","ms-excel.gif"),
    "exe"     => array("Microsoft Windows Executable","application.gif"),

    "tif"     => array("TIF Image","image.gif"),
    "psd"     => array("Adobe Photoshop Image","image.gif"),

    "pdf"     => array("Adobe Acrobat Document","ad-pdf.gif"),
    "mov"     => array("Apple Quicktime Movie","multimedia.gif"),

    "zip"     => array("ZIP Archive","zip.gif"),
    "gz"      => array("UNIX GZ archive","zip.gif")

  );
 
  
 /*******************************************************************
  * End of configuration file
  *******************************************************************/

?>