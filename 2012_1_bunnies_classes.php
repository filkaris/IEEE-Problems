<?php

//Define Classes

class bunny {	
	public $number;
	
	public function kill(){
		$this->number = round($this->number*0.75);
	}
	public function __construct($data){
		$this->number = $data;
	}
}

class newborn extends bunny {

	public function growth($data){
		$this->number = round($data*0.9);
	}
}

class premature extends bunny { 
	public $preadult;
	
	public function leave(){
		$this->preadult = round($this->preadult*0.7);	
	}
}


fscanf(STDIN, "%d\n", $input);


//Instantiate
$adults = new bunny($input);
$newborn = new newborn(0);
$premature = new premature(0);


//read from std input

$bunnies = $adults->number;

for ($i = 15; $i<365; $i += 15) {

	//Check if bunnies died
	if ($bunnies == 0){
		break;
	}

	//bunnies swapping
	
	$premature->preadult = $premature->number;
	$premature->number = $newborn->number;

	//Birth
	$newborn->growth($adults->number);
	
       	//mature
	if ($i >= 45 ){
		$premature->leave();
		$adults->number += $premature->preadult;
	}

	//bunnies die from flu
	if ( $i % 30 == 0){ 
		$adults->kill();
		$newborn->kill();
		$premature->kill();
	}

	$bunnies = ($adults->number + $newborn->number + $premature->number);	
}

echo $bunnies,"\n";
echo "Adults:",$adults->number,"\nNewborn:",$newborn->number,"\nPremature:",$premature->number,"\n\n";




?>
