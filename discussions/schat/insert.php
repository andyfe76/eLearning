<?php include "incl/hdr.inc";$ins=true;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><?php print $crl[1];?>
<link rel="stylesheet" type="text/css" href="incl/nstl.css"><script type="text/javascript" src="incl/mdf.js"></script>
<?php include "incl/sty.inc";?></head><body onLoad="fc()">
<form action="main.php" target="a" method="post" onSubmit="tu()"><table align="center" border="0" width="450">
<tr><td colspan="3"><input type="text" name="entry" size="65" maxlength="180" class="ia"></td>
<td align="right"><input type="submit" value="<?php print "$crl[4]";?>" class="ib"></td>
</tr><tr><td colspan="4" nowrap> </td></tr><tr><td valign="top" nowrap><b>
<a href="main.php" onClick="rd('main');return false" target="a" title="<?php print $crl[26];?>"><?php print $crl[25];?></a> | 
<a href="history.php" onClick="rd('history');return false" target="a" title="<?php print $crl[28];?>"><?php print $crl[27];?></a> | 
<a href="index.php" target="_parent" title="<?php print $crl[30];?>"><?php print $crl[29];?></a> | 
<a href="clear.php" onClick="rd('clear');return false" target="a" title="<?php print $crl[32];?>"><?php print $crl[31];?></a> | 
<a href="about.php" onClick="rd('about');return false" target="a" title="<?php print $crl[33];?>"><?php print $crl[33];?></a>
</b></td><td nowrap>
<a href="#" onClick="sp('[m1]');return false"><img src="pics/m1.gif" width="15" height="15" alt="<?php print "$crl[8]";?>" border="0"></a>
<a href="#" onClick="sp('[m2]');return false"><img src="pics/m2.gif" width="15" height="15" alt="<?php print "$crl[9]";?>" border="0"></a>
<a href="#" onClick="sp('[m3]');return false"><img src="pics/m3.gif" width="15" height="15" alt="<?php print "$crl[10]";?>" border="0"></a>
<a href="#" onClick="sp('[m4]');return false"><img src="pics/m4.gif" width="15" height="15" alt="<?php print "$crl[11]";?>" border="0"></a>
<a href="#" onClick="sp('[m5]');return false"><img src="pics/m5.gif" width="15" height="15" alt="<?php print "$crl[12]";?>" border="0"></a>
<a href="#" onClick="sp('[m6]');return false"><img src="pics/m6.gif" width="15" height="15" alt="<?php print "$crl[13]";?>" border="0"></a>
</td><td valign="top" nowrap><b><a href="#" onClick="sp('[b][/b]');return false" title="<?php print "$crl[14]";?>">B</a></b> <b><a href="#" onClick="sp('[i][/i]');return false" title="<?php print "$crl[15]";?>">I</a></b> <b><a href="#" onClick="sp('[c][/c]');return false" title="<?php print "$crl[16]";?>">C</a></b>
</td><td align="right" valign="middle" nowrap>
<a href="#" title="<?php print "$crl[34]";?>5 sec" onClick="fg(5000);document.a.src='pics/on.gif';return false"><img name="a" src="pics/of.gif" width="10" height="9" border="0" alt="<?php print "$crl[34]";?>5 sec" hspace="1"></a><a href="#" title="<?php print "$crl[34]";?>10 sec" onClick="fg(10000);document.b.src='pics/on.gif';return false"><img name="b" src="pics/of.gif" width="10" height="9" border="0" alt="<?php print "$crl[34]";?>10 sec" hspace="0"></a><a href="#" title="<?php print "$crl[34]";?>20 sec" onClick="fg(20000);document.c.src='pics/on.gif';return false"><img name="c" src="pics/on.gif" width="10" height="9" border="0" alt="<?php print "$crl[34]";?>20 sec" hspace="1"></a><a href="#" title="<?php print "$crl[34]";?>30 sec" onClick="fg(30000);document.d.src='pics/on.gif';return false"><img name="d" src="pics/of.gif" width="10" height="9" border="0" alt="<?php print "$crl[34]";?>30 sec" hspace="0"></a><a href="#" title="<?php print "$crl[34]";?>60 sec" onClick="fg(60000);document.e.src='pics/on.gif';return false"><img name="e" src="pics/of.gif" width="10" height="9" border="0" alt="<?php print "$crl[34]";?>60 sec" hspace="1"></a>
</td></tr><tr><td colspan="4" nowrap>
<img border="0" src="pics/clrs.gif" width="437" height="7" usemap="#clrs"><img src="pics/spc.gif" width="<?php $crl[0]=(int)$crl[0]; print $crl[0];?>" height="7">
<script type="text/javascript">
if(typeof document.layers!='object'){document.write('<img style="cursor:hand" src="pics/sndn.gif" width="12" height="7" border="0" onClick="sd(this)" alt="<?php print $crl[3]?>" title="<?php print $crl[3]?>">')}
</script><map name="clrs">
<area href="#" onClick="ow(1);return false" shape="rect" coords="0,0,20,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(2);return false" shape="rect" coords="21,0,41,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(3);return false" shape="rect" coords="42,0,62,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(4);return false" shape="rect" coords="63,0,83,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(5);return false" shape="rect" coords="84,0,104,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(6);return false" shape="rect" coords="105,0,125,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(7);return false" shape="rect" coords="126,0,146,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(8);return false" shape="rect" coords="147,0,167,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(9);return false" shape="rect" coords="168,0,188,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(10);return false" shape="rect" coords="189,0,209,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(11);return false" shape="rect" coords="210,0,230,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(12);return false" shape="rect" coords="231,0,251,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(13);return false" shape="rect" coords="252,0,272,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(14);return false" shape="rect" coords="273,0,293,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(15);return false" shape="rect" coords="294,0,314,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(16);return false" shape="rect" coords="315,0,335,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(17);return false" shape="rect" coords="336,0,356,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(18);return false" shape="rect" coords="357,0,377,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(19);return false" shape="rect" coords="378,0,398,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="ow(20);return false" shape="rect" coords="399,0,419,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="bd(1);return false" shape="rect" coords="422,0,429,7" alt="<?php print $crl[7];?>">
<area href="#" onClick="bd(2);return false" shape="rect" coords="430,0,437,7" alt="<?php print $crl[7];?>">
</map></td></tr></table></form></body></html>