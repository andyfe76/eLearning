<%@ LANGUAGE="VBSCRIPT" %>
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>Fields Editor</TITLE>
</HEAD>
<script>
function update(action)
{
 document.forms[0].action.value=action;
 document.forms[0].submit();
}
</script>
<BODY>
<%
 cat=Request.QueryString("cat")
 attr=Request.querystring("attr")
 desc=Request.QueryString("desc")
 table=Request.QueryString("table")
 field=Request.QueryString("field")
 action=Request.QueryString("action")
 editing=Request.QueryString("editing")
 id=Request.QueryString("id")
 Set record=CreateObject("adodb.recordset")
 Set record2=CreateObject("adodb.recordset")
 Set record3=CreateObject("adodb.recordset")

 If action="edit" and editing<>"yes" Then 
  record.ActiveConnection="dsn=klore_report"
  record.Source="SELECT * FROM report_definitions WHERE id="&id
  record.CursorType=0
  record.CursorLocation=2
  record.LockType=1
  record.Open()
  If record.eof=False Then
   cat=record.fields.item("cat")
   attr=record.fields.item("attr")
   desc=record.fields.item("description")
   table=record.fields.item("tbl")
   field=record.fields.item("field")
  End If
  record.close
  editing="yes"
 End If
 
 If action="Add" Then
 Set conn=CreateObject("adodb.connection")
 conn.open "dsn=klore_report"
 sql="INSERT INTO report_definitions (cat,attr,description,tbl,field) VALUES ('"&cat&"','"&attr&"','"&desc&"','"&table&"','"&field&"')"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
 End If
 
 If action="Update" Then
 Set conn=CreateObject("adodb.connection")
 conn.open "dsn=klore_report"
 sql="UPDATE report_definitions SET cat='"&cat&"',attr='"&attr&"',description='"&desc&"',tbl='"&table&"',field='"&field&"' WHERE id="&id
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action="Add"
 End If
 
 If action="delete" Then
 Set conn=CreateObject("adodb.connection")
 conn.open "dsn=klore_report"
 sql="DELETE FROM report_definitions WHERE id="&id
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action="Add"
 End If
 
%>
<table border="1" align="center">
<FORM action="fields_edit.asp">
<tr>
<td align="center" bgcolor="#E0E0E0">Category</td><td align="center" bgcolor="#E0E0E0">Attribute</td><td align="center" bgcolor="#E0E0E0">Description</td><td align="center" bgcolor="#E0E0E0">Table</td><td align="center" bgcolor="#E0E0E0">Field</td>
</td>
<tr>
<td><INPUT type="text" name="cat" value="<%=cat%>" size="20"></td>
<td><INPUT type="text" name="attr" value="<%=attr%>" size="20"></td>
<td><INPUT type="text" name="desc" value="<%=desc%>" size="20"></td>
<td><SELECT name="table" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SHOW tables"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  txt=record.fields.item("tables_in_atutor")
  If table="" Then table=txt
  selected=""
  If txt=table Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<td><SELECT name="field" onchange="document.forms[0].submit()">
<%
 If table<>"" Then
 record.ActiveConnection="dsn=klore_report"
 record.Source="SHOW FIELDS FROM "&table
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  txt=record.fields.item("field")
  selected=""
  If txt=field Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 record.movenext
 a=a+1
 Loop Until record.eof
 End If
 record.close
 End If
 %>
</select></td>
<%
txt_action=action
If action="" Then txt_action="Add"
If action="edit" Then txt_action="Update"
%>
<td>
<A HREF="javascript:void(update('<%=txt_action%>'))"><%=txt_action%></A> &nbsp;</td>
</tr>
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_definitions"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
 %> 
 <td><A HREF="fields_edit.asp?id=<%=record.fields.item("id")%>&action=edit&editing=no"><%=record.fields.item("cat")%></a>&nbsp;</td>
 <td><A HREF="fields_edit.asp?id=<%=record.fields.item("id")%>&action=edit&editing=no"><%=record.fields.item("attr")%></a>&nbsp;</td>
 <td><A HREF="fields_edit.asp?id=<%=record.fields.item("id")%>&action=edit&editing=no"><%=record.fields.item("description")%></a>&nbsp;</td>
 <td><A HREF="fields_edit.asp?id=<%=record.fields.item("id")%>&action=edit&editing=no"><%=record.fields.item("tbl")%></a>&nbsp;</td>
 <td><A HREF="fields_edit.asp?id=<%=record.fields.item("id")%>&action=edit&editing=no"><%=record.fields.item("field")%></a>&nbsp;</td>
 <td><A HREF="fields_edit.asp?id=<%=record.fields.item("id")%>&action=delete">Delete</a></td>
 </tr>
 <%
 record.movenext
 Loop Until record.eof
 record.close
 End If
 %>
 <BR>
 <input type="hidden" name="action" value="<%=action%>">
 <input type="hidden" name="id" value="<%=id%>">
 <input type="hidden" name="editing" value="<%=editing%>">
</form>
</table>
<br>
<center><A href="admin.asp">Return to Reports Home</a></center>
</BODY>
</HTML>