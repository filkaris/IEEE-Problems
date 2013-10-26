<?php

function checkifpal($num){
	$str = strval($num);
	if (strlen($str) == 1){
		return true;
	}
	if ($str == strrev($str)){
		return true;	
	}
	else{
		return false;
	}
}

$string = fgets(STDIN);

$data = explode(",",$string);

$low = $data[0];
$upper = trim($data[1]);

$palindromes = 0;
for ($i = $low;$i <= $upper;$i++){
	$num = decbin($i);
	if (checkifpal($num)){
		$palindromes += 1;
	}

}
echo $palindromes;

?>
