<?php

//GET INPUT-----------------------
$pairs = array();
fscanf(STDIN, "%s\n", $dest);
fscanf(STDIN, "%s %s\n", $from, $to);
while( ($from != 'A') && ($to != 'A')) {
	$pairs[][0] = $from;
	$pairs[][1] = $to;
	fscanf(STDIN, "%s %s\n", $from, $to);	
}

//pairs ;)

foreach ($pairs as $pair) {
	
}



?>
