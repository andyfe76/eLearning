<?php $datetime=gmdate('M j, G:i',time()+0*3600);$pp=time();$log="data/log";$usr="data/usr";set_magic_quotes_runtime(0);
ini_set('error_reporting',7);import_request_variables("GPC");
$dbl='a';function ccl(){global $dbl;if($dbl=='a'){$dbl='b';}else{$dbl='a';}}

function opl(){global $log;$fd=fopen($log,"r") or die('...');$fs=fread($fd,filesize($log));fclose($fd);return $fs;}
function wrl($n){global $log;$fd=fopen($log,"w") or die('...');$fout=fwrite($fd,$n);fclose($fd);}
function opu(){global $usr;$fd=fopen($usr,"r") or die('...');$fs=fread($fd,filesize($usr));fclose($fd);return $fs;}
function wru($n){global $usr;$fd=fopen($usr,"w") or die('...');$fout=fwrite($fd,$n);fclose($fd);}
function sdd($q){die("<html><head><script type=\"text/javascript\">window.location='$q';</script><title>...</title></head><body></body></html>");}
function duu($r){$users='';$fy=opu();$fy=explode("\n",$fy);$fz=array();$j=0;for($i=0;$i<count($fy);$i++){if(isset($fy[$i])&&strlen($fy[$i])>4){$we=explode(":|:",$fy[$i]);$fz[$j]="$we[2]:|:$we[3]:|:$we[1]";$j++;}}rsort($fz);for($i=0;$i<count($fz);$i++){$wg=explode(":|:",$fz[$i]);$users="<img src=\"pics/$wg[1].gif\" width=\"11\" height=\"14\" alt=\"\" title=\"$wg[2]\"> <b>$wg[0]</b>$r$users";}print $users;}
function htmsp($w){$w=str_replace("<","&lt;",$w);$w=str_replace(">","&gt;",$w);$w=str_replace("\r\n"," ",$w);$w=str_replace("\r","",$w);$w=str_replace("\n"," ",$w);return $w;}
function htmse($w){$w=htmsp($w);$w=str_replace(":|:"," ",$w);$w=str_replace("\\'","'",$w);$w=str_replace("\\\"","&quot;",$w);$w=str_replace("\\\\","\\",$w);return $w;}

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

if(isset($nyc)){setcookie('myc',$nyc,time()+86400*100,'/');}elseif(!isset($myc) && !isset($nyc)){setcookie('myc','20',time()+86400*100,'/');$nyc='20';}else{$nyc=$myc;}
if(isset($wik)){setcookie('bik',$wik,time()+86400*100,'/');}elseif(!isset($bik) && !isset($wik)){setcookie('bik','1',time()+86400*100,'/');$wik='1';}else{$wik=$bik;}

if(!is_file($log)||!is_writeable($log)||!is_file($usr)||!is_writeable($usr)){
$fd=fopen($log,"w+") or die('<div align="center" style="color:red;background-color:white"><h3><br><br>WARNING! Create an <u>empty</u> directory /<i style="color:green">data</i> and CHMOD it to 777!</h3></div>');
$fout=fwrite($fd,"");fclose($fd);$fd=fopen($usr,"w+") or die('...');$fout=fwrite($fd,"");fclose($fd);}

include "lang/lang-en.inc";
?>