<?php
// Spanish translation for the setup process
// By Pedro Garassino <pedro@dkanontower.com>

// extra header for charset
$S_Charset = "iso-8859-1";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Tablas serán creadas/subidas al server local.");
define("S_MAIN_2","Paso 1 completado: tablas han sido creadas/subidas.");
define("S_MAIN_3","Paso 1 Salteado por el usuario.");
define("S_MAIN_4","Encuentra seteo(s) perdidos o inválido(s).");
define("S_MAIN_5","Al menos uno está perdido.");
define("S_MAIN_6","Al menos un canal es requerido.");
define("S_MAIN_7","El nombre del canal no puede contener barras (\\).");
define("S_MAIN_8","La hora del lugar por defecto, se ha perdido.");
define("S_MAIN_9","El número de mensajes para mostrar y/o el timeout por defecto entre cada update se ha perdido.");
define("S_MAIN_11","Paso 2 completado: seteos para el fine tunning ha sido registrado.");
define("S_MAIN_12","Usted debe ingresar su nombre de usuario.");
define("S_MAIN_13","Su nombre de usuario no puede tener espacios, comas o barras (\\).");
define("S_MAIN_14","Usted debe ingresar su clave.");
define("S_MAIN_15","The <I>%s</I> Su nick ha sido registrado por otro usuario y la clave que ha ingresado es incorrecta.");
define("S_MAIN_16","Paso 3 completado: Sus datos como administrador han sido registrados.");
define("S_MAIN_17","Paso 3 Salteado por el usuario.");
define("S_MAIN_18","- Seteo");

// Settings for setup0.php3 file
define("S_SETUP0_1","Este script permite una fácil instalación %s.");
define("S_SETUP0_2","Usted puede hacerlo en forma manual, si lo desea. Si usted prefiere hacerlo, entonces debe:");
define("S_SETUP0_3","Crear tablas para %s utilizando archivos dump localizados en <I>'chat/install/database'</I> dir;");
define("S_SETUP0_4","Editar el <I>config.lib.php3</I> archivo localizado en el <I>'chat/config'</I> directorio para definir %s seteos;");
define("S_SETUP0_5","Manualmente se requiere información adicional para el Administrador en la tabla de usuarios registrados (c_reg_users): su nick en <I>username</I> columna, MD5 hash de la clave actual en <I>password</I> columna y la palabra 'admin' (sin comillas) en <I>perms</I> columna. Si usted quiere, puede añadir información adicional en otras columnas pero esto no es requerido;");
define("S_SETUP0_5m","Setear tres variables en la parte de arriba de 'chat/admin/mail4admin.lib.php3' script.");
define("S_SETUP0_6","Para continuar con el setup automático haga click en el boton de abajo.");
define("S_SETUP0_7"," Ir ");
define("S_SETUP0_8","Antes del updating de una versión anterior de %s usted debería vaciar la tabla de mensajes (utilizando el 'chat/admin.php3' script de esa versión anterior).");

// Settings for setup1.php3 file
define("S_SETUP1_1","Primer paso: Configuración de tablas");
define("S_SETUP1_2","Seteo de base de datos");
define("S_SETUP1_3","Seleccione su tipo de servidor:");
define("S_SETUP1_4","Nombre del Host de su servidor SQL:");
define("S_SETUP1_5","Nombre de la base de datos del server:");
define("S_SETUP1_6","(debe existir)");
define("S_SETUP1_7","Login de la base de datos:");
define("S_SETUP1_8","Usuario de la base de datos:");
define("S_SETUP1_9","Creación de tablas/update");
define("S_SETUP1_10","Que quiere usted que haga el script?");
define("S_SETUP1_11","Crear tablas para %s");
define("S_SETUP1_12","Update de las existentes creadas para 0.12.0 or 0.12.1 releases");
define("S_SETUP1_13","Nada, las tablas han sido creadas (para versiones 0.13.4 y 0.14.?)");
define("S_SETUP1_14","Nombre de las tablas<SUP>*</SUP> adonde...");
define("S_SETUP1_15","mensajes serán almacenados:");
define("S_SETUP1_16","datos de los usuarios registrados serán almacenados:");
define("S_SETUP1_17","logueo de los usuarios serán almacenados:");
define("S_SETUP1_18","<SUP>*</SUP>Los nombres que usted ingresa para las tablas deben corresponder a existentes is usted elige<BR><B>update</B> de ellos. Si usted quiere <B>crear nuevas tablas</B> los nombres <B>no</B> deben ser los <BR> mismos que las tablas existentes!<BR>Todos los campos deben ser completados, si usted no quiere que el script lo haga<BR>será necesario hacerlo cuando crea el Administrador<BR>más adelante.");
define("S_SETUP1_19","OK");
define("S_SETUP1_20","Update existentes creadas para 0.13.0 to 0.13.3 versiones");
define("S_SETUP1_21","usuarios baneados serán almacenados:");

// Settings for setup2.php3 file
define("S_SETUP2_1","Segundo paso: Opciones más puntuales");
define("S_SETUP2_2","Quitar los seteos para mensajes y usuarios");
define("S_SETUP2_3","Múmero de horas hasta que los mensajes son borrados:");
define("S_SETUP2_4","Número de minutos hasta que los usuarios inactivos son borrados:");
define("S_SETUP2_5","Número de días hasta que los usuarios inactivos son borrados&nbsp;&nbsp;&nbsp;<BR>desde la registración en la tabla (0 para nunca):");
define("S_SETUP2_6","Salones a crear por defecto");
define("S_SETUP2_7","Separado con coma (,) no espacios.");
define("S_SETUP2_8","Seteo idioma");
define("S_SETUP2_9","Permitir multi-idiomas/soporte de caracteres ?");
define("S_SETUP2_10","Idioma por defecto:");
define("S_SETUP2_11","Seguridad y resticciones");
define("S_SETUP2_12","Mostrar los link para administración de recursos cuando aparece la pantalla ?");
define("S_SETUP2_13","Mostrar los link que permiten a los usuarios borrar sus datos ?");
define("S_SETUP2_14","Quiere registrarse?");
define("S_SETUP2_15","Usuarios pueden acceder...");
define("S_SETUP2_16","...solamente la primer sala con los valores por defecto");
define("S_SETUP2_17","...todas las salas definidas por defecto, pero no crear una sala");
define("S_SETUP2_18","...todas las salas y la posiblidad de crear nuevas");
define("S_SETUP2_19","Acumulación de mensajes");
define("S_SETUP2_20","Utilizar gráficos sonrisas (ver 'chat/lib/smilies.lib.php3')?");
define("S_SETUP2_21","Guardar efecto de negrita, itálica y subrayado en mensajes ?");
define("S_SETUP2_22","Mostrar HTML tags descartados?");
define("S_SETUP2_23","Mostrar seteos por defecto");
define("S_SETUP2_24","Zona horaria medida en horas entre el tiempo de su server y el de su país:");
define("S_SETUP2_25","Mensajes por defecto:");
define("S_SETUP2_26","último hacia arriba");
define("S_SETUP2_27","último hacia abajo");
define("S_SETUP2_28","Número de mensajes, por defecto, a mostrar:");
define("S_SETUP2_29","Tiempo final por defecto entre actualización de mensajes por pantalla (en segundos):");
define("S_SETUP2_30","Mostrar timestamp por defecto.");
define("S_SETUP2_31","Mostrar notificaciones del usuario entrante/salida por defecto.");
define("S_SETUP2_36","Verificar malas palabras (ver 'chat/lib/swearing.lib.php3') ?");
define("S_SETUP2_41","Número máximo de mensajes que un usuario es permitido exportar a un archivo HTML (0 para no -el comando está desactivado-, '*' para todos los mensajes posibles, o un límite para la carga del server)?");
define("S_SETUP2_42","Activar las posibilidades de ban?<BR>0 para no, un número positivo para definir el número de banes<BR>día(s) (2000000 para no terminar, 0.02 para media hora....))");
define("S_SETUP2_43","Registración de usuarios");
define("S_SETUP2_44","Generar una clave y enviarla a la dirección de e-mail del usuario?<BR>Esta opción requiere <I>'mail()'</I> función PHP activada, y esté seguro que pueda usarlo con el administrador del server.<BR>Más aún, para tenerlo funcionando usted tiene que definir cuatro seteos en 'chat/lib/mail_validation.lib.php3' script.");
define("S_SETUP2_45","Su PHP configuración parece no permitir el uso de <I>'mail()'</I> función. Entonces usted no puede cambiar la clave general y enviarla al usuario por e-mail.");
define("S_SETUP2_46","publicos:");
define("S_SETUP2_47","privados:");
define("S_SETUP2_48","Enviar un mensaje de bienvenida al usurio que ingresa al chat (ver 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","Los datos del Administrador están definidos, y solamente un<BR>administrador puede existir. Modificar los campos, por favor<BR>abajo del update los datos existentes.");
define("S_SETUP3_2","Tercer paso: Registración del administrador");
define("S_SETUP3_3","Campos con <SPAN CLASS=error>*</SPAN> son requeridos.");
define("S_SETUP3_4","login (nick):");
define("S_SETUP3_5","clave:");
define("S_SETUP3_6","Nombre:");
define("S_SETUP3_7","Apellido:");
define("S_SETUP3_8","idiomas:");
define("S_SETUP3_9","sitioweb:");
define("S_SETUP3_10","e-mail:");
define("S_SETUP3_11","mostrar e-mail con /whois comando");
define("S_SETUP3_12","Saltear >>");
define("S_SETUP3_13","Puede modificar sus datos posteriormente haciendo click en edit<BR>datos relacionados en el comienzo de página %s.");
define("S_SETUP3_14", "Sexo");
define("S_SETUP3_15", "masculino");
define("S_SETUP3_16", "femenino");

// Settings for setup4.php3 file
define("S_SETUP4_1","Cuarto paso: El archivo config");
define("S_SETUP4_2","Aquí está el archivo config, conforme a la información que usted ha ingresado.<BR><BR>Copiar todo, incluyendo las primeras y últimas lineas, y luego pegarla en su editor de texto favorito (Notepad, Vi...). Después, usted *debe* ingresar la clave de su base de datos en la linea 7 y salvar el archivo como <I>config.lib.php3</I>.<BR><BR>Asegúrese que no hay <B>ni lineas en blanco, ni espacios entre caracteres, ni antes de la apertura del php, ni después de cerrado</B>, entonces usted puede cargar el archivo config en el server <I>config</I> directorio (reemplazar el existente) y asegurarse (ver <I>install.txt</I> en el directorio <I>docs</I> para más información sobre esto).<BR><BR>No se olvide de mirar <A HREF=\"#warn\">cuidado</A> abajo.");
define("S_SETUP4_3","Seleccionar todo");
define("S_SETUP4_4","Una vez que usted ha completado los pasos de abajo, %s está casi listo para correr.<BR>");
define("S_SETUP4_4m"," Setear manualmente tres variables arriba del <I>'chat/admin/mail4admin.lib.php3'</I><BR>script... y tenga algunas hermosas discuciones de chat.");
define("S_SETUP4_5","Después de %s y corrido usted podría remover el archivo<BR><I>setup.php3</I> y el directorio <I>'chat/install'</I> desde su server.");
?>