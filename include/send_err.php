<?php
	$subject = "KLore Connex Error: Curs -".$_SESSION['course_title'].'.';
				//$fromname = 'K-Lore Learning Management System';
				$fromemail = 'dealer.training@connex.ro';
				
		    	klore_mail("marian.vasile@koncept.ro", 
						$subject, 
						$message, 
						'<'.$fromemail.'>');
?>