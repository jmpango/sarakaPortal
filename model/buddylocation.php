<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class BuddyLocation extends BaseData{
	var $locationName;
	var $buddy;
	
	public function  __construct(){
		parent::__construct();
	}

	public function setLocationName($locationName){
		$this->locationName = $locationName;
	}

	public function getLocationName(){
		return $this->locationName;
	}

	public function setBuddy($buddy){
		$this->buddy = $buddy;
	}

	public function getBuddy(){
		return $this->buddy;
	}
}
?>