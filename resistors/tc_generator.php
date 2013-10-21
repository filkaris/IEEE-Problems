<?php

function rnd_str($length) {
	return substr(
		str_shuffle(
			implode(
				array_merge(
					range('a', 'z')
				)
			)
		), 
		0, 
		$length
	);
}

//$f = fopen("tc.txt","w");


$string = "1\n";
/*

foreach(range('a','y') as $i) {
	$string .= $i.($i++)." ";
}
*/

//RESISTORS NUMBER
$N = $argv[1];

for ($i=0; $i<$N; $i++){
	$string .= 'az ';
}

trim($string);
$string .= "\n";

file_put_contents('tc.txt',$string);


?>
