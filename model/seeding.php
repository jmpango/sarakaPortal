<?php
class Seeding extends BaseData{
	var $name;
	var $description;

	public function __construct(){
		parent::__construct();
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function getDescription(){
		return $this->description;
	}
}
?>