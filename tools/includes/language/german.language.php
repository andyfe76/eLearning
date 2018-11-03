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
  * File:        german.language.php
  * Created by:  Jörn Tschersich (schneemensch@users.sourceforge.net)
  * Created on:  13th December 2002 (my birthday! woohoo!!! ;-)
  *
  * So, ma'n paar Worte auf Deutsch, ne?! ;-)
  * Ich hab hier eine förmliche Version gemacht (Sie-Anrede). Natürlich
  * mag es für die eine oder andere Website stilistisch besser (weil
  * konsistenter) sein, die Du-Anrede zu benutzen.
  * Dafür darf gerne ein eigenes Language File erstellt werden bzw.
  * vielleicht werde ich mich sogar in den nächsten Tagen noch dahinter
  * klemmen.
  * Auf jeden Fall viel Erfolg mit Terracotta auf Deutsch! =)
  * Meine Webseite (mit Terracotta): http://www.aufwind-koeln.de/kreis/gallery
  * Meine private Webseite: http://jt.kiss.to
  *
  * Language:    German, formal (DE/AT/CH/LI)
  *
  ******************************************************************/

 /* Defines the font family to be used for support of the language */

  $FontFamily        = "Verdana";
  $CharType          = "ISO-8859-1";
  $XHTMLLanguageCode = "EN"; // uhm, there is no other defined yet ... :-(

 /******************************************************************
  * Common messages
  ******************************************************************/

  $_MSG_TCPE_COMMON = array(

   "APP_TITLE"  => "Terracotta Pers&ouml;nliche Ausgabe",
   "Version"    => "Version",
   "Home"       => "Index",
   "Edit"       => "Bearbeiten",
   "Delete"     => "L&ouml;schen",
   "Continue"   => "Weiter",
   "Okay"       => "OK",
   "Yes"        => "Ja",
   "No"         => "Nein",
   "Page"       => "Seite",
   "Top"        => "Anfang",
   "Next"       => "Weiter",
   "Back"       => "Zurück",
   "Search"     => "Suche",
   "Document"   => "Dokument",
   "Image"      => "Bild",
   "Link"       => "Link",
   "Folder"     => "Ordner",
   "Article"    => "Artikel",
   "Manage"     => "Verwalten",
   "Logout"     => "Ausloggen",
   "AdminEmail" => "Administrator-E-Mail",
   "AdminPass"  => "Administrator-Passwort",
   "Backup"     => "Sicherung"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "Die Konfigurationsdatei ist nicht kompatibel mit dieser Terracotta-Installation, bitte installieren Sie Terracotta erneut!",
   "BadConfigurationTitle" => "Konfigurationsdatei fehlerhaft",
   "NotImageFileTitle"     => "Keine Bilddatei",
   "NotImageFile"          => "Die von Ihnen hochgeladene Datei ist kein Internet-Bild. Bitte nur JPEG, GIF oder PNG hochladen!",
   "BadFile"               => "Die gew&uuml;nschte Datei konnte nicht gefunden werden, der Administrator ist benachrichtigt."

  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Deinstallation von Terracotta PE",
   "Warning"   => "Sie sind dabei, Terracotta und alle dazugehörigen Dateien und jeglichen Inhalt vom Server zu l&ouml;schen. Dies ist ein unwiderruflicher Prozess und sollte gut &uuml;berlegt sein. Wir empfehlen au&szlig;erdem, eine Sicherungskopie des Inhalts anzufertigen, bevor Sie fortfahren!",
   "Completed" => "Das L&ouml;schen der Dateien wurde erfolgreich abgeschlossen, Sie k&ouml;nnen jetzt die Skripte manuell vom Server l&ouml;schen, um die Deinstallation abzuschlie&szlig;en.",
   "TitleFin"  => "L&ouml;schen des Inhalts erfolgt",
   "Uninstall" => "Deinstallation"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "Administrationsmodul",
    "LoginTitle"             => "Login zum Management Interface",
    "LoginMessage"           => "Sie wollen Zugriff auf die Verwaltungsfunktionen f&uuml;r diese Terracotta-Webseite nehmen. Bitte identifizieren Sie sich:",
    "AdministrativeEmail"    => "Administrator-E-Mail",
    "AdministrativePassword" => "Administrator-Passwort",
    "LoginButton"            => "Einloggen",
    "LoginOK"                => "Der Login war erfolgreich. Sie werden nun zur&uuml;ck in die Galerie geleitet, mit Administratorprivilegien.",
    "LoginBAD"               => "Die angegebene Benutzername-Passwort-Kombination stimmte nicht &uuml;berein. Bitte versuchen Sie es erneut.",
    "LogoutMessage"          => "Der Logout war erfolgreich.",
    "AdminModeMessage"       => "Administratormenü >> ",
    "AdminBarMessage"        => "Was m&ouml;chten Sie tun? ",
    "Modify"                 => "&Auml;ndern",
    "Add"                    => "Hinzuf&uuml;gen",
    "MultipleItemTitle"      => "Objekte hochladen",
    "MultipleItemDescribe"   => "Terracotta 0.6 unterst&uuml;tzt das gleichzeitige Hochladen mehrerer Objekte.<br>Bitte geben sie die Zahl der Objekte ein, die sie hochladen wollen:",
    "SelectNumber"           => "Wie viele m&ouml;chten Sie hochladen?",
    "SelectType"             => "Was m&ouml;chten Sie hochladen?",
    "ConfirmDelete"          => "Sind Sie sicher, dass dieses Objekt gel&ouml;scht werden soll? Dieser Vorgang ist irreversibel!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "Neue Ordner hinzuf&uuml;gen",
    "ModFolder"           => "Ordnerinformationen &auml;ndern",
    "AddFolderMessage"    => "Bitte tragen Sie die geforderten Details f&uuml;r jeden Ordner ein und klicken Sie auf den OK-Button, um fortzufahren.",
    "ModFolderMessage"    => "Bitte verbesseren Sie die Ordnerinformationen und klicken Sie zum Speichern auf den OK-Button. Laden Sie ein Ordnericon nur dann hoch, wenn Sie es &auml;ndern wollen.",
    "FolderName"          => "Ordnername",
    "FolderDescription"   => "Beschreibung",
    "FolderIcon"          => "Eigenes Ordnericon (JPG, GIF oder PNG)",
    "AddButton"           => "OK",
    "ModButton"           => "OK"

  );

 /******************************************************************
  * Image Management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_IMAGE = array(
  
    "AddImageTitle"       => "Neue Bilder hinzuf&uuml;gen",
    "AddImageMessage"     => "Bitte w&auml;hlen Sie die Bilder von ihrem Computer aus, die Sie in diese Gallerie hochladen wollen. Wenn die Vorschaubilderstellung fehlschl&auml;gt, m&uuml;ssen Sie selbst ein Vorschaubild hochladen.",
    "EditImageTitle"      => "Bildunterschrift bearbeiten",
    "EditImageMessage"    => "&Auml;ndern Sie die Bildunterschrift und klicken Sie auf &#132;&Auml;nderungen speichern&#148;.",
    "ImageFile"           => "Bild (JPG/PNG/GIF)",
    "ThumbnailFile"       => "evt. Vorschaubild (JPG/PNG/GIF)",
    "Caption"             => "Bildunterschrift",
    "AddButton"           => "Bilder hochladen",
    "ModButton"           => "&Auml;nderungen speichern"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "Neuen Artikel erstellen",
    "EditArticleTitle"    => "Artikel bearbeiten",
    "AddArticleMessage"   => "Bitte geben Sie ihrem Artikel einen Titel. Der von Ihnen eingegebene Text wird, wenn gew&uuml;nscht, automatisch in HTML umgewandelt.",
    "ArticleHead"         => "Titel des Artikels",
    "ArticleBody"         => "Text:",
    "AddButton"           => "Artikel speichern"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "Neuen Link hinzuf&uuml;gen",
    "EditLinkTitle"    => "Link bearbeiten",
    "AddLinkMessage"   => "Bitte geben Sie die komplette URL (mail, web oder ftp) und eine Beschreibung an.",
    "LinkCaption"      => "Beschreibung",
    "LinkURL"          => "URL (mailto:, http:, ftp:)",
    "AddButton"        => "Link erstellen",
    "ModButton"        => "&Auml;nderungen speichern"

  );

 /******************************************************************
  *
  ******************************************************************/

  $_MSG_TCPE_MANAGE_DOCUMENT = array(
  
    "AddDocTitle"      => "Neues Dokument erstellen",
    "ModDocTitle"      => "Vorhandenes Dokument &auml;ndern",
    "AddDocMessage"    => "Bitte w&auml;hlen Sie die gew&uuml;nschten Dokumente von ihrem Computer aus und geben Sie jedem eine Beschreibung. Klicken Sie danach auf &#132;Hochladen&#148;, um das Dokument in die Galerie einzuf&uuml;gen. Bitte beachten Sie, dass nur Dokumente akzeptiert werden, die in der Konfigurationsdatei als solche ausgewiesen sind!",
    "ModDocMessage"    => "&Auml;ndern Sie die Dokumentinformationen und klicken Sie auf &#132;&Auml;nderungen speichern&#148;. Laden Sie nur eine neue Datei hoch, wenn Sie die existierende Datei durch diese ersetzen wollen! Wenn das Feld leer bleibt, wird weiterhin das aktuelle Dokument verwandt.",
    "DocumentTitle"    => "Name des Dokumentes",
    "DocumentCaption"  => "Beschreibung",
    "DocFile"          => "Bitte w&auml;hlen das gew&uuml;nschte Dokument",
    "AddButton"        => "Dokumente hochladen",
    "ModButton"        => "&Auml;nderungen speichern"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "Dokumentengalerie durchsuchen",
    "SearchMessage"    => "Bitte geben Sie die Suchbegriffe ein und klicken Sie auf &#132;Durchsuchen&#148;.",
    "SearchKeywords"   => "Suchkriterien (separate Suchbegriffe, jeweils durch ein Komma abgetrennt)",
    "EntireSite"       => "Die gesamte Dokumentengalerie durchsuchen",
    "ThisDirectory"    => "Nur diesen Ordner durchsuchen",
    "SearchButton"     => " Durchsuchen ",
    "SearchResults"    => "Suchergebnisse"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Ordner ansehen",
    "EditLabel"        => "Bearbeiten",
    "DeleteLabel"      => "L&ouml;schen",
    "Article"          => "Artikel",
    "InternetLink"     => "Link",
    "LastModified"     => "Zuletzt ge&auml;ndert",
    "PrintArticle"     => "Diesen Artikel ausdrucken",
    "EmailAddress"     => "E-Mail",
    "MaintainedBy"     => "verwaltet von",
    "PrintedOn"        => "gedruckt am",
    "Size"             => "Dateigr&ouml;&szlig;e",
    "KBytes"           => "Kilobytes",
    "ClickToDownload"  => "Herunterladen",
    "Mins"             => "Min.",
    "EmptyFolder"      => "Dieser Ordner ist leer.",
    "EmptySearch"      => "Ihre Suchanfrage blieb leider ohne Ergebnis",
    "SearchResults"    => "Suchergebnisse",
    "DownloadPDF"      => "PDF-Version herunterladen"

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
