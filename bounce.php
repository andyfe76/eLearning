<?php

function count_login( ) {
	global $db;

	if ($_SESSION['is_guest']) {
	    $sql   = "INSERT INTO course_stats VALUES ($_SESSION[course_id], NOW(), 1, 0)";
	} else {
	   $sql    = "INSERT INTO course_stats VALUES ($_SESSION[course_id], NOW(), 0, 1)";
	}

    $result = @mysql_query($sql, $db);

    if (!$result) {
		/* that entry already exists, then update it. */
		if ($_SESSION['is_guest']) {
			$sql   = "UPDATE course_stats SET guests=guests+1 WHERE course_id=$_SESSION[course_id] AND login_date=NOW()";
		} else {
			$sql   = "UPDATE course_stats SET members=members+1 WHERE course_id=$_SESSION[course_id] AND login_date=NOW()";
		}
		$result = @mysql_query($sql, $db);
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
	$sql	= "INSERT INTO g_click_data VALUES ($_SESSION[member_id], $_SESSION[from_cid], 0, 5, NOW())";
	$result = @mysql_query($sql, $db);
}
*/

if ($_GET['pexp'] == 1) {
	$_SESSION['course_id'] = $course;
	Header('Location: ./pass_expired.php');
	exit;
}

if (($course === 0) && ($_SESSION['valid_user'])) {
	$_SESSION['course_id'] = $course;
	$_SESSION['last_updated'] = time()/60 - ONLINE_UPDATE - 1;
	Header('Location: ./users/index.php?f='.$_GET['f']);
	exit;
}

$sql	= "SELECT * FROM courses WHERE course_id=$course";
$result = mysql_query($sql,$db);

if (mysql_num_rows($result) == 1) {
	$row	  = mysql_fetch_array($result);
	$owner_id = $row['member_id'];
	$tracking = $row['tracking'];

	$_SESSION['track_me'] = ($tracking == 'on') ? 1 : 0;

	switch ($row['access']){
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
				if ($owner_id == $_SESSION['member_id']) {
					$_SESSION['is_admin'] = true;
					$_SESSION['enroll']	  = true;
				} else {
					$_SESSION['is_admin'] = false;

					/* add member login to counter: */
					count_login();
				}
			}

			/* title wont be needed. comes from the cache. */
			$_SESSION['course_title'] = $row['title'];

			$sql	= "SELECT * FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";
			$result = mysql_query($sql, $db);
			if ($row2 = mysql_fetch_array($result)) {
				/* we have requested or are enrolled in this course */
				$_SESSION['enroll'] = true;
			}

			/* update users_online	*/
			add_user_online();

			/* get prefs:			*/
			$sql	= "SELECT preferences FROM preferences WHERE member_id=$_SESSION[member_id] AND course_id=$course";
			$result = mysql_query($sql, $db);
			if ($row2 = mysql_fetch_array($result)) {
				assign_session_prefs(unserialize(stripslashes($row2['preferences'])));
			} else {
				$sql	= "SELECT preferences FROM members WHERE member_id=$_SESSION[member_id]";
				$result = mysql_query($sql, $db);
				if ($row2 = mysql_fetch_array($result)) {
					assign_session_prefs(unserialize(stripslashes($row2['preferences'])));
				}
			}

			if ($_GET['f']) {
				Header('Location: ./index.php?f='.$_GET['f'].SEP.'g=30');
				exit;
			} /* else */
			Header('Location: ./index.php?g=30');
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
				if ($owner_id == $_SESSION['member_id']) {
					$_SESSION['is_admin'] = true;
					$_SESSION['enroll']	  = true;
				} else {
					$_SESSION['is_admin'] = false;

					$sql	= "SELECT * FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";
					$result = mysql_query($sql, $db);
					if ($row2 = mysql_fetch_array($result)) {
						/* we have requested or are enrolled in this course */
						$_SESSION['enroll'] = true;
					}

					/* add member login to counter: */
					count_login();
				}

				$_SESSION['course_title'] = $row['title'];

				/* update users_online	*/
				add_user_online();

				/* get prefs:			*/
				$sql	= "SELECT preferences FROM preferences WHERE member_id=$_SESSION[member_id] AND course_id=$course";
				$result = mysql_query($sql, $db);
				if ($row2 = mysql_fetch_array($result)) {
					assign_session_prefs(unserialize(stripslashes($row2['preferences'])));

				} else {
					$sql	= "SELECT preferences FROM members WHERE member_id=$_SESSION[member_id]";
					$result = mysql_query($sql, $db);
					if ($row2 = mysql_fetch_array($result)) {
						assign_session_prefs(unserialize(stripslashes($row2['preferences'])));
					}
				}

				if ($_GET['f']) {
					Header('Location: ./index.php?f='.$_GET['f'].SEP.'g=30');
					exit;
				} /* else */
				Header('Location: ./index.php?g=30');
				exit;
			}

			break;

		case 'private':
			if (!$_SESSION['valid_user']) {
				/* user not logged in: */
				Header('Location: ./login.php?course='.$course);
				exit;
			} else {

				if ($owner_id == $_SESSION['member_id']) {
					/* we own this course. so we dont have to enroll */

					$_SESSION['is_admin']  = true;
					$_SESSION['course_id'] = $course;
					$_SESSION['course_title'] = $row['title'];
					$_SESSION['enroll']	  = true;

					/* update users_online */
					add_user_online();

					if ($_GET['f']) {
						Header('Location: ./index.php?f='.$_GET['f']);
						exit;
					} /* else */
					Header('Location: ./index.php');
					exit;
				}

				/* check if we're enrolled */
				$sql	= "SELECT * FROM course_enrollment WHERE member_id=$_SESSION[member_id] AND course_id=$course";
				$result = mysql_query($sql, $db);

				if (($row2 = mysql_fetch_array($result)) || ($_SESSION['is_admin'])) {
					/* we have requested or are enrolled in this course */

					$_SESSION['enroll'] = true;

					if (($row2['approved'] == 'y') || ($_SESSION['is_admin'])) {
						/* enrollment has been approved */

						/* we're already logged in */
						$_SESSION['course_id'] = $course;

						/* check if we're an admin here */
						if ($owner_id == $_SESSION['member_id']) {
							$_SESSION['is_admin']	 = true;
							$_SESSION['enroll']		 = true;
						} else {
							$_SESSION['is_admin']	 = false;
						}

						$_SESSION['course_title'] = $row['title'];

						/* update users_online			*/
						add_user_online();

						/* add member login to counter: */
						count_login();

						/* get prefs:					*/
						$sql	= "SELECT preferences FROM preferences WHERE member_id=$_SESSION[member_id] AND course_id=$course";
						$result = mysql_query($sql, $db);
						if ($row2 = mysql_fetch_array($result)) {
							assign_session_prefs(unserialize(stripslashes($row2['preferences'])));
						} else {
							$sql	= "SELECT preferences FROM members WHERE member_id=$_SESSION[member_id]";
							$result = mysql_query($sql, $db);
							if ($row2 = mysql_fetch_array($result)) {
								assign_session_prefs(unserialize(stripslashes($row2['preferences'])));
							}
						}

						if($_GET['f']){
							Header('Location: ./index.php?f='.$_GET['f'].SEP.'g=30');
							exit;
						} /* else */
						Header('Location: ./index.php?g=30');
						exit;

					} else {
						/* we have not been approved to enroll in this course */

						$_SESSION['course_id'] = 0;
						Header('Location: ./users/private_enroll.php?course='.$course);
						exit;
					}

				} else {
					/* we have not requested enrollment in this course */
					$_SESSION['course_id'] = 0;
					Header('Location: ./users/private_enroll.php?course='.$course);
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