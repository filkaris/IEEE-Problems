<?php

//Print error function
function print_error() {
	echo "ERROR\n";
	exit(0);
}

//INPUT-----------------------
$input = array();
fscanf(STDIN, "%d\n",$n);
$string = fgets(STDIN);
$input = explode(' ',$string);	
$input[count($input)-1] = trim(end($input));

$max = 0;
$sum = 0;
$inputrev = array_reverse($input);
foreach ($inputrev as $speed) {
	if (
		($speed > 2000) ||
		($speed < -2000)
	) print_error();
	$sum += $speed;
	if ($sum > $max) $max = $sum;
}

echo "$max\n";

?>
