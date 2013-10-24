<?php

include 'demo_functions.php';


//INPUT-------------------------------
$input = array();
fscanf(STDIN, "%d\n", $N);
for ($i = 0; $i<5; $i++) { 
	for ($j = 0; $j<$N; $j++) {	
		$number = fgets(STDIN);
		//No end of line at the end
		$number = trim($number);
		$input[$i][$j] = $number;
	}
}

$final = array();

//Find first and last
eval_startend(0);
eval_startend($N-1);

echo "The first number is definitely ",$final[0],"\n";
echo "The last number is definitely ",$final[$N-1],"\n";

for ($i=1; $i<=$N; $i++) {
	$to = eval_faraway($i);

	//Has it moved?	
	if ($to !== FALSE) {
		echo "Looks like $i moved to position ",($to+1),"!\n";
		//Do we know where it is?
		/*if (($pos = array_search($i,$final)) !== FALSE) {
			$final2 = position_to_case($i,$to);
			$string = implode($final);
			for ($j=1; $j<=$N; $j++) {
				//TODO after pos, before pos
			}
		}*/
	} 
	else {
		
		echo "We are not sure if $i moved.\n";
	}
	
}



?>
