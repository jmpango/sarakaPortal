<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class DashboardCategory extends BaseData{
	var $name;
	var $dashboard;
	
	public function  __construct(){
		parent::__construct();
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getDashboard(){
		return $this->dashboard;
	}
	
	public function setDashboard($dashboard){
		$this->dashboard = $dashboard;
	}
}
?>