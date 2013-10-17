<?php

//Functions

function mean($a) {
	return array_sum($a) / count($a);
}

function std_dev($a,$meana) {
	$final = array();
	for ($i=0; $i<count($a); $i++) {
		$tmp = $a[$i] - $meana;
		$final[] = $tmp * $tmp;
	}
	$tmp = array_sum($final) / count($a);
	return sqrt($tmp);
}

//Var Init
$X = array();
$Y = array();
$xtmp = 0;
$ytmp = 0;

// GET INPUT
for ($i = 0; $i>-1; $i++) {

	//Read from STDIN	
	fscanf(STDIN, "%s %s\n", $xtmp, $ytmp);

	//Check if valid input
	if ( is_numeric($xtmp) && is_numeric($ytmp) ) {
		$X[] = $xtmp - 0;
		$Y[] = $ytmp - 0;			
	} 
	//Check if end of input
	elseif ($xtmp == '-') { 
		break;
	} 
	// Invalid input
	else {
		echo 'invalid input';
		exit();
	}	
}
//------------------------------------------------

//Caclucating 

//Means
$meanx = mean($X);
$meany = mean($Y);

//Standard Deviation X
$stdx = std_dev($X,$meanx);
$stdy = std_dev($Y,$meany);

//Covariance X,Y
$C = array();
for ($i=0; $i<count($X); $i++) {
	$xtmp = $X[$i] - $meanx;
	$ytmp = $Y[$i] - $meany;
	$C[] = $xtmp * $ytmp;
}
$covar = mean($C);

//Pearson's (final)
$pears = $covar / ($stdx * $stdy);
/*
echo "\nMean X:$meanx";
echo "\nMean Y:$meany";
echo "\nStd Dev X:$stdx";
echo "\nStd Dev Y:$stdy";
echo "\nCovariance:$covar";
echo "\n\nPearson's Correlation Coefficient:$pears";
echo "\n";
*/

if ( ($pears>1) || ($pears<-1) ) {
	echo 'invalid input';
} elseif ($stdx == 0 || $stdy == 0) {
	echo 'invalid input';
} else {
	echo number_format($pears, 4, '.', '');
}
?>

