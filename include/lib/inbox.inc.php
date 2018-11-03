<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002-2003 by Greg Gay & Joel Kronenberg        */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

require($_include_path.'lib/forum_codes.inc.php');

if (!$_SESSION['valid_user']) {
	$errors[]=AT_ERROR_MSG_SEND_LOGIN;
	print_errors($errors);
	return;
}


if ($_GET['delete']) {
	$_GET['delete'] = intval($_GET['delete']);

	if($result = mysql_query("DELETE FROM messages WHERE to_member_id=$_SESSION[member_id] AND message_id=$_GET[delete]",$db)){
		$feedback[] = AT_FEEDBACK_MSG_DELETED;
	}

	$_GET['delete'] = '';
}

print_feedback($feedback);
?>
<h2><?php echo $_template['inbox']; ?></h2>
<p>
<span class="bigspacer">( <a href="<?php echo $current_path; ?>send_message.php"><?php echo $_template['new_message']; ?></a> )</span>
<br /><br />
<p>
<?php

if (isset($_GET['s'])) {
	$feedback[] = AT_FEEDBACK_MSG_SENT;
	print_feedback($feedback);
}

if ($_GET['view']) {

	$sql	= "SELECT * FROM messages WHERE message_id=$_GET[view] AND to_member_id=$_SESSION[member_id]";
	$result = mysql_query($sql, $db);

	if ($row = mysql_fetch_array($result)) {
?>
	<table border="0" cellpadding="2" cellspacing="1" width="98%" class="bodyline" summary="">
	<tr>
		<th valign="top" class="left"><?php
			echo $row['subject'];
		?></th>
	</tr>
	<tr>
		<td><?php
			$from = get_login($row['from_member_id']);

			echo '<span class="bigspacer">'.$_template['from'].' <b>'.$from.'</b> '.$_template['posted_on'].' ';
			echo AT_date($_SESSION['lang'], $_template['inbox_date_format'], $row['date_sent'], AT_MYSQL_DATETIME);
			echo '</span>';
			echo '<p>';
			echo format_final_output(' '.$row['body'].' ');
			echo $body;
			echo '</p>';
		?></td>
	</tr>
	</table>
	<span class="bigspacer">( <a href="<?php echo $current_path; ?>send_message.php?reply=<?php echo $_GET['view']; ?>" accesskey="r" title="<?php echo $_template['reply']; ?>: Alt-r"><b> <?php echo $_template['reply']; ?> [Alt-r]</b></a> |  <a href="<?php echo $PHP_SELF; ?>?delete=<?php echo $_GET['view']; ?>" accesskey="x" title="<?php echo $_template['delete']; ?>: Alt-x"><b><?php echo $_template['delete']; ?> [Alt-x]</b></a> )</span>
	<?php
	}
	echo '<hr width="98%"></p>';
}



$sql	= "SELECT * FROM messages WHERE to_member_id=$_SESSION[member_id] ORDER BY date_sent DESC";
$result = mysql_query($sql,$db);

if ($row = mysql_fetch_array($result)) {
	echo '<table border="0" cellspacing="1" cellpadding="0" width="98%" class="bodyline" summary="">
	<tr>
		<th><img src="images/clr.gif" alt="" width="40" height="1"></th>
		<th width="100" class="left">'.$_template['from'].'</th>
		<th width="327" align="center">'.$_template['subject'].'</font></th>
		<th width="150" align="center">'.$_template['date'].'</font></th>
	</tr>';
	$count = 0;
	$total = mysql_num_rows($result);
	do {
		$count ++;

		echo '<tr>';

		
		echo '<td valign="middle" width="10" align="center" class="row1">';
		if ($row['new'] == 1)	{
			echo '<small>'.$_template['new'].'&nbsp;</small>';
		} else if ($row['replied'] == 1) {
			echo '<small>'.$_template['replied'].'</small>';
		}
		echo '</td>';

		$name = get_login($row[1]);

		echo '<td align="left" class="row1">';

		if ($view != $row[0]) {
			echo $name.'&nbsp;</td>';
		} else {
			echo '<b>'.$name.'</b>&nbsp;</td>';
		}


		echo '<td valign="middle" class="row1">';
		if ($view != $row[0]) {
			echo '<a href="'.$PHP_SELF.'?view='.$row[0].'">'.$row['subject'].'</a></td>';
		} else {
			echo '<b>'.$row['subject'].'</b></td>';
		}
	
		echo '<td valign="middle" align="right" class="row1"><small>';
		echo AT_date(	$_SESSION['lang'],
						$_template['inbox_date_format'],
						$row['date_sent'],
						AT_MYSQL_DATETIME);
		echo '</small></td>';
		echo '</tr>';

		if ($count < $total) {
			echo '<tr><td height="1" class="row2" colspan="4"></td></tr>';
		}

	} while ($row = mysql_fetch_array($result));
	echo '</tr>
		</table>';
} else {
	$infos[] = AT_INFOS_INBOX_EMPTY;
	print_infos($infos);
}
?>
<br /><br />
