<?php
// File : english.lang.php3
// Original file by Nicolas Hoizey <nhoizey@phpheaven.net>

// extra header for charset
$Charset = "iso-8859-1";

// medium font size in pt.
$FontSize = 10;

// welcome page
define("L_TUTORIAL", "Tutorial");

define("L_WEL_1", "Messages are deleted after");
define("L_WEL_2", "hours and usernames after");
define("L_WEL_3", "minutes ...");

define("L_CUR_1", "There are currently");
define("L_CUR_2", "in the chat.");
define("L_CUR_3", "Users currently in the chat rooms");
define("L_CUR_4", "users in private rooms");

define("L_SET_1", "Please set ...");
define("L_SET_2", "your username");
define("L_SET_3", "the number of messages to display");
define("L_SET_4", "the timeout between each update");
define("L_SET_5", "Select a chat room ...");
define("L_SET_6", "default rooms");
define("L_SET_7", "Make your choice ...");
define("L_SET_8", "public rooms created by users");
define("L_SET_9", "create your own");
define("L_SET_10", "public");
define("L_SET_11", "private");
define("L_SET_12", "room");
define("L_SET_13", "Then, just");
define("L_SET_14", "chat");

define("L_SRC", "is freely available on");

define("L_SECS", "seconds");
define("L_MIN", "minute");
define("L_MINS", "minutes");

// registration stuff:
define("L_REG_1", "your password");
define("L_REG_1r", "(only if you are registered)");
define("L_REG_2", "Account management");
define("L_REG_3", "Register");
define("L_REG_4", "Edit your profile");
define("L_REG_5", "Delete user");
define("L_REG_6", "User registration");
define("L_REG_7", "your password");
define("L_REG_8", "your e-mail");
define("L_REG_9", "You have successfully registered.");
define("L_REG_10", "Back");
define("L_REG_11", "Editing");
define("L_REG_12", "Modifying user's informations");
define("L_REG_13", "Deleting user");
define("L_REG_14", "Login");
define("L_REG_15", "Log In");
define("L_REG_16", "Change");
define("L_REG_17", "Your profile was successfully updated.");
define("L_REG_18", "You have been kicked out of the room by a moderator.");
define("L_REG_19", "Do you really want to be removed ?");
define("L_REG_20", "Yes");
define("L_REG_21", "You have been successfully removed.");
define("L_REG_22", "No");
define("L_REG_25", "Close");
define("L_REG_30", "firstname");
define("L_REG_31", "lastname");
define("L_REG_32", "WEB");
define("L_REG_33", "show e-mail in public information");
define("L_REG_34", "Editing user profile");
define("L_REG_35", "Administration");
define("L_REG_36", "spoken languages");
define("L_REG_37", "Fields with a <span class=\"error\">*</span> must be completed.");
define("L_REG_39", "The room you were in has been removed by the administrator.");
define("L_REG_45", "gender");
define("L_REG_46", "male");
define("L_REG_47", "Female");

// e-mail validation stuff
define("L_EMAIL_VAL_1", "Your settings to enter the chat");
define("L_EMAIL_VAL_2", "Welcome to our chat server.");
define("L_EMAIL_VAL_Err", "Internal error, please contact the administrator: <a href=\"mailto:%s\">%s</a>.");
define("L_EMAIL_VAL_Done", "Your password has been sent to your<BR>e-mail address.");

// admin stuff
define("L_ADM_1", "%s is no longer a moderator for this room.");
define("L_ADM_2", "You're no longer a registered user.");

// error messages
define("L_ERR_USR_1", "This username is already in use. Please chose another.");
define("L_ERR_USR_2", "You must chose a username.");
define("L_ERR_USR_3", "This username is registered. Please type your password or chose another username.");
define("L_ERR_USR_4", "You typed a incorrect password.");
define("L_ERR_USR_5", "You must type your username.");
define("L_ERR_USR_6", "You must type your password.");
define("L_ERR_USR_7", "You must type your e-mail.");
define("L_ERR_USR_8", "You must type a correct e-mail address.");
define("L_ERR_USR_9", "This username is already in use.");
define("L_ERR_USR_10", "Wrong username or password.");
define("L_ERR_USR_11", "You must be administrator.");
define("L_ERR_USR_12", "You are the administrator, so you cannot be removed.");
define("L_ERR_USR_13", "To create your own room you must be registered.");
define("L_ERR_USR_14", "You must be registered before chatting.");
define("L_ERR_USR_15", "You must type your full name.");
define("L_ERR_USR_16", "Username cannot contain spaces, commas or backslashes (\\).");
define("L_ERR_USR_17", "This room doesn't exist, and you are not allowed to create one.");
define("L_ERR_USR_18", "Banished word found in your username.");
define("L_ERR_USR_19", "You cannot be in more than one room at the same time.");
define("L_ERR_USR_20", "You have been banished from this room or from the chat.");
define("L_ERR_ROM_1", "Room's name cannot contain commas or backslashes (\\).");
define("L_ERR_ROM_2", "Banished word found in the room's name you want to create.");
define("L_ERR_ROM_3", "This room already exists as a public one.");
define("L_ERR_ROM_4", "Invalid room name.");

// users frame or popup
define("L_EXIT", "Exit");
define("L_DETACH", "Detach");
define("L_EXPCOL_ALL", "Expand/Collapse All");
define("L_CONN_STATE", "Connection state");
define("L_CHAT", "Chat");
define("L_USER", "user");
define("L_USERS", "users");
define("L_NO_USER", "No user");
define("L_ROOM", "room");
define("L_ROOMS", "rooms");
define("L_EXPCOL", "Expand/Collapse room");
define("L_BEEP", "Beep/no beep at user entrance");
define("L_PROFILE", "Display profile");
define("L_NO_PROFILE", "No profile");

// input frame
define("L_HLP", "Help");
define("L_BAD_CMD", "This is not a valid command!");
define("L_ADMIN", "%s is already the administrator!");
define("L_IS_MODERATOR", "%s is already a moderator!");
define("L_NO_MODERATOR", "Only a moderator of this room can use this command.");
define("L_MODERATOR", "%s is now a moderator for this room.");
define("L_NONEXIST_USER", "User %s isn't in the current room.");
define("L_NONREG_USER", "User %s isn't registered.");
define("L_NONREG_USER_IP", "His IP is: %s.");
define("L_NO_KICKED", "User %s is a moderator or the administrator and can't be kicked away.");
define("L_KICKED", "User %s has successfully been kicked away.");
define("L_NO_BANISHED", "User %s is a moderator or the administrator and can't be banished.");
define("L_BANISHED", "User %s has successfully been banished.");
define("L_SVR_TIME", "Server time: ");
define("L_NO_SAVE", "No message to save!");
define("L_NO_ADMIN", "Only the administrator can use this command.");
define("L_ANNOUNCE", "ANNOUNCE");
define("L_INVITE", "%s requests that you join her/him into the <a href=\"#\" onClick=\"window.parent.runCmd('%s','%s')\">%s</a> room.");
define("L_INVITE_REG", " You have to be registered to enter this room.");
define("L_INVITE_DONE", "Your invitation has been sent to %s.");
define("L_OK", "Send");

// help popup
define("L_HELP_TIT_1", "Smilies");
define("L_HELP_TIT_2", "Text formating for messages");
define("L_HELP_FMT_1", "You can put bold, italic or underlined text in messages by encasing the applicable sections of your text with either the &lt;B&gt; &lt;/B&gt;, &lt;I&gt; &lt;/I&gt; or &lt;U&gt; &lt;/U&gt; tags.<BR>For example, &lt;B&gt;this text&lt;/B&gt; will produce <B>this text</B>.");
define("L_HELP_FMT_2", "To create a hyperlink (for e-mail or URL) in your message, simply type the corresponding address without any tag. The hyperlink will be created automatically.");
define("L_HELP_TIT_3", "Commands");
define("L_HELP_USR", "user");
define("L_HELP_MSG", "message");
define("L_HELP_ROOM", "room");
define("L_HELP_CMD_0", "{} represents a required setting, [] an optional one.");
define("L_HELP_CMD_1a", "Set number of messages to show. Minimum and default are 5.");
define("L_HELP_CMD_1b", "Reload the messages frame and display the n latest messages, minimum and default are 5.");
define("L_HELP_CMD_2a", "Modify messages list refresh delay (in seconds).<BR>If n is not specified or less than 3, toggles between no refresh and 10s refresh.");
define("L_HELP_CMD_2b", "Modify messages and users lists refresh delay (in seconds).<BR>If n is not specified or less than 3, toggles between no refresh and 10s refresh.");
define("L_HELP_CMD_3", "Inverts messages order.");
define("L_HELP_CMD_4", "Join another room, creating it if it doesn't exist and if you're allowed to.<BR>n equals 0 for private and 1 for public, default to 1 if not specified.");
define("L_HELP_CMD_5", "Leave the chat after displaying an optionnal message.");
define("L_HELP_CMD_6", "Avoid diplaying messages from an user if nick is specified.<BR>Set ignoring off for an user when nick and - are both specified, for all users when - is but not nick.<BR>With no option, this command pops up a window that shows all ignored nicks.");
define("L_HELP_CMD_7", "Recall the previous text typed (command or message).");
define("L_HELP_CMD_8", "Show/Hide time before messages.");
define("L_HELP_CMD_9", "Kick away user from the chat. This command can only be used by a moderator.");
define("L_HELP_CMD_10", "Send a private message to the specified user (other users won't see it).");
define("L_HELP_CMD_11", "Show informations about specified user.");
define("L_HELP_CMD_12", "Popup window for editing user's profile.");
define("L_HELP_CMD_13", "Toggles notifications of user entrance/exit for the current room.");
define("L_HELP_CMD_14", "Allow the administrator or moderator(s) of the curent room to promote another registered user to moderator for the same room.");
define("L_HELP_CMD_15", "Clear the messages frame and show only the last 5 messages.");
define("L_HELP_CMD_16", "Save the last n messages (notifications ones excluded) to an HTML file. If n is not specified, all available messages will be taken into account.");
define("L_HELP_CMD_17", "Allow the administrator to send an announcement to all users in all chat rooms.");
define("L_HELP_CMD_18", "Invite an user chatting in an other room join the one you are in.");
define("L_HELP_CMD_19", "Allow the moderator(s) of a room or the administrator to \"banish\" an user from the room for a time defined by the administrator.<BR>The later can banish an user chatting in an other room than the one he is into and use the '<B>&nbsp;*&nbsp;</B>' setting to banish \"for ever\" an user from the chat as the whole.");
define("L_HELP_CMD_20", "Describe what you're doing without refer yourself.");

// messages frame
define("L_NO_MSG", "There is currently no message ...");
define("L_TODAY_DWN", "The messages that have been sent today start below");
define("L_TODAY_UP", "The messages that have been sent today start above");

// message colors
$TextColors = array(	"Black" => "#000000",
				"Red" => "#FF0000",
				"Green" => "#009900",
				"Blue" => "#0000FF",
				"Purple" => "#9900FF",
				"Dark red" => "#990000",
				"Dark green" => "#006600",
				"Dark blue" => "#000099",
				"Maroon" => "#996633",
				"Aqua blue" => "#006699",
				"Carrot" => "#FF6600");

// ignored popup
define("L_IGNOR_TIT", "Ignored");
define("L_IGNOR_NON", "No ignored user");

// whois popup
define("L_WHOIS_ADMIN", "Administrator");
define("L_WHOIS_MODER", "Moderator");
define("L_WHOIS_USER", "User");

// Notification messages of user entrance/exit
define("L_ENTER_ROM", "%s enters this room");
define("L_EXIT_ROM", "%s exits from this room");
?>