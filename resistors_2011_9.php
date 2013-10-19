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

//Functions 

function if_collision($ball1, $ball2, $t0){

	$x1 = $ball1->position;
	$v1 = $ball1->speed;
	$x2 = $ball2->position;
	$v2 = $ball2->speed;

	//Same Speed - No collision
	if ( $v1 == $v2){
		return -1;
	}
	//Same Direction
	if ( $v1 * $v2 > 0 ) {
		if ( $v1 > $v2){
			return (($x2 - $x1)/($v1-$v2) + $t0) ; 		
		}
		else {
			return -1;
		}
	}
	//Opposite Direction
	else {
		if ($v1 > 0) {
			return (($x2 - $x1)/($v1-$v2) + $t0) ; 		
		}
		else{
			return -1;		
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

	//Interpret Input
	$ballnum = $data[0];
	for ($i = 0;$i < $ballnum; $i++) {
		$k = $i*2;
		$balls[$i] = new ball($data[$k+1],$data[$k+2]);
	}
	$length = count($data);
	$finball = $data[$length-2] - 1;
	$fintime = $data[$length-1];	


	// 1 Ball
	if ($ballnum == 1) {
		echo $balls[$finball]->move($fintime),"\n";
	}	
	// 2 Balls	
	elseif ( $ballnum == 2) { 
		$t = if_collision($balls[0], $balls[1], 0);	

		//If no collision, move finball normally 
		if ( ($t == -1) || ($t > $fintime) ){
			echo $balls[$finball]->move($fintime),"\n";
		}
		//If collision: Move, Collide, Move
		else{
			$balls[$finball]->position = $balls[$finball]->move($t);
			$balls[$finball]->collision();
			echo $balls[$finball]->move($fintime-$t),"\n";
		}
	}	

	//3 Balls
	elseif ( $ballnum > 2) {
		$tmin = 0;
		$t0 = 0;
		while ($tmin <= $fintime) {

			$tmin = 99999;
			$coll = -1;
			for ($i	=0; $i< $ballnum-1; $i++) {
				//Check if pair of balls collides
				$t = if_collision($balls[$i], $balls[$i+1], $t0);
				
				//Find first collision
				if ( ($t < $tmin) && ($t != -1) ) { 
					$tmin = $t;
					$coll = $i;
				}
			}
			if ($tmin <= $fintime) {
				
				//Move all balls 
				for ($k=0; $k < $ballnum; $k++) {
					$balls[$k]->position = $balls[$k]->move($tmin-$t0);
				}
		
				//Collide only the two
				$balls[$coll]->collision();
				$balls[$coll+1]->collision();

				$t0 = $tmin;
			}
		}
		echo $balls[$finball]->move($fintime-$t0),"\n";
	}
}	


?>
