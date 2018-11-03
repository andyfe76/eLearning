<?php
	// this is not a stand-alone script file. Works only included in the K-Lore framework.
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');

	$sql = "SELECT * FROM dyn_queries";
	$res = $db->query($sql);
	
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		
		$static_id = $row['R_ID'];
		$dyn_id = $row['R_ID'];
		$sql = $row['Q_TEXT'];
		//echo $sql.'<br>';
		
		if ($sql <> '') {
			//delete old group members
			$sql_empty = "DELETE FROM mdyn_groups WHERE group_id=$static_id";
			$res3 = $db->query($sql_empty);
			
			// execute stored sql
			$sql = str_replace('apstr%', '\'%', $sql);
			$sql = str_replace('%apstr', '%\'', $sql);
			$sql = str_replace('&apstr', '\'', $sql);
			$sql = str_replace('"', '\'', $sql);
			$sql = str_replace('`', "'", $sql);
//			echo $sql.'<br><br>';
			$sql = "SELECT DISTINCT member_id FROM (".$sql.")";
			$res2 = $db->query($sql);
			if (PEAR::isError(res2)) {
				$_errors[] = AT_ERROR_DYNAMIC_GROUP;
				echo 'DynGroup Error';
			}
			while ($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC)) {
				$sqli = "INSERT INTO mdyn_groups VALUES ($row2[MEMBER_ID], null, $static_id)";
				$resi = $db->query($sqli);
			}
		}
	}
	Header('Location: ../users/usermng.php?dyngrp='.$_GET['group']);
?>