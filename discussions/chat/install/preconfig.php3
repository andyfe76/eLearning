<?php

echo("<?php\n");
?>
// Database settings
define("C_DB_TYPE", '<?php echo(stripslashes($C_DB_TYPE)); ?>');
define("C_DB_HOST", '<?php echo(stripslashes($C_DB_HOST)); ?>');
define("C_DB_NAME", '<?php echo(stripslashes($C_DB_NAME)); ?>');
define("C_DB_USER", '<?php echo(stripslashes($C_DB_USER)); ?>');
define("C_DB_PASS", '*** Complete here ***');
define("C_MSG_TBL", '<?php echo(stripslashes($C_MSG_TBL)); ?>');
define("C_USR_TBL", '<?php echo(stripslashes($C_USR_TBL)); ?>');
define("C_REG_TBL", '<?php echo(stripslashes($C_REG_TBL)); ?>');
define("C_BAN_TBL", '<?php echo(stripslashes($C_BAN_TBL)); ?>');

// Cleaning settings for messages and usernames
define("C_MSG_DEL", '<?php echo($C_MSG_DEL); ?>');
define("C_USR_DEL", '<?php echo($C_USR_DEL); ?>');
define("C_REG_DEL", '<?php echo($C_REG_DEL); ?>');

// Proposed rooms
<?php
$R0 = "'".str_replace(",","', '",$C_PUB_CHAT_ROOMS)."'";
?>
$DefaultChatRooms = array(<?php echo($R0); ?>);
<?php
$R0 = ($C_PRIV_CHAT_ROOMS != "" ? "'".str_replace(",","', '",$C_PRIV_CHAT_ROOMS)."'" : "");
?>
$DefaultPrivateRooms = array(<?php echo($R0); ?>);

// Language settings
define("C_LANGUAGE", '<?php echo($C_LANGUAGE); ?>');
define("C_MULTI_LANG", '<?php echo($C_MULTI_LANG); ?>');

// Registration of users
define("C_REQUIRE_REGISTER", '<?php echo($C_REQUIRE_REGISTER); ?>');
define("C_EMAIL_PASWD", '<?php echo($C_EMAIL_PASWD); ?>');

// Security and restriction settings
define("C_SHOW_ADMIN", '<?php echo($C_SHOW_ADMIN); ?>');
define("C_SHOW_DEL_PROF", '<?php echo($C_SHOW_DEL_PROF); ?>');
define("C_VERSION", '<?php echo($C_VERSION); ?>');
define("C_BANISH", '<?php echo($C_BANISH); ?>');
define("C_NO_SWEAR", '<?php echo($C_NO_SWEAR); ?>');
define("C_SAVE", '<?php echo($C_SAVE); ?>');

// Messages enhancements
define("C_USE_SMILIES", '<?php echo($C_USE_SMILIES); ?>');
define("C_HTML_TAGS_KEEP", '<?php echo($C_HTML_TAGS_KEEP); ?>');
define("C_HTML_TAGS_SHOW", '<?php echo($C_HTML_TAGS_SHOW); ?>');

// Default display seetings
define("C_TMZ_OFFSET", '<?php echo($C_TMZ_OFFSET); ?>');
define("C_MSG_ORDER", '<?php echo($C_MSG_ORDER); ?>');
define("C_MSG_NB", '<?php echo($C_MSG_NB); ?>');
define("C_MSG_REFRESH", '<?php echo($C_MSG_REFRESH); ?>');
define("C_SHOW_TIMESTAMP", '<?php echo($C_SHOW_TIMESTAMP); ?>');
define("C_NOTIFY", '<?php echo($C_NOTIFY); ?>');
define("C_WELCOME", '<?php echo($C_WELCOME); ?>');
<?php
echo("?>");

?>