<?php
/*
--Dynamic Excel or Word File from MySQL--
php-doc-xls-gen for php/MySQL: (.doc or .xls dumper):

This script takes the contents of a MySQL table and dumps it to
either a dynamically-generated MS Word File (file with ending '.doc')
or a dynamically-generated MS Excel File (file with ending '.xls').

Prerequisites:  You Must have MS Word and/or MS Excel installed on
the same computer as your web browser for this to work (although
the script can be placed on any Unix/Linux server, you have to access it using
a browser on a Windows machine with either Word or Excel installed).

How to use:
1)edit the MySQL Connection Info below for your MySQL connection
  & for the name of the MySQL table that you would like to make the dump for
2)save this file somewhere on your server
3)link to this file from another page:
  a)for Word dumps:
    <a href="this_file_name.php?w=1">link to word dump</a>
  b)for Excel dumps:
    <a href="this_file_name.php">link to excel dump</a>
  --or else--
  create a Bookmark to this page (include any of the optional parameters
  described below as part of the query string for the bookmarked URL)
4)how to reuse this code to create a dump for ANY MySQL table on your server:
  a)comment-out this line below under MySQL Connection Info:
    //$DB_TBLName = "your_table_name";
  b)include the name of your MySQL table in links (or bookmarks) to this page
    as an extra parameter:
    ie: for word dump--
    <a href="this_file_name.php?w=1&DB_TBLName=your_table_name">link to word dump</a>
    ie: for excel dump--
    <a href="this_file_name.php?DB_TBLName=your_table_name">link to excel dump</a>
  c)all of the above also holds true for the name of the Database:
    you could pass along the name of the Database as a parameter to this script
	in order to use it on many different databases on your server:
	comment out //$DB_DBName = "your database"; in this script below 
	and then link to this file like:
	"this_file_name.php?$DB_DBName=your_database&DB_TBLName=your_table_name..."
5)if you're resourceful, you could also pass the sql statement to be used for this
  script as a parameter: "this_file_name.php?sql=..."
  but you might have to URL-ENCODE your sql statement before passing it to this script,
  and then URL-DECODE it in the beginning of this script for it to work.

To change the formatting of the Word or Excel File generated:
change the respective parts of the coding for the word or the excel file that format
the database info sent to the browser.  Most useful for this are the escape characters
for tabs ('\t') & line returns ('\n').  Experiment with these until you get the formatting
that you desire.

If you're going to be using this script with SSL, please see the comments marked
'A NOTE ABOUT USING THIS SCRIPT WITH SSL' found below!

This code is freeware (GPL).  Please feel free to do with it what you'd like.
Comments, bugs, fixes to:
churmtom@hotmail.com

Originally: Nov. 25th, 2001
Updated:    May  12th, 2002
Updated:    July  1st, 2002
Updated:    Jan	 19th, 2003 - SSL Fix for MSIE

Thanks to Josue & Steven d.B. for helping point out
improvements for this code!

Interested in a desktop application that backs up a
COMPLETE MySQL database to an Excel File--without using ODBC?

Then try out my MySQL Database 2 Excel KonvertR program:
http://www.churm.com/konvertr/index.php
*/

//EDIT YOUR MySQL Connection Info:
$DB_Server = "admin";    	//your MySQL Server 
$DB_Username = "root"; 			//your MySQL User Name 
$DB_Password = "";    			//your MySQL Password 
$DB_DBName = "klore";    			//your MySQL Database Name 
$DB_TBLName = "content";    			//your MySQL Table Name 
//$DB_TBLName,  $DB_DBName, may also be commented out & passed to the browser
//as parameters in a query string, so that this code may be easily reused for
//any MySQL table or any MySQL database on your server

//DEFINE SQL QUERY:
//you can use just about ANY kind of select statement you want - 
//edit this to suit your needs!
$sql = "Select * from $DB_TBLName";

//Optional: print out title to top of Excel or Word file with Timestamp
//for when file was generated:
//set $Use_Titel = 1 to generate title, 0 not to use title
$Use_Title = 1;
//define date for title: EDIT this to create the time-format you need
$now_date = date('m-d-Y H:i');
//define title for .doc or .xls file: EDIT this if you want
$title = "Dump For Table $DB_TBLName from Database $DB_DBName on $now_date";
/*

Leave the connection info below as it is:
just edit the above.

(Editing of code past this point recommended only for advanced users.)
*/
//create MySQL connection
$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password)
    or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
//select database
$Db = @mysql_select_db($DB_DBName, $Connect)
    or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());
//execute query
$result = @mysql_query($sql,$Connect)
    or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

//if this parameter is included ($w=1), file returned will be in word format ('.doc')
//if parameter is not included, file returned will be in excel format ('.xls')
if (isset($w) && ($w==1)){
$file_type = "msword";
$file_ending = "doc";
}
else {
$file_type = "vnd.ms-excel";
$file_ending = "xls";
}
//header info for browser: determines file type ('.doc' or '.xls')
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=database_dump.$file_ending");
header("Pragma: no-cache");
header("Expires: 0");

/*
A NOTE ABOUT USING THIS SCRIPT WITH SSL:
==============================================
To get this script to work properly in MSIE,
do the following:

//delete this header:
header("Pragma: no-cache");

//and add these headers just after the "Expires: 0" header:
header("Keep-Alive: timeout=15, max=100");
header("Connection: Keep-Alive");         
header("Transfer-Encoding: chunked");

Thanks to Christopher Owens for this!
==============================================
*/

/*    Start of Formatting for Word or Excel    */

if (isset($w) && ($w==1)) //check for $w again
/*    FORMATTING FOR WORD DOCUMENTS ('.doc')   */
{
//create title with timestamp:
if ($Use_Title == 1){
echo("$title\n\n");
}
//define separator (defines columns in excel & tabs in word)
$sep = "\n"; //new line character

    while($row = mysql_fetch_row($result))
    {
        //set_time_limit(60); // HaRa
        $schema_insert = "";
        for($j=0; $j<mysql_num_fields($result);$j++)
        {
        //define field names
        $field_name = mysql_field_name($result,$j);
        //will show name of fields
        $schema_insert .= "$field_name:\t";
            if(!isset($row[$j])) {
                $schema_insert .= "NULL".$sep;
                }
            elseif ($row[$j] != "") {
                $schema_insert .= "$row[$j]".$sep;
                }
            else {
                $schema_insert .= "".$sep;
                }
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        //end of each mysql row
        //creates line to separate data from each MySQL table row
        print "\n----------------------------------------------------\n";
}
}
else
/*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
{
//create title with timestamp:
if ($Use_Title == 1){
echo("$title\n");
}
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character

//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++) {
echo mysql_field_name($result,$i) . "\t";
}
print("\n");
//end of printing column names

//start while loop to get data
/*
note: the following while-loop was taken from phpMyAdmin 2.1.0.
--from the file "lib.inc.php".
*/
    while($row = mysql_fetch_row($result))
    {
        //set_time_limit(60); // HaRa
        $schema_insert = "";
        for($j=0; $j<mysql_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
		//following fix suggested by Josue (thanks, Josue!)
		//this corrects output in excel when table fields contain \n or \r
		//these two characters are now replaced with a space
		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }
}
?>
