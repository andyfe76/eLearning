<?php

function klore_mail($email,
					 $subject,
					 $body,
					 $from,
					 $bcc = '') {

	global $_base_href;
	global $_template;

	$klore_sig = "\n\n".'----------------------------------------------'."\n";
	$klore_sig .= $_template['sent_via_klore'].' '.$_base_href;
	$klore_sig .= "\n".$_template['klore_home'].": http://klore.com";

	$body .= $klore_sig;

	mail($email, stripslashes($subject), stripslashes($body), 'From: '.$from."\nReply-To:".$from."\nBcc: $bcc\nX-Mailer: PHP");
} 

?>