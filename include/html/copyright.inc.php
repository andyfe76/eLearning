<?php
 
?><br />
	<table border="0" summary="Copyright notice" width="100%">
	<tr>
		<td colspan="2" valign="middle" align="center"><small><?php
	
		$getcopyright_sql="select copyright from courses where course_id='$_SESSION[course_id]'";	
		$result2 = @mysql_query($getcopyright_sql, $db);
		$row = @mysql_fetch_row($result2);
		$show_edit_copyright = $row[0];
		if(strlen($show_edit_copyright)>0){
			//echo $show_edit_copyright;
		} 

		?></small></td>
	</tr>
	</table>
</td></tr>
<tr><td>
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr><td width="350">
			<a target="_blank" href="http://k-lore.koncept.ro"><img src="images/footer/footer_03.jpg" border="0"></a></td>
		<td background="images/footer/footer_04.jpg">
			<img src="images/spacer.gif" width="1" height="1">
		<td width="16" align="right">
			<img src="images/footer/footer_06.jpg"></td>
		</tr>
	</table>
</td></tr></table>
