# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Nov 22, 2003 at 05:43 PM
# Server version: 4.0.12
# PHP Version: 4.3.1
# Database : `klore`
# --------------------------------------------------------

#
# Table structure for table `c_ban_users`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 17, 2003 at 01:17 PM
#

CREATE TABLE `c_ban_users` (
  `username` varchar(30) NOT NULL default '',
  `latin1` tinyint(1) NOT NULL default '0',
  `ip` varchar(16) NOT NULL default '',
  `rooms` varchar(100) NOT NULL default '',
  `ban_until` int(11) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `c_messages`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 20, 2003 at 02:35 PM
# Last check: Nov 20, 2003 at 02:15 PM
#

CREATE TABLE `c_messages` (
  `type` tinyint(1) NOT NULL default '0',
  `room` varchar(30) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `latin1` tinyint(1) NOT NULL default '0',
  `m_time` int(11) NOT NULL default '0',
  `address` varchar(30) NOT NULL default '',
  `message` text NOT NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `c_reg_users`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 17, 2003 at 01:17 PM
#

CREATE TABLE `c_reg_users` (
  `username` varchar(30) NOT NULL default '',
  `latin1` tinyint(1) NOT NULL default '0',
  `password` varchar(32) NOT NULL default '',
  `firstname` varchar(64) NOT NULL default '',
  `lastname` varchar(64) NOT NULL default '',
  `country` varchar(64) NOT NULL default '',
  `website` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `showemail` tinyint(1) NOT NULL default '0',
  `perms` varchar(9) NOT NULL default '',
  `rooms` varchar(128) NOT NULL default '',
  `reg_time` int(11) NOT NULL default '0',
  `ip` varchar(16) NOT NULL default '',
  `gender` tinyint(1) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `c_users`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 20, 2003 at 02:35 PM
# Last check: Nov 20, 2003 at 02:15 PM
#

CREATE TABLE `c_users` (
  `room` varchar(30) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `latin1` tinyint(1) NOT NULL default '0',
  `u_time` int(11) NOT NULL default '0',
  `status` char(1) NOT NULL default '',
  `ip` varchar(16) NOT NULL default '',
  UNIQUE KEY `room` (`room`,`username`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `content`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 22, 2003 at 04:43 PM
# Last check: Nov 22, 2003 at 04:13 PM
#

CREATE TABLE `content` (
  `content_id` int(10) unsigned NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `content_parent_id` int(10) unsigned NOT NULL default '0',
  `ordering` tinyint(4) NOT NULL default '0',
  `last_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `revision` tinyint(3) unsigned NOT NULL default '0',
  `formatting` tinyint(4) NOT NULL default '0',
  `release_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(150) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`content_id`),
  KEY `course_id` (`course_id`)
) TYPE=MyISAM AUTO_INCREMENT=219 ;
# --------------------------------------------------------

#
# Table structure for table `course_availability`
#
# Creation: Jul 23, 2003 at 04:16 PM
# Last update: Nov 13, 2003 at 11:23 AM
#

CREATE TABLE `course_availability` (
  `course_id` mediumint(9) NOT NULL default '0',
  `start_date` datetime default '0000-00-00 00:00:00',
  `end_date` datetime default '0000-00-00 00:00:00',
  `period` mediumint(9) default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `course_custom_fields`
#
# Creation: Jul 08, 2003 at 11:56 PM
# Last update: Aug 09, 2003 at 02:32 AM
#

CREATE TABLE `course_custom_fields` (
  `id` mediumint(9) NOT NULL default '0',
  `name` varchar(64) default NULL,
  `mandatory` tinyint(4) default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `course_enrollment`
#
# Creation: Jul 19, 2003 at 02:46 PM
# Last update: Nov 22, 2003 at 03:43 PM
#

CREATE TABLE `course_enrollment` (
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `approved` enum('y','n') NOT NULL default 'n',
  `enrolltime` datetime NOT NULL default '0000-00-00 00:00:00',
  `approvetime` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`member_id`,`course_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `course_groups`
#
# Creation: Jul 24, 2003 at 01:17 AM
# Last update: Oct 27, 2003 at 01:53 PM
#

CREATE TABLE `course_groups` (
  `group_id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '0',
  `comments` varchar(32) default NULL,
  PRIMARY KEY  (`group_id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
# --------------------------------------------------------

#
# Table structure for table `course_maxstud`
#
# Creation: Nov 22, 2003 at 01:58 PM
# Last update: Nov 22, 2003 at 03:30 PM
#

CREATE TABLE `course_maxstud` (
  `course_id` mediumint(9) NOT NULL default '0',
  `max_stud` mediumint(9) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `course_options`
#
# Creation: Jul 12, 2003 at 07:29 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `course_options` (
  `type` varchar(32) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `selected` mediumint(9) default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `course_stats`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `course_stats` (
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `login_date` date NOT NULL default '0000-00-00',
  `guests` mediumint(8) unsigned NOT NULL default '0',
  `members` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`course_id`,`login_date`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `course_type`
#
# Creation: Jun 12, 2003 at 12:21 AM
# Last update: Nov 13, 2003 at 11:23 AM
#

CREATE TABLE `course_type` (
  `course_id` mediumint(9) NOT NULL default '0',
  `course_type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`course_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `courses`
#
# Creation: Jul 09, 2003 at 08:25 PM
# Last update: Nov 22, 2003 at 04:43 PM
#

CREATE TABLE `courses` (
  `course_id` mediumint(8) unsigned NOT NULL auto_increment,
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `access` enum('public','protected','private') NOT NULL default 'public',
  `created_date` date NOT NULL default '0000-00-00',
  `title` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `notify` tinyint(4) NOT NULL default '0',
  `max_quota` varchar(30) NOT NULL default '',
  `max_file_size` varchar(30) NOT NULL default '',
  `hide` tinyint(4) NOT NULL default '0',
  `preferences` text NOT NULL,
  `header` text NOT NULL,
  `footer` text NOT NULL,
  `copyright` text NOT NULL,
  `tracking` enum('on','off') NOT NULL default 'off',
  `custom1` varchar(255) default NULL,
  `custom2` varchar(255) default NULL,
  `custom3` varchar(255) default NULL,
  `custom4` varchar(255) default NULL,
  `custom5` varchar(255) default NULL,
  `custom6` varchar(255) default NULL,
  `custom7` varchar(255) default NULL,
  `custom8` varchar(255) default NULL,
  `custom9` varchar(255) default NULL,
  `custom10` varchar(255) default NULL,
  `modif_date` datetime default NULL,
  PRIMARY KEY  (`course_id`)
) TYPE=MyISAM AUTO_INCREMENT=25 ;
# --------------------------------------------------------

#
# Table structure for table `crel_groups`
#
# Creation: Jun 01, 2003 at 02:24 AM
# Last update: Nov 13, 2003 at 11:23 AM
#

CREATE TABLE `crel_groups` (
  `course_id` mediumint(9) default NULL,
  `igroup_id` mediumint(9) default NULL,
  `group_id` mediumint(9) NOT NULL default '0',
  KEY `course_id` (`course_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `del_content`
#
# Creation: Aug 09, 2003 at 12:46 PM
# Last update: Nov 22, 2003 at 04:14 PM
# Last check: Nov 22, 2003 at 04:13 PM
#

CREATE TABLE `del_content` (
  `content_id` int(10) unsigned NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `content_parent_id` int(10) unsigned NOT NULL default '0',
  `ordering` tinyint(4) NOT NULL default '0',
  `last_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `revision` tinyint(3) unsigned NOT NULL default '0',
  `formatting` tinyint(4) NOT NULL default '0',
  `release_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(150) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`content_id`),
  KEY `course_id` (`course_id`)
) TYPE=MyISAM AUTO_INCREMENT=141 ;
# --------------------------------------------------------

#
# Table structure for table `del_courses`
#
# Creation: Aug 09, 2003 at 11:38 AM
# Last update: Nov 22, 2003 at 04:43 PM
#

CREATE TABLE `del_courses` (
  `course_id` mediumint(8) unsigned NOT NULL auto_increment,
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `access` enum('public','protected','private') NOT NULL default 'public',
  `created_date` date NOT NULL default '0000-00-00',
  `title` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `notify` tinyint(4) NOT NULL default '0',
  `max_quota` varchar(30) NOT NULL default '',
  `max_file_size` varchar(30) NOT NULL default '',
  `hide` tinyint(4) NOT NULL default '0',
  `preferences` text NOT NULL,
  `header` text NOT NULL,
  `footer` text NOT NULL,
  `copyright` text NOT NULL,
  `tracking` enum('on','off') NOT NULL default 'off',
  `custom1` varchar(255) default NULL,
  `custom2` varchar(255) default NULL,
  `custom3` varchar(255) default NULL,
  `custom4` varchar(255) default NULL,
  `custom5` varchar(255) default NULL,
  `custom6` varchar(255) default NULL,
  `custom7` varchar(255) default NULL,
  `custom8` varchar(255) default NULL,
  `custom9` varchar(255) default NULL,
  `custom10` varchar(255) default NULL,
  `modif_date` datetime default NULL,
  PRIMARY KEY  (`course_id`)
) TYPE=MyISAM AUTO_INCREMENT=22 ;
# --------------------------------------------------------

#
# Table structure for table `del_members`
#
# Creation: Aug 09, 2003 at 11:42 AM
# Last update: Oct 16, 2003 at 06:42 PM
# Last check: Aug 13, 2003 at 12:48 AM
#

CREATE TABLE `del_members` (
  `member_id` mediumint(8) unsigned NOT NULL auto_increment,
  `login` varchar(20) NOT NULL default '',
  `password` varchar(20) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `status` tinyint(4) NOT NULL default '0',
  `preferences` text NOT NULL,
  `creation_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `modif_date` datetime default NULL,
  `custom1` varchar(255) default NULL,
  `custom2` varchar(255) default NULL,
  `custom3` varchar(255) default NULL,
  `custom4` varchar(255) default NULL,
  `custom5` varchar(255) default NULL,
  `custom6` varchar(255) default NULL,
  `custom7` varchar(255) default NULL,
  `custom8` varchar(255) default NULL,
  `custom9` varchar(255) default NULL,
  `custom10` varchar(255) default NULL,
  PRIMARY KEY  (`member_id`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;
# --------------------------------------------------------

#
# Table structure for table `del_news`
#
# Creation: Aug 09, 2003 at 12:18 PM
# Last update: Nov 22, 2003 at 04:43 PM
#

CREATE TABLE `del_news` (
  `news_id` mediumint(8) unsigned NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `formatting` tinyint(4) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `body` text NOT NULL,
  PRIMARY KEY  (`news_id`)
) TYPE=MyISAM AUTO_INCREMENT=32 ;
# --------------------------------------------------------

#
# Table structure for table `dyn_columns`
#
# Creation: Nov 17, 2003 at 10:54 AM
# Last update: Nov 19, 2003 at 06:48 PM
#

CREATE TABLE `dyn_columns` (
  `id` int(11) NOT NULL auto_increment,
  `cat` text NOT NULL,
  `attr` text NOT NULL,
  `report` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=24 ;
# --------------------------------------------------------

#
# Table structure for table `dyn_definitions`
#
# Creation: Nov 17, 2003 at 10:53 AM
# Last update: Nov 17, 2003 at 12:01 PM
#

CREATE TABLE `dyn_definitions` (
  `cat` text NOT NULL,
  `attr` text NOT NULL,
  `tbl` text NOT NULL,
  `field` text NOT NULL,
  `description` text,
  `ID` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;
# --------------------------------------------------------

#
# Table structure for table `dyn_groups`
#
# Creation: Nov 17, 2003 at 10:52 AM
# Last update: Nov 22, 2003 at 01:32 AM
#

CREATE TABLE `dyn_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` text,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;
# --------------------------------------------------------

#
# Table structure for table `dyn_links`
#
# Creation: Nov 17, 2003 at 10:53 AM
# Last update: Nov 19, 2003 at 06:48 PM
#

CREATE TABLE `dyn_links` (
  `id` int(11) NOT NULL auto_increment,
  `cat1` text NOT NULL,
  `attr1` text NOT NULL,
  `cat2` text NOT NULL,
  `attr2` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=14 ;
# --------------------------------------------------------

#
# Table structure for table `dyn_operators`
#
# Creation: Nov 17, 2003 at 10:53 AM
# Last update: Nov 19, 2003 at 06:48 PM
#

CREATE TABLE `dyn_operators` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
# --------------------------------------------------------

#
# Table structure for table `dyn_query`
#
# Creation: Nov 17, 2003 at 10:52 AM
# Last update: Nov 21, 2003 at 05:26 PM
#

CREATE TABLE `dyn_query` (
  `cat` text NOT NULL,
  `attr` text NOT NULL,
  `op` text NOT NULL,
  `val` text NOT NULL,
  `report` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `function` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `report` (`report`),
  KEY `report_2` (`report`)
) TYPE=MyISAM AUTO_INCREMENT=39 ;
# --------------------------------------------------------

#
# Table structure for table `dyn_sql`
#
# Creation: Nov 20, 2003 at 04:01 PM
# Last update: Nov 22, 2003 at 01:32 AM
#

CREATE TABLE `dyn_sql` (
  `dyn_id` mediumint(9) NOT NULL default '0',
  `static_id` mediumint(9) NOT NULL default '0',
  `sqltext` mediumtext NOT NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forums`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 21, 2003 at 05:14 PM
#

CREATE TABLE `forums` (
  `forum_id` mediumint(8) unsigned NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `title` varchar(60) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`forum_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;
# --------------------------------------------------------

#
# Table structure for table `forums_accessed`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 01, 2003 at 10:09 PM
#

CREATE TABLE `forums_accessed` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `last_accessed` timestamp(14) NOT NULL,
  PRIMARY KEY  (`post_id`,`member_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forums_subscriptions`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 17, 2003 at 01:17 PM
#

CREATE TABLE `forums_subscriptions` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`,`member_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forums_threads`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Jun 12, 2003 at 12:30 AM
# Last check: Jun 12, 2003 at 12:30 AM
#

CREATE TABLE `forums_threads` (
  `post_id` mediumint(8) unsigned NOT NULL auto_increment,
  `parent_id` mediumint(8) unsigned NOT NULL default '0',
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_id` mediumint(8) unsigned NOT NULL default '0',
  `login` varchar(20) NOT NULL default '',
  `last_comment` datetime NOT NULL default '0000-00-00 00:00:00',
  `num_comments` mediumint(8) unsigned NOT NULL default '0',
  `subject` varchar(100) NOT NULL default '',
  `body` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `locked` tinyint(4) NOT NULL default '0',
  `sticky` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`post_id`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;
# --------------------------------------------------------

#
# Table structure for table `g_click_data`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `g_click_data` (
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `from_cid` int(10) unsigned NOT NULL default '0',
  `to_cid` int(10) unsigned NOT NULL default '0',
  `g` tinyint(3) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `duration` double unsigned NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `g_refs`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 17, 2003 at 01:18 PM
#

CREATE TABLE `g_refs` (
  `g_id` tinyint(4) default NULL,
  `reference` varchar(65) default NULL,
  KEY `g_id` (`g_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `glossary`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 26, 2003 at 07:12 AM
#

CREATE TABLE `glossary` (
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `word` varchar(60) NOT NULL default '',
  `definition` text NOT NULL,
  `related_word_id` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`word_id`),
  KEY `course_id` (`course_id`),
  KEY `first_letter` (`word`(1))
) TYPE=MyISAM AUTO_INCREMENT=4 ;
# --------------------------------------------------------

#
# Table structure for table `group_mng`
#
# Creation: Nov 22, 2003 at 03:53 PM
# Last update: Nov 22, 2003 at 03:53 PM
#

CREATE TABLE `group_mng` (
  `member_id` mediumint(9) NOT NULL default '0',
  `group_id` mediumint(9) NOT NULL default '0',
  `role` varchar(12) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `instructor_approvals`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 19, 2003 at 04:17 PM
#

CREATE TABLE `instructor_approvals` (
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `request_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `notes` text NOT NULL,
  PRIMARY KEY  (`member_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `learning_concepts`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 17, 2003 at 01:18 PM
#

CREATE TABLE `learning_concepts` (
  `concept_id` tinyint(3) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `tag` varchar(20) NOT NULL default '',
  `description` text NOT NULL,
  `icon_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`concept_id`)
) TYPE=MyISAM AUTO_INCREMENT=14 ;
# --------------------------------------------------------

#
# Table structure for table `m_skills`
#
# Creation: Aug 11, 2003 at 06:32 PM
# Last update: Aug 13, 2003 at 12:52 AM
#

CREATE TABLE `m_skills` (
  `member_id` mediumint(9) NOT NULL default '0',
  `skill_id` mediumint(9) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mcourse_completion`
#
# Creation: Aug 11, 2003 at 02:41 PM
# Last update: Aug 12, 2003 at 03:12 AM
#

CREATE TABLE `mcourse_completion` (
  `member_id` mediumint(9) NOT NULL default '0',
  `course_id` mediumint(9) NOT NULL default '0',
  `completed` enum('yes','no') NOT NULL default 'yes',
  `grade` mediumint(9) NOT NULL default '0',
  `max_grade` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`member_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mdyn_group`
#
# Creation: Aug 12, 2003 at 06:00 PM
# Last update: Aug 12, 2003 at 06:00 PM
#

CREATE TABLE `mdyn_group` (
  `member_id` mediumint(9) NOT NULL default '0',
  `igroup_id` mediumint(9) NOT NULL default '0',
  `group_id` mediumint(9) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `member_categ`
#
# Creation: Jul 07, 2003 at 10:17 PM
# Last update: Jul 07, 2003 at 10:23 PM
#

CREATE TABLE `member_categ` (
  `categ_id` mediumint(9) NOT NULL default '0',
  `name` varchar(32) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `member_cost`
#
# Creation: Jun 04, 2003 at 11:51 PM
# Last update: Nov 22, 2003 at 01:56 PM
#

CREATE TABLE `member_cost` (
  `mid` mediumint(9) NOT NULL default '0',
  `cost` int(11) default NULL,
  KEY `mid` (`mid`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `member_groups`
#
# Creation: Jun 18, 2003 at 02:24 PM
# Last update: Nov 22, 2003 at 01:32 AM
#

CREATE TABLE `member_groups` (
  `category` varchar(32) NOT NULL default '0',
  `group_id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `comments` varchar(32) default NULL,
  KEY `group_id` (`group_id`),
  KEY `category` (`category`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;
# --------------------------------------------------------

#
# Table structure for table `members`
#
# Creation: Jul 08, 2003 at 11:34 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `members` (
  `member_id` mediumint(8) unsigned NOT NULL auto_increment,
  `login` varchar(20) NOT NULL default '',
  `password` varchar(20) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `status` tinyint(4) NOT NULL default '0',
  `preferences` text NOT NULL,
  `creation_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `modif_date` datetime default NULL,
  `custom1` varchar(255) default NULL,
  `custom2` varchar(255) default NULL,
  `custom3` varchar(255) default NULL,
  `custom4` varchar(255) default NULL,
  `custom5` varchar(255) default NULL,
  `custom6` varchar(255) default NULL,
  `custom7` varchar(255) default NULL,
  `custom8` varchar(255) default NULL,
  `custom9` varchar(255) default NULL,
  `custom10` varchar(255) default NULL,
  PRIMARY KEY  (`member_id`)
) TYPE=MyISAM AUTO_INCREMENT=22 ;
# --------------------------------------------------------

#
# Table structure for table `message`
#
# Creation: Nov 22, 2003 at 02:52 PM
# Last update: Nov 22, 2003 at 02:52 PM
#

CREATE TABLE `message` (
  `time` timestamp(14) NOT NULL,
  `rid` int(11) default NULL,
  `send_id` int(11) default NULL,
  `rcpt_id` int(11) default NULL,
  `message` text
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `messages`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 18, 2003 at 06:26 PM
#

CREATE TABLE `messages` (
  `message_id` mediumint(8) unsigned NOT NULL auto_increment,
  `from_member_id` mediumint(8) unsigned NOT NULL default '0',
  `to_member_id` mediumint(8) unsigned NOT NULL default '0',
  `date_sent` datetime NOT NULL default '0000-00-00 00:00:00',
  `new` tinyint(4) NOT NULL default '0',
  `replied` tinyint(4) NOT NULL default '0',
  `subject` varchar(150) NOT NULL default '',
  `body` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `to_member_id` (`to_member_id`)
) TYPE=MyISAM AUTO_INCREMENT=12 ;
# --------------------------------------------------------

#
# Table structure for table `mpass`
#
# Creation: Jul 08, 2003 at 11:31 PM
# Last update: Nov 22, 2003 at 05:13 PM
#

CREATE TABLE `mpass` (
  `status` mediumint(9) NOT NULL default '0',
  `pass_expiry` mediumint(9) default NULL,
  PRIMARY KEY  (`status`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mrel_courses`
#
# Creation: Jul 24, 2003 at 12:22 AM
# Last update: Jul 24, 2003 at 12:22 AM
#

CREATE TABLE `mrel_courses` (
  `member_id` mediumint(9) NOT NULL default '0',
  `course_id` mediumint(9) NOT NULL default '0',
  `start` datetime NOT NULL default '0000-00-00 00:00:00'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `mrel_groups`
#
# Creation: Nov 22, 2003 at 01:17 AM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `mrel_groups` (
  `member_id` mediumint(9) NOT NULL default '0',
  `igroup_id` mediumint(9) default NULL,
  `group_id` mediumint(9) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `news`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 22, 2003 at 04:43 PM
#

CREATE TABLE `news` (
  `news_id` mediumint(8) unsigned NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `formatting` tinyint(4) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `body` text NOT NULL,
  PRIMARY KEY  (`news_id`)
) TYPE=MyISAM AUTO_INCREMENT=35 ;
# --------------------------------------------------------

#
# Table structure for table `policy`
#
# Creation: Jun 02, 2003 at 04:05 PM
# Last update: Nov 22, 2003 at 04:43 PM
#

CREATE TABLE `policy` (
  `id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `prop` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;
# --------------------------------------------------------

#
# Table structure for table `preferences`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 20, 2003 at 04:57 PM
#

CREATE TABLE `preferences` (
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `preferences` text NOT NULL,
  PRIMARY KEY  (`member_id`,`course_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `related_content`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: May 20, 2003 at 07:30 PM
#

CREATE TABLE `related_content` (
  `content_id` int(10) unsigned NOT NULL default '0',
  `related_content_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`content_id`,`related_content_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `report_columns`
#
# Creation: Jul 28, 2003 at 08:03 PM
# Last update: Nov 19, 2003 at 06:48 PM
#

CREATE TABLE `report_columns` (
  `id` int(11) NOT NULL auto_increment,
  `cat` text NOT NULL,
  `attr` text NOT NULL,
  `report` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=23 ;
# --------------------------------------------------------

#
# Table structure for table `report_definitions`
#
# Creation: Jul 28, 2003 at 08:03 PM
# Last update: Nov 19, 2003 at 06:34 PM
#

CREATE TABLE `report_definitions` (
  `cat` text NOT NULL,
  `attr` text NOT NULL,
  `tbl` text NOT NULL,
  `field` text NOT NULL,
  `description` text,
  `ID` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`ID`)
) TYPE=MyISAM AUTO_INCREMENT=20 ;
# --------------------------------------------------------

#
# Table structure for table `report_links`
#
# Creation: Jul 28, 2003 at 08:03 PM
# Last update: Nov 19, 2003 at 06:34 PM
#

CREATE TABLE `report_links` (
  `id` int(11) NOT NULL auto_increment,
  `cat1` text NOT NULL,
  `attr1` text NOT NULL,
  `cat2` text NOT NULL,
  `attr2` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=14 ;
# --------------------------------------------------------

#
# Table structure for table `report_operators`
#
# Creation: Jul 28, 2003 at 08:03 PM
# Last update: Jul 28, 2003 at 10:19 PM
#

CREATE TABLE `report_operators` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
# --------------------------------------------------------

#
# Table structure for table `report_query`
#
# Creation: Nov 11, 2003 at 08:24 PM
# Last update: Nov 11, 2003 at 08:24 PM
#

CREATE TABLE `report_query` (
  `cat` text NOT NULL,
  `attr` text NOT NULL,
  `op` text NOT NULL,
  `val` text NOT NULL,
  `report` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `function` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `report` (`report`),
  KEY `report_2` (`report`)
) TYPE=MyISAM AUTO_INCREMENT=37 ;
# --------------------------------------------------------

#
# Table structure for table `report_reports`
#
# Creation: Jul 28, 2003 at 08:03 PM
# Last update: Nov 09, 2003 at 02:11 AM
#

CREATE TABLE `report_reports` (
  `id` int(11) NOT NULL auto_increment,
  `name` text,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=11 ;
# --------------------------------------------------------

#
# Table structure for table `resource_categories`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Jun 24, 2003 at 02:04 AM
#

CREATE TABLE `resource_categories` (
  `CatID` bigint(21) NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `CatName` varchar(100) NOT NULL default '',
  `CatParent` bigint(21) default NULL,
  PRIMARY KEY  (`CatID`),
  KEY `course_id` (`course_id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;
# --------------------------------------------------------

#
# Table structure for table `resource_links`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Jul 28, 2003 at 07:49 PM
#

CREATE TABLE `resource_links` (
  `LinkID` bigint(21) NOT NULL auto_increment,
  `CatID` bigint(21) NOT NULL default '0',
  `Url` varchar(255) NOT NULL default '',
  `LinkName` varchar(64) NOT NULL default '',
  `Description` varchar(255) NOT NULL default '',
  `Approved` tinyint(8) default '0',
  `SubmitName` varchar(64) NOT NULL default '',
  `SubmitEmail` varchar(64) NOT NULL default '',
  `SubmitDate` date NOT NULL default '0000-00-00',
  `hits` int(11) default '0',
  PRIMARY KEY  (`LinkID`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;
# --------------------------------------------------------

#
# Table structure for table `roi`
#
# Creation: May 30, 2003 at 03:34 PM
# Last update: Nov 13, 2003 at 11:23 AM
#

CREATE TABLE `roi` (
  `course_id` mediumint(9) NOT NULL default '0',
  `cost_student` mediumint(9) default NULL,
  `cost_instructor` mediumint(9) default NULL,
  `time` mediumint(9) default NULL,
  PRIMARY KEY  (`course_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `room`
#
# Creation: Nov 22, 2003 at 02:52 PM
# Last update: Nov 22, 2003 at 02:54 PM
#

CREATE TABLE `room` (
  `rid` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  `descript` varchar(255) default NULL,
  `typ` char(1) default NULL,
  `adminid` int(11) default NULL,
  PRIMARY KEY  (`rid`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
# --------------------------------------------------------

#
# Table structure for table `session`
#

CREATE TABLE `session` (
  `uid` int(11) default NULL,
  `time` timestamp(14) NOT NULL,
  `skey` varchar(64) default NULL,
  `ip` varchar(16) default NULL
) TYPE=HEAP;
# --------------------------------------------------------

#
# Table structure for table `skills`
#
# Creation: Jul 20, 2003 at 12:46 AM
# Last update: Nov 22, 2003 at 02:43 PM
#

CREATE TABLE `skills` (
  `skill_id` mediumint(9) NOT NULL auto_increment,
  `skill_desc` text NOT NULL,
  `course_id` mediumint(9) NOT NULL default '0',
  `min_grade` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`skill_id`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;
# --------------------------------------------------------

#
# Table structure for table `test_process`
#
# Creation: Jun 13, 2003 at 04:13 AM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `test_process` (
  `test_id` mediumint(9) NOT NULL default '0',
  `member_id` mediumint(9) NOT NULL default '0',
  `retries` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`test_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `test_type`
#
# Creation: Jun 12, 2003 at 12:32 AM
# Last update: Nov 19, 2003 at 12:54 AM
#

CREATE TABLE `test_type` (
  `test_id` mediumint(9) NOT NULL default '0',
  `test_type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`test_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `tests`
#
# Creation: Jul 21, 2003 at 08:39 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `tests` (
  `test_id` mediumint(8) unsigned NOT NULL auto_increment,
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `format` tinyint(4) NOT NULL default '0',
  `start_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `duration` mediumint(9) default NULL,
  `randomize_order` tinyint(4) NOT NULL default '0',
  `num_questions` tinyint(3) unsigned NOT NULL default '0',
  `instructions` text NOT NULL,
  `retries` smallint(6) default NULL,
  `min_grade` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`test_id`)
) TYPE=MyISAM AUTO_INCREMENT=18 ;
# --------------------------------------------------------

#
# Table structure for table `tests_answers`
#
# Creation: Aug 28, 2003 at 05:24 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `tests_answers` (
  `result_id` mediumint(8) unsigned NOT NULL default '0',
  `question_id` mediumint(8) unsigned NOT NULL default '0',
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `answer` text NOT NULL,
  `score` varchar(5) NOT NULL default '',
  `notes` text NOT NULL,
  PRIMARY KEY  (`result_id`,`question_id`,`member_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `tests_questions`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 19, 2003 at 12:54 AM
#

CREATE TABLE `tests_questions` (
  `question_id` mediumint(8) unsigned NOT NULL auto_increment,
  `test_id` mediumint(8) unsigned NOT NULL default '0',
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `ordering` tinyint(3) unsigned NOT NULL default '0',
  `type` tinyint(3) unsigned NOT NULL default '0',
  `weight` tinyint(3) unsigned NOT NULL default '0',
  `required` tinyint(4) NOT NULL default '0',
  `feedback` text NOT NULL,
  `question` text NOT NULL,
  `choice_0` varchar(255) NOT NULL default '',
  `choice_1` varchar(255) NOT NULL default '',
  `choice_2` varchar(255) NOT NULL default '',
  `choice_3` varchar(255) NOT NULL default '',
  `choice_4` varchar(255) NOT NULL default '',
  `choice_5` varchar(255) NOT NULL default '',
  `choice_6` varchar(255) NOT NULL default '',
  `choice_7` varchar(255) NOT NULL default '',
  `choice_8` varchar(255) NOT NULL default '',
  `choice_9` varchar(255) NOT NULL default '',
  `answer_0` tinyint(4) NOT NULL default '0',
  `answer_1` tinyint(4) NOT NULL default '0',
  `answer_2` tinyint(4) NOT NULL default '0',
  `answer_3` tinyint(4) NOT NULL default '0',
  `answer_4` tinyint(4) NOT NULL default '0',
  `answer_5` tinyint(4) NOT NULL default '0',
  `answer_6` tinyint(4) NOT NULL default '0',
  `answer_7` tinyint(4) NOT NULL default '0',
  `answer_8` tinyint(4) NOT NULL default '0',
  `answer_9` tinyint(4) NOT NULL default '0',
  `answer_size` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`question_id`),
  KEY `test_id` (`test_id`)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=42 ;
# --------------------------------------------------------

#
# Table structure for table `tests_results`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `tests_results` (
  `result_id` mediumint(8) unsigned NOT NULL auto_increment,
  `test_id` mediumint(8) unsigned NOT NULL default '0',
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `date_taken` datetime NOT NULL default '0000-00-00 00:00:00',
  `final_score` char(5) NOT NULL default '',
  PRIMARY KEY  (`result_id`),
  KEY `test_id` (`test_id`)
) TYPE=MyISAM AUTO_INCREMENT=130 ;
# --------------------------------------------------------

#
# Table structure for table `tests_status`
#
# Creation: Jul 22, 2003 at 08:18 PM
# Last update: Jul 22, 2003 at 08:22 PM
#

CREATE TABLE `tests_status` (
  `test_id` mediumint(9) NOT NULL default '0',
  `member_id` mediumint(9) NOT NULL default '0',
  `passed` enum('yes','no') NOT NULL default 'yes',
  KEY `test_id` (`test_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `theme_settings`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Aug 12, 2003 at 10:32 PM
#

CREATE TABLE `theme_settings` (
  `theme_id` tinyint(4) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `preferences` text NOT NULL,
  PRIMARY KEY  (`theme_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;
# --------------------------------------------------------

#
# Table structure for table `tmp_date`
#
# Creation: Aug 06, 2003 at 02:14 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `tmp_date` (
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `tmp` mediumint(9) NOT NULL auto_increment,
  PRIMARY KEY  (`tmp`)
) TYPE=MyISAM AUTO_INCREMENT=621 ;
# --------------------------------------------------------

#
# Table structure for table `tmp_dyngroup`
#
# Creation: Aug 12, 2003 at 10:43 PM
# Last update: Aug 13, 2003 at 12:52 AM
#

CREATE TABLE `tmp_dyngroup` (
  `id` mediumint(9) NOT NULL auto_increment,
  `clause` text NOT NULL,
  `sql` varchar(64) NOT NULL default '',
  `type` varchar(24) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;
# --------------------------------------------------------

#
# Table structure for table `tmp_testansw`
#
# Creation: Aug 18, 2003 at 02:19 PM
# Last update: Nov 20, 2003 at 03:58 PM
#

CREATE TABLE `tmp_testansw` (
  `question_id` mediumint(9) NOT NULL default '0',
  `member_id` mediumint(9) NOT NULL default '0',
  `answer` text NOT NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `tmp_tests`
#
# Creation: Aug 27, 2003 at 07:36 PM
# Last update: Nov 22, 2003 at 05:43 PM
#

CREATE TABLE `tmp_tests` (
  `member_id` mediumint(9) NOT NULL default '0',
  `test_id` mediumint(9) NOT NULL default '0',
  `page` mediumint(9) NOT NULL default '0',
  `question_id` mediumint(9) NOT NULL default '0'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `user`
#
# Creation: Nov 22, 2003 at 02:55 PM
# Last update: Nov 22, 2003 at 05:13 PM
#

CREATE TABLE `user` (
  `uid` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  `last` timestamp(14) NOT NULL,
  `rid` int(11) default NULL,
  `pass` varchar(64) default NULL,
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`uid`)
) TYPE=MyISAM AUTO_INCREMENT=29 ;
# --------------------------------------------------------

#
# Table structure for table `user_categ`
#
# Creation: Jun 18, 2003 at 02:40 PM
# Last update: Jun 18, 2003 at 02:56 PM
#

CREATE TABLE `user_categ` (
  `categ_id` mediumint(9) NOT NULL auto_increment,
  `category` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`categ_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;
# --------------------------------------------------------

#
# Table structure for table `user_custom_fields`
#
# Creation: Jun 26, 2003 at 08:31 PM
# Last update: Jun 28, 2003 at 04:11 PM
#

CREATE TABLE `user_custom_fields` (
  `id` mediumint(9) NOT NULL default '0',
  `name` varchar(64) NOT NULL default '',
  `mandatory` tinyint(4) default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `user_skills`
#
# Creation: Jul 19, 2003 at 11:04 PM
# Last update: Jul 19, 2003 at 11:04 PM
#

CREATE TABLE `user_skills` (
  `member_id` mediumint(9) NOT NULL default '0',
  `skill_id` mediumint(9) NOT NULL default '0',
  `skill_level` mediumint(9) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00'
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `users_online`
#
# Creation: May 17, 2003 at 01:17 PM
# Last update: Nov 22, 2003 at 05:43 PM
# Last check: Nov 22, 2003 at 04:16 PM
#

CREATE TABLE `users_online` (
  `member_id` mediumint(8) unsigned NOT NULL default '0',
  `course_id` mediumint(8) unsigned NOT NULL default '0',
  `login` varchar(20) NOT NULL default '',
  `expiry` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`member_id`)
) TYPE=MyISAM;

