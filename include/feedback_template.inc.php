<?php
// ToDo : Replace Texts with $_template['text'];
$fdtext='

<table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#f3f3f3">
  <tr>
    <td width="117"><div align="center"><strong>Feedback</strong> </div></td>
  </tr>
</table>
<br>
<form name="form1" method="post" action="users/feedback.php">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#f3f3f3">
    <tr> 
      <td width="50%" valign="top">What is your oppinion about this course ?</td>
      <td width="50%"> <select name=q1>
          <option value=2>Excelent,Smashing,Super</option>
          <option value=1>Good</option>
          <option value=0 selected>Average</option>
          <option value=-1>Bad</option>
          <option value=-2>Worst Course I`ve ever seen</option>
        </select> </td>
    </tr>
    <tr> 
      <td width="50%" valign="top">What do you think about the teacher ?</td>
      <td><select name=q2 id="q2">
          <option value="2">Genius</option>
          <option value="1">Good</option>
          <option value="0" selected>Average</option>
          <option value="-1">Bad</option>
          <option value="-2">Very bad</option>
        </select></td>
    </tr>
    <tr> 
      <td width="50%" height="27" valign="top">.. And about you ?</td>
      <td><select name=q3 id="q3">
          <option value=2>Genius</option>
          <option value=1>Good</option>
          <option value=0 selected>Average</option>
          <option value=-1>Bad</option>
          <option value=-2>Nightmare</option>
        </select></td>
    </tr>
    <tr> 
      <td width="50%">&nbsp;</td>
      <td><input type="submit" name="add_feedback" class="button" value="Feedback"></td>
    </tr>
  </table>
</form>


';

?>