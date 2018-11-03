<?php
// Define the welcome message to be used when the 'C_WELCOME' switch is set
// to 1 inside the 'chat/config/config.lib.php3' file

switch ($L)
{
   case 'argentinian_spanish':   // Para usuarios en Espa�ol para Argentina
		define('WELCOME_MSG', "Bienvenidos a nuestro chat. El objetivo es conocernos, intercambiar ideas y <I>especialmente, pasar un momento agradable</I>.");
		break;
	case 'danish':	// For danish users
		define('WELCOME_MSG', "Velkommen til chatten. Oprethold venligst en sober tone mens du chatter: <i>fors�g at v�re venlig, rar og im�dekommende</i>.");
		break;
	case 'english':	// For english users
		define('WELCOME_MSG', "Welcome to our chat. Please obey the net etiquette while chatting: <I>try to be pleasant and polite</I>.");
		break;
	case 'french':	// For french users
		define('WELCOME_MSG', "Bienvenu(e) sur notre chat. N\'oubliez pas les <I>r�gles de politesse �l�mentaire</I> au cours de vos discussions.");
		break;
	case 'japanese':	// For japan users
		define('WELCOME_MSG', "����åȤؤ褦������ ¾�Υ桼���������Ǥ򤫤����ˡ��ڤ���Ǥ��äƤ��������͡�");
		break;
	case 'spanish':	// Para usuarios en Espa�ol
		define('WELCOME_MSG', "Bienvenidos a nuestro chat. El objetivo es conocernos, intercambiar ideas y <I>especialmente, pasar un momento agradable</I>.");
	default:		// When there is no translation for the language of the user
		define('WELCOME_MSG', "Welcome to our chat. Please obey the net etiquette while chatting: <I>try to be pleasant and polite</I>.");
};

?>