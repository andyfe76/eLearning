#
# ATutor database schema.
# Database : `atutor`
# ATutor Version 1.1
# --------------------------------------------------------

#
# Table structure for table `c_ban_users`
#

CREATE TABLE c_ban_users (
  username varchar(30) NOT NULL default '',
  latin1 tinyint(1) NOT NULL default '0',
  ip varchar(16) NOT NULL default '',
  rooms varchar(100) NOT NULL default '',
  ban_until int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table `c_ban_users`
#

# --------------------------------------------------------

#
# Table structure for table `c_messages`
#

CREATE TABLE c_messages (
  type tinyint(1) NOT NULL default '0',
  room varchar(30) NOT NULL default '',
  username varchar(30) NOT NULL default '',
  latin1 tinyint(1) NOT NULL default '0',
  m_time int(11) NOT NULL default '0',
  address varchar(30) NOT NULL default '',
  message text NOT NULL
) TYPE=MyISAM;

#
# Dumping data for table `c_messages`
#

# --------------------------------------------------------

#
# Table structure for table `c_reg_users`
#

CREATE TABLE c_reg_users (
  username varchar(30) NOT NULL default '',
  latin1 tinyint(1) NOT NULL default '0',
  password varchar(32) NOT NULL default '',
  firstname varchar(64) NOT NULL default '',
  lastname varchar(64) NOT NULL default '',
  country varchar(64) NOT NULL default '',
  website varchar(64) NOT NULL default '',
  email varchar(64) NOT NULL default '',
  showemail tinyint(1) NOT NULL default '0',
  perms varchar(9) NOT NULL default '',
  rooms varchar(128) NOT NULL default '',
  reg_time int(11) NOT NULL default '0',
  ip varchar(16) NOT NULL default '',
  gender tinyint(1) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table `c_reg_users`
#

# --------------------------------------------------------

#
# Table structure for table `c_users`
#

CREATE TABLE c_users (
  room varchar(30) NOT NULL default '',
  username varchar(30) NOT NULL default '',
  latin1 tinyint(1) NOT NULL default '0',
  u_time int(11) NOT NULL default '0',
  status char(1) NOT NULL default '',
  ip varchar(16) NOT NULL default '',
  UNIQUE KEY room (room,username)
) TYPE=MyISAM;

#
# Dumping data for table `c_users`
#

# --------------------------------------------------------

#
# Table structure for table `content`
#

CREATE TABLE content (
  content_id int(10) unsigned NOT NULL auto_increment,
  course_id mediumint(8) unsigned NOT NULL default '0',
  content_parent_id int(10) unsigned NOT NULL default '0',
  ordering tinyint(4) NOT NULL default '0',
  last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  revision tinyint(3) unsigned NOT NULL default '0',
  formatting tinyint(4) NOT NULL default '0',
  release_date datetime NOT NULL default '0000-00-00 00:00:00',
  title varchar(150) NOT NULL default '',
  text text NOT NULL,
  PRIMARY KEY  (content_id),
  KEY course_id (course_id)
) TYPE=MyISAM;

#
# Dumping data for table `content`
#

INSERT INTO content VALUES (1, 1, 0, 1, '2003-03-07 14:49:25', 0, 1, '2003-03-07 14:00:00', 'Welcome To ATutor', 'This is just a blank content page. You can edit or delete this page by enabling the Editor and using the options directly above.');
# --------------------------------------------------------

#
# Table structure for table `course_enrollment`
#

CREATE TABLE course_enrollment (
  member_id mediumint(8) unsigned NOT NULL default '0',
  course_id mediumint(8) unsigned NOT NULL default '0',
  approved enum('y','n') NOT NULL default 'n',
  PRIMARY KEY  (member_id,course_id)
) TYPE=MyISAM;

#
# Dumping data for table `course_enrollment`
#

INSERT INTO course_enrollment VALUES (1, 1, 'y');
# --------------------------------------------------------

#
# Table structure for table `course_stats`
#

CREATE TABLE course_stats (
  course_id mediumint(8) unsigned NOT NULL default '0',
  login_date date NOT NULL default '0000-00-00',
  guests mediumint(8) unsigned NOT NULL default '0',
  members mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (course_id,login_date)
) TYPE=MyISAM;

#
# Dumping data for table `course_stats`
#

# --------------------------------------------------------

#
# Table structure for table `courses`
#

CREATE TABLE courses (
  course_id mediumint(8) unsigned NOT NULL auto_increment,
  member_id mediumint(8) unsigned NOT NULL default '0',
  access enum('public','protected','private') NOT NULL default 'public',
  created_date date NOT NULL default '0000-00-00',
  title varchar(100) NOT NULL default '',
  description text NOT NULL,
  notify tinyint(4) NOT NULL default '0',
  max_quota varchar(30) NOT NULL default '',
  max_file_size varchar(30) NOT NULL default '',
  hide tinyint(4) NOT NULL default '0',
  preferences text NOT NULL,
  header text NOT NULL,
  footer text NOT NULL,
  copyright text NOT NULL,
  tracking enum('on','off') NOT NULL default 'off',
  PRIMARY KEY  (course_id)
) TYPE=MyISAM;

#
# Dumping data for table `courses`
#

INSERT INTO courses VALUES (1, 1, 'protected', '2003-03-07', 'Welcome Course', '', 0, '5242880', '512000', 0, '', '', '', '', 'off');
# --------------------------------------------------------

#
# Table structure for table `forums`
#

CREATE TABLE forums (
  forum_id mediumint(8) unsigned NOT NULL auto_increment,
  course_id mediumint(8) unsigned NOT NULL default '0',
  title varchar(60) NOT NULL default '',
  description text NOT NULL,
  PRIMARY KEY  (forum_id)
) TYPE=MyISAM;

#
# Dumping data for table `forums`
#

# --------------------------------------------------------

#
# Table structure for table `forums_accessed`
#

CREATE TABLE forums_accessed (
  post_id mediumint(8) unsigned NOT NULL default '0',
  member_id mediumint(8) unsigned NOT NULL default '0',
  last_accessed timestamp(14) NOT NULL,
  PRIMARY KEY  (post_id,member_id)
) TYPE=MyISAM;

#
# Dumping data for table `forums_accessed`
#

# --------------------------------------------------------

#
# Table structure for table `forums_subscriptions`
#

CREATE TABLE forums_subscriptions (
  post_id mediumint(8) unsigned NOT NULL default '0',
  member_id mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (post_id,member_id)
) TYPE=MyISAM;

#
# Dumping data for table `forums_subscriptions`
#

# --------------------------------------------------------

#
# Table structure for table `forums_threads`
#

CREATE TABLE forums_threads (
  post_id mediumint(8) unsigned NOT NULL auto_increment,
  parent_id mediumint(8) unsigned NOT NULL default '0',
  course_id mediumint(8) unsigned NOT NULL default '0',
  member_id mediumint(8) unsigned NOT NULL default '0',
  forum_id mediumint(8) unsigned NOT NULL default '0',
  login varchar(20) NOT NULL default '',
  last_comment datetime NOT NULL default '0000-00-00 00:00:00',
  num_comments mediumint(8) unsigned NOT NULL default '0',
  subject varchar(100) NOT NULL default '',
  body text NOT NULL,
  date datetime NOT NULL default '0000-00-00 00:00:00',
  locked tinyint(4) NOT NULL default '0',
  sticky tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (post_id)
) TYPE=MyISAM;

#
# Dumping data for table `forums_threads`
#

# --------------------------------------------------------

#
# Table structure for table `g_click_data`
#

CREATE TABLE g_click_data (
  member_id mediumint(8) unsigned NOT NULL default '0',
  course_id mediumint(8) unsigned NOT NULL default '0',
  from_cid int(10) unsigned NOT NULL default '0',
  to_cid int(10) unsigned NOT NULL default '0',
  g tinyint(3) unsigned NOT NULL default '0',
  timestamp int(10) unsigned NOT NULL default '0',
  duration double unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table `g_click_data`
#


# --------------------------------------------------------

#
# Table structure for table `g_refs`
#

CREATE TABLE g_refs (
  g_id tinyint(4) default NULL,
  reference varchar(65) default NULL,
  KEY g_id (g_id)
) TYPE=MyISAM;

#
# Dumping data for table `g_refs`
#
INSERT INTO g_refs VALUES (1, 'Users Online');
INSERT INTO g_refs VALUES (2, 'Local Menu');
INSERT INTO g_refs VALUES (3, 'Global Menu');
INSERT INTO g_refs VALUES (4, 'Related topic');
INSERT INTO g_refs VALUES (5, 'Jump');
INSERT INTO g_refs VALUES (6, 'Top/#bypass anchor');
INSERT INTO g_refs VALUES (7, 'Sequence');
INSERT INTO g_refs VALUES (8, 'Within sitemap');
INSERT INTO g_refs VALUES (9, 'Global Home link');
INSERT INTO g_refs VALUES (10, 'Breadcrumb');
INSERT INTO g_refs VALUES (11, 'Headings');
INSERT INTO g_refs VALUES (12, 'Embedded links');
INSERT INTO g_refs VALUES (13, 'Table of contents');
INSERT INTO g_refs VALUES (14, 'Home');
INSERT INTO g_refs VALUES (15, 'Tools');
INSERT INTO g_refs VALUES (16, 'Resources');
INSERT INTO g_refs VALUES (17, 'Discussions');
INSERT INTO g_refs VALUES (18, 'Help');
INSERT INTO g_refs VALUES (19, 'Logout');
INSERT INTO g_refs VALUES (20, 'Preferences');
INSERT INTO g_refs VALUES (21, 'Inbox');
INSERT INTO g_refs VALUES (22, 'Local major topic');
INSERT INTO g_refs VALUES (23, 'To sitemap');
INSERT INTO g_refs VALUES (24, 'Embedded glossary');
INSERT INTO g_refs VALUES (25, 'Menu glossary');
INSERT INTO g_refs VALUES (26, 'Local Home link');
INSERT INTO g_refs VALUES (27, 'Print Compiler');
INSERT INTO g_refs VALUES (28, 'My Tracker');
INSERT INTO g_refs VALUES (29, 'Links DB');
INSERT INTO g_refs VALUES (30, 'Session Start');

# --------------------------------------------------------

#
# Table structure for table `glossary`
#

CREATE TABLE glossary (
  word_id mediumint(8) unsigned NOT NULL auto_increment,
  course_id mediumint(8) unsigned NOT NULL default '0',
  word varchar(60) NOT NULL default '',
  definition text NOT NULL,
  related_word_id mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (word_id),
  KEY course_id (course_id),
  KEY first_letter (word(1))
) TYPE=MyISAM;

#
# Dumping data for table `glossary`
#

# --------------------------------------------------------

#
# Table structure for table `instructor_approvals`
#

CREATE TABLE instructor_approvals (
  member_id mediumint(8) unsigned NOT NULL default '0',
  request_date datetime NOT NULL default '0000-00-00 00:00:00',
  notes text NOT NULL,
  PRIMARY KEY  (member_id)
) TYPE=MyISAM;

#
# Dumping data for table `instructor_approvals`
#

# --------------------------------------------------------

#
# Table structure for table `learning_concepts`
#

CREATE TABLE learning_concepts (
  concept_id tinyint(3) unsigned NOT NULL auto_increment,
  title varchar(100) NOT NULL default '',
  tag varchar(20) NOT NULL default '',
  description text NOT NULL,
  icon_name varchar(50) NOT NULL default '',
  PRIMARY KEY  (concept_id)
) TYPE=MyISAM;

#
# Dumping data for table `learning_concepts`
#

INSERT INTO learning_concepts VALUES (1, 'Read', 'read', 'This icon signifies additional reading or a more advanced look at a topic. This reading may include a relevant paper published on the Web, a recommended book or paper reference, or more advanced course notes. Those who would rather do activies and forego the reading, can skip over items marked with these icons.', 'read.gif');
INSERT INTO learning_concepts VALUES (2, 'A Test', 'test', 'The test icon appears beside paragraphs or list items that refer to an ability that can be tested. These little tests are often quick activities that will make you aware of a particular type of thinking. Others test your endurace with thinking activities, some challenge the limits of your ability, and others are just for fun. Sometimes tests are just tests, seeing what you recall from what you\'ve been learning.', 'test.gif');
INSERT INTO learning_concepts VALUES (3, 'Write', 'write', 'The Write icon signifies some form of writing. It may mean a pencil and paper should be used, it may mean make a note of this, it may mean rewrite this in your own words to better understand, or it may mean try writing about the topic, perhaps a page or two from memory.', 'write1a.gif');
INSERT INTO learning_concepts VALUES (4, 'Listen', 'listen', 'The Listen icon means a streamed audio transcript of the page is available. Introductory pages and instructions often include audio. Real audio player is required.', 'listen1b.gif');
INSERT INTO learning_concepts VALUES (5, 'Think Critically', 'think', 'This icon signifies "deep" thought. You may argue to support or oppose a position being taken, justify a comment based on the logic of an argument, find evidence from other sources to clarify uncertainty, or perhaps add to an argument to extend its logic into other domains.', 'think.gif');
INSERT INTO learning_concepts VALUES (6, 'Important Info', 'important', 'This icon signifies information that shouldn\'t be missed. If you are breezing through the course looking for activities, you might want to stop here and read a little. If you are going to learn anything from the course you should learn this.', 'exclaim.gif');
INSERT INTO learning_concepts VALUES (7, 'Question This', 'question', 'The Question mark asks you to question the truth or validity of a statement or theory. Ask yourself "Is this really true?" Why do you think it isn\'t true? Why do you think someone else thinks it is?', 'questiona.gif');
INSERT INTO learning_concepts VALUES (8, 'Don\'t!', 'dont', 'This icon is present when bad habits are being discussed, or something that should be avoided has been mentioned.', 'no2a.gif');
INSERT INTO learning_concepts VALUES (9, 'Do!', 'do', 'Dos are the opposite of Don\'ts. Dos are things you should try to make habit, or things you should seek out and practice.', 'yes1b.gif');
INSERT INTO learning_concepts VALUES (10, 'A Project Topic', 'project', 'This icon is placed near interesting topics that would be ideal for a short project. Those who intend to do a course project may want to scan the course site for these icons before deciding on a topic.', 'project.gif');
INSERT INTO learning_concepts VALUES (11, 'Discussion', 'discussion', 'The Discussion icon is placed near topics that might be interesting, controversial, raise questions, or challenge your way of thinking. Use the topic to start a discussion thread.', 'discussion.gif');
INSERT INTO learning_concepts VALUES (12, 'Information', 'information', 'The Information icon is found near information not directly related to the course content but helpful in ways that can assist your learning. This information might be a "how to.." page, a link to technical information, an address or phone number, a reference to a topic outside the focus of the course, or just something interesting.', 'info1.gif');
INSERT INTO learning_concepts VALUES (13, 'Links Database', 'link', 'This linked Addlinks icon can be found often throughout the course. It will take you to a page with a collection of links that have been added to the site by other participants. If you find an interesting site you think might fit into the course resources, please take a minute and add it to the Addlinks page. Also refer to the Addlinks page for the most recent updates. These new resources are used to replace broken links on other resource pages that need replacing each session. You can help keep the course resources up to date by adding two or three new links yourself.', 'chain.gif');
# --------------------------------------------------------

#
# Table structure for table `members`
#

CREATE TABLE members (
  member_id mediumint(8) unsigned NOT NULL auto_increment,
  login varchar(20) NOT NULL default '',
  password varchar(20) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  website varchar(200) NOT NULL default '',
  first_name varchar(100) NOT NULL default '',
  last_name varchar(100) NOT NULL default '',
  age tinyint(3) unsigned NOT NULL default '0',
  gender enum('m','f') NOT NULL default 'm',
  address varchar(255) NOT NULL default '',
  postal varchar(15) NOT NULL default '',
  city varchar(50) NOT NULL default '',
  province varchar(50) NOT NULL default '',
  country varchar(50) NOT NULL default '',
  phone varchar(15) NOT NULL default '',
  status tinyint(4) NOT NULL default '0',
  preferences text NOT NULL,
  creation_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (member_id)
) TYPE=MyISAM;

#
# Dumping data for table `members`
#

INSERT INTO members VALUES (1, 'admin', 'admin', 'admin@admin.com', '', '', '', 0, 'm', '', '', '', '', '', '', 1, 'a:17:{s:10:"PREF_STACK";a:5:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";}s:14:"PREF_MAIN_MENU";i:1;s:9:"PREF_MENU";i:1;s:19:"PREF_MAIN_MENU_SIDE";i:2;s:8:"PREF_SEQ";i:3;s:8:"PREF_TOC";i:2;s:14:"PREF_SEQ_ICONS";i:0;s:14:"PREF_NAV_ICONS";i:0;s:16:"PREF_LOGIN_ICONS";i:0;s:9:"PREF_FONT";i:0;s:15:"PREF_STYLESHEET";i:0;s:14:"PREF_NUMBERING";i:0;s:13:"PREF_HEADINGS";i:0;s:16:"PREF_BREADCRUMBS";i:1;s:13:"PREF_OVERRIDE";i:0;s:9:"PREF_HELP";i:1;s:14:"PREF_MINI_HELP";i:1;}', '2003-03-07 14:48:56');
# --------------------------------------------------------

#
# Table structure for table `messages`
#

CREATE TABLE messages (
  message_id mediumint(8) unsigned NOT NULL auto_increment,
  from_member_id mediumint(8) unsigned NOT NULL default '0',
  to_member_id mediumint(8) unsigned NOT NULL default '0',
  date_sent datetime NOT NULL default '0000-00-00 00:00:00',
  new tinyint(4) NOT NULL default '0',
  replied tinyint(4) NOT NULL default '0',
  subject varchar(150) NOT NULL default '',
  body text NOT NULL,
  PRIMARY KEY  (message_id),
  KEY to_member_id (to_member_id)
) TYPE=MyISAM;

#
# Dumping data for table `messages`
#

# --------------------------------------------------------

#
# Table structure for table `news`
#

CREATE TABLE news (
  news_id mediumint(8) unsigned NOT NULL auto_increment,
  course_id mediumint(8) unsigned NOT NULL default '0',
  member_id mediumint(8) unsigned NOT NULL default '0',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  formatting tinyint(4) NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  body text NOT NULL,
  PRIMARY KEY  (news_id)
) TYPE=MyISAM;

#
# Dumping data for table `news`
#

INSERT INTO news VALUES (1, 1, 1, '2003-03-07 14:49:25', 1, 'Welcome To ATutor!', 'This is some default content. See the <a href="help/about_help.php">About ATutor Help</a> for sources of information about using ATutor.-160');
# --------------------------------------------------------

#
# Table structure for table `preferences`
#

CREATE TABLE preferences (
  member_id mediumint(8) unsigned NOT NULL default '0',
  course_id mediumint(8) unsigned NOT NULL default '0',
  preferences text NOT NULL,
  PRIMARY KEY  (member_id,course_id)
) TYPE=MyISAM;

#
# Dumping data for table `preferences`
#

# --------------------------------------------------------

#
# Table structure for table `related_content`
#

CREATE TABLE related_content (
  content_id int(10) unsigned NOT NULL default '0',
  related_content_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (content_id,related_content_id)
) TYPE=MyISAM;

#
# Dumping data for table `related_content`
#

# --------------------------------------------------------

#
# Table structure for table `resource_categories`
#

CREATE TABLE resource_categories (
  CatID bigint(21) NOT NULL auto_increment,
  course_id mediumint(8) unsigned NOT NULL default '0',
  CatName varchar(100) NOT NULL default '',
  CatParent bigint(21) default NULL,
  PRIMARY KEY  (CatID),
  KEY course_id (course_id)
) TYPE=MyISAM;

#
# Dumping data for table `resource_categories`
#

# --------------------------------------------------------

#
# Table structure for table `resource_links`
#

CREATE TABLE resource_links (
  LinkID bigint(21) NOT NULL auto_increment,
  CatID bigint(21) NOT NULL default '0',
  Url varchar(255) NOT NULL default '',
  LinkName varchar(64) NOT NULL default '',
  Description varchar(255) NOT NULL default '',
  Approved tinyint(8) default '0',
  SubmitName varchar(64) NOT NULL default '',
  SubmitEmail varchar(64) NOT NULL default '',
  SubmitDate date NOT NULL default '0000-00-00',
  hits int(11) default '0',
  PRIMARY KEY  (LinkID)
) TYPE=MyISAM;

#
# Dumping data for table `resource_links`
#

# --------------------------------------------------------

#
# Table structure for table `tests`
#

CREATE TABLE tests (
  test_id mediumint(8) unsigned NOT NULL auto_increment,
  course_id mediumint(8) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  format tinyint(4) NOT NULL default '0',
  start_date datetime NOT NULL default '0000-00-00 00:00:00',
  end_date datetime NOT NULL default '0000-00-00 00:00:00',
  randomize_order tinyint(4) NOT NULL default '0',
  num_questions tinyint(3) unsigned NOT NULL default '0',
  instructions text NOT NULL,
  PRIMARY KEY  (test_id)
) TYPE=MyISAM;

#
# Dumping data for table `tests`
#

# --------------------------------------------------------

#
# Table structure for table `tests_answers`
#

CREATE TABLE tests_answers (
  result_id mediumint(8) unsigned NOT NULL default '0',
  question_id mediumint(8) unsigned NOT NULL default '0',
  member_id mediumint(8) unsigned NOT NULL default '0',
  answer text NOT NULL,
  score varchar(5) NOT NULL default '',
  notes text NOT NULL,
  PRIMARY KEY  (result_id,question_id,member_id)
) TYPE=MyISAM;

#
# Dumping data for table `tests_answers`
#

# --------------------------------------------------------

#
# Table structure for table `tests_questions`
#

CREATE TABLE tests_questions (
  question_id mediumint(8) unsigned NOT NULL auto_increment,
  test_id mediumint(8) unsigned NOT NULL default '0',
  course_id mediumint(8) unsigned NOT NULL default '0',
  ordering tinyint(3) unsigned NOT NULL default '0',
  type tinyint(3) unsigned NOT NULL default '0',
  weight tinyint(3) unsigned NOT NULL default '0',
  required tinyint(4) NOT NULL default '0',
  feedback text NOT NULL,
  question text NOT NULL,
  choice_0 varchar(255) NOT NULL default '',
  choice_1 varchar(255) NOT NULL default '',
  choice_2 varchar(255) NOT NULL default '',
  choice_3 varchar(255) NOT NULL default '',
  choice_4 varchar(255) NOT NULL default '',
  choice_5 varchar(255) NOT NULL default '',
  choice_6 varchar(255) NOT NULL default '',
  choice_7 varchar(255) NOT NULL default '',
  choice_8 varchar(255) NOT NULL default '',
  choice_9 varchar(255) NOT NULL default '',
  answer_0 tinyint(4) NOT NULL default '0',
  answer_1 tinyint(4) NOT NULL default '0',
  answer_2 tinyint(4) NOT NULL default '0',
  answer_3 tinyint(4) NOT NULL default '0',
  answer_4 tinyint(4) NOT NULL default '0',
  answer_5 tinyint(4) NOT NULL default '0',
  answer_6 tinyint(4) NOT NULL default '0',
  answer_7 tinyint(4) NOT NULL default '0',
  answer_8 tinyint(4) NOT NULL default '0',
  answer_9 tinyint(4) NOT NULL default '0',
  answer_size tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (question_id),
  KEY test_id (test_id)
) TYPE=MyISAM PACK_KEYS=0;

#
# Dumping data for table `tests_questions`
#

# --------------------------------------------------------

#
# Table structure for table `tests_results`
#

CREATE TABLE tests_results (
  result_id mediumint(8) unsigned NOT NULL auto_increment,
  test_id mediumint(8) unsigned NOT NULL default '0',
  member_id mediumint(8) unsigned NOT NULL default '0',
  date_taken datetime NOT NULL default '0000-00-00 00:00:00',
  final_score char(5) NOT NULL default '',
  PRIMARY KEY  (result_id),
  KEY test_id (test_id)
) TYPE=MyISAM;

#
# Dumping data for table `tests_results`
#

# --------------------------------------------------------

#
# Table structure for table `theme_settings`
#

CREATE TABLE theme_settings (
  theme_id tinyint(4) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  preferences text NOT NULL,
  PRIMARY KEY  (theme_id)
) TYPE=MyISAM;

#
# Dumping data for table `theme_settings`
#

INSERT INTO theme_settings VALUES (1, 'Accessbility', 'a:16:{s:19:"PREF_MAIN_MENU_SIDE";i:2;s:14:"PREF_MAIN_MENU";i:0;s:10:"PREF_THEME";i:0;s:12:"PREF_DISPLAY";i:0;s:9:"PREF_TIPS";i:0;s:8:"PREF_SEQ";i:1;s:8:"PREF_TOC";i:2;s:14:"PREF_NUMBERING";i:0;s:11:"PREF_ONLINE";i:0;s:14:"PREF_SEQ_ICONS";i:2;s:14:"PREF_NAV_ICONS";i:2;s:16:"PREF_LOGIN_ICONS";i:2;s:13:"PREF_HEADINGS";i:0;s:16:"PREF_BREADCRUMBS";i:0;s:9:"PREF_FONT";i:0;s:15:"PREF_STYLESHEET";i:0;}');
INSERT INTO theme_settings VALUES (2, 'Icons only', 'a:4:{s:14:"PREF_SEQ_ICONS";i:1;s:14:"PREF_NAV_ICONS";i:1;s:16:"PREF_LOGIN_ICONS";i:1;s:16:"PREF_BREADCRUMBS";i:1;}');
INSERT INTO theme_settings VALUES (3, 'Both icons and text', 'a:5:{s:14:"PREF_MAIN_MENU";i:1;s:14:"PREF_SEQ_ICONS";i:0;s:14:"PREF_NAV_ICONS";i:0;s:16:"PREF_LOGIN_ICONS";i:0;s:16:"PREF_BREADCRUMBS";i:1;}');
INSERT INTO theme_settings VALUES (4, 'ATutor Defaults', 'a:17:{s:10:"PREF_STACK";a:5:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";}s:14:"PREF_MAIN_MENU";i:1;s:9:"PREF_MENU";i:1;s:19:"PREF_MAIN_MENU_SIDE";i:2;s:8:"PREF_SEQ";i:3;s:8:"PREF_TOC";i:2;s:14:"PREF_SEQ_ICONS";i:0;s:14:"PREF_NAV_ICONS";i:0;s:16:"PREF_LOGIN_ICONS";i:0;s:9:"PREF_FONT";i:0;s:15:"PREF_STYLESHEET";i:0;s:14:"PREF_NUMBERING";i:0;s:13:"PREF_HEADINGS";i:0;s:16:"PREF_BREADCRUMBS";i:1;s:13:"PREF_OVERRIDE";i:0;s:9:"PREF_HELP";i:1;s:14:"PREF_MINI_HELP";i:1;}');
# --------------------------------------------------------

#
# Table structure for table `users_online`
#

CREATE TABLE users_online (
  member_id mediumint(8) unsigned NOT NULL default '0',
  course_id mediumint(8) unsigned NOT NULL default '0',
  login varchar(20) NOT NULL default '',
  expiry int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (member_id)
) TYPE=MyISAM;

#
# Dumping data for table `users_online`
#


