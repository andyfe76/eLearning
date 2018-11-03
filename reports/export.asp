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
 Set record=CreateObject("adodb.recordset")
 Set record2=CreateObject("adodb.recordset")
 Set record4=CreateObject("adodb.recordset")
 Set record3=CreateObject("adodb.recordset")
 Set conn=CreateObject("adodb.connection")

 report_id=Request.QueryString("report_id")
 sql="SELECT "
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
  sql=sql&table&"."&field
  record.movenext
  If record.eof=False Then sql=sql&","
 Loop Until record.eof
 record.close 
 End If
 
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
  tables=tables&table&","
  record.movenext
 Loop Until record.eof
 End If
 record.close
 
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_links"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  'cat=record.fields.item("cat1")
  'attr=record.fields.item("attr1")
  'record2.ActiveConnection="dsn=klore_report"
  'record2.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
  'record2.CursorType=0
  'record2.CursorLocation=2
  'record2.LockType=1
  'record2.Open()
  'If record2.eof=False Then
  ' table=record2.fields.item("tbl")
  ' field=record2.fields.item("field")
  'End If
  'record2.close
  table=record.fields.item("cat1")
  tables=tables&table&","
    
  'cat=record.fields.item("cat2")
  'attr=record.fields.item("attr2")
  'record2.ActiveConnection="dsn=klore_report"
  'record2.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
  'record2.CursorType=0
  'record2.CursorLocation=2
  'record2.LockType=1
  'record2.Open()
  'If record2.eof=False Then
  ' table=record2.fields.item("tbl")
  ' field=record2.fields.item("field")
  'End If
  'record2.close
  table=record.fields.item("cat2")
  tables=tables&table&","
  
  record.movenext
 Loop Until record.eof
 End If
 record.close
 
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
  tables=tables&table&","
  record.movenext
 Loop Until record.eof
 record.close 
 End If
 
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
 
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_links"
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  'cat=record.fields.item("cat1")
  'attr=record.fields.item("attr1")
  'record2.ActiveConnection="dsn=klore_report"
  'record2.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
  'record2.CursorType=0
  'record2.CursorLocation=2
  'record2.LockType=1
  'record2.Open()
  'If record2.eof=False Then
  ' table1=record2.fields.item("tbl")
  ' field1=record2.fields.item("field")
  'End If
  'record2.close
  
  'cat=record.fields.item("cat2")
  'attr=record.fields.item("attr2")
  'record2.ActiveConnection="dsn=klore_report"
  'record2.Source="SELECT * FROM report_definitions WHERE cat='"&cat&"' AND attr='"&attr&"'"
  'record2.CursorType=0
  'record2.CursorLocation=2
  'record2.LockType=1
  'record2.Open()
  'If record2.eof=False Then
  ' table2=record2.fields.item("tbl")
  ' field2=record2.fields.item("field")
  'End If
  'record2.close
  
  sql=sql&record.fields.item("cat1")&"."&record.fields.item("attr1")&"="&record.fields.item("cat2")&"."&record.fields.item("attr2")
  record.movenext
  If record.eof=False Then sql=sql&" AND "
 Loop Until record.eof
 End If
 record.close
 
 
 
 'sql queryes
 
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_query WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  cat=record.fields.item("cat")
  attr=record.fields.item("attr")
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
  
  sql=sql&" "&func&" "&table&"."&field&" "&op&" '"&val&"'"
  
  record.movenext
 Loop Until record.eof
 End If
 record.close 
 
 Set ExcelApp = CreateObject("Excel.Application")
 ExcelApp.Application.Visible = true
 Set ExcelBook = ExcelApp.Workbooks.Add
 index = 1
 record.ActiveConnection="dsn=klore_report"
 record.Source="SELECT * FROM report_columns WHERE report="&report_id
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 col=1
 Do
  tmp=""
  tmp=tmp&record.fields.item("cat")
  tmp=tmp&"."
  tmp=tmp&record.fields.item("attr")
  ExcelBook.Worksheets(1).cells(index,col)=tmp
  with ExcelBook.Worksheets(1).cells(index,col)
  	.font.bold=true
  	.interior.color=rgb(200, 200, 200)
  end with
 
 record.movenext
 col=col+1
 Loop Until record.eof
 record.close
 
 index=index+1
 
 record.ActiveConnection="dsn=klore_report"
 record.Source=sql
 record.CursorType=0
 record.CursorLocation=2
 record.LockType=1
 record.Open()
 If record.eof=False Then
 Do
  col=1
  For Each item In record.fields
   ExcelBook.Worksheets(1).cells(index,col)=item.value
   col=col+1
  Next
 record.movenext
 index=index+1
 Loop Until record.eof
 End If
 record.close
 
 ' Ok. Let's autofit the columns
 ExcelBook.Worksheets(1).Columns("a:z").AutoFit
  
 dir=Server.MapPath(".")&"\export\"
 set fso=createobject("scripting.filesystemobject")
 if fso.fileexists (dir&"report_"&session.sessionid &".xls") then fso.deletefile dir&"report_"&session.sessionid &".xls", true
 set fso = nothing
 ExcelBook.saveAs dir &"report_" &session.sessionid &".xls"
 ExcelApp.Application.quit
 set ExcelApp = nothing
 response.addHeader "Content-Type", "application/file"
 response.redirect("http://192.168.0.1/k-lore reports/export/report_"&session.sessionid &".xls")
 
 %>
</BODY>
</HTML>