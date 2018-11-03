<?php

 /******************************************************************
  *
  * Terracotta Personal Edition (published under GNU/GPL)
  * Version 0.6 Created on 12th October 2002
  * Natural Language Definition
  *
  * Created by Devraj MUKHERJEE (devraj@eternitytechnologies.com)
  * Copyright (c) 2002 Eternity Technologies
  *
  * All source code published as a part of the Terracotta OS project
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
  * File:        english.language.php
  * Created by:  Devraj MUKHERJEE
  * Created on:  12th October 2002
  *
  * Natural language definition developers can use this file as a
  * template and make their custom language files. Please do contribute
  * your language files to the Terracotta project at
  * terracotta-devel@lists.sourceforge.net
  *
  * Language:    English (US/UK)
  *
  ******************************************************************/

 /* Defines the font family to be used for support of the language */

  $FontFamily        = "Verdana";
  $CharType          = "UTF-8";
  $XHTMLLanguageCode = "EN";

 /******************************************************************
  * Common messages
  ******************************************************************/

  $_MSG_TCPE_COMMON = array(

   "APP_TITLE"  => "Terracotta Personal Edition",
   "Version"    => "Version",
   "Home"       => "Home",
   "Edit"       => "Edit",
   "Delete"     => "Delete",
   "Continue"   => "Continue",
   "Okay"       => "Okay",
   "Yes"        => "Yes",
   "No"         => "No",
   "Page"       => "Page",
   "Top"        => "Top",
   "Next"       => "Next",
   "Back"       => "Previous",
   "Search"     => "Search",
   "Document"   => "Document",
   "Image"      => "Image",
   "Link"       => "Link",
   "Folder"     => "Folder",
   "Article"    => "Article",
   "Manage"     => "Manage",
   "Logout"     => "Logout",
   "AdminEmail" => "Administrative Email",
   "AdminPass"  => "Administrative Password",
   "Backup"     => "Backup"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "The configuration file is not compatible with this installation.",
   "BadConfigurationTitle" => "Bad Configuration File",
   "NotImageFileTitle"     => "Not an Image file",
   "NotImageFile"          => "Uploaded file is not an accepted web image, please upload JPEG, GIF or PNG only",
   "BadFile"               => "The requested file was found missing, an email has been sent across to the administrator"
   
  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Un-install Terracotta file-management, personal edition",
   "Warning"   => "This utility will allow unlinking of all content published and deleting them from this server. Please be very sure before proceeding as this is an irreversible process. We also recommend that you take a backup of your content before continuing.",
   "Completed" => "Unlinking was completed sucessfully, you can now delete the scripts to complete un-installation",
   "TitleFin"  => "Finished Un-Linking content",
   "Uninstall" => "Un-install"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "Administration Module",  
    "LoginTitle"             => "Login to the Management Interface",
    "LoginMessage"           => "You have requested to access the management functions, to continue you must prove that you have the proper credentials to continue",
    "AdministrativeEmail"    => "Administrative Email",
    "AdministrativePassword" => "Administrative Password",
    "LoginButton"            => "Administer",
    "LoginOK"                => "You have successfully logged on to the administrative interface and will now be redirected back to the gallery with administrative options",
    "LoginBAD"               => "You administrative credentials could not be verified please try again",
    "LogoutMessage"          => "You have been successfully logged out of the administrative interface",
    "AdminModeMessage"       => "Administrative Menu >> ",
    "AdminBarMessage"        => "What would you like to do? ",
    "Modify"                 => "Modify",
    "Add"                    => "Add",
    "MultipleItemTitle"      => "How many items do you want to add?",
    "MultipleItemDescribe"   => "Choose the number of items you would like to add",
    "SelectNumber"           => "How many do you want to add?",
    "SelectType"             => "What do you want to add?",
    "ConfirmDelete"          => "Are you sure you want to delete this item? The process is irreversible!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "Add New Folders",  
    "ModFolder"           => "Modify Folder Information",
    "AddFolderMessage"    => "Fill in the required details for each folder and click on the button to create the folders",
    "ModFolderMessage"    => "Update the folder information and click the button to save. Upload the icon only if you want to change it",
    "FolderName"          => "Folder Name",
    "FolderDescription"   => "Description of the Folder",
    "FolderIcon"          => "Custom folder icon (JPG/GIF/PNG)",
    "AddButton"           => "Create Folders",
    "ModButton"           => "Update Titles"

  );

 /******************************************************************
  * Image Management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_IMAGE = array(
  
    "AddImageTitle"       => "Add New Images",
    "AddImageMessage"     => "Select the images from your computer to be uploaded to this image gallery, if your PHP installation does not support thumbnails creation or if you have switched this feature off then you must provide a thumbnail as well.",
    "EditImageTitle"      => "Edit Image Caption",
    "EditImageMessage"    => "Modify the image caption and then click on the button to save the changes.",
    "ImageFile"           => "Image (JPG/PNG/GIF)",
    "ThumbnailFile"       => "Thumbnail (JPG/PNG/GIF)",
    "Caption"             => "Caption for this image",
    "AddButton"           => "Upload Images",
    "ModButton"           => "Change Caption"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "Add new article",
    "EditArticleTitle"    => "Edit article",
    "AddArticleMessage"   => "Give your article a title and type in your body text below. If the character replacement setting is turned on then the carrige returns will be replaced with the BR tags while the article is rendered on the live web site",
    "ArticleHead"         => "Article Name",
    "ArticleBody"         => "Article Body",
    "AddButton"           => "Save Article"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "Add new Internet Link",
    "EditLinkTitle"    => "Edit Internet Link",
    "AddLinkMessage"   => "Provide a caption and the complete URL (mail, web, ftp) to create an Internet link on your Terracotta managed web site",
    "LinkCaption"      => "Link caption",
    "LinkURL"          => "URL (mailto:, http:, ftp:)",
    "AddButton"        => "Create Links",
    "ModButton"        => "Modify Links"

  );

 /******************************************************************
  *
  ******************************************************************/

  $_MSG_TCPE_MANAGE_DOCUMENT = array(
  
    "AddDocTitle"      => "Add new document",
    "ModDocTitle"      => "Modify an existing document",
    "AddDocMessage"    => "Select the documents from your computer, give each one of them a caption and click on the button to add the documents to the gallery. Note that Terracotta will only accept the documents defined in the configuration files",
    "ModDocMessage"    => "Change the information about the document and click the button to save. Choose the file only if you want to update the existing file on the server, if you ignore the file field then the existing document will be preserved",
    "DocumentTitle"    => "Document Title",
    "DocumentCaption"  => "Describe the document",
    "DocFile"          => "Select the file to upload",
    "AddButton"        => "Upload Documents",
    "ModButton"        => "Change Information"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "Search Document Gallery",
    "SearchMessage"    => "Enter the keywords you want to search on and<br>click on the button to produce a list of matching items",
    "SearchKeywords"   => "Search Criteria, separate keywords using a comma",
    "EntireSite"       => "Search the entire document gallery",
    "ThisDirectory"    => "Search this folder only",
    "SearchButton"     => " Find Now ",
    "SearchResults"    => "Results of your Search"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Browse Folder",
    "EditLabel"        => "Edit",
    "DeleteLabel"      => "Delete",
    "Article"          => "Article",
    "InternetLink"     => "Internet Link",
    "LastModified"     => "Last Modified",
    "PrintArticle"     => "Print this Article",
    "EmailAddress"     => "Email",
    "MaintainedBy"     => "Maintained By",
    "PrintedOn"        => "Printed On",
    "Size"             => "File Size",
    "KBytes"           => "Kilo Bytes",
    "ClickToDownload"  => "Download the file Now",
    "Mins"             => "Mins.",
    "EmptyFolder"      => "This folders contains no items",
    "EmptySearch"      => "Your search returned no results",
    "SearchResults"    => "Search Results",
    "DownloadPDF"      => "Download a PDF version"

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
