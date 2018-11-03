<?php

/* multiple language support for date() */

$day_name_ext = array(
				'it'=>array('Domenica','Lunedi','Martedi','Mercoledi','Giovedi','Venerdi','Sabato'),
				'en'=>array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
				'de'=>array('Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'),
				'fr'=>array('Dimanche','Lundì','Mardì','Mercredì','Jeudì','Vendredì','Samedì'),
				'es'=>array('Domingo','Lunes','Martes','Miercole','Jueves','Viernes','Sabado'),
				'id'=>array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), 
				'no'=>array('Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lordag','Sondag'),
				'jp'=>array('Nichiyoubi','Getsuyoubi','Kayoubi','Suiyoubi','Mokuyoubi','Kinyoubi','Douyoubi')
			);

$day_name_con = array(
				'it'=>array('Dom','Lun','Mar','Mer','Gio','Ven','Sab'),
				'en'=>array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),
				'de'=>array('Son','Mon','Die','Mit','Don','Fre','Sam'),
				'fr'=>array('Dim','Lun','Mar','Mer','Jeu','Ven','Sam'),
				'es'=>array('Dom','Lun','Mar','Mie','Jue','Vie','Sab'),
				'id'=>array('Min','Sen','Sel','Rab','Kam','Jum','Sab'),
				'no'=>array('Man','Tir','Ons','Tor','Fre','Lor','Son'),
				'jp'=>array('Nic','Get','Kay','Sui','Mok','Kin','Dou')
			);

$month_name_ext = array(
				'it'=>array('Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'),
				'en'=>array('January','February','March','April','May','June','July','August','September','October','November','December'),
				'de'=>array('Januar','Februar','Marz','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'),
				'fr'=>array('Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'),
				'es'=>array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),				
				'id'=>array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
				'no'=>array('Januar','February','Mars','April','Mai','Juni','Juli','Oktober','Desember'),
				'jp'=>array('Ichigatsu','Nigatsu','Sangatsu','Shigatsu','Gogatsu','Rokugatsu','Shicigatsu','Hachigatsu','Kugatsu','Jugatsu','Juichigatsu','Junigatsu')				
			);
			
$month_name_con = array(
				'it'=>array('Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'),
				'en'=>array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
				'de'=>array('Jan','Feb','Mar','Apr','Mag','Jun','Jul','Aug','Sep','Okt','Nov','Dez'),
				'fr'=>array('Jan','Fev','Mar','Avr','Mai','Jui','Jul','Aou','Sep','Oct','Nov','Dec'),
				'es'=>array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'),
				'id'=>array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'),
				'no'=>array('Jan','Feb','Mar','Apr','Mai','Jun','Jul','Okt','Des'),
				'jp'=>array('Ich','Nig','San','Shi','Gog','Rok','Shi','Hac','Kug','Jug','Jui','Jun')	
			);

/* Uses the same options as date(), but require a % infront of each argument and the
/* textual values are language dependant ( unlike date() ).

	the following options were added as language dependant:

	%D: A textual representation of a week, three letters Mon through Sun
	%F: A full textual representation of a month, such as January or March January through December
	%l (lowercase 'L'): A full textual representation of the day of the week Sunday through Saturday
	%M: A short textual representation of a month, three letters Jan through Dec
	?? %S: English ordinal suffix for the day of the month, 2 characters st, nd, rd or th. Works well with j
	?? a: Lowercase Ante meridiem and Post meridiem am or pm 
	?? A: Uppercase Ante meridiem and Post meridiem AM or PM 

	valid format_types:
	AT_MYSQL_DATETIME:		YYYY-MM-DD HH:MM:SS
	AT_MYSQL_TIMESTAMP_14:	YYYYMMDDHHMMSS
	AT_UNIX_TIMESTAMP:		seconds since epoch
*/
function AT_date($lang = 'en', $format='%Y-%M-%d', $timestamp = '', $format_type=AT_MYSQL_DATETIME)
{	
	global $day_name_con, $day_name_ext, $month_name_con, $month_name_ext;

	if ($timestamp == '') {
		$timestamp = time();
		$format_type = AT_UNIX_TIMESTAMP;
	}

	/* 1. convert the date to a Unix timestamp before we do anything with it */
	if ($format_type == AT_MYSQL_DATETIME) {
		$year	= substr($timestamp,0,4);
		$month	= substr($timestamp,5,2);
		$day	= substr($timestamp,8,2);
		$hour	= substr($timestamp,11,2);
		$min	= substr($timestamp,14,2);
		$sec	= substr($timestamp,17,2);
	    $timestamp	= mktime($hour, $min, $sec, $month, $day, $year);

	} else if ($format_type == AT_MYSQL_TIMESTAMP_14) {
	    $hour		= substr($timestamp,8,2);
	    $minute		= substr($timestamp,10,2);
	    $second		= substr($timestamp,12,2);
	    $month		= substr($timestamp,4,2);
	    $day		= substr($timestamp,6,2);
	    $year		= substr($timestamp,0,4);
	    $timestamp	= mktime($hour, $minute, $second, $month, $day, $year);  
	}

	/* pull out all the %X items from $format */
	$first_token = strpos($format, '%');
	if ($first_token === false) {
		/* no tokens found */
		return $timestamp;
	} else {
		$tokened_format = substr($format, $first_token);
	}
	$tokens = explode('%', $tokened_format);
	array_shift($tokens);
	$num_tokens = count($tokens);

	$output = $format;
	for ($i=0; $i<$num_tokens; $i++) {
		$tokens[$i] = substr($tokens[$i],0,1);

		if ($tokens[$i] == 'D') {
			$output = str_replace('%D', $day_name_con[$lang][date('w', $timestamp)],$output);
		
		} else if ($tokens[$i] == 'l') {
			$output = str_replace('%l', $day_name_ext[$lang][date('w', $timestamp)],$output);
		
		} else if ($tokens[$i] == 'F') {
			$output = str_replace('%F', $month_name_ext[$lang][date('n', $timestamp)-1],$output);		
		
		} else if ($tokens[$i] == 'M') {
			$output = str_replace('%M', $month_name_con[$lang][date('n', $timestamp)-1],$output);

		} else {

			/* this token doesn't need translating */
			$value = date($tokens[$i], $timestamp);
			if ($value != $tokens[$i]) {
				$output = str_replace('%'.$tokens[$i], $value, $output);
			} /* else: this token isn't valid. so don't replace it. Eg. try %q */
		}
	}
	return $output;
}
	
?>