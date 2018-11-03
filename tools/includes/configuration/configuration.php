<?php

 /*******************************************************************
  *
  * The Terracotta Document Management System
  * Personal Edition 0.6 Configuration File
  * http://terracotta.sourceforge.net/
  *
  * Personal Edition, released under the GNU/GPL (http://www.gnu.org/)
  *
  * Unless contributing to development of Terracotta please only modify
  * what is require to configure Terracotta to run on your web site.
  *
  * Created By Devraj Mukherjee (devraj@eternitytechnologies.com)
  * Copyright (c) 2002 Eternity Technologies
  * Copyright (c) 2002 The Terracotta Project
  *
  * These variables are requried to configure Terracotta to your needs
  * most of them have a one liner description of what they are and
  * what values they contain.
  *
  * This configuration file does require some knowledge of your OS and
  * PHP scripting. If you are not sure then please contact your ISP or
  * shoot your questions on the list serve. Parts of this file has been
  * adapted from the previous publications of The Terracotta Project
  *
  * FOR ALL DIRECTORY NAMES YOU MUST USE A TRAILING SLASH
  *
  * FOR NORMAL INSTALLATIONS YOU SHOULD HAVE TO CHANGE VERY FEW DETAILS
  * MOST PATH NAMES ARE AUTO CONFIGURED IN THIS VERSION
  *
  * By default all settings are made for UNIX based servers
  * running the Apache web server 1.3.x (http://httpd.apache.org/)
  *
  *******************************************************************/

 /*******************************************************************
  * Document Gallery Owner, and Titles
  *******************************************************************/

  /* The full real name of the administrator */

   $SiteAdministratorName     = "Admin";

  /* Email address for the administrator */

   $SiteAdminEmailAddress     = "";

  /* Adminitrators password */

   $SiteAdministratorPassword = "terracotta";

  /* Gallery Title to be place as the HTML title */

   $GalleryTitle              = "Terracotta 0.6 Document Gallery";

  /* XHTML META Keywords, Seperate Keywords using commas 
     Uses the PHP str_replace functions to convert Administrators name
     and the GalleryTitle into keywords. 
     
     You can remove the str_replace function, they are not manditory
   */

   $HTMLMetaKeyWords          = "Terracotta,Document,Gallery,Image,Content,Management,PHP,Eternity,Lifestyle,Technologies".
                                str_replace(" ",",",$SiteAdministratorName).",".str_replace(" ",",",$GalleryTitle);

 /*******************************************************************
  * Langauge administration for Terracotta
  * Simply remove the hashes from the language you wish to choose
  * Make sure only one language description is selected at a time
  * English (US/UK) is chosen as the default language
  *******************************************************************/

  $NaturalLanguageFile = "english.language.php";       // English (US/UK)
  // $NaturalLanguageFile = "spanish.language.php";    // Spanish
  // $NaturalLanguageFile = "german.language.php";     // German
  // $NaturalLanguageFile = "dutch.language.php";      // Dutch
  
 /*******************************************************************
  * Localization settings, Time/Date formats, etc
  *******************************************************************/

  /* Format the date and time is displayed in
     Important for internationalization */

   $DateTimeFormat            = "d-m-Y H:i";
  
 /*******************************************************************
  * Document Gallery Paths and URL information
  *******************************************************************/

  /* Home page URL for linking from the gallery to homepage */

   $HomePageURL               = "http://terracotta.sourceforge.net/";
   
  /* ICON base URL for, incase you decide to place the icon images 
     elsewhere, if you are using the default directory structure then
     you will not need to change this */

   $IconBaseURL               = "images/icons/";

  /*
   * Gallery Based URL, could be relative to script installation
   * directory or absolute (for the documents not the scripts) 
   * 
   * If you are not changing the installation directory structure
   * then you should not have to change this setting.        
   *
   */

   $GalleryBaseURL            = "tools/www_content/";

  /*
   * Complete base directory where the document galleries will be
   * placed (documents not the scripts). The realpath function determines
   * where the directory of the Terracotta installation and auto configures
   * the path names. This functions properly on UNIX and Apahce for Windows.
   * IIS based servers might need absolute paths
   *
   * If on a Windows server use / instead of \\ for file name seperations
   * and use a filename instead of the $_SERVER["SCRIPT_NAME"] variable if
   * you have chosen to implement Terracotta on Microsoft IIS.
   *
   * You should not have to change this under the normal circumstances.
   *
   */

  /* Dont modify this following line as the GalleryBaseDirectory variable
     is dependant on the information from this variable. This is not required
     for normal Terracotta configuration, but is present to enable the auto
     configuration of directory names */
      
   $path_parts               = pathinfo($_SERVER["SCRIPT_NAME"]);
   
  /* Under normal circumstances this variable should be dynamically configured
     if there are any problems just use the traditional way and input the
     absolute path e.g
    
     $GalleryBaseDirectory  = "/home/username/htdocs/terracotta/www_content/";
   */

   $GalleryBaseDirectory     = dirname(realpath($path_parts["basename"]))."/www_content/";

 /*******************************************************************
  * FPDF (http://fpdf.org/) confuguration variables
  *
  * Please refer to the FPDF manuals for more information, you can
  * leave the default values if you dont know what to do
  *******************************************************************/
   
  /* 
   * FDF Configuration variable to define the location of the font metric
   * files, it should autoconfigure based on the input from the GalleryBaseDirectory
   * configuraiton variable.
   *
   * Obtained from install.txt distributed with the FPDF libraries.
   *  
   */
   
  define('FPDF_FONTPATH',dirname(realpath($path_parts["basename"])).'/includes/libraries/fpdf/font/');
  
  /* 
   * FPDF Fonts, please choose fonts only from the fonts that
   * are available with the FPDF packages. If you wish to upgrade the 
   * FPDF packages just replace the files in the includes/libraries/fpdf directory
   *
   */
  
  $FPDF_FontName             = "Arial";
  
 /*******************************************************************
  * Document Gallery Layout and appearance information
  *
  * This is for making quick changes to the color schemes etc.
  * You can choose to entirely re-write the layout files and give
  * your document gallery a new look.
  *******************************************************************/
  
  /* Display the Top Link, which links to the root of the document gallery */
  
   $DisplayTopLabel              = TRUE;

  /* Visual seperator character between directory names */

   $VisualCharacterSeperator     = ">";

  /* Do you want links on the gallery pages to have an underline */

   $UnderlineLinks               = TRUE;
   
  /* Display the Next and Back button for easy navigation */
  
   $DisplayNextAndBackButtons    = TRUE;

  /* How many images per page of the table */

   $ObjectsPerPage               = 12;

  /* How many images per row of the table */

   $ObjectsPerRow                = 4;

  /* Document Body tag color scheme */

   $BodyBackgroundColor          = "#96BBDA";
   $BodyTextColor                = "#000000";
   $BodyLinkColor                = "#000000";
   $BodyVisitedLinkColor         = "#000000";

  /* Colours for header and footer */

   $InformationRowBGColor        = "#DAE7F0"; // "#3471A4";
   $InformationRowFontColor      = "#000000";
   $InformationBorderWidth       = 0;
   $InformationBorderColor       = "#DAE7F0";
   $InformationTableAlign        = "center";

  /* Colours for main table where images are displayed */

   $MainRowBGColor               = "#AAC7E0";
   $MainRowFontColor             = "#000000";
   $MainBorderWidth              = 0;
   $MainBorderColor              = "#336699";
   $MainTableAlign               = "center";

  /* Table widths, heights are dynamic */

   $TableWidth                   = "700px";

  /* Table allignment */

   $TableAlign                   = "center";

 /*******************************************************************
  * Folder Options
  *******************************************************************/

  /* Defines information for the directory */

   $DirectoryDescriptionFile     = "description.txt";
   
  /* Defines the name of the text file that holds the title for the folder */
   
   $DirectoryTitleFile           = "title.txt";

  /* File permission for the files and directories created (in hex code) */

   $FilePermission               = 0775;

 /* Gallery icon file name, to be placed on the root of the gallery
  * If missing then default folder icon is displayed 
  * 
  * A .jpg .gif or .png will be appended as necessary to identify the
  * format of the file. Don't append the file extentions for the image
  *
  * NOTE: Only JPG, PNG and GIF will be accepted as images for the folder
  *
  */

   $GalleryIconFile              = "gallery";

 /*******************************************************************
  * Article settings
  *
  * Make sure you change the font if you are using International
  * characters in your articles.
  *******************************************************************/

  /* Articles files must have this extention */

   $ArticlesExtention            = "art";
   
  /* Directory to store titles in */
  
   $ArticlesTitleDirectory       = "titles";
   
  /* Font to be used in the <font> tags */

   $ArticlesDisplayFont          = "Verdana";
   
  /* Font size for articles */
  
   $ArticleFontSize              = 2;
   
  /* Replace Carrige Returns with <br> tags */
  
   $GenerateBRTagsForArticles    = TRUE;   

 /*******************************************************************
  * Internet Links Settings
  *******************************************************************/

  /* Extention of Internet link files */

   $LinkFileExtention            = "ref";
   
  /* Link title directory */
  
   $LinkTitleDirectory           = "titles";

  /* Open Links in the same window or a new one */

   $OpenLinksInNewWindow         = TRUE;

 /*******************************************************************
  * Image and Thumbnail Creations settings
  *******************************************************************/
  
  /* Directory to store images for image galleries */

   $ImageDirectoryName           = "images";
   
  /* Image Captions directory */
   
   $ImageCaptionsDirectory       = "captions";
   
  /* 
   * Do you want Terracotta to resize the original image size
   * This is very handy for users uploading pictures from digital cameras 
   * 
   * If the original image is small than the maximum size then the image
   * resize process will be ignored
   * 
   */
     
   $ResizeOriginalImages         = TRUE;
   
  /* Original Image resize height and width */
  
   $MaximumOriginalImageHeight   = 450;
   
   $MaximumOriginalImageWidth    = 600;
   
  /* Quality of the original image resize */
   
   $OriginalImageQuality         = 100;
   
  /* Border around the image */
  
   $ImageBorderSize              = 2;

  /* 
   * Option of using GD libaries as many ISPs dont support it yet
   * Set the option to FALSE to stop using GD libs and revert back to
   * the traditional uploading mode 
   *
   */

   $CreateThumbnails             = TRUE;

  /* Directory to store image thumbnails */

   $ThumbnailDirectoryName       = "thumbnails";

  /* Generated Thumbnail quality in percentage */

   $ThumbnailQuality             = 80;

  /* Max Width of thumbnail in pixels */

   $ThumbnailMaximumWidth        = 90;

  /* Max Height of thumbnail in pixels */

   $ThumbnailMaximumHeight       = 58;
   
  /* Borders around thumbnails */
  
   $ThumbnailBorderSize          = 2;

 /*******************************************************************
  * File Respository settings
  *******************************************************************/

  /* Directory where to look for binary files
   * from the file_types list  */
   
  /* Where to store the file itself? */

   $FileRepositoryDirectoryName        = "files";
   
  /* Where to store the captions for the files */
   
   $FileRepositoryCaptionDirectoryName = "captions";
  
  /* Where to store the titles */
  
   $FileRepositoryTitlesDirectoryName  = "titles";

 /*******************************************************************
  * Backup feature options
  *
  * The file format, defines the name of the file for every backup
  * event, if you are not sure of how to program in PHP then we
  * recomend that you dont make any changes here.
  *******************************************************************/

  /* A prefix to the filename, the program will also add a _todaysdate
     to the filename */

   $ZipFileFormat                 = "TCPE_ContentBackup_".date("Ymd").".zip";
   
  /* Other examples of ZIP file formats could be
     $ZipFileFormat = "TCPE_DomainName_Backup".date("Ymd").".zip";
   */

 /*******************************************************************
  * Script self refer configuration required for IIS
  *
  * Original version of Terracotta was implemented for Apache
  * This revised version has support for IIS
  *******************************************************************/

  /* Use this if you are using Apache */

   $SCRIPT_SELF_REFERAL = $_SERVER["SCRIPT_NAME"];

  /* Use this if you are using IIS, enter the fully qualified URL
     for the main script */

  /* $SCRIPT_SELF_REFERAL = "http://yourdomain.com/terracotta/index.php"; */

 /*******************************************************************
  * Versioning and other features
  * Users should not have to normally change these
  *******************************************************************/
  
  /* 
   * Standard Baud rates for calculating file download time
   * 28800, 33600, 56600 (please add or remove as per your requirement) 
   * 
   * If you want multiple baud rate calculations then use the following format
   * 
   *     $BaudRates    = array(x,y,z) where x,y,z are different Baud Rates
   * e.g $BaudRates    = array(14400,28800,33600,56600) 
   * 
   */
     
   $BaudRates                   = array(56600);
  

  /* Based on Windows or UNIX select a file system seperator
     This will work on Windows servers as well provided you use / instead of \\ */

   $FileSystemSeperator         = "/";

  /* Default PHP page name usually index.php
   * used for files that are created with the directories */

   $DefaultPHPName               = "index.php";
   
  /* Name of the transpaernt spacer GIF that is in user */

   $SpacerGIFName                = "spacer.gif";

  /* Script time out is given in seconds - look in php.ini for more settings */

   $ScriptTimeOut                = 30;

  /* Magic quotes runtime information */

   $MagicQuotesRuntime           = 0;
   
  /* Maximum File Upload size for uploads in bytes */
  
  $MaxFileUploadSize             = 2097152; // 2 Mb

 /*******************************************************************
  * Engine Verification Varible, Please donot change
  *******************************************************************/

  /* 
   * Terracotta Version number for configuration file
   * PLEASE DONOT CHANGE THIS AT ALL UNLESS DEVELOPING A NEW VERSION
   * OF THE TERRACOTTA PERSONAL EDITION ENGINE
   *
   * THIS VERIFIES THE INTEGRATION OF THE CONFIG FILE WITH THE ENGINE 
   *
   */

   $TerracottaConfigurationFileVersion = "0.6";

 /*******************************************************************
  * End of configuration file
  *******************************************************************/

?>
