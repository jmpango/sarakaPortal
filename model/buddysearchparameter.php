<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class BuddySearchParameter {
	var $name;
	var $owner;
	var $status;

	public function  __construct(){
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function setOwner($owner){
		$this->owner = $owner;
	}

	public function getOwner(){
		return $this->owner;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}
}
?>