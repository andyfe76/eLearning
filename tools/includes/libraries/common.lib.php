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
  * File:        common.lib.php
  * Created by:  Devraj MUKHERJEE
  * Created on:  12th October 2002
  *
  * Summary:     Common Functions required for Terracotta OS Edn.
  *
  ******************************************************************/

  /* Terracotta libraries and defintions */

  include("includes/configuration/configuration.php");
  include("includes/configuration/doctypes.php");
  include("includes/language/".$NaturalLanguageFile);

  include("includes/libraries/ContentRender.class.php");
  include("includes/libraries/ContentManagement.class.php");

  /* Third party libraries for PDF and ZipFile generation */

  include("includes/libraries/fpdf/fpdf.php");
  include("includes/libraries/ZipFile.class.php");


  /* 
   * Perform settings required for Terracotta to run 
   * Based on the configuration variables
   * 
   */

  set_time_limit($ScriptTimeOut);
  set_magic_quotes_runtime($MagicQuotesRuntime);
   
  /* 
   * Security patch from 0.5.1 so that users cannot force the engine
   * to read directories below the Terracotta content root folder    
   *
   * Originally appeared in index.php placed here to reduce code in
   * the main index script file     
   *
   */

  $CurrentDirectory = str_replace("../","",$CurrentDirectory);
  $CurrentDirectory = str_replace(".","",$CurrentDirectory);

  $CurrentDirectory = str_replace($ImageDirectoryName,"",$CurrentDirectory);
  $CurrentDirectory = str_replace($ThumbnailDirectoryName,"",$CurrentDirectory);

  $CurrentDirectory = str_replace($FileRepositoryDirectoryName,"",$CurrentDirectory);
   
  /* 
   * End path Security patch from 0.5.x
   */
  
  /* 
   * Common layout functions for the administration module 
   * Mostly adapted from 0.5.1 terracotta_lib.php
   *
   */

 /*******************************************************************
  * Function to generate a link based on the setting in the config
  *******************************************************************/

  function CreateLink($URL, $LinkTitle, $NewWindow, $TextColor) {

    global $UnderlineLinks;       // From Configuration file

    if($UnderlineLinks == TRUE) {
      if($NewWindow == TRUE) {
        $LinkString = "<a href=\"$URL\" target=\"_blank\">$LinkTitle</a>";
      }
      else {
        $LinkString = "<a href=\"$URL\">$LinkTitle</a>";
      }
    }
    else {
      if($NewWindow == TRUE) {
        $LinkString = "<a href=\"$URL\" target=\"_blank\" border=\"0\">$LinkTitle</a>";
      }
      else {
        $LinkString = "<a href=\"$URL\" border=\"0\">$LinkTitle</a>";
      }
    }
    return $LinkString;

  } // end function CreateLink

  /***********************************************************************
   * Write Index file to directory
   *
   * Adapted from previous versions of Terracotta 
   * Written by Mukherjee, Devraj (dm@devraj.org)
   ***********************************************************************/
   
   function WriteIndexFileToCurrentDirectory() {
     
     global $SCRIPT_SELF_REFERAL;
     global $DefaultPHPName;
     global $FileSystemSeperator;
     global $GalleryBaseDirectory;
     global $_REQUEST;
     
     $CurrentDirectory = $_REQUEST["CurrentDirectory"];
   
     $IndexFileContents = "<?php ".
                          "  header(\"Location: $SCRIPT_SELF_REFERAL?CurrentDirectory=$CurrentDirectory\");".
                          "?>";
   
     $IndexFile = $GalleryBaseDirectory.$CurrentDirectory.$FileSystemSeperator.$DefaultPHPName;
     if(file_exists($IndexFile)) return;
     
     $IndexFilePointer = fopen($IndexFile,"w");
     $IndexFP = fwrite ($IndexFilePointer,$IndexFileContents);
     fclose($IndexFilePointer);
   
   } // end function WriteIndexFileToDirectory

  /*
   * Writes the given text to the specified file name
   *
   */
  
  function WriteTextToFile($FileName, $TextLine) {
  
    /* Based on the code available in the PHP manuals */
   
    if (!$fp = fopen($FileName,"wb")) return FALSE;
    if (!fwrite($fp, $TextLine)) return FALSE;
    fclose($fp);
    return TRUE;
    
  } // end function WriteTextToFile
  
  /*
   * Reads text from given file
   *
   */
  
  function ReadTextFromFile($FileName) {
  
    /* Based on the use of standard functions */
    
    if(file_exists($FileName) && is_readable($FileName)) {
    
      $fd = fopen ($FileName, "rb");
      $contents = stripslashes(fread ($fd, filesize ($FileName)));
      fclose ($fd);
      return $contents;
      
     }
     else {
     
       ## In case the file does not exists return blank spaces      
       return "";
     
     }
  
  } // end function ReadTextFromFile
  
  /* Calculate download time given file size and modem speed */
  
  function CalculateDownloadTime($ModemSpeed, $FileSize) {
  
    // Based on information from
    // http://www.phpbuilder.com/mail/php-general/2001062/1306.php
    // http://www.ksinclair.com/Article315.htm
    //
    // Comments welcome at dm@devraj.org
    
    $FileSize = $FileSize * 8; // Convert the bytes to bits
    return round((($FileSize/$ModemSpeed)/60),2); // Result returned in mins
  
  }

  /***********************************************************************
   * Reterieves the icons filename for a file type
   *
   * Written by Mukherjee, Devraj (dm@devraj.org)
   ***********************************************************************/
   
  function GetIconForFileType($FileTypeName) {
  
    global $file_type_list;
    global $IconBaseURL;
    
    $GetFileArray = $file_type_list[$FileTypeName];
    return $IconBaseURL.$GetFileArray[1]; // return the filename
  
  }

  /***********************************************************************
   * Users strstr to find atleast one keyword in the text
   ***********************************************************************/

  function FindKeywordInText($Keywords, $Text) {
  
    $KeyList = preg_split("/[\s,]+/", strtoupper($Keywords)); // get an array of keywords
    $TextList = preg_split("/[\s,]+/",strtoupper($Text));
    
    foreach($KeyList as $Key) {
      foreach($TextList as $Word) {
        if($Key == $Word) return TRUE; // found a match
      }
    }
    
    return FALSE; // nothing found
  
  }

  /***********************************************************************
   * Search the current document gallery
   ***********************************************************************/
   
  function GetSearchResultAsArray($WorkingDirectory, $Keywords) {
  
    global $GalleryBaseDirectory;
    global $FileSystemSeperator;
    global $_REQUEST;
    global $DirectoryDescriptionFile;
    global $DirectoryTitleFile;
    global $ImageCaptionsDirectory;
    global $FileRepositoryDirectoryName;
    global $FileRepositoryTitlesDirectoryName;
    global $LinkTitleDirectory;
    global $ArticlesTitleDirectory;
    global $FileRepositoryCaptionDirectoryName;
    global $ArticlesExtention;
    global $LinkFileExtention;
    global $ThumbnailDirectoryName;
    global $FileRepositoryDirectoryName;
    
    $CurrentDirectory = $_REQUEST["CurrentDirectory"];
  
    $DirectoryContents = GetDirectoryContentsAsArray($WorkingDirectory);
    
    foreach($DirectoryContents as $file) {
    
      if(is_dir($WorkingDirectory.$file)) {

        $GalleryCaption = ReadTextFromFile($GalleryBaseDirectory.$CurrentDirectory.$file.$FileSystemSeperator.$DirectoryDescriptionFile);
        $GalleryTitle   = ReadTextFromFile($GalleryBaseDirectory.$CurrentDirectory.$file.$FileSystemSeperator.$DirectoryTitleFile);
        if(FindKeywordInText($Keywords,$GalleryCaption." ".$GalleryTitle)) $SearchResultList[] = $file;

      }
      elseif (is_file($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$file)) {
        
        $ImageCaption = ReadTextFromFile($WorkingDirectory.$ImageCaptionsDirectory.$FileSystemSeperator.$file.".txt");
        if(FindKeywordInText($Keywords,$ImageCaption)) $SearchResultList[] = $file;

      }
      elseif (is_file($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$file)) {
   	  
	$FileTitle = ReadTextFromFile($WorkingDirectory.$FileRepositoryTitlesDirectoryName.$FileSystemSeperator.$file.".txt");
	$FileDescription = ReadTextFromFile($WorkingDirectory.$FileRepositoryCaptionDirectoryName.$FileSystemSeperator.$file.".txt");
	if(FindKeywordInText($Keywords,$FileTitle.",".$FileDescription)) $SearchResultList[] = $file;
	
      }
      elseif (strrchr ($file , "." ) == (".".$LinkFileExtention))  {
          
        $LinkTitle  = ReadTextFromFile($WorkingDirectory.$LinkTitleDirectory.$FileSystemSeperator.$file.".txt"); 
        $LinkTo = ReadTextFromFile($WorkingDirectory.$FileSystemSeperator.$file);
        if(FindKeywordInText($Keywords,$LinkTitle." ".$LinkTo)) $SearchResultList[] = $file;

      }
      elseif (strrchr ($file , "." ) == (".".$ArticlesExtention))  {
        
        $ArticleTitle = ReadTextFromFile($WorkingDirectory.$ArticlesTitleDirectory.$FileSystemSeperator.$file.".txt");
        if(FindKeywordInText($Keywords,$ArticleTitle)) $SearchResultList[] = $file;

      }
      
    } // end foreach loop
    
    return $SearchResultList;
  
  } // end Search function
    
  /***********************************************************************
   * Return List of files and folders
   *
   * Adapted from previous versions of Terracotta 
   * Written by Mukherjee, Devraj (dm@devraj.org)
   ***********************************************************************/

  function GetDirectoryContentsAsArray($WorkingDirectory) {

    global $ImageDirectoryName;
    global $CaptionsDirectoryName;
    global $FileRepositoryCaptionDirectoryName;
    global $ThumbnailDirectoryName;
    global $FileRepositoryDirectoryName;
    global $ArticlesExtention;
    global $file_type_list;
    global $LinkFileExtention;
    global $LinkTitleDirectory;
    global $FileRepositoryTitlesDirectoryName;
    global $GalleryIconFile;
    global $DirectoryDescriptionFile;
    global $DirectoryTitleFile;
    global $ArticlesTitleDirectory;
    global $FileSystemSeperator;
        
    /* Make a list of directories */

    if(is_dir($WorkingDirectory)) {
  
      $handle=opendir($WorkingDirectory);
      while ($file = readdir($handle)) {
        if($file == "." || $file==".." || $file==$ImageDirectoryName || 
           $file==$CaptionsDirectoryName || $file==$ThumbnailDirectoryName || 
           $file==$FileRepositoryCaptionDirectoryName || $file==$FileRepositoryDirectoryName || $file==$LinkTitleDirectory || 
           $file==$FileRepositoryTitlesDirectoryName || $file==$ArticlesTitleDirectory) continue;
        if(is_dir($WorkingDirectory.$file)) $dirlist[] = $file;
      }
      closedir($handle);
    }
  
    /* Prepare the list of image files */
    
    if(is_dir($WorkingDirectory.$ThumbnailDirectoryName)) {
      $handle=opendir($WorkingDirectory.$ThumbnailDirectoryName);
      while ($file = readdir($handle)) {
        if(is_file($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$file)) {
          $ext = strrchr ($file , "." );
          if((!strcasecmp ($ext, ".gif")) || (!strcasecmp ($ext, ".jpg")) || (!strcasecmp ($ext, ".jpeg")) || (!strcasecmp ($ext, ".png"))) $imagelist[] = $file;
        }
      }
      closedir($handle);
    }

    /* Prepare a list of files */

    if(is_dir($WorkingDirectory.$FileRepositoryDirectoryName)) {
      $handle=opendir($WorkingDirectory.$FileRepositoryDirectoryName);
      while ($file = readdir($handle)) {
        if(is_file($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$file)) {
          if($file==$GalleryIconFile || $file==$DirectoryDescriptionFile || $file==$DirectoryTitleFile ||
             $file==$ArticlesTitleDirectory || $file==$LinkTitleDirectory) continue;
          $ext = strrchr ($file , "." );
          // Loop through the different binary file types
          foreach($file_type_list as $current_extention => $extention_details) {
      	     if((!strcasecmp ($ext, ".".$current_extention))) $filelist[] = $file;
          }
        }
      }
      closedir($handle);
    }

    /* Load articles into memory */

    if(is_dir($WorkingDirectory)) {
       $handle=opendir($WorkingDirectory);
       while ($file = readdir($handle)) {
         if(is_file($WorkingDirectory.$file)) {
           $ext = strrchr ($file , "." );
 	       if((!strcasecmp ($ext, ".".$ArticlesExtention))) $articlelist[] = $file;
         }
       }
       closedir($handle);
     }

    /* Load Links into memory */

    if(is_dir($WorkingDirectory)) {

      $handle=opendir($WorkingDirectory);
      while ($file = readdir($handle)) {
        if(is_file($WorkingDirectory.$file)) {
          $ext = strrchr ($file , "." );
     	  if((!strcasecmp ($ext, ".".$LinkFileExtention))) $linkfiles[] = $file;
        }
      }
      closedir($handle);
    }

    /* Merge result arrays to one array */

    if($dirlist) {
      asort($dirlist, SORT_STRING);
      $result_list = $dirlist;
    }

    if($articlelist) {
      asort($articlelist, SORT_STRING);
      $result_list = array_merge($result_list,$articlelist);
    }

    if($imagelist) {
      asort($imagelist, SORT_STRING);
      $result_list = array_merge($result_list,$imagelist);
    }

    if($filelist) {
      asort($filelist, SORT_STRING);
      $result_list = array_merge($result_list,$filelist);
    }

    if($linkfiles) {
      asort($linkfiles, SORT_STRING);
      $result_list = array_merge($result_list,$linkfiles);
    }

    /* All done, return this array to the calling function */
    return $result_list;

  }

 /*
  * Function to resize images
  * Modified for the Terracotta project by Devraj Mukherjee
  *
  * Returns TRUE if successful and FALSE if the image resize is aborted
  *  
  */
  
  function ResizeImage($SourceImage, $DestinationImage, $DesiredHeight, $DesiredWidth, $ImageQuality, $ImageType) {
    
    $size = GetImageSize($SourceImage);
    $width = $size[0];
    $height = $size[1];

    if($width < $DesiredWidth || $height < $DesiredHeight) return FALSE;
     
    $x_ratio = $DesiredWidth / $width;
    $y_ratio = $DesiredHeight / $height;
    
    if ( ($width <= $DesiredWidth) && ($height <= $DesiredHeight )) {
        $tn_width = $width;
        $tn_height = $height;
    }
    else if (($x_ratio * $height) < $DesiredHeight) {
        $tn_height = ceil($x_ratio * $height);
        $tn_width = $DesiredWidth;
    }
    else {
        $tn_width = ceil($y_ratio * $width);
        $tn_height = $DesiredHeight;
    }
    
    if($ImageType == "image/pjpeg" || $ImageType == "image/jpeg") $src = ImageCreateFromJpeg($SourceImage);
    elseif ($ImageType == "image/gif") $src = ImageCreateFromGif($SourceImage);
    elseif ($ImageType == "image/png") $src = ImageCreateFromPng($SourceImage);
    else $src = ImageCreateFromJpeg($SourceImage);
    
    $dst = ImageCreate($tn_width,$tn_height);
    ImageCopyResized($dst, $src, 0, 0, 0, 0,$tn_width,$tn_height,$width,$height);
    
    if($ImageType == "image/pjpeg" || $ImageType == "image/jpeg") ImageJpeg($dst, $DestinationImage, $ImageQuality);
    elseif ($ImageType == "image/gif") ImageGif($dst, $DestinationImage, $ImageQuality);
    elseif ($ImageType == "image/png") ImagePng($dst, $DestinationImage, $ImageQuality);
    else  ImageJpeg($dst, $DestinationImage, $ImageQuality);
    
    ImageDestroy($src);
    ImageDestroy($dst);

	return TRUE;
  
  } // end image resize
  
 /******************************************************************
  * End of Program file
  ******************************************************************/

?>