<?php

//Class Resistor
class Resistor {

	//Resistor name eg. 'ab'
	public $name;

	//Resistor Ohm value
	public $value;

	//Resistor nodes
	public $start;
	public $end;

	//Initialize resistor by name and value
	public function __construct($letters,$value = 1) {
		$this->value = $value;
		$this->start = $letters[0];
		$this->end = $letters[1];
		$this->name = $letters;
	}

	public function parallels($n) {
		$this->value = 1/$n;
	}
}

//Functions

//Calculate 2 in series => new transistor
function calc_series($res1, $res2) {
	$value = $res1->value + $res2->value;
	
	if ($res1->start == $res2->end) {
		$nstart = $res2->start;
		$nend = $res1->end;
	}
	else {	
		$nstart = $res1->start;
		$nend = $res2->end;
	}	

	return new Resistor($nstart.$nend,$value);
	
}

//Calculate 2 in parallel => new transistor
function calc_parallel($res1, $res2) {
	$val1 = $res1->value;
	$val2 = $res2->value;
	$value = ($val1*$val2) / ($val1+$val2);
	
	$nstart = $res1->start;
	$nend = $res1->end;

	return new Resistor($nstart.$nend,$value);
	
}

//Insert Resistors
function insert_new($res) {
	global $resistor, $connections, $nodes;

	$name = $res->name;
	
	//Add 'bc' to connections
	$connections[] = $name;

	//Add res object to resistor[bc][0]
	$resistor[$name][] = $res;

	//Increase node connections
	$nodes[$name[0]]++ ;
	$nodes[$name[1]]++ ;	
}

//Main in_series function
function in_series($key) {
	global $resistor, $connections, $nodes;

	//Return 'bc' , 'cd' for key = c
	$conns = preg_grep('/['.$key.']/',$connections);

	//Calculate in series
	$tmp = array_values($conns);
	$new = calc_series($resistor[$tmp[0]][0],$resistor[$tmp[1]][0]);

	//Deleting OLDS
	foreach ($conns as $keys => $letters) {
		//Remove them from connections			
		unset($connections[$keys]);

		//Remove them from resistors
		//There's only one for sure, else we could not do in series
		unset($resistor[$letters]);

		//Remove them from nodes
		$nodes[$letters[0]]--;
		$nodes[$letters[1]]--;
	}	

	//Adding NEW
	insert_new($new);
}

//Main in_parallel function
function in_parallel($conn) {
	global $resistor, $connections, $nodes;

	//Calculate parallel
	$new = calc_parallel($resistor[$conn][0],$resistor[$conn][1]);

	//Remove them from connections	
	$keys = array_keys($connections,$conn);		
	unset($connections[$keys[0]]);
	unset($connections[$keys[1]]);

	//Remove them from resistors
	unset($resistor[$conn][0]);
	unset($resistor[$conn][1]);
	//Fix array keys
	$resistor[$conn] = array_values($resistor[$conn]);

	//Remove them from nodes
	$nodes[$conn[0]] -= 2;
	$nodes[$conn[1]] -= 2;

	//Adding NEW
	insert_new($new);	
}


//MAIN PROGRAM-------------------


//GET INPUT-----------------------
$input = array();
$f = fopen($argv[1],"r");
fscanf($f, "%d\n", $N);
for ($i = 0; $i<$N; $i++) { 
	$string = fgets($f);
	$string = trim($string);
	$input[] = explode(' ',$string);	
}

//PROBLEMS LOOP----------------------
foreach ($input as $data) {

	//Interpret Input
	//$resistors = array of resistor objects by connection ( "bc" )
	//$connections = exactly the input (ab, cd ...)
	//$nodes = array of node arrays (x resistors for each node)


//INITIALIZATION--------------------

	$resistor = array();
	$connections = array();
	$nodes = array();

	//Init nodes to 0
	foreach(range('a','z') as $i) {
		$nodes[$i] = 0;
	}

//INSERTION------------------------

	//Insert all unique resistors
	$un_data = array_unique($data);
	foreach ($un_data as $letter) {
		$res = new Resistor($letter);
		insert_new($res);
	}

	//immediately calculate parallels from input
	$parallel = array_count_values($data);
	foreach ($parallel as $conn => $freq) {
		if ($freq >= 2) {
			$resistor[$conn][0]->parallels($freq);	
		}
	}

	//Prune nodes after resistors inserted (all alphabet was 0)
	$nodes = array_filter($nodes);

//MAIN LOOP-----------------------

	//Repeat until there's only AZ left
	while (count($connections) > 1) {

//IN SERIES-----------------------
		foreach ($nodes as $key => $resno) {
			//We look at inside nodes only
			if ($key == 'a' || $key == 'z')
				continue;

			//If node has only 2 connections, then IN SERIES
			if ($resno == 2) {
				in_series($key);
			}
			//Delete now empty nodes
			$nodes = array_filter($nodes); 
		}

//IN PARALLEL---------------------
		//Create array value => frequency
		$parallel = array_count_values($connections);

		foreach ($parallel as $conn => $freq) {
			//If more than 2 then parallel:
			if ($freq >= 2) {
				for ($i = 0; $i<($freq-1); $i++) 
					in_parallel($conn);					
			}
		}
	}

//PRINT RESULT--------------------
	$result = $resistor['az'][0]->value;
	echo number_format($result, 4, '.', ''),"\n";
}	


?>
