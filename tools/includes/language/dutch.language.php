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
  * File:        dutch.language.php
  * Created by:  Hugo Maerten (huGo@webshapes.nl)
  * Created on:  4 December 2002
  *
  * Natural language definition developers can use this file as a
  * template and make their custom language files. Please do contribute
  * your language files to the Terracotta project at
  * terracotta-devel@lists.sourceforge.net
  *
  * Language:    Dutch
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
   "Version"    => "Versie",
   "Home"       => "Home",
   "Edit"       => "Bewerk",
   "Delete"     => "Verwijder",
   "Continue"   => "Ga door",
   "Okay"       => "O.K.",
   "Yes"        => "Ja",
   "No"         => "Nee",
   "Page"       => "Pagina",
   "Top"        => "Top",
   "Next"       => "Verder",
   "Back"       => "Terug",
   "Search"     => "Zoek",
   "Document"   => "Dokument",
   "Image"      => "Foto",
   "Link"       => "Link",
   "Folder"     => "Folder",
   "Article"    => "Artikel",
   "Manage"     => "Manage",
   "Logout"     => "Uitloggen",
   "AdminEmail" => "Administratie E-mail",
   "AdminPass"  => "Administratie Wachtwoord",
   "Backup"     => "Backup"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "Het configuratiebestand is niet geldig voor deze installatie van Terracotta; installeer Terracotta opnieuw.",
   "BadConfigurationTitle" => "Fout configuatiebestand."

  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Verwijder Terracotta personal edition",
   "Warning"   => "Hiermee verwijdert u alles wat u met Terracotta heeft gepubliceerd van deze server. Dit proces is onomkeerbaar en u wordt aangeraden eerst een backup te maken.",
   "Uninstall" => "Verwijder"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "Administratie Module",  
    "LoginTitle"             => "Login in het administratie paneel.",
    "LoginMessage"           => "U wilt de administratie van deze Terracotta-site voeren. Vooraleer verder te gaan moet u aantonen daartoe over de juiste toegangsrechten te beschikken.",
    "AdministrativeEmail"    => "Administratie E-mail",
    "AdministrativePassword" => "Administratie Wachtwoord",
    "LoginButton"            => "Administratie",
    "LoginOK"                => "U bent ingelogd en wordt met alle beheers-opties  doorgeschakeld naar de Terracotta gallerij.",
    "LoginBAD"               => "Uw gegevens konden niet gekontroleerd worden, probeer het nog eens.",
    "LogoutMessage"          => "U bent uitgelogd uit het adminstratie paneel.",
    "AdminModeMessage"       => "Administratie Menu >> ",
    "AdminBarMessage"        => "Wat wilt u doen? ",
    "Modify"                 => "Wijzig",
    "Add"                    => "Voeg toe",
    "MultipleItemTitle"      => "Hoeveel items wilt u toevoegen?",
    "MultipleItemDescribe"   => "Terracotta 0.6 ondersteunt het gelijktijdig toevoegen van meerdere items<br>kies het aantal items dat u toe wilt voegen.",
    "SelectNumber"           => "Hoeveel wilt u er toevoegen?",
    "SelectType"             => "Wat wilt u toevoegen?",
    "ConfirmDelete"          => "Weet u zeker dat u dit item wilt verwijderen? Dit kan niet ongedaan gemaakt worden!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "Voeg Nieuwe Folders toe",  
    "AddFolderMessage"    => "Vul de benodigde gegevens voor elke folder in en klik op de knop om de folders te maken.",
    "FolderName"          => "Naam Folder",
    "FolderDescription"   => "Beschrijving van de Folder",
    "FolderIcon"          => "Folder Icoon (JPG/GIF/PNG)",
    "AddButton"           => "Maak Folders"
    

  );

 /******************************************************************
  * Image Management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_IMAGE = array(
  
    "AddImageTitle"       => "Voeg Nieuwe Foto's toe",
    "AddImageMessage"     => "Kies de foto's die van uw computer naar de gallerij opgeladen moeten worden; indien uw PHP installatie het maken van thumbnails (klein formaat afbeeldingen) niet ondersteunt, of als u deze mogelijkheid uitgeschakeld hebt, dan moet u zelf ook een thumbnail maken en opladen.",
    "ImageFile"           => "Foto (JPG/PNG/GIF)",
    "ThumbnailFile"       => "Thumbnail (JPG/PNG/GIF)",
    "Caption"             => "Beschrijving van foto",
    "AddButton"           => "Laad Foto's"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "Voeg Nieuw Artikel toe",
    "EditArticleTitle"    => "Wijzig Artikel",
    "AddArticleMessage"   => "Geef uw Artikel een titel en tik uw tekst hieronder. Als u heeft ingesteld dat karakters vervangen worden, dan zal automatisch voor elke nieuwe regel een BR tag ingevoegd worden in uw tekst op de website.",
    "ArticleHead"         => "Naam Artikel",
    "ArticleBody"         => "Tekst van Artikel",
    "AddButton"           => "Bewaar Artikel"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "Voeg Nieuwe Internet Link toe",
    "EditLinkTitle"    => "Wijzig Internet Link",
    "AddLinkMessage"   => "Geef een beschrijving en de volledige URL (mail, web, ftp) om een  Link te maken op uw Terracotta website.",
    "LinkCaption"      => "Beschrijving Link",
    "LinkURL"          => "URL (mailto:, http:, ftp:)",
    "AddButton"        => "Maak Links",
    "ModButton"        => "Wijzig Links"

  );

 /******************************************************************
  *
  ******************************************************************/

  $_MSG_TCPE_MANAGE_DOCUMENT = array(
  
    "AddDocTitle"      => "Voeg Nieuw Dokument toe",
    "AddDocMessage"    => "Selecteer de dokumenten op uw computer, geef ze elk een beschrijving en klik op de knop om de dokumenten toe te voegen aan uw gallerij. Let op dat Terracotta alleen dokumenten accepteert van de types die gedefiniëerd zijn in de configuratie.",
    "DocumentTitle"    => "Titel van Dokument",
    "DocumentCaption"  => "Beschrijving van Dokument",
    "DocFile"          => "Selecteer het bestand dat opgeladen moet worden.",
    "AddButton"        => "Laad Dokumenten"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "Doorzoek de Dokumenten gallerij",
    "SearchMessage"    => "Geef uw zoektermen op en<br>klik op de knop om de overeenkomstige items weer te geven.",
    "SearchKeywords"   => "Zoekcriteria, zet een komma tussen de zoektermen.",
    "EntireSite"       => "Doorzoek de hele gallerij",
    "ThisDirectory"    => "Zoek alleen in deze folder",
    "SearchButton"     => " Zoek Nu ",
    "SearchResults"    => "Zoekresultaten"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Blader door de Folder",
    "EditLabel"        => "Wijzig",
    "DeleteLabel"      => "Verwijder",
    "Article"          => "Artikel",
    "InternetLink"     => "Internet Link",
    "LastModified"     => "Laatst gewijzigd",
    "PrintArticle"     => "Print dit Artikel.",
    "EmailAddress"     => "E-mail",
    "MaintainedBy"     => "Bijgehouden door",
    "PrintedOn"        => "Geprint Op",
    "Size"             => "Bestandsgrootte",
    "KBytes"           => "Kilo Bytes",
    "ClickToDownload"  => "Download dit bestand Nu",
    "Mins"             => "Mins.",
    "EmptyFolder"      => "Deze folder is leeg.",
    "EmptySearch"      => "Uw zoekactie heeft geen resultaat opgeleverd.",
    "SearchResults"    => "Zoekresultaten",
    "DownloadPDF"      => "Download een PDF versie."

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
