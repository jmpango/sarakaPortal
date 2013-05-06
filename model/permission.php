<?php
class Permission extends BaseData{
	var $name;
	var $description;
	
	function __construct(){
		parent::__construct();
	}
	
	function setName($name){
		$this->name = name;
	}
	
	function getName(){
		return $this->name;
	} 
	
	function setDescription($description){
		$this->description = $description;
	}
	
	function getDescription(){
		return $this->description;
	}
}
?>