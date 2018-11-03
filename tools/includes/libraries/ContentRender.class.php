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
  * File:        ContentRender.class.php
  * Created by:  Devraj MUKHERJEE
  * Created on:  12th October 2002
  *
  * Summary:     Functions required to render the Terracotta managed
  *              content base.
  *
  ******************************************************************/
  
  /*
   * This class helps in rendering the content on the live web site
   * and makes the code streamlined and easy to modify
   *
   * Some functions have been adapted from 0.5.1 and been improved
   * for performance.
   *
   */

  class ContentRender {
  
    /*
     * Adapted from Original versions of Terracotta Version 0.5.x
     * modified to suit the 0.6 Engine theory
     *
     * This function is responsible for rendering the content of a directory
     * to the document gallery front end.
     *
     */
    
    function RenderDirectoryContents($result_list, $SearchResult) {
    
      // Get access to globally declared vars so that they dont have
      // to be passed in as params and the configuration file does
      // not have be included in every function
      
	  global $SCRIPT_SELF_REFERAL;
      global $ManageObject;                           
      global $_REQUEST;                               
      global $GalleryBaseDirectory;                   
      global $DateTimeFormat;
      global $_MSG_TCPE_RENDER;
      global $ArticlesExtention;
      global $ImageDirectoryName;
      global $ThumbnailDirectoryName;
      global $ImageCaptionsDirectory;
      global $FileSystemSeperator;
      global $FileRepositoryCaptionDirectoryName;
      global $FileRepositoryDirectoryName;
      global $DirectoryDescriptionFile;
      global $DirectoryTitleFile;
      global $ZipFileFormat;
      global $SpacerGIFName;
      global $DefaultPHPName;
      global $ObjectsPerPage;
      global $ObjectsPerRow;
      global $MainRowFontColor;
      global $FontFamily;
      global $file_type_list;
      global $LinkFileExtention;
      global $OpenLinksInNewWindow;
      global $GalleryBaseURL;
      global $GalleryIconFile;
      global $ThumbnailBorderSize;
      
      global $LinkTitleDirectory;
      global $FileRepositoryTitlesDirectoryName;
      global $ArticlesTitleDirectory;
      
      $CurrentDirectory = $_REQUEST["CurrentDirectory"]; // CurrentDirectory var from index
      $StartAt = $_REQUEST["StartAt"]; // Read from the URL input
      
      if(!$StartAt) $StartAt=0; // Set the value to 0 if the value if null
      
      $WorkingDirectory = $GalleryBaseDirectory.$CurrentDirectory;
      $RowCounter = 0;
      $EndAt = $StartAt + $ObjectsPerPage;
      $IterationCounter = 0;
      
      $WorkingDirectory = $GalleryBaseDirectory.$CurrentDirectory;
      $TotalItemsInDirectory = 0;
      
      // Cater for the situation when there are no items in the directory array 
      
      if(count($result_list) == 0) {
      
        if($SearchResult == TRUE) {
        
         $ResultText = "<br/><font color=\"$MainRowFontColor\" face=\"$FontFamily\" size=\"3\">".
                       "<b>".$_MSG_TCPE_RENDER["EmptySearch"]."</b></font><br/><br/>";
      
        }
        else {

         $ResultText = "<br/><font color=\"$MainRowFontColor\" face=\"$FontFamily\" size=\"3\">".
                       "<b>".$_MSG_TCPE_RENDER["EmptyFolder"]."</b></font><br/><br/>";
        
        }
        
        return $ResultText; // Return the search result and end here
      
      } // end empty directory messages
          
      // Get directory contents as an array using the function
      // $result_list = GetDirectoryContentsAsArray($WorkingDirectory);
      $EndAt = $StartAt + $ObjectsPerPage;
      if(count($result_list)<$EndAt) $EndAt = count($result_list);
      
      // Start a table to preseve the template design flexibility      
      $RenderText = $RenderText.'<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">';

      if($SearchResult == TRUE) {
      
        $RenderText = $RenderText."<font color=\"$MainRowFontColor\" face=\"$FontFamily\" size=\"3\"><img src=\"images/$SpacerGIFName\" height=5 width=10><br/>".
                      "<b>&nbsp;&nbsp;".$_MSG_TCPE_RENDER["SearchResults"]." > ".$_REQUEST["Keywords"]."</b></font><br/><img src=\"images/$SpacerGIFName\" height=7 width=10><br/>";
      
      } // end display of search result banner
      
      $RenderText = $RenderText.'<tr><td>';
     
      for($IteratorCounter=$StartAt; $IteratorCounter<$EndAt; $IteratorCounter++) {
        
        $file = $result_list[$IteratorCounter];
        $contents = "";
        
        if(is_dir($WorkingDirectory.$file)) {
        
          // Render Directory
          // 0.6 Ready
        
          // Read Caption from Directory Description file
          $GalleryCaption = ReadTextFromFile($GalleryBaseDirectory.$CurrentDirectory.$file.$FileSystemSeperator.$DirectoryDescriptionFile);
          $GalleryTitle   = ReadTextFromFile($GalleryBaseDirectory.$CurrentDirectory.$file.$FileSystemSeperator.$DirectoryTitleFile);
         
          // Show directory icon if it exists in the folder
          $IconImage = GetIconForFileType("folder");
          
          if(is_file($WorkingDirectory.$file.$FileSystemSeperator.$GalleryIconFile.".jpg")) $IconImage = $GalleryBaseURL.$CurrentDirectory.$file."/".$GalleryIconFile.".jpg";
          if(is_file($WorkingDirectory.$file.$FileSystemSeperator.$GalleryIconFile.".jpeg")) $IconImage = $GalleryBaseURL.$CurrentDirectory.$file."/".$GalleryIconFile.".jpeg"; 
          if(is_file($WorkingDirectory.$file.$FileSystemSeperator.$GalleryIconFile.".gif")) $IconImage = $GalleryBaseURL.$CurrentDirectory.$file."/".$GalleryIconFile.".gif";
          if(is_file($WorkingDirectory.$file.$FileSystemSeperator.$GalleryIconFile.".png")) $IconImage = $GalleryBaseURL.$CurrentDirectory.$file."/".$GalleryIconFile.".png"; 
          
          if($RowCounter==0) $RenderText = $RenderText."<tr width=\"100%\">";
          $RenderText = $RenderText."<td valign=\"top\" align=\"center\"><a href=\"$SCRIPT_SELF_REFERAL?FileType=Folder&CurrentDirectory=$CurrentDirectory$file/\"><img border=0 src=\"$IconImage\" alt=\"".$_MSG_TCPE_RENDER["BrowseFolder"]."\"></a><br/>";
          $RenderText = $RenderText."<font color=\"$MainRowFontColor\" face=\"$FontFamily\" size=2><b>$GalleryTitle</b></font><br/><font face=\"$FontFamily\" size=1>$GalleryCaption</font><br/>";
          
          if($ManageObject->IsAdminLoggedIn()) {
            $RenderText = $RenderText."<font face=\"$FontFamily\" size=1 color=\"$MainRowFontColor\">";
            $RenderText = $RenderText."[".CreateLink("$SCRIPT_SELF_REFERAL?action=Delete&FileType=Folder&CurrentDirectory=$CurrentDirectory&File=$file",$_MSG_TCPE_RENDER["DeleteLabel"],FALSE,$MainRowFontColor)." | ".CreateLink("$SCRIPT_SELF_REFERAL?action=Edit&FileType=Folder&CurrentDirectory=$CurrentDirectory&File=$file",$_MSG_TCPE_RENDER["EditLabel"],FALSE,$MainRowFontColor)."]<br/>";
            $RenderText = $RenderText."</font>";
          }

          $RenderText = $RenderText."</td>";
          $RowCounter = $RowCounter + 1;

          if($RowCounter==$ObjectsPerRow) {
            $RenderText = $RenderText."</tr>";
            $RowCounter = 0;
          }

        }
        elseif (is_file($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$file)) {
        
          // Display an Image thumbnail
          // 0.6 Ready         
          
          if($RowCounter==0) $RenderText = $RenderText."<tr width=\"100%\">";
          $lastchanged = filectime($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$file);
          $changeddate = date($DateTimeFormat, $lastchanged);
          
          /*
          
          $ext   = strrchr ($file, "." );
          $label = substr($file,0,strlen($file)-strlen($ext));
          $label = str_replace("_"," ",$label);
          
          */
          
          $contents = ReadTextFromFile($WorkingDirectory.$ImageCaptionsDirectory.$FileSystemSeperator.$file.".txt");
          
          if(strlen($contents) > 30) $UpperLength = 27; else $UpperLength = strlen($contents);
          $ShortImageCaption = substr($contents, 0, $UpperLength)."..."; // -1 because of the length starting at 0

          $RenderText = $RenderText."<td valign=\"top\" align=\"center\"><a href=\"$SCRIPT_SELF_REFERAL?CurrentDirectory=$CurrentDirectory&FileType=Image&File=$file\"><img alt=\"$contents\" src=\"$GalleryBaseURL$CurrentDirectory$ThumbnailDirectoryName/$file\" border=\"$ThumbnailBorderSize\"></a><br/>";
          $RenderText = $RenderText."<font face=\"$FontFamily\" size=\"1\" color=\"$MainRowFontColor\"><b>$ShortImageCaption</b><br/>$changeddate<br/>";
          if($ManageObject->IsAdminLoggedIn()) $RenderText = $RenderText."[".CreateLink("$SCRIPT_SELF_REFERAL?action=Delete&CurrentDirectory=$CurrentDirectory&FileType=Image&File=$file",$_MSG_TCPE_RENDER["DeleteLabel"],FALSE,$MainRowFontColor)." | ".CreateLink("$SCRIPT_SELF_REFERAL?action=Edit&CurrentDirectory=$CurrentDirectory&FileType=Image&File=$file",$_MSG_TCPE_RENDER["EditLabel"],FALSE,$MainRowFontColor)."]<br/>";
          $RenderText = $RenderText."<br/></font></td>";
          $RowCounter = $RowCounter + 1;
          if($RowCounter==$ObjectsPerRow) {
            $RenderText = $RenderText."</tr>";
            $RowCounter = 0;
          }

        }
        elseif (is_file($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$file)) {
        
          // Display a File
          
          $ext = strrchr (urldecode($file) , "." );
          
          // Loop through the different binary file types
          foreach($file_type_list as $current_extention => $extention_details) {
          
            if((!strcasecmp ($ext, ".$current_extention"))) {
              list ($ext_description,$icon_file_name) = $extention_details;
              $icon_file_name = GetIconForFileType($current_extention);
            }

          }

  	     // Extract name if icon and link the file
         if($RowCounter==0) $RenderText = $RenderText."<tr width=\"100%\">";
         $lastchanged = filectime($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$file);
   	     $changeddate = date($DateTimeFormat, $lastchanged);
   	  
         $label = ReadTextFromFile($WorkingDirectory.$FileRepositoryTitlesDirectoryName.$FileSystemSeperator.$file.".txt");
  	  
         $RenderText = $RenderText."<td valign=\"top\" align=\"center\"><a href=\"$SCRIPT_SELF_REFERAL?CurrentDirectory=$CurrentDirectory&FileType=Document&File=$file\"><img border=0 src=\"$icon_file_name\"></a><br/>";
         $RenderText = $RenderText."<font face=\"$FontFamily\" size=1 color=\"$MainRowFontColor\"><b>$label</b><br/>$ext_description<br/>$changeddate<br/>";
         
         if($ManageObject->IsAdminLoggedIn()) $RenderText = $RenderText."[".CreateLink("$SCRIPT_SELF_REFERAL?action=Delete&CurrentDirectory=$CurrentDirectory&FileType=Document&File=$file",$_MSG_TCPE_RENDER["DeleteLabel"],FALSE,$MainRowFontColor)." | ".CreateLink("$SCRIPT_SELF_REFERAL?action=Edit&CurrentDirectory=$CurrentDirectory&FileType=Document&File=$file",$_MSG_TCPE_RENDER["EditLabel"],FALSE,$MainRowFontColor)."]<br/>";
         
         $RenderText = $RenderText."<br/></font></td>";
         $RowCounter = $RowCounter + 1;
         
         if($RowCounter==$ObjectsPerRow) {
           $RenderText = $RenderText."</tr>";
           $RowCounter = 0;
         }

         // End process

        }
        elseif (strrchr ($file , "." ) == (".".$LinkFileExtention))  {
        
          // Display a Link
          // 0.6 Ready, Links directly to target links
          // Follows rules in configuraiton file
          
          $ext    = strrchr($file , "." );
          $label  = ReadTextFromFile($WorkingDirectory.$LinkTitleDirectory.$FileSystemSeperator.$file.".txt"); 
          $LinkTo = ReadTextFromFile($WorkingDirectory.$FileSystemSeperator.$file);

          if($LinkTo != "") {
          
            if($RowCounter==0) $RenderText = $RenderText."<tr width=\"100%\">";
            $lastchanged = filectime($WorkingDirectory.$file);
            $changeddate = date($DateTimeFormat, $lastchanged);
            $LinkFileImage = GetIconForFileType("link");
   	    
            $RenderText = $RenderText."<td valign=\"top\" align=\"center\">".CreateLink($LinkTo,"<img border=0 src=\"$LinkFileImage\" alt=\"$LinkTo\">",$OpenLinksInNewWindow,"#000000")."<br/>";
            $RenderText = $RenderText."<font face=\"$FontFamily\" size=1 color=\"$MainRowFontColor\"><b>$label</b><br/>".$_MSG_TCPE_RENDER["InternetLink"]."<br/>$changeddate<br/>";
            if($ManageObject->IsAdminLoggedIn()) $RenderText = $RenderText."[".CreateLink("$SCRIPT_SELF_REFERAL?action=Delete&CurrentDirectory=$CurrentDirectory&FileType=Link&File=$file",$_MSG_TCPE_RENDER["DeleteLabel"],FALSE,$MainRowFontColor)." | ".CreateLink("$SCRIPT_SELF_REFERAL?action=Edit&CurrentDirectory=$CurrentDirectory&FileType=Link&File=$file",$_MSG_TCPE_RENDER["EditLabel"],FALSE,$MainRowFontColor)."]<br/>";
            $RenderText = $RenderText."</font></td>";
            $RowCounter = $RowCounter + 1;

            if($RowCounter==$ObjectsPerRow) {
              $RenderText = $RenderText."</tr>";
              $RowCounter = 0;
            }

          }

          // End Process

        }
        elseif (strrchr ($file , "." ) == (".".$ArticlesExtention))  {
        
          // Article rendering 
          // 0.6 Ready

          $ext   = strrchr ($file , "." );
          $label = ReadTextFromFile($WorkingDirectory.$ArticlesTitleDirectory.$FileSystemSeperator.$file.".txt");
          $ArticlesIcon = GetIconForFileType("article");
          
          if($RowCounter==0) $RenderText = $RenderText."<tr width=\"100%\">";
          $lastchanged = filectime($WorkingDirectory.$file);
          $changeddate = date($DateTimeFormat, $lastchanged);

          $RenderText = $RenderText."<td valign=\"top\" align=\"center\"><a href=\"$SCRIPT_SELF_REFERAL?CurrentDirectory=$CurrentDirectory&FileType=Article&File=$file\"><img border=0 src=\"$ArticlesIcon\"></a><br/>";
          $RenderText = $RenderText."<font face=\"$FontFamily\" size=\"1\" color=\"$MainRowFontColor\"><b>$label</b><br/>".$_MSG_TCPE_RENDER["Article"]."<br/>$changeddate<br/>";
          if($ManageObject->IsAdminLoggedIn()) $RenderText = $RenderText."[".CreateLink("$SCRIPT_SELF_REFERAL?action=Delete&CurrentDirectory=$CurrentDirectory&FileType=Article&File=$file",$_MSG_TCPE_RENDER["DeleteLabel"],FALSE,$MainRowFontColor)." | ".CreateLink("$SCRIPT_SELF_REFERAL?action=Edit&CurrentDirectory=$CurrentDirectory&FileType=Article&File=$file",$_MSG_TCPE_RENDER["EditLabel"],FALSE,$MainRowFontColor)."]<br/>";
          $RenderText = $RenderText."</font></td>";
          $RowCounter = $RowCounter + 1;

          if($RowCounter==$ObjectsPerRow) {
            $RenderText = $RenderText."</tr>";
            $RowCounter = 0;
          }

          // End Process

        }

      } // end for loop 
      
      // Fill in the empty colums
      If($RowCounter > 0 && $RowCounter<$ObjectsPerRow) {  
        for($FillerCounter=$RowCounter; $FillerCounter<$ObjectsPerRow; $FillerCounter++) {
          $RenderText = $RenderText."<td></td>";
        }
        $RenderText = $RenderText."</tr>";
      }
      
      // End table     
      $RenderText = $RenderText.'</table>';
      
      return $RenderText;

    } // end function

    /*
     * Adapted from Original versions of Terracotta Version 0.5.x
     * modified to suit the 0.6 Engine theory
     *
     * This function is responsible for rendering the details of a file
     * to the document gallery front end.
     *
     */
    
    function RenderFile() {
      
      global $GalleryBaseDirectory;
      global $ImageDirectoryName;
      global $FileSystemSeperator;
      global $_REQUEST;
      global $MainRowFontColor;
      global $FontFamily;
      global $ArticlesTitleDirectory;
      global $ArticlesDisplayFont;
      global $GenerateBRTagsForArticles;
      global $ArticleFontSize;
      global $_MSG_TCPE_RENDER;
      global $DateTimeFormat;
      global $ImageCaptionsDirectory;
      global $GalleryBaseURL;
      global $ImageBorderSize;
      global $FileRepositoryDirectoryName;
      global $file_type_list;
      global $FileRepositoryTitlesDirectoryName;
      global $FileRepositoryCaptionDirectoryName;
      global $BaudRates;
      global $DirectoryContents;
      global $DisplayNextAndBackButtons;
      global $SCRIPT_SELF_REFERAL;
      global $_MSG_TCPE_COMMON;
      
      global $ThumbnailDirectoryName;
      global $LinkFileExtention;
      global $ArticlesExtention;
      
      $CurrentDirectory = $_REQUEST["CurrentDirectory"];
      $FileType = $_REQUEST["FileType"];
      $File = $_REQUEST["File"];
      
      $WorkingDirectory = $GalleryBaseDirectory.$CurrentDirectory;
      
      // Start a table to preseve the template design flexibility      
      $RenderText = $RenderText.'<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center"><tr><td>';
      
      $contents = "";

      // Display images
      
      if($FileType=="Image") {
      
        if(is_file($GalleryBaseDirectory.$CurrentDirectory.$ImageDirectoryName.$FileSystemSeperator.$File)) {
        
          $contents = str_replace("\n","<br/>",ReadTextFromFile($GalleryBaseDirectory.$CurrentDirectory.$ImageCaptionsDirectory.$FileSystemSeperator.$File.".txt"));
          $RenderText = $RenderText."<tr><td><br/><center><img src=\"$GalleryBaseURL$CurrentDirectory$ImageDirectoryName/$File\" border=\"$ImageBorderSize\" alt=\"".str_replace("<br/>","\n",$contents)."\"><br/>";         
          $RenderText = $RenderText."<br/><font color=\"$MainRowFontColor\" face=\"$FontFamily\" size=2><b>$contents</b></font>";
          $RenderText = $RenderText."</center><br/></td></tr>";

       }
       
      } // end if for image
      
      // Display Binary files
      
      if($FileType=="Document") {
      
        if(is_file($GalleryBaseDirectory.$CurrentDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$File)) {

          $ext = strrchr ($File , "." );
          // Loop through the different binary file types
          foreach($file_type_list as $current_extention => $extention_details) {
          
            if((!strcasecmp ($ext, ".".$current_extention))) {
              list ($ext_description,$icon_file_name) = $extention_details;
              $IconFile = GetIconForFileType($current_extention);
            }
          
          }
          
          $label = ReadTextFromFile($GalleryBaseDirectory.$CurrentDirectory.$FileRepositoryTitlesDirectoryName.$FileSystemSeperator.$File.".txt");
          $contents = str_replace("\n","<br/>",ReadTextFromFile($GalleryBaseDirectory.$CurrentDirectory.$FileRepositoryCaptionDirectoryName.$FileSystemSeperator.$File.".txt"));
          
          $lastchanged = filectime($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$File);
          $changeddate = date($DateTimeFormat, $lastchanged);
          $filesize = filesize($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$File);
        
          $RenderText = $RenderText."<tr><td><br/><center><img src=\"$IconFile\"><br/><br/>";
          $RenderText = $RenderText."<font color=\"$MainRowFontColor\" face=\"$FontFamily\" size=\"2\"><b>$label</b><br/>";
        
          $RenderText = $RenderText."$ext_description<br/><br/>$contents<br/><br/>[<b><a href=\"$GalleryBaseURL$CurrentDirectory$FileRepositoryDirectoryName/$File\" STYLE=\"color:$MainRowFontColor;\">".$_MSG_TCPE_RENDER["ClickToDownload"]."</a></b>]<br/><br/></font>";
          $RenderText = $RenderText."<font color=\"$MainRowFontColor\" face=\"$FontFamily\" size=\"2\">".$_MSG_TCPE_RENDER["LastModified"]." $changeddate<br/>".$_MSG_TCPE_RENDER["Size"]." ".round($filesize/1024,2)." ".$_MSG_TCPE_RENDER["KBytes"]."<br/><br/>";
          foreach($BaudRates as $Baud) {
            $RenderText = $RenderText.CalculateDownloadTime($Baud,$filesize)." ".$_MSG_TCPE_RENDER["Mins"]." @ ".($Baud/1000)." Kbps<br/>";
          }
          $RenderText = $RenderText."</font></center><br/></td></tr>";

        } 
        
      } // end if for file
      
      if($FileType=="Article") {
      
        $ArticlesFile = $WorkingDirectory.$FileSystemSeperator.$File;

        if(is_file($ArticlesFile)) {
      
          $ArticlesContents = ReadTextFromFile($ArticlesFile);         
          $lastchanged = filectime($ArticlesFile);
          $changeddate = date($DateTimeFormat, $lastchanged);
          $ArticleTitle = ReadTextFromFile($WorkingDirectory.$FileSystemSeperator.$ArticlesTitleDirectory.$FileSystemSeperator.$File.".txt");
        
          $RenderText = $RenderText."<tr><td>";
          $RenderText = $RenderText."<table border=0 cellpadding=4 cellspacing=4 align=\"left\"><tr><td align=\"left\">";
          $RenderText = $RenderText."<font face=\"$ArticlesDisplayFont\" color=\"$MainRowFontColor\" size=\"$ArticleFontSize\">";
          
          if($GenerateBRTagsForArticles == TRUE) $RenderText = $RenderText.str_replace("\n","<br/>",$ArticlesContents);
          else $RenderText = $RenderText.$ArticlesContents;
          
          $RenderText = $RenderText."<br/><br/><b>$ArticleTitle</b><br/>".$_MSG_TCPE_RENDER["LastModified"]." $changeddate";
          $RenderText = $RenderText."<br/><br/>[<b>".CreateLink("$SCRIPT_SELF_REFERAL?action=PrintArticle&CurrentDirectory=$CurrentDirectory&File=$File&FileType=$FileType",$_MSG_TCPE_RENDER["PrintArticle"],TRUE,$MainRowFontColor)."</b> | <b>";
          $RenderText = $RenderText.CreateLink("$SCRIPT_SELF_REFERAL?action=DownloadPDF&CurrentDirectory=$CurrentDirectory&File=$File&FileType=$FileType",$_MSG_TCPE_RENDER["DownloadPDF"],TRUE,$MainRowFontColor)."</b>]";
          $RenderText = $RenderText."<br/></font></td></tr></table>";
          $RenderText = $RenderText."</td></tr>";
        
        }       

      } // end if for article
      
      $RenderText = $RenderText.'</table>';    
      
      /* This section displays the next and back buttons */
      
      if($DisplayNextAndBackButtons == TRUE) {
      
        $NextFile = "";
        $PreviousFile = "";

        if($DirectoryContents) {
        
          $CurrentPosition = array_search($File,$DirectoryContents);
          if($CurrentPosition>0) $PreviousFile = $DirectoryContents[$CurrentPosition-1];
          if($CurrentPosition<count($DirectoryContents)) $NextFile = $DirectoryContents[$CurrentPosition+1];

        }      
        
        $RenderText = $RenderText."<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\"><tr><td align=\"left\" width=\"50%\"><font face=\"$FontFamily\" size=\"2\"><b>";
             
        if ($PreviousFile != "") {

          if(is_dir($WorkingDirectory.$PreviousFile)) $RenderText = $RenderText."&lt;&lt; ".CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory$PreviousFile/&File=&FileType=Folder",$_MSG_TCPE_COMMON["Back"],FALSE,$MainRowFontColor);
          elseif (is_file($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$PreviousFile)) $RenderText = $RenderText."&lt;&lt; ".CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory&File=$PreviousFile&FileType=Image",$_MSG_TCPE_COMMON["Back"],FALSE,$MainRowFontColor);
          elseif (is_file($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$PreviousFile)) $RenderText."&lt;&lt; ".CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory&File=$PreviousFile&FileType=File",$_MSG_TCPE_COMMON["Back"],FALSE,$MainRowFontColor);
          elseif (strrchr ($PreviousFile , "." ) == (".".$LinkFileExtention)) {
            
            $LinkURL = ReadTextFromFile($WorkingDirectory.$PreviousFile);
            $RenderText = $RenderText."&lt;&lt; ".CreateLink($LinkURL,$_MSG_TCPE_COMMON["Back"],FALSE,$MainRowFontColor);
            
          }
          elseif (strrchr ($PreviousFile , "." ) == (".".$ArticlesExtention)) $RenderText = $RenderText."&lt;&lt; ".CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory&File=$PreviousFile&FileType=Article",$_MSG_TCPE_COMMON["Back"],FALSE,$MainRowFontColor);         
          
        }
      
        $RenderText = $RenderText."</b></font></td><td align=\"right\" width=\"50%\"><font face=\"$FontFamily\" size=\"2\"><b>";
        
        if($NextFile != "") {

          if(is_dir($WorkingDirectory.$NextFile)) $RenderText = $RenderText.CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory$NextFile/&File=&FileType=Folder",$_MSG_TCPE_COMMON["Next"],FALSE,$MainRowFontColor)." &gt;&gt;";
          elseif (is_file($WorkingDirectory.$ThumbnailDirectoryName.$FileSystemSeperator.$NextFile)) $RenderText = $RenderText.CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory&File=$NextFile&FileType=Image",$_MSG_TCPE_COMMON["Next"],FALSE,$MainRowFontColor)." &gt;&gt;";
          elseif (is_file($WorkingDirectory.$FileRepositoryDirectoryName.$FileSystemSeperator.$NextFile)) $RenderText = $RenderText.CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory&File=$NextFile&FileType=Document",$_MSG_TCPE_COMMON["Next"],FALSE,$MainRowFontColor)." &gt;&gt;";
          elseif (strrchr ($NextFile , "." ) == (".".$LinkFileExtention)) {
          
            $LinkURL = ReadTextFromFile($WorkingDirectory.$NextFile);
            $RenderText = $RenderText.CreateLink($LinkURL, $_MSG_TCPE_COMMON["Next"],FALSE,$MainRowFontColor)." &gt;&gt;";
          
          }
          elseif (strrchr ($NextFile , "." ) == (".".$ArticlesExtention)) $RenderText = $RenderText.CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=$CurrentDirectory&File=$NextFile&FileType=Article",$_MSG_TCPE_COMMON["Next"],FALSE,$MainRowFontColor)." &gt;&gt;";
        
        }
      
        $RenderText = $RenderText."</b></td></tr></table>";
                      
      } // end display next and back
                    
      /* End the display code */
     
      return $RenderText;
    
    } // end function Render File
  
    /*
     * DisplaNavaigationBar displays the top navigation bar so that
     * the user can move between directories.
     *
     * The function depends on configuration and language variables
     *
     */
  
    function DisplayNavigationBar($CurrentDirectory) {
    
      global $GalleryBaseDirectory;
      global $SCRIPT_SELF_REFERAL;
      global $FileSystemSeperator;
      global $VisualCharacterSeperator;
      global $InformationRowFontColor;
      global $_MSG_TCPE_COMMON;
      global $DirectoryTitleFile;
      global $DisplayTopLabel;
    
      $TotalItemsInDirectory = 0;    
      $SplitDirectory = explode($FileSystemSeperator,$CurrentDirectory);
      
      if($DisplayTopLabel == TRUE)
      $NavigationBar = "<b>".CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=",$_MSG_TCPE_COMMON["Top"],FALSE,$InformationRowFontColor)."</b> ".$VisualCharacterSeperator;
      
      for($counter=0; $counter<(count($SplitDirectory)-1); $counter++) {
       
        $CompleteDirectory = $CompleteDirectory.$SplitDirectory[$counter].$FileSystemSeperator;
        $DirectoryTitle = ReadTextFromFile($GalleryBaseDirectory.$CompleteDirectory.$DirectoryTitleFile);
        $NavigationBar = $NavigationBar." <b>".CreateLink($SCRIPT_SELF_REFERAL."?CurrentDirectory=".$CompleteDirectory,$DirectoryTitle,FALSE,$InformationRowFontColor)."</b> ".$VisualCharacterSeperator;
        
      }

      return $NavigationBar;    

    }
    
    /*
     * Display page numbers is function that will allow generation of links
     * for page numbers on the gallery live web site
     *
     * It has been adapted from 0.5.1 and been modified to fit in to the new
     * OO design with the InfoBase files in place
     *
     */

    function DisplayPageNumbers($result_list) {

      global $GalleryBaseDirectory;
      global $SCRIPT_SELF_REFERAL;
      global $FileSystemSeperator;
      global $InformationRowFontColor;
      global $_MSG_TCPE_COMMON;
      global $_REQUEST;
      global $ObjectsPerPage;
      
      $CurrentDirectory = $_REQUEST["CurrentDirectory"];

      $WorkingDirectory = $GalleryBaseDirectory.$CurrentDirectory;
      $TotalItemsInDirectory = 0;
    
      if(count($result_list)>$ObjectsPerPage) {
      
        $PageNumber = 1;
        $PageNumberText = $_MSG_TCPE_COMMON["Page"]."&nbsp;&nbsp;";
        for($counter=0; $counter<count($result_list); $counter=$counter+$ObjectsPerPage) {
          $PageNumberText = $PageNumberText."(<b>".CreateLink("$SCRIPT_SELF_REFERAL?CurrentDirectory=$CurrentDirectory&StartAt=$counter",$PageNumber,FALSE,$InformationRowFontColor)."</b>)&nbsp;";
          $PageNumber++;
        }
      }
 
      return $PageNumberText;    

    }

    /*
     * Render Article in PDF format using the FPDF libraries
     *
     * http://www.fpdf.org/ for more information on the libraries
     *
     */
    
    function RenderArticleInPDFFormat() {
    
      global $GalleryBaseDirectory;
      global $_REQUEST;
      global $FileSystemSeperator;
      global $ArticlesTitleDirectory;
      global $DateTimeFormat;
      global $SiteAdministratorName;
      global $FPDF_FontName;
      global $_MSG_TCPE_RENDER;
      global $SiteAdminEmailAddress;
      global $HomePageURL;

      $WorkingDirectory = $GalleryBaseDirectory.$_REQUEST["CurrentDirectory"];
      $ArticlesFile = $WorkingDirectory.$FileSystemSeperator.$_REQUEST["File"];
      $ArticleTitle = ReadTextFromFile($WorkingDirectory.$FileSystemSeperator.$ArticlesTitleDirectory.$FileSystemSeperator.$_REQUEST["File"].".txt");
      $lastchanged = filectime($ArticlesFile);
      $changeddate = date($DateTimeFormat, $lastchanged);
 
      $pdf=new FPDF();
      $pdf->Open();
      $pdf->AliasNbPages();
      $pdf->AddPage();
      $pdf->SetAutoPageBreak(TRUE);
      $pdf->SetAuthor($SiteAdministratorName);
      $pdf->SetTitle($ArticleTitle);
    
      $pdf->SetFont($FPDF_FontName,'B',16);    
      $pdf->Cell(40,10,$ArticleTitle,0,1);
      
      $pdf->SetFont($FPDF_FontName,'',12);
      $pdf->Cell(0,5,$_MSG_TCPE_RENDER["MaintainedBy"]." ".$SiteAdministratorName." (".$SiteAdminEmailAddress.")",0,1);
      $pdf->Cell(0,5,$_MSG_TCPE_RENDER["LastModified"]." ".$changeddate,0,1);
      $pdf->Cell(0,5,$_MSG_TCPE_RENDER["PrintedOn"]." ".date($DateTimeFormat),0,1);
    
      $pdf->Ln(8);
    
      $fd = fopen ($ArticlesFile, "r");
      while(!feof ($fd)) {
    
        $inputchr = fgetc($fd);
      
        if($inputchr == "\n") {
          $pdf->Cell(0,1.5,stripslashes($ArticlesContents),0,1);   
          $pdf->Ln();
          $ArticlesContents = "";
        }
        else {
          $ArticlesContents = $ArticlesContents.$inputchr;
        }
        
      }

      $pdf->Cell(0,1.5,stripslashes($ArticlesContents),0,1); // Last Buffer incase there was no Cr
      $pdf->Ln();

      $pdf->Ln(8);
      $pdf->Cell(0,5,$HomePageURL,0,1);
      $pdf->Ln();
    
      $pdf->SetFont("Arial",'',8);
      $pdf->Cell(0,5,"Published using the The Terracotta Project and The FPDF libraries",0,1);    
      $pdf->Cell(0,3,"http://terracotta.sourceforge.net/",0,1);

      $pdf->Output();    

    } // end PDF generation function
    
  
 } // end class here

 /******************************************************************
  * End of Program file
  ******************************************************************/

?>
