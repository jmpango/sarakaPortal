<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class BuddySearchTag extends BaseData{
	var $searchValue;
	var $buddy;

	public function  __construct(){
		parent::__construct();
	}

	public function setSearchValue($searchValue){
		$this->searchValue = $searchValue;
	}

	public function getSearchValue(){
		return $this->searchValue;
	}

	public function setBuddy($buddy){
		$this->buddy = $buddy;
	}

	public function getBuddy(){
		return $this->buddy;
	}
}
?>