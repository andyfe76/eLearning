DROP TABLE IF EXISTS c_messages;
CREATE TABLE c_messages (
   type tinyint(1) DEFAULT '0' NOT NULL,
   room varchar(30) NOT NULL,
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   m_time int(11) DEFAULT '0' NOT NULL,
   address varchar(30) NOT NULL,
   message text NOT NULL
);


DROP TABLE IF EXISTS c_users;
CREATE TABLE c_users (
   room varchar(30) NOT NULL,
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   u_time int(11) DEFAULT '0' NOT NULL,
   status varchar(1) NOT NULL,
   ip varchar(16) NOT NULL,
   UNIQUE room (room, username)
);


DROP TABLE IF EXISTS c_reg_users;
CREATE TABLE c_reg_users (
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
);
INSERT INTO c_reg_users VALUES('admin', '', '21232f297a57a5a743894a0e4a801fc3', '', '', '', '', '', 0, 'admin', '', '', '', '');

DROP TABLE IF EXISTS c_ban_users;
CREATE TABLE c_ban_users (
   username varchar(30) NOT NULL,
   latin1 tinyint(1) DEFAULT '0' NOT NULL,
   ip varchar(16) NOT NULL,
   rooms varchar(100) NOT NULL,
   ban_until int(11) DEFAULT '0' NOT NULL
);