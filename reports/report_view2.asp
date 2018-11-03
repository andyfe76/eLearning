<%@ LANGUAGE="VBSCRIPT" %>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>K-Lore Report Viewer</TITLE>
<link rel="stylesheet" href="stylesheet.css" type="text/css" />
<style type="text/css">
	* {font-size: 8pt}
</style>

</HEAD>
<BODY>
<%
function check_link(c1, c2) 

end function

 Set record=CreateObject("adodb.recordset")
 Set record2=CreateObject("adodb.recordset")
 Set record4=CreateObject("adodb.recordset")
 Set record3=CreateObject("adodb.recordset")
 Set conn=CreateObject("adodb.connection")

 
 
 course_enrollment = false
 course = false
 test = false
 members = false
 
  ' links
 
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_links"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
 
  table=record.fields.item("cat1")
  if publish=true then tables=tables&table&","
    
  table=record.fields.item("cat2")
  if publish=true then tables=tables&table&","
  
  record.movenext
 Loop Until record.eof
 End If
 record.close

 
 ' columns

 report_id=Request.QueryString("report_id")
 sql="SELECT "
 all_tables=""
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_columns WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  cat=record.fields.item("cat")
  attr=record.fields.item("attr")
  if attr="Enrolled member" then course_enrollment = true
  if cat="Course" then course=true
  if cat="Test" then test=true
  if cat="Student" then members=true

  record2.ActiveConnection="dsn=klore_report"
  record2.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
  record2.CursorType=0
  record2.CursorLocation=2
  record2.LockType=1
  record2.Open()
  If record2.eof=False Then
   table=record2.fields.item("tbl")
   all_tables=all_tables&table
   field=record2.fields.item("field")
  End If
  record2.close
  sql=sql&table&"."&field
  record.movenext
  If record.eof=False Then sql=sql&","
 Loop Until record.eof
 record.close 
 End If
 
 
 
 
 
 ' queries
	 
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_query WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 q=""

 If record.eof=False Then
 Do
  cat=record.fields.item("cat")
  attr=record.fields.item("attr")

  if (attr="Enrolled member") then course_enrollment = true
  if (cat="Course") then course=true
  if (cat="Test") then test=true
  if (cat="Student") then members=true

  op=record.fields.item("op")
  val=record.fields.item("val")
  func=record.fields.item("function")
  record2.ActiveConnection="dsn=klore_report"
  record2.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
  record2.CursorType=0
  record2.CursorLocation=2
  record2.LockType=1
  record2.Open()
  If record2.eof=False Then
   table=record2.fields.item("tbl")
   field=record2.fields.item("field")
  End If
  record2.close
  
  q=q&" "&func&" "&table&"."&field&" "&op&" '"&val&"'"

  
  record.movenext
 Loop Until record.eof
 End If
 record.close 
 
 sql=sql&" FROM "
 tables=""
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_query WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
 	response.write("step..")
  cat=record.fields.item("cat")
  attr=record.fields.item("attr")
  record2.ActiveConnection="dsn=klore_report"
  record2.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
  record2.CursorType=0
  record2.CursorLocation=2
  record2.LockType=1
  record2.Open()
  If record2.eof=False Then
   table=record2.fields.item("tbl")
   field=record2.fields.item("field")
  End If
  record2.close
  
  response.write("<BR>new table check: "&table&"<BR>")  
  
  publish = true
  if (course_enrollment=false) then
	  response.write("<BR>FROM course_enrollment: "&table)
  	if table="course_enrollment" or table="course_enrollment" then publish=false
  end if
  if (course=false) then
  	response.write("<BR>FROM course: "&table)
  	if table="courses" or table="crel_groups" or table="course_groups" then publish = false
  end if
  if (test=false) then 
  	response.write("<BR>FROM test: "&table)
  	if table="test_results" or table="test_status" or table="test_results" or table="test_status" then publish = false
  end if
  if (members=false) then
  	response.write("<BR>FROM members: "&table)
  	if table="members" or table="mrel_groups" or table="member_groups" or table="member_categ" then publish=false
  end if
  
  if publish=true then tables=tables&table&","
  record.movenext
 Loop Until record.eof
 End If
 record.close

	response.write("<BR>tables: "&tables&"<BR>")   
 tables2=""
 a1=1
 t=0
 Do
  a2=InStr(a1,tables,",")
  table_tmp=Mid(tables,a1,a2-a1)
  If InStr(1,tables2,table_tmp)=0 Then tables2=tables2&table_tmp&","
  a1=a2+1
  t=t+1
 Loop Until a1>=Len(tables) Or t=100
 tables2=Left(tables2,Len(tables2)-1)

 sql=sql&tables2
 
 sql=sql&" WHERE "
 
 'links
 
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_links"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
	
 If record.eof=False Then
 Do
  cat1=record.fields.item("cat1")
  attr1=record.fields.item("attr1")
  cat2=record.fields.item("cat2")
  attr2=record.fields.item("attr2")
  
  publish = true
  if (course_enrollment=false) then
  	if cat1="course_enrollment" or cat2="course_enrollment" then publish=false
  end if
  if (course=false) then
  	if cat1="courses" or cat1="crel_groups" or cat1="course_groups" or _
  	   cat2="courses" or cat2="crel_groups" or cat2="course_groups" then publish = false
  end if
  if (test=false) then 
  	if cat1="test_results" or cat1="test_status" or cat2="test_results" or cat2="test_status" then publish = false
  end if
  if (members=false) then
  	if cat1="members" or cat1="mrel_groups" or cat1="member_groups" or cat1="member_categ" or _
	   cat2="members" or cat2="mrel_groups" or cat2="member_groups" or cat2="member_categ" then publish=false
  end if	
  
  if publish=true then sql=sql &cat1&"."&attr1&"="&cat2&"."&attr2

  record.movenext
  If record.eof=False and publish=true then sql=sql&" AND "
 Loop Until record.eof
 End If
 record.close
 sql = left (sql, len(sql)-4)
 
 on error resume next
 response.write(sql)
 response.write("<br><br>Course:"&course)
 
 
  'sql queryes
 
 sql = sql &q
 
 %>
 <TABLE class="bodyline" border="0" cellpadding="0" cellspacing="1" align="center" width="75%">
 <tr>
 <%
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_columns WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 Do
  %>
  <th><%=record.fields.item("cat")%>.<%=record.fields.item("attr")%></th>
 <%
 record.movenext
 Loop Until record.eof
 record.close
 %>
 </tr>
 <%
 record.ActiveConnection="dsn=klore_report"
 record.Source=sql
 '"SELECT * FROM report_query WHERE id=9999"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  %>
  <tr>
  <%
  For Each item In record.fields
   %><td><%=item.value%>&nbsp;</td><%
  Next
  %>
  </tr>
  <%
 record.movenext
 Loop Until record.eof
 End If
 record.close
 %>
 </table>
<br>
<center>
<table border="0" align="center" width="75%">
<tr><td>
	<input type="button" class="button" name="export" value="Export to Excel" onclick="javascript:void(window.location='export.asp?report_id=<%=report_id%>');"></td>
<td>
	<A href="index.asp">Return to Reports Home</a>
</td><td>
	<input type="button" class="button" name="print" value="Print" onclick="javascript:void(window.print());">
</td>
</tr></table>
<BR>
<%=sql%>
</center>
</BODY>
</HTML>