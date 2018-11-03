<?php
?>
<script language="JavaScript">
	function change_course(){
		document.all.jump_course.submit();
	}
	function change_language() {
		document.all.jump_course.submit();
	}

</script>

<tr>
	<td colspan="2" bgcolor="#F0F0F5">
		<img src="../images/spacer.gif" width="700" height="1">
	</td>
</tr>

<tr>
	<td valign="top"">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td bgcolor="F0F0F2">
				<img src="../images/menu/logo.jpg" border="0">
				<img src="../images/spacer.gif" width="53" height="1"></td>
		</tr><tr>
			<td background="../images/menu/left_artifact.gif" valign="top">
				<table cellpadding="2" cellspacing="0" border="0" id="top">
				<tr><td>
					<?php
						echo '<span style="font-family: Verdana, Arial; font-size: 10pt; color: #C0D7CF; margin-top: 0px;">';
						if ($_SESSION['valid_user'] === true) {
							echo '&nbsp;<a class="invert" href="users/edit.php" title="'.$_template['edit_profile'].'" target="_top"><b>'.$_SESSION['login'].'</b></a></span> ';
						} else {
							echo ' <b>'.$_template['guest'].'</b>. </span>';
						}
					?>
				</td></tr></table>
			</td>
		</tr>
		</table>
		
	</td><td valign="top" width="100%">
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" align="right" id="top">
		<tr>
			<td bgcolor="f0f0f2" align="center" valign="top" width="100%">
				<img src="../images/spacer.gif" width="1" height="42">
				<b><?php echo $_SESSION['course_title']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		
		<tr>
			<td background="../images/menu/menu_line.gif" colspan="2">
				<img src="../images/spacer.gif" border="0" width="1" height="7"></td>
		</tr>
		
		<tr>
			<td align="right" valign="top"  colspan="2">
				<?php
				
				if ($_SESSION['valid_user']) {
					if ($_SESSION['course_id'] == 0) {
						$temp_path = 'users/';
					}
				}
				?>
				
			</td>
		</tr>
		</table>
	</td>
</tr>

