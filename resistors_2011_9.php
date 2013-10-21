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

function in_parallel($res1, $res2) {
	$val1 = $res1->value;
	$val2 = $res2->value;
	$value = ($val1*$val2) / ($val1+$val2);
	
	$nstart = $res1->start;
	$nend = $res1->end;

	return new Resistor($nstart.$nend,$value);
	
}

// GET INPUT
$input = array();

fscanf(STDIN, "%d\n", $N);
for ($i = 0; $i<$N; $i++) { 
	$string = fgets(STDIN);
	$string = trim($string);
	$input[] = explode(' ',$string);	
}
//------------------------------------------------


foreach ($input as $data) {
//$data = $input[0];

	//Interpret Input
	//$resistors = array of resistor objects by connection ( "bc" )
	//$connections = exactly the input (ab, cd ...)
	//$nodes = array of node arrays (x resistors for each node)

	$resistor = array();
	$connections = array();
	$nodes = array();

	foreach(range('a','z') as $i) {
		$nodes[$i] = 0;
	}

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

	while (count($connections) > 1) {

		//IN SERIES
		foreach ($nodes as $key => $resno) {
			if ($key == 'a' || $key == 'z')
				continue;

			if ($resno == 2) {
				//Return 'bc' , 'cd' for key = c
				$conns = preg_grep('/['.$key.']/',$connections);

				//Calculate in series
				$tmp = array_values($conns);
				$new = in_series($resistor[$tmp[0]][0],$resistor[$tmp[1]][0]);

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
				$name = $new->name;
				$connections[] = $name;
				$resistor[$name][] = $new;
				$nodes[$name[0]]++ ;
				$nodes[$name[1]]++ ;			
			}
			$nodes = array_filter($nodes); 
		}
	
		//PARALLEL
		$parallel = array_count_values($connections);
		foreach ($parallel as $conn => $freq) {
			if ($freq >= 2) {
			
				$new = in_parallel($resistor[$conn][0],$resistor[$conn][1]);

				//Remove them from connections	
				$key = array_search($conn,$connections);		
				unset($connections[$key]);

				$key = array_search($conn,$connections);		
				unset($connections[$key]);

				//Remove them from resistors
				//Both, but not the whole array yet
				unset($resistor[$conn][0]);
				unset($resistor[$conn][1]);
				$resistor[$conn] = array_values($resistor[$conn]);

				//Remove them from nodes
				$nodes[$conn[0]] -= 2;
				$nodes[$conn[1]] -= 2;


				//Adding NEW
				$name = $new->name;
				$connections[] = $name;
				$resistor[$name][] = $new;
				$nodes[$name[0]]++ ;
				$nodes[$name[1]]++ ;		
			}
		}
	}
	$result = $resistor['az'][0]->value;
	echo number_format($result, 4, '.', ''),"\n";
}	


?>
