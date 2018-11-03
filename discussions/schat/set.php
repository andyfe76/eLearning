<?php 
include "incl/hdr.inc"; 
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
	
$n = $username_a;
if(!isset($n)||!isset($b)){sdd('index.php');}
$nick=trim($n);$bick=trim($b);$nick=htmse($nick);
if($nick==''||$bick==''||strlen($nick)>60||strlen($bick)>2){sdd('index.php');}else{

$j=0;$fm=array();$fs=opu();$fs=explode("\n",$fs);

for($i=0;$i<count($fs);$i++){
if(isset($fs[$i])&&$fs[$i]!=''){$rt=explode(":|:",$fs[$i]);
if($pp-$rt[0]<70&&$rt[2]!=$nick){$fm[$j]=$fs[$i];$j++;}
if($nick==$rt[2]){sdd('index.php?tkn=1');}
}}
$gtk="$pp:|:$REMOTE_ADDR:|:$nick:|:$bick";setcookie('nnk',$gtk);
$fm=implode("\n",$fm);$fm="$gtk\n$fm";wru($fm);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"><html><head>
<?php print $crl[1];?><title><?php print $crl[2];?></title>
</head><frameset rows="*,90,20">
<frame src="main.php" name="a" marginwidth="8" marginheight="0" frameborder="0" scrolling="auto" noresize>
<frame src="insert.php" name="b" marginwidth="2" marginheight="12" frameborder="0" scrolling="no" noresize>
<frame src="non.php" name="c" marginwidth="0" marginheight="0" frameborder="0" scrolling="no" noresize>
<noframes><?php print $crl[21];?></noframes></frameset></html>