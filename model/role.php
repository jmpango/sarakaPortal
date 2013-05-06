<?php
class  Role extends BaseData{
	const DEFAULT_ADMIN_ROLE = "ROLE_ADMINISTRATOR";
	var $name;
	var $description;
	var $permissions;
	//protected $users;

	public function __construct(){
		parent::__construct();
		$this->permissions = array();
	}

	public function setName($roleName){
		$this->name = $roleName;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function setPermissions($permissions){
		$this->permissions = $permissions;
	}
	
	public function getPermissions(){
		return $this->permissions;
	}
	
	public function chechIfDefaultAdminRole(){

		if($this->getName() == SELF::DEFAULT_ADMIN_ROLE){
			return true;
		}
		return false;
	}
}
?>