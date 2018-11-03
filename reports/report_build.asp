<%@ LANGUAGE="VBSCRIPT" %>
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>Report Builder</TITLE>
</HEAD>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<style type="text/css">
	* {font-size: 8pt}
</style>

<script>
function click_sel()
{
 document.all.val.value=document.all.sel.value;
}

function update(action)
{
 document.forms[0].action.value=action;
 document.forms[0].editing.value='no';
 document.forms[0].submit();
}

function filllist()
{
 document.report_form.val.value=document.report_form.form_list.value;
}

function change_cat()
{
 document.report_form.attr.value='';
 document.forms[0].submit();
}

</script>
<BODY>
<%
Set record=CreateObject("adodb.recordset")
Set record2=CreateObject("adodb.recordset")
Set record4=CreateObject("adodb.recordset")
Set record3=CreateObject("adodb.recordset")
Set conn=CreateObject("adodb.connection")
action=Request.QueryString("action")
query_id=Request.QueryString("query_id")
report_id=Request.QueryString("report_id")
column_id=Request.QueryString("column_id")
cat=Request.QueryString("cat")
attr=Request.QueryString("attr")
op=Request.QueryString("op")
val=Request.QueryString("val")
func=Request.QueryString("func")
editing=Request.QueryString("editing")
column_cat=Request.QueryString("column_cat")
column_attr=Request.QueryString("column_attr")

If action="Report Update" Then
 report_name=Request.QueryString("report_name")
 report_desc=Request.QueryString("report_desc")
 Set conn=CreateObject("adodb.connection")
 sql="UPDATE report_reports SET name='"&report_name&"',description='"&report_desc&"' WHERE id="&report_id
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
End If

report_name=Request.QueryString("report_name")
report_desc=Request.QueryString("report_desc")
If report_name="" Or reported_desc="" Then
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_reports WHERE id="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
  report_name=record.fields.item("name")
  report_desc=record.fields.item("description")
 End If
 record.close 
End If

If action="Query Add" Then
 Set conn=CreateObject("adodb.connection")
 sql="INSERT INTO report_query (cat,attr,op,val,report,function) VALUES ('"&cat&"','"&attr&"','"&op&"','"&val&"',"&report_id&",'"&func&"')"
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
End If

If action="Query Update" and editing="no" Then
 Set conn=CreateObject("adodb.connection")
 sql="UPDATE report_query SET cat='"&cat&"',attr='"&attr&"',op='"&op&"',val='"&val&"',function='"&func&"' WHERE id="&query_id
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
 editing="no"
End If

If action="Query Edit" Then
 editing=Request.QueryString("editing")
 If editing<>"yes" Then
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_query WHERE id="&query_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
  cat=record.fields.item("cat")
  attr=record.fields.item("attr")
  op=record.fields.item("op")
  val=record.fields.item("val")
  func=record.fields.item("function")
 End If
 record.close
 End If
 action="Query Update"
 editing="yes"
End If

If action="Query Delete" Then
 Set conn=CreateObject("adodb.connection")
 sql="DELETE FROM report_query WHERE id="&query_id
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
End If

If action="Column Add" Then
 Set conn=CreateObject("adodb.connection")
 sql="INSERT INTO report_columns (cat,attr,report) VALUES ('"&column_cat&"','"&column_attr&"',"&report_id&")"
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
End If

If action="Column Delete" Then
 Set conn=CreateObject("adodb.connection")
 sql="DELETE FROM report_columns WHERE id="&column_id
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
End If


If action="Column Edit" Then
 editing=Request.QueryString("editing")
 If editing<>"yes" Then
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_columns WHERE id="&column_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
  column_cat=record.fields.item("cat")
  column_attr=record.fields.item("attr")
  column_id=record.fields.item("id")
 End If
 record.close
 End If
 action="Column Update"
 editing="yes"
End If

If action="Column Update" and editing="no" Then
 Set conn=CreateObject("adodb.connection")
 sql="UPDATE report_columns SET cat='"&column_cat&"',attr='"&column_attr&"' WHERE id="&column_id
 conn.open "dsn=klore_report"
 conn.Execute sql
 conn.close
 Set conn=Nothing
 action=""
 editing="no"
End If

%>
<br>

<form action="report_build.asp" name="report_form">
<table cellspacing="0" cellpadding="0" border="0" align="center" width="75%"><tr><td>
<b>Report Name: </b>
<INPUT type="text" name="report_name" value="<%=report_name%>" size="20"></td>
<td><b>Description: </b>
<INPUT type="text" name="report_desc" value="<%=report_desc%>" size="20"></td>
<td><input type="submit" name="update" class="button" onClick="javascript:void(update('Report Update'))" value="Update"></td>
</tr>
</table>

<br>
<TABLE align="center" cellpadding="0" cellspacing="1" border="0" align="center" class="bodyline" width="75%">
<tr><th scope="col" colspan="7">Query Editor</th></tr>
<tr>
	<th scope="col">Catogory</th>
	<th scope="col">Attribute</th>
	<th scope="col">Op.</th>
	<th scope="col">Value</th>
	<th scope="col">List</th>
	<th scope="col">Function</th>
	<th scope="col">Action</th></tr>
<tr>
<tr>
	<td><img src="images/spacer.gif" width="130" height="1"></td>
	<td><img src="images/spacer.gif" width="130" height="1"></td>
	<td><img src="images/spacer.gif" width="20" height="1"></td>
	<td><img src="images/spacer.gif" width="100" height="1"></td>
	<td><img src="images/spacer.gif" width="200" height="1"></td>
	<td><img src="images/spacer.gif" width="80" height="1"></td>
	<td><img src="images/spacer.gif" width="90" height="1"></td>
</tr>
<td align="center" valign="bottom"><SELECT name="cat" onchange="change_cat();">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_definitions ORDER BY cat"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 cat_old=""
 Do
  txt=record.fields.item("cat")
  If cat="" Then cat=txt
  If cat_old<>txt Then
    cat_old=txt
    selected=""
    If txt=cat Then selected="SELECTED "
%>
    <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option>
<%
  End If
  record.movenext
  Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<td align="center" valign="bottom"><SELECT name="attr" onchange="document.report_form.submit();">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT DISTINCT * FROM report_definitions WHERE cat='"&cat&"'"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
  if attr="" then attr=record.fields.item("attr")
 end if
 record.close
 
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT DISTINCT * FROM report_definitions WHERE cat='"&cat&"'"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  txt=record.fields.item("attr")
  response.write(txt&"!!"&attr)
  selected=""
  If txt=attr Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<td align="center" valign="bottom"><SELECT name="op" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT DISTINCT * FROM report_operators"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  txt=record.fields.item("text")
  selected=""
  If txt=op Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<td align="center" valign="bottom"><INPUT type="text" name="val" value="<%=val%>" size="20"></td>
<td align="center" valign="bottom"><SELECT name="form_list" id="form_list" cols="10" onchange="filllist();">
<%
 on error resume next
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 t=""
 f=""
 If record.eof=False Then
  t=record.fields.item("tbl")
  f=record.fields.item("field")
 End If
 If t<>"" Then
 record.close
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT "&f&" FROM "&t
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  response.write(f&" !from! "&t)
  v=record.fields.item(f)
  selected=""
  If v=val Then selected=" SELECTED"
  %>
  <OPTION<%=selected%> value="<%=v%>"><%=v%></option>
  <%
  record.movenext
 Loop Until record.eof
 End If
 End If
 record.close 
%>
</Select>
<td align="center" valign="bottom"><SELECT name="func" onchange="document.forms[0].submit()">
<%
selected=""
If func="AND" Then selected="SELECTED "
%>
<OPTION <%=selected%>name="AND">AND</option>
<%
selected=""
If func="OR" Then selected="SELECTED "
%>
<OPTION <%=selected%>name="OR">OR</option>
</select>
</td>
<td>
<INPUT type="hidden" name="action" value="<%=action%>">
<INPUT type="hidden" name="query_id" value="<%=query_id%>">
<INPUT type="hidden" name="report_id" value="<%=report_id%>">
<INPUT type="hidden" name="column_id" value="<%=column_id%>">
<INPUT type="hidden" name="editing" value="<%=editing%>">
<%

txt_action=action
If action="" Then txt_action="Query Add"
If action="Query Edit" Then txt_action="Update Query"
If InStr(1,txt_action,"Column")<>0 or InStr(1,txt_action,"Report")<>0 Then txt_action="Query Add"
%>
<A HREF="javascript:void(update('<%=txt_action%>'))"><%=txt_action%></A> &nbsp;</td>
</tr>
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT DISTINCT * FROM report_query WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  %>
  <tr><td colspan="7"><hr></td></tr>
  <tr>
  <td><A class="breadcrumbs" HREF="report_build.asp?report_id=<%=report_id%>&query_id=<%=record.fields.item("id")%>&action=Query Edit&editing=no"><%=record.fields.item("cat")%></a>&nbsp;</td>
  <td><A class="breadcrumbs" HREF="report_build.asp?report_id=<%=report_id%>&query_id=<%=record.fields.item("id")%>&action=Query Edit&editing=no"><%=record.fields.item("attr")%></a>&nbsp;</td>
  <td><A class="breadcrumbs" HREF="report_build.asp?report_id=<%=report_id%>&query_id=<%=record.fields.item("id")%>&action=Query Edit&editing=no"><%=record.fields.item("op")%></a>&nbsp;</td>
  <td colspan="2"><A class="breadcrumbs" HREF="report_build.asp?report_id=<%=report_id%>&query_id=<%=record.fields.item("id")%>&action=Query Edit&editing=no"><%=record.fields.item("val")%></a>&nbsp;</td>
  <td><A class="breadcrumbs" HREF="report_build.asp?report_id=<%=report_id%>&query_id=<%=record.fields.item("id")%>&action=Query Edit&editing=no"><%=record.fields.item("function")%></a>&nbsp;</td>
  <td><A class="breadcrumbs" HREF="report_build.asp?report_id=<%=report_id%>&query_id=<%=record.fields.item("id")%>&report_name=<%=report_name%>&report_desc=<%=report_desc%>&action=Query Delete">Delete</a></td>
  </tr>
  <%
  record.movenext
 Loop Until record.eof
 End If
 record.close
%>
</table></br>
<table cellpadding="0" cellspacing="1" border="0" class="bodyline" align="center">
<tr>
<th scope="col" colspan="7">Column Editor</th>
</tr>
<tr><th scope="col">Category</th>
<th scope="col">Attribute</th>
<th scope="col">Action</th>
</tr>

<tr>
<td><img src="images/spacer.gif" width="150" height="1"></td>
<td><img src="images/spacer.gif" width="150" height="1"></td>
<td><img src="images/spacer.gif" width="100" height="1"></td>
</tr>

<tr>
<td align="center" valign="bottom"><SELECT name="column_cat" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_definitions ORDER BY cat"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 cat_old=""
 Do
  txt=record.fields.item("cat")
  If column_cat="" Then column_cat=txt
  If cat_old<>txt Then
  cat_old=txt
  selected=""
  If txt=column_cat Then selected="SELECTED "
%>
 <OPTION <%=selected%>name="<%=txt%>"><%=txt%></option><%
 End If
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
</select></td>
<td align="center" valign="bottom"><SELECT name="column_attr" onchange="document.forms[0].submit()">
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT DISTINCT * FROM report_definitions WHERE cat='"&column_cat&"'"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  txt=record.fields.item("attr")
  selected=""
  If txt=column_attr Then selected="SELECTED "
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
If txt_action<>"Column Update" Then txt_action="Column Add"
%>
<td><A HREF="javascript:void(update('<%=txt_action%>'))"><%=txt_action%></A>&nbsp;</td>
</tr>
<%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_columns WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  %>
  <tr>
  <td><A href="report_build.asp?action=Column Edit&column_id=<%=record.fields.item("id")%>&report_id=<%=report_id%>"><%=record.fields.item("cat")%></a>&nbsp;</td>
  <td><A href="report_build.asp?action=Column Edit&column_id=<%=record.fields.item("id")%>&report_id=<%=report_id%>"><%=record.fields.item("attr")%></a>&nbsp;</td>
  <td><A href="report_build.asp?action=Column Delete&report_name=<%=report_name%>&report_desc=<%=report_desc%>&column_id=<%=record.fields.item("id")%>&report_id=<%=report_id%>">Delete</a></td>
  </tr>
  <%
  record.movenext
 Loop Until record.eof
 record.close
 End If
 %> 
</TABLE>

<br>
<center>
	<A href="index.asp">Cancel/Return to Reports Page</a></center>
</form>
</BODY>
</HTML>