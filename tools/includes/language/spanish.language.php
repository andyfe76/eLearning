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
  * File:        spanish.language.php
  * Created by:  Juan Carlos Pi�a
  * Created on:  12th december 2002
  *
  * Natural language definition developers can use this file as a
  * template and make their custom language files. Please do contribute
  * your language files to the Terracotta project at
  * terracotta-devel@lists.sourceforge.net
  *
  * Language:    Spanish (MX)
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

   "APP_TITLE"  => "Terracotta Edici�n Personal",
   "Version"    => "Versi�n",
   "Home"       => "Inicio",
   "Edit"       => "Editar",
   "Delete"     => "Borrar",
   "Continue"   => "Continuar",
   "Okay"       => "Ok",
   "Yes"        => "Si",
   "No"         => "No",
   "Page"       => "P�gina",
   "Top"        => "Superior",
   "Next"       => "Anterior",
   "Back"       => "Siguiente",
   "Search"     => "Buscar",
   "Document"   => "Documento",
   "Image"      => "Imagen",
   "Link"       => "Liga de Internet",
   "Folder"     => "Carpeta",
   "Article"    => "Art�culo",
   "Manage"     => "Administrar",
   "Logout"     => "Salir",
   "AdminEmail" => "Email del administrador",
   "AdminPass"  => "Contrase�a del administrador",
   "Respaldar"     => "Respaldar"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "El archivo de configuraci�n no es compatible con esta instalaci�n de Terracota, por favor reinstale Terracota",
   "BadConfigurationTitle" => "Archivo de configuraci�n incorrecto",
   "NotImageFileTitle"     => "No es un archivo de imagen",
   "NotImageFile"          => "El archivo transferido no es aceptado como una imagen, por favor transfiera solo im�genes JPEG, GIF o PNG",
   "BadFile"               => "El archivo solicitado no se encuentra, un mensaje de notificaci�n le ha sido enviado al administrador."
   
  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Desinstalar la Edici�n Personal de Terracota",
   "Warning"   => "Esta utiler�a le permitir� desligar todo el contenido publicado utilizando Terracota y borrarlo de �ste servidor. Por favor aseg�rese de querer hacer esto antes de proceder ya que es un proceso irreversible.  Le recomendamos hacer un respaldo de sus datos antes de continuar.",
   "Completed" => "Los archivos han sido desligados, ahora puede borrar los scripts para completar la desinstalaci�n",
   "TitleFin"  => "Se ha terminado de desligar el contenido",
   "Uninstall" => "Desinstalar"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "M�dulo de administraci�n",  
    "LoginTitle"             => "Entrada al m�dulo de administraci�n",
    "LoginMessage"           => "Ha solicitado accesar a las funciones administrativas para este sitio web de Terracota, para continuar debe comprobar los datos de acceso apropiados",
    "AdministrativeEmail"    => "Email del administrador",
    "AdministrativePassword" => "Contrase�a del administrador",
    "LoginButton"            => "Administrar",
    "LoginOK"                => "Usted ha entrado al m�dulo de administraci�n y ser� redireccionado a la galer�a con privilegios de administrador",
    "LoginBAD"               => "Sus datos de acceso no pudieron ser verificados, por favor intente de nuevo",
    "LogoutMessage"          => "Usted ha salido del m�dulo de administraci�n",
    "AdminModeMessage"       => "Men� de administraci�n >> ",
    "AdminBarMessage"        => "�Qu� desea hacer?",
    "Modify"                 => "Modificar",
    "Add"                    => "A�adir",
    "MultipleItemTitle"      => "�Cu�ntos elementos desea a�adir?",
    "MultipleItemDescribe"   => "Terracotta 0.6 permite a�adir multiples elementos al mismo tiempo <br>elija el n�mero de elementos que desea a�adir",
    "SelectNumber"           => "�Cu�ntos desea a�adir?",
    "SelectType"             => "�Qu� desea a�adir?",
    "ConfirmDelete"          => "�Esta seguro que quiere borrar este elemento? El proceso es irreversible!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "A�adir Carpetas",  
    "ModFolder"           => "Modificar la informaci�n de las Carpetas",
    "AddFolderMessage"    => "Complete los detalles requeridos para cada Carpeta y haga clic en el bot�n para crearlas",
    "ModFolderMessage"    => "Actualice la informaci�n de la Carpeta y haga clic en el bot�n para guardar los cambios. Transfiera el icono solo si desea cambiarlo",
    "FolderName"          => "Nombre de la Carpeta",
    "FolderDescription"   => "Descripci�n de la Carpeta",
    "FolderIcon"          => "Icono personalizado para la Carpeta (JPG/GIF/PNG)",
    "AddButton"           => "Crear Carpetas",
    "ModButton"           => "Actualizar t�tulos"

  );

 /******************************************************************
  * Image Management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_IMAGE = array(
  
    "AddImageTitle"       => "A�adir imagenes",
    "AddImageMessage"     => "Seleccione las im�genes que ser�n transferidas a la galer�a, si su instalaci�n de PHP no soporta miniaturas o si ha deshabilitado dicha opci�n, deber� transferir las miniaturas tambi�n.",
    "EditImageTitle"      => "Editar etiqueta de la imagen",
    "EditImageMessage"    => "Modifique la etiqueta de la imagen y haga clic en el bot�n para guardar los cambios.",
    "ImageFile"           => "Imagen (JPG/PNG/GIF)",
    "ThumbnailFile"       => "Miniatura (JPG/PNG/GIF)",
    "Caption"             => "Leyenda para esta imagen",
    "AddButton"           => "Transferir im�genes",
    "ModButton"           => "Cambiar etiqueta"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "A�adir art�culo",
    "EditArticleTitle"    => "Editar art�culo",
    "AddArticleMessage"   => "Proporcione un t�tulo para su art�culo y escriba el cuerpo del texto. Si la propiedad de reemplazo de caracteres est� activa, los retornos de carro ser�n reemplazados por etiquetas BR mientras el art�culo es dibujado en vivo en el sitio web",
    "ArticleHead"         => "Nombre del art�culo",
    "ArticleBody"         => "Cuerpo del art�culo",
    "AddButton"           => "Grabar art�culo"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "A�adir Liga de Internet",
    "EditLinkTitle"    => "Editar Liga de Internet",
    "AddLinkMessage"   => "Proporcione una etiqueta y complete el URL (Email, web, ftp)",
    "LinkCaption"      => "Etiqueta de la liga",
    "LinkURL"          => "URL (mailto:, http:, ftp:)",
    "AddButton"        => "Crear ligas",
    "ModButton"        => "Modificar ligas"

  );

 /******************************************************************
  *
  ******************************************************************/

  $_MSG_TCPE_MANAGE_DOCUMENT = array(
  
    "AddDocTitle"      => "A�adir documento",
    "ModDocTitle"      => "Modificar un documento existente",
    "AddDocMessage"    => "Seleccione los documentos en su computadora, proporcione una etiqueta para cada uno y haga clic en el bot�n para a�adirlos a la galer�a.",
    "ModDocMessage"    => "Cambie la informaci�n acerca del documento y haga clic en el bot�n para grabar los cambios. Elija archivo solo si desea actualizar el archivo existente en el servidor, si omite el campo archivo el documento existente ser� preservado",
    "DocumentTitle"    => "T�tulo del documento",
    "DocumentCaption"  => "Descripci�n del documento",
    "DocFile"          => "Seleccione los archivos a transferir",
    "AddButton"        => "Transferir documentos",
    "ModButton"        => "Cambiar informaci�n"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "Buscar en la Galer�a de Documentos",
    "SearchMessage"    => "Ingrese las palabras clave que desea encontrar y <br> haga clic en el bot�n para generar la lista de coincidencias",
    "SearchKeywords"   => "Criterio de b�squeda (separe las palabras clave utilizando una coma)",
    "EntireSite"       => "Buscar en toda la Galer�a de Documentos",
    "ThisDirectory"    => "Buscar solo en esta carpeta",
    "SearchButton"     => " Buscar ahora ",
    "SearchResults"    => "Resultados de su b�squeda"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Ver contenido de la Carpeta",
    "EditLabel"        => "Editar",
    "DeleteLabel"      => "Borrar",
    "Article"          => "Art�culo",
    "InternetLink"     => "Liga de Internet",
    "LastModified"     => "Ultima modificaci�n",
    "PrintArticle"     => "Imprimir este art�culo",
    "EmailAddress"     => "Email",
    "MaintainedBy"     => "Maintenida por",
    "PrintedOn"        => "Impreso en",
    "Size"             => "Tama�o del archivo",
    "KBytes"           => "Kilo Bytes",
    "ClickToDownload"  => "Descargar el archivo ahora",
    "Mins"             => "Mins.",
    "EmptyFolder"      => "Esta carpeta no contiene elementos",
    "EmptySearch"      => "Su b�squeda no arroj� resultados",
    "SearchResults"    => "Resultados de la b�squeda",
    "DownloadPDF"      => "Descargar una versi�n PDF"

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
