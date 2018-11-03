<%@ LANGUAGE="VBSCRIPT" %>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>K-Lore Reports</TITLE>
</HEAD>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<style type="text/css">
	* {font-size: 8pt}
</style>

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
<BR>
<center><A href="index.asp?action=Add Report">Add Report</a></center>
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
 <table cellpadding="0" cellspacing="1" border="0" align="center" class="bodyline">
 <tr><th scope="col">Name</th><th scope="col" width="200">Description</th><th scope="col" colspan="2">Action</th></tr>
 <%
 Do
  %>
  <tr>
  <td class="row1"><A href="report_build.asp?report_id=<%=record.fields.item("id")%>"><%=record.fields.item("name")%></a>&nbsp;</td>
  <td class="row1"><%=record.fields.item("description")%>&nbsp;</td>
  <td class="row1"><A href="report_view.asp?report_id=<%=record.fields.item("id")%>">View</a></td>
  <td class="row1">&nbsp;&nbsp;&nbsp;&nbsp;<A href="index.asp?action=Delete Report&report_id=<%=record.fields.item("id")%>">Delete</a></td>
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