<?php

$originals = array();
$encrypted = array();

//INPUT--------------------
fscanf(STDIN, "%d\n", $n);

for ($i=0;$i<$n;$i++) {
	fscanf(STDIN, "%s\n", $word);
	$dictionary[] = $word;
}
fscanf(STDIN,"\n");
$string = fgets(STDIN);
var_dump($string);
?>
