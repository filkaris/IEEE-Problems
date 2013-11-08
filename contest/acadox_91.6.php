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
	print_error();
}

if (!is_operator(end($input))) {
	print_error();	
}

foreach ($input as $item) {
	//Remove Newline
	//$item = trim($item);
	//if (strlen($item) > 4) {
	//	print_error();
	//}
	//If Hex
	if (ctype_xdigit($item)) {
		//Sanitize
		$hex = hexdec($item);
		$hex = (int)$hex;
		$max = hexdec('FFFF');
		if ($hex > $max) {
			print_error();
		}

		array_push($buffer,$hex);
	}

	//If Operator 
	elseif ( is_operator($item) ) {
		//Define Vars
		$operator = $item;
		//$operands = count($buffer);
		
		//See if number of operands is appropriate
		if  ($operator == '~') {
			$operand = array_pop($buffer);
			if ($operand !== FALSE) {
				$result = ~ $operand;
			}
			else {
				print_error();
			}
		}
		else {
			//var_dump($operator);
			$op2 = array_pop($buffer);
			$op1 = array_pop($buffer);
			if (
				($op1 !== FALSE) &&
				($op2 !== FALSE) 
			) {
				$result = calc_2($operator,array($op1,$op2));					
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
		array_push($buffer,$result);
	}
	else {
		print_error();
	}
}
if (count($buffer) >1) print_error();
$result = $buffer[0];
printf("%04X\n",$result);


?>
