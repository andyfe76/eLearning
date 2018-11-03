<?php

 /******************************************************************
  *
  * Terracotta Personal Edition (published under GNU/GPL)
  * Version 0.6 Created on 12th October 2002
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
  * File:        ContentManagement.class.php
  * Created by:  Devraj MUKHERJEE
  * Created on:  12th October 2002
  *
  * Summary:     Functions required for managing the content
  *
  ******************************************************************/

  class ContentManagement {
  
    /*
     * Save or Modify folder information
     */
  
    function SaveFolder() {
    
      global $GalleryBaseDirectory;
      global $_REQUEST;
      global $_FILES;
      global $DirectoryDescriptionFile;
      global $DirectoryTitleFile;
      global $FilePermission;
      global $FileSystemSeperator;
      global $GalleryIconFile;
      
      for($Counter = 1; $Counter <= $_REQUEST["NoItems"]; $Counter++) {
      
        /* If the folder name is blank then ignore request */
        if($_REQUEST["FolderName_".$Counter] == "") continue; 
    
        /* Step 1: Generate a new name for the folder and create it */
        if($_REQUEST["File"] == "") $FileName = uniqid("FOLDER_",TRUE);
        else $FileName = $_REQUEST["File"];
        
        if($_REQUEST["File"] == "") mkdir($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$FileName, $FilePermission);

        /* Step 2: Store the folder title */
        WriteTextToFile($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$FileName.$FileSystemSeperator.$DirectoryTitleFile, $_REQUEST["FolderName_".$Counter]);
     
        /* Step 3: Store the folder description file */
        WriteTextToFile($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$FileName.$FileSystemSeperator.$DirectoryDescriptionFile, $_REQUEST["FolderDescription_".$Counter]);
     
        /* Step 4: Upload the image if supplied, support for PNG,GIF and JPG */   
        $GalleryIconExtention = strrchr ($_FILES["FolderIcon_".$Counter]["name"] , "." );
        move_uploaded_file($_FILES["FolderIcon_".$Counter]["tmp_name"],$GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$FileName.$FileSystemSeperator.$GalleryIconFile.$GalleryIconExtention);
        
      }
    
    }
    
    /* 
     * Save or Modify the links
     */
    
    function SaveLink() {

      global $_REQUEST;
      global $LinkFileExtention;
      global $LinkTitleDirectory;
      global $FileSystemSeperator;
      global $GalleryBaseDirectory;
      global $FilePermission;
      
      $WorkingDirectory = $GalleryBaseDirectory.$_REQUEST["CurrentDirectory"];
      $NumItems = $_REQUEST["NoItems"];
      $FileName = $_REQUEST["File"];
           
      if(!($FileName == "")) $NumItems = 1; // Edit mode

      if(!is_dir($WorkingDirectory.$LinkTitleDirectory.$FileSystemSeperator)) 
      mkdir($WorkingDirectory.$LinkTitleDirectory.$FileSystemSeperator, $FilePermission);
      
      for($Counter = 1; $Counter <= $NumItems; $Counter++) {
      
        /* If the details are blank then skip */
        if($_REQUEST["LinkCaption_".$Counter] == "" || $_REQUEST["LinkURL_".$Counter] == "") continue;
        
        if($FileName == "") $FileName = uniqid("LINK_",TRUE).".".$LinkFileExtention;
        
        WriteTextToFile($WorkingDirectory.$FileName, $_REQUEST["LinkURL_".$Counter]);
        WriteTextToFile($WorkingDirectory.$LinkTitleDirectory.$FileSystemSeperator.$FileName.".txt", $_REQUEST["LinkCaption_".$Counter]);
        
        $FileName = $_REQUEST["File"]; // reset the file name for add action
      
      }
      
    } // end save link
    
    /*
     * Save or modify Image information
     */
    
    function SaveImage() {
    
      global $GalleryBaseDirectory;
      global $FileSystemSeperator;
      global $_REQUEST;
      global $_FILES;
      global $CreateThumbnails;
      global $ResizeOriginalImages;
      global $ImageDirectoryName;
      global $ImageCaptionsDirectory;
      global $MaximumOriginalImageHeight;
      global $MaximumOriginalImageWidth;
      global $OriginalImageQuality;
      global $ThumbnailDirectoryName;
      global $ThumbnailQuality;
      global $ThumbnailMaximumWidth;
      global $ThumbnailMaximumHeight;
      global $FilePermission;
      global $GDLibVersion;
      global $_MSG_TCPE_ERROR;
      
      $WorkingDirectory = $GalleryBaseDirectory.$_REQUEST["CurrentDirectory"];
      
      if(!($_REQUEST["File"] == ""))       
      WriteTextToFile($WorkingDirectory.$ImageCaptionsDirectory.$FileSystemSeperator.$_REQUEST["File"].".txt", $_REQUEST["ImageDescription_1"]);
      
      else {
      
        // Add a new image to gallery
      
       /* Step 0: Create the require directories to store content */
        if(!is_dir($WorkingDirectory.$ImageDirectoryName.$FileSystemSeperator)) 
        mkdir($WorkingDirectory.$ImageDirectoryName.$FileSystemSeperator, $FilePermission);
  
        if(!is_dir($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator)) 
        mkdir($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator,$FilePermission);

        if(!is_dir($WorkingDirectory.$ImageCaptionsDirectory.$FileSystemSeperator)) 
        mkdir($WorkingDirectory.$ImageCaptionsDirectory.$FileSystemSeperator,$FilePermission);
      
        $NumberItems = $_REQUEST["NoItems"];
        
        for($Counter = 1; $Counter <= $NumberItems; $Counter++) {
        
          /* If an image was not loaded */
          if($_FILES["ImageFile_".$Counter]["name"] == "") continue;
          
          if($CreateThumbnails == TRUE && $_FILES["ThumbnailFile_".$Counter]["name"] == "")  continue;
      	  /* Step 1: Resize the original image if required and store it in the directories */
          
          $ImageFileName = $_FILES["ImageFile_".$Counter]["name"];
          // If the uploaded file is not an image
        
          if(!($_FILES["ImageFile_".$Counter]["type"] == "image/jpeg" || $_FILES["ImageFile_".$Counter]["type"] == "image/pjpeg" || $_FILES["ImageFile_".$Counter]["type"] == "image/gif" || $_FILES["ImageFile_".$Counter]["type"] == "image/png")) {
        
            header("Location: $SCRIPT_SELF_REFERAL?action=MessageBox&Title=".urlencode($_MSG_TCPE_ERROR["NotImageFileTitle"])."&Message=".urlencode($_MSG_TCPE_ERROR["NotImageFile"])."&RedirectURL=$SCRIPT_SELF_REFERAL?CurrentDirectory=".$_REQUEST["CurrentDirectory"]);
            exit;
        
          }
        
          if($ResizeOriginalImages == FALSE) {
         
            // Move original image across to the right directory
            move_uploaded_file($_FILES['ImageFile_'.$Counter]['tmp_name'], $WorkingDirectory.$ImageDirectoryName.$FileSystemSeperator.$ImageFileName);
        
          }
          else {

			// If the image resize failed because the picture is of the correct size
			// then use the move_uploaded_file function to get move the file
            if(!ResizeImage($_FILES['ImageFile_'.$Counter]['tmp_name'], $WorkingDirectory.$ImageDirectoryName.$FileSystemSeperator.$ImageFileName, $MaximumOriginalImageHeight, $MaximumOriginalImageWidth, $OriginalImageQuality, $_FILES["ImageFile_".$Counter]["type"]))
            move_uploaded_file($_FILES['ImageFile_'.$Counter]['tmp_name'], $WorkingDirectory.$ImageDirectoryName.$FileSystemSeperator.$ImageFileName);       
          
          } // saved image
      
          /* Step 2: Create or store thumbnail supplied by user */

          // Move thumbnail image to the right directory
          // rename it to suit the system
  
          if($CreateThumbnails == FALSE) {

            if(!($_FILES["ThumbnailFile_".$Counter]["type"] == "image/jpeg" || $_FILES["ThumbnailFile_".$Counter]["type"] == "image/pjpeg" || $_FILES["ThumbnailFile_".$Counter]["type"] == "image/gif" || $_FILES["ThumbnailFile_".$Counter]["type"] == "image/png")) {
         
              header("Location: $SCRIPT_SELF_REFERAL?action=MessageBox&Title=".urlencode($_MSG_TCPE_ERROR["NotImageFileTitle"])."&Message=".urlencode($_MSG_TCPE_ERROR["NotImageFile"])."&RedirectURL=$SCRIPT_SELF_REFERAL?CurrentDirectory=".$_REQUEST["CurrentDirectory"]);
              exit;
         
            }

            move_uploaded_file($_FILES['ThumbnailFile_'.$Counter]['tmp_name'], $WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$ImageFileName);
        
          }
          else {

            ResizeImage($WorkingDirectory.$ImageDirectoryName.$FileSystemSeperator.$ImageFileName, $WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$ImageFileName, $ThumbnailMaximumHeight, $ThumbnailMaximumWidth, $ThumbnailQuality, $_FILES["ImageFile_".$Counter]["type"]);
        
          } // generated thumbnails
      
          /* Step 3: Store the caption related to the image */
          $ImageDescription = $_REQUEST["ImageDescription_".$Counter];
          WriteTextToFile($WorkingDirectory.$ImageCaptionsDirectory.$FileSystemSeperator.$ImageFileName.".txt", $ImageDescription);
        
        } // end for
        
      
      } // end add image if
    
    } // end save image
    
    /* 
     * Save or modify
     */
    
    function SaveDocument() {

      global $GalleryBaseDirectory;
      global $_REQUEST;
      global $_FILES;
      global $FileRepositoryDirectoryName;
      global $FileRepositoryCaptionDirectoryName;
      global $FileRepositoryTitlesDirectoryName;
      global $FilePermission;
      global $FileSystemSeperator;
      
      $WorkingDirectory = $GalleryBaseDirectory.$_REQUEST["CurrentDirectory"];
      
      // Create directories if they dont exists

      if(!is_dir($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator)) 
      mkdir($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator,$FilePermission);

      if(!is_dir($WorkingDirectory.$FileRepositoryCaptionDirectoryName.$FileSystemSeperator)) 
      mkdir($WorkingDirectory.$FileRepositoryCaptionDirectoryName.$FileSystemSeperator,$FilePermission);

      if(!is_dir($WorkingDirectory.$FileRepositoryTitlesDirectoryName.$FileSystemSeperator)) 
      mkdir($WorkingDirectory.$FileRepositoryTitlesDirectoryName.$FileSystemSeperator,$FilePermission);
      
      // Store the files
      
      for($Counter = 1; $Counter <= $_REQUEST["NoItems"]; $Counter++) {
      
        if($_REQUEST["DocTitle_".$Counter] == "") continue;
    
        /* Step 1: Generate a new name for the folder and create it */
        // $FileName = uniqid("FOLDER_",TRUE);
        if($_REQUEST["File"] == "") $FileName = $_FILES["DocFile_".$Counter]["name"]; // get the original name
        else $FileName = $_REQUEST["File"]; // get old file name
        
        /* Step 2: Store the folder title */
        WriteTextToFile($WorkingDirectory.$FileRepositoryTitlesDirectoryName.$FileSystemSeperator.$FileName.".txt", $_REQUEST["DocTitle_".$Counter]);
     
        /* Step 3: Store the folder description file */
        WriteTextToFile($WorkingDirectory.$FileRepositoryCaptionDirectoryName.$FileSystemSeperator.$FileName.".txt", $_REQUEST["DocCaption_".$Counter]);
     
        /* Step 4: Upload the image if supplied */   
        move_uploaded_file($_FILES['DocFile_'.$Counter]['tmp_name'],$WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$FileName);
        
      }
      
    } // end save document
    
    /*
     * Adds or Edits the contents of an article
     *
     */
     
    function SaveArticle() {
    
      global $_REQUEST;
      global $ArticlesExtention;
      global $ArticlesTitleDirectory;
      global $GalleryBaseDirectory;
      global $FileSystemSeperator;
      global $FilePermission;
      
      // get input from form      
      $FileName     = $_REQUEST["File"];
      $ArticleTitle = $_REQUEST["ArticleHead"];
      $ArticleBody  = $_REQUEST["ArticleBody"];
      $WorkingDirectory = $GalleryBaseDirectory.$_REQUEST["CurrentDirectory"];
      
      /* If the details are blank then ignore save */
      if($ArticleTitle == "" || $ArticleBody == "") continue;
      
      // If blank file name then this is a new article      
      if($FileName == "") $FileName = uniqid("ARTICLE_",TRUE).".".$ArticlesExtention;
      
      /* New Article addition to the system */
      
      // make directories if required     
      if(!is_dir($WorkingDirectory.$ArticlesTitleDirectory.$FileSystemSeperator)) 
      mkdir($WorkingDirectory.$ArticlesTitleDirectory.$FileSystemSeperator,$FilePermission);
      
      // write article and title in the files      
      WriteTextToFile($WorkingDirectory.$FileName, $ArticleBody);
      WriteTextToFile($WorkingDirectory.$ArticlesTitleDirectory.$FileSystemSeperator.$FileName.".txt", $ArticleTitle);
       
      /* End Article */
    
    } // save article

    /*
     * Delete Functions, to delete the various objects of the doc gallery
     *
     */
     
    function DeleteLink() {
    
      global $GalleryBaseDirectory;
      global $_REQUEST;
      global $LinkTitleDirectory;
      global $FileSystemSeperator;
      
      $this->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$_REQUEST["File"]);
      $this->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$LinkTitleDirectory.$FileSystemSeperator.$_REQUEST["File"].".txt");
    
    } // end delete link
    
    function DeleteImage() {

      global $GalleryBaseDirectory;
      global $_REQUEST;
      global $FileSystemSeperator;
      global $ImageDirectoryName;
      global $ImageCaptionsDirectory;
      global $ThumbnailDirectoryName;
      
      $WorkingDirectory = $GalleryBaseDirectory.$_REQUEST["CurrentDirectory"];
      
      $this->recursive_delete($WorkingDirectory.$ImageDirectoryName.$FileSystemSeperator.$_REQUEST["File"]);
      $this->recursive_delete($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$_REQUEST["File"]);
      $this->recursive_delete($WorkingDirectory.$ImageCaptionsDirectory.$FileSystemSeperator.$_REQUEST["File"].".txt");
    
    } // end delete image
    
    function DeleteArticle() {

      global $GalleryBaseDirectory;
      global $_REQUEST;
      global $FileSystemSeperator;
      global $ArticlesTitleDirectory;

      $this->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$_REQUEST["File"]);
      $this->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$ArticlesTitleDirectory.$FileSystemSeperator.$_REQUEST["File"].".txt");
   
    } // end delete article
    
    function DeleteDocument() {

      global $GalleryBaseDirectory;
      global $_REQUEST;
      global $FileSystemSeperator;
      global $FileRepositoryDirectoryName;
      global $FileRepositoryCaptionDirectoryName;
      global $FileRepositoryTitlesDirectoryName;
      
      $this->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$FileRepositoryDirectoryName.$FileSystemSeperator.$_REQUEST["File"]);
      $this->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$FileRepositoryCaptionDirectoryName.$FileSystemSeperator.$_REQUEST["File"].".txt");
      $this->recursive_delete($GalleryBaseDirectory.$_REQUEST["CurrentDirectory"].$FileRepositoryTitlesDirectoryName.$FileSystemSeperator.$_REQUEST["File"].".txt");
    
    } // end delete document
    
     
    /*
     * Login the administrator
     *
     */
  
    function Login($Email, $Password) {
    
      global $SiteAdminEmailAddress;
      global $SiteAdministratorPassword;
      
      if($SiteAdminEmailAddress == $Email && $SiteAdministratorPassword == $Password) {
        return TRUE;
      }
      
      return FALSE;
    
    }
    
    /*
     * Recursive delete function
     *  Originally written by: georg@spieleflut.de
     *  Modified for Terracotta by Devraj Mukherjee
     *
     */

    function recursive_delete($file) {
    
      // if(!chmod($file,0777)) return FALSE;
      // require("includes/config.php");
      
      if (is_dir($file)) {
      
        $handle = opendir($file);
        while($filename = readdir($handle)) {
        
          if ($filename != "." && $filename != "..") {
            $this->recursive_delete($file."/".$filename);
          }
        }
       
        closedir($handle);
        rmdir($file);
      }
      else {
        unlink($file);
      }
      
    }

    /*
     * Function read binary contents of a file
     * part of the back script for Terracotta
     *
     */
 
    function read_file_data($File) {
     $FilePointer = fopen ($File, "r");
     $FileContents = fread ($FilePointer, filesize ($File));
     return $FileContents;
    }

    /*
     * Function Add Directories recursively to a zip file
     * part of the back script for Terracotta
     *
     */

    function add_dir_recursively($BaseDirectory,$zipfile) {
    
      global $FileSystemSeperator;
      
      if (is_dir($BaseDirectory)) {
        $zipfile->add_dir($BaseDirectory); // Add the directory
        $handle = opendir($BaseDirectory);
        while($filename = readdir($handle)) {
        
          if ($filename != "." && $filename != "..") {
            $zipfile = $this->add_dir_recursively($BaseDirectory.$FileSystemSeperator.$filename,$zipfile);
          }
          
        }
        closedir($handle);
      }
      else {
        $zipfile->add_file($this->read_file_data($BaseDirectory),$BaseDirectory);
      }
      
      return $zipfile;
      
    }
    
    /*
     *  Terracotta Backup function adapted from 0.5.1
     *  dependant on two global variables
     *  Written by Devraj Mukherjee
     *
     */

    function PerformContentBackup() {
    
      global $GalleryBaseDirectory;
      global $ZipFileFormat;
      
      $RootDirectory = substr($GalleryBaseDirectory,0,strlen($GalleryBaseDirectory)-1);
      $zipfile = new zipfile();
      $zipfile = $this->add_dir_recursively($RootDirectory,$zipfile);
      
      header("Content-type: application/octet-stream");
      header("Content-Disposition: Attachment; filename=$ZipFileFormat");
      echo $zipfile -> file();

    }
    
    /* 
     * Check to see if Administrator is Logged in
     *
     */

    function IsAdminLoggedIn() {
    
      global $HTTP_COOKIE_VARS;
      global $SiteAdministratorPassword;
      global $SiteAdminEmailAddress;
      return $_SESSION['is_admin'];

    }
    

  } // end class

 /******************************************************************
  * End of Program file
  ******************************************************************/

?>