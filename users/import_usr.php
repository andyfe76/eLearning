<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */


$section = 'users';
$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
require($_include_path.'classes/pclzip.lib.php');
require($_include_path.'lib/filemanager.inc.php');

//error_reporting(E_NOTICE | E_WARNNING | E_PARSE | E_ERROR );
if ($_POST['cancel']) {
	$_SESSION['done'] = 1;
	Header('Location: usermng.php?f='.AT_FEEDBACK_IMPORT_CANCELLED);
	exit;
}



function translate_whitespace($input) {
	$input = str_replace('\n', "\n", $input);
	$input = str_replace('\r', "\r", $input);
	$input = str_replace('\x00', "\0", $input);

	return $input;
}

/* to avoid timing out on large files */
set_time_limit(0);

$_SESSION['done'] = 1;

if ($_POST['submit']) {
	
	if (!$_SESSION['is_admin']) {
		require($_include_path.'cc_html/header.inc.php');
		$errors[]=AT_ERROR_ACCESS_DENIED;
		print_errors($errors);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
		
	} //*** ? admin or super_admin ?

	
	
	if (	$_FILES['file']['name'] 
		&&	is_uploaded_file($_FILES['file']['tmp_name']) 
		&& (
			(	$_FILES['file']['type'] == 'application/x-zip-compressed')
			|| ($_FILES['file']['type'] == 'application/zip')
			|| ($_FILES['file']['type'] == 'application/x-gzip-compressed')
			|| ($_FILES['file']['type'] == 'application/vnd.ms-excel')
			)
		)
		{
		
		if ($_FILES['file']['size'] > 0) {
			/* check if ../content/import/ exists */
			$import_path = '../content/import/';
			$content_path = '../content/';

			if (!is_dir($import_path)) {
				if (!@mkdir($import_path, 0700)) {
					$errors[] = AT_ERROR_IMPORTDIR_FAILED;
					print_errors($errors);
					exit;
				}
			}
			$course='allusers';
			$import_path = '../content/import/'.$course.'/';
			
						
			if (!is_dir($import_path)) {
				if (!mkdir($import_path, 0775)) {
					$errors[] = AT_ERROR_IMPORTDIR_FAILED;
					print_errors($errors);
					exit;
				}
			}
			if ($_FILES['file']['type'] == 'application/vnd.ms-excel') {
				/* for simple csv file 					*/
				/* copy the file in the directory	*/
				move_uploaded_file($_FILES['file']['tmp_name'], $import_path . $_FILES['file']['name']);
				
			
			}else if ($_FILES['file']['type'] == 'application/x-gzip-compressed') {
				/* for versions < 1.1				*/
				/* copy the file in the directory	*/
				move_uploaded_file($_FILES['file']['tmp_name'], $import_path . $_FILES['file']['name']);

				/* unzip and untar the archive */
				$exec	= 'cd '.$import_path.'; gunzip -dc '.escapeshellcmd($_FILES['file']['name']).' | tar -xf -';
				$result = system ( $exec );
			} else {
				/* for versions >= 1.1				*/
				$archive = new PclZip($_FILES['file']['tmp_name']);
				if ($archive->extract(	PCLZIP_OPT_PATH,	$import_path,
										PCLZIP_CB_PRE_EXTRACT,	'preImportCallBack') == 0) {
					dir ("Error : ".$archive->errorInfo(true));
				}
			}



			if (ALLOW_IMPORT_USERS) {
				$totalBytes = dirsize($import_path.'content/');
				$course_total = dirsize($content_path.$course.'/');
				$total_after = $MaxCourseSize-$course_total-$totalBytes;
				if ($total_after < 0) {
					/* remove the content dir, since there's no space for it */
					$errors[] = AT_ERROR_NO_CONTENT_SPACE;
					clr_dir($content_path.$course.'/');
					/*
					$exec	= 'cd '.$import_path.'; rm -r content/';
					$result = system ( $exec );
					*/
				} else {
					/* move the content to the correct course content directory */
					$exec	= 'cd '.$import_path.'; mv content/* ../../'.$course.'/';
					$result = system ( $exec );
					
				}
			}

			
			
			$fp = fopen($import_path.$_FILES['file']['name'],'r');
			
			

			$lock_sql = 'LOCK TABLE members IN SHARE ROW EXCLUSIVE MODE';
			$result   = $db->query($lock_sql);
			
			$lock_sql = 'LOCK TABLE mrel_groups IN SHARE ROW EXCLUSIVE MODE';
			$result   = $db->query($lock_sql);
			
			$lock_sql = 'LOCK TABLE members_pers IN SHARE ROW EXCLUSIVE MODE';
			$result   = $db->query($lock_sql);

			
			$sql = '';
			$index_offset = '';
			
			//$DEBUG=1;
			
			/// clear all existent users so there will be no duplicates if IDs change somehow
			
			
			$sql = "DELETE FROM members";				if ($DEBUG) echo "<br>".$sql;
			$res = $db->query($sql) ;
				if (PEAR::isError($res)) {
				echo '<BR><font color=red>DB Error ! </font>';
				}
				
				
			$sql = "DELETE FROM members_pers";			if ($DEBUG) echo "<br>".$sql;
			$res = $db->query($sql) ;
			
				if (PEAR::isError($res)) {
				echo '<BR><font color=red>DB Error ! </font>';
				}
				
				
			$sql = "DELETE FROM mrel_groups";			if ($DEBUG) echo "<br>".$sql;
			$res = $db->query($sql) ;
				if (PEAR::isError($res)) {
				echo '<BR><font color=red>DB Error ! </font>';
				}

			
while ($data = fgetcsv($fp, 10000000, ',')) {
			
				

		$indata = array();
		$indata ['MEMBER_ID']	= $data[0];
		$indata ['LOGIN']		= $data[1];
		$indata ['PASSWORD']	= $data[2];
		$indata ['EMAIL']		= $data[3];
		$indata ['STATUS']		= $data[4];
		$indata ['PREFERENCES']	= $data[5];
		
		$indata ['CUSTOM1']		= $data[6];
		$indata ['CUSTOM2']		= $data[7];
		$indata	['CUSTOM3']		= $data[8];
		$indata ['CUSTOM4']		= $data[9];
		$indata ['CUSTOM5']		= $data[10];
		$indata ['CUSTOM6']		= $data[11];
		$indata ['CUSTOM7']		= $data[12];
		$indata ['CUSTOM8']		= $data[13];
		$indata ['CUSTOM9']		= $data[14];
		$indata ['CUSTOM10']	= $data[15];
		$indata ['GID']			= $data[16];
		$indata ['FIRST_NAME']	= $data[17];
		$indata ['LAST_NAME']	= $data[18];
		
		
		//** To decide **//
		//**  ??? ===DELETE everythig FROM users and INSERT the new records===  OR ===UPDATE old ones and INSERT nonexistent recs=== ??? **//
		
		
		if ($DEBUG) echo "<br>===(-)===<br>"; 
		
		$sql	= "INSERT INTO mrel_groups VALUES ($indata[MEMBER_ID],0,$indata[GID])"; 							if ($DEBUG) echo "<br>".$sql;
		/*===-->*/ $res = $db->query($sql) ;
		if (PEAR::isError($res)) {
				echo '<BR><font color=red>DB Error ! </font>';
				}
		$sql	= "INSERT INTO members VALUES ($indata[MEMBER_ID],'$indata[LOGIN]','$indata[PASSWORD]','$indata[EMAIL]',$indata[STATUS],'$indata[PREFERENCES]',SYSDATE,SYSDATE,'$indata[CUSTOM1]','$indata[CUSTOM2]','$indata[CUSTOM3]','$indata[CUSTOM4]','$indata[CUSTOM5]','$indata[CUSTOM6]','$indata[CUSTOM7]','$indata[CUSTOM8]','$indata[CUSTOM9]','$indata[CUSTOM10]')";if ($DEBUG) echo "<br>".$sql;
		/*===-->*/ $res = $db->query($sql) ;
		if (PEAR::isError($res)) {
				echo '<BR><font color=red>DB Error ! </font>';
				}
		$sql	= "INSERT INTO members_pers VALUES ($indata[MEMBER_ID],'$indata[FIRST_NAME]','$indata[LAST_NAME]')";	if ($DEBUG) echo "<br>".$sql;
		/*===-->*/ $res = $db->query($sql) ;
		if (PEAR::isError($res)) {
				echo '<BR><font color=red>DB Error ! </font>';
				}
		
		//echo '<br><br><br>'.print_r($indata);	

	}
   header( 'Location: usermng.php?f='.AT_FEEDBACK_USERS_UPDATED);		
		} else {
			require($_include_path.'cc_html/header.inc.php');
			$errors[] = AT_ERROR_IMPORTFILE_EMPTY;
			print_errors($errors);
			require($_include_path.'cc_html/footer.inc.php');
			exit;
		}
	} else {
		require($_include_path.'cc_html/header.inc.php');
		$errors[] = AT_ERROR_FILE_NOT_SELECTED;
		print_errors($errors);
		require($_include_path.'cc_html/footer.inc.php');
		exit;
	}
}else {

require ($_include_path.'cc_html/header.inc.php'); 
?>


<form name="form1" method="post" action="users/import_usr.php" enctype="multipart/form-data" onsubmit="openWindow('<?php echo $_base_href; ?>tools/prog.php');">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />

<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="">
<tr>
	<td class="row1" colspan="2"><?php echo $_template['import_usr_about']; ?></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" colspan="2"><strong><?php echo $_template['import_users']; ?></strong>: <input type="file" name="file" class="formfield" /><br /><br /></td>
</tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr><td height="1" class="row2" colspan="2"></td></tr>
<tr>
	<td class="row1" align="center" colspan="2"><input type="submit" name="submit" value="<?php echo $_template['import']; ?>" class="button" /> - <input type="submit" name="cancel" value="<?php echo $_template['cancel']; ?>" class="button" /></td>
</table>
</form>


<?
}
require ($_include_path.'cc_html/footer.inc.php'); 
?>
