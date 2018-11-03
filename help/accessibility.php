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
$_section[0][0] = $_template['help'];
$_section[0][1] = 'help/';
$_section[1][0] = $_template['klore_accessibility'];

require($_include_path.'header.inc.php');
?>

<h2><a href="help/?g=11"><?php echo $_template['help']; ?></a></h2>
<h3><?php echo $_template['klore_accessibility']; ?></h3>

<p>klore includes a variety of features designed to ensure that content is accessible to all potential users ? including those with slow Internet connections, older Web browsers, and people with disabilities using assistive technologies to access the Web. These features are described in detail below.</p>

<ol>
<li><b>ByPass Links</b>: In the top left corner of klore are a number of hidden bypass links that allow assistive technology users to skip over the navigation elements and jump directly to the content being displayed. Press the Tab key once after a page has finished loading to advance to the first bypass link then press Enter to reposition the content to the top of your screen. Alternatively, users can press the Tab key twice, then Enter to jump directly to the top menu array. Press the Tab key a third time to jump to the first Tab (Home) in the main navigation bar.  Press the Tab key a forth time to jump to the Accessibility page (this page) for information on configuring klore to work effectively with your assistive technology.</li>

<li><b>Default Accessibility Preference Configuration</b>: klore has a default accessibility configuration that hides all non-essential images and navigation tools when activated. <b>During registration</b> select "Enable the Accessibility preferences scheme" to load the default accessibility settings when you enter klore. This removes most of the images from klore, and closes the Menu, leaving a pair of sequence links as the primary navigation tools. klore's accessibility configuration can also be loaded by selecting the <b>Preset Preference</b> labelled  "<a href="tools/preferences.php?pref_id=1">Accessibility</a>" near the top of the Preferences page. Screen reader users are advised to begin with this default preference setting and then modify those settings later through the Preferences page (if necessary). </li>

<li><b>Accesskeys:</b> Keyboard accessibility has been added to many klore features. To activate accesskeys, press Alt plus the assigned number or letter as follows:
<ul>
<li>[Alt 1] Home</li>
<li>[Alt 2] Tools</li>
<li>[Alt 3] Resources</li>
<li>[Alt 4] Discussions</li>
<li>[Alt 5] Help</li>
<li>[Alt 6] Toggle menus open and closed</li>
<li>[Alt 7] Global Menu</li>
<li>[Alt 8] Previous topic</li>
<li>[Alt 9] Next topic</li>
<li>[Alt 0] Resume</li>
<li>[Alt y] Main Navigation</li>
<li>[Alt m] Menus</li>
<li>[Alt j] Jump Menu</li>
<li>[Alt s] Submit (active on form pages)</li>
<li>[Alt c] Jump to content top (top and bypass link)</li>
</ul>
 </li>
<li><b>Alternative Text:</b> All images in klore include a text alternative that describes the image or its function.</li>
<li><b>Alternative Navigation:</b> Global, hierarchical, and sequential navigation tools are available so users can view or structure content in a manner that suits their style of learning. See the Help pages or the klore HowTo course for more information about klore's navigation features.</li>
<li><b>Hide Menus:</b> For users of older assistive technologies that do not support columnar text laid out in tables, it is possible to hide klore's menus so that content will be displayed in a linear presentation. Hiding menus also conserves space for users with smaller monitors.</li>
<li><b>Text or Images:</b> klore users can choose to have navigational features displayed as either text, icons, or text and icons through a variety of preference settings.</li>
<li><b>Form Labels:</b> All form fields throughout klore are marked up using the LABEL element to ensure that they are properly described for assistive technology users. Explicit labelling in this manner also makes it possible to click on a form field's label to activate the field. This provides a larger target area for those people who have difficulty positioning a mouse pointer on a small form field such as a radio button or a checkbox.</li>
<li><b>Style Sheets:</b> Wherever possible, the presentation of content in klore is controlled by style sheet elements. This allows users to override klore's default appearance and apply their own preferred presentation styles (i.e. increased font sizes, different font styles, colours, etc.) </li>
<li><b>Form Field Focus:</b> For pages where the primary content is a form, the mouse cursor will automatically be placed in the first field so that after a form page loads, it is not necessary to click or Tab into a field. Rather, users can begin typing text into the form as soon as the page has finished loading.</li>
</ol>
<?php
require($_include_path.'footer.inc.php');
?>
