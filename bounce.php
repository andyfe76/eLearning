<?php

function count_login( ) {
	global $db;

	if ($_SESSION['is_guest']) {
	    $sql   = "INSERT INTO course_stats VALUES ($_SESSION[course_id], SYSDATE, 1, 0)";
	} else {
	   $sql    = "INSERT INTO course_stats VALUES ($_SESSION[course_id], SYSDATE, 0, 1)";
	}

    $result = @$db->query($sql);

    if (!$result) {
		/* that entry already exists, then update it. */
		if ($_SESSION['is_guest']) {
			$sql   = "UPDATE course_stats SET guests=guests+1 WHERE course_id=$_SESSION[course_id] AND login_date=SYSDATE";
		} else {
			$sql   = "UPDATE course_stats SET members=members+1 WHERE course_id=$_SESSION[course_id] AND login_date=SYSDATE";
		}
		$result = @$db->query($sql);
	}
}



$section		= 'users';
$_public		= true;
$_include_path	= 'include/';
require($_include_path.'vitals.inc.php');

$_SESSION['enroll']		 = false;
$_SESSION['from_cid']	 = 0;
$_SESSION['s_cid']		 = '';
$_SESSION['prefs_saved'] = '';

if ($_GET['course'] != '') {
	$course	= intval($_GET['course']);
} else {
	$course	= intval($_POST['course']);
}

if (isset($_POST['lang'])) {
	$_SESSION['lang'] = $_POST['lang'];
}
//$_SESSION['is_admin'] = false;

/*
if ($_POST['g'] != '') {
	echo 'entry?';
	$sql	= "INSERT INTO g_click_data VALUES ($_SESSION[member_id], $_SESSION[from_cid], 0, 5, SYSDATE)";
	$result = @$db->query($sql);
}
*/



if ($_GET['newpass'] == 1) {
	$_SESSION['course_id'] = $course;
	Header('Location: ./change_profile.php');
	exit;
}


if ($_GET['pexp'] == 1) {
	$_SESSION['course_id'] = $course;
	Header('Location: ./pass_expired.php');
	exit;
	
}

if (($course === 0) && ($_SESSION['valid_user'])) {
	$_SESSION['course_id'] = $course;
	$_SESSION['last_updated'] = time()/60 - ONLINE_UPDATE - 1;
	Header('Location: ./users/index.php?f='.$_GET['f']);
	//Header('Location: ./users/e_intro.php?f='.$_GET['f']);
	exit;
}

$sql	= "SELECT * FROM courses WHERE course_id=$course";
$result = $db->query($sql);
$countsql = "SELECT COUNT(*) FROM (".$sql.")";
$countres = $db->query($countsql);
$count0 = $countres->fetchRow();

if ($count0[0] == 1) {
	$row	  =$result->fetchRow(DB_FETCHMODE_ASSOC);
	$owner_id = $row['MEMBER_ID'];
	$tracking = $row['TRACKING'];
	
	$_SESSION['track_me'] = (($tracking == 'on') || ($tracking=='on ')) ? 1 : 0;
	switch ($row['ACCESSTYPE']){
		case 'public':

			$_SESSION['course_id']	  = $course;

			if (!$_SESSION['valid_user']) {
				/* guest login */
				$_SESSION['login']		= 'guest';
				$_SESSION['valid_user']	= false;
				$_SESSION['member_id']	= 0;
				$_SESSION['is_admin']	= false;
				$_SESSION['is_guest']	= true;
	
				/* add guest login to counter: */
				count_login();
			} else {
				/* check if we're an admin here */
				if (($SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
					//$_SESSION['is_admin'] = true;
					$_SESSION['enroll']	  = true;
				} else {
					$_SESSION['is_admin'] = false;

					/* add member login to counter: */
					count_login();
				}
			}

			/* title wont be needed. comes from the cache. */
			$_SESSION['course_title'] = $row['TITLE'];

			$sql	= "SELECT * FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";
			$result = $db->query($sql);
			if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				/* we have requested or are enrolled in this course */
				$_SESSION['enroll'] = true;
			}

			/* update users_online	*/
			add_user_online();

			/* get prefs:			*/
			$sql	= "SELECT preferences FROM preferences WHERE member_id=$_SESSION[member_id] AND course_id=$course";
			$result = $db->query($sql);
			if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
				assign_session_prefs(unserialize(stripslashes($row2['PREFERENCES'])));
			} else {
				$sql	= "SELECT preferences FROM members WHERE member_id=$_SESSION[member_id]";
				$result = $db->query($sql);
				if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
					assign_session_prefs(unserialize(stripslashes($row2['PREFERENCES'])));
				}
			}

			if ($_GET['f']) {
				Header('Location: ./index.php?f='.$_GET['f'].SEP.'g=30'.SEP.'disable=PREF_MAIN_MENU');
				exit;
			} /* else */
			Header('Location: ./index.php?g=30'.SEP.'disable=PREF_MAIN_MENU');
			exit;

			break;

		case 'protected':
			if (!$_SESSION['valid_user']) {

				Header('Location: ./login.php?course='.$course);
				exit;

			} else {
				/* we're already logged in */
				$_SESSION[course_id] = $course;

				/* check if we're an admin here */
				if (($SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
					//$_SESSION['is_admin'] = true;
					$_SESSION['enroll']	  = true;
				} else {
					$_SESSION['is_admin'] = false;

					$sql	= "SELECT * FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";
					$result = $db->query($sql);
					if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
						/* we have requested or are enrolled in this course */
						$_SESSION['enroll'] = true;
					}

					/* add member login to counter: */
					count_login();
				}

				$_SESSION['course_title'] = $row['TITLE'];

				/* update users_online	*/
				add_user_online();

				/* get prefs:			*/
				$sql	= "SELECT preferences FROM preferences WHERE member_id=$_SESSION[member_id] AND course_id=$course";
				$result = $db->query($sql);
				if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
					assign_session_prefs(unserialize(stripslashes($row2['PREFERENCES'])));

				} else {
					$sql	= "SELECT preferences FROM members WHERE member_id=$_SESSION[member_id]";
					$result = $db->query($sql);
					if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
						assign_session_prefs(unserialize(stripslashes($row2['PREFERENCES'])));
					}
				}

				if ($_GET['f']) {
					Header('Location: ./index.php?f='.$_GET['f'].SEP.'g=30'.SEP.'disable=PREF_MAIN_MENU');
					exit;
				} /* else */
				Header('Location: ./index.php?g=30'.SEP.'disable=PREF_MAIN_MENU');
				exit;
			}

			break;

		case 'private':
			if (!$_SESSION['valid_user']) {
				/* user not logged in: */
				Header('Location: ./login.php?course='.$course);
				exit;
			} else {

				if (($SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
					/* we own this course. so we dont have to enroll */

					$_SESSION['is_admin']  = true;
					$_SESSION['course_id'] = $course;
					$_SESSION['course_title'] = $row['TITLE'];
					$_SESSION['enroll']	  = true;

					/* update users_online */
					add_user_online();

					if ($_GET['f']) {
						Header('Location: ./index.php?f='.$_GET['f'].SEP.'disable=PREF_MAIN_MENU');
						exit;
					} /* else */
					Header('Location: ./index.php?disable=PREF_MAIN_MENU');
					exit;
				}

				/* check if we're enrolled */
				$sql	= "SELECT * FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";
				$result = $db->query($sql);

				if (($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) || ($_SESSION['is_admin']) || ($_SESSION['c_instructor'])) {
					/* we have requested or are enrolled in this course */

					$_SESSION['enroll'] = true;

						/* enrollment has been approved */

						/* we're already logged in */
						$_SESSION['course_id'] = $course;

						/* check if we're an admin here */
						if (($SESSION['status']==STATUS_ADMIN) || ($_SESSION['status']==STATUS_TRAINER)) {
							//$_SESSION['is_admin']	 = true;
							$_SESSION['enroll']		 = true;
						} else {
							$_SESSION['is_admin']	 = false;
						}

						$_SESSION['course_title'] = $row['TITLE'];

						/* update users_online			*/
						add_user_online();

						/* add member login to counter: */
						count_login();

						/* get prefs:					*/
						$sql	= "SELECT preferences FROM preferences WHERE member_id=$_SESSION[member_id] AND course_id=$course";
						$result = $db->query($sql);
						if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
							assign_session_prefs(unserialize(stripslashes($row2['PREFERENCES'])));
						} else {
							$sql	= "SELECT preferences FROM members WHERE member_id=$_SESSION[member_id]";
							$result = $db->query($sql);
							if ($row2 =$result->fetchRow(DB_FETCHMODE_ASSOC)) {
								assign_session_prefs(unserialize(stripslashes($row2['PREFERENCES'])));
							}
						}

						if($_GET['f']){
							Header('Location: ./index.php?f='.$_GET['f'].SEP.'g=30'.SEP.'disable=PREF_MAIN_MENU');
							exit;
						} /* else */
						Header('Location: ./index.php?g=30'.SEP.'disable=PREF_MAIN_MENU');
						exit;

				} else {
					/* we have not requested enrollment in this course */
					$_SESSION['course_id'] = 0;
					// Header('Location: ./users/private_enroll.php?course='.$course);
					echo 'Not enrolled to this course...';
					exit;
				}
			}
		break;
	}
} /* else */

require($_include_path.'basic_html/header.php');
$errors[]=AT_ERROR_NO_SUCH_COURSE;
print_errors($errors);
require($_include_path.'basic_html/footer.php');

?>
