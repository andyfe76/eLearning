<?php
//////////////////////////////////////
// HELP

$_help[AT_HELP_HIDE_HELP]='You may <strong><em>Hide Help</em></strong> by disabling it in your Display Options <a href="tools/preferences.php">preference settings</a>.';
$_help[AT_HELP_NO_HELP] ='There is no help available at this time.';
$_help[AT_HELP_ENABLE_EDITOR] ='Use the <strong><em><a href="%1enable=PREF_EDIT">Enable Editor</a></em></strong> [ <img src="images/pen.gif" alt="Enable Editor Icon" /> ] link at the top to edit this content.';
$_help[AT_HELP_DISABLE_EDITOR] ='Use the <strong><em><a href="?disable=PREF_EDIT">Disable Editor</a></em></strong> [ <img src="images/pen2.gif" alt="Disable Editor Icon" /> ] link at the top to hide the editing tools.';
/*
//where are these being used?  delete these if they're not missed
$_help[AT_HELP_EDIT_CONTENT]='Use "<strong><em><a href="editor/edit_content.php?cid=$cid">Edit This Content Page</a></em></strong>" to add or modify content on this page. Tools are also available through this link for formatting and rearranging your content, and for managing files.<br />';
$_help[AT_HELP_DELETE_CONTENT]='Use "<strong><em><a href="editor/delete_content.php?cid=$cid">Delete This Content Page</a></strong></em>" to remove the current page from your course. All sub pages must be deleted first.<br />';
$_help[AT_HELP_SUB_CONTENT]='Use "<strong><em><a href="editor/add_new_content.php?pid=$cid">Add Sub Content to This Page</a></strong></em>" to create pages for sub topics. This will add an indented entry to the Menu below the current topic. There is no limit to the number of topic levels you can add, though 4 or 5 deep is generally a maximum.<br />';
*/
$_help[AT_HELP_BROWSER_PRINT_BUTTON] = 'Use your browser\'s print button to print this compiled page.';
$_help[AT_HELP_EDIT_STYLES]='<ol>
<li>This tool creates/edits a file in your course content directory called "stylesheet.css".</li>
<li>Search the Web for a Style Sheet Tutorial to learn more about creating and editing CSS files (<a href="http://www.htmlhelp.com/reference/css/">Cascading Style Sheets</a>).</li>
<li>Be sure to use web safe colours. (see the <a href="http://www.visibone.com/colourlab/">VisiBone Color Lab</a>).</li>
<li>Start by loading the K-Lore Default Style Sheet by clicking the link below. <strong><em>WARNING</em></strong> this will delete any previous course styles. </li>
<li>Edit the Default Stylesheet</li>
<li>Upload the files linked from within the style sheet into your content directory using the K-Lore File Manager.</li>
<li>Link to your background images by replacing the default location of the image (e.g "../../images/cellpic1.gif") to a location in your content directory (e.g. "content/241/images/myimage.gif", where 241 is the ID number of your course)
<li>Delete the stylesheet.css file (using the File Manager), or empty the Course styles area and save, to display the K-Lore Default Styles.</li>
</ol>';
$_help[AT_HELP_EDIT_STYLES_MINI]='Upload an existing style sheet from your local hard drive, to be pasted into the textarea below. You may prefer to begin with the K-Lore default stylesheet, then edit it\'s attributes to create your own custom styles.';  //'
$_help[AT_HELP_ADD_ANNOUNCEMENT]='You are currently on the Course Announcements page. Click on <strong><em><a href="editor/add_news.php">Add Announcement</a></em></strong> below to add content to this page. This page is the course Home Page, through which students enter your course.<br />';
$_help[AT_HELP_ADD_ANNOUNCEMENT2]='You are currently on the Course Announcements page. Click on <strong><em><a href="editor/add_news.php">Add Announcement</a></em></strong> below to add content to this page. This page is the course Home Page, through which students enter your course. </a>.<br />';
$_help[AT_HELP_ADD_TOP_PAGE]='You may add main content pages to your course by clicking on <strong><em><a href="editor/add_new_content.php">Add Chapter Page</a></em></strong>. This will add an entry to the Menu. Notice that "Add Chapter Page" also appears in the global menu, so you may add main pages from there as well.<br />';
$_help[AT_HELP_CREATE_LINKS]='Create categories in which to sort links by entering topic names in to the "<strong><em>New Category</em></strong>" field below.';
$_help[AT_HELP_CREATE_LINKS1]='To add a new link move into the category where it should reside, then click "<strong><em>Suggest a New Link</em></strong>".';
$_help[AT_HELP_CREATE_FORUMS]='Click on "<strong><em><a href="editor/add_forum.php">New Forum</a></em></strong>" to add a new discussion board to your course.';
$_help[AT_HELP_FILE_LINKING] = 'To link to course files use <code>CONTENT_DIR</code> as the path to the content home directory. For example, if you upload an image called MyImage.gif then you would link to it in your HTML using <code>CONTENT_DIR</code>/MyImage.gif as the path to the image. <code>CONTENT_DIR</code> will automatically be replaced with the correct path to that file when the page is viewed. If you upload an image to a folder called MyFolder then upload the same image, then the path to use will become <code>CONTENT_DIR</code>/MyFolder/MyImage.gif <br />';
$_help[AT_HELP_FILE_EXPORTABLE] ='Using <code>CONTENT_DIR</code> will make it possible to export and import your course material easily without having to change the path to the files. If you do not intend to move your course, you can right click on a filename and copy the link location, then paste that path into your HTML';
$_help[AT_HELP_EMBED_GLOSSARY]='To embed a definition into your content use [?] to designate the start of the term and a [/?] to designate the end of the term. If the term is not already in the glossary then you will be prompted to provide the definition.';
$_help[AT_HELP_CONTENT_PATH]='When linking to files from within your content, use <code>CONTENT_DIR/</code> as the root path to your uploaded files, followed by a sub directory name (if necessary), then followed by the file name of the file being linked too (e.g. src="<code>CONTENT_DIR</code>/images/logo.gif" OR href="<code>CONTENT_DIR</code>/week1/outline.html").';
$_help[AT_HELP_FORUM_STICKY]='Click on the "sticky" icon [<img src="images/forum/sticky.gif" height="18" width="16" alt="sticky icon"/>] to fix a message thread to the top of the thread list. Multiple sticky threads are ordered by the date of the last post to the thread.';
$_help[AT_HELP_FORUM_LOCK]='Click on the "lock" icon [<img src="images/lock.gif" height="18" width="16" alt="lock icon"/>] to restrict posts to a thread, or to hide a thread from reading and posting.';
$_help[AT_HELP_TRACKING]='Select from the menu below, the student who\'s navigation tendencies and click path you wish to view.';//'
$_help[AT_HELP_TRACKING1]='Select a page from the menu below, to view its statistics.';
$_help[AT_HELP_NOT_RELEASED] = 'This page will become available to students on the selected date.';
$_help[AT_HELP_FORMATTING] = 'Plain text content will display as it appears in the Body textarea. Use HTML, or the codes listed below, to add formatting, links, graphics, etc. to your content.';
$_help[AT_HELP_PASTE_FILE] = 'Pasting from a file will insert the contents of the file into the Body field below. Create your content in an HTML editor, then import the page here.';
$_help[AT_HELP_PASTE_FILE1] ='You can safely paste content into the Body area without altering the existing content. Saving will erase any previous content';
$_help[AT_HELP_ADD_CODES] ='The Discussion and Link Learning Concept will insert icons that are linked to the Forums and the Link Database. When inserting images using the image code, be sure to include a short text description of the image in the second half of the opening code labelled "alt text".';
$_help[AT_HELP_ADD_CODES1] ='Use the codes listed below to apply basic formatting to you content, or to insert links or images. Use HTML to create more detailed formatting.';
$_help[AT_HELP_INSERT]='Locate this page within other pages of the course. Move the page around within this section, or move it to another section.';
$_help[AT_HELP_RELATED]='Select other topics in the course related to this one. Topics appear in the "Related Topics" menu when this page is viewed.';
$_help[AT_HELP_ANNOUNCEMENT]='Announcements will appear on the course Home Page. Text or HTML is allowed. At least one of the two fields is required.';
$_help[AT_HELP_FILEMANAGER]='Upload files here to link to your content pages. Click on "Open File Manager frame", to have it open while editing your content.';
$_help[AT_HELP_FILEMANAGER1]='Right click on a file then select "copy link location" (or what ever your browser calls this function), to copy the file\'s path, then paste that path into your content.';
$_help[AT_HELP_FILEMANAGER2]='You might first create a number of <strong><em>folders</em></strong>, in which to sort your course files. You might create different directories for images, sound files, assignment downloads, or perhaps directories for each lesson.<br /><br />';
$_help[AT_HELP_FILEMANAGER3]='Assuming you know a little HTML, you can <strong><em>link to files</em></strong> in your course directory using a path something like href="CONTENT_DIR/assignments/week1intro.doc". You may also link to files using full URLs, but <strong><em>using CONTENT_DIR makes your course portable</em></strong> if you decide later you want to move it.<br /><br />';
$_help[AT_HELP_FILEMANAGER4]='To <strong><em>find the path</em></strong> to a course file, right click on its link in the File Manager and choose "Save Link Location" (systems vary in terminology used). This copies the link to the clipboard, which you might then choose to paste into your course content to create a link (using right-click then paste, or Ctrl-v).<br /><br />';

  
$_help[AT_HELP_CUSTOM_HEADER]='Insert HTML formatted content to create a custom header for this course. Or, click on "Load Default Wrap-around Template", then modify the template with your own content.';
$_help[AT_HELP_CREATE_HEADER]='To create a custom header for your course, enter HTML formatted content into the textarea below. Use your <a href="tools/file_manager.php">File Manager</a> to upload images (etc.) linked from your header, into your course content directory. See <a href="http://k-lore.koncept.ro//howto.php">K-Lore HowTo V2.0</a> for more about creating a custom course header.';
$_help[AT_HELP_EDIT_STYLES]='Create a custom look and feel for your course. Load the K-Lore Default Stylesheet, make modification to it, then save to see the effects. The course style sheet is used when vistors are not using their own custom preference settings, or when "Override selections ..." is set to "yes" in the theme preference. With this setting each course appears with its own unique appearance.';
$_help[AT_HELP_DEMO_HELP]='This is a demo Context Sensitive Help. Hover over it with a mouse pointer, or click on it, to display the accompanying help.';
$_help[AT_HELP_DEMO_HELP2]='This is a demo Help Box. When the Help Box preference is disabled, the Help Icon becomes clickable, so Help Boxes can be opened and close.';
$_help[AT_HELP_ADD_RESOURCE]='URL, Title, Description, and Your Name, are required fields.';
$_help[AT_HELP_ADD_RESOURCE1]='Use appropriate keywords in your description to aid resource searches. ';
$_help[AT_HELP_ADD_RESOURCE_MINI]='Keep your description brief. Mention what content could be found on the site and what it is about. Do not praise the site by using words like "best" or "greatest" in your description. Try to use appropriate keywords to aid searching.';
$_help[AT_HELP_ADD_FORUM_MINI]='Provide a descriptive title that signifies the main topic of discussion. Describe the topics, and the types of discussion that should take place in this forum.';
$_help[AT_HELP_GLOSSARY_MINI]='Words or phrase may be added to the glossary. If related terms exist, associate them to this term (phrase) using the selection menu below. Glossary terms are displayed in a mouseover box like this one, or on a separate page if a user clicks the glossary item e.g. [?] ';
$_help[AT_HELP_GLOSSARY_MENU]='When terms on the current page are listed in the glossary, those listings will appear in this menu. ';
$_help[AT_HELP_USERS_MENU]='The Users Online Menu is a list of people currently logged into this course. Click on a user\'s login name to send a private message to that person\'s inbox. You (and the recipient) must be enrolled in this course to send messages.';
$_help[AT_HELP_RELATED_MENU]='The Related Topics Menu displays other topics in this course that are related to the one currently being viewed. ';
$_help[AT_HELP_GLOBAL_MENU]='The Global Menu is a collapsible menu that can be used to display the entire course. Use <strong><em>Alt-7</em></strong> to open or close this menu.';
$_help[AT_HELP_LOCAL_MENU]='The Local Menu is a collapsible menu that displays the topics in the current content section. Links at the top and bottom of this menu lead to the previous and next major topics in the course. ';
$_help[AT_HELP_MAIN_MENU]='Hide the menus to conserve space. Using your preference settings, locate the menu on the left or right. Toggle this menu opened or closed with your keyboard by pressing Alt-6.';
$_help[AT_HELP_ADD_MC_QUESTION]='Create two or more choices for the question, and select one of those choices to be the correct answer. Create feedback to display with the results presented to test takers (i.e. the correct answer, or an explanation).';
$_help[AT_HELP_ADD_TF_QUESTION]='Supply a statement that can be answered with either the word "true", or the word "false". Include an explanation or a reference as feedback, to display with results persented to test takers.';
$_help[AT_HELP_ADD_OPEN_QUESTION]='Create different types of open ended questions by choosing from the Answer Sizes below. These questions are presented with either a text field, a small textarea, or a large text area.';
$_help[AT_HELP_ADD_TEST]='Provide a concise descriptive title (e.g. "Chapter 1 Quiz"). With the date selectors create a "time window" during which the test is available to test takers. By default, tests are unavailable.';
$_help[AT_HELP_GLOBAL_WEIGHT]='Provide the maximum weight for offline test. This weight will be used in calculating student results. For example, if global weight is 20 and you grand a mark of 15 the student will record an achievement of 80%.';
$_help[AT_HELP_TEST_DURATION]='This represents the timing of the test being taken. For one recorded test session, the user may complete his choices within this timeframe. <br><br>A test may or may not be taken several times during the start-end test availability period.';
$_help[AT_HELP_TEST_RETRIES]='The maximum number of retries that you allow the student to take the test in the availability period. Default blank value allows the student only one chance to take the test.';
$_help[AT_HELP_POSITION_OPTIONS]='You might choose to locate the menus on the left if you are left handed. <br>Previous/Next location indicates the positioning of the ordered navigation bar.<br>The Table of Contents appears on content pages as a collapsible list of sub pages associated with the current topic.';
$_help[AT_HELP_DISPLAY_OPTIONS]='Incremental <strong><em>topic numbers</em></strong> ( eg. 1.2.6) appear before menu listings and page headings.<br><strong><em>K-Lore Help</em></strong> appears as boxes containing K-Lore usage information. Hide them once you know your way around K-Lore.';
$_help[AT_HELP_TEXTICON_OPTIONS]='You might choose to turn off icons if you are using a screen reader. If you prefer to view a graphic display, turn icons on. To reduce clutter, display icons without a text label.';
$_help[AT_HELP_MENU_OPTIONS]='Configure the display of K-Lore Menus. Choose those you use, and eliminate others. Put the most used menu at the top. ';

$_help[AT_HELP_THEME_OPTIONS]='Choose the colours and fonts that are easiest for you to view. Choose the <strong><em>Course Default Colours</em></strong>, Set Preferences for the current session, then save those settings to <em>This Course Only</em> so this course gets displayed with its own custom look-and-feel (if one has been created by the instructor)';
$_help[AT_HELP_PREFERENCES]='You might choose from the Preset preferences below, then adjust those settings in the <strong><em>Personal Preferences</em></strong> table.<br /><br />';
$_help[AT_HELP_PREFERENCES1]='The Preset <strong><em>Accessibility</em></strong> settings will strip away all non-essential navigation elements, optimizing K-Lore for use with various assistive technologies.<br /><br />';
$_help[AT_HELP_PREFERENCES2]='Preferences are first set for the session currently running. <strong><em>You must save the current settings</em></strong> if you want them to display on future visits. In the feedback box that appears after clicking "Set Preferences", choose to save those settings for the <strong><em>current course</em></strong>, or for <strong><em>all courses</em></strong>.<br /><br />';
$_help[AT_HELP_ADD_TEST1]='Click on <strong>Questions</strong> to add or modify questions. Edit availability will open the test properties.';
$_help[AT_HELP_ADD_QUESTIONS]='Click on the <strong><em>Questions</em></strong> link for the newly listed test, to add questions to it. ';
$_help[AT_HELP_ADD_QUESTIONS2]='Choose from the <strong></em>Add Questions</em></strong> links below, to add a new question. Click on <strong><em>Edit</em></strong> in the listing created for a question, to make changes.<br /><br />';
$_help[AT_HELP_PREVEIW_QUESTIONS]='Return to the <a href="tools/tests/">Test Manager</a> opening screen and click on <strong><em>Preview</em></strong> next to the listing for the test <strong><em> %1.</em></strong>';
$_help[AT_HELP_MARK_RESULTS]='Test are marked when an instructor views a submitted test and re-submits it, after which results become available to students. Multiple choice and true/false questions are marked automatically. Open ended questions require the instructor to enter a mark manually.';
$_help[AT_HELP_NETSCAPE4]='<strong style="color:#FF0000"><em>IMPORTANT</em></strong>: You appear to be using an older version of <strong><em>Mozilla/Netscape</em></strong>. While K-Lore will function adequately with this browser, a variety of features will not be available to you. We strongly recommend upgrading to a more current browser.<br /><br />';
$_help[AT_HELP_CONTROL_CENTER1]='Here you are presented with the courses you are enrolled to, and if you are a trainer, you may also see the courses that you teach. <br>Select <strong>Course Management</strong> for a global management of all courses, or <strong>User Management</strong> for managing users on this server. You may have also access to <strong>Reports</strong>, where you may extract usefull information by building a query on the current database.';
$_help[AT_HELP_CONTROL_CENTER2]='Select <strong><em>Create a New Course</em></strong> to set up the initial framework for your course. You will be placed into your course framework when you submit the intial setup, after which you may begin adding content. Your new course, and its properties, can be managed from the listing created in the <strong><em>Taught Courses</em></strong> table.';
$_help[AT_HELP_CONTROL_CENTER3]='Administrators may access only the global managementa and reporting tools. You may browse the content of any courses by entering it from the <strong>Course Management</strong>, but enrolling to a course will not work.';
$_help[AT_HELP_CONTROL_PROFILE]='Modify your Account Information by selecting the <strong><em>Edit Profile</em></strong> link in the menu to the left.';
$_help[AT_HELP_IMPORT_EXPORT]='Export course content to create backups, to create a copy of your course to import as a new course session, or to create a copy to import on to another K-Lore server.<br /><br />';
$_help[AT_HELP_IMPORT_EXPORT1]='Import an entire course into an empty course framework (created with Create a New Course), or append the content in an Export file to a course where content already exists. Depending on the size of the course you are uploading, and the speed at which you are connected to the Internet, importing may take a few while.';
$_help[AT_HELP_COURSE_EMAIL]='Send a plain text email message to all students in this course. Introduce weekly lessons, announce tests or assignments, warn students about an approaching deadline, or send any message that should be read by the entire class.';
$_help[AT_HELP_ENROLMENT]='Select a user\'s Login name to view his or her registration information.';
$_help[AT_HELP_ENROLMENT2]='Select Approve, or Disapprove, to change a user\'s enrolment status. Click "remove" to take the user off the enrolment list.';
$_help[AT_HELP_PRINT_COMPILER]='Select from the checkbox in the Content Selector below, the sections to display for printing. Then use your browser\'s print button to print the compiled content.';
$_help[AT_HELP_PRINT_COMPILER2]='If you are using one of many current browser, the K-Lore navigation elements will be hidden automatically when printing. Use your browser\'s Print Preview to see if it supports this feature.';
$_help[AT_HELP_NUMBER_QUESTIONS]='For example if you build a test with 12 questions and you want only 5 questions to be displayed at random choice.';
$_help[AT_HELP_MIN_GRADE] = 'The minimum mark a user should get to pass this test.';
$_help[AT_HELP_SPECIAL_INSTRUCTIONS] = 'You can add special instructions that will appear before the test starts.';
$_help[AT_HELP_COURSE_START_DATE] = 'Date from when you want this course to be available to students. If unchecked, this course will be available anytime.';
$_help[AT_HELP_COURSE_END_DATE] = 'Date at which you want this course to stop being available to students. If unchecked, this course will be available for an undetermined amount of time.';
$_help[AT_HELP_COURSE_PERIOD] = 'The number of days you want this course to be available to the student, once he/she started it. You may check start-date and end-date and still allow only a fixed number of days for taking this course, within that period.';
?>
