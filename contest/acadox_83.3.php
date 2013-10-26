<?php

function is_operator($item) {
	if (
		($item == '+') ||
		($item == '-') ||
		($item == '&') ||
		($item == '|') ||
		($item == '~') ||
		($item == 'X')
	) {
		return true;
	}
	else {
		return false;
	}
}

function print_error() {
	echo "ERROR\n";
	exit(0);
}

function calc_2($operator,$buffer) {
	switch ($operator) {
		case 	'+':
			$result = $buffer[0] + $buffer[1];
			break;
		case 	'-':
			$result = $buffer[0] - $buffer[1];
			break;
		case 	'&':
			$result = $buffer[0] & $buffer[1];
			break;
		case 	'|':
			$result = $buffer[0] | $buffer[1];
			break;
		case 	'X':
			$result = $buffer[0] ^ $buffer[1];
			break;	
	}
	return $result;
}

//INPUT-------------------------
$input = array();
$string = fgets(STDIN);
$input = explode(' ',$string);	
$input[count($input)-1] = trim(end($input));

$buffer = array();

if (count($input) > 20) {
	$input = array_chunk($input,20);
}

if (!is_operator(end($input))) {
	print_error();	
}

foreach ($input as $item) {
	//Remove Newline
	//$item = trim($item);

	//If Hex
	if (ctype_xdigit($item)) {
		//Sanitize
		$hex = hexdec($item);
		$hex = (int)$hex;
		$buffer[] = $hex;
	}

	//If Operator 
	elseif ( is_operator($item) ) {
		//Define Vars
		$operator = $item;
		$operands = count($buffer);
		
		//See if number of operands is appropriate
		if  ($operator == '~') {
			if ($operands == 1) {
				$result = ~ $buffer[0];
			}
			else {
				print_error();
			}
		}
		else {
			//var_dump($operator);
			if ($operands == 2) {
				$result = calc_2($operator,$buffer);	
			}
			else {
				print_error();
			}
		}
		//Result checked for overflows
		$max = hexdec('FFFF');
		if ($result < 0) {
			$result = 0;
		} elseif ($result > $max) {
			$result = $max;
		}


		//Reset buffer and put result in
		unset($buffer);
		$buffer = array();
		$buffer[] = $result;
	}
	else {
		print_error();
	}
}
$result = $buffer[0];
printf("%04X\n",$result);


?>
