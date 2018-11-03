<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

$section = 'users';
$_include_path = '../include/';
require ($_include_path.'vitals.inc.php');
//require ($_include_path.'lib/klore_mail.inc.php');
	$sql2 = "SELECT * from members where member_id='$_GET[mid]'";
	$result2 = mysql_query($sql2);
		require($_include_path.'cc_html/header.inc.php');

?>
<p>[<a href="users/enroll_admin.php?course=<?php echo $_GET['course']; ?>">Back to Enrolment</a>]</p>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="90%" summary="" align="center">
	<tr>
		<th colspan="2" align="left" class="left">Student Information</th>
	</tr>
<?php 
while ($row=mysql_fetch_array($result2)){

	echo '<tr><td width="150" class="row1" align="right"><b>'.$_template['login'].':</b></td><td class="row1">'.$row['login'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	//echo '<tr><td class="row1" align="right"><b>'.$_template['first_name'].':</b></td><td class="row1">&nbsp;'.$row['first_name'].'</td></tr>';
	//echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	//echo '<tr><td class="row1" align="right"><b>'.$_template['last_name'].':</b></td><td class="row1">&nbsp;'.$row['last_name'].'</td></tr>';
	//echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td class="row1" align="right"><b>'.$_template['email'].':</b></td><td class="row1">'.$row['email'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
	echo '<tr><td class=row1 align=right><b>'.$_template['status'].':</b></td><td class="row1">';
	if ($status == 0) {
		echo 'Student';
	} else {
		echo 'Instructor';
	}
	echo '</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['age'].':</b></td><td class="row1">'.$row['age'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['gender'].':</b></td><td class="row1">'.$row['gender'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['street_address'].':</b></td><td class="row1">'.$row['address'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['city'].':</b></td><td class="row1">'.$row['city'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['province'].':</b></td><td class="row1">'.$row['province'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['postal_code'].':</b></td><td class="row1">'.$row['postal'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
			echo '<tr><td class="row1" align="right"><b>'.$_template['country'].':</b></td><td class="row1">'.$row['country'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['web_site'].':</b></td><td class="row1">'.$row['website'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['phone'].':</b></td><td class="row1">'.$row['phone'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
		echo '<tr><td class="row1" align="right"><b>'.$_template['date_created'].':</b></td><td class="row1">'.$row['creation_date'].'</td></tr>';
	echo '<tr><td height="1" class="row2" colspan="2"></td></tr>';
?>
	</table>

	
<?php
}
require($_include_path.'cc_html/footer.inc.php');
?>
