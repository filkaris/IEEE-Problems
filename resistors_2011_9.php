<?php

//Classes

class Resistor {
	public $name;
	public $value;
	public $start;
	public $end;

	public function __construct($letters,$value = 1) {
		$this->value = $value;
		$this->start = $letters[0];
		$this->end = $letters[1];
		$this->name = $letters;
	}

	public function in_series($resistor,$nodes) {
		$this->value += $resistor->value;

		if ($this->start == $resistor->end) {
			$this->start = $resistor->start;
		}
		else {
			$this->end = $resistor->end;			
		}
	}
}
/*
class Node {
	public $name;
	public $resistors;

	public function __construct($name) {
		$this->name = $name;
		$this->resistors = array();
	}
}
*/
//Functions 

function in_series($res1, $res2) {
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

// GET INPUT
$input = array();

fscanf(STDIN, "%d\n", $N);
for ($i = 0; $i<$N; $i++) { 
	$string = fgets(STDIN);
	$input[] = explode(' ',$string);	
}
//------------------------------------------------

$resistor = array();
$connections = array();
$nodes = array();
foreach(range('a','z') as $i) {
	$nodes[$i] = 0;
}
$ends = array();
//foreach ($input as $data) {
$data = $input[0];
	//Interpret Input
	//$resistors = array of resistor objects
	//$nodes = array of node arrays (x resistors for each node)
	//$ends = specific array for az nodes

	foreach ($data as $letter) {
		$resistor[$letter][] = new Resistor($letter);
		$connections[] = $letter;
		$nodes[$letter[0]]++;
		$nodes[$letter[1]]++;
	}
	//var_dump($resistor);
	//var_dump($connections);
	//var_dump($ends);

	$nodes = array_filter($nodes);
	foreach ($nodes as $key => $resno) {
		var_dump($nodes);
		if ($key == 'a' || $key == 'z')
			continue;
		if ($resno == 2) {
			//Return 'bc' , 'cd' for key = c
			echo $key."\n";
			$conns = preg_grep('/['.$key.']/',$connections);

			//Calculate in series
			$new = in_series($resistor[$conns[0]][0],$resistor[$conns[1]][0]);

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
			$nodes = array_filter($nodes);	

			//Adding NEW
			$name = $new->name;
			$connections[] = $name;
			$resistor[$name][] = $new;
			$nodes[$name[0]]++;
			$nodes[$name[1]]++;
			
		}
	}
	echo "------------------------------------------------------------------\n";
	//var_dump($resistor);
	//var_dump($nodes);
	//var_dump($ends);
//}	


?>
