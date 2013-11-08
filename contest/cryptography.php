<?php

function num_to_char($num) {
	$alphabet = range('A','Z');
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
	return ($val2 - $val1 + 26) % 26;
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

$length = max(array_map('strlen',$originals));

//INITIALIZE KEYS AND SUMS
$key1 = array();
$key1 = array_fill(0,$length,'A');

$sum1 = array();
$sum1 = array_fill(0,$length,'1');

$key2 = array();
$sum2 = array();

$columns = array();
$or_nums = array_map('str_to_num',$originals);
$en_nums = array_map('str_to_num',$encrypted);
//echo $or_nums[0][2]," -> ",$en_nums[0][2],"\n";
$lengths = array_map('count',$or_nums);
$pos = array_search(max($lengths),$lengths);



for ($i=0; $i<$length; $i++) {
	if (isset($or_nums[$pos][$i]) && !empty($or_nums[$pos][$i])) {
		$diff = dif($or_nums[$pos][$i],$en_nums[$pos][$i]);
		$columns[$i] = $diff;
		for ($j=1; $j<count($or_nums); $j++) {
			//UNKNOWN VALUE
			if (!empty($or_nums[$j][$i]) && !empty($en_nums[$j][$i]) ) {
				if ($diff != (dif($or_nums[$j][$i],$en_nums[$j][$i]))) {
					fill_unknown($i);
					break;
				}
			}
		}
	}
}

foreach ($columns as $i => $col) {
	if ($col !== '?') {
		$sum = $col;
		$sum -= 2;
		$sum = ($sum + 26) % 26;


		$d = 3;
		$done = false;
		if ($sum <= 9) {
			$key2[$i] = 'A';
			$sum2[$i] = $sum;
			$done = true;
		}
		elseif ( 
			($sum % 2 == 0) &&
			($sum < 20)
		) {
			$key2[$i] = 'B';
			$sum2[$i] = $sum / 2;
			$done = true;
		}

		while (!$done) {
			if ($sum % $d == 0) {
				$key2[$i] = num_to_char($d);
				$sum2[$i] = $sum / $d;
				$done = true;
			}
			$d++;
		}
	}
}

ksort($key2);
ksort($sum2);

$k1 = implode($key1);
$s1 = implode($sum1);
$k2 = implode($key2);
$s2 = implode($sum2);

echo 	"$k1\n$s1\n$k2\n$s2\n";

?>
