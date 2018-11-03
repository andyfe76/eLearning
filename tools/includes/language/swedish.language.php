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
   "Continue"   => "Forts�tt",
   "Okay"       => "Ok",
   "Yes"        => "Ja",
   "No"         => "Nej",
   "Page"       => "Sida",
   "Top"        => "Upp",
   "Next"       => "N�sta",
   "Back"       => "F�reg�ende",
   "Search"     => "S�k",
   "Document"   => "Dokument",
   "Image"      => "Bild",
   "Link"       => "L�nk",
   "Folder"     => "Katalog",
   "Article"    => "Artikel",
   "Manage"     => "Administrera",
   "Logout"     => "Logga ut",
   "AdminEmail" => "Administrat�rs Epost",
   "AdminPass"  => "Administrat�rs L�senord",
   "Backup"     => "S�kerhetskopiera"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "Konfigurationsfilen �r inte kompatibel med denna installation av Terracotta, var god ominstallera Terracotta",
   "BadConfigurationTitle" => "Felaktig Konfigurationsfil",
   "NotImageFileTitle"     => "Detta �r inte en bildfil",
   "NotImageFile"          => "Den uppladdade filen �r inte accepterad som en webb bild, var god ladda endast upp JPEG, GIF eller PNG",
   "BadFile"               => "Filen hittades inte, ett epostmeddelande om detta har skickats till administrat�ren"
   
  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Avinstallera Terracotta personlig version",
   "Warning"   => "Denna funktion kommer radera alla l�nkar och objekt som har blivit publicerade via Terracotta. Var helt s�ker p� vad du g�r innan du forts�tter. Vi rekommenderar att du tar en backup p� ditt inneh�ll innan du forts�tter.",
   "Completed" => "Radering av alla l�nkar och objekt �r slutf�rd, du kan nu radera scriptfilerna f�r att slutf�ra avinstalltionen",
   "TitleFin"  => "Klar med radering av l�nkar och objekt",
   "Uninstall" => "Avinstallera"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "Administrations modul",
    "LoginTitle"             => "Logga in till administrationsr�nssnittet",
    "LoginMessage"           => "Du har bett om tilltr�de till administrations gr�nssnittet f�r denna Terracotta installtion, f�r att forts�tta m�ste du verifiera dig",
    "AdministrativeEmail"    => "Administrat�rs Epost",
    "AdministrativePassword" => "Administrat�rs L�senord",
    "LoginButton"            => "Administrera",
    "LoginOK"                => "Du har loggat in till det administrativa gr�nssnittet och kommer nu skickas tillbaka till galleriet med administrativa funktioner",
    "LoginBAD"               => "Inloggningen misslyckades, kontrollera Email och L�senord och f�rs�k igen",
    "LogoutMessage"          => "Du har loggats ut ifr�n den administrativa gr�snsnittet",
    "AdminModeMessage"       => "Administrativ Meny >> ",
    "AdminBarMessage"        => "Vad vill du g�ra? ",
    "Modify"                 => "Modifiera",
    "Add"                    => "Addera",
    "MultipleItemTitle"      => "Hur m�nga obejkt vill du l�gga till?",
    "MultipleItemDescribe"   => "Terracotta 0.6 st�djer addering av multipla objekt samtidigt<br>v�lj det antal objekt du vill l�gga till",
    "SelectNumber"           => "Hur m�nga vill du l�gga till?",
    "SelectType"             => "Vad vill du l�gga till?",
    "ConfirmDelete"          => "�r du s�ker p� att du vill l�gga till detta objekt? Processen �r o�terkallelig!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "L�gg till ny katalog",  
    "ModFolder"           => "Modifiera Katalog Information",
    "AddFolderMessage"    => "Fyll i de obligatoriska uppgifterna f�r verje katalog och klicka p� knappen f�r att skapa katalogerna",
    "ModFolderMessage"    => "Uppdatera kataloginformationen och klicka p� knappen f�r att spara. Ladda upp en ikon endast om du vill �ndra p� den",
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
  
    "AddImageTitle"       => "L�gg till ny bilder",
    "AddImageMessage"     => "V�lj de bilder du vill ladda upp ifr�n din dator till bildgalleriet, om din PHP installation inte st�djer ikongenerering eller om du har slagit av denna funktion m�ste du �ven ladda upp en ikon.",
    "EditImageTitle"      => "Editera Bildtext",
    "EditImageMessage"    => "Modifiera bildtexten och klicka sedan p� knappen f�r att spara �ndringarna.",
    "ImageFile"           => "Bild (JPG/PNG/GIF)",
    "ThumbnailFile"       => "Ikon (JPG/PNG/GIF)",
    "Caption"             => "Bildtext f�r denna bild",
    "AddButton"           => "Ladda upp bilder",
    "ModButton"           => "�ndra bildtext"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "L�gg till ny artikel",
    "EditArticleTitle"    => "Editera artikel",
    "AddArticleMessage"   => "Ge din artikel en titel och skriv in din text h�r nedan. Om funtionen teckeners�ttning �r p�slagen kommer radbrytningar ers�ttas med en BR tag n�r arikeln behandlas av websiten!",
    "ArticleHead"         => "Artikel Namn",
    "ArticleBody"         => "Artikel Text",
    "AddButton"           => "Spara Artikel"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "L�gg till ny Internet L�nk",
    "EditLinkTitle"    => "Editera Internet L�nk",
    "AddLinkMessage"   => "Ge l�nken en l�nktext och en komplett URL (mail, web, ftp) f�r att skapa en Internet L�nk p� din Terracotta website",
    "LinkCaption"      => "L�nktext",
    "LinkURL"          => "URL (mailto:, http:, ftp:)",
    "AddButton"        => "Skapa L�nkar",
    "ModButton"        => "Modifiera L�nkar"

  );

 /******************************************************************
  *
  ******************************************************************/

  $_MSG_TCPE_MANAGE_DOCUMENT = array(
  
    "AddDocTitle"      => "L�gg till nytt dokument",
    "ModDocTitle"      => "Modifiera ett befintligt dokument",
    "AddDocMessage"    => "V�lj dokument ifr�n din dator, ge dom en rubrik och klicka p� knappen f�r att l�gga till dom i arkivet. Observera att Terracotta kommer endast acceptera dokument som �r definierade i konfigurationsfilen",
    "ModDocMessage"    => "�ndra informationen om dokumentet och klicka p� knappen f�r att spara. V�lj en fil endast om du vill uppdatera filen p� server, om du ignorera filf�ltet kommer den existerande filen att beh�llas",
    "DocumentTitle"    => "Dokument Titel",
    "DocumentCaption"  => "Beskriv dokumentet",
    "DocFile"          => "V�lj fil att ladda upp",
    "AddButton"        => "Ladda upp Dokument",
    "ModButton"        => "�ndra Information"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "S�k i Dokument galleriet",
    "SearchMessage"    => "Skriv in de nyckelord du vill s�ka efter och<br>klicka p� knappen f�r att genomf�ra s�kningen",
    "SearchKeywords"   => "Skriv in de ord du vill s�ka efter, separera dom med ett kommatecken",
    "EntireSite"       => "S�k i hela dokument arkivet",
    "ThisDirectory"    => "S�k endast i denna katalog",
    "SearchButton"     => " S�k ",
    "SearchResults"    => "Resultat av din s�kning"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Bl�ddra i Katalog",
    "EditLabel"        => "Editera",
    "DeleteLabel"      => "Radera",
    "Article"          => "Artikel",
    "InternetLink"     => "Internet L�nk",
    "LastModified"     => "Senast Modifierad",
    "PrintArticle"     => "Skriv ut denna Artikel",
    "EmailAddress"     => "Epostadress",
    "MaintainedBy"     => "Sk�ts Av",
    "PrintedOn"        => "Utskriven",
    "Size"             => "Filstorlek",
    "KBytes"           => "Kilobyte",
    "ClickToDownload"  => "Ladda ner denna fil nu",
    "Mins"             => "Min.",
    "EmptyFolder"      => "Denna katalog inneh�ller inga obejkt",
    "EmptySearch"      => "Din s�kning gav inga tr�ffar",
    "SearchResults"    => "S�k Resultat",
    "DownloadPDF"      => "Ladda ner en PDF version"

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
