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
$dest = array();
fscanf(STDIN, "%s\n", $verts);
for ($i=0; $i<$verts-1; $i++) {
	fscanf(STDIN, "%s %s\n", $from, $to);
	$nodes[$from][] = $to;	
	$dest[] = $to;
}

$all = range(1,$verts);
$start = array_diff($all, $dest);
var_dump($start);



/*

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
*/
?>
