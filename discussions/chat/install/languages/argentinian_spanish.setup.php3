<?php
// File: argentinian_spanish.setup.php3
// Argentinian Spanish translation for the setup process
//   by Jorge Colaccini <jrc@informas.com>

// extra header for charset
$S_Charset = "iso-8859-1";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Las tablas serán creadas/subidas al servidor local.");
define("S_MAIN_2","Paso 1 completado: las tablas han sido creadas/subidas.");
define("S_MAIN_3","Paso 1 Salteado por el usuario.");
define("S_MAIN_4","Encuentra seteo(s) perdidos o inválido(s).");
define("S_MAIN_5","Al menos uno está perdido.");
define("S_MAIN_6","Se requiere por lo menos un canal.");
define("S_MAIN_7","El nombre del canal no puede contener barras (\\).");
define("S_MAIN_8","La hora del lugar por omisión, se ha perdido.");
define("S_MAIN_9","El número de mensajes para mostrar y/o el timeout por defecto entre cada actualización se ha perdido.");
define("S_MAIN_11","Paso 2 completado: la configuración para el <i>fine tunning</i> (ajuste fino) ha sido registrada.");
define("S_MAIN_12","Debés ingresar tu nombre de usuario.");
define("S_MAIN_13","Tu nombre de usuario no puede tener espacios, comas o barras (\\).");
define("S_MAIN_14","Debés ingresar tu contraseña.");
define("S_MAIN_15","Tu <I>nick</I> o alias (<b>%s</B>) ha sido registrado por otro usuario y la contraseña que ingresaste es incorrecta.");
define("S_MAIN_16","Paso 3 completado: Tus datos como administrador han sido registrados.");
define("S_MAIN_17","Paso 3 Salteado por el usuario.");
define("S_MAIN_18","- Configuración");

// Settings for setup0.php3 file
define("S_SETUP0_1","Este script te permitirá una fácil instalación de %s.");
define("S_SETUP0_2","Si querés, podés hacerlo en forma manual. Si preferís hacerlo así, entonces tenés que:");
define("S_SETUP0_3","Crear tablas para %s utilizando archivos dump localizados en el directorio: <I>'chat/install/database'</I>;");
define("S_SETUP0_4","Editar el archivo <I>config.lib.php3</I> ubicado en el directorio <I>'chat/config'</I> para definir las configuraciones de %s;");
define("S_SETUP0_5","El proceso Manual requiere información adicional para el Administrador en la tabla de usuarios registrados (c_reg_users): debés ingresar tu nick en la columna <I>username</I>, la contraseña en <I>password</I> usando encriptación MD5, y la palabra 'admin' (sin comillas) en <I>perms</I>. Si querés, podés añadir información adicional en otras columnas pero esto no es obligatorio;");
define("S_SETUP0_5m","Configurar tres variables en el inicio del archivo/script 'chat/admin/mail4admin.lib.php3'.");
define("S_SETUP0_6","Para continuar con la configuración automática hacé click en el botón de abajo.");
define("S_SETUP0_7"," Continuar ");
define("S_SETUP0_8","Antes de actualizar desde una versión anterior de %s deberías vaciar la tabla de mensajes (utilizando el script 'chat/admin.php3' de esa versión).");

// Settings for setup1.php3 file
define("S_SETUP1_1","Primer paso: Configuración de tablas");
define("S_SETUP1_2","Configuración de la base de datos");
define("S_SETUP1_3","Seleccioná el tipo de servidor SQL:");
define("S_SETUP1_4","Nombre de Host de tu servidor SQL:");
define("S_SETUP1_5","Nombre de la base de datos del servidor:");
define("S_SETUP1_6","(debe existir)");
define("S_SETUP1_7","Usuario de Login de la base de datos:");
define("S_SETUP1_8","Contraseña del usuario de la base de datos:");
define("S_SETUP1_9","Creación de tablas/actualización");
define("S_SETUP1_10","Que querés que haga este script?");
define("S_SETUP1_11","Crear tablas para %s");
define("S_SETUP1_12","Actualizar las existentes creadas para versiones 0.12.0 ó 0.12.1");
define("S_SETUP1_13","Nada, las tablas han sido creadas (para versiones 0.13.4 y 0.14.?)");
define("S_SETUP1_14","Nombre de las tablas<SUP>*</SUP> donde...");
define("S_SETUP1_15","serán almacenados los mensajes:");
define("S_SETUP1_16","serán almacenados los datos de los usuarios registrados:");
define("S_SETUP1_17","serán almacenados el historial de acceso de los usuarios:");
define("S_SETUP1_18","<SUP>*</SUP>Los nombres que ingreses para las tablas deben corresponder a tablas existentes si estás eligiendo <BR><B>actualización</B>. Si querés <B>crear nuevas tablas</B> los nombres <B>no</B> deben ser los <BR> mismos que los de las tablas existentes!<BR>Todos los campos deben ser rellenados, si no querés que el script lo haga<BR>será necesario hacerlo más adelante cuando creés el Administrador.");
define("S_SETUP1_19"," Continuar ");
define("S_SETUP1_20","Actualización de las existentes creadas para versiones 0.13.0 a 0.13.3");
define("S_SETUP1_21","serán almacenados los nombres de usuarios bloqueados:");

// Settings for setup2.php3 file
define("S_SETUP2_1","Segundo paso: Opciones más específicas");
define("S_SETUP2_2","Depuración de mensajes y usuarios");
define("S_SETUP2_3","Número de horas para que los mensajes sean borrados:");
define("S_SETUP2_4","Número de minutos para que los usuarios inactivos sean borrados:");
define("S_SETUP2_5","Número de días para que los usuarios inactivos sean borrados&nbsp;&nbsp;&nbsp;<BR>de la tabla de usuarios registrados (0 para nunca):");
define("S_SETUP2_6","Salones predeterminados, a crear");
define("S_SETUP2_7","Separado con coma (,) no espacios.");
define("S_SETUP2_8","Configuración de idioma");
define("S_SETUP2_9","Permitir soporte de caracteres multi-idiomas?");
define("S_SETUP2_10","Idioma predeterminado:");
define("S_SETUP2_11","Seguridad y restricciones");
define("S_SETUP2_12","Mostrar un enlace para administración cuando aparece la pantalla inicial?");
define("S_SETUP2_13","Mostrar un enlace que le permita a los usuarios borrar sus datos ?");
define("S_SETUP2_14","Se requiere registración obligatoria para usar el chat?");
define("S_SETUP2_15","Los Usuarios pueden acceder...");
define("S_SETUP2_16","...solamente la primer sala de las predeterminadas");
define("S_SETUP2_17","...a todas las salas predeterminadas, pero no pueden crear una sala");
define("S_SETUP2_18","...a todas las salas y además pueden crear nuevas");
define("S_SETUP2_19","Estética de los mensajes");
define("S_SETUP2_20","Utilizar caritas (<i>emoticons</i>)(ver 'chat/lib/smilies.lib.php3')?");
define("S_SETUP2_21","Permitir efectos de negrita, itálica y subrayado en mensajes ?");
define("S_SETUP2_22","Mostrar los tags HTML descartados?");
define("S_SETUP2_23","Configuración de presentación predeterminada");
define("S_SETUP2_24","Zona horaria medida en horas entre el tiempo de tu servidor y el de tu país:");
define("S_SETUP2_25","Orden de presentación de los mensajes:");
define("S_SETUP2_26","último al principio");
define("S_SETUP2_27","último al final");
define("S_SETUP2_28","Número de mensajes a mostrar:");
define("S_SETUP2_29","Tiempo para la actualización de mensajes en pantalla (en segundos):");
define("S_SETUP2_30","Mostrar la hora (<i>timestamp</i>)?.");
define("S_SETUP2_31","Mostrar las notificaciones de entrada y/o salida de usuarios?");
define("S_SETUP2_36","Verificar malas palabras (ver 'chat/lib/swearing.lib.php3') ?");
define("S_SETUP2_41","Número máximo de mensajes que un usuario tiene permitido exportar a un archivo HTML (0 para ninguno -el comando está desactivado-, '*' para todos los mensajes posibles, o un valor, para para no sobrecargar al servidor)?");
define("S_SETUP2_42","Activar las posibilidades de bloqueo?<BR>0 para no, un número positivo para definir el número de día/s a bloquear<BR>(2000000 para *siempre*, 0.02 para aprox. media hora...)");
define("S_SETUP2_43","Registración de usuarios");
define("S_SETUP2_44","Generar una clave y enviarla a la dirección de e-mail del usuario?<BR>Esta opción requiere la función <I>'mail()'</I> de PHP activada, (aseguráte con el administrador del server, que podés usarla).<BR>Más aún, para hacer que funcione tenés que definir cuatro variables en el archivo script 'chat/lib/mail_validation.lib.php3'.");
define("S_SETUP2_45","La configuración del PHP que estás usando no parece permitir el uso de la función <I>'mail()'</I>. En consecuencia, no podés elegir que la contraseña se genere automáticamente y se envíe por email al usuario.");
define("S_SETUP2_46","públicos:");
define("S_SETUP2_47","privados:");
define("S_SETUP2_48","Enviar un mensaje de bienvenida al usuario que ingresa al chat (ver 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","Los datos del Administrador están definidos, y solamente un<BR>administrador puede existir. Modificar los campos, por favor<BR>abajo del update los datos existentes.");
define("S_SETUP3_2","Tercer paso: Registración del administrador");
define("S_SETUP3_3","Los datos con <SPAN CLASS=error>*</SPAN> son de ingreso obligatorios.");
define("S_SETUP3_4","login (<i>nick</i>):");
define("S_SETUP3_5","contraseña:");
define("S_SETUP3_6","nombre:");
define("S_SETUP3_7","apellido:");
define("S_SETUP3_8","idiomas:");
define("S_SETUP3_9","sitioweb:");
define("S_SETUP3_10","e-mail:");
define("S_SETUP3_11","mostrar e-mail en el comando /whois");
define("S_SETUP3_12","Pasar por alto >>");
define("S_SETUP3_13","Podrás modificar tus datos posteriormente haciendo click en edit<BR>datos (perfil) en la página de comienzo de %s.");
define("S_SETUP3_14", "Sexo");
define("S_SETUP3_15", "masculino");
define("S_SETUP3_16", "femenino");

// Settings for setup4.php3 file
define("S_SETUP4_1","Cuarto paso: El archivo config");
define("S_SETUP4_2","Aquí está el archivo config, de acuerdo con la información que ingresaste.<BR><BR>Copiá todo, incluyendo las primeras y últimas líneas, y luego pegalas en tu editor de texto favorito (Notepad, Vi...). Después, *tenés que cambiar* la contraseña de tu base de datos en la linea 7 y guardar el archivo como <I>config.lib.php3</I>.<BR><BR>Aseguráte que no haya <B>ni lineas en blanco, ni espacios antes del <i>tag</i> de apertura de php, ni del de cierre (<i>&lt;?php ... ?&gt;</i>)</B>. Finalmente, podés subir (<i>upload</i>) el archivo config al directorio <I>config</I> del servidor (reemplazando el existente). (ver <I>install.txt</I> en el directorio <I>docs</I> para más información sobre esto).<BR><BR>No dejés de mirar el <A HREF=\"#warn\">mensaje de advertencia</A> al final de esta página.");
define("S_SETUP4_3","Seleccionar todo");
define("S_SETUP4_4","Una vez que completaste los pasos de abajo, %s está casi listo para correr.<BR>");
define("S_SETUP4_4m","Deberás configurar manualmente tres variables al principio del archivo <I>'chat/admin/mail4admin.lib.php3'</I><BR>y... ¡a tener interesantes discusiones en tu chat!.");
define("S_SETUP4_5","Después que %s esté instalado y funcionando podrías remover el archivo<BR><I>setup.php3</I> y el directorio <I>'chat/install'</I> en tu servidor.");
?>