<?php

function primes($N){
	$num = 5;
	$tail = sieve($num);
	while (count($tail) < $N){
		$num +=2;
		$tail = sieve($num);
	}
	return $tail;
}
function sieve($bound){

	$sieve = range(0, $bound);
	unset($sieve[0]);
	unset($sieve[1]);
	unset($sieve[2]);
	unset($sieve[3]);
	unset($sieve[4]);
	$current = 5;
	$root = sqrt($bound);
	while ( $current < $root ){
		for ($i = $current; $i <= $bound; $i=$i+$current) { 
			if ( isset($sieve[$i]) && $i !== $current ) {		 
			unset($sieve[$i]);
			} 
		} 
		$next = 1;
		while ( !isset($sieve[$current+$next]) ) {
			$next += 1;	
		}
		$current += $next;
	}
	return $sieve;
}

var_dump( primes(20) );

?>
