<?php
?>

	<small class="spacer">- <?php echo $_template['click_concept'];  ?></small>
	<table cellspacing="1" cellpadding="0" border="0" summary="">
<?php
	$num_tags = count($learning_concept_tags);
	echo '<tr>';
	foreach($learning_concept_tags as $tag => $info) {
	echo '<td class="row1"><a href="javascript:smilie(\'['.$tag.']\')"><img src="images/concepts/'. $info[icon_name].'" alt="'.$info[title].' ['.$tag.']" border="0" height="22" width="22" title="'.$info[title].' ['.$tag.']" /></a></td>';
	$counter++;
	}
	echo '</tr><tr><td height="1" class="row2" colspan="'.$counter.'"></td></tr>';
	echo '</table>';
?>
