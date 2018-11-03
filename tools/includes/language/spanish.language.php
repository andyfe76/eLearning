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
  * Created by:  Juan Carlos Piña
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

   "APP_TITLE"  => "Terracotta Edición Personal",
   "Version"    => "Versión",
   "Home"       => "Inicio",
   "Edit"       => "Editar",
   "Delete"     => "Borrar",
   "Continue"   => "Continuar",
   "Okay"       => "Ok",
   "Yes"        => "Si",
   "No"         => "No",
   "Page"       => "Página",
   "Top"        => "Superior",
   "Next"       => "Anterior",
   "Back"       => "Siguiente",
   "Search"     => "Buscar",
   "Document"   => "Documento",
   "Image"      => "Imagen",
   "Link"       => "Liga de Internet",
   "Folder"     => "Carpeta",
   "Article"    => "Artículo",
   "Manage"     => "Administrar",
   "Logout"     => "Salir",
   "AdminEmail" => "Email del administrador",
   "AdminPass"  => "Contraseña del administrador",
   "Respaldar"     => "Respaldar"

  );

 /******************************************************************
  * Terracotta Error Messages
  ******************************************************************/

  $_MSG_TCPE_ERROR = array(

   "BadConfigurationFile"  => "El archivo de configuración no es compatible con esta instalación de Terracota, por favor reinstale Terracota",
   "BadConfigurationTitle" => "Archivo de configuración incorrecto",
   "NotImageFileTitle"     => "No es un archivo de imagen",
   "NotImageFile"          => "El archivo transferido no es aceptado como una imagen, por favor transfiera solo imágenes JPEG, GIF o PNG",
   "BadFile"               => "El archivo solicitado no se encuentra, un mensaje de notificación le ha sido enviado al administrador."
   
  );

 /******************************************************************
  * Messages used by the un-installation script
  ******************************************************************/

  $_MSG_TCPE_UNINSTALL = array(

   "Header"    => "Desinstalar la Edición Personal de Terracota",
   "Warning"   => "Esta utilería le permitirá desligar todo el contenido publicado utilizando Terracota y borrarlo de éste servidor. Por favor asegúrese de querer hacer esto antes de proceder ya que es un proceso irreversible.  Le recomendamos hacer un respaldo de sus datos antes de continuar.",
   "Completed" => "Los archivos han sido desligados, ahora puede borrar los scripts para completar la desinstalación",
   "TitleFin"  => "Se ha terminado de desligar el contenido",
   "Uninstall" => "Desinstalar"

  );


 /******************************************************************
  * Management Interface messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE = array(
   
    "AdminTitle"             => "Módulo de administración",  
    "LoginTitle"             => "Entrada al módulo de administración",
    "LoginMessage"           => "Ha solicitado accesar a las funciones administrativas para este sitio web de Terracota, para continuar debe comprobar los datos de acceso apropiados",
    "AdministrativeEmail"    => "Email del administrador",
    "AdministrativePassword" => "Contraseña del administrador",
    "LoginButton"            => "Administrar",
    "LoginOK"                => "Usted ha entrado al módulo de administración y será redireccionado a la galería con privilegios de administrador",
    "LoginBAD"               => "Sus datos de acceso no pudieron ser verificados, por favor intente de nuevo",
    "LogoutMessage"          => "Usted ha salido del módulo de administración",
    "AdminModeMessage"       => "Menú de administración >> ",
    "AdminBarMessage"        => "¿Qué desea hacer?",
    "Modify"                 => "Modificar",
    "Add"                    => "Añadir",
    "MultipleItemTitle"      => "¿Cuántos elementos desea añadir?",
    "MultipleItemDescribe"   => "Terracotta 0.6 permite añadir multiples elementos al mismo tiempo <br>elija el número de elementos que desea añadir",
    "SelectNumber"           => "¿Cuántos desea añadir?",
    "SelectType"             => "¿Qué desea añadir?",
    "ConfirmDelete"          => "¿Esta seguro que quiere borrar este elemento? El proceso es irreversible!"

  );

 /******************************************************************
  * Folder Management Messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_FOLDER = array(
  
    "AddFolder"           => "Añadir Carpetas",  
    "ModFolder"           => "Modificar la información de las Carpetas",
    "AddFolderMessage"    => "Complete los detalles requeridos para cada Carpeta y haga clic en el botón para crearlas",
    "ModFolderMessage"    => "Actualice la información de la Carpeta y haga clic en el botón para guardar los cambios. Transfiera el icono solo si desea cambiarlo",
    "FolderName"          => "Nombre de la Carpeta",
    "FolderDescription"   => "Descripción de la Carpeta",
    "FolderIcon"          => "Icono personalizado para la Carpeta (JPG/GIF/PNG)",
    "AddButton"           => "Crear Carpetas",
    "ModButton"           => "Actualizar títulos"

  );

 /******************************************************************
  * Image Management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_IMAGE = array(
  
    "AddImageTitle"       => "Añadir imagenes",
    "AddImageMessage"     => "Seleccione las imágenes que serán transferidas a la galería, si su instalación de PHP no soporta miniaturas o si ha deshabilitado dicha opción, deberá transferir las miniaturas también.",
    "EditImageTitle"      => "Editar etiqueta de la imagen",
    "EditImageMessage"    => "Modifique la etiqueta de la imagen y haga clic en el botón para guardar los cambios.",
    "ImageFile"           => "Imagen (JPG/PNG/GIF)",
    "ThumbnailFile"       => "Miniatura (JPG/PNG/GIF)",
    "Caption"             => "Leyenda para esta imagen",
    "AddButton"           => "Transferir imágenes",
    "ModButton"           => "Cambiar etiqueta"

  );
  
 /******************************************************************
  * Article management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_ARTICLE = array(
  
    "AddArticleTitle"     => "Añadir artículo",
    "EditArticleTitle"    => "Editar artículo",
    "AddArticleMessage"   => "Proporcione un título para su artículo y escriba el cuerpo del texto. Si la propiedad de reemplazo de caracteres está activa, los retornos de carro serán reemplazados por etiquetas BR mientras el artículo es dibujado en vivo en el sitio web",
    "ArticleHead"         => "Nombre del artículo",
    "ArticleBody"         => "Cuerpo del artículo",
    "AddButton"           => "Grabar artículo"

  );  

 /******************************************************************
  * Link management messages
  ******************************************************************/

  $_MSG_TCPE_MANAGE_LINK = array(
  
    "AddLinkTitle"     => "Añadir Liga de Internet",
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
  
    "AddDocTitle"      => "Añadir documento",
    "ModDocTitle"      => "Modificar un documento existente",
    "AddDocMessage"    => "Seleccione los documentos en su computadora, proporcione una etiqueta para cada uno y haga clic en el botón para añadirlos a la galería.",
    "ModDocMessage"    => "Cambie la información acerca del documento y haga clic en el botón para grabar los cambios. Elija archivo solo si desea actualizar el archivo existente en el servidor, si omite el campo archivo el documento existente será preservado",
    "DocumentTitle"    => "Título del documento",
    "DocumentCaption"  => "Descripción del documento",
    "DocFile"          => "Seleccione los archivos a transferir",
    "AddButton"        => "Transferir documentos",
    "ModButton"        => "Cambiar información"

  );

  
 /******************************************************************
  * Search Function messages
  ******************************************************************/

  $_MSG_TCPE_SEARCH = array(
  
    "SearchTitle"      => "Buscar en la Galería de Documentos",
    "SearchMessage"    => "Ingrese las palabras clave que desea encontrar y <br> haga clic en el botón para generar la lista de coincidencias",
    "SearchKeywords"   => "Criterio de búsqueda (separe las palabras clave utilizando una coma)",
    "EntireSite"       => "Buscar en toda la Galería de Documentos",
    "ThisDirectory"    => "Buscar solo en esta carpeta",
    "SearchButton"     => " Buscar ahora ",
    "SearchResults"    => "Resultados de su búsqueda"

  );

 /******************************************************************
  * Messages required while rendering directory contents
  ******************************************************************/

  $_MSG_TCPE_RENDER = array(
  
    "BrowseFolder"     => "Ver contenido de la Carpeta",
    "EditLabel"        => "Editar",
    "DeleteLabel"      => "Borrar",
    "Article"          => "Artículo",
    "InternetLink"     => "Liga de Internet",
    "LastModified"     => "Ultima modificación",
    "PrintArticle"     => "Imprimir este artículo",
    "EmailAddress"     => "Email",
    "MaintainedBy"     => "Maintenida por",
    "PrintedOn"        => "Impreso en",
    "Size"             => "Tamaño del archivo",
    "KBytes"           => "Kilo Bytes",
    "ClickToDownload"  => "Descargar el archivo ahora",
    "Mins"             => "Mins.",
    "EmptyFolder"      => "Esta carpeta no contiene elementos",
    "EmptySearch"      => "Su búsqueda no arrojó resultados",
    "SearchResults"    => "Resultados de la búsqueda",
    "DownloadPDF"      => "Descargar una versión PDF"

  );

 /******************************************************************
  * End of PHP script file
  ******************************************************************/

?>
