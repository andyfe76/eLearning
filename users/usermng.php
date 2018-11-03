<?php
$section = 'users';
$_include_path = '../include/';

require($_include_path.'vitals.inc.php');
require($_include_path.'lib/klore_mail.inc.php');
//require($_include_path.'dynupdate.php');

if ((!$_SESSION['c_instructor'])&& (!$_SESSION['is_admin'])&&(!$_SESSION['group_mng'])&&(!$_SESSION['coordinator'])){
		require($_include_path.'cc_html/header.inc.php');
		$errors[]=AT_ERROR_ACCESS_DENIED;
		print_errors($errors);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
}
	
	
if ($_GET['grp']) {
	$group = $_GET['grp'];
	$sql = "SELECT category FROM member_groups WHERE group_id=$group";
	$res = $db->query($sql);
	$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
	$category = $row['CATEGORY'];
}

if ($_POST['category']) {
	$category = $_POST['category'];
	$group = '';
}

if (($_POST['group']) && (!$_POST['form_categ_change'])) {
	$group = $_POST['group'];
}

$dyngrp = false;
if ($_POST['form_dyn_change']) {
	$dyngrp = $_POST['dyngrp'];
	Header('Location: ../include/dynupdate.php?group='.$dyngrp);
	exit;
}
if (isset($_GET['dyngrp'])) {
	$dyngrp = $_GET['dyngrp'];
}


if ($_POST['grp_name']) {
	// create new group
	if ($_POST['grp_name'] == "" ) {
		$errors[] = AT_ERROR_BAD_GROUP_NAME;
	} else {
		$sql = "SELECT name FROM member_groups WHERE name='$grp_name' AND category='".$_POST['category']."'";
		$res = $db->query($sql);
		$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
		$countsql = "SELECT COUNT(*) FROM (".$sql.")";
		$countres = $db->query($countsql);
		$count0 = $countres->fetchRow();
		if ($count0[0] >= 1) {
			$errors[] = AT_ERROR_GROUP_EXISTING;
		} else {
			$id = $db->nextId("AUTO_MEMBER_GROUPS_GID");
			$sql = "INSERT INTO member_groups VALUES ('$category', $id, '$grp_name', '')"; // no group comments so far
			$res = $db->query($sql);
			$feedback[] = AT_FEEDBACK_SUCCESS;
		}
	}
}

	function quote_csv($line) {
		$line = str_replace('"', '""', $line);
	
		$line = str_replace("\n", '\n', $line);
		$line = str_replace("\r", '\r', $line);
		$line = str_replace("\x00", '\0', $line);
	
		return '"'.$line.'"';
	}
	
	function save_csv($name, $sql, $fields) {
		global $db;
	
		$content = '';
		$num_fields = count($fields);
	
		$result = $db->query($sql);
		while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
			for ($i=0; $i< $num_fields; $i++) {
				if ($fields[$i][1] == NUMBER) {
					$content .= $row[$fields[$i][0]] . ',';
				} else {
					$content .= quote_csv($row[$fields[$i][0]]) . ',';
				}
			}
			$content = substr($content, 0, strlen($content)-1);
			$content .= "\n";
		}
		//echo $content;
		$result->free(); 
	
		$fp = @fopen('../content/export/'.$name.'.csv', 'w');
		if (!$fp) {
			$errors[]=array(AT_ERROR_CSV_FAILED, $name);
			print_errors($errors);
			exit;
		}
		@fputs($fp, $content); @fclose($fp);
	}

	if($_GET['csv']=='1'){
		if (!is_dir('../content/export/')) {
			if (!@mkdir('../content/export', 0700)) {
				$errors[]=AT_ERROR_EXPORTDIR_FAILED;
				print_errors($errors);
				exit;
			}
		}
		define('NUMBER',	1);
		define('TEXT',		2);
		
		/* content.csv */
		$sql	= 'SELECT M.*, N.first_name, N.last_name, G.group_id as gid FROM members M INNER JOIN mrel_groups G ON M.member_id=G.member_id, members_pers N WHERE M.member_id=N.member_id';
	
		$fields = array();
		$fields[0] = array('MEMBER_ID',			NUMBER);
		$fields[1] = array('LOGIN', 			NUMBER);
		$fields[2] = array('PASSWORD',			TEXT);
		$fields[3] = array('EMAIL',				TEXT);
		$fields[4] = array('STATUS',			NUMBER);
		$fields[5] = array('PREFERENCES',		TEXT);
		
		$fields[6] = array('CUSTOM1',			TEXT);
		$fields[7] = array('CUSTOM2',			TEXT);
		$fields[8] = array('CUSTOM3',			TEXT);
		$fields[9] = array('CUSTOM4',			TEXT);
		$fields[10] = array('CUSTOM5',			TEXT);
		$fields[11] = array('CUSTOM6',			TEXT);
		$fields[12] = array('CUSTOM7',			TEXT);
		$fields[13] = array('CUSTOM8',			TEXT);
		$fields[14] = array('CUSTOM9',			TEXT);
		$fields[15] = array('CUSTOM10',			TEXT);
		$fields[16] = array('GID',				NUMBER);
		$fields[17] = array('FIRST_NAME', 		TEXT);
		$fields[18] = array('LAST_NAME', 		TEXT);
	
		$name='users';
		save_csv($name, $sql, $fields);
		
		header('Content-Type: text/csv');
		header('Content-Disposition: inline; filename="'.$name.'.csv"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		//$fp = @unlink('../content/export/'.$name.'_users.csv');
		$fp = @fopen('../content/export/'.$name.'.csv', 'r');
		if (!$fp) {
			$errors[]=array(AT_ERROR_CSV_FAILED, $name);
			print_errors($errors);
			exit;
		}
		@readfile('../content/export/'.escapeshellcmd($name).'.csv');
		@unlink('../content/export/'.escapeshellcmd($name).'.csv');
		exit;
	}
//*** Import users
/*if($_GET['csv']=='2'){
	Header('Location: users/import_usr.php?group='.$group);
	exit;
}*/
	
//modif \/
if (isset($_GET['lock'])) {
	$sql="UPDATE members SET modif_date=TO_DATE('01/01/1980 00:00:00', 'DD/MM/YYYY HH24:MI:SS') WHERE member_id=$_GET[lock]"; 
	$res = $db->query($sql);
	unset ($_GET['lock']);
}

if (isset($_GET['unlock'])) {
	$sql="UPDATE members SET modif_date=SYSDATE WHERE member_id=$_GET[unlock]"; 
	$res = $db->query($sql) ;
	
	$sql = "UPDATE LOGIN_ATEMPTS SET A_NR=0 WHERE LOGIN = (SELECT login FROM members where member_id=$_GET[unlock])";
	$res = $db->query($sql);
	unset ($_GET['unlock']);
}

if ($_POST['form_dyn_change']) {
	$dyn_grp = $_POST['dyngrp'];
}

if ($_POST['policy'] || $_POST['group_change'] || $_POST['enroll'] || $_POST['delete'] || $_POST['mark']){
	if (!$_POST['group_id']) {
		require($_include_path.'cc_html/header.inc.php');
		$errors[] = AT_ERROR_GROUP_MISSING;
		print_errors();
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}
	$sql 	= "SELECT M.*, G.* FROM members M, mrel_groups G WHERE M.member_id=G.member_id AND G.group_id=$_POST[group_id]";
	$result = $db->query($sql);
	while ($row =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$mid = $row['MEMBER_ID'];
		if ($_POST['policy']) {
			// action: Policy change
			if ($_POST['m'.$mid]){
				$pmid = $mid;
				$gid = $_POST['group_id'];
				if ($_POST['pol'] == '1') $s = STATUS_STUDENT;
				else if ($_POST['pol'] == '2') $s = STATUS_TRAINER;
				else if ($_POST['pol'] == '6') $s = STATUS_TRAINING_MANAGER;
				else if ($_POST['pol'] == '3') $s = STATUS_ADMINISTRATOR;
				else if ($_POST['pol'] == '4') {
					$s = STATUS_GROUP_MANAGER;
					$sql = "DELETE FROM group_mng WHERE member_id=$pmid";
					$res_gm = $db->query($sql);
					$sql = "INSERT INTO group_mng VALUES ($pmid, $gid, 'gmng')";
					$res_gm = $db->query($sql);
				}
				else if ($_POST['pol'] == '5') {
					$s = STATUS_COORDINATOR;
					$sql = "DELETE FROM coord_groups WHERE member_id=$pmid";
					$res_coord = $db->query($sql);
					$sql = "INSERT INTO coord_groups VALUES ($pmid, $gid)";
					$res_coord = $db->query($sql);
				}
				$sql = "UPDATE members SET status=$s WHERE member_id=$mid";
				$res = $db->query($sql);
			}
		} else if ($_POST['group_change']) {
			// action: group change
			if ($_POST['m'.$mid]){
				$sql = "UPDATE mrel_groups SET group_id=$_POST[grp] WHERE member_id=$mid";
				$res = $db->query($sql);
			}
			
		} else if ($_POST['enroll']) {
			// action: enroll to course
			if ($_POST['m'.$mid]){
				$course_id = $_POST['crs'];
				$old_mid = $member_id;
				$member_id = $mid;
				require("enroll.php");
				$member_id = $old_mid;
			}
						
		} else if ($_POST['delete']) {
			// action: delete users
			if ($_POST['m'.$mid]){
				$sql = "SELECT * FROM members WHERE member_id=$mid";
				$res = $db->query($sql);
				$row_d =$res->fetchRow(DB_FETCHMODE_ASSOC);
				$sql = "INSERT INTO del_members VALUES ($row_d[MEMBER_ID], '$row_d[LOGIN]', '$row_d[PASSWORD]', '$row_d[EMAIL]', $row_d[STATUS], '$row_d[PREFERENCES]', '$row_d[CREATION_DATE]', '$row_d[MODIF_DATE]', '$row_d[CUSTOM1]', '$row_d[CUSTOM2]', '$row_d[CUSTOM3]', '$row_d[CUSTOM4]', '$row_d[CUSTOM5]', '$row_d[CUSTOM6]', '$row_d[CUSTOM7]', '$row_d[CUSTOM8]', '$row_d[CUSTOM9]', '$row_d[CUSTOM10]')";
				$res = $db->query($sql);
				
				$sql = "DELETE FROM members WHERE member_id=$mid";
				$res = $db->query($sql);
				
			}
		} else if ($_POST['mark']) {
			// action: mark course as complete
			if ($_POST['m'.$mid]) {
				$sql = "SELECT COUNT(member_id) FROM mcourse_completion WHERE member_id=$mid AND course_id=$_POST[crs_c]";
				$res = $db->query($sql);
				$row_m =$res->fetchRow();
				$sql = "SELECT * FROM course_enrollment WHERE member_id=$mid AND course_id=$_POST[crs_c]";
				$res = $db->query($sql);
				$row_e = $res->fetchRow(DB_FETCHMODE_ASSOC);
				if ($row_e['MEMBER_ID'] == 0) {
					$errors[] = AT_ERROR_NOT_ENROLLED;
				} else {
					/*if ($row_m[0] == 0) {
						// TBC: update also the grades
						$sql = "INSERT INTO mcourse_completion VALUES ($mid, $_POST[crs_c], 'yes', 0, 0, SYSDATE)";
						$res = $db->query($sql);
					} else {
						// UPDATE the existing values
						$sql = "UPDATE mcourse_completion SET completed='yes' WHERE member_id=$mid AND course_id=$_POST[crs_c]";
						$res = $db->query($sql);
					}*/
					
					$sql = "DELETE FROM course_enrollment WHERE member_id=$mid AND course_id=$_POST[crs_c]";
					$res = $db->query($sql);
					
					$sql	= "SELECT first_name,last_name FROM members_pers WHERE member_id=$mid";
					$result3	= $db->query($sql);
					$row3	= $result3->fetchRow(DB_FETCHMODE_ASSOC);
					$knume=$row3['LAST_NAME'];
					$kprenume=$row3['FIRST_NAME'];	
					
					$sql	= "SELECT title FROM courses WHERE course_id=$_POST[crs_c]";
					$res	= $db->query($sql);
					$row 	= $res->fetchRow();
					$ctitle = $row[0];
					
					$sql="SELECT test_id,title FROM tests WHERE course_id=$_POST[crs_c]";//." AND title='Test Final'"//;
					$countsql = "SELECT COUNT(test_id) FROM (".$sql.")";
					$countres = $db->query($countsql);
					$countrow = $countres->fetchRow();
					$total_tests = $countrow[0];
					
					if ($total_tests >0) {
						$res = $db->query($sql);
						while ($row = $res->fetchRow()){
							if (strtoupper($row[1])=='TEST FINAL') {
								$sql_tests_final = $row[0];
							}else {
								$sql_tests[] = $row[0];
							}
						}
					} else {
						$sql_tests_final = 0;
						$sql_tests[] = "";
					}
					
					foreach ($sql_tests as $k => $test_id) {
						$sql = "SELECT MAX(final_score) FROM tests_results WHERE member_id=$mid AND test_id=$test_id";
						//echo "<br>===>".$sql;
						$res = $db->query($sql);
						$row = $res->fetchRow();
						$total_inter_grade += $row[0];
						//echo $row[0];
					}
					$total_inter_grade=($total_inter_grade/($total_tests-1))*0.4;//(-Final exam)
					//echo "<br>Inter Tests : ".$total_inter_grade;
					
					//calc final exam *0.6
					$sql = "SELECT MAX(final_score) FROM tests_results WHERE member_id=$mid AND test_id=$sql_tests_final";
							//echo "<br>===>".$sql;
							$res = $db->query($sql);
							$row = $res->fetchRow();
							$total_final_grade = $row[0]*0.6;
								
					
					//echo "<br>Final Exam : ".$total_final_grade;
					
					$final_score=round($total_inter_grade+$total_final_grade);
					
					$sql = "SELECT min_grade FROM skills WHERE course_id=$_POST[crs_c]";
					$res = $db->query($sql);
					$row = $res->fetchRow($res);
					$min_grade = $row[0]; 
					if ($min_grade == '') $min_grade = 0;
					// we should use instead: max_grade = sum (tests weights)
					//$final_score=$final_grade/$total_tests;
					//echo "<br>".$sql;
					// This sql should be changed and max_grade inserted instead of min_grade.
					$sql = "INSERT INTO mcourse_completion VALUES ($mid, $_POST[crs_c], 'yes', $final_score, $min_grade, SYSDATE)"; 
					$res = $db->query($sql);
					
					$subject = "$knume $kprenume, Nota finala : ".$final_score.". Curs -".$ctitle.'.';
					
					if ($final_score >= 70 )	{
						$message = "<br>
							Felicitari, ai absolvit cursul de ".$ctitle." cu un procent de ".$final_score."
							raspunsuri corecte!
							<p>Acum esti gata sa aplici cunostintele dobandite. Poti oricand sa revii asupra
							  informatiilor din curs folosind documentatia tiparita sau salvata in format
							  .pdf.</p>
							<p>Iti multumim pentru participare si bafta la urmatoarele cursuri!</p>
							 <p>
							  <b>Acesta este un mesaj informativ. Te rugam nu raspunde la acest mail!</b>
							  </p>
							";
					} else {
						$message = "<p>Regretam, dar procentul de ".$final_score."% raspunsuri corecte din minimum
						de 70%, nu iti asigura promovarea cursului.</p>
						<p>Pentru detalii suplimentare, te rugam sa iei legatura cu DCM-ul tau!</p>
						 <p>
						 <b>Acesta este un mesaj informativ. Te rugam nu raspunde la acest mail!</b>
						 </p>";
					}
					//$fromname = 'K-Lore Learning Management System';
					$fromemail = 'name@mail.com';
					
					$sql = "SELECT email FROM members WHERE member_id=$mid";
					$res_tr = $db->query($sql);
					$row_tr = $res_tr->fetchRow(DB_FETCHMODE_ASSOC);
					
					klore_mail($row_tr['EMAIL'], 
							$subject, 
							$message, 
							'<'.$fromemail.'>');
				}
			}
		}
		
	}
	if (!$errors) $feedback[] = AT_FEEDBACK_SUCCESS;
}

require($_include_path.'cc_html/header.inc.php');
?>
<script language="JavaScript">
function change_categ() {
	// allows refreshing the userlist according to the selected category
	document.form_report.form_categ_change.value = "1";
	document.form_report.submit();
}

function change_group() {
	// allows refreshing the user list according to the selected group
	document.form_report.form_group_change.value = "1";
	document.form_report.submit();
}

function change_dyn() {
	// allows refreshing the user list according to the selected group
	document.form_report.form_dyn_change.value = "1";
	document.form_report.submit();
}

function UpdateGroup() {
	document.location = "../include/dynupdate.php?group=<?php echo $dyn_grp; ?>";
}

function DeleteGroup() {
	document.location = "del_usergroup.php?group=<?php echo $group; ?>";
}

function CheckAll()
{
  with (document.form_report) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox')
           elements[i].checked = true;
    }
  }
}

function UncheckAll()
{
  with (document.form_report) {
    for (var i=0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox')
           elements[i].checked = false;
    }
  }
}

function confirmDel() {
	alert("<?php echo $_warning[AT_WARNING_DELETE_USER]; ?>");
}
</script>
<?php

echo '<h1 class="left">'.$_template['user_management'].'</h1><br>';

// Showing groups and members

echo '<br><form id="report" method="post" action="'.$PHP_SELF.'" name="form_report">';
echo '<input type="hidden" name="amid" value="'.$_GET['amid'].'">';
	
		$sqllic = "SELECT COUNT(member_id) AS no FROM members";
		$reslic = $db->query($sqllic);
		$rowlic = $reslic->fetchRow(DB_FETCHMODE_ASSOC);
		$no_members = $rowlic['NO'];
		$no_licenses = 1800 - $no_members;
		
		echo '<table  cellspacing="1" cellpadding="0" border="0" width="85%" summary="" align="center">';
		echo '<tr><td align="right">';
		echo $_template['number_of_licenses'].': '.$no_licenses;
		echo '</td></tr>';
		
	?>	
	<table cellspacing="1" cellpadding="0" class="framework" width="95%" summary="">
	<tr>
		<td class="rowa1" width="150"><b><?php  echo $_template['existing_users'];  ?>:</b></td>
		<td class="rowa1" width="200">
	<?php
	echo '<b>'.$_template['category'].'</b>';
	// check for coordinator / group manager privileges:
	if ($_SESSION['status'] == STATUS_GROUP_MANAGER) {
		$sql = "SELECT G.group_id, C.category, C.name FROM mrel_groups G INNER JOIN member_groups C ON G.group_id=C.group_id WHERE G.member_id=$_SESSION[member_id]";
		$res = $db->query($sql);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$category = $row['CATEGORY'];
		$group = $row['GROUP_ID'];
		$group_name = $row['NAME'];
		$fixed_categ = true;
		$fixed_group = true;
	}
	
	
	if ($_SESSION['status'] == STATUS_COORDINATOR) {
		$sql = "SELECT DISTINCT G.category FROM member_groups G INNER JOIN coord_groups C ON G.group_id=C.group_id WHERE C.member_id=$_SESSION[member_id]";
		$res = $db->query($sql);
		echo "\n".'&nbsp;<label for="category"></label><span style="white-space: nowrap;"><select name="category" onChange="change_categ();" class="dropdown" id="category" title="Category">'."\n";
		while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)){ 
			echo '<option value="'.$row['CATEGORY'].'"';
			if ($category == '') {
				$category = $row['CATEGORY'];
				echo 'selected="selected">'.$row['CATEGORY'];
			} else if ($category == $row['CATEGORY']) {
				echo 'selected="selected">'.$row['CATEGORY'];
			} else {
				echo '>'.$row['CATEGORY'];
			}
			echo '</option>'."\n";	
		}
		echo '</select>&nbsp;'."\n";
	} else {
	
		if (!$fixed_categ) {
			$sql = "SELECT name FROM member_categ";
			$res = $db->query($sql);
			
			echo "\n".'&nbsp;<label for="category"></label><span style="white-space: nowrap;"><select name="category" onChange="change_categ();" class="dropdown" id="category" title="Category">'."\n";
			if ($dyngrp) {
				echo '<option value=""></option>';
			}
			while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
				echo '<option value="'.$row['NAME'].'"';
				if ($category == '') {
					$category = $row['NAME'];
					if (!$dyngrp) {
						echo 'selected="selected">'.$row['NAME'];
					} else {
						echo '>'.$row['NAME'];
					}
				} else if ($category == $row['NAME']) {
					if (!$dyngrp){
						echo 'selected="selected">'.$row['NAME'];
					} else {
						echo '>'.$row['NAME'];
					}
				} else {
					echo '>'.$row['NAME'];
				}
				echo '</option>'."\n";
			}
			echo '</select>&nbsp;'."\n";
		} else {
			echo ": ".$category."&nbsp;";
		}
	}
	
	?>
	</td>
	<td class="rowa1" width="300">
	<?php 
	echo '<b>'.$_template['group'].'</b>';
	
	if (!$fixed_group) {
		if ($_SESSION['status'] == STATUS_COORDINATOR) {
			$sql	= "SELECT G.* FROM member_groups G INNER JOIN coord_groups C ON G.group_id=C.group_id WHERE G.category='$category' AND C.member_id=$_SESSION[member_id]";
		} else {
			$sql	= "SELECT * FROM member_groups WHERE category='$category'";
		}

		$res	= $db->query($sql);
		echo "\n".'&nbsp;<label for="group"></label><span style="white-space: nowrap;"><select name="group" onChange="change_group();" class="dropdown" id="group" title="Group">'."\n";
		if ($dyngrp) {
			echo '<option value="" selected="selected"></option>';
		}
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			echo '<option value="'.$row['GROUP_ID'].'"';
			if ($group == '') {
				$group = $row['GROUP_ID'];
				$group_name = $row['NAME'];
				if (!$dyngrp) {
					echo 'selected="selected">'.$row['NAME'];
				} else {
					echo '>'.$row['NAME'];
				}
			} else if ($group == $row['GROUP_ID']) {
				if (!$dyngrp) {
					echo 'selected="selected">'.$row['NAME'];
				} else {
					echo '>'.$row['NAME'];
					$group_name = $row['NAME'];
				}
			} else {
				echo '>'.$row['NAME'];
			}
			echo '</option>'."\n";
		}
		echo '</select>&nbsp;'."\n";
	} else {
		echo ": ".$group_name.'&nbsp;';
	}
	echo '<input type="hidden" name="group_id" value="'.$group.'">';
	$group_id = $group;
	?>
	</td>
	<td class="rowa1" width="300">
	<?php 

	$dyn_name = false;
	if (($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
		// dyn groups:
		if ($dyngrp) {
			$first_erow = false;	
			$dyn_name = $dyngrp;
		} else {
			$first_erow = true;
		}
		echo '<b>'.$_template['dynamic_group'].':</b>&nbsp;&nbsp;&nbsp;';
		$sql = "SELECT DISTINCT name FROM dyn_groups";	
		$res = $db->query($sql);

		echo "\n".'&nbsp;<label for="dyngroup"></label><span style="white-space: nowrap;"><select name="dyngrp" onChange="change_dyn();" class="dropdown" id="dyn" title="Dynamic Group">'."\n";
		if ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			if ($first_erow) echo '<option value=""></option>';
			do {
				echo '<option value="'.$row['NAME'].'"';
				if ($dyn_name == $row['NAME']) {
					echo 'selected="selected">'.$row['NAME'];
				} else {
					echo '>'.$row['NAME'];
				}
				echo '</option>'."\n";
			} while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC));
		} else {
			echo '<option value="">'.$_template['none_defined'].'</option>';
		}
		echo '</select>&nbsp;'."\n";
	}
	
	?>
	</td>
	
	</tr>
	</table>
	<table>
	<tr><td>
	<?php
	if (!$dyngrp){
		if ($group_id=='') $group_id = 0;
		$sql = "SELECT member_id, role FROM group_mng WHERE group_id=$group_id";
		$res = $db->query($sql);
		$coordinator = 'None';
		$group_manager = 'None';
		$row =$res->fetchRow(DB_FETCHMODE_ASSOC);
		if ($row['ROLE'] == 'gmng') {
			$gmng_id = $row['MEMBER_ID'];
			$sql = "SELECT M.login, N.first_name, N.last_name FROM members M INNER JOIN members_pers N ON M.member_id=N.member_id WHERE M.member_id=$gmng_id";
			$resc = $db->query($sql);
			$rowc =$resc->fetchRow(DB_FETCHMODE_ASSOC);
			$group_manager = $rowc['FIRST_NAME'].' '.$rowc['LAST_NAME'].' ('.$rowc['LOGIN'].')';
		} 
		//$sql = "SELECT K.login, N.first_name, N.last_name FROM (SELECT M.login, M.member_id FROM members M INNER JOIN coord_groups C ON C.member_id=M.member_id WHERE C.group_id=$group_id) K, members_pers N WHERE N.member_id=K.member_id";
		$sql = "SELECT M.login, N.first_name, N.last_name FROM members_pers N, members M INNER JOIN coord_groups C ON C.member_id=M.member_id WHERE C.group_id=$group_id AND N.member_id=M.member_id";
		$res = $db->query($sql);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		$coordinator = $row['FIRST_NAME'].' '.$row['LAST_NAME'].' ('.$row['LOGIN'].')';
		
		echo '<b>'.$_template['coordinator'].': </b>'.$coordinator;
		echo '<br><b>'.$_template['group_manager'].': </b>'.$group_manager;
	} else {
		echo '<b>'.$_template['dynamic_group'].'</b>';
	}
	?>
	</td></tr>
	</table>
	<br>
	
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
		<tr>
			<th scope="col" width="150"><?php  echo $_template['user_login'];  ?></th>
			<th scope="col" width="100"><?php  echo $_template['policy'];  ?></th>
			<th scope="col" width="150"><?php  echo $_template['enrolled_to'];  ?></th>
			<th scope="col" width="300"><?php  echo $_template['skills'].'<br>(<font color="#AA5555">'.$_template['course_not_passed'].'</font> / <font color="#008000">'.$_template['course_passed'].'</font>)';  ?></th>
			<th scope="col" width="100"><?php  echo $_template['p_start_date'];  ?></th>
			<th scope="col" colspan="2" align="right"></th>
		</tr>
		
<?php
	//echo '<tr><td colspan="5" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	$member_count = 0;
	$sql 	= "SELECT * FROM policy";
	$result = $db->query($sql);
	$policy = "";
	while ($row=$result->fetchRow(DB_FETCHMODE_ASSOC)){
		$policy[$row['ID']] = $row['NAME'];
	}
	
	if ($dyngrp) {
		$sql	= "SELECT M.member_id, M.login, M.status, P.first_name, P.last_name, G.*, R.* 
			FROM members M, dyn_groups G, mdyn_groups R, members_pers P 
			WHERE M.member_id=R.member_id AND G.name='$dyn_name' AND R.group_id=G.id AND P.member_id=M.member_id ORDER BY M.login";
	} else {
		$sql = "SELECT * FROM 
			(SELECT M.member_id, M.login, M.status, P.first_name, P.last_name FROM members M INNER JOIN members_pers P ON M.member_id=P.member_id)
			K INNER JOIN 
			(SELECT * FROM member_groups G INNER JOIN mrel_groups R ON G.group_id=R.group_id WHERE G.group_id=$group_id) 
			L ON K.member_id=L.member_id ORDER BY first_name";
		// echo $sql;

		//$sql	= "SELECT M.member_id, M.login, P.first_name, P.last_name, G.*, R.* FROM members M, member_groups G, mrel_groups R, members_pers P WHERE M.member_id=R.member_id AND G.group_id=$group_id AND R.group_id=$group_id AND P.member_id=M.member_id ORDER BY M.login";
	}
	$res	= $db->query($sql);
	$member_count = 0;
	$alternate = 1;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$group_id = $row_id['GROUP_ID'];
		$mid = $row['MEMBER_ID'];
		$member_count++;
		echo '<tr><td class="rowa'.$alternate.'" width="25%" valign="top">';
		echo '<input type="checkbox" name="m'.$row['MEMBER_ID'].'">';
		echo '<small>';
		echo $row['FIRST_NAME'].' '.$row['LAST_NAME'];
		echo ' ('.$row['LOGIN'].')';
		echo '</small></td>';
		
		echo '<td class="rowa'.$alternate.'" valign="top">'.$policy[$row['STATUS']+1].'</td>';
		
		echo '<td class="rowa'.$alternate.'" width="30%" valign="top">';
		$sql = "SELECT E.member_id, C.title FROM course_enrollment E, courses C WHERE E.course_id=C.course_id AND E.member_id=$mid";
		$res_e = $db->query($sql);
		while( $row_e =$res_e->fetchRow(DB_FETCHMODE_ASSOC) ) {
			echo '&middot;&nbsp;'.$row_e['TITLE'].'<br>';
		}
		echo '</td>';
		
		echo '<td class="rowa'.$alternate.'" width="30%" align="left" valign="top">';
		$sql = "SELECT L.*, C.title FROM mcourse_completion L INNER JOIN courses C ON L.course_id=C.course_id WHERE L.member_id=$mid ORDER BY C.title";
		$res_s = $db->query($sql);
		$last_ctitle = '';
		while( $row_s =$res_s->fetchRow(DB_FETCHMODE_ASSOC) ) {
			if ($row_s['COMPLETED'] == 'yes') {
				if ($last_ctitle == $row_s['TITLE']) {
					// don't show. It it only another try on the same course.
				} else {
					echo '&middot;&nbsp;'.$row_s['TITLE'].'<br>';
					$sql = "SELECT M.grade FROM mcourse_completion M WHERE M.course_id=$row_s[COURSE_ID] AND M.member_id=$mid";
					$res_r = $db->query($sql);
					$count_r = 0;
					while ($row_r = $res_r->fetchRow()) {
						if ($count_r >0) {
							echo ', ';
						}
						$final_score = intval($row_r[0]);
						if ($final_score >69) {
							$f = "<font color='#008000'>";
						} else {
							$f = "<font color='#AA5555'>";					
						}
						echo $f.$final_score.'</font>';
						$count_r++;
					}
				}
				$last_ctitle = $row_s['TITLE'];
				echo '<br>';
			}
		}
		echo '</small></td>';
		
		
		//pass start date 
		echo '<td class="rowa'.$alternate.'" width="10%" align="left" valign="top">';
		$sql = "SELECT modif_date FROM members WHERE member_id=$mid";
		$res_s = $db->query($sql);
		$row_s =$res_s->fetchRow(DB_FETCHMODE_ASSOC) ;
			
		echo '&nbsp;'.$row_s['MODIF_DATE'].'<br>';
	

		echo '</td>';
		
		
		
		$sql="SELECT status, modif_date FROM members WHERE member_id=".$mid;
		$res_ul=$db->query($sql);
		$rowl=$res_ul->fetchRow(DB_FETCHMODE_ASSOC);
		
		$modif_time=strtotime($rowl['MODIF_DATE']);
		$usr_status=intval($rowl['STATUS'])+1;
		
		$sql="SELECT pass_expiry FROM mpass WHERE status=".$usr_status;
		$res_ul=$db->query($sql);
		$rowl=$res_ul->fetchRow(DB_FETCHMODE_ASSOC);
		
		$pass_expiry=intval($rowl['PASS_EXPIRY']);
	
		$expiry_time=strtotime("-".$pass_expiry." days");
		
		  
		/*	
		//debug
			echo '<br>Satus='.$usr_status;
			echo '<br>PassExp='.$row['PASS_EXPIRY'];
			echo '<br>NOW='.date('d-m-Y H:i:s ',time());
			echo '<br>MODIF='.date('d-m-Y H:i:s ',$modif_time);
			echo '<br>DELTA='.date('d-m-Y H:i:s ',$expiry_time).'<br>';
		*/ 
			
		
		if ($modif_time<$expiry_time) 
				{
				$ech_str='<a href="users/usermng.php?group='.$group.'&unlock='.$mid.'"><img alt="'.$_template['unlock'].'" border="0" src="images/menu/unlock_account.gif"</a>';
				//$usr_col='#f30000';
				}
		 else 
		 		{	 
		 		$ech_str='<a href="users/usermng.php?group='.$group.'&lock='.$mid.'"><img border="0" alt="'.$_template['lock'].'" src="images/menu/lock_account.gif"></a>';
		 		//$usr_col='#000000';
		 		}
		// modif ^ 	
		
		echo '<td class="rowa'.$alternate.'" align="right" width="10%" valign="top">';
		$usr_status--;
		if (($usr_status == STATUS_COORDINATOR) && ($_SESSION['is_admin'] || $_SESSION['c_instructor'])) {
			// this is a coordinator: enable group assignment
			echo '<a href="users/coord.php?mid='.$mid.'&group='.$group.'"><img alt="'.$_template['manage'].'" src="images/menu/admin_group.gif" border="0"></a>';
		}
		if (($usr_status == STATUS_GROUPMNG) && ($_SESSION['is_admin'] || $_SESSION['c_instructor'])) {
			// this is a coordinator: enable group assignment
			echo '<a href="users/gmng.php?mid='.$mid.'&group='.$group.'"><img alt="'.$_template['manage'].'" src="images/menu/admin_group.gif" border="0"></a>';
		}
		
		echo '&nbsp;&nbsp;'.$ech_str;//modif (added)
		echo '<a href="users/member_rep.php?group='.$group.'&show_profile=1&member='.$row['LOGIN'].'"><img alt="'.$_template['report'].'" border="0" src="images/menu/user_profile.gif"</a>';
		echo '<a href="users/remove_user.php?group='.$group.'&mid='.$row['MEMBER_ID'].'"><img alt="'.$_template['remove'].'" border="0" src="images/menu/delete.gif"></a>';
		echo '</td>';
		echo '</tr>';
		$alternate++;
		if ($alternate>2) $alternate = 1;
	}
	echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
	if ($member_count == 0) {
		echo '<tr><td class="row1" colspan="5"><i>'.$_template['no_users'].'</i>';
		if (isset($dyngrp)){
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" onClick="UpdateGroup();" value="'.$_template['update_group'].'">';
		}
		echo '</td>';
		echo '</td><td class="row1" align="right">';
		echo '<input type="button" class="button" onClick="DeleteGroup();" value="'.$_template['delete_group'].'">';
		echo '</td></tr>';
	} else {
		echo '<tr><td class="row1" colspan="4">';
		echo '<input type="button" class="button2" onClick="CheckAll();" value="'.$_template['select_all_simple'].'">&nbsp;';
		echo '<input type="button" class="button2" onClick="UncheckAll();" value="'.$_template['unselect_all'].'">';
		if ($dyngrp <> ''){
			echo '<input type="button" class="button" onClick="UpdateGroup();" value="'.$_template['update_group'].'">';
		}
		echo '</td><td class="row1" align="right">';
		if ($_SESSION['is_admin'] || $_SESSION['c_instructor']) {
			echo '<input type="button" class="button" onClick="DeleteGroup();" value="'.$_template['delete_group'].'">';
		}
		echo '</td></tr>';
	}
	
	echo '</table>';
	
	echo '<br />';
	
	echo '<table cellspacing="1" cellpadding="0" border="0" width="90%" summary="" align="center">';
	echo '<tr><td>';
	
	$sql = "SELECT * FROM policy ORDER by name";
	$result = $db->query($sql);
	
	echo '<table cellspacing="1" cellpadding="3" border="0" class="framework" width="350" summary="">';
	echo '<tr><th colspan="3">';
	echo '<h3>'.$_template['with_selected'].':</h3>';
	echo '</th></tr>';
	
	/* POLICY */
	if ($_SESSION['c_instructor'] || $_SESSION['is_admin']) {
		echo '<tr><td width="100" class="rowa1">';
		echo $_template['assign_policy'].': </td><td class="rowa1">';
		echo '<select name="pol"'.$tip_jump.' class="dropdown" id="pol" title="Jump: '.$_template['accesskey'].' ALT-d">'."\n";
		while ($row=$result	->fetchRow(DB_FETCHMODE_ASSOC)) {
			$allow = true;
			if (($_SESSION['status'] == STATUS_INSTRUCTOR) || ($_SESSION['status'] == STATUS_TMNG)) {
				if ($row['NAME'] == 'Administrator') {
					$allow = false;
				}
			} 
			if ($_SESSION['status'] == STATUS_TRAINER) {
				if ($row['NAME'] == 'Training Manager') {
					$allow = false;
				}
			}
			if ($allow) {
				echo '<option value="'.$row['ID'].'">'.$row['NAME'].'</option>';
			}
		}
		echo '</select></td>';
		echo '<td class="rowa1" align="right"><input type="submit" name="policy" value=" '.$_template['apply'].'  " class="button2" />';
		echo '</td></tr>';
		//echo '<tr><td colspan="1" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	}
	
	/* GROUP CHANGE */
	if (!$_SESSION['group_mng']) {
		echo '<tr><td class="rowa1" width="100">';
		echo $_template['change_group'].': </td><td class="rowa1">';
		if ($_SESSION['status'] == STATUS_COORDINATOR) {
			$sql = "SELECT G.group_id, G.name FROM member_groups G INNER JOIN coord_groups C ON G.group_id=C.group_id WHERE G.category='$category' AND C.member_id=$_SESSION[member_id]";
		} else {
			$sql = "SELECT * FROM member_groups WHERE category='$category'";
		}
		$result = $db->query($sql);
		echo '<select name="grp" class="dropdown" id="grp" title="'.$_template['change_group'].'">\n';
		while ($row=$result->fetchRow(DB_FETCHMODE_ASSOC)){
			echo '<option value="'.$row['GROUP_ID'].'">'.$row['NAME'].'</option>';
		}
		echo '</select>';
		echo '</td><td class="rowa1" align="right"><input type="submit" name="group_change" value="'.$_template['change'].'" class="button2" />';
		echo '</td></tr>';
		
		//echo '<tr><td colspan="1" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	}
	
	
	/* ENROLLMENT */
	echo '<tr><td class="rowa1" width="100">';
	echo $_template['enroll'].': ';
	echo '</td><td class="rowa1">';
	if ($_SESSION['status'] == STATUS_COORDINATOR) {
		$sql = "SELECT C.course_id, C.title FROM courses C INNER JOIN coord_courses K ON C.course_id=K.course_id WHERE K.member_id=$_SESSION[member_id] ORDER BY C.title";
	} else if ($_SESSION['status'] == STATUS_GROUPMNG) {
		$sql = "SELECT C.course_id, C.title FROM courses C INNER JOIN gmng_courses K ON C.course_id=K.course_id WHERE K.member_id=$_SESSION[member_id] ORDER BY C.title";
	} else {
		$sql = "SELECT course_id, title FROM courses ORDER BY title";
	}
	$result = $db->query($sql);
	echo '<select name="crs" class="dropdown" id="crs" title="'.$_template['enroll_to'].'">\n';
	while ($row=$result->fetchRow(DB_FETCHMODE_ASSOC)){
		echo '<option value="'.$row['COURSE_ID'].'">'.$row['TITLE'].'</option>';
	}
	echo '</select>';
	echo '</td><td class="rowa1" align="right"><input type="submit" name="enroll" value=" '.$_template['enroll'].'  " class="button2" />';
	//echo '<tr><td colspan="1" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	
	
	/* COURSE COMPLETION */
	if ($_SESSION['c_instructor'] || $_SESSION['is_admin']) {
		echo '<tr><td class="rowa1" width="100">';
		echo $_template['mark_complete'].': ';
		echo '</td><td class="rowa1">';
		if ($_SESSION['status'] == STATUS_COORDINATOR) {
			$sql = "SELECT C.course_id, C.title FROM courses C INNER JOIN coord_courses K ON C.course_id=K.course_id WHERE K.member_id=$_SESSION[member_id] ORDER BY C.title";
		} else if ($_SESSION['status'] == STATUS_GROUPMNG) {
			$sql = "SELECT C.course_id, C.title FROM courses C INNER JOIN gmng_courses K ON C.course_id=K.course_id WHERE K.member_id=$_SESSION[member_id] ORDER BY C.title";
		} else {
			$sql = "SELECT course_id, title FROM courses ORDER BY title";
		}
		$result = $db->query($sql);
		echo '<select name="crs_c" class="dropdown" id="crs_c" title="'.$_template['mark_complete'].'">\n';
		while ($row=$result->fetchRow(DB_FETCHMODE_ASSOC)){
			echo '<option value="'.$row['COURSE_ID'].'">'.$row['TITLE'].'</option>';
		}
		echo '</select>';
		echo '</td><td class="rowa1" align="right"><input type="submit" name="mark" value="  '.$_template['mark_as_complete'].'  " class="button2" />';
		
		echo '</td></tr>';
		//echo '<tr><td colspan="1" class="row3" height="1"><img src="images/clr.gif" height="1" width="1" alt="" /></td></tr>';
	}
	
	echo '<tr><td class="rowa1" colspan="2" align="left" valign="middle">';
	echo '<input type="submit" name="delete" value="'.$_template['delete_selected_users'].'" class="button2" />&nbsp;</td><td class="rowa1">&nbsp;';
	echo '</td></tr></table>';
	echo '<input type="hidden" name="form_group_change">';
	echo '<input type="hidden" name="form_categ_change">';
	echo '<input type="hidden" name="form_dyn_change">';
	
	// ACTIONS: 
	
	echo '</td><td valign="top">';
	echo '<table cellspacing="0" cellpadding="0" border="0" class="framework" width="350" summary="">';
	/*echo '<tr><th colspan="2">';
	echo '<h3>'.$_template['actions'].':</h3>';
	echo '</th></tr>';*/
	
	if ($_SESSION['c_instructor'] || $_SESSION['is_admin']) {
		echo '<tr><td class="rowa1" colspan="2" valign="top" align="center">';
		echo '<a class="framewk" href="'.$PHP_SELF.'?csv=1&group='.$group.'"><img src="images/menu/user2excel.gif" border="0"><br>'.$_template['export_users'].'</a><br><br>';
		echo '</td><td class="rowa1" colspan="2" valign="top" align="center">';
		echo '<a class="framewk" href="users/import_usr.php"><img src="images/menu/excel2user.gif" border="0"><br>'.$_template['import_users'].'</a><br><br>';
		echo '</td></tr>';
		echo '<tr><td class="rowa1" colspan="4">';
		echo $_template['create_group'].': <input type="text" size="20" name="grp_name">&nbsp;<input type="submit" class="button2" value="'.$_template['create'].'"name="c_group" id="c_group"><br><br>';
		echo '</td></tr>';
	}
	echo '<tr>';
	if ($_SESSION['c_instructor'] || $_SESSION['is_admin']) {
		echo '<td class="rowa1" align="center"><a class="framewk" href="dyngroup/index.php" class="breadcrumbs"><img border="0" src="images/menu/dyn_group.gif"><br>'.$_template['dynamic_group'].'</a></td>';
	}		
	
	echo '<td class="rowa1" align="center"><a class="framewk" href=users/adduser.php?categ='.$category.'&grp='.$group.' class="breadcrumbs"><img border="0" src="images/menu/add_user.gif"><br>'.$_template['add_user'].'</a></td>';
	if ($_SESSION['c_instructor'] || $_SESSION['is_admin']) {
		echo '<td class="rowa1" align="center"><a class="framewk" href=users/userattr.php?grp='.$group.' class="breadcrumbs"><img border="0" src="images/menu/reg_fields.gif"><br>'.$_template['define_regfields'].'</a></td>';
		echo '<td class="rowa1" align="center"><a class="framewk" href=users/password_policy.php?grp='.$group.' class="breadcrumbs"><img border="0" src="images/menu/passwd_policy.gif"><br>'.$_template['password_policy'].'</a></td>';
	}
	echo '</tr>';
	
	echo '</table></td></tr></table>';
	echo '</form>';
	
	echo '<br><br><br><br>';
	if ($_SESSION['is_super_admin']) {
			echo '<h4>'.$_template['deleted_users'].'</h4>';
			$alternate = 1;
		?>
		<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
			<tr>
				<th scope="col" width="150"><?php  echo $_template['user_name'];  ?></th>
				<th scope="col" width="150"><?php  echo $_template['group'];  ?></th>
				<th scope="col" width="150"><?php  echo $_template['policy'];  ?></th>
				<th scope="col" width="150"><?php  //echo $_template['policy'];  ?></th>
				<th scope="col" colspan="2" align="right"></th>
			</tr>
	
		<?php
		$sql	= "SELECT * FROM del_members ORDER BY login";
		$res	= $db->query($sql);
		$member_count = 0;
		while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
			$mid = $row['MEMBER_ID'];
			$sql 	= "SELECT group_id FROM mrel_groups WHERE member_id=$mid";
			
			$res1	= $db->query($sql);
			$row_g	=$res1->fetchRow(DB_FETCHMODE_ASSOC);
			$sql 	= "SELECT name FROM member_groups WHERE group_id='$row_g[GROUP_ID]'";
			
			$res2	= $db->query($sql);
			$row2	=$res2->fetchRow(DB_FETCHMODE_ASSOC);
			$member_count++;
			echo '<tr><td class="rowa'.$alternate.'" width="15%" valign="top">';
			echo '<input type="checkbox" name="md'.$row['MEMBER_ID'].'">';
			echo '<small>';
			echo $row['LOGIN'];
			echo '</small></td>';
			echo '<td class="rowa'.$alternate.'" width="15%" valign="top"><b>'.$row2['NAME'].'</b></td>';
			echo '<td class="rowa'.$alternate.'" width="15%" valign="top">'.$policy[$row['STATUS']+1].'</td>';
			
			echo '<td class="rowa'.$alternate.'" align="left" valign="top">';
			//echo '<a href="users/member_rep.php?member='.$row['LOGIN'].'">'.$_template['report'].'</a> ';//.$pipe;
			// echo ' <a href="users/enroll.php?mid='.$row['MEMBER_ID'].'">'.$_template['enroll'].'... </a>';
			echo '</small></td>';
			
			echo '<td class="rowa'.$alternate.'" align="right" valign="top">';
			echo '<a href="users/restore_user.php?group_id='.$group.'&mid='.$row['MEMBER_ID'].'">'.$_template['restore'].'</a>';
			echo '</td>';
			echo '</tr>';
			$alternate++;
			if ($alternate>2) $alternate=1;
		}
		echo '<tr><td height="1" class="row2" colspan="6"></td></tr>';
		if ($member_count == 0) {
			echo '<tr><td class="row1" colspan="6"><i>'.$_template['no_users'].'</i></td></tr>';
		} else {
			/*echo '<tr><td class="row1" colspan="6">';
			echo '<input type="button" class="button2" onClick="CheckAll();" value="'.$_template['select_all_simple'].'">&nbsp;';
			echo ' <input type="button" class="button2" onClick="UncheckAll();" value="'.$_template['unselect_all'].'">';
			echo '</td></tr>';*/
		}
		
		echo '</table>';
	}
	
	require ($_include_path.'cc_html/footer.inc.php');
?>
