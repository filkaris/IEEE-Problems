<?php

function number_to_field($x) {

	//Init coordinates	
	$i = 0;
	$j = 0;

	//Find previous + next root
	$root = sqrt($x);
	$r2 = ceil($root);
	$r1 = $r2-1;
	$corner = $r1*$r1 + $r2;

	//See which case it is (right + up) / (down + left)
	if ($r2 % 2 == 0) {
		//If right + down -> up 
		if ($x < $corner) {
			$i = $r2/2;
			$j = $r2/2 - ($corner - $x);
		}
		//If  up + right -> left  + CORNER
		elseif ($x >= $corner) {
			$j = $r2/2;
			$i = $r2/2 - ($x - $corner);
		}
	}
	else {
		//If left + up -> down 
		if ($x < $corner) {
			$i = -$r1/2;
			$j = -$r1/2 + ($corner - $x);
		}
		//If  down + left -> right  + CORNER
		elseif ($x >= $corner) {
			$j = -$r1/2;
			$i = -$r1/2 + ($x - $corner);
		}
	}

	return array('x'=>$i,'y'=>$j);
	
}


function input_primes($primes,$n) {

	//Total counter
	$c = 0;

	//Coordinates
	$i = 0;
	$j = 0;

	//Width - Height of movement
	$width = 1;
	$height = 1;

	//Direction
	$direction = 1;

	//Array
	$field = array();

	while ($c < $n) {
//	for($c = 0; $c<$n; $c++) {
		for ($w = 0; $w<$width; $w++) {
			$i += $direction;
			$field[$i][$j] = $primes[$c];
			$c++;
			if ($c >= $n) break;
		}
		if ($c >=$n) break;
		$width++;
		for ($h = 0; $h<$height; $h++) {
			$j += $direction;
			$field[$i][$j] = $primes[$c];
			$c++;
			if ($c >=$n) break;
		}
		if ($c >=$n) break;
		$height++;

		$direction *= -1;
	}	
	return $field;
}
$n = 53;
$primes = range(0,$n);

$field = input_primes($primes,$n);

while (TRUE) {
	fscanf(STDIN, "%d\n", $x);
	$co = number_to_field($x);
	print_r($co);
	echo $field[$co['x']][$co['y']],"\n";
}

?>
