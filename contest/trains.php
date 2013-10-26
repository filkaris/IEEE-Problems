<?php

//Print error function
function print_error() {
	echo "ERROR\n";
	exit(0);
}

//Transforms km/h to m/s
function kmh_ms($speed) {
	return $speed * 1000 / 3600;
}

//Gives total time needed to traverse length with acc decc limitations
function length_to_time($length) {
	global $d90t;

	if ($length <= $d90t) {
		$t = short_length($length);
	}
	else {
		$t = long_length($length);
	}	
	return $t;
}

function short_length($length) {	
	global $acc,$decc;

	$t2 = sqrt(
		(2*$acc*$length)/($decc*($decc+$acc))
	);
	$t1 = $t2*$decc/$acc;
	return round($t1 + $t2);	
}

function long_length($length) {
	global $d90t, $t90t;
	$cruise = ($length-$d90t)/kmh_ms(90);
	return round($t90t + $cruise);
}

//Checks if 1 <= num <= 5
function in_range($num) {
	return array_search($num,range(1,5));
}

//INPUT-------------------------
$input = array();
$string = fgets(STDIN);
$input = explode(' ',$string);	
$input[count($input)-1] = trim(end($input));

$trains = $input[0];
//1-5 trains
if (in_range($trains) === FALSE) print_error();
unset($input[0]);
$sections = $input;
$scount = count($sections);
//1-5 sections
if (in_range($scount) === FALSE) print_error();
if (array_sum($sections) != 100000) print_error();
if (min($sections) < 500) print_error();
//INITIALIZATIONS----------------
//Acc and Decc in m/s
$acc = kmh_ms(2.7); 
$decc = kmh_ms(3.8); 

//Time it takes to reach 90kmh and stop from 90kmh
$t90 = kmh_ms(90)/$acc;
$t90s = kmh_ms(90)/$decc;
//MAX TIME NO CRUISING SPEED
$t90t = $t90 + $t90s;

//Distance it takes to reach 90kmh and stop from 90kmh
$d90 = $acc*($t90*$t90)/2;
$d90s = $decc*($t90s*$t90s)/2;
//MAX DISTANCE NO CRUISING SPEED
$d90t = $d90 + $d90s;

//CALCULATIONS--------------------------
$times = array();
$arrivals = array();
$departures = array();
//Find time needed to cross section
foreach ($sections as $key => $section) {
	$times[] = length_to_time($section);
}

//OUTPUT-------------------------------

for ($i=1; $i<=$trains; $i++) {
	printf("$i : ***** ");
	if ($i == 1) {
		$starts = 1;
		foreach ($times as $key => $t) {
			printf("- % 5d  % 5d ",$starts,$starts+$t);
			$departures[$i][$key] = $starts;
			$arrivals[$i][$key] = $starts+$t;
			$starts += 121 + $t;
		}
	} 
	else {
		foreach ($times as $key => $t) {
			$starts = isset($departures[$i-1][$key+1]) ? $departures[$i-1][$key+1] : $arrivals[$i-1][$key];
			$starts++;
			printf("- % 5d  % 5d ",$starts,$starts+$t);
			$departures[$i][$key] = $starts;
			$arrivals[$i][$key] = $starts+$t;
		}
	}
	printf("*****\n");
}
?>
