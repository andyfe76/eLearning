<?php
// phphoo2 - a yahoo-like link directory written in PHP3
// Copyright (C) 1999/2000 Rolf V. Ostergaard http://www.cable-modems.org/phpHoo/

require('mysql.php');			// Access to all the database functions
require('myheadfoot.php');		 // The header and footer files
$_include_path= '../../include/';
require ($_include_path.'vitals.inc.php');
$_section[0][0] = $_template['resources'];
$_section[0][1] = 'resources/';
$_section[1][0] = $_template['links_db'];
$_section[1][1] = 'resources/links/';

// Need to set these constant variables:
$ADMIN_MODE = false;			// Set true for admin version
$SEE_ALL_SUBMISSIONS = true;		// Set false to show submissions in this category only
$SITE_URL = 'resources/links/index.php';
$FULL_ADMIN_ACCESS = true;		// True to allow admin to create categories
$TOP_CAT_NAME = $_template['newest_links'];			// Name of the top "category"


if (($_SESSION['is_admin']) && ($_SESSION['prefs'][PREF_EDIT])) {
	$ADMIN_MODE = true;
}

// Open the database
$db2 = new MySQL;
if(!$db2->init()) {
	$errors[]=AT_ERROR_NO_DB_CONNECT;
	print_errors($errors);
	exit;
}

if ($_GET['add']) {
	$_section[2][0] = $_template['add_new_link'];
} else if ($_GET['edit_link']) {
	$_section[2][0] = $_template['edit_link'];
}


if ((!$_GET['view']) && (!$adminpass)) {
	breadcrumbs($_GET['viewCat']); // has to be here because of the include.
	require($_include_path.'header.inc.php');

	//echo '<h2><a href="resources/?g=11">'.$_template['resources'].'</a></h2>';
	//echo '<h3><a href="resources/links/?g=11">'.$_template['links_db'].'</a></h3>';
}

function show_submissions_list($CatID)
{
	global $PHP_SELF;
	global $db2;
	global $SEE_ALL_SUBMISSIONS;
	global $TOP_CAT_NAME;
	global $_template;

	if ($SEE_ALL_SUBMISSIONS) {
		$sub = $db2->get_Submissions();
	} else {
		// Need to replace with function to show only for this CatID
		$sub = $db2->get_Submissions();
	}

	echo '<ul class="list">';
	if(!empty($sub))
	{
		while ( list ( $key,$val ) = each ($sub))
		{
			$Url		= stripslashes($val['Url']);
			$LinkName	= stripslashes($val['LinkName']);
			$Desc		= stripslashes($val['Description']);
			$Name		= stripslashes($val['SubmitName']);
			$Email		= stripslashes($val['SubmitEmail']);
			$SDate		= stripslashes($val['SubmitDate']);
			$LinkID		= stripslashes($val['LinkID']);
			$LinkCatID	= stripslashes($val['CatID']);

			if(!empty($LinkCatID)) {
				$LinkCatName = $db2->get_CatNames($LinkCatID);
			} else {
				$LinkCatName = $TOP_CAT_NAME;
			}

			print '<li>';
			print "<a href=\"$Url\" target=\"_blank\"><b>$LinkName</b></a> - $Desc<br />\n";
			print "<small class=\"spacer\">URL: $Url</small>\n";
			// Print submitter name and email
			print " <small class=\"spacer\">(Name: <a href=\"mailto:$Email\">$Name</A> - $Email)</small><br />\n";
			
			// Print category
			print " <small class=\"spacer\">Category: $LinkCatName</small><br />\n";

			print "<small>[";
			// Link to approve a sumbission
			print "<a href=\"$PHP_SELF?CatID=$CatID".SEP."approve=$LinkID\">".$_template['approve']."</a> ";

			// Link to delete a sumbission
			print "<a href=\"$PHP_SELF?CatID=$CatID".SEP."delete_link=$LinkID\">".$_template['delete']."</a> ";

			// Link to edit a sumbission
			print "<a href=\"$PHP_SELF?CatID=$CatID".SEP."edit_link=$LinkID\">".$_template['edit']."</a>";
			print "]</small>";
			print "</li>";
		}
	}
	print "</ul>\n";
	return;
}

function start_page($CatID="",$title="",$msg="")
{
	global $PHP_SELF;
	global $SITE_URL;
	global $_template;
	print_header($CatID,$title,$msg);
	
	if(!empty($msg)) {
		print_feedback($msg);
	}

	$warnings[] = AT_WARNING_LINK_WINDOWS;
	print_help($help);
	print_warnings($warnings);

	print '<center><form action="'.$PHP_SELF.'" method="post">';
	print '<input type="text" name="KeyWords" size="20" class="formfield" /> <input type="submit" name="Search" value="'.$_template['search'].'" class="button" /></center>';
	print '<input type="hidden" name="CatID" value="'.$CatID.'" />';
	print '</form>';	
	return;
}

function start_browse($CatID='')
{
	global $PHP_SELF;
	global $db2;
	global $ADMIN_MODE;
	global $TOP_CAT_NAME;
	global $SITE_URL;
	//global $system_courses;
	global $_template;
	$data	= $db2->get_Cats($CatID);

	if ($CatID != 0){
		$links	= $db2->get_Links($CatID);
	} else {
		$links = $db2->get_Links('-1');	// get the new links
	}

	$OurCatID = $CatID;

	if(empty($CatID) || ($CatID == '0'))
	{
		$currentID = 'top';
		$currentName = "$TOP_CAT_NAME";
	} else {
		$currentID = $CatID;
		$currentName = $db2->get_CatNames($CatID);
	}

	// Print list of sub categories
	if(!empty($data))
	{
		$data_cnt = count ($data);
		$data_left = $data_cnt >> 1;

  		if($_SESSION['is_admin'] && ($_SESSION['prefs'][PREF_EDIT])) {
			$help[] = AT_HELP_CREATE_LINKS;
		}
		$help[] = AT_HELP_CREATE_LINKS1;

		print_help($help);

		print '<center>';
		print '<table border="0" cellpadding="2" cellspacing="0" summary=""><tr><td width="50%" align="left" valign="top">';

		while ( list ( $key,$val ) = each ($data))
		{
			$CatID = stripslashes($val["CatID"]);
			$CatName = stripslashes($val["CatName"]);
			$LinksInCat = $db2->get_TotalLinksInCat_cnt($CatID);

			print "<a href=\"$SITE_URL?viewCat=$CatID\"><b><span class=\"catname\">$CatName</span></b></a>";
			if ($ADMIN_MODE) {
				echo ' <small>( <a href="resources/links/edit_cat.php?CatID='.$CatID.'">'.$_template['edit'].'</a>, <a href="resources/links/delete_cat.php?CatID='.$CatID.'">'.$_template['delete'].'</a> )</small>';
			}
			print ' <em><small>('.$LinksInCat.')</small></em>';
			$db2->get_ChildrenInt($CatID);
			$children = $db2->TRAIL;
			if (!empty($children))
			{
				print '<br />';
				$counter = 0;
				while (( list ( $child_key,$child_val ) = each ($children)) && ($counter < 3))
				{
					$Child_CatID = stripslashes($child_val["CatID"]);
					$Child_CatName = stripslashes($child_val["CatName"]);
					if ($counter == 2) {
						print ", <a href=\"$SITE_URL?viewCat=$Child_CatID\"><span class=\"catname\">$Child_CatName</span></a>...";
					} else if ($counter == 0) {
						print "<a href=\"$SITE_URL?viewCat=$Child_CatID\"><span class=\"catname\">$Child_CatName</span></a>";
					} else {
						print ", <a href=\"$SITE_URL?viewCat=$Child_CatID\"><span class=\"catname\">$Child_CatName</span></a>";
					}

					$counter ++;
				}
				echo '</span>';
			} 
			echo '<br />';
			$data_cnt--;
			if ($data_cnt == $data_left) {
				echo '</td><td width="50%" align="left" valign="top">';
			}
		}
		print '</td></tr></table>';
		print '</center>';
	}
	$CatID = $OurCatID;	// restore CatID

	print "<h3>$currentName:</h3>\n";
	// Print list of links
	print "<ul>\n";
	if(!empty($links))
	{
		while ( list ( $key,$val ) = each ($links))
		{
			$Url		= stripslashes($val["Url"]);
			$LinkName	= stripslashes($val["LinkName"]);
			$Desc		= stripslashes($val["Description"]);
			$LinkID		= stripslashes($val["LinkID"]);
			$Hits		= stripslashes($val["hits"]);
			$SDate		= stripslashes($val["SubmitDate"]);

			print "<li>";
			print "<a href=\"$SITE_URL?view=$LinkID\" target=\"_new\" class=\"catname\"><b>$LinkName</b></a> - <small>$Desc</small>\n";
			print "<span class=\"spacer\"><small>[".$_template['hits'].": $Hits\n";
			print $_template['added'].": $SDate]</small></span><br />\n";
			if ($ADMIN_MODE) {
				$Name		= stripslashes($val["SubmitName"]);
				$Email		= stripslashes($val["SubmitEmail"]);
				
				// Print submitter name and email
				print " <small>(".$_template['name'].": <a href=\"mailto:$Email\">$Name</A> - $Email)</small><br />\n";

				// Link to disapprove a sumbission
				print "<small>[<a href=\"$PHP_SELF?CatID=$CatID".SEP."disapprove=$LinkID\">".$_template['disapprove']."</a> ";

				// Link to edit a sumbission
				print "<a href=\"$PHP_SELF?CatID=$CatID".SEP."edit_link=$LinkID\">".$_template['edit']."</a>]</small>";
			}
			print "</li>\n";
		}
	} else {
		echo '<li>'.$_template['no_links'].'</li>';
	}
	print "</ul>\n";

	if ($CatID != 0)
	{
		print "<p align=\"center\"><br />";
		print " <a href=\"$SITE_URL?add=$currentID\">".$_template['suggest_new_link']."</a> ";
		print "</p>\n";
	}
	if ($ADMIN_MODE) {
		print "\n<hr />\n";
		print "<h1>".$_template['submissions']."</h1>\n";

		show_submissions_list($CatID);
		$CatID = $OurCatID;	// restore CatID
			
		// Show form to add a subcategory
		print "\n<hr />\n";
		print "<center><p>
		<form action=\"$PHP_SELF\" method=\"post\">
		<input type=\"hidden\" name=\"CatID\" value=\"$CatID\" />
		<strong>".$_template['new_category'].":</strong> <input name=\"NewCatName\" size=\"40\" class=\"formfield\" />
		<input type=\"submit\" class=\"button\" name=\"add_cat\" value=\" ".$_template['create']." \" accesskey=\"s\"/>
		</form>
		</p></center>\n";
	}

	// Print the footer

	if ($_SESSION['is_admin']) {
		echo '<br /><p><small class="spacer" title="'.$_template['links_pending'].'">(';
		echo $db2->get_approved_cnt();
		echo '/';
		echo $db2->get_not_approved_cnt();
		echo ')</small></p>';
	}

	return;
}

// Print drop-down box for available categories
function show_cat_selection($SelName = "CatID", $IncludeTop = true, $SecSel = "NULL")
{
	global $PHP_SELF;
	global $db2;
	global $ADMIN_MODE;
	global $TOP_CAT_NAME;

	print "<select name=\"$SelName\" size=\"1\">\n";
	if ($IncludeTop) {
		if ($SecSel == "NULL") {$sel = "selected ";} else {$sel = "";}
		print "<option $sel value=\"0\">$TOP_CAT_NAME</option>";
	};

	$secs = $db2->get_AllCats();

	if(!empty($secs))
	{
		while (list ($key, $val) = each ($secs))
		{
			// Run for all sections:
			$CatID		= $val["CatID"];
			$CatName	= $val["CatName"];

			if ($CatID == $SecSel) {$sel = "selected ";} else {$sel = "";}
			print "<option $sel value=\"$CatID\">$CatName</option>\n";
		}
	}
	print "</select>\n";

	return;
}

function show_edit_link($LinkID="",$title="",$msg="") 
{
	global $PHP_SELF;
	global $db2;
	global $TOP_CAT_NAME;
	global $FULL_ADMIN_ACCESS;
	global $_template;
	print_header($CatID,$title,$msg);

	$thislink = $db2->get_OneLink($LinkID);
	if (empty($thislink)) {
		print "<p>".$_template['bad_link'] ."</p>
		<HR noshade>
		</form></p>
		</html>\n";
		return;
	}

	while ( list ( $key,$val ) = each ($thislink))
	{
		$CatID		= stripslashes($val["CatID"]);
		$Url		= stripslashes($val["Url"]);
		$LinkName	= stripslashes($val["LinkName"]);
		$Desc		= stripslashes($val["Description"]);
		$Name		= stripslashes($val["SubmitName"]);
		$Email		= stripslashes($val["SubmitEmail"]);
		$SDate		= stripslashes($val["SubmitDate"]);
	}
 
	if(!empty($CatID))
	{
		$LinkCatName = $db2->get_CatNames($CatID);
	} else {
		$LinkCatName = "$TOP_CAT_NAME";
	}

	?>
	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<input type="hidden" name="LinkID" value="<?php echo $LinkID; ?>" />
	<p>
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="">
	<tr>
		<td class="cat" colspan="2"><h4><?php  echo $_template['edit_resource_in']; ?>: <b><?php echo $LinkCatName; ?></h4></td>
	</tr>
	<tr>
		<td class="row1" align="right"><label for="url"><b><?php  echo $_template['url']; ?>:</b></label></td>
		<td class="row1"><input name="Url" class="formfield" size="40" value="<?php echo $Url; ?>" id="url" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right"><label for="title"><b><?php  echo $_template['title']; ?>:</b></label></td>
		<td class="row1"><input name="LinkName" class="formfield" size="40" value="<?php echo $LinkName; ?>" id="title" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="desc"><b><?php  echo $_template['description']; ?>:</b></label></td>
		<td class="row1"><textarea name="Description" class="formfield" rows="5" cols="45" id="desc"><?php echo $Desc; ?></textarea></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="name"><b><?php  echo $_template['your_name']; ?>:</b></label></td>
		<td class="row1"><input name="SubmitName" class="formfield" value="<?php echo $Name ?>" size="40" id="name" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="email"><b><?php  echo $_template['your_email']; ?>:</b></label></td>
		<td class="row1"><input name="SubmitEmail" class="formfield" value="<?php echo $Email ?>" size="40" id="email" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><b><?php  echo $_template['category']; ?>:</b></td>
		<td class="row1" valign="top"><?php show_cat_selection("CatID", True, $CatID); ?><br /><br /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" colspan="2" align="center"><input type="submit" name="update" value="<?php  echo $_template['update_resources']; ?> Alt-s" class="button" accesskey="s" /> <input type="reset" value="<?php echo $_template['reset'];?> " class="button" /></td>
	</tr>
	</table>
	</p>
	</form>
	<?php

	return;
}

function show_add_link($add = "NULL", $CatName = "unknown")
{
	global $PHP_SELF;
	global $_template;
	global $db2;
	global $TOP_CAT_NAME;
	global $FULL_ADMIN_ACCESS;
	global $UserName;		// Cookie
	global $UserEmail;		// Cookie

	$help[] = AT_HELP_ADD_RESOURCE;
	$help[] = AT_HELP_ADD_RESOURCE1;
	print_help($help);
	?><h3><?php echo $_template['add_link_in']; ?> <?php echo $CatName ?>:</h3>

	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<input type="hidden" name="CatID" value="<?php echo $add ?>" />

	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" align="center" summary="">
	<tr>
		<th class="left" colspan="2"><?php print_popup_help(AT_HELP_ADD_RESOURCE_MINI); ?><?php echo $_template['add_new_resource']; ?></th>
	</tr>
	<tr>
		<td class="row1" align="right"><label for="url"><b><?php echo $_template['url']; ?>:</b></label></td>
		<td class="row1"><input name="Url" class="formfield" size="40" value="http://" id="url" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right"><label for="title"><b><?php echo $_template['title']; ?>:</b></label></td>
		<td class="row1"><input name="LinkName" class="formfield" size="40" id="title" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="desc"><b><?php echo $_template['description']; ?>:</b></label></td>
		<td class="row1"><textarea name="Description" class="formfield" rows="5" cols="45" id="desc"></textarea></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="name"><b><?php echo $_template['your_name']; ?>:</b></label></td>
		<td class="row1"><input name="SubmitName" class="formfield" value="<?php echo $UserName ?>" size="40" id="name" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1" align="right" valign="top"><label for="email"><b><?php  echo $_template['your_email']; ?>:</b></label></td>
		<td class="row1"><input name="SubmitEmail" class="formfield" value="<?php echo $UserEmail ?>" size="40" id="email" /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td colspan="2" class="row1" align="center"><input type="submit" name="suggest" class="button" value="<?php  echo $_template['submit_resource']; ?> Alt-s" accesskey="s" /></td>
	</tr>
	</table>
	</form>
	<?php
	return;
}

// Mail the admin anytime a new link is submitted
function mail_new_link($postData = '')
{
	global $PHP_SELF;
	global $db2;
	global $ADMIN_EMAIL;
	global $_template;
	if( (empty($_POST)) or (!is_array($_POST)) ) { return false; } 
	if ($ADMIN_EMAIL == '') { return false; }

	$CatID = $_POST["CatID"];
	$Url = addslashes($_POST["Url"]);
	$Description = addslashes($_POST["Description"]);
	$LinkName = addslashes($_POST["LinkName"]);
	$SubmitName = addslashes($_POST["SubmitName"]);
	$SubmitEmail = addslashes($_POST["SubmitEmail"]);
	$SuggestNewCategory = addslashes($_POST["SuggestNewCategory"]);
	$SubmitDate =  date("Y-m-d");

	// Get category information
	$secs = $db2->get_CatNames($CatID);
	$CatName = $_template['unknown'];
	if (!empty($secs)) {
		$CatName = $secs;
	}

	$Subject = $_template['new_link'].": ";
	$Subject .= substr($LinkName, 0, 60);
	if ($LinkName != substr($LinkName, 0, 60)) {
		$LinkName .= "...";
	}
	$Subject = trim($Subject);

	$Body = $_template['user'].' '.$SubmitName.'" <'.$SubmitEmail.'> '.$_template['user2'].' '. $CatName.":\n\n";
	$Body .= "$LinkName ".$_template['at']." <$Url>\n\n";
	$Body .= "$Description\n\n";
	if ($SuggestNewCategory != ''){
		$Body .= $_template['new_cat_suggested'].": $SuggestNewCategory\n\n";
	}
	if ($AUTOAPPROVEQUE) {
		$Body .= $_template['link_auto_approved']."\n";
	} else {
		$Body .= $_template['link_needs_approval']."\n";
		$Body .= $_template['use2']." $PHP_SELF".$_template['use2']."\n";
	}
	
	$From = "$SubmitName<".$SubmitEmail.">";

	// Send the email notice if email defined
	if ($ADMIN_EMAIL) {
		admin_mail($ADMIN_EMAIL, $Subject, $Body, $From);
	}

	return;
}

//	*****************************************************************

$query = getenv('QUERY_STRING');

if( ($_REQUEST['viewCat']) || ( (!$_POST) && (!$query) ) )
{
	start_page($_REQUEST['viewCat']);
	start_browse($_REQUEST['viewCat']);
	require($_include_path.'footer.inc.php'); 
	exit;
} elseif ($_REQUEST['view']) {
	$db2->increment_count($_REQUEST['view']);
	exit;
} elseif($_REQUEST['add']) {
	if (("$add" == "top") || empty($_REQUEST['add'])) { 
		$add = 0; 
		$CatName = "$TOP_CAT_NAME"; 
	} else {
		$CatName = stripslashes($db2->get_CatNames($_REQUEST['add']));
		if (empty($CatName)) { $CatName = "$TOP_CAT_NAME"; }
	}

	$junk = "";	
	print_header($_REQUEST['add'],$title,$junk);
	show_add_link($_REQUEST['add'], $CatName);

	require($_include_path.'footer.inc.php');  
	exit;

} elseif($_REQUEST['add_cat']) {
	$junk = "";
	$err_msg = "";
	if ($ADMIN_MODE && $FULL_ADMIN_ACCESS) {
		if(!$db2->add_cat($_POST,$err_msg))
		{
			$title = $_template['cat_create_error'];
			$msg = $_template['cat_not_created']." ".$err_msg;
		} else {
			$title = $_template['cat_created'];
			$msg = $_template['sub_created'];
		}
	} else {
		$title = $_template['cat_create_error'];
		$msg = $_template['cat_not_authorized'];
	}
	start_page($_REQUEST['CatID'],$title,$msg);
	start_browse($_REQUEST['CatID']);
	require($_include_path.'footer.inc.php');  
	exit;

} elseif ($_REQUEST['suggest']) {
	$junk = "";
	$err_msg = "";
	if(!$db2->suggest($_POST,$err_msg))
	{
		$title = $_template['suggestion_error'];
		$msg = $_template['suggestion_not_accepted'].": ".$err_msg;
	} else {
		$title = $_template['suggestion_submitted'];
		$msg = $_template['suggestion_submitted_approval'];
		mail_new_link($_POST);
	}
	start_page($_REQUEST['CatID'],$title,$msg);
	start_browse($_REQUEST['CatID']);
	require($_include_path.'footer.inc.php');  
	exit;

} elseif ($_REQUEST['update']) {
	$junk = "";
	$err_msg = "";
	if ($ADMIN_MODE) {
		if(!$db2->update($_POST,$err_msg))
		{
			$title = $_template['update_error'];
			$msg = $_template['update_failed'].": ".$err_msg;
		} else {
			$title = $_template['updated'];
			$msg = $_template['update_submitted'];
		}
	} else {
		$title = $_template['update_error'];
		$msg = $_template['not_authorized'];
	}
	start_page($_REQUEST['CatID'],$title,$msg);
	start_browse($_REQUEST['CatID']);
	require($_include_path.'footer.inc.php');
	exit;

} elseif ($_REQUEST['approve']) {
	if ($ADMIN_MODE) {
		if(!$db2->approve($_REQUEST['approve'],$err_msg))
		{
			$title = $_template['approval_error'];
			$msg = $err_msg;
		} else 	{
			$title = $_template['approved'];
			$msg = $_template['suggestion_approved'];
		}
	} else {
		$title = $_template['approval_error'];
		$msg = $_template['not_authorized'];
	}
	start_page($_REQUEST['CatID'],$title,$msg);
	start_browse($_REQUEST['CatID']);
	require($_include_path.'footer.inc.php');  
	exit;

} elseif ($_REQUEST['disapprove']) {
	if ($ADMIN_MODE) {
		if(!$db2->disapprove($_REQUEST['disapprove'],$err_msg))
		{
			$title = $_template['disapproval_error'];
			$msg = $err_msg;
		} else 	{
			$title = $_template['disapproved'];
			$msg = $_template['link_disapproved'];
		}
	} else {
		$title = $_template['disapproval_error'];
		$msg = $_template['not_authorized'];
	}
	start_page($_REQUEST['CatID'],$title,$msg);
	start_browse($_REQUEST['CatID']);
	require($_include_path.'footer.inc.php');  
	exit;

} elseif ($_REQUEST['delete_link']) {
	if ($ADMIN_MODE) {
		if(!$db2->delete_link($_REQUEST['delete_link'],$err_msg))
		{
			$title = $_template['sub_delete_error'];
			$msg = $err_msg;
		} else 	{
			$title = $_template['deleted'];
			$msg = $_template['suggestion_deleted'];
		}
	} else {
		$title = $_template['sub_delete_error'];
		$msg = $_template['not_authorized'];
	}
	start_page($_REQUEST['CatID'],$title,$msg);
	start_browse($_REQUEST['CatID']);
	require($_include_path.'footer.inc.php'); 
	exit;

} elseif ($_REQUEST['edit_link']) {
	show_edit_link($_REQUEST['edit_link'],$_REQUEST['title'],$msg);
	require($_include_path.'footer.inc.php');  
	exit;

} elseif ($_REQUEST['KeyWords']) {
	//start_page();
	$CatID_temp = $_REQUEST['CatID'];
	$hits = $db2->search($_REQUEST['KeyWords']);
	if( (!$hits) or (empty($hits)) )
	{
		$junk = "";
		$title = $_template['search_results'];
		$msg =  $_template['no_matches'];
		start_page($CatID_temp,$title,$msg);
	} else {

		$total = count($hits);
		$title = $_template['search_results'];
		$msg = $_template['search_returns'].' '. $total.' '.$_template['search_matches'] ;
		$junk = "";
		//	start_page($junk,$title,$msg); 
		start_page($CatID_temp,$title,$msg); 
		while ( list ($key,$hit) = each ($hits))
		{
			if(!empty($hit))
			{
				$LinkID = $hit["LinkID"];
				$LinkName = stripslashes($hit["LinkName"]);
				$LinkDesc = stripslashes($hit["Description"]);
				$LinkURL = stripslashes($hit["Url"]);
				$CatID = $hit["CatID"];
				$CatName = stripslashes($db2->get_CatNames($CatID));
				print "<DL>\n";
				print "<DT><A HREF=\"$LinkURL\" TARGET=\"_NEW\">$LinkName</A>\n";
				print "<DD>$LinkDesc\n";
				print "<DD><B>Found In:</B>&nbsp;<A HREF=\"$PHP_SELF?viewCat=$CatID\">$CatName</A>\n";
				print "</DL>\n";
			}
		}
	}
	print "<p><hr />\n";
	start_browse($CatID_temp);
	
	require($_include_path.'footer.inc.php'); 
	exit;
} else {
	// Something terribly bad happened - start fresh
	start_page('', '', '');
	start_browse('');
	require($_include_path.'footer.inc.php'); 
	exit;
}

?>