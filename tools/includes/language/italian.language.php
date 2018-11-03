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
  * File:        italian.language.php
  * Created by:  Stefano DALL'OLIO (dallo.s@tin.it)
  * Created on:  16th December 2002
  *
  * Natural language definition developers can use this file as a
  * template and make their custom language files. Please do contribute
  * your language files to the Terracotta project at
  * terracotta-devel@lists.sourceforge.net
  *
  * Language:    Italian (it_IT)
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
   "Version"    => "Versione",
   "Home"       => "Home",
   "Edit"       => "Modifica",
   "Delete"     => "Elimina",
   "Continue"   => "Continua",
   "Okay"       => "OK",
   "Yes"        => "Si",
   "No"         => "No",
   "Page"       => "Pagina",
   "Top"        => "Top",
   "Next"       => "Prossimo",
   "Back"       => "Precedente",
   "Search"     => "Cerca",
   "Document"   => "Documento",
   "Image"      => "Immagine",
   "Link"       => "Link",
   "Folder"     => "Cartella",
   "Article"    => "Articolo",
   "Manage"     => "Gestisci",
   "Logout"     => "Esci",
   "AdminEmail" => "Email Amministratore",
   "AdminPass"  => "Password Amministratore",
   "Backup"     => "Salvataggio"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "Il file di configurazione non è compatibile con questa versione di Terracotta, si prega di re-installare l'applicazione",
   "BadConfigurationTitle" => "File di configurazione errato",
   "NotImageFileTitle"     => "Non è un file di tipo Immagine",
   "NotImageFile"          => "Il file appena caricato non è in un formato valido. Si prega di caricare solo file JPEG, GIF o PNG",
   "BadFile"               => "Il file richiesto non è stato trovato. Una email di notifica è stata inviata all'amministratore del sistema"
   
  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Rimuovi Terracotta Personal Edition",
   "Warning"   => "Questa procedura eliminerà PERMANENTEMENTE ogni contenuto pubblicato con Terracotta cancellando i file dal server. Si prega di ponderare con attenzione questa azione perchè sarà IRREVERSIBILE. Si consiglia di eseguire un Salvataggio prima di continuare.",
   "Completed" => "La Rimozione è stata eseguita con successo. Si prega di eliminara anche questo script per completare la Disinstallazione",
   "TitleFin"  => "Completamento Rimozione",
   "Uninstall" => "Rimozione"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "Modulo di Amministrazione",  
    "LoginTitle"             => "Entra nell'Interfaccia Amministrativa",
    "LoginMessage"           => "Hai chiesto di usare le funzioni di amministrazione di questo sito.<BR>Inserire la corretta email e password per poter accedere.",
    "AdministrativeEmail"    => "Email Amministratore",
    "AdministrativePassword" => "Password Amministratore",
    "LoginButton"            => "Amministra",
    "LoginOK"                => "Accesso effettuato correttamente. Ora verrai riportato alla pagina principale che conterrà anche le opzioni amministrative",
    "LoginBAD"               => "Errore nella verifica dei dati immessi, si prega di ritentare",
    "LogoutMessage"          => "Uscita dall interfaccia amministrativa eseguito correttamente",
    "AdminModeMessage"       => "Menu Amministrativo >> ",
    "AdminBarMessage"        => "Cosa vuoi fare? ",
    "Modify"                 => "Modifica",
    "Add"                    => "Aggiungi",
    "MultipleItemTitle"      => "Quanti Oggetti vuoi aggiungere?",
    "MultipleItemDescribe"   => "Terracotta 0.6 supporta l'aggiunta di più oggetti allo stesso tempo<br>Selezionare il numero di oggetti da aggiungere",
    "SelectNumber"           => "Quoanto ne vuoi aggiungere?",
    "SelectType"             => "Cosa vuoi aggiungere?",
    "ConfirmDelete"          => "Sei sicuro di volerlo eliminare? Questa azione è IRREVERSIBILE!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "Aggiungi Nuova Cartella",  
    "ModFolder"           => "Modifica Informazioni Cartella",
    "AddFolderMessage"    => "Completare con le informazioni richieste per ogni Cartella e premere il pulsante per creare le Cartelle",
    "ModFolderMessage"    => "Aggiornare le informazioni sulla cartella e premere il pulsante per salvare. Caricare solo l'icona se si vuole cambiare solo quella",
    "FolderName"          => "Nome Cartella",
    "FolderDescription"   => "Descrizione Cartella",
    "FolderIcon"          => "Icona Personalizzata (JPG/GIF/PNG)",
    "AddButton"           => "Crea Cartella",
    "ModButton"           => "Aggiorna Titolo"

  );

 /******************************************************************
  * Image Management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_IMAGE = array(
  
    "AddImageTitle"       => "Aggiungi File Immagine",
    "AddImageMessage"     => "Selezionare, dal proprio PC, l'immagine da aggiungere a questa Galleria.<BR>Se la propria installazione di PHP non supporta la creazione di anteprime o non si e' attivata questa opzione nel file di configurazione, bisogna fornire anche il file dell'anteprima.",
    "EditImageTitle"      => "Titolo Immagine",
    "EditImageMessage"    => "Modifica il Titolo e premi il pulsante per salvare le modifiche.",
    "ImageFile"           => "Immagine (JPG/PNG/GIF)",
    "ThumbnailFile"       => "Anteprima (JPG/PNG/GIF)",
    "Caption"             => "Titolo di questa immagine",
    "AddButton"           => "Upload Immagine",
    "ModButton"           => "Modifica Titolo"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "Aggiungi un Nuovo Articolo",
    "EditArticleTitle"    => "Modifica Articolo",
    "AddArticleMessage"   => "Fornire un Nome al proprio Articolo e inserirne il corpo nello spazio apposito sottostante.<BR>Se la funzione di sostituzione caratteri e' attiva, il carattere di caporiga verra' sostituito con il corrispondente codice HTML per una corretta visualizzazione sul sito web.",
    "ArticleHead"         => "Nome Articolo",
    "ArticleBody"         => "Corpo Articolo",
    "AddButton"           => "Salva Articolo"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "Aggiungi un nuovo Link Internet",
    "EditLinkTitle"    => "Modifica un Link",
    "AddLinkMessage"   => "Fornire un Titolo e un URL completo (mail, web, ftp) per creare un Link Internetto sul sito",
    "LinkCaption"      => "Titolo del Link",
    "LinkURL"          => "URL (mailto:, http:, ftp:)",
    "AddButton"        => "Crea il Link",
    "ModButton"        => "Modifica il Link"

  );

 /******************************************************************
  *
  ******************************************************************/

  $_MSG_TCPE_MANAGE_DOCUMENT = array(
  
    "AddDocTitle"      => "Aggiungi un nuovo Documento",
    "ModDocTitle"      => "Modifica un Documento Esistente",
    "AddDocMessage"    => "Selezionare i Documenti da Aggiungere dal PC locale.<BR>Dare ad ognuno un Titolo e premere il pulsante per caricarli sul sito.<BR><BR>ATTENZIONE: Terracotta accetta solo i formati di Documento definiti nel file di configurazione",
    "ModDocMessage"    => "Modifica le informazioni sul Documento e premi il pulsante per salvarle.<BR>Selezionare il file solo se si vuole ri-caricare il documento sul server.<BR>Se si omette questo campo il file sul server verra' preservato.",
    "DocumentTitle"    => "Titolo Documento",
    "DocumentCaption"  => "Descrizione Documento",
    "DocFile"          => "Selezionare il file da Caricare",
    "AddButton"        => "Carica Documento",
    "ModButton"        => "Cambia Informazioni"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "Ricerca nel Sito",
    "SearchMessage"    => "Inserire le parole da ricercare e premere il pulsante per avere i risultati.",
    "SearchKeywords"   => "Criteri di Ricerca: (separare le parole usando virgole)",
    "EntireSite"       => "Ricerca sull'intero sito",
    "ThisDirectory"    => "Ricerca solo in questa cartella",
    "SearchButton"     => " TROVA ",
    "SearchResults"    => "Risultati della ricerca"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Mostra Cartella",
    "EditLabel"        => "Modifica",
    "DeleteLabel"      => "Elimina",
    "Article"          => "Articolo",
    "InternetLink"     => "Link Internet",
    "LastModified"     => "Ultima Modifica",
    "PrintArticle"     => "Stampa questo Articolo",
    "EmailAddress"     => "Email",
    "MaintainedBy"     => "Gestito Da",
    "PrintedOn"        => "Stampato Su",
    "Size"             => "Dimensione File",
    "KBytes"           => "Kilo Bytes",
    "ClickToDownload"  => "Scarica il file ORA",
    "Mins"             => "Mins.",
    "EmptyFolder"      => "La Cartella e' vuota",
    "EmptySearch"      => "La ricerca non ha prodotto Risultati",
    "SearchResults"    => "Risultati Ricerca",
    "DownloadPDF"      => "Scarica una Versione PDF"

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
