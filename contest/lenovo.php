<?php

//GET INPUT-----------------------

//GET SEQUENCES
$seqs = array();
fscanf(STDIN, "%d\n", $N);
for ($i = 0; $i<$N; $i++) { 
	fscanf(STDIN, "%s\n", $seqs[]);
}

//GET ASKED ALIGNMENTS
$asked = array();
fscanf(STDIN, "%d\n", $k);
for ($i = 0; $i<$k; $i++) { 
	fscanf(STDIN, "%d\n", $asked[]);
}

//Alignments array
//Alignment[0][0] = 'AC'
$aligns = array();

$i = 0;

//Find max columns
$col = 0;
foreach ($seqs as $seq) {
	$tmp = strlen($seq);
	if ($tmp > $col) $col = $tmp;
}

//Initialize first align
foreach ($seqs as $pos => $seq) {
	$aligns[$i][$pos] = $seq;
	if (strlen($seq) < $col) {
		for ($i=0; $i<($col-strlen($seq)); $i++) 
			$aligns[$i][$pos] .= '-';
	}
}

$i++;
$col++;

foreach ($seqs as $pos => $seq) {
	$aligns[$i][$pos] = $seq;
	if (strlen($seq) < $col) {
		for ($i=0; $i<($col-strlen($seq)); $i++) 
			$aligns[$i][$pos] .= '-';
	}
}






?>
