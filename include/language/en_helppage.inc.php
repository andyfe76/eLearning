<?php
//The English Help Page
?>
<h3>Accessibility</h3>
<ul>
<li><a href="help/accessibility.php?g=18">K-Lore Accessibility Features</a>
<br />Using K-Lore with assistive technology -- and other access features.
</li>
</ul>
<br />
<h3>About K-Lore Help</h3>
<ul>
<li><a href="help/about_help.php?g=18">About K-Lore Help</a><br />Learning about various sources of K-Lore help, and the help display options available.</li>
</ul>
<br />
<h3>K-Lore HowTo</h3>
<ul>
<li>The <a href="http://k-lore.koncept.ro/howto.php?g=18">K-Lore HowTo</a> course contains the documentation for K-Lore. Choose the topics that apply to you. K-Lore HowTo may also be available on your local system. Check "<a href="browse.php">Browse Courses</a>."</li>
</ul>
<br />
<h3>K-Lore Support Forum</h3>
<ul>
<li>If after reviewing the Help sources listed above, your questions have not been answered, post them to the <a href="http://k-lore.koncept.ro/forum/index.php">K-Lore Support Forum</a> on the K-Lore Web site. Scan through topics in the Support Forum to see if your questions have already been answered. <strong>Support questions should be of a technical nature</strong>. Course related questions should be directed to the course forums or the course instructor. </li>
</ul>
<br />
<h3>Contacts</h3>
<ul>
	<?php if ($_SESSION['is_admin']) { ?>
	<li>For Instructors Only:<br />
		<ul>
			<li><a href="help/contact_admin.php">K-Lore System Administrator Contact Form</a></li>
		</ul>
	</li>
	<?php } else {
		echo '<li><a href="help/contact_instructor.php?g=18">Course Instructor Contact Form</a></li>';
	} ?>
</ul>
<br />
<br />
<br />
<?php

?>
