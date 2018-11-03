<?php include "incl/hdr.inc";?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head><?php print "$crl[1]";?>
<script type="text/javascript" src="incl/cff.js"></script>
<link rel="stylesheet" type="text/css" href="incl/nstl.css">
<?php include "incl/sty.inc";?><title>...</title></head>
<?php if(isset($pass)&&$pass=="12345"){wrl('');
print "<body><script type=\"text/javascript\">self.location='main.php'</script>";
}else{
print "<body onLoad=\"document.forms[0].pass.focus();rfr()\" onUnload=\"unl()\"><form action=\"clear.php\" method=\"post\"><div align=\"center\">";
print "<table class=\"tbl\"><tr><td align=\"right\"><b>$crl[6]:</b></td>";
print "<td width=\"150\"><input type=\"text\" size=\"28\" name=\"pass\" maxlength=\"20\" class=\"ia\"></td>";
print "<td><input type=\"submit\" value=\"$crl[4]\" class=\"ib\"></td>";
print "</tr></table></div></form>";
} ?></body></html>