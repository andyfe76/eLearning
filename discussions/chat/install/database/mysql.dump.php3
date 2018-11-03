<?php

// ----- TABLES CREATION -----

$Create_Tab[0] = "
CREATE TABLE ${C_MSG_TBL} (
   type tinyint(1) DEFAULT '0' NOT NULL,
   room varchar(30) NOT NULL,
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   m_time int(11) DEFAULT '0' NOT NULL,
   address varchar(30) NOT NULL,
   message text NOT NULL
)
";

$Create_Tab[1] = "
CREATE TABLE ${C_USR_TBL} (
   room varchar(30) NOT NULL,
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   u_time int(11) DEFAULT '0' NOT NULL,
   status varchar(1) NOT NULL,
   ip varchar(16) NOT NULL,
   UNIQUE room (room, username)
)
";

$Create_Tab[2] = "
CREATE TABLE ${C_REG_TBL} (
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   password varchar(32) NOT NULL,
   firstname varchar(64) NOT NULL,
   lastname varchar(64) NOT NULL,
   country varchar(64) NOT NULL,
   website varchar(64) NOT NULL,
   email varchar(64) NOT NULL,
   showemail tinyint(1) NOT NULL,
   perms varchar(9) NOT NULL,
   rooms varchar(128) NOT NULL,
   reg_time int(11) DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   gender tinyint(1) DEFAULT '0' NOT NULL
)
";

$Create_Tab[3] = "
CREATE TABLE ${C_BAN_TBL} (
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   rooms varchar(100) NOT NULL,
   ban_until int(11) DEFAULT '0' NOT NULL
)
";


// ----- TABLES UPDATES FROM OLDER VERSION THAN 0.13.? -----

// Message table
$Upd1_Tab[0] = "
ALTER TABLE ${C_MSG_TBL}
  CHANGE type type tinyint(1) DEFAULT '0' NOT NULL,
  CHANGE latin1 latin1 tinyint(1) DEFAULT '0' NOT NULL
";

// Users table
$Upd1_Tab[1] = "
ALTER TABLE ${C_USR_TBL}
  CHANGE latin1 latin1 tinyint(1) DEFAULT '0' NOT NULL,
  ADD status varchar(1) NOT NULL,
  ADD ip varchar(16) NOT NULL
";

// Registred users table
$Upd1_Tab[2] = "
ALTER TABLE ${C_REG_TBL}
  CHANGE latin1 latin1 tinyint(1) DEFAULT '0' NOT NULL,
  CHANGE showemail showemail tinyint(1) NOT NULL,
  CHANGE perms perms varchar(9) NOT NULL,
  ADD reg_time int(11) DEFAULT '0' NOT NULL,
  ADD ip varchar(16) NOT NULL,
  ADD gender tinyint(1) DEFAULT '0' NOT NULL
";
$Upd1_Tab[3] = "
UPDATE ${C_REG_TBL} SET reg_time =".time()." 
";

// Banished users table
$Upd1_Tab[4] = "
CREATE TABLE ${C_BAN_TBL} (
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   rooms varchar(100) NOT NULL,
   ban_until int(11) DEFAULT '0' NOT NULL
)
";


// ----- TABLES UPDATES FROM VERSION 0.13.? -----

// Users table
$Upd2_Tab[1] = "
ALTER TABLE ${C_USR_TBL}
  ADD ip varchar(16) NOT NULL
";

// Registred users table
$Upd2_Tab[2] = "
ALTER TABLE ${C_REG_TBL}
  ADD ip varchar(16) NOT NULL,
  ADD gender tinyint(1) DEFAULT '0' NOT NULL
";

// Banished users table
$Upd2_Tab[3] = "
CREATE TABLE ${C_BAN_TBL} (
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   rooms varchar(100) NOT NULL,
   ban_until int(11) DEFAULT '0' NOT NULL
)
";


// ----- PROFILE FOR ADMIN CREATION -----

$Create_Adm = "INSERT INTO ${C_REG_TBL} VALUES ('${ADM_LOG}', '', '${admin_pwd}', '${ADM_FNAME}', '${ADM_LNAME}', '${ADM_LANG}', '${ADM_WEB}', '${ADM_EMAIL}', '${SHOWEMAIL}', 'admin', '', ".time().", '${IP}', '${ADM_GENDER}')";
?>