<?php
/****************************************************************/
/* klore														*/
/****************************************************************/
/* Copyright (c) 2002 by Greg Gay & Joel Kronenberg             */
/* http://klore.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

$_include_path = '../include/';
require($_include_path.'vitals.inc.php');
$_section[0][0] = 'Help';
$_section[0][1] = 'help/';
$_section[1][0] = 'Create an klore Course';

require($_include_path.'header.inc.php');
?>

<h2>Help</h2>
<h3>Creating klore Courses</h3>

	<ol>
		<li><a href="help/create_courses.php#a1">Introduction</a></li>
		<li><a href="help/create_courses.php#a2">Registering a New Course</a></li>
		<li><a href="help/create_courses.php#a3">Turn on the Editor</a></li>
		<li><a href="help/create_courses.php#a4">Adding Content Pages</a></li>
		<li><a href="help/create_courses.php#a5">Content Editing Options</a>
			<ol>
				<li><a href="help/create_courses.php#a51">Moving and Relating Topics</a></li>
				<li><a href="help/create_courses.php#a52">Learning Concept Icons</a></li>
				<li><a href="help/create_courses.php#a53">Adding Glossary Items</a></li>
			</ol>
		</li>
		<li><a href="help/create_courses.php#a6">Adding Sub-Content to Content Pages</a></li>
		<li><a href="help/create_courses.php#a7">The File Manager</a></li>
		<li><a href="help/create_courses.php#a8">Accessibility</a></li>
	</ol>


<ol>
<li><a name="a1"></a><b>Introduction</b>
<p>To create an klore course you must have your klore System Account upgraded
 to instructor status. After you have created an klore System Account and
 logged into klore, click on the <code>Instructor Account</code> request button located in
 the <code>Taught Courses</code> section of your Control Centre. This will inform your klore
 system administrator of your request, who can then upgrade your account to
 instructor status. Once your account has been upgraded a <code>Create a New Course</code>
 link will appear beside the <code>Taught Courses</code> section in your Control
 Centre.</p><br /></li>

<li><a name="a2"></a><b>Registering a New Course</b>
<p>When your account status has been upgraded to instructor, click on <code>Create a
 New Course</code> in your Control Centre to set up your new course. Provide a title
 for your course and a brief description to appear in the <code>Browse Courses</code> menu,
 and decide whether your course should be <code>Public</code>, <code>Protected</code>, or <code>Private</code>. Tip: you will likely want to set your course to <code>Private</code> to begin with, and perhaps
 change this setting to <code>Protected</code> or <code>Public</code> once your course content has been
 assembled.</p><br />

<p>When you are satisfied with your title, description, and initial settings,
 press <code>Submit</code> to complete the course setup and return to your Control Centre.
 Notice that your new course now appears in the <code>Taught Courses</code> section of your
 Control Centre. Click on the course name to open the course.</p><br /></li>

<li><a name="a3"></a><b>Turn on the Editor</b>
<p>When you enter your new course for the first time you will be placed on the
 course home page where announcements are usually found. By default the course
 editor will be turned on. For future visits you will need to enable the editor
 manually using the link that appears in the Login menu at the top of the
 screen. When you click on <code>Enable Editor</code>, the various editing tools will be
 activated. When you click on <code>Disable Editor</code> the editing tools are hidden and
 you will see exactly what a student might see.</p><br /></li>

<li><a name="a4"></a><b>Adding Content Pages</b>
<p>At the top of the <code>Global Menu</code> that appears to the left when a new course is
 accessed for the first time, will appear a link to <code>Add a Top Level Page</code>. Click
 on the link and in the form that appears enter a title for the page and insert
 the content in the <code>Body</code> textarea that appears below. Content may be formatted
 with HTML or it may be presented as plain text. Select from the two radio
 buttons below the <code>Body</code> textarea your choice of formats. It is recommended that
 you add HTML formatting to your content to create headings, lists, highlighted
 text etc. If you are not familiar with HTML find yourself one of the many  
 tutorials on basic HTML found around the Internet.</p><br />

<p>Click on the <code>Add Content</code> button below the <code>Body</code> textarea to save your newly
 created content and insert a listing into the menu. See <code>Content Editing Options</code>
 below for a description of the other tools that appear on the <code>Add Content</code>
 screen.</p><br /></li>

<li><a name="a5"></a><b>Content Editing Options</b>
<p>Once you have saved a content page you can easily edit it by clicking on <code>Edit
 This Content Page</code> that appears at the top of the content area when the editor
 is enabled. This will open a screen very similar to the <code>Add Content screen</code>.
 Edit the content as needed and click <code>Edit Changes</code> to save those changes.</p><br />

<ol><li><a name="a51"></a><b>Moving and Relating Topics</b>
<p>Use the <code>Move To</code> fields to move content pages around within a particular
 content section, or to move pages to another content section. Use the
 <code>Related To</code> fields to associate up to 4 related topics to the one you are
 currently editing. You might choose to return and update related topics once
 the content of your course is relatively well established.</p><br /></li>

<li><a name="a52"></a><b>Learning Concept Icons</b>
<p>From the selection of icons that appear at the bottom of the <code>Edit Content</code> page
 (or <code>Add Content</code> page) you may choose to embed these graphic "triggers" in your
 content to put your students in a particular frame of mind. For example insert the <code>[project]</code>
 code at the location you would like the icon to appear to suggest that the
 adjacent topic would make a good project. Or insert the <code>[write]</code> icon to
 indicate a writing exercise. Note that the <code>[link]</code> icon creates a direct link to
 the Links Database, and the <code>[discussion]</code> icon creates a link to the course
 discussion forum. (Icons will be customizable in a future version of klore).</p><br /></li>

<li><a name="a53"></a><b>Adding Glossary Items</b>
<p>To add a term or phrase to your course glossary, while you are editing your
 content simply embed the term between the question mark tags like so
 <code>[?]glossary term[/?]</code>. When you save your content you will be asked to provide a
 definition for the term or phrase if it does not already appear in the
 glossary. Provide a definition in the associated textarea then click <code>Add Term</code>
 to save it to the glossary.</p><br />

<p>When adding a new term to your course glossary you may also choose to relate
 the term to another, or you may choose to ignore the term, if for example you
 had already defined the term earlier in the page.</p><br /></li>

</ol></li>

<li><a name="a6"></a><b>Adding Sub-Content to Content Pages</b>
<p>To add sub-content to a content page click on  <code>Add Sub Content to This Page</code>
 which appears with the other editing links at the top of the content area while
 the editor is enabled. The interface to add sub-content is identical to that
 used for adding a content page, and functions in the same way. When you save
 sub-content it appears as a separate page, adds a link to the content list that
 appears on the parent content page, and inserts an indented listing in the menu
 under the listing for its parent page. You may create as many levels of
 sub-content as you like, though a maximum of 4 or 5 levels is recommended.
 </p><br /></li>


<li><a name="a7"></a><b>The File Manager</b>
<p>You many upload a variety of different types of files to your course
 directory with the <code>File Manager</code>, and link to those files from within your
 content. You will find the <code>File Manager</code> linked from the <code>Tools</code> page. Click on
 the <code>Browse</code> button to locate the file on your hard drive then press <code>Upload
 File</code> to save it to your course directory on the klore server. You may also
 create sub-directories into which you can sort your course files, if for
 example you wish to locate all your images into the same directory, your HTML
 files in another directory, and all your downloadable word processed documents in
 another directory. To link to a course file use a standard HREF tag in the
 following format:</p><br />

<p><code>&lt;a href="content/COURSE_ID/FILENAME"&gt;Link to a sample file&lt;/a&gt;</code>
<br /><br />
or<br /><br />
<code>&lt;a href="content/212/samplefile.html"&gt;Link to a sample file&lt;/a&gt;</code>

<br /><br />Or to link to an image use a standard HTML image tag as follows<br /><br />
<code>&lt;img src="content/212/images/testimage.gif" alt="test image" /&gt;</code></p><br />

<p>You may use HTML or Javascript to control how your files are
 displayed, for example to open a file into a new window. You might decide to
 upload word processed documents for your students to download. For advanced
 users you might choose to upload PHP scripts to perform your own customized
 functionality. HTML markup , Javascript, and PHP scripting are beyond the scope
 of this help page. See any of the many tutorials found around the Web for more
 about using HTML, Javascript and PHP in your content.</p><br />

<p>By default a limit of 500KB (½ MB) is set as the maximum size for individual
 files, and a limit of 5 MB is set for the total size of all files uploaded to a
 course. Contact your system administrator if you need to upload larger files or
 require more than 5 MB of space.</p><br /></li>


<li><a name="a8"></a><b>Accessibility</b>
It is important to consider the technology being used and the abilities of your
 students when creating content to be uploaded and linked from the content in your
 course. klore has been developed so users with older technology and students
 with disabilities using assistive technologies, will still have full access to
 the klore environment. Review the <a href="http://www.websavvy-access.org/resources/top_ten.shtml">Top 10 Accessible Web Authoring Practices</a>
 for more about the strategies you can apply during the creation of your content
 to be sure that all your students will be able to access it.</p><br />

</li>
</ol>

<?php
	require($_include_path.'footer.inc.php');
?>