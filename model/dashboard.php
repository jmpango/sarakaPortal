<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class Dashboard extends BaseData{
	var $name;
	var $tagline;

	public function  __construct(){
		parent::__construct();
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function setTagline($tagline){
		$this->tagline = $tagline;
	}

	public function getTagline(){
		return $this->tagline;
	}
}
?>