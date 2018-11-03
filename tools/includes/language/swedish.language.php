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
  * File:        swedish.language.php
  * Created by:  Christian Wallin (crille@swipnet.se)
  * Created on:  19th January 2003 16:36
  *
  * Natural language definition developers can use this file as a
  * template and make their custom language files. Please do contribute
  * your language files to the Terracotta project at
  * terracotta-devel@lists.sourceforge.net
  *
  * Language:    Swedish (sv_SE Sweden, some parts of Finland)
  ******************************************************************/

 /* Defines the font family to be used for support of the language */

  $FontFamily        = "Verdana";
  $CharType          = "UTF-8";
  $XHTMLLanguageCode = "EN";

 /******************************************************************
  * Common messages
  ******************************************************************/

  $_MSG_TCPE_COMMON = array(

   "APP_TITLE"  => "Terracotta Personlig Version",
   "Version"    => "Version",
   "Home"       => "Hem",
   "Edit"       => "Editera",
   "Delete"     => "Radera",
   "Continue"   => "Fortsätt",
   "Okay"       => "Ok",
   "Yes"        => "Ja",
   "No"         => "Nej",
   "Page"       => "Sida",
   "Top"        => "Upp",
   "Next"       => "Nästa",
   "Back"       => "Föregående",
   "Search"     => "Sök",
   "Document"   => "Dokument",
   "Image"      => "Bild",
   "Link"       => "Länk",
   "Folder"     => "Katalog",
   "Article"    => "Artikel",
   "Manage"     => "Administrera",
   "Logout"     => "Logga ut",
   "AdminEmail" => "Administratörs Epost",
   "AdminPass"  => "Administratörs Lösenord",
   "Backup"     => "Säkerhetskopiera"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "Konfigurationsfilen är inte kompatibel med denna installation av Terracotta, var god ominstallera Terracotta",
   "BadConfigurationTitle" => "Felaktig Konfigurationsfil",
   "NotImageFileTitle"     => "Detta är inte en bildfil",
   "NotImageFile"          => "Den uppladdade filen är inte accepterad som en webb bild, var god ladda endast upp JPEG, GIF eller PNG",
   "BadFile"               => "Filen hittades inte, ett epostmeddelande om detta har skickats till administratören"
   
  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Avinstallera Terracotta personlig version",
   "Warning"   => "Denna funktion kommer radera alla länkar och objekt som har blivit publicerade via Terracotta. Var helt säker på vad du gör innan du fortsätter. Vi rekommenderar att du tar en backup på ditt innehåll innan du fortsätter.",
   "Completed" => "Radering av alla länkar och objekt är slutförd, du kan nu radera scriptfilerna för att slutföra avinstalltionen",
   "TitleFin"  => "Klar med radering av länkar och objekt",
   "Uninstall" => "Avinstallera"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "Administrations modul",
    "LoginTitle"             => "Logga in till administrationsränssnittet",
    "LoginMessage"           => "Du har bett om tillträde till administrations gränssnittet för denna Terracotta installtion, för att fortsätta måste du verifiera dig",
    "AdministrativeEmail"    => "Administratörs Epost",
    "AdministrativePassword" => "Administratörs Lösenord",
    "LoginButton"            => "Administrera",
    "LoginOK"                => "Du har loggat in till det administrativa gränssnittet och kommer nu skickas tillbaka till galleriet med administrativa funktioner",
    "LoginBAD"               => "Inloggningen misslyckades, kontrollera Email och Lösenord och försök igen",
    "LogoutMessage"          => "Du har loggats ut ifrån den administrativa gräsnsnittet",
    "AdminModeMessage"       => "Administrativ Meny >> ",
    "AdminBarMessage"        => "Vad vill du göra? ",
    "Modify"                 => "Modifiera",
    "Add"                    => "Addera",
    "MultipleItemTitle"      => "Hur många obejkt vill du lägga till?",
    "MultipleItemDescribe"   => "Terracotta 0.6 stödjer addering av multipla objekt samtidigt<br>välj det antal objekt du vill lägga till",
    "SelectNumber"           => "Hur många vill du lägga till?",
    "SelectType"             => "Vad vill du lägga till?",
    "ConfirmDelete"          => "Är du säker på att du vill lägga till detta objekt? Processen är oåterkallelig!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "Lägg till ny katalog",  
    "ModFolder"           => "Modifiera Katalog Information",
    "AddFolderMessage"    => "Fyll i de obligatoriska uppgifterna för verje katalog och klicka på knappen för att skapa katalogerna",
    "ModFolderMessage"    => "Uppdatera kataloginformationen och klicka på knappen för att spara. Ladda upp en ikon endast om du vill ändra på den",
    "FolderName"          => "Katalognamn",
    "FolderDescription"   => "Beskrivning av Katalogen",
    "FolderIcon"          => "Egen katalog ikon (JPG/GIF/PNG)",
    "AddButton"           => "Skapa kataloger",
    "ModButton"           => "Uppdatera titlar"

  );

 /******************************************************************
  * Image Management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_IMAGE = array(
  
    "AddImageTitle"       => "Lägg till ny bilder",
    "AddImageMessage"     => "Välj de bilder du vill ladda upp ifrån din dator till bildgalleriet, om din PHP installation inte stödjer ikongenerering eller om du har slagit av denna funktion måste du även ladda upp en ikon.",
    "EditImageTitle"      => "Editera Bildtext",
    "EditImageMessage"    => "Modifiera bildtexten och klicka sedan på knappen för att spara ändringarna.",
    "ImageFile"           => "Bild (JPG/PNG/GIF)",
    "ThumbnailFile"       => "Ikon (JPG/PNG/GIF)",
    "Caption"             => "Bildtext för denna bild",
    "AddButton"           => "Ladda upp bilder",
    "ModButton"           => "Ändra bildtext"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "Lägg till ny artikel",
    "EditArticleTitle"    => "Editera artikel",
    "AddArticleMessage"   => "Ge din artikel en titel och skriv in din text här nedan. Om funtionen teckenersättning är påslagen kommer radbrytningar ersättas med en BR tag när arikeln behandlas av websiten!",
    "ArticleHead"         => "Artikel Namn",
    "ArticleBody"         => "Artikel Text",
    "AddButton"           => "Spara Artikel"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "Lägg till ny Internet Länk",
    "EditLinkTitle"    => "Editera Internet Länk",
    "AddLinkMessage"   => "Ge länken en länktext och en komplett URL (mail, web, ftp) för att skapa en Internet Länk på din Terracotta website",
    "LinkCaption"      => "Länktext",
    "LinkURL"          => "URL (mailto:, http:, ftp:)",
    "AddButton"        => "Skapa Länkar",
    "ModButton"        => "Modifiera Länkar"

  );

 /******************************************************************
  *
  ******************************************************************/

  $_MSG_TCPE_MANAGE_DOCUMENT = array(
  
    "AddDocTitle"      => "Lägg till nytt dokument",
    "ModDocTitle"      => "Modifiera ett befintligt dokument",
    "AddDocMessage"    => "Välj dokument ifrån din dator, ge dom en rubrik och klicka på knappen för att lägga till dom i arkivet. Observera att Terracotta kommer endast acceptera dokument som är definierade i konfigurationsfilen",
    "ModDocMessage"    => "Ändra informationen om dokumentet och klicka på knappen för att spara. Välj en fil endast om du vill uppdatera filen på server, om du ignorera filfältet kommer den existerande filen att behållas",
    "DocumentTitle"    => "Dokument Titel",
    "DocumentCaption"  => "Beskriv dokumentet",
    "DocFile"          => "Välj fil att ladda upp",
    "AddButton"        => "Ladda upp Dokument",
    "ModButton"        => "Ändra Information"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "Sök i Dokument galleriet",
    "SearchMessage"    => "Skriv in de nyckelord du vill söka efter och<br>klicka på knappen för att genomföra sökningen",
    "SearchKeywords"   => "Skriv in de ord du vill söka efter, separera dom med ett kommatecken",
    "EntireSite"       => "Sök i hela dokument arkivet",
    "ThisDirectory"    => "Sök endast i denna katalog",
    "SearchButton"     => " Sök ",
    "SearchResults"    => "Resultat av din sökning"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Bläddra i Katalog",
    "EditLabel"        => "Editera",
    "DeleteLabel"      => "Radera",
    "Article"          => "Artikel",
    "InternetLink"     => "Internet Länk",
    "LastModified"     => "Senast Modifierad",
    "PrintArticle"     => "Skriv ut denna Artikel",
    "EmailAddress"     => "Epostadress",
    "MaintainedBy"     => "Sköts Av",
    "PrintedOn"        => "Utskriven",
    "Size"             => "Filstorlek",
    "KBytes"           => "Kilobyte",
    "ClickToDownload"  => "Ladda ner denna fil nu",
    "Mins"             => "Min.",
    "EmptyFolder"      => "Denna katalog innehåller inga obejkt",
    "EmptySearch"      => "Din sökning gav inga träffar",
    "SearchResults"    => "Sök Resultat",
    "DownloadPDF"      => "Ladda ner en PDF version"

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
