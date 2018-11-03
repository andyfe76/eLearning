<?php 
$_include_path = '../include/';
require_once($_include_path.'vitals.inc.php');
require_once ($_include_path.'lib/klore_mail.inc.php');

// first: check the max_stud limit
	$sql	  = "SELECT COUNT(*) FROM course_enrollment WHERE course_id=$course_id AND approved='y'";
	$c_result = $db->query($sql);
	$c_row	  = $c_result->fetchRow(DB_FETCHMODE_ASSOC);
	
	$sql 	  = "SELECT email,login FROM members WHERE member_id=$mid";
	$res_e	  = $db->query($sql);
	$row_e	  = $res_e->fetchRow(DB_FETCHMODE_ASSOC);
	$m_email  = $row_e['EMAIL'];
	$m_login  = $row_e['LOGIN'];
	$sql 	  = "SELECT title FROM courses WHERE course_id=$course_id";
	$res_cid  = $db->query($sql);
	$row_cid  = $res_cid->fetchRow(DB_FETCHMODE_ASSOC);
	$course_name = $row_cid['TITLE'];
	
	$sql	= "SELECT first_name,last_name FROM members_pers WHERE member_id=$mid";
	$result3	= $db->query($sql);
	$row3	= $result3->fetchRow(DB_FETCHMODE_ASSOC);
	$knume=$row3['LAST_NAME'];
	$kprenume=$row3['FIRST_NAME'];
	
	$sql	= "SELECT text FROM notifications WHERE name='ENROLL' AND course_id=".$course_id;
	$result2	= $db->query($sql);
	$row2	= $result2->fetchRow(DB_FETCHMODE_ASSOC);

	$subject=$knume." ".$kprenume." ai fost inscris la cursul `".$course_name."`";
	$msg="
  <p>Durata estimativa de invatare a cursului este de 10 ore. Iti oferim 30 de
  zile incepand de azi pentru a parcurge programul, dupa care informatiile tale
  de acces se vor dezactiva.<br>
  Iti recomandam sa incepi cu Sinteza Cursului dupa care sa studiezi Cursul Aprofundat.<br>
  Testele de cunostinte de la sfarsitul fiecarui capitol te vor ajuta sa masori
  gradul de intelegere a continutului si sa revii acolo unde vrei sa aprofundezi. <br>
  Vom considera cursul absolvit atunci cand rata de reusita la teste este cel
  putin 70% raspunsuri corecte. <br>
  Poti descarca materialul cursului pentru consultari ulterioare.<br>
  Succes !</p>
  <p>
  <b>Acesta este un mesaj informativ. Te rugam nu raspunde la acest mail!</b>
  </p>";
	
	
	$sql	  = "SELECT * FROM course_maxstud WHERE course_id=$course_id";
	$res 	  = $db->query($sql);
	if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if (intval($row['MAX_STUD']) <= intval($c_row[0])) {
			$errors[] = AT_ERROR_MAX_STUD_REACHED;
		} else {
			$sql = "INSERT into course_enrollment VALUES ($member_id, $course_id, 'y', SYSDATE, SYSDATE)";
			$res = $db->query($sql);
			klore_mail($m_email, $subject,$msg, 'name@mail.com');
		}
	} else {
		$sql = "INSERT into course_enrollment VALUES ($member_id, $course_id, 'y', SYSDATE, SYSDATE)";
		$res = $db->query($sql);
		klore_mail($m_email, $subject,$msg,'name@mail.com');
	}
	
	if (!$errors) {
		// KEEP TEST RESULTS FOR HISTORY
		$sql = "DELETE FROM tests_answers WHERE member_id=$member_id";
		$res = $db->query($sql);
		$sql = "DELETE FROM test_process WHERE member_id=$member_id";
		$res = $db->query($sql);
		$sql = "DELETE FROM tests_status WHERE member_id=$member_id";
		$res = $db->query($sql);
	}
?>