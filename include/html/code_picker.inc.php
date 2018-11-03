<?php
	require_once($_include_path.'lib/forum_codes.inc.php');

	require($_include_path.'html/learning_concepts.inc.php');

?><small class="spacer"><?php echo $_template['click_code']; ?><?php

	echo '<a href="javascript:smilie(\':)\')" title=":)">'.smile_replace(':)').'</a> ';
	echo '<a href="javascript:smilie(\';)\')" title=";)">'.smile_replace(';)').'</a> ';
	echo '<a href="javascript:smilie(\':(\')" title=":(">'.smile_replace(':(').'</a> ';
	echo '<a href="javascript:smilie(\':D\')" title=":D">'.smile_replace(':D').'</a> ';
	echo '<a href="javascript:smilie(\':\\\ \')" title=":\\">'.smile_replace(':\\').'</a> ';

	echo '<a href="javascript:smilie(\':P\')" title=":P">'.smile_replace(':P').'</a> ';
	echo '<a href="javascript:smilie(\'::angry::\')" title="::angry::">'.smile_replace('::angry::').'</a> ';

	echo '<a href="javascript:smilie(\'::evil::\')" title="::evil::">'.smile_replace('::evil::').'</a> ';
	echo '<a href="javascript:smilie(\'::lol::\')" title="::lol::">'.smile_replace('::lol::').'</a> ';
	echo '<a href="javascript:smilie(\'::confused::\')" title="::confused::">'.smile_replace('::confused::').'</a> ';
	echo '<a href="javascript:smilie(\'::crazy::\')" title="::crazy::">'.smile_replace('::crazy::').'</a> ';

	echo '<a href="javascript:smilie(\'::tired::\')" title="::tired::">'.smile_replace('::tired::').'</a> ';
	echo '<a href="javascript:smilie(\'::muah::\')" title="::muah::">'.smile_replace('::muah::').'</a> ';
	echo '<a href="javascript:smilie(\'::wow::\')" title="::wow::">'.smile_replace('::wow::').'</a> ';

	?>	
	<br /><b><?php echo $_template['codes'];  ?>:</b>
	<a href="javascript:smilie('[head1][/head1]')" title="[head1][/head1]"><?php echo $_template['head1']; ?></a>,
	<a href="javascript:smilie('[head2][/head2]')" title="[head2][/head2]"><?php echo $_template['head2']; ?></a>
	<a href="javascript:smilie('[b] [/b]')" title="[b] [/b]"><?php echo $_template['bold']; ?></a>,
	<a href="javascript:smilie('[i] [/i]')" title="[i] [/i]"><?php echo $_template['italic']; ?></a>,
	<a href="javascript:smilie('[u] [/u]')" title="[u] [/u]"><?php echo $_template['underline']; ?></a>,
	<a href="javascript:smilie('[center] [/center]')" title="[center] [/center]"><?php echo $_template['center']; ?></a>,
	<a href="javascript:smilie('[quote] [/quote]')" title="[quote] [/quote]"><?php echo $_template['quote']; ?></a>,
	<a href="javascript:smilie('http://')" title="http://"><?php echo $_template['link']; ?></a>,
	<a href="javascript:smilie('[image|alt text][/image]')" title="[image|alt text][/image]"><?php echo $_template['image']; ?></a>,
	<a href="javascript:smilie('[cid]')" title="<?php echo $_template['create_anchor']; ?>"><?php echo $_template['cid']; ?></a>,
	<a href="javascript:smilie('[?] [/?]')" title="[?][/?]"><?php echo $_template['glossary_item']; ?></a>
	<br />
	</small> 
	<table border="0" cellspacing="2" cellpadding="0" summary="">
	<tr>
		<td><b><small><?php  echo $_template['colors'];  ?>:</small></b></td>
		<td bgcolor="blue"><a href="javascript:smilie('[blue] [/blue]')" title="[blue] [/blue]"><img src="images/clr.gif" alt="<?php echo $_template['blue']; ?>" height="15" width="15" border="0" /></a></td>
		<td bgcolor="red"><a href="javascript:smilie('[red] [/red]')" title="[red] [/red]"><img src="images/clr.gif" alt="<?php echo $_template['red']; ?>" height="15" width="15" border="0" /></a></td>
		<td bgcolor="green"><a href="javascript:smilie('[green] [/green]')" title="[green] [/green]"><img src="images/clr.gif" alt="<?php echo $_template['green']; ?>" height="15" width="15" border="0" /></a></td>
		<td bgcolor="orange"><a href="javascript:smilie('[orange] [/orange]')" title="[orange] [/orange]"><img src="images/clr.gif" alt="<?php echo $_template['orange']; ?>" height="15" width="15" border="0" /></a></td>
		<td bgcolor="purple"><a href="javascript:smilie('[purple] [/purple]')" title="[purple] [/purple]"><img src="images/clr.gif" alt="<?php echo $_template['purple']; ?>" height="15" width="15" border="0" /></a></td>
		<td bgcolor="gray"><a href="javascript:smilie('[gray] [/gray]')" title="[gray] [/gray]"><img src="images/clr.gif" alt="<?php echo $_template['gray']; ?>" height="15" width="15" border="0" /></a></td>
	</tr>
	</table> 
	
	<script type="text/javascript">
	<!--
	function smilie(thesmilie) {
		// inserts smilie text
		document.form.body.value += thesmilie+" ";
		// alert( document.form.body.value );
		document.form.body.focus();
	}

	//-->
	</script>
