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
$_section[1][0] = 'Using klore';

require($_include_path.'header.inc.php');
?>

<h2>Help</h2>
<h3>klore Content Navigation and Preference Settings</h3>

	<ol>
		<li><a href="help/using_klore.php#a1">Introduction</a></li>
		<li><a href="help/using_klore.php#a2">Navigation</a>
			<ol>
			<li><a href="help/using_klore.php#a21">Login Navigation</a></li>
			<li><a href="help/using_klore.php#a22">Main Navigation</a></li>
			<li><a href="help/using_klore.php#a23">Breadcrumb Navigation</a></li>
			<li><a href="help/using_klore.php#a24">Local Menu</a></li>
			<li><a href="help/using_klore.php#a25">Global Menu</a></li>
			<li><a href="help/using_klore.php#a26">Previous/Next</a></li>
			<li><a href="help/using_klore.php#a27">Content Menu</a></li>
			<li><a href="help/using_klore.php#a28">Heading Navigation</a></li>
			<li><a href="help/using_klore.php#a29">Related Topics</a></li>
			<li><a href="help/using_klore.php#a210">Context Navigation</a></li>
			<li><a href="help/using_klore.php#a211">Sitemap</a></li>
			</ol>
		<li><a href="help/using_klore.php#a3">Preferences</a></li>
	</ol>

<ol>
<li><a name="a1"></a><b>Introduction</b>
<p>A primary goal in the development of klore has been to create a learning
 environment that learners could customize to their liking. These customizations
 include various navigation and preference settings, and are outlined below.</p><br /></li>

<li><a name="a2"></a><b>Navigation</b>
<p>There are many ways to navigate through the information presented in an
 klore course.  You may choose to use a subset of the navigation tools, if your
 preference is to navigate through a course's content in a global, hierarchical,
 or sequential manner. The various navigation tools are described here.</p><br /></li>

<ol><li><a name="a21"></a><b>Login Navigation</b>
<p>The Login Navigation bar that appears across the very top of the klore
 learning environment provides links to <code>Log-In</code> (or <code>Log-Out</code>), a link to the
 preferences page where customizations can be made, for instructors there is a
 link to turn the content editor on and off, and there is a drop down menu for
 quick access to other courses you are enrolled in as well as access to your
 Control Centre.</p>
 <br />
 <p>Use accesskey ALT-7 to jump to course selector.</p><br /></li>

<li><a name="a22"></a><b>Main Navigation</b>
<p>The Main Navigation appears below the Login Navigation and
 includes a number of tabs which lead to major areas within klore. The <code>Home</code> tab
 will return you to the course home page where the announcements appear. You
 might choose to use this link to reorient yourself if you become lost within
 the content of a course. The <code>Tools</code> tab leads to a collection of various
 learning tools, and for the instructor, various content management tools. The <code>Resources</code> tab
 leads to supplementary materials, such as Web sites, where additional
 information can be found on the topics being covered. The <code>Discussions</code> tab leads
 to the online bulletin board and chat room. And, the <code>Help</code> tab leads to various
 documents on using klore, and taking klore courses, as well as links to
 contact your instructor or system administrator.</p>
 <br />
 <p>Use accesskey ALT-1 through ALT-6 to jump to the main navigation.</p><br /></li>

<li><a name="a23"></a><b>Breadcrumb Navigation</b>
<p>The Breadcrumb Navigation appears immediately below the Main Navigation. The
 "breadcrumbs" appear as a string of links indicating where you are within the
 content of a course. Each of the links in the breadcrumbs will return you to
 the upper most page in any given content section.</p><br /></li>

<li><a name="a24"></a><b>Local Menu</b>
<p>The Local Menu is a collapsible menu that displays the pages in the content
 module you are currently viewing. Where previous and subsequent modules exist,
 links appear at the top and bottom of the Local Menu to move between modules.
 Click on any of the listed topics in the Local Menu to open that topic. The
 Local Menu may be closed if you prefer not to use it (also see Global
 Menu).</p><br /></li>

<li><a name="a25"></a><b>Global Menu</b>
<p>The Global Menu works much like the Local Menu, except it can display the
 content of the entire course, as well as links to various klore tools, such as
 the <code>Sitemap</code>, and the <code>Glossary</code>. By default the Global Menu displays only the
 opening page in each module. Click on the plus sign (<code>+</code>) beside a topic to open
 a section within the menu and display its sub-content, or click on the minus
 sign (<code>-</code>) to hide sections.</p><br />

<p>The Global Menu will recall where you left off in your previous session and
 automatically open the associated section of the menu, and highlight your last
 visited page so you can identify where you were within the content when you
 return for a new session. The Global Menu (and Local Menu) will also recall the
 page you left off on if you navigate outside the course content, perhaps to the
 <code>Tools</code>, <code>Resources</code>, or <code>Help</code> pages, or even to another Web site, so you can easily find your way back to that page when you return to the course content.</p><br />

<p>Where the wording of topics in the Global Menu are longer than the width
 allowed, you can position your mouse pointer over the topic to display the full
 wording (this only works in current browsers that support the HTML <code>title</code>
 attribute). You may also choose to display topic numbering within the menus
 either by selecting this option from the Preferences page. You
 may also choose to position the Global Menu (and other menus) on the right or
 left side of the screen, or hide them altogether.</p><br /></li>

<li><a name="a26"></a><b>Previous/Next</b>
<p>While you are within the content of a course, <code>Previous</code> and <code>Next</code> links will
 appear at the top or bottom of the page, depending on your preference, which
 you can use to navigate through course content in sequence.</p>
 <br />
 <p>Use accesskey ALT-8 to jump to the <code>Previous</code> link; ALT-9 for the <code>Next</code> link, and ALT-0 for the <code>Resume</code> link if it is available.</p><br /></li>


<li><a name="a27"></a><b>Content Menu</b>
<p>While you are within a content section that includes sub-content, a listing
 for each of the sub-content sections will appear as a table of contents at the top of
 the section's opening page, providing links to each of the pages within that
 section. With a preference setting the Content Menus can be located at the top
 or bottom of the page.</p><br /></li>

<li><a name="a28"></a><b>Heading Navigation</b>
<p>While in sub-content sections, the headings that appear at the top
 of the page provide links back to the upper most page in any particular
 section, much like the breadcrumb links provide a means of moving up through
 levels of a particular content section.</p><br /></li>

<li><a name="a29"></a><b>Related Topics</b>
<p>Instructors have the option of linking to various content sections to other related
 content sections throughout a course. These links appear in the the Related
 Topics Menu where they exist and can be used to understand relationships between
 various topics in a course.</p><br /></li>

<li><a name="a210"></a><b>Context Navigation</b>
<p>Instructors may also manually create links within the course content to other
 content sections. Click on the links embedded within content to navigate through
 the topics in a module or to navigate to other related information throughout
 the content of the course.</p><br /></li>

<li><a name="a211"></a><b>Sitemap</b>
<p>The Sitemap provides a listing of all the content in a course. It
 functions much like the Global Menu though it provides links to content as well
 as various tools, resources and help pages.</p><br /></li>
</ol>
</li>

<li><a name="a3"></a><b>Preferences </b>
<p><b>(Currently under development)</b></p><br />
<p>A variety of preference settings are available to control the look and layout
 of the klore environment. Preferences can be controlled through the Preferences page. Preference settings are
 maintained across sessions and across courses on any given klore
 system.</p><br />

<p><b>Preference setting include:</b>
<br />Position of the Menu: either left or right
<br />Position of the Previous/Next link: either top or bottom of the page
<br />Position of the section table of contents: either top or bottom of the
 page
<br />Display topic numbering: on or off
</p><br />
</li>
</ol>

<?php
require($_include_path.'footer.inc.php');
?>
