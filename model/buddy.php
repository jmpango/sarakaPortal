<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';
include_once HOME . DS . 'model' . DS . 'buddyrating.php';

class Buddy extends BaseData{
	var $name;
	var $tagline;
	var $address;
	var $telphoneNos;
	var $email;
	var $fax;
	var $url;
	var $dashboardCategory;
	var $seed;
	
	public function  __construct(){
		parent::__construct();
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function  setTagline($tagline){
		$this->tagline = $tagline;
	}

	public function getTagline(){
		return $this->tagline;
	}

	public function  setTelphoneNos($telphoneNos){
		$this->telphoneNos = $telphoneNos;
	}

	public function getTelphoneNos(){
		return $this->telphoneNos;
	}

	public function  setEmail($email){
		$this->email = $email;
	}

	public function getEmail(){
		return $this->email;
	}

	public function  setFax($fax){
		$this->fax = $fax;
	}

	public function getFax(){
		return $this->fax;
	}

	public function  setUrl($url){
		$this->url = $url;
	}

	public function getUrl(){
		return $this->url;
	}

	public function  setDashboardCategory($dashboardCategory){
		$this->dashboardCategory = $dashboardCategory;
	}

	public function getDashboardCategory(){
		return $this->dashboardCategory;
	}

	public function  setAddress($address){
		$this->address = $address;
	}

	public function getAddress(){
		return $this->address;
	}
	
	public function setSeed($seed){
		$this->seed = $seed;
	}
	
	public function getSeed(){
		return $this->seed;
	}
}
?>