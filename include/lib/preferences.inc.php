<?php

	
echo '<br />';

echo '<h3>'.$_template['personal_preferences'].'</h3>';

?>
<form action="<?php echo $PHP_SELF; ?>" method="get" name="prefs">
<table cellspacing="10" width="100%" cellpadding="8" summary="" border="0">
<tr>
	<td valign="top"><table border="0" width="100%" class="bodyline" cellspacing="1" cellpadding="0">
	<tr>
		<th colspan="2"><?php print_popup_help(AT_HELP_POSITION_OPTIONS); echo $_template['pos_options']?></th>
	</tr>
	<tr>
		<td class="row1"><label for="pos"><?php echo $_template['menu_location'];  ?>:</label></td>
		<td class="row1"><?php
		/* menu position preference */
		if ($_SESSION['prefs'][PREF_MAIN_MENU_SIDE] == MENU_LEFT) {
			$left = ' selected="selected"';
		} else {
			$right = ' selected="selected"';
		}
		?><select name="pos" id="pos">
			<option value="1" <?php echo $left;?>><?php echo $_template['left']; ?></option>
			<option value="2" <?php echo $right;?>><?php echo $_template['right']; ?></option>
		  </select><br /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1"><label for="seq"><?php echo $_template['seq_links'];  ?>:</label></td>
		<td class="row1"><?php
		/* sequence links preference */
		if ($_SESSION['prefs'][PREF_SEQ] == TOP) {
			$top = ' selected="selected"';
		} else if ($_SESSION['prefs'][PREF_SEQ] == BOTTOM) {
			$bottom = ' selected="selected"';
		} else {
			$both = ' selected="selected"';
		}
		?><select name="seq" id="seq">
			<option value="<?php echo TOP; ?>"<?php echo $top; ?>><?php echo $_template['top'];  ?></option>
			<option value="<?php echo BOTTOM; ?>"<?php echo $bottom; ?> ><?php echo $_template['bottom'];  ?></option>
			<option value="<?php echo BOTH; ?>"<?php echo $both; ?>><?php echo $_template['top_bottom'];  ?></option>
	  	  </select><br /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1"><label for="toc"><?php echo $_template['table_of_contents_location'];  ?>:</label></td>
		<td class="row1"><?php
		// table of contents preference
		$top = $bottom = '';
		if ($_SESSION['prefs'][PREF_TOC] == TOP) {
			$top	= ' selected="selected"';
		} else {
			$bottom = ' selected="selected"';
		}
		?><select name="toc" id="toc">
			<option value="<?php echo TOP; ?>"<?php echo $top; ?>><?php echo $_template['top'];  ?></option>
			<option value="<?php echo BOTTOM; ?>"<?php echo $bottom; ?>><?php echo $_template['bottom'];  ?></option>
		  </select></td>
	</tr>
	</table></td>

	<td valign="top" align="left"><table border="0" width="100%"  class="bodyline" cellspacing="1" cellpadding="0">
	<tr>
		<th colspan="2"><?php print_popup_help(AT_HELP_DISPLAY_OPTIONS); ?>
<?php echo $_template['disp_options'];  ?></th>
	</tr>
	<tr>
		<td class="row1"><?php
		/* Show Topic Numbering Preference */
		if ($_SESSION['prefs'][PREF_NUMBERING] == 1) {
			$num = ' checked="checked"';
		}
		?> <input type="checkbox" name="numering" value="1" <?php echo $num;?> id="numbering" /></td>
		<td class="row1"><label for="numbering"><?php echo $_template['show_numbers'];  ?></label></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
		<tr>
		<td class="row1"><?php
			$num = '';
			if ($_SESSION['prefs'][PREF_HELP] == 1) {
				$num = ' checked="checked"';
			}
			?><input type="checkbox" name ="use_help" id="use_help" value="1" <?php echo $num; ?> /></td>
		<td class="row1"><label for="use_help"><?php echo $_template['show_help'];  ?></label><br /></td>
	</tr>
	<tr><td height="1" class="row2" colspan="2"></td></tr>
	<tr>
		<td class="row1"><?php
			$num = '';
			if ($_SESSION['prefs'][PREF_MINI_HELP] == 1) {
				$num = ' checked="checked"';
			}
			?><input type="checkbox" name ="use_mini_help" id="use_mini_help" value="1" <?php echo $num; ?> /></td>
		<td class="row1"><label for="use_mini_help"><?php echo $_template['show_mini_help'];  ?></label><br /></td>
	</tr>
	</table></td>
</tr>
<tr>
	<td valign="top" width="50%"><table border="0"  width="100%" class="bodyline" cellspacing="1" cellpadding="0">
		<tr>
			<th colspan="2"><?php print_popup_help(AT_HELP_MENU_OPTIONS); ?>
<?php  echo $_template['menus']; ?></th>
		</tr>
		<tr>
			<td class="row1" align="center"><?php

			$num_stack = count($_stacks);

			for ($i = 0; $i< 5; $i++) {
				echo '<select name="stack'.$i.'">';
				echo '<option value="">[ empty ]</option>';
				for ($j = 0; $j<$num_stack; $j++) {
					echo '<option value="'.$j.'"';
					if (isset($_SESSION['prefs'][PREF_STACK][$i]) && ($j == $_SESSION[prefs][PREF_STACK][$i])) {
						echo ' selected="selected"';
					}
					echo '>'.$_template[$_stacks[$j]].'</option>';	
				}
				echo '</select>';
				echo '<br />'; 
			}

		?></td>
		</tr>
		</table></td>
</tr>
<tr>
	<td colspan="2"><!-- here the theme/font prefs --></td>
</tr>
<tr>
	<td colspan="2" align="center"><br />
	<input type="submit" name="submit" value="<?php echo $_template['set_prefs']; ?>" title="<?php echo $_template['set_prefs']; ?>" accesskey="s" class="button" />
	-
	<input type="submit" name="restore" value="<?php echo $_template['restore']; ?>" class="button" /></td>
</tr>
</table>

</form>
<script language="JavaScript" type="text/javascript">
<!--
function enableThemes()
{
	document.prefs.font.disabled	= false;
	document.prefs.stylesheet.disabled = false;
}

function disableThemes()
{
	document.prefs.font.disabled = true;
	document.prefs.stylesheet.disabled = true;
}

// -->
</script>
