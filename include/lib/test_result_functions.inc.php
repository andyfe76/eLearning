<?php

function print_result($q_text, $q_answer, $q_num, $a_num, $multi, $show_ans=true) {
	global $mark_right, $mark_wrong;

	if ($a_num == '') {
		$a_num = -1;
	}
	if ($multi) {
		if ($a_num == 1) {
			echo '<input type="checkbox" checked="checked"/>';
		} else {
			echo '<input type="checkbox" disabled="disabled" />';
		}
		if( $show_ans <> '0' ) {
			if ($q_answer == 1) {
				echo $mark_right;
			} else {
				echo $mark_wrong;
			}
		}
	} else {
		if ($a_num == $q_num)  {
			echo '<input type="checkbox" checked="checked"/>';
		} else {
			echo '<input type="checkbox" disabled="disabled" />';
		}
		if (($q_answer == $q_num) & ($show_ans <> '0' )) {
			echo $mark_right;
		} else if($show_ans<>'0') {
			echo $mark_wrong;
	}

	}

	echo $q_text;

}

function print_score($correct, $weight, $qid, $score, $put_zero = true, $open=false) {
	echo $correct[1];
	if ($score != '') {
		$val = $score;
	} else if ($correct) {
		$val = $weight;
	} else if ($put_zero) {
		$val = '0';
	}
	
	if ($open) {
		echo '<input type="text" class="formfieldR" size="2" name="scores['.$qid.']" value="'.$val.'" style="width: 25px; font-weight: bold;" maxlength="4" /><b>/'.$weight.'</b>';
	} else {	
		echo '<input type="hidden" class="formfieldR" name="scores['.$qid.']" value="'.$val.'">';
		echo '<span class="formfieldR" style="font-size: 8pt" align="right" style="width: 25px; font-weight: bold;">';
		echo $val.'<b>/'.$weight.'</b></span>';
	}
}

?>
