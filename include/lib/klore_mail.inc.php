<?php
function xmail
($email_address,
$email_cc,
$email_bcc,
$email_from,
$subject,
$msg,
$attach_filepath,
$want_attach)
{  
       $b = 0;  
       $mail_attached = "";  
       $boundary = "000XMAIL000";  
       if (count($attach_filepath)>0 && $want_attach) {  
           for ($a=0;$a<count($attach_filepath);$a++) {  
               if ($fp=fopen($attach_filepath[$a],"rb")) {  
                   $file_name=basename($attach_filepath[$a]);  
                   $content[$b]=fread($fp,filesize($attach_filepath[$a]));  
                   $mail_attached.="--".$boundary."\n"  
                       ."Content-Type: image/jpeg; name=\"$file_name\"\n"  
                       ."Content-Transfer-Encoding: base64\n"  
                       ."Content-Disposition: inline; filename=\"$file_name\"\n\n"  
                       .chunk_split(base64_encode($content[$b]))."\n";  
                   $b++;  
                   fclose($fp);  
               } else {  
                   echo "No attachments.";  
               }  
           }  
           $mail_attached .= "--".$boundary."\n";  
           $add_header ="MIME-Version: 1.0\n"
."Content-Type: multipart/mixed; boundary=\"$boundary\"; 
Message-ID: <".md5($email_from)."@domain.net>";  
           $mail_content="--".$boundary."\n"  
                       ."Content-Type: text/html; charset=\"iso-8859-1\"\n"  
                       ."Content-Transfer-Encoding: 8bit\n\n"  
                       .$msg."\n\n".$mail_attached;  
           return mail(
		   		$email_address,
				$subject,
				$mail_content,
				"From: ".$email_from."\nCC: ".$email_cc."\nBCC: ".$email_bcc
				."\nErrors-To: ".$email_from."\n".$add_header);  
       } else {  
           return mail(
		   		$email_address,
				$subject,
				$msg,
				"From: ".$email_from."\nCC: ".$email_cc."\nBCC: ".$email_bcc
				."\nErrors-To: ".$email_from); 
       }  
} 


function klore_mail($email,
					 $subject,
					 $body,
					 $from,
					 $bcc = '') {

	global $_base_href;
	global $_template;

	$klore_sig = "</b><br><br>".'-------------------------------------------------------------<br>';
	$klore_sig .= $_template['sent_via_klore'].' <a href="'.$_base_href.'">'.$_base_href.'</a>';

	$body_tmp = '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	<title>KLore LMS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	
	<body>
	<table width="80%" border="0" cellpadding="0" cellspacing="0">
	  <tr bgcolor="#7DBBFF"> 
		<td colspan="3"><p align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#006666" size="2">&nbsp;&nbsp; 
			training </font><font size="2"><br>
			&nbsp;&nbsp;K-Lore</font></strong><font size="2"> Learning Management System </font><br>
			</font></p></td>
	  </tr>
	  <tr bgcolor="#288EFF"> 
		<td colspan="3"><div align="right"><font face="Verdana, Arial, Helvetica, sans-serif"><font color="#FFCC00"><strong><font size="1">i.</font></strong></font><a href=""><font size="1"><strong><font color="#000099">Koncept</font></strong></font></a>&nbsp;&nbsp; 
			</font></div></td>
	  </tr>
	  <tr> 
		<td width="4" bgcolor="#288EFF">&nbsp;</td>
		<td width="98%" bgcolor="#FFFFFF">&nbsp;'
		.stripslashes($body)
		.'</td><td width="4" bgcolor="#288EFF">&nbsp;</td>
	  </tr>
	  <tr bgcolor="#288EFF"> 
		<td colspan="3"><font size="2">'.$klore_sig.'</font></td>
	  </tr>
	</table>
	</body>
	</html>';
	
	$body = $body_tmp;

	$boundary = "000XMAIL000";
	$mail_attached .= "--".$boundary."\n";  
	$add_header ="MIME-Version: 1.0\n"
			."Content-Type: text/html; boundary=\"$boundary\"; 
			Message-ID: <".md5($from)."@mail.com>"; 
	$mail_content= stripslashes($body)."\n\n";  
					   
	if (!mail($email, stripslashes($subject), $mail_content, 'From: '.$from."\nReply-To:".$from."\nBcc: $bcc\nX-Mailer: PHP\n".$add_header)) {
		echo 'Email error: could not send email';
	}
} 

?>
