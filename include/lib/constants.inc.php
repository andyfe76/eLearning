<?php

/*******************
 * constants
 ******/
/* used for the collapse/expand as well as open/close */
define('MENU_CLOSE',        0);	/* also: DISABLE, COLLAPSE */
define('MENU_OPEN',         1); /* also: ENABLE,  EXPAND  */
define('OPEN',				1); /* also: ENABLE,  EXPAND  */
define('CLOSE',				0); /* also: ENABLE,  EXPAND  */

define('TOP',				1);
define('BOTTOM',			2);
define('BOTH',				3);

define('MENU_RIGHT',		0); /* the location of the menu */
define('MENU_LEFT',			1);

/* how many related topics can be listed? */
define('NUM_RELATED_TOPICS', 5);

/* how long cache objects can persist		*/
/* in seconds. should be low initially, but doesn't really matter. */
/* in practice should be 0 (ie. INF)				*/
define('CACHE_TIME_OUT',	60);

define('AT_KBYTE_SIZE',		1024);

// colours[0] = array('NAME' => 'fancy blue', 'FILE' => 'blue');
// not translated, to be recreated in theme builder
$_colours[0]['NAME'] = 'klore Original';
$_colours[0]['FILE'] = 'stylesheet';
$_colours[1]['NAME'] = 'Chrome';
$_colours[1]['FILE'] = 'chrome';
$_colours[2]['NAME'] = 'Dusty Rose';
$_colours[2]['FILE'] = 'pink';
$_colours[3]['NAME'] = 'Faded Green';
$_colours[3]['FILE'] = 'green';
$_colours[4]['NAME'] = 'Fancy Blue';
$_colours[4]['FILE'] = 'blue';
$_colours[5]['NAME'] = 'Coloured';
$_colours[5]['FILE'] = 'multi';
$_colours[6]['NAME'] = 'Colour High Contrast';
$_colours[6]['FILE'] = 'high';
$_colours[7]['NAME'] = 'Mono High Contrast';
$_colours[7]['FILE'] = 'high2';

//$_colours[6]['NAME'] = 'Course Default Colours';
//$_colours[6]['FILE'] = 'content/'.$_SESSION[course_id].'/stylesheet';


$_fonts[0]['NAME'] = 'Verdana';
$_fonts[0]['FILE'] = 'verdana';
$_fonts[1]['NAME'] = 'Helvetica';
$_fonts[1]['FILE'] = 'helvetica';
$_fonts[2]['NAME'] = 'Times New Roman';
$_fonts[2]['FILE'] = 'times';
$_fonts[3]['NAME'] = 'Courier New';
$_fonts[3]['FILE'] = 'courier';
$_fonts[4]['NAME'] = 'Garamond';
$_fonts[4]['FILE'] = 'garamond';
$_fonts[5]['NAME'] = 'Comic';
$_fonts[5]['FILE'] = 'comic';
$_fonts[6]['NAME'] = 'Arial';
$_fonts[6]['FILE'] = 'arial';


if (strpos(ini_get('arg_separator.input'), ';') !== false) {
	define('SEP', ';');
} else {
	define('SEP', '&');
}

$PHP_SELF		= $_SERVER['PHP_SELF'];
$REQUEST_URI    = $_SERVER['REQUEST_URI'];

/* get the base url									*/
$dir_deep		= substr_count($_include_path, '..');
$current_url	= $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$url_parts		= explode('/', $current_url);
$_base_href		= array_slice($url_parts, 0, count($url_parts) - $dir_deep-1);
$_base_href		= 'http://'.implode('/', $_base_href).'/';


ini_set('register_globals',		  '0');
ini_set('session.use_trans_sid',  '0');
ini_set('session.gc_maxlifetime', '7200'); /* 2 hours */

define('DEBUG',			1);
define('HELP',			0);
define('VERSION',		'1.1');
define('ONLINE_UPDATE', 3); /* update the user expiry every 3 min */

/* valid date format_types:						*/
/* @see ./include/lib/date_functions.inc.php	*/
define('AT_MYSQL_DATETIME',		1); /* YYYY-MM-DD HH:MM:SS	*/
define('AT_MYSQL_TIMESTAMP_14', 2); /* YYYYMMDDHHMMSS		*/
define('AT_UNIX_TIMESTAMP',		3); /* seconds since epoch	*/

?>