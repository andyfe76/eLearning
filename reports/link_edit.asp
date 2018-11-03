<%@ LANGUAGE="VBSCRIPT" %>
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>Link Editor</TITLE>
</HEAD>
<script>
function update(action)
{
 document.forms[0].action.value=action;
 document.forms[0].editing.value='no';
 document.forms[0].submit();
}

</script>
<BODY>
<%
Set record=CreateObject("adodb.recordset")
action=Request.QueryString("action")
link_id=Request.QueryString("link_id")
cat1=Request.QueryString("cat1")
cat2=Request.QueryString("cat2")
attr1=Request.QueryString("attr1")
attr2=Request.QueryString("attr2")

If action="Link Add" Then
 Set conn=CreateObject("adodb.connection")
 sql="INSERT INTO report_links (cat1,attr1,cat2,attr2) VALUES ('"&cat1&"','"&attr1&"','"&cat2&"','"&attr2&"')"
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
End If

If action="Link Update" and editing="no" Then
 Set conn=CreateObject("adodb.connection")
 sql="UPDATE report_links SET cat1='"&cat1&"',attr1='"&attr1&"',cat2='"&cat2&"',attr2='"&attr2&"' WHERE id="&link_id
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
 editing="no"
End If

If action="Link Edit" Then
 editing=Request.QueryString("editing")
 If editing<>"yes" Then
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_links WHERE id="&link_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
  cat1=record.fields.item("cat1")
  attr1=record.fields.item("attr1")
  cat2=record.fields.item("cat2")
  attr2=record.fields.item("attr2")
 End If
 record.close
 End If
 action="Link Update"
 editing="yes"
End If

If action="Link Delete" Then
 Set conn=CreateObject("adodb.connection")
 sql="DELETE FROM report_links WHERE id="&link_id
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
End If


%>
<TABLE border="1" align="center">
<form action="link_edit.asp">
<tr><td bgcolor="#E0E0E0">Catogory1</td><td bgcolor="#E0E0E0">Attribute1</td><td>&nbsp;</td><td bgcolor="#E0E0E0">Category2</td><td bgcolor="#E0E0E0">Attribute2</td></tr>
<tr>
<td><SELECT name="cat1" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SHOW TABLES"
 '"SELECT * FROM report_definitions ORDER BY cat"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 cat_old=""
 Do
  txt=record.fields.item("tables_in_atutor")
  If cat1="" Then cat1=txt
  If cat_old<>txt Then
  cat_old=txt
  selected=""
  If txt=cat1 Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 End If
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<td><SELECT name="attr1" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SHOW FIELDS FROM "&cat1
 '"SELECT * FROM report_definitions WHERE cat='"&cat1&"'"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  txt=record.fields.item("Field")
  selected=""
  If txt=attr1 Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>

<td><=></td>

<td><SELECT name="cat2" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SHOW TABLES"
 '"SELECT * FROM report_definitions ORDER BY cat"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 cat_old=""
 Do
  txt=record.fields.item("tables_in_atutor")
  If cat2="" Then cat2=txt
  If cat_old<>txt Then
  cat_old=txt
  selected=""
  If txt=cat2 Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 End If
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<td><SELECT name="attr2" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SHOW fields FROM "&cat2
 '"SELECT DISTINCT * FROM report_definitions WHERE cat='"&cat2&"'"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  txt=record.fields.item("Field")
  selected=""
  If txt=attr2 Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<%
txt_action=action
If txt_action="" Then txt_action="Link Add"
%>
<td><A HREF="javascript:void(update('<%=txt_action%>'))"><%=txt_action%></A>&nbsp;</td>
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_links"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
 %>
<tr>
<td><A href="link_edit.asp?action=Link Edit&link_id=<%=record.fields.item("id")%>"><%=record.fields.item("cat1")%></a>&nbsp;</td>
<td><A href="link_edit.asp?action=Link Edit&link_id=<%=record.fields.item("id")%>"><%=record.fields.item("attr1")%></a>&nbsp;</td>
<td><=></td>
<td><A href="link_edit.asp?action=Link Edit&link_id=<%=record.fields.item("id")%>"><%=record.fields.item("cat2")%></a>&nbsp;</td>
<td><A href="link_edit.asp?action=Link Edit&link_id=<%=record.fields.item("id")%>"><%=record.fields.item("attr2")%></a>&nbsp;</td>
<td><A href="link_edit.asp?action=Link Delete&link_id=<%=record.fields.item("id")%>">Delete</a></td>
</tr>
<%
 record.movenext
 Loop Until record.eof
 record.close
 End If
 %>
<INPUT type="hidden" name="action" value="<%=action%>">
<INPUT type="hidden" name="editing" value="<%=editing%>">
</form>
</table>
<br>
<center><A href="admin.asp">Return to Reports Home</a></center>
</BODY>
</HTML>