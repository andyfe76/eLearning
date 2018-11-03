<?php
require('../../include/vitals.inc.php');
// Database settings
define("C_DB_TYPE", 'mysql');
define("C_DB_HOST", 'localhost');
define("C_DB_NAME", DB_NAME);
define("C_DB_USER", DB_USER);
define("C_DB_PASS", DB_PASSWORD);
define("C_MSG_TBL", 'c_messages');
define("C_USR_TBL", 'c_users');
define("C_REG_TBL", 'c_reg_users');
define("C_BAN_TBL", 'c_ban_users');

// Cleaning settings for messages and usernames
define("C_MSG_DEL", '48');
define("C_USR_DEL", '120');
define("C_REG_DEL", '0');

// Proposed rooms
$DefaultChatRooms = array('Default', 'klore 1', 'klore 2');
$DefaultPrivateRooms = array('Priv1', 'Priv2');

// Language settings
define("C_LANGUAGE", 'english');
define("C_MULTI_LANG", '1');

// Registration of users
define("C_REQUIRE_REGISTER", '0');
define("C_EMAIL_PASWD", '0');

// Security and restriction settings
define("C_SHOW_ADMIN", '1');
define("C_SHOW_DEL_PROF", '0');
define("C_VERSION", '2');
define("C_BANISH", '0.02');
define("C_NO_SWEAR", '1');
define("C_SAVE", '*');

// Messages enhancements
define("C_USE_SMILIES", '1');
define("C_HTML_TAGS_KEEP", 'simple');
define("C_HTML_TAGS_SHOW", '1');

// Default display seetings
define("C_TMZ_OFFSET", '0');
define("C_MSG_ORDER", '0');
define("C_MSG_NB", '40');
define("C_MSG_REFRESH", '');
define("C_SHOW_TIMESTAMP", '1');
define("C_NOTIFY", '1');
define("C_WELCOME", '1');
?>
