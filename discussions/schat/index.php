<?php include "incl/hdr.inc"; 
	$section = 'discussions';
	$_include_path = '../../include/';
	
	require_once($_include_path.'vitals.inc.php');
	if ($_SESSION['is_admin'] || $_SESSION['c_instructor']) {
		//enter the room;
		$username = 'tmp';
		$sql = "SELECT COUNT(member_id) FROM c_users WHERE member_id=$_SESSION[member_id]";
		$res = $db->query($sql);
		$row = $res->fetchRow();
		$utime = time();
		if ($row[0] >0) {
			// sql update 
			$sql = "UPDATE c_users SET utime=$utime";
			$res = $db->query($sql);
		} else {
			$sql = "INSERT INTO c_users VALUES ($_SESSION[member_id], $_SESSION[status], 0, '$username', $utime)";
			$res = $db->query($sql);
		}
	} else {
		// check to see if instructor is logged in
		$statuslist = STATUS_ADMINISTRATOR.','.STATUS_TRAINER.','.STATUS_TRAINING_MANAGER;
		$sql = "SELECT COUNT(C.member_id) FROM c_users C INNER JOIN members M ON C.member_id=M.member_id WHERE M.status IN ($statuslist)";
		$res = $db->query($sql);
		$row = $res->fetchRow();
		if ($row[0] == 0) {
			echo 'Sorry, no instructor present in the chat room. Chatting between students is not allowed';
			exit;
		}
	}
	
	$sql = "SELECT login FROM members WHERE member_id=$_SESSION[member_id]";
	$res = $db->query($sql);
	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$username_a = $row['LOGIN'];
	

$j=0;$fx=array();$fy=opu();$fy=explode("\n",$fy);$nick=$username_a;
if(isset($nnk)){$nnk=urldecode($nnk);$nnk=explode(":|:",$nnk);$nick=$nnk[2];}
$nick = $username_a;
if(isset($tkn)&&!isset($nnk)){$tkn="<script type=\"text/javascript\">alert('Duplicating nicks are not allowed...')</script>";}else{$tkn='';}


for($i=0;$i<count($fy);$i++){
if(isset($fy[$i])&&$fy[$i]!=''){$rt=explode(":|:",$fy[$i]);
if($pp-$rt[0]<70&&$nick!=$rt[2]){$fx[$j]=$fy[$i];$j++;}
}}$fx=implode("\n",$fx);wru($fx); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>
<link rel="stylesheet" type="text/css" href="incl/nstl.css">
<?php print $crl[1];?><title><?php print $crl[2];?></title>
<script type="text/javascript" src="incl/inx.js"></script>
<?php include "incl/sty.inc";?></head><body onLoad="lo()">
<form action="set.php" method="post"><input type="hidden" value="w1" name="b">
<table align="center" class="tbl" width="330"><tr><td align="center" valign="middle">
<table border="0" width="100%" cellpadding="1" cellspacing="2"><tr><td class="c">
<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td bgcolor="#ffffff">
<table border="0" width="100%" cellpadding="5" cellspacing="1">
<tr><td class="c" align="center"><?php print "$crl[2]";?></td></tr><tr><td class="b">
<table border="0" cellpadding="1" cellspacing="1"><tr>
<td rowspan="2" valign="top" nowrap><b><?php print $crl[24];?> <script type="text/javascript">df()</script>:</b></td>
<td valign="bottom" align="center"><input type="text" disabled size="30" name="n" maxlength="8" class="ia" value="<?php print $nick; ?>"></td>
<td rowspan="2" valign="top"> <input type="submit" value=" OK " class="ib"></td>
</tr><tr><td align="center" valign="top" nowrap>
<a href="#" onClick="wr('w1');return false"><img src="pics/w1.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('s1');return false"><img src="pics/s1.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('w2');return false"><img src="pics/w2.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('s2');return false"><img src="pics/s2.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('w3');return false"><img src="pics/w3.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('s3');return false"><img src="pics/s3.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('w4');return false"><img src="pics/w4.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('s4');return false"><img src="pics/s4.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('w5');return false"><img src="pics/w5.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('s5');return false"><img src="pics/s5.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('w6');return false"><img src="pics/w6.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('s6');return false"><img src="pics/s6.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('w7');return false"><img src="pics/w7.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
<a href="#" onClick="wr('s7');return false"><img src="pics/s7.gif" width="11" height="14" vspace="6" border="0" alt=""></a>
</td></tr></table></td></tr>
<tr><td class="c" align="center"><?php print "$crl[22]";?></td></tr>
<tr><td class="b" align="center">
<?php $fy=opu();if(strlen($fy)<20){print "<b>$crl[23]</b>";}else{duu(' ');} ?></td></tr>
</table></td></tr></table></td></tr></table></td></tr></table></form><?php print $tkn; ?></body></html>
<?php $fsr=opl();$myar=explode("\n",$fsr);$nr='';
for($i=0;$i<150;$i++){if(isset($myar[$i])){$nr=$nr.$myar[$i]."\n";}}wrl($nr);?>