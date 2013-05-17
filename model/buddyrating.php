<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class BuddyRate extends BaseData{
	var $currentRate;
	var $prvRate;
	var $buddyId;

	public function  __construct(){
		parent::__construct();
	}

	public function setCurrentRate($currentRate){
		$this->currentRate = $currentRate;
	}

	public function getCurrentRate(){
		return $this->currentRate;
	}

	public function  setPrvRate($prvRate){
		$this->prvRate = $prvRate;
	}

	public function getPrvRate(){
		return $this->prvRate;
	}

	public function setBuddyId($buddyId){
		$this->buddyId = $buddyId;
	}

	public function getBuddyId(){
		return $this->buddyId;
	}
}
?>