<?php
// Original english file for the setup process
// By Loïc Chapeaux <loic-info@netcourrier.com> and Martin Edelius <martin.edelius@spirex.se>

// extra header for charset
$S_Charset = "iso-8859-1";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Tables will be created/updated on a local server.");
define("S_MAIN_2","Step 1 completed: tables have been created/updated.");
define("S_MAIN_3","Step 1 bypassed by user.");
define("S_MAIN_4","Found missing or invalid setting(s).");
define("S_MAIN_5","At least one of the cleaning delays is missing.");
define("S_MAIN_6","At least one default room is required.");
define("S_MAIN_7","The name of a room cannot contain backslashes (\\).");
define("S_MAIN_8","The timezone offset is missing.");
define("S_MAIN_9","The default number of messages to display and/or the default timeout between each update is/are missing.");
define("S_MAIN_11","Step 2 completed: settings for fine tunning have been registered.");
define("S_MAIN_12","You must enter a login name.");
define("S_MAIN_13","Your name cannot contain a space, comma or backslash (\\).");
define("S_MAIN_14","You must enter your password.");
define("S_MAIN_15","The <I>%s</I> nick is already registered and the password you entered is wrong.");
define("S_MAIN_16","Step 3 completed: your administrator profile has been registered.");
define("S_MAIN_17","Step 3 bypassed by user.");
define("S_MAIN_18","- Setup");

// Settings for setup0.php3 file
define("S_SETUP0_1","This script allows you to easily install %s.");
define("S_SETUP0_2","You can also do this manually if you wish. If you prefer to do it this way, you have to:");
define("S_SETUP0_3","Create tables for %s using the dump files located in <I>'chat/install/database'</I> dir;");
define("S_SETUP0_4","Edit the <I>config.lib.php3</I> file located in the <I>'chat/config'</I> dir to define %s settings;");
define("S_SETUP0_5","Manually add required information for the Administrator into the registered users table (c_reg_users): your nick in the <I>username</I> column, MD5 hash of the actual password in the <I>password</I> column and the word 'admin' (without quotes) in the <I>perms</I> column. If you want to you can always add additional information in the other columns but it is not required;");
define("S_SETUP0_5m","Sets three variables at the top of the 'chat/admin/mail4admin.lib.php3' script.");
define("S_SETUP0_6","To continue with the automated setup please click the button below.");
define("S_SETUP0_7"," Go ");
define("S_SETUP0_8","Before updating from an older version of %s you'd better clean the messages table (using the 'chat/admin.php3' script of this old version for example).");

// Settings for setup1.php3 file
define("S_SETUP1_1","First step: Tables configuration");
define("S_SETUP1_2","Database settings");
define("S_SETUP1_3","Select your SQL server type:");
define("S_SETUP1_4","Hostname of your SQL server:");
define("S_SETUP1_5","Logical database name on that server:");
define("S_SETUP1_6","(must exist)");
define("S_SETUP1_7","Database user's login:");
define("S_SETUP1_8","Database user's password:");
define("S_SETUP1_9","Tables creation/update");
define("S_SETUP1_10","What do you want this script to do ?");
define("S_SETUP1_11","Create tables for %s");
define("S_SETUP1_12","Update existing ones created for 0.12.0 or 0.12.1 releases");
define("S_SETUP1_13","Do nothing, tables are already up to date (for 0.13.4 and 0.14.? releases)");
define("S_SETUP1_14","Names of the tables<SUP>*</SUP> where...");
define("S_SETUP1_15","messages will be stored:");
define("S_SETUP1_16","registered users profiles will be stored:");
define("S_SETUP1_17","logged users will be stored:");
define("S_SETUP1_18","<SUP>*</SUP>Names you enter for tables must correspond to existing tables if you choose to<BR><B>update</B> them. If you want to <B>create new tables</B> the names must <B>not</B> be the<BR>same as those of existing tables!<BR>All of the fields must be completed, even if you don't want the script to do<BR>anything as the information will be necessary when creating the administrator<BR>profile later.");
define("S_SETUP1_19","OK");
define("S_SETUP1_20","Update existing ones created for 0.13.0 to 0.13.3 releases");
define("S_SETUP1_21","banished users will be stored:");

// Settings for setup2.php3 file
define("S_SETUP2_1","Second step: Fine tuning options");
define("S_SETUP2_2","Clean up settings for messages and usernames");
define("S_SETUP2_3","Number of hours until messages are deleted:");
define("S_SETUP2_4","Number of minutes until inactive users are deleted:");
define("S_SETUP2_5","Number of days until inactive users are deleted&nbsp;&nbsp;&nbsp;<BR>from registration table (0 for never):");
define("S_SETUP2_6","Default rooms to create");
define("S_SETUP2_7","Separated with comma (,) no spaces.");
define("S_SETUP2_8","Language settings");
define("S_SETUP2_9","Allow multi-languages/charset support ?");
define("S_SETUP2_10","Default language:");
define("S_SETUP2_11","Security and restrictions");
define("S_SETUP2_12","Show link for admin resources at startup screen ?");
define("S_SETUP2_13","Show link that allows users to delete their own profile ?");
define("S_SETUP2_15","Users can access...");
define("S_SETUP2_16","...only the first room within the default ones");
define("S_SETUP2_17","...all the rooms defined as default ones but not create a room");
define("S_SETUP2_18","...all the rooms and create new ones");
define("S_SETUP2_19","Messages enhancements");
define("S_SETUP2_20","Use graphical smilies (see 'chat/lib/smilies.lib.php3')?");
define("S_SETUP2_21","Keep effect of bold, italic and underline tags in messages ?");
define("S_SETUP2_22","Show discarded HTML tags ?");
define("S_SETUP2_23","Default display seetings");
define("S_SETUP2_24","Timezone offset in hours between the server time and your country:");
define("S_SETUP2_25","Default message order:");
define("S_SETUP2_26","last on top");
define("S_SETUP2_27","last on bottom");
define("S_SETUP2_28","Default number of messages to display:");
define("S_SETUP2_29","Default timeout between refreshing messages frame (in seconds):");
define("S_SETUP2_30","Show timestamp as default.");
define("S_SETUP2_31","Show nofications of user entrance/exit as default.");
define("S_SETUP2_36","Check for swear words (see 'chat/lib/swearing.lib.php3') ?");
define("S_SETUP2_41","Maximum number of messages that an user is allowed to export to an HTML file (0 for none -save command is disabled-, '*' for all available messages, or an integer to limit server charge)?");
define("S_SETUP2_42","Enable the banishment feature?<BR>0 for no, else a positive number to define the number of banishment<BR>day(s) (2000000 for no end, 0.02 for ~half an hour....))");
define("S_SETUP2_43","Registration of users");
define("S_SETUP2_14","Require registration?");
define("S_SETUP2_44","Generate a password and send it to the e-mail address the user enter in?<BR>This option require the <I>'mail()'</I> PHP function to be enabled, ensure you can use it with the administrator of your PHP server.<BR>Moreover, to have it running you must define 4 settings in the 'chat/lib/mail_validation.lib.php3' script.");
define("S_SETUP2_45","Your PHP configuration seems not to allow the use of the <I>'mail()'</I> function. So you can't choose to generate a password and send it to the user by e-mail.");
define("S_SETUP2_46","publics:");
define("S_SETUP2_47","privates:");
define("S_SETUP2_48","Send a welcome message to an user logging into the chat (see 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","An administrator profile is already defined and only one<BR>administrator can exist. Please modify the fields<BR>below to update the existing profile.");
define("S_SETUP3_2","Third step: Administrator registration");
define("S_SETUP3_3","Fields with a <SPAN CLASS=error>*</SPAN> are required.");
define("S_SETUP3_4","login (nick):");
define("S_SETUP3_5","password:");
define("S_SETUP3_6","firstname:");
define("S_SETUP3_7","lastname:");
define("S_SETUP3_8","spoken languages:");
define("S_SETUP3_9","website:");
define("S_SETUP3_10","e-mail address:");
define("S_SETUP3_11","show e-mail by /whois command");
define("S_SETUP3_12","Skip >>");
define("S_SETUP3_13","You may modify your profile later by clicking on the edit<BR>profile link at the start page of %s.");
define("S_SETUP3_14", "gender");
define("S_SETUP3_15", "male");
define("S_SETUP3_16", "female");

// Settings for setup4.php3 file
define("S_SETUP4_1","Fourth step: The config file");
define("S_SETUP4_2","Here's the config file created according to the information you have entered.<BR><BR>Copy all of it, including the first and last lines, and then paste it into your favourite text-editor (Notepad, Vi...). After this you *must* enter the database users password on line 7 and save the file as <I>config.lib.php3</I>.<BR><BR>Ensure that there is <B>neither empty line neither space character, neither before the php opening tag neither after the closing one</B>, then you can upload the config file to your server in the <I>config</I> dir (replace the existing one) and secure it (see the <I>install.txt</I> file in the <I>docs</I> dir for more information on this).<BR><BR>Don't forget to have a look at the <A HREF=\"#warn\">warning message</A> bellow.");
define("S_SETUP4_3","Highlight all");
define("S_SETUP4_4","Once you have completed the steps above, %s is near ready to run.<BR>");
define("S_SETUP4_4m"," Just sets manually three variables at the top of the <I>'chat/admin/mail4admin.lib.php3'</I><BR>script... and have some nice chat discussions.");
define("S_SETUP4_5","After you have got %s up and running you should remove the<BR><I>setup.php3</I> file and the whole <I>'chat/install'</I> dir from your server.");
?>