<?php
$_include_path = '../include/';
$_ignore_page = true; /* used for the close the page option */
require($_include_path.'vitals.inc.php');
require($_include_path.'lib/filemanager.inc.php');

if (!$_GET['f']) {
	$_SESSION['done'] = 0;
}
session_write_close();
$_section[0][0] = $_template['tools'];
$_section[0][1] = 'tools/';
$_section[1][0] = $_template['file_manager'];
$_section[1][1] = 'tools/file_manager.php';

$help[]=AT_HELP_FILEMANAGER2;
$help[]=AT_HELP_FILEMANAGER3;
$help[]=AT_HELP_FILEMANAGER4;



/********************************************/
/* Terracotta code from here bellow			*/
/********************************************/

/* Import settings and libraries by importing just one php file */
/* includes folder for filemanagement is local -> GPL Terracotta */

  include("includes/libraries/common.lib.php");

  /* Initiate an object of the class ContentRender and ContentManagement */
  
  $RenderObject = new ContentRender;
  $ManageObject = new ContentManagement;

  /* Actions beging here */

  /* 
   * Message box action 
   * 
   * Displays a message box based on the variables Title, Message and
   * RedirectURL from the $_REQUEST variable
   *
   */
  
  if($_REQUEST["action"] == "MessageBox") {
    include("includes/at_header.php");
    include("includes/layout/message_box.layout");
    exit;
  
  }

  /* 
   * Yes/NO Box  
   * 
   */
  
  if($_REQUEST["action"] == "YesNoBox") {
    include("includes/at_header.php");  
    include("includes/layout/yesno_box.layout");
    exit;
  
  }
  
  /* Uninstall box - confirms uninstall */
  
  if($_REQUEST["action"] == "Uninstall" && $ManageObject->IsAdminLoggedIn()) {
    include("includes/at_header.php");  
    header("Location: $SCRIPT_SELF_REFERAL?action=YesNoBox&YesURL=$SCRIPT_SELF_REFERAL?action=ConfirmUninstall&NoURL=$SCRIPT_SELF_REFERAL?CurrentDirectory=$CurrentDirectory&Title=".urlencode($_MSG_TCPE_UNINSTALL["Header"])."&Message=".urlencode($_MSG_TCPE_UNINSTALL["Warning"]));
    exit;
  
  }
  
  /* Uninstall content */

  if($_REQUEST["action"] == "ConfirmUninstall" && $ManageObject->IsAdminLoggedIn()) {

    $DirectoryContents = GetDirectoryContentsAsArray($GalleryBaseDirectory);
    for($DeleteCounter = 0; $DeleteCounter < count($DirectoryContents); $DeleteCounter++) {
      $ManageObject->recursive_delete($GalleryBaseDirectory.$DirectoryContents[$DeleteCounter]);
    }
    header("Location: $SCRIPT_SELF_REFERAL?action=MessageBox&RedirectURL=$SCRIPT_SELF_REFERAL&Title=".urlencode($_MSG_TCPE_UNINSTALL["TitleFin"])."&Message=".urlencode($_MSG_TCPE_UNINSTALL["Completed"]));
    exit;
  
  }
  
  /*
   * Bad Configuraiton file version, exit from this web site
   *
   */
  
  if(!($TerracottaConfigurationFileVersion == "0.6")) {
  
    header("Location: $SCRIPT_SELF_REFERAL?action=MessageBox&Title=".urlencode($_MSG_TCPE_ERROR["BadConfigurationTitle"])."&Message=".urlencode($_MSG_TCPE_ERROR["BadConfigurationFile"])."&RedirectURL=http://terracotta.sourceforge.net/");
    exit;  
    
  }

  /* 
   * Backup (sends a ZIP file of the content published by Terracotta)
   *
   * This is executed when the user has requested to take a backup for
   * the content that has been published in the Terracotta gallery.
   *
   */

  if($_REQUEST["action"] == "Backup" && $ManageObject->IsAdminLoggedIn()) {
    $ManageObject->PerformContentBackup(); // called from ContentManagement.class.php
    exit;
  }
  
  /* 
   * Logout
   *
   * Just set the cookies and display a message
   *
   */
  
  if($_REQUEST["action"] == "Logout" && $ManageObject->IsAdminLoggedIn()) {
  
    setcookie("AdminEmail","");
    setcookie("AdminPassword","");
    header("Location: $SCRIPT_SELF_REFERAL?action=MessageBox&Title=".urlencode($_MSG_TCPE_MANAGE["AdminTitle"])."&Message=".urlencode($_MSG_TCPE_MANAGE["LogoutMessage"])."&RedirectURL=$SCRIPT_SELF_REFERAL?CurrentDirectory=".$_REQUEST["CurrentDirectory"]);
    exit; 
  
  }
  
  /* 
   * Admin Login Validation 
   *
   * Validate using the ManageObject and set the cookies if everything
   * seems to be in order
   *
   */
  
  if($_REQUEST["action"] == "ValidateAdmin") {
    
    if($ManageObject->Login($_REQUEST["AdminEmail"],$_REQUEST["AdminPassword"])) {     
     /* Set the cookies because the user has successfully logged on */  
     setcookie("AdminEmail",$_REQUEST["AdminEmail"]);
     setcookie("AdminPassword",$_REQUEST["AdminPassword"]);
     header("Location: $SCRIPT_SELF_REFERAL?action=MessageBox&Title=".urlencode($_MSG_TCPE_MANAGE["AdminTitle"])."&Message=".urlencode($_MSG_TCPE_MANAGE["LoginOK"])."&RedirectURL=$SCRIPT_SELF_REFERAL?CurrentDirectory=".$_REQUEST["CurrentDirectory"]);
     exit; 
    }
    else {
     header("Location: $SCRIPT_SELF_REFERAL?action=MessageBox&Title=".urlencode($_MSG_TCPE_MANAGE["AdminTitle"])."&Message=".urlencode($_MSG_TCPE_MANAGE["LoginBAD"])."&RedirectURL=$SCRIPT_SELF_REFERAL?CurrentDirectory=".$_REQUEST["CurrentDirectory"]);
     exit; 
    }
  
  }

  /* 
   * Render Article in Printable Format
   *
   */
   
  if($_REQUEST["action"] == "PrintArticle") {
  
    $WorkingDirectory = $GalleryBaseDirectory.$_REQUEST["CurrentDirectory"];
    $ArticlesFile = $WorkingDirectory.$FileSystemSeperator.$_REQUEST["File"];
    include("includes/at_header.php");
	
    if(is_file($ArticlesFile)) {
      
      $ArticlesContents = ReadTextFromFile($ArticlesFile);         
      $lastchanged = filectime($ArticlesFile);
      $changeddate = date($DateTimeFormat, $lastchanged);
      $ArticleTitle = ReadTextFromFile($WorkingDirectory.$FileSystemSeperator.$ArticlesTitleDirectory.$FileSystemSeperator.$_REQUEST["File"].".txt");
      
      if(is_file($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."header.layout"))
      include($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."header.layout");
      else include("includes/layout/print_header.layout");

      echo "<font face=\"$ArticlesDisplayFont\" color=\"#000000\" size=\"$ArticleFontSize\">";
      if($GenerateBRTagsForArticles == TRUE) echo str_replace("\n","<br/>",$ArticlesContents);
      else echo $ArticlesContents;         
      echo "<br/></font>";

      if(is_file($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."footer.layout"))
      include($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."footer.layout");
      else include("includes/layout/print_footer.layout");    
     
    }    

    exit; // end execution of index here
  
  }
  
  /*
   * Download a PDF version of the text articles published on the web site
   *
   * Uses the functions defined by FPDF (http://fpdf.org/)
   *
   */
  
  if($_REQUEST["action"] == "DownloadPDF") {
    include("includes/at_header.php");
    $RenderObject->RenderArticleInPDFFormat();    
    exit; // end PDF generation and stop execution of page
  
  }

  /*
   * Delete function (Confirm Delete)
   *
   */
  
  if($_REQUEST["action"] == "ConfirmDelete" && $ManageObject->IsAdminLoggedIn()) {

   // Added security patch from last versions, because the delete
   // function tended to delete all content in the main directory if
   // you deleted a folder on the root
   if($_REQUEST["FileType"] == "Folder") $ManageObject->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$_REQUEST["File"]);
   
   if($_REQUEST["FileType"] == "Link") $ManageObject->DeleteLink();
   if($_REQUEST["FileType"] == "Image") $ManageObject->DeleteImage();
   if($_REQUEST["FileType"] == "Document") $ManageObject->DeleteDocument();
   if($_REQUEST["FileType"] == "Article") $ManageObject->DeleteArticle();
   
   header("Location: $SCRIPT_SELF_REFERAL?CurrentDirectory=".$_REQUEST["CurrentDirectory"]);
   exit;
  
  }
  
  /*
   * Save content to the gallery
   *
   */
  
  if($_REQUEST["action"] == "Save" && $ManageObject->IsAdminLoggedIn()) {
  
   if($_REQUEST["FileType"] == "Folder") $ManageObject->SaveFolder();
   if($_REQUEST["FileType"] == "Link") $ManageObject->SaveLink();
   if($_REQUEST["FileType"] == "Image") $ManageObject->SaveImage();
   if($_REQUEST["FileType"] == "Document") $ManageObject->SaveDocument();
   if($_REQUEST["FileType"] == "Article") $ManageObject->SaveArticle();
   
   // Redirect to the directory contents
   header("Location: $SCRIPT_SELF_REFERAL?CurrentDirectory=".$_REQUEST["CurrentDirectory"]);
   exit;
  
  }
  
  
  /* Write the index file to the current directory incase it does not exists */
  
  WriteIndexFileToCurrentDirectory();

  /* 
   * Administrative and Message Actions end here
   *
   * If no actions were to be taken then render the folder contents 
   * Content rendering requested are performed later
   *
   * Preare the directory array before the header.layout file is read
   * the contents are rendered later below
   *  
   */

  if($_REQUEST["action"] == "Search")
  $DirectoryContents = GetSearchResultAsArray($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"],$_REQUEST["Keywords"]);
  else
  $DirectoryContents = GetDirectoryContentsAsArray($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]);

  /* Start content rendering here */

  include("includes/at_header.php");
  if(is_file($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."header.layout"))
  include($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."header.layout");
  else include("includes/layout/header.layout");
 
  if($_REQUEST["action"] == "AdminLogin") {
   /* 
    * The user has requested for Administration Login 
    * this layout file will presents the user with a login form
    *
    */
   include("includes/layout/admin_login.layout");
  } elseif($_REQUEST["action"] == "Delete") {
   /* 
    * The user has requested for a search page
    *
    */
   include("includes/layout/confirm_delete.layout"); 
  } elseif($_REQUEST["action"] == "SearchForm") {
   /* 
    * The user has requested for a search page
    *
    */
   include("includes/layout/search.layout"); 
  } elseif($_REQUEST["action"] == "AddObjects" && $_SESSION['is_admin']) {
   /* 
    * The user has requested for a addition of items
    * present him/her with the option of adding multiple items
    *
    */   
   include("includes/layout/multiple_items.layout"); 
   
  } elseif($_REQUEST["action"] == "Add" && $_SESSION['is_admin']) {
   /* 
    * The user has requested add interface
    *
    */
   if($_REQUEST["FileType"] == "Folder") include("includes/layout/add_folder.layout"); 
   if($_REQUEST["FileType"] == "Link") include("includes/layout/add_link.layout"); 
   if($_REQUEST["FileType"] == "Image") include("includes/layout/add_image.layout"); 
   if($_REQUEST["FileType"] == "Document") include("includes/layout/add_document.layout"); 
   if($_REQUEST["FileType"] == "Article") include("includes/layout/add_article.layout"); 
   
  } elseif($_REQUEST["action"] == "Edit" && $ManageObject->IsAdminLoggedIn()) {
   /* 
    * The user has requested an edit option interface
    *
    */
   if($_REQUEST["FileType"] == "Folder") include("includes/layout/add_folder.layout"); 
   if($_REQUEST["FileType"] == "Image") include("includes/layout/add_image.layout"); 
   if($_REQUEST["FileType"] == "Article") include("includes/layout/add_article.layout"); 
   if($_REQUEST["FileType"] == "Link") include("includes/layout/add_link.layout"); 
   if($_REQUEST["FileType"] == "Document") include("includes/layout/add_document.layout"); 
   
  } else {
  
   if($_REQUEST["File"] == "") {

     // If this is a search request then get the array back with searched items only
     if($_REQUEST["action"] == "Search") {
       // Render content based on the array returned
       echo $RenderObject->RenderDirectoryContents($DirectoryContents, TRUE);
     }
     else {
       // Render content based on the array returned
       echo $RenderObject->RenderDirectoryContents($DirectoryContents, FALSE);
     }
     
   } // end render directory
   else {
     echo $RenderObject->RenderFile(); // Render the File
   } // end render file
   
  } // end all content rendering options
  
  /* 
   * Footer file defines the bottom half
   *
   */
  
  if(is_file($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."footer.layout"))
  include($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"]."footer.layout");
  else include("includes/layout/footer.layout");
  
  /* 
   * End Index.php (Main Terracotta Script) file here
   *
   */


/***********************************/
/* END of Terracotta code 		   */
/***********************************/

	require($_include_path.$_footer_file);
?>
