<?php
function pgsql_cleanstr($str) {
    $str = str_replace("\r", "", $str);
    $str = str_replace("\n", " ", $str);
    return $str;
}


// ----- TABLES CREATION -----

$Create_Tab[0] = pgsql_cleanstr("
CREATE TABLE ${C_MSG_TBL} (
   type int2 DEFAULT '0' NOT NULL,
   room varchar(30) NOT NULL,
   username varchar(30) NOT NULL,
   latin1 int2 DEFAULT '0' NOT NULL,
   m_time int4 DEFAULT '0' NOT NULL,
   address varchar(30) NOT NULL,
   message text NOT NULL
)"
);

$Create_Tab[1] = pgsql_cleanstr("
CREATE TABLE ${C_USR_TBL} (
   room varchar(30) NOT NULL,
   username varchar(30) NOT NULL,
   latin1 int2 DEFAULT '0' NOT NULL,
   u_time int4 DEFAULT '0' NOT NULL,
   status varchar(1) NOT NULL,
   ip varchar(16) NOT NULL
)"
);

$Create_Tab[2] = pgsql_cleanstr("
CREATE TABLE ${C_REG_TBL} (
   username varchar(30) NOT NULL UNIQUE,
   latin1 int2 DEFAULT '0' NOT NULL,
   password varchar(32) NOT NULL,
   firstname varchar(64) NOT NULL,
   lastname varchar(64) NOT NULL,
   country varchar(64) NOT NULL,
   website varchar(64) NOT NULL,
   email varchar(64) NOT NULL,
   showemail int2 NOT NULL,
   perms varchar(9) NOT NULL,
   rooms varchar(128) NOT NULL,
   reg_time int4 DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   gender int2 DEFAULT '0' NOT NULL
)"
);

$Create_Tab[3] = pgsql_cleanstr("
CREATE TABLE ${C_BAN_TBL} (
   username varchar(30) NOT NULL,
   latin1 int2 DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   rooms varchar(100) NOT NULL,
   ban_until int4 DEFAULT '0' NOT NULL
)"
);


// ----- TABLES UPDATES FROM OLDER VERSION THAN 0.13.? -----

// Message table

$Upd1_Tab[] = pgsql_cleanstr("SELECT type::int2 AS \"type\", room, username, latin1::int2 AS \"latin1\", m_time, address, message INTO __phpmychat_tmp FROM ${C_MSG_TBL}
");
$Upd1_Tab[] = pgsql_cleanstr("DROP TABLE ${C_MSG_TBL}
");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp RENAME TO ${C_MSG_TBL}");

// Users table

$Upd1_Tab[] = pgsql_cleanstr("SELECT room, username, latin1::int2 AS \"latin1\", u_time INTO __phpmychat_tmp FROM ${C_USR_TBL}
");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD status varchar(1) NOT NULL");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD ip varchar(16) NOT NULL");
$Upd1_Tab[] = pgsql_cleanstr("DROP TABLE ${C_USR_TBL}
");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp RENAME TO ${C_USR_TBL}");

// Registered users table

$Upd1_Tab[] = pgsql_cleanstr("SELECT username, latin1::int2 AS \"latin1\", password, firstname, lastname, country, website, email, showemail::int2 AS \"showemail\", perms, rooms INTO __phpmychat_tmp FROM ${C_REG_TBL}
");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD reg_time int4 DEFAULT '0' NOT NULL");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD ip varchar(16) NOT NULL");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD gender tinyint(1) DEFAULT '0' NOT NULL");
$Upd1_Tab[] = pgsql_cleanstr("DROP TABLE ${C_REG_TBL}
");
$Upd1_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp RENAME TO ${C_REG_TBL}");

// Banished users table

$Upd1_Tab[] = pgsql_cleanstr("
CREATE TABLE ${C_BAN_TBL} (
   username varchar(30) NOT NULL,
   latin1 int2 DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   rooms varchar(100) NOT NULL,
   ban_until int4 DEFAULT '0' NOT NULL
)"
);


// ----- TABLES UPDATES FROM VERSIONS 0.13.? -----

// Users table

$Upd2_Tab[] = pgsql_cleanstr("SELECT * INTO __phpmychat_tmp FROM ${C_USR_TBL}
");
$Upd2_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD ip varchar(16) NOT NULL");
$Upd2_Tab[] = pgsql_cleanstr("DROP TABLE ${C_USR_TBL}
");
$Upd2_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp RENAME TO ${C_USR_TBL}");

// Registered users table

$Upd2_Tab[] = pgsql_cleanstr("SELECT * INTO __phpmychat_tmp FROM ${C_REG_TBL}
");
$Upd2_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD ip varchar(16) NOT NULL AFTER password");
$Upd2_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp ADD gender tinyint(1) DEFAULT '0' NOT NULL");
$Upd2_Tab[] = pgsql_cleanstr("DROP TABLE ${C_REG_TBL}
");
$Upd2_Tab[] = pgsql_cleanstr("ALTER TABLE __phpmychat_tmp RENAME TO ${C_REG_TBL}");

// Banished users table

$Upd2_Tab[] = pgsql_cleanstr("
CREATE TABLE ${C_BAN_TBL} (
   username varchar(30) NOT NULL,
   latin1 int2 DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   rooms varchar(100) NOT NULL,
   ban_until int4 DEFAULT '0' NOT NULL
)"
);


// ----- PROFILE FOR ADMIN CREATION -----

$Create_Adm = "INSERT INTO ${C_REG_TBL} VALUES ('${ADM_LOG}', '', '${admin_pwd}', '${ADM_FNAME}', '${ADM_LNAME}', '${ADM_LANG}', '${ADM_WEB}', '${ADM_EMAIL}', '${SHOWEMAIL}', 'admin', '', ".time().", '${IP}', '${ADM_GENDER}')";
?>