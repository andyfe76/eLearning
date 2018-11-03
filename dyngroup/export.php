<?php
	$section = 'users';
	$_include_path = '../include/';
	require($_include_path.'vitals.inc.php');
	
	// debug 4migration
	echo 'Migration process. 4 Nov 2003. ASP / PHP COM objects.';
	exit;

	$sql_buf = "SELECT ";
	$report_id = $_GET['report_id'];
	
	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	$res = $db->query($sql);
	$c = 0;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($c >0) $sql_buf .= ',';
		$cat = $row['CAT'];
		$attr = $row['ATTR'];
		$sql = "SELECT * FROM report_definitions WHERE cat='$cat' AND attr='$attr'";
		$res1 = $db->query($sql);
		if ($row1 =$res1->fetchRow(DB_FETCHMODE_ASSOC)) {
			$table = $row1['TBL'];
			$field = $row1['FIELD'];
		}
		$sql_buf .= $table.'.'.$field;
		$c++;
	}
	
	$sql_buf .= ' FROM ';
	$tables = '';
	$sql = "SELECT * FROM report_query WHERE report=$report_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$sql = "SELECT * FROM report_definitions WHERE cat='$cat' AND attr='$attr'";
		$res1 = $db->query($sql);
		if ($row1 =$res1->fetchRow(DB_FETCHMODE_ASSOC)) {
			$table = $row1['TBL'];
			$field = $row1['FIELD'];
		}
		$tables .= $table.',';
	}

	$sql = "SELECT * FROM report_links";
	$res = $db->query($sql);
	$c = 0;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($c >0) $tables .= ',';
		$tables .= $row['CAT1'].','.$row['CAT2'];
		$c++;
		
	}

	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
	$res = $db->query($sql);
	$c = 0;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($c >0) $tables .= ',';
		$cat = $row['CAT'];
		$attr = $row['ATTR'];
		$sql = "SELECT * FROM report_definitions WHERE cat='$cat' AND attr='$attr'";
		$res1 = $db->query($sql);
		if ($row1 =$res1->fetchRow(DB_FETCHMODE_ASSOC)) {
			$table = $row1['TBL'];
			$field = $row1['FIELD'];
		}
		$tables .= $table;
	}
	
	$tables2 = '';
	$a1 = 0;
	$t = 0;
	$c = 0;
	do {
		$a2 = strpos($tables, ',', $a1);
		$table_tmp = substr($tables, $a1, $a2 - $a1);
		if (!strpos($tables, $table_tmp, 0)) {
			if ($c >0) $tables2 .= ',';
			$tables2 .= $table_tmp;
			$c++;
		}
		$a1 .= $a2 +1;
		$t++;
	} while (($a1 < strlen($tables)) && ($t<100));

	$sql_buf .= $tables2.' WHERE ';

	$sql = "SELECT * FROM report_links";
	$res = $db->query($sql);
	$c = 0;
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($c >0) $sql_buf .= ' AND ';
		$sql_buf .= $row['CAT1'].'.'.$row['ATTR1'].'='.$row['CAT2'].'.'.$row['ATTR2'];
		$c++;
	}
	
	$sql = "SELECT * FROM report_query WHERE report=$report_id";
	$res = $db->query($sql);
	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
		$cat = $row['CAT'];
		$attr = $row['ATTR'];
		$op = $row['OP'];
		$val = $row['VAL'];
		$func = $row['FUNCTION'];
		$sql = "SELECT * FROM report_definitions WHERE cat='$cat' AND attr='$attr'";
		$res1 = $db->query($sql);
		if ($row1 =$res1->fetchRow(DB_FETCHMODE_ASSOC)) {
			$table = $row1['TBL'];
			$field = $row1['FIELD'];
		}
		$sql_buf .= ' '.$func.' '.$table.'.'.$field.' '.$op.' \''.$val.'\'';
	}
	 
	$none = new VARIANT();
	com_load_typelib('Excel.Application');
	$excelApp = new COM('Excel.Application') or die('Unable to load Excel');
 	$excelBook = $excelApp->Workbooks->Add();
 	$index = 1;
 	$sql = "SELECT * FROM report_columns WHERE report=$report_id";
 	$res = $db->query($sql);
 	$col = 1;
 	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
 		$tmp = '';
 		$tmp .= $row['CAT'];
 		$tmp .= '.';
 		$tmp .= $row['ATTR'];
 		$excelApp->Workbooks(1)->Worksheets(1)->cells($index, $col)->set($tmp);
 		$excelBook->Worksheets(1)->cells($index, $col)->font->bold = true;
 		$excelBook->Worksheets(1)->cells($index, $col)->interior->color = rgb(200, 200, 200);
 		$col++;
 	}
 	
 	$index++;
 	$res = $db->query($sql_buf);
 	while ($row =$res->fetchRow(DB_FETCHMODE_ASSOC)) {
 		$col = 1;
 		foreach ($row) {
 			
 		}
 	}
 	
 	
 
 
 
 
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
