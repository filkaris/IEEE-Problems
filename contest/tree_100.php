<?php

class Node {
	public $from;
	public $to;
	public $name;
	public $value;

	public function __construct($name) {
		$this->from = array();
		$this->to = array();
		$this->name = $name;
		$this->value = 0;
	}
	
	public function add_child($child) {
		$this->to[] = $child;
	}

	public function add_parent($parent) {
		$this->from[] = $parent;
	}

	public function set_value($value = 1) {
		$this->value = $value;
	}

	public function add_value($value) {
		$this->value += $value;
	}

}

function get_value($ndkey) {
	global $nodes;	
	
	foreach	($nodes[$ndkey]->from as $parent) {
		if (empty($nodes[$parent]->value)) {
			get_value($parent);
		}
		$val = $nodes[$parent]->value / count($nodes[$parent]->to);
		$nodes[$ndkey]->add_value($val);
	}
}

function set_child($ndkey) {
	global $nodes;

	if (empty($nodes[$ndkey]->value)) {
		get_value($ndkey);
	}	

	if (empty($nodes[$ndkey]->to)) {
		return;
	}
	foreach ($nodes[$ndkey]->to as $child) {
		set_child($child);
	}
	return;

}

//GET INPUT-----------------------
$nodes = array();
$dest = array();
fscanf(STDIN, "%s\n", $verts);

for ($i=1; $i<=$verts; $i++) {
	$nodes[$i] = new Node($i);
}

for ($i=0; $i<$verts-1; $i++) {
	fscanf(STDIN, "%s %s\n", $from, $to);
	$nodes[$from]->add_child($to);
	$nodes[$to]->add_parent($from);
}

$first = true;

foreach ($nodes as $key => $node) {
	if (empty($node->from)) {		
		$node->set_value();
		if ($first) {
			$startnode = $key;
			$first = false;
		}
	}	
}

set_child($startnode);

$values = array();
foreach ($nodes as $node) {
	$values[$node->name] = $node->value;
}

$bottleneck = array_keys($values,max($values));

foreach ($bottleneck as $fin) {
	echo "$fin\n";
}

?>
