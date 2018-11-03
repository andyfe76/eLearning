<?php

	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	$_section[0][0] = $_template['tools'];
	$_section[0][1] = 'tools/';

	if (!$_SESSION['is_admin'] && !$_SESSION['c_instructor']) {
		exit;
	}

	
global $_FILES;
if($_POST['submit'] && is_array($_FILES["pdf_file"])){
	if($_FILES["pdf_file"]["name"] == "") $errors = "Invalid file name.";
	else {
		move_uploaded_file($_FILES['pdf_file']['tmp_name'], '/var/www/html/KLore/tools/'.str_replace(' ','_',$_SESSION['course_title']).'.pdf');
		$feedback = "PDF File uploaded sucessfully";
	}
}

require($_include_path.'header.inc.php');
  
print_errors($errors);
print_feedback($feedback);

?>

<table border="0" cellpadding="4" cellspacing="4" width="300" align="center"><tr><td align="left">
<br/>
<form name="AddDocument" action="<?php echo $PHP_SELF ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="file">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
 <td>
  <input type="file" name="pdf_file" size="30"><br/>
 </td>
</tr>

</table>
<br/><br/>

<center>
<input type="submit" name="submit" value="Upload">
</center>
</form>
</font>
</td></tr></table>

<?php 
require($_include_path.'footer.inc.php');
?>