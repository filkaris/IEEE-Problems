<?php

//Classes

class ball {
	public $position;
	public $speed;

	public function __construct($pos,$speed) {
		$this->position = $pos;
		$this->speed = $speed;
	}

	public function collision() {
		$this->speed = -1 * $this->speed;
	}

	public function move($time) {
		$pos = $this->position;
		$pos += $this->speed * $time;
		if ($pos < 0) {
			return 0;
		} elseif ($pos > 100) {
			return 100;
		} else { 
			return $pos; 
		}
	}

}

$input = array();

// GET INPUT
fscanf(STDIN, "%d\n", $N);
for ($i = 0; $i<$N; $i++) { 
	$string = fgets(STDIN);
	$input[] = explode(' ',$string);	
}
//------------------------------------------------

$balls = array();
foreach ($input as $data) {
	$ballnum = $data[0];
	for ($i = 0;$i < $ballnum; $i+=2) {
		$balls[$i] = new ball($data[$i+1],$data[$i+2]);
	}
	$length = count($data);
	$finball = $data[$length-2] - 1;
	$fintime = $data[$length-1];	

	var_dump($balls);	
	echo $balls[$finball]->move($fintime),"\n";	
}

?>










