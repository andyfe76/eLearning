<?php include "incl/hdr.inc";$fs=opl();$mmu=0;
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
		// delete expired instructor session
		$timp = time() - 60;
		$sql = "DELETE FROM c_users WHERE utime<".$timp;
		//echo $sql;
		$res = $db->query($sql);
		
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
	
$n = $username_a;


if(!isset($nnk)){sdd('index.php');}else{
$nnk=urldecode($nnk);$nnk=explode(":|:",$nnk);
$nick=$nnk[2];$bick=$nnk[3];
$gtk="$pp:|:$REMOTE_ADDR:|:$nick:|:$bick";setcookie('nnk',$gtk);
$j=0;$fx=array();$fy=opu();$fy=explode("\n",$fy);

for($i=0;$i<count($fy);$i++){
if(isset($fy[$i])&&$fy[$i]!=''){$rt=explode(":|:",$fy[$i]);
if($pp-$rt[0]<70&&$rt[2]!=$nick){$fx[$j]=$fy[$i];$j++;}
}}$fx=implode("\n",$fx);$fx="$gtk\n$fx";wru($fx);}

if(isset($entry)&&$entry!=''&&isset($nnk)){$entry=htmsp($entry);
$n1=explode(':','\\\\:\\":\\\':[m1]:[m2]:[m3]:[m4]:[m5]:[m6]:[b]:[i]:[c]:[/b]:[/i]:[/c]');
$n2=explode(':','\:":\':<img src="pics/m1.gif" width="15" height="15" hspace="2" alt="">:<img src="pics/m2.gif" width="15" height="15" hspace="2" alt="">:<img src="pics/m3.gif" width="15" height="15" hspace="2" alt="">:<img src="pics/m4.gif" width="15" height="15" hspace="2" alt="">:<img src="pics/m5.gif" width="15" height="15" hspace="2" alt="">:<img src="pics/m6.gif" width="15" height="15" hspace="2" alt="">: <b>: <i>: <span class="y">:</b> :</i> :</span> ');
for($i=0;$i<count($n1);$i++){$entry=str_replace($n1[$i],$n2[$i],$entry);}
$entry=eregi_replace('[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]','<a href="\\0" target="_blank">\\0</a>',$entry);
$eep="$pp:|:$datetime:|:$nnk[2]:|:$nnk[3]:|:$entry\n$fs";wrl($eep);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head><?php print "$crl[1]";?>
<link rel="stylesheet" type="text/css" href="incl/nstl.css">
<script type="text/javascript" src="incl/cff.js"></script>
<title>...</title><?php include "incl/sty.inc";?></head>
<body onLoad="rfr()" onUnload="unl()">
<table width="100%" class="tbl"><tr><td align="center" valign="middle">
<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td class="p">
<table border="0" width="100%" cellpadding="5" cellspacing="1">
<tr><td class="c" colspan="4" align="center"><?php print "$crl[2]";?></td></tr>
<tr><td width="10%" class="f" nowrap>&nbsp;<?php print "$crl[17]";?>&nbsp;</td><td width="10%" align="right" class="f">&nbsp;<?php print "$crl[18]";?>&nbsp;</td><td width="70%" class="f">&nbsp;<?php print "$crl[19]";?>&nbsp;</td><td width="10%" class="f" nowrap>&nbsp;<?php print "$crl[22]";?>&nbsp;</td></tr>
<?php
$qq=12;$fs=opl();$fm=array();$fs=explode("\n",$fs);if(count($fs)<$qq){$qq=count($fs);}
for($i=0;$i<$qq;$i++){if(strlen($fs[$i])>10){$fm[$i]=$fs[$i];}}sort($fm);$ff=count($fm)-1;
for($i=0;$i<count($fm);$i++){if(strlen($fm[$i])>10){$fq=explode(":|:",$fm[$i]);
print "<tr class=\"$dbl\"><td nowrap>$fq[1]</td><td class=\"e\" nowrap>$fq[2] <img src=\"pics/$fq[3].gif\" width=\"11\" height=\"14\" alt=\"\"></td><td>$fq[4]</td>";
if($i==0){print "<td rowspan=\"$qq\" nowrap>";duu('<br>');print "</td>";}
if($i==$ff){$mmu=$fq[0];}print "</tr>\n";ccl();}}
?></table></td></tr></table></td></tr></table>
<?php print "<script type=\"text/javascript\">pp=$mmu;</script>"; 
if(isset($u)){$u=(int)$u;$mmu=(int)$mmu;
if($u!=0&&$u<$mmu){print "<script type=\"text/javascript\">snd()</script>";}}
?></body></html>