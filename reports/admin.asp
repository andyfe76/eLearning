<%@ LANGUAGE="VBSCRIPT" %>
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="SAPIEN Technologies PrimalScript 3.0">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>KLore Reports</TITLE>
</HEAD>
<BODY>
<%
 action=Request.QueryString("action")
 If action="Add Report" Then
  Set conn=CreateObject("adodb.connection")
  Set record=CreateObject("adodb.recordset")
  conn.open "dsn=klore_report"
  conn.Execute "INSERT INTO report_reports (name,description) VALUES ('test','test')"
  conn.close
  record.ActiveConnection="dsn=klore_report"
  record.Source="select last_insert_id() from report_reports"
  record.CursorType=0
  record.CursorLocation=2
  record.LockType=1
  record.Open()
  id=record.fields.item("last_insert_id()")
  record.close
  Set record=Nothing
  Set conn=Nothing
  Response.Redirect("report_build.asp?report_id="&id)
 End If
 
 If action="Delete Report" Then
  Set conn=CreateObject("adodb.connection")
  Set record=CreateObject("adodb.recordset")
  conn.open "dsn=klore_report"
  conn.Execute "DELETE FROM report_reports WHERE ID="&Request.QueryString("report_id")
  conn.close
  Set conn=Nothing
 End If 
 %> 
<A href="fields_edit.asp">Fields Editor</a>
<BR>
<A href="link_edit.asp">Links Editor</a>
<BR>

<A href="index.asp?action=Add Report">Add Report</a>
<BR>
<BR>
<%
 Set record=CreateObject("adodb.recordset")
 record.ActiveConnection="dsn=klore_report"
 record.Source="select * from report_reports"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 %>
 <table border="1">
 <tr><td>Name</td><td>Desription</td><td>&nbsp</td></tr>
 <%
 Do
  %>
  <tr>
  <td><A href="report_build.asp?report_id=<%=record.fields.item("id")%>"><%=record.fields.item("name")%></a></td>
  <td><A href="report_build.asp?report_id=<%=record.fields.item("id")%>"><%=record.fields.item("description")%></a></td>
  <td><A href="index.asp?action=Delete Report&report_id=<%=record.fields.item("id")%>">Delete</a></td>
  <td><A href="report_view.asp?report_id=<%=record.fields.item("id")%>">View</a></td>
  </tr>
  <%
  record.movenext
 Loop Until record.eof
 record.close
 %>
 </table>
 <%
 End If
 %> 
</BODY>
</HTML>
