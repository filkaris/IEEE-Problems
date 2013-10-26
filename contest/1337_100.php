<?php



function num_to_pos($num) {
	$c = 1;
	$pos = 1;
	$st = 1;
	while ($c < $num) {
		$c++;
		$pos += $st;
		if (
			(strpos($c.'','7') !== FALSE) ||
			($c % 7 ==0)
		) {
			$st *= -1;		
		}
	}
	return (($pos >= 0) ? ($pos) : ($pos + 1337));
}



fscanf(STDIN,"%d\n",$n);
if (
	($n > 1000) ||
	($n < 1) 
){
	exit(0);
}

$output = array();

for ($i = 0;$i<$n;$i++){
	$fav = trim(fgets(STDIN));
	$result = num_to_pos($fav);	
	$output[] = $result;
}
   
foreach ($output as $out) {
	echo "$out\n";
}
?>
