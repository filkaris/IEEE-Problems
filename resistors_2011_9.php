<?php

//Classes

class resistor {
	public $value;
	public $start;
	public $end;

	public function __construct($start,$end) {
		$this->value = 1;
		$this->start = $start;
		$this->end = $end;
	}
}

//Functions 

// GET INPUT
$input = array();

fscanf(STDIN, "%d\n", $N);
for ($i = 0; $i<$N; $i++) { 
	$string = fgets(STDIN);
	$input[] = explode(' ',$string);	
}
//------------------------------------------------

$resistors = array();
$nodes = array();
$ends = array();
foreach ($input as $data) {

	//Interpret Input
	//$resistors = array of resistor objects
	//$nodes = array of node arrays (x resistors for each node)
	//$ends = specific array for az nodes
	foreach ($data as $letter) {
		$resistor = new resistor($letter[0], $letter[1]);

		if ($letter[0] == 'a') {
			$ends['a'][] 		= $resistor;
		} else {
			$nodes[$letter[0]][] 	= $resistor;
		}

		if ($letter[1] == 'z') {
			$ends['z'][] 		= $resistor;
		} else {
			$nodes[$letter[1]][] 	= $resistor;
		}
		$resistors[] = $resistor;
	}

	/*foreach ($nodes as $node) {
		if ( count($node) == 2 ) {
			
		}
	}	
	*/
}	


?>
