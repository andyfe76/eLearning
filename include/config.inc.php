<?php

/* Edit only the values below:									*/

/* the database user name										*/
define('DB_USER',		'');

/* the database password										*/
define('DB_PASSWORD',	'');	

/* the database host											*/
define('DB_HOST',		'');

/* the database name											*/
define('DB_NAME',		'');

/* your (klore system admin) password to let you add			*/
/* new instructors												*/
define('ADMIN_PASSWORD', 'admin');

/* yourIIS														*/
define('SERVER_IIS', 'http://amio/K-Lore%20reports');

/* your (admin) email address									*/
define('ADMIN_EMAIL',	'');

/* do you want to receive emails when new instructor accounts	*/
/* require approval												*/
define('EMAIL_NOTIFY',	 true);

/* allow regular account users to request their account to be	*/
/* upgraded to instructor accounts.								*/
define('ALLOW_INSTRUCTOR_REQUESTS',	 false);

/* If ALLOW_INSTRUCTOR_REQUESTS is true then you can have the	*/
/* requests approved instantly, otherwise each request will		*/
/* have to be approved manually by the admin.					*/
define('AUTO_APPROVE_INSTRUCTORS',	 false);

/* File manager options:										*/

/* Maximum allowable file size in Bytes to upload:				*/
/* Will not override the upload_max_filesize in php.ini			*/
$MaxFileSize   =  512000;	/* 500 KB */

/* Total maximum allowable course size in Bytes:				*/
$MaxCourseSize = 5242880;	/* 5 MB   */

/* Illegal file types, by extension. Include any extensions		*/
/* you do not want to allow for uploading. (Just the extention	*/
/* without the leading dot.)									*/
$IllegalExtentions	= array('exe', 'asp', 'php', 'bat', 'cgi', 'pl');

/* Allow instructors to import the course content directory		*/
/* from the tar.gz exported file. This option to disable the importing */
/* of the content directory was added as a security	concern.	*/
/* As of version 1.0 the file manager is a much more secure way */
/* of uploading course content.									*/
define('ALLOW_IMPORT_CONTENT',	 true);


/* The name of your course website.								*/
/* Example: Acme University's Course Server						*/
/* Double quotes will have to be escaped with a slash: \".		*/
define('SITE_NAME',	"KONCEPT Learning Server");

?>
