<?php

function num_to_char($num) {
	$alphabet = range('a','z');
	return ($alphabet[$num-1]);
}

function char_to_num($char) {
	$ascii = ord($char);
	if (
		($ascii >= 65) &&
		($ascii <= 90)
	) {
		$ascii -= 64;
	}
	elseif (
		($ascii >= 97) &&
		($ascii <= 122)
	) {
		$ascii -= 96;
	}
	return $ascii;
}

function str_to_num($str) {
	$array = str_split($str);
	return array_map('char_to_num',$array);
}

function fill_unknown($i) {
	global $key1, $key2, $sum1, $sum2, $columns;
	
	$key1[$i] = '?';
	$sum1[$i] = '?';
	$key2[$i] = '?';
	$sum2[$i] = '?';
	$columns[$i] = '?';
	return;
}

function dif($val1,$val2) {
	return ($val1 - $val2 + 26) % 26;
}

$originals = array();
$encrypted = array();

//INPUT--------------------
fscanf(STDIN, "%s %s\n", $orig, $crypt);
while ($orig != '.') {
	$originals[] = $orig;	
	$encrypted[] = $crypt;
	fscanf(STDIN, "%s %s\n", $orig, $crypt);
}

$length = strlen($originals[0]);

//INITIALIZE KEYS AND SUMS
$key1 = array($length);
$key1 = array_fill(0,$length,'A');

$sum1 = array($length);
$sum1 = array_fill(0,$length,'1');

$key2 = array($length);
$sum2 = array($length);

$columns = array();
$or_nums = array_map('str_to_num',$originals);
$en_nums = array_map('str_to_num',$encrypted);
//echo $or_nums[0][2]," -> ",$en_nums[0][2],"\n";

for ($i=0; $i<$length; $i++) {
	$diff = dif($or_nums[0][$i],$en_nums[0][$i]);
	$columns[$i] = $diff;
	for ($j=1; $j<count($or_nums); $j++) {
		//UNKNOWN VALUE
		if ($diff != (dif($or_nums[$j][$i],$en_nums[$j][$i]))) {
			fill_unknown($i);
			break;
		}
	}
}
foreach ($columns as $i => $col) {
	$sum = $col;
	$sum -= 2;
	$sum = ($sum + 26) % 26;
	if ($sum <= 9) {
		$key2[$i] = 'A';
		$sum2[$i] = $sum;
	}
	elseif ( 
		($sum % 2 == 0) &&
		($sum < 20)
	) {
		$key2[$i] = 'B';
		$sum2[$i] = $sum / 2;
	}
	elseif ($sum % 3 == 0) {
		$key2[$i] = 'C';
		$sum2[$i] = $sum / 3;
	}
	elseif ($sum % 4 == 0) {
		$key2[$i] = 'D';
		$sum2[$i] = $sum / 4;
	}
	elseif ($sum % 5 == 0) {
		$key2[$i] = 'E';
		$sum2[$i] = $sum / 5;
	}
	elseif ($sum % 11 == 0) {
		$key2[$i] = num_to_char(11);
		$sum2[$i] = $sum / 11;
	}
	elseif ($sum % 13 == 0) {
		$key2[$i] = num_to_char(13);
		$sum2[$i] = $sum / 13;
	}
	else {
		$key2[$i] = num_to_char($sum);
		$sum2[$i] = 1;
	}
}

$k1 = implode($key1);
$s1 = implode($sum1);
$k2 = implode($key2);
$s2 = implode($sum2);

echo 	"$k1\n$s1\n$k2\n$s2\n";

?>
