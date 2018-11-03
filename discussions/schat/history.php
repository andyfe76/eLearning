<?php include "incl/hdr.inc";?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head><?php print "$crl[1]";?>
<link rel="stylesheet" type="text/css" href="incl/nstl.css">
<script type="text/javascript" src="incl/cff.js"></script>
<title>...</title><?php include "incl/sty.inc";?></head><body>
<table width="100%" class="tbl"><tr><td align="center" valign="middle">
<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td class="p">
<table border="0" width="100%" cellpadding="5" cellspacing="1">
<tr><td class="c" colspan="4" align="center"><?php print "$crl[2] $crl[20]";?></td></tr>
<tr><td width="15%" class="f">&nbsp;<?php print "$crl[17]";?></td><td width="15%" align="right" class="f"><?php print "$crl[18]";?>&nbsp;</td><td width="70%" class="f" align="left">&nbsp;<?php print "$crl[19]";?></td></tr>
<?php $fs=opl();$fs=explode("\n",$fs);sort($fs); 
for($i=0;$i<count($fs);$i++){if(strlen($fs[$i])>10){$fq=explode(":|:",$fs[$i]);
print "<tr class=\"$dbl\"><td nowrap>$fq[1]</td><td class=\"e\" nowrap>$fq[2] <img src=\"pics/$fq[3].gif\" width=\"11\" height=\"14\" alt=\"\"></td><td>$fq[4]</td>";
print "</tr>\n";ccl();}} ?></table></td></tr></table></td></tr></table></body></html>