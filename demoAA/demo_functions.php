<?php

//Finds first and last elements and puts them into final array
function eval_startend($pos) {
	global $input, $final;

	$array = array();
	$next = array();
	
	//Find first number from all 5 cases
	for ($i = 0; $i<5; $i++) { 
		$array[] = $input[$i][$pos];
	}
	//Find if there's one that's there more than 2 times	
	$values = array_count_values($array);
	$val = array_search(max($values), $values);

	//If there is, put it in final array and return true;
	if ($values[$val] >= 2) {
		$final[$pos] = $val;
	} else {
		//Find second or second to last numbers
		$npos = ( ($pos == 0) ?  ($pos + 1) : ($pos - 1) );
		for ($i = 0; $i<5; $i++) { 
			$next[] = $input[$i][$npos];
		}
		$next_values = array_count_values($next);

		//Sum occurences with previous values to find most in neighborhood
		$sums = array();
		foreach (array_keys($values + $next_values) as $key) {
			$sums[$key] = @($values[$key] + $next_values[$key]);
		}

		//Final max value
		$val = array_search(max($sums), $sums);
		$final[$pos] = $val;
	}	
}

//Returns array where: keys = positions, values = occurences of NUM, NOT FILTERED
function mapping($num) {
	global $input, $N;

	//Initialize array
	$map = array($N);
	$map = array_fill(0,$N,0);

	foreach ($input as $random) {
		$pos = array_search($num,$random);
		$map[$pos]++;
	}
	return $map;
}

//Returns unique case where NUM is in position POS or TRUE if found more than ONCE
//PROBABLY NOT NEEDED
function position_to_case($num, $pos) {
	global $input;

	$count = 0;
	$finpos = -1;
	foreach ($input as $key => $random) {
		if ($random[$pos] == $num) {
			$count++;
			$finpos = $key;
		}
	}

	switch ($count) {

		//Not Found
		case 	0:
			return FALSE;
			break;

		//Found once
		case	1:
			return $finpos;
			break;

		//Found >once
		default:
			return TRUE;
	}
}

/*Returns if number has moved more than 2 numbers away
 *If we know for SURE, it returns the POSITION
 *If we are UNSURE where it moved, it returns BOTH POSITION
 *If we don't know if it moved FAR AWAY, it returns FALSE
*/
function eval_faraway($num) {
	global $input;

	//Get map without the zeros
	$map_z = mapping($num);
	$map = array_filter($map_z);

	//Get keys in array	
	$positions = array_keys($map);

	//Find max and min positions
	$max = max($positions);
	$min = min($positions);

	if ($max - $min > 2) {
		//Create string like 1210001
		$string = substr(implode($map_z),$min,($max-$min+1));
		
		//If more than 4 away, RETURN WHERE IT MOVED
		$pos = strpos($string,'0');
		if ($pos !== FALSE) {
			if ( ($pos - $min) == 1) {
				return $min;
			} else {
				return $max;
			}
		} 
		//If we know it moved, but don't know where, yet
		else {
			$minf = position_to_case($num,$min);
			$maxf = position_to_case($num,$max);
			//RETURN WHERE IT MOVED	
			if ($minf === TRUE) {
				return $maxf;
			} 
			//RETURN WHERE IT MOVED
			elseif ($maxf === TRUE) {
				return $minf;
			}
			else {
				//Return BOTH
				return array($min,$max);

				//Return TRUE
				//return TRUE;
			}
		}
	}
	else {	
		return FALSE;
	}
}

function eval_neighbors($num) {
	
		
}

function find($num) {
	
}

?>
