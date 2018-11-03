<?php

/////////////////////////
// Errors
$_errors[AT_ERROR_GENERAL] = 'This is a search and %1 K-Lore error.';  //call with:  print_errors(array(AT_ERROR_GENERAL, "replace"));
$_errors[AT_ERROR_UNKNOWN] = 'An undetermined error has occurred';
$_errors[AT_ERROR_NO_SUCH_COURSE] ='No such course ID found.';
$_errors[AT_ERROR_NO_TITLE] ='The title cannot be empty.';
$_errors[AT_ERROR_BAD_DATE] ='That date is not valid.';
$_errors[AT_ERROR_ID_ZERO] ='Content ID was zero, or was missing.';
$_errors[AT_ERROR_PAGE_NOT_FOUND] ='Content page cannot be found.';
$_errors[AT_ERROR_BAD_FILE_TYPE] ='Unsupported file type. Plain Text or HTML files only.';
$_errors[AT_ERROR_ANN_BOTH_EMPTY] ='The announcement title and body cannot both be empty.';
$_errors[AT_ERROR_ANN_ID_ZERO] ='Announcement ID cannot be zero/missing.';
$_errors[AT_ERROR_ANN_NOT_FOUND] ='Access denied to edit this announcement.';
$_errors[AT_ERROR_TERM_EMPTY] ='The term cannot be empty.';
$_errors[AT_ERROR_DEFINITION_EMPTY] ='The definition cannot be empty.';
$_errors[AT_ERROR_TERM_EXISTS] ='The term %1 already exists.';
$_errors[AT_ERROR_GLOS_ID_MISSING] ='Glossary term ID cannot be zero/missing.';
$_errors[AT_ERROR_TERM_NOT_FOUND] ='Glossary term cannot be found';
$_errors[AT_ERROR_FORUM_TITLE_EMPTY] ='The forum title cannot be empty.';
$_errors[AT_ERROR_POST_ID_ZERO] ='Post ID cannot be zero/missing.';
$_errors[AT_ERROR_POST_NOT_FOUND] ='Post cannot be found.';
$_errors[AT_ERROR_FORUM_NOT_FOUND] ='Forum can not be found.';
$_errors[AT_ERROR_ACCESS_DENIED] ='Access Denied';
$_errors[AT_ERROR_LOGIN_TO_POST]='You must be logged in to post';
$_errors[AT_ERROR_ALREADY_SUB]='You are already subscribed to this thread.';
$_errors[AT_ERROR_ACCESS_INSTRUCTOR] ='You must be registered as an instructor, and be logged in, to send a message to the Administrator.';
$_errors[AT_ERROR_STUD_INFO_NOT_FOUND] ='Student information cannot be found.';
$_errors[AT_ERROR_ADMIN_INFO_NOT_FOUND] ='Administrator information cannot be found.';
$_errors[AT_ERROR_MSG_SUBJECT_EMPTY] ='Your message subject cannot be empty.';
$_errors[AT_ERROR_MSG_BODY_EMPTY] ='Your message body cannot be empty.';
$_errors[AT_ERROR_MSG_TO_INSTRUCTOR] ='You must be a registered K-Lore user, and be logged in, to send the instructor a message.';
$_errors[AT_ERROR_INST_INFO_NOT_FOUND] ='Instructor information cannot be found.';
$_errors[AT_ERROR_CHOOSE_ONE_SECTION] ='You must select at least one section to print by choosing the corresponding checkbox.';
$_errors[AT_ERROR_NO_COURSE_CONTENT] ='There is no content associated with this course.';
$_errors[AT_ERROR_NO_DB_CONNECT] = 'Unable to connect to DB.<br />Possible causes: Incorrect user name and password; incorrect database name; or too many DB connections.';
$_errors[AT_ERROR_PREFS_NO_ACCESS] ='Either you are not logged in as the owner of this course, or you do not have permission to set preferences for this course';
$_errors[AT_ERROR_NO_USER_PREFS] ='Could not fetch user preferences';
$_errors[AT_ERROR_INVALID_LOGIN] ='Invalid login/password combination.';
$_errors[AT_ERROR_EMAIL_NOT_FOUND] ='No account found with that email address.';
$_errors[AT_ERROR_EMAIL_MISSING] ='You must enter an email address.';
$_errors[AT_ERROR_EMAIL_INVALID] ='Email address was invalid.';
$_errors[AT_ERROR_EMAIL_EXISTS] ='An account with that email address already exists. Please use the <a href="password_reminder.php">password reminder</a> feature to retrieve your password if it has been forgotten.';
$_errors[AT_ERROR_LOGIN_NAME_MISSING] ='You must enter a login name.';
$_errors[AT_ERROR_LOGIN_CHARS] ='Your user name must only contain letters, numbers, or underscores (_\'s).';
$_errors[AT_ERROR_LOGIN_EXISTS] ='That login already exists, please choose another.';
$_errors[AT_ERROR_PASSWORD_MISSING] ='You must supply a password.';
$_errors[AT_ERROR_PASSWORD_MISMATCH] ='Passwords did not match.';
$_errors[AT_ERROR_GROUP_MISSING] = 'Please select a group for the new user.';
$_errors[AT_ERROR_GROUP_EXISTING] = 'Group name already exists. Please type another name.';
$_errors[AT_ERROR_BAD_GROUP_NAME] = 'Invalid group name';
$_errors[AT_ERROR_NO_COURSE_GROUP] = 'No course group defined. Please define course groups before creating new courses.';
$_errors[AT_ERROR_DB_NOT_UPDATED]='Information could not be added to the database.';
$_errors[AT_ERROR_MSG_SEND_LOGIN] ='You must be logged in to send messages.';
$_errors[AT_ERROR_NO_RECIPIENT] ='You must choose a recipient.';
$_errors[AT_ERROR_SEND_ENROL] ='You can only send a message to other members after you enroll in a course.';
$_errors[AT_ERROR_SEND_MEMBERS] ='You can only send a message to others who are enrolled in the same courses as you. Your intended recipient may be viewing the course, but not enrolled.';
$_errors[AT_ERROR_FILE_ILLEGAL] =' %1 files are not allowed.';
$_errors[AT_ERROR_FILE_NOT_SAVED] ='The file cannot be saved.';
$_errors[AT_ERROR_FILE_TOO_BIG] ='The file size exceeds the limit %1';
$_errors[AT_ERROR_MAX_STORAGE_EXCEEDED] ='Adding this file exceeds the maximum course storage limit';
$_errors[AT_ERROR_FILE_NOT_SELECTED] ='You did not select a file to upload.';
$_errors[AT_ERROR_FOLDER_NOT_CREATED] ='The folder could not be created.';
$_errors[AT_ERROR_DIR_NOT_OPENED] ='Cannot open directory.';
$_errors[AT_ERROR_DIR_NOT_DELETED] ='Cannot open directory to be deleted.';
$_errors[AT_ERROR_DIR_NOT_EMPTY] ='Cannot delete directory because it is not empty.';
$_errors[AT_ERROR_DIR_NO_PERMISSION] ='Cannot delete directory. You may not have premission, or it may not be empty.';
$_errors[AT_ERROR_NOT_RELEASED] ='This content has not yet been released. %1';
$_errors[AT_ERROR_UNSUPPORTED_FILE]='Unsupported file type. Plain Text or HTML files only.';
$_errors[AT_ERROR_CSS_ONLY]='Unsupported file type. Style sheet files only (i.e. stylesheet.css).';
$_errors[AT_ERROR_RESULT_NOT_FOUND]='Result not found.';
$_errors[AT_ERROR_SUPPLY_TITLE]='You must supply a course name.';
$_errors[AT_ERROR_CREATE_NOPERM]='You do not have permission to create courses.';
$_errors[AT_ERROR_NO_STUDENTS]='There are no students enrolled in this course.';
$_errors[AT_ERROR_ALREADY_OWNED]='You own this course, and cannot enrol.';
$_errors[AT_ERROR_ALREADY_ENROLED]='You have already made a request to enroll in this course and you have not yet been approved by the instructor. You will be notifed when your request has been approved.';
$_errors[AT_ERROR_LOGIN_ENROL]='You must be logged in to enroll in a course.';
$_errors[AT_ERROR_REMOVE_COURSE]='An unknown error while removing the course.';
$_errors[AT_ERROR_DESC_REQUIRED]='You must provide a course description, before your instructor request can be processed.';
$_errors[AT_ERROR_START_DATE_INVALID]='That start date is not valid.';
$_errors[AT_ERROR_END_DATE_INVALID]='That end date is not valid.';
$_errors[AT_ERRORS_QUESTION_EMPTY]='Your question cannot be empty.';
$_errors[AT_ERROR_QUESTION_NOT_FOUND]='Question not found.';
$_errors[AT_ERROR_TEST_NOT_FOUND]='Test not found.';
$_errors[AT_ERROR_FIELD_TITLE_EMPTY]='[Field No: %1] The "Title" for field no. %2 was left blank.';
$_errors[AT_ERROR_FIELD_SIZE_EMPTY]='[Field No: %1] Field size must be provided for a field of type "Drop Down Select".';
$_errors[AT_ERROR_FIELD_SIZE_EMPTY_MULTI]='[Field No: %1] Field size must be provided for a field of type "Multiple Drop Down Select".';
$_errors[AT_ERROR_FIELD_TYPE_EMPTY]='[Field No: %1] Field type must not be empty.';
$_errors[AT_ERROR_SIZE_TEXTAREA_BOTH]='[Field No: %1] Field size 1 and Field size 2 are both required for field of type "Text Area".';
$_errors[AT_ERROR_OPTION_MISSING]='[Field No. %1, Option No. %2] No option provided.';
$_errors[AT_ERROR_VALUE_MISSING]='[Field No. %1, Option No. %2] No value provided.';
$_errors[AT_ERROR_TEST_EMAIL_MISSING]='You did not provide an email address to send the form data to.';
$_errors[AT_ERROR_TEST_EMAIL_INVALID]='You did not provide a valid email address.';
$_errors[AT_ERROR_TEST_THANKYOU]='You did not provide a thank-you page URL to redirect the user to after they have filled the form.';
$_errors[AT_ERROR_TEST_HOSTUSER_MISSING]='You did not enter hostname and/or username and/or database name.';
$_errors[AT_ERROR_TEST_TABLENAME_MISSING]='You did not enter the name of the table to be created.';
$_errors[AT_ERROR_TEST_COLNAME_MISSING]='Column %1 for field "%2" was not entered.';
$_errors[AT_ERROR_TEST_COL_NOSPACE]='<li>Column %1 for field "%2" cannot contain spaces.';
$_errors[AT_ERROR_CHOOSE_YESNO]='Please choose either yes or no to whether you want to enter form data into a MySQL database table.';
$_errors[AT_ERROR_DB_NOT_CONNECTED]='Could not establish connection to MySQL database with the information provided.';
$_errors[AT_ERROR_DB_NOT_ACCESSED]='Could not access MySQL database with information provided.';
$_errors[AT_ERROR_TABLE_NOT_CREATED]='Could not create MySQL database table.';
$_errors[AT_ERROR_NOT_OWNER]='You do not own this course or it does not exist.';
$_errors[AT_ERROR_CSV_FAILED]='Unable to create %1 CSV file.';
$_errors[AT_ERROR_EXPORTDIR_FAILED]='Unable to create export directory.';
$_errors[AT_ERRORS_TARFILE_FAILED]='Unable to create tar archive.';
$_errors[AT_ERROR_TARGZFILE_FAILED]='Unable to create tar.gz archive.';
$_errors[AT_ERROR_IMPORTDIR_FAILED]='Unable to create import directory';
$_errors[AT_ERROR_IMPORTFILE_EMPTY]='The import file must not be empty.';
$_errors[AT_ERROR_NO_QUESTIONS]='No questions were found for this test.';
$_errors[AT_ERROR_NODELETE_USER]='Cannot delete this user because they own courses. Delete the courses first.';
$_errors[AT_ERRORS_TRACKING_NOT_DELETED]='Course tracking data could not be deleted. Possibly reasons: there is no tracking data for this course, or you do not have permission.';
$_errors[AT_ERRORS_TRACKING_NOT_DELETED]='Theme not found.';
$_errors[AT_ERROR_CPREFS_NOT_FOUND]='No Preference settings were found for this course';
$_errors[AT_ERROR_THEME_NOT_FOUND] = 'Theme not found.';
$_errors[AT_ERROR_CANNOT_OPEN_DIR] = 'Unable to open content directory.';

$_errors[AT_ERROR_NO_SPACE_LEFT] = 'There is no more space in this course to extract this archive.';

$_errors[AT_ERROR_CANNOT_OVERWRITE_FILE] = 'Cannot override file.';

$_errors[AT_ERROR_LINK_CAT_NOT_EMPTY] = 'Link category cannot be deleted because it contains sub-categories.';

$_errors[AT_ERROR_NO_CONTENT_SPACE] = 'Not enough space to import content directory.';

$_errors[AT_ERROR_INVALID_MIN_GRADE] = 'Invalid minimal mark. You must specify the minimal mark required to pass the test.';
$_errors[AT_ERROR_MANDATORY_FIELDS] = 'Please complete all mandatory fields.';
$_errors[AT_ERROR_NOT_ENROLLED] = 'The selected user is not enrolled to this course.';

$_errors[AT_ERROR_MAX_STUD_REACHED] = 'Maximum number of students already enrolled to this course. Please contact course instructor.';

// translation
$_errors[AT_ERROR_USER_ALREADY_LOGGEDIN] = 'User already logged in.';
$_errors[AT_ERROR_SQL_BAD_DEFINITION] = 'SQL Not properly defined. Please rebuild your query.';
$_errors[AT_ERROR_DYNAMIC_GROUP] = 'Dynamic group update error. Please check your dynamic group sql query.';
$_errors[AT_ERROR_USER_LICENSES_LIMIT] = 'Maximum number of users has been reached. For additional licenses please contact: <a href="mailto: ">KONCEPT</a>';
$_errors[AT_ERROR_FIRST_NAME_MISSING] = 'First name is missing. Please complete all required fields.';
$_errors[AT_ERROR_LAST_NAME_MISSING] = 'Last name is missing. Please complete all required fields';
$_errors[AT_ERROR_NO_REPORT_COLUMNS] = 'There are no report columns defined.';
?>