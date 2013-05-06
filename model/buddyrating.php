<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class BuddyRating extends BaseData{
	var $currentRate;
	var $prvRate;
	
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
}
?>