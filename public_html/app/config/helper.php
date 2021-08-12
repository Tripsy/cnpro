<?php
/*****************************************************************************
* config/helper.php
*
* Author: David Gabriel
*
*****************************************************************************/

function debug($var, $name = null, $stop = false) {
	$name = $name ?? '<strong>'.$name.'</strong> ::: ';

	//vars
	if (is_array($var)) {
		$output = print_r($var, true);
	}
	else if (is_object($var)) {
		ob_start();
		var_dump($var);
		$output = ob_get_contents();
		ob_end_clean();
	}
	else {
		$output = $var.'<br />';
	}

	echo '<pre>'.$name.$output.'</pre>';

	if ($stop)
		exit('STOP');
}