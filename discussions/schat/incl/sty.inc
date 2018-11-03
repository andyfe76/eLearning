<style type="text/css">
<?php $nyc=(int)$nyc; $wik=(int)$wik;if($wik=='2'){$rd='000000';}else{$rd='ffffff';}

switch($nyc){
case'1':$ra='aaaaaa';$rb='777777';$rc='cccccc';break;
case'2':$ra='888888';$rb='666666';$rc='aaaaaa';break;
case'3':$ra='555555';$rb='333333';$rc='666666';break;
case'4':$ra='cc9966';$rb='996666';$rc='ffcc99';break;
case'5':$ra='ff9966';$rb='cc3333';$rc='cc6633';break;
case'6':$ra='cc9999';$rb='cc6666';$rc='cc6666';break;
case'7':$ra='cc6633';$rb='990000';$rc='ff9966';break;
case'8':$ra='cc3333';$rb='cc0000';$rc='ff6666';break;
case'9':$ra='993333';$rb='990000';$rc='996666';break;
case'10':$ra='cccc66';$rb='004400';$rc='cccc99';break;
case'11':$ra='cc9933';$rb='996600';$rc='cccc66';break;
case'12':$ra='666633';$rb='666600';$rc='999966';break;
case'13':$ra='336666';$rb='006666';$rc='669966';break;
case'14':$ra='003333';$rb='003333';$rc='336666';break;
case'15':$ra='6699cc';$rb='336699';$rc='99ccff';break;
case'16':$ra='336699';$rb='336699';$rc='6699cc';break;
case'17':$ra='006699';$rb='000099';$rc='336699';break;
case'18':$ra='003366';$rb='000044';$rc='006699';break;
case'19':$ra='666699';$rb='666699';$rc='9999cc';break;
default:$ra='333366';$rb='333366';$rc='666699';break;}
if(!isset($ins)){
print "body{font-family:Verdana,Arial,Helvetica,sans-serif;font-size:11px;color:#000000;background-color:#$rc}\n";
}else{
print "body{font-family:Verdana,Arial,Helvetica,sans-serif;font-size:11px;color:#000000;background-color:#eeeeee}\n";
}
print ".p{background-color:#$rd}\n";
print ".c{font-size:12px;font-weight:bold;color:#ffffff;background-color:#$ra}\n";
print ".y{color:#$rb;background-color:transparent}\n";
print "A:link{color:#$rb;background-color:transparent}\nA:visited{color:#$rb;background-color:transparent}\nA:hover{color:#aaaaaa;background-color:transparent}\nA:active{color:#aaaaaa;background-color:transparent}";
?></style>