<?php

// This file contains the "language" for the K-Lore feedback system
// SEE: en_defs.inc.php for the variable definitions associated with this language.
// FEEDBACK TYPES:
// Errors, Help, Warnings, Feedback, and Info
// FUNCTIONS INCLUDE: print_feedback($feedback),print_help($help), print_popup_help($help),
//  print_infos($infos), print_warnings($warnings)
//
// Feedback can be added using the 5 feedback functions,
//
// -using Text messaged: print_feedback("This is simple text feedback");
//   **this method is not recommended as it makes it more difficult to translate K-Lore
//
// -using an array of messages: print_errors($errors); - where $errors is defined
//  as an array variable $errors[]=AT_ERROR_SIMPLE_EXAMPLE1; $errors[]=AT_ERROR_SIMPLE_EXAMPLE2; ...
//  multiple messages of the same type are grouped together and displayed in a single feedback box.
//
// -using a second array with search and replace characters
//   (e.g. $errors[]=array(AT_ERROR_SIMPLE_EXAMPLE, "some text", $a_variable)
//   the second and third arguments would replace the %1 and %2 strings. )
//
// //////////////////////////////
// Translate this file to create additional feedback languages


/////////////////////////////////////
// WARNINGS
$_warning[AT_WARNING_RAM_SIZE] ='Depending how much RAM your computer has, and the size of the course you wish to print, selecting the entire content of a large course may cause your computer to lock up.';
$_warning[AT_WARNING_THREAD_DELETE]='Are you sure you want to delete this thread?';
$_warning[AT_WARNING_DELETE_FORUM]='Are you sure you want to delete <b>%1</b>? All messages posted to this forum will be erased.';
$_warning[AT_WARNING_CONFIRM_FILE_DELETE]='Are you sure you want to delete file <strong>%1</strong>?';
$_warning[AT_WARNING_CONFIRM_DIR_DELETE]='Are you sure you want to delete folder <strong>%1</strong>?';
$_warning[AT_WARNING_SURE_DELETE_COURSE1]='Are you sure you want to <b>Delete</b> the course <strong><em>%1</em></strong>';
$_warning[AT_WARNING_SURE_DELETE_COURSE2]='Are you <b>really really</b> sure you want to <b>Delete</b> the course <strong><em>%1</em></strong>. Deleted courses can be recovered only by the K-Lore Server Administrator.';
$_warning[AT_WARNING_SURE_DELETE_USER]='Are you sure you want to delete user <b>%1</b>?<br />';
$_warning[AT_WARNING_SUB_CONTENT_DELETE]='This content page has sub content. If you delete this page all its sub pages will be deleted as well.<br />';
$_warning[AT_WARNING_GLOSSARY_REMAINS]='Embedded glossary definitions will not be deleted.<br />';
$_warning[AT_WARNING_GLOSSARY_REMAINS2]='Glossary items embedded in content pages will not be delete.<br />';
$_warning[AT_WARNING_GLOSSARY_DELETE]='Are you sure you want to delete this glossary item?<br />';
$_warning[AT_WARNING_DELETE_CONTENT]='Are you sure you want to delete this page?<br />';
$_warning[AT_WARNING_DELETE_NEWS]='Are you sure you want to delete %1?<br />';
$_warning[AT_WARNING_SAVE_YOUR_WORK]='Save your work before opening or closing the File Manager.';
$_warning[AT_WARNING_DELETE_THREAD]='Are you sure you want to delete this <strong>thread</strong>. It can not be recovered once deleted.';
$_warning[AT_WARNING_DELETE_MESSAGE]='Are you sure you want to delete this <strong>message</strong>. It can not be recovered once deleted.';
$_warning[AT_WARNING_LINK_WINDOWS]='Links open in a new window.';
$_warning[AT_WARNING_AUTO_LOGIN]='Be aware that others using this computer will be able to access your courses, and will appear to be logged in as you. Auto-Login should <strong>not</strong> be enabled when using a public work station.';
$_warning[AT_WARNING_SAVE_TEMPLATE]='Your template is not yet saved. Saving it will erase any existing header. Use "Cancel" to revert to your previously saved header.';
$_warning[AT_WARNING_EXPERIMENTAL11]='This tool is experimental. Expect there to be much room for improvement!';
$_warning[AT_WARNING_DELETE_TRACKING]='Are you sure your want to delete the tracking data for this course? You might choose to <a href="%1?csv=1">create a backup</a> before you empty the database.';
$_warning[AT_WARNING_DELETE_TEST]='Are you sure you want to delete the test <strong><em>%1</em></strong>? All the questions and all the results will be permanently erased.';
$_warning[AT_WARNING_DELETE_RESULTS]='Are you sure you want to delete results for user <strong><em>%1</em></strong>?';
$_warning[AT_WARNING_DELETE_QUESTION]='Are you sure you want to delete this question? It will be permanently erased.';
$_warning[AT_WARNING_REMOVE_COURSE]='Are you sure you want to delete <strong>%1</strong> from your Enrolled Courses?';
$_warning[AT_WARNING_DELETE_USER]='Are you sure you want to delete user <b>%1</b>?';
$_warning[AT_WARNING_DELETE_CATEGORY]='Are you sure you want to delete this category with all its links?';
/////////////////////////////////////
// INFORMATION
$_infos[AT_INFOS_REQUEST_ACCOUNT]='You do not yet have permission to create courses. If you would like your account upgraded to Instructor status, enter the <b>required description</b> of the course you wish to create, then use the "Request Instructor Account" button to submit your request for approval.';
$_infos[AT_INFOS_PRIVATE_ENROL]='The course you are trying to access is <b>private</b>. Enrollment in this course requires instructor approval.<br />';
$_infos[AT_INFOS_CHOOSE_NUMBERS]='All the fields are required. Tip: numbers make the best choices for <code>value</code> fields.';
$_infos[AT_INFOS_NO_MORE_FIELDS]='There are no additional options for the fields you chose. Use the "next" button to continue.';
$_infos[AT_INFOS_USE_SQLBELOW]='Use the SQL below to create your table in MySQL.';
$_infos[AT_INFOS_NO_POSTS_FOUND]='There are no posts in this forum.';
$_infos[AT_INFOS_INBOX_EMPTY]='There are no messages in your inbox.';
$_infos[AT_INFOS_APPROVAL_PENDING]='Your request has been made. You will be notifed when your request has been approved.<br /><br />Return to your <a href="users/index.php">Control Centre</a>.';
$_infos[AT_INFOS_ACCOUNT_PENDING]='Your instructor account request has been made. You will be notifed by email when your request has been approved.';
$_infos[AT_INFOS_NO_ENROLLMENTS]='No students are enrolled in this course.';
$_infos[AT_INFOS_GLOSSARY_REMAINS]='Note that removing a linked glossary term from your content will <strong>not</strong> delete the term from the glossary.';

$_infos[AT_INFOS_NO_TERMS]='No Glossary terms found for letter "%1". Select "All" to display the entire glossary.';
$_infos[AT_INFOS_TRACKING_OFFST]='Tracking is not enabled for this course.';
$_infos[AT_INFOS_TRACKING_OFFIN]='Tracking is not enabled for this course. Contact your system administrator to have it turned on.';
$_infos[AT_INFOS_TRACKING_NO_INST]='You have choosen your own ID number. Tracking information is not recorded for course instructors. Choose another user.';
$_infos[AT_INFOS_TRACKING_NO_INST1]='Tracking information is not recorded for course instructors. See the <a href="tools/course_tracker.php">Course Tracker</a> for a record of course activity.';
$_infos[AT_INFOS_NO_CONTENT]='This course has no content yet.';
$_infos[AT_INFOS_NO_PERMISSION]='You do not have permission to access this page.';
$_infos[AT_INFOS_NOT_RELEASED] ='This content has not yet been released. %1';
$_infos[AT_INFOS_NO_PAGE_CONTENT] ='There is no content on this page.';

?>