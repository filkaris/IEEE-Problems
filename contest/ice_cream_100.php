<?php
function new_string($string,$last) {
	global $dest, $final, $nodes;	

	if ($last == $dest) {
		$final[] = $string;
		return;
	}
	else {
		foreach ($nodes[$last] as $node) {
			if (strpos($string,$node) === FALSE) {
				new_string($string.$node ,$node);
			}
		}
		return;
	}
}
//GET INPUT-----------------------
$nodes = array();
fscanf(STDIN, "%s\n", $dest);
fscanf(STDIN, "%s %s\n", $from, $to);
while ( ($from != 'A') && ($to != 'A') ) {
	$nodes[$from][] = $to;
	$nodes[$to][] = $from;
	fscanf(STDIN, "%s %s\n", $from, $to);	
}

//nodes ;)
$final = array();

new_string('F','F');

if (count($final) > 0) {
	//Find shortest path length
	$lengths = array_map('strlen', $final);
	$min = min($lengths);

	//Find shortest path
	$shorts = array();
	foreach ($lengths as $key => $length) {
		if ($length == $min) $shorts[] = $final[$key];
	}
	sort($shorts);
	$short = str_split($shorts[0]);
	$short = implode(' ',$short);

	//Display Output
	echo "Total Routes: ", count($final), "\n";
	echo "Shortest Route Length: $min\n";
	echo "Shortest Route after Sorting of Routes of length $min: ", $short , "\n";
}
else {
	echo "No Route Available from F to $dest\n";
}

?>
