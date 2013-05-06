<?php

class BaseData{
	var $id;
	var $dateupdated;
	var $status;
	
	public function __construct(){
	}
	
	function setId($id){
		$this->id = $id;
	}
	
	function getId(){
		return $this->id;
	}
	
	function setDateupdated($dateupdated){
		$this->dateupdated = $dateupdated;
	}
	
	function getDateupdated(){
		return $this->dateupdated;
	}
	
	function setStatus($status){
		$this->status = $status;
	}
	
	function getStatus(){
		return $this->status;
	}
}
?>