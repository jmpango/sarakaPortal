<?php
include_once HOME . DS . 'model' . DS . 'basedata.php';

class User extends BaseData{
	var $username;
	var $password;
	var $roles;
	var $secretQuestion;
	var $secretAnswer;
	var $firstname;
	var $lastname;
	var $gender;

	public function __construct(){
		parent::__construct();
		$this->roles = array();
	}
	
	public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setSecretQuestion($secretQuestion){
		$this->secretQuestion = $secretQuestion;
	}

	public function getSecretQuestion(){
		return $this->secretQuestion;
	}

	public function setSecretAnswer($secretAnswer){
		$this->secretQuestion = $secretAnswer;
	}

	public function getSecretAnswer(){
		return $this->secretAnswer;
	}
	
	public function setFirstName($firstname){
		$this->firstname = $firstname;
	}
	
	public function getFirstName(){
		return $this->firstname;
	}
	
	public function setLastName($lastname){
		$this->lastname = $lastname;
	}
	
	public function getLastName(){
		return $this->lastname;
	}
	
	public function setGender($gender){
		$this->gender = $gender;
	}
	
	public function getGender(){
		return $this->gender;
	}
	
	public function setRoles($roles){
		$this->roles = $roles;
	}

	public function getRoles(){
		return $this->roles;
	}

	public function getFullNames(){
		return $this->firstname. " " . $this->lastname;
	}
	
	public function addRole(Role $role){
		if($this->roles == null){
			$this->roles = array();
		}

		if(!in_array($role, $this->getRoles())){
			$role->addUser($this);
			array_push($this->roles, $role);
		}
	}

	public function removeRole(Role $role){
		if($this->roles == null || $role == null || count($this->roles) == 0){
			return;
		}

		if(in_array($role, $this->getRoles())){
			unset($this->roles[$role->getId()]);
		}
	}

	public function hasNewPassword(){
		if($this->password != null && strlen($this->password) > 0){
			return true;
		}
		return false;
	}

	public function findPermissions(){
		$permissions;
		if($this->roles != null && count($this->roles)){
			$permissions = array();

			for($i = 0; $i < count($this->roles); $i++){
				$role = new Role();
				$role = $this->roles[$i];
				if($role->getPermissions() != null && count($role->getPermissions()) > 0){
					for($k = 0; $k < count($role->getPermissions()); $k++){
						$perm = $role->getPermissions();
						array_push($permissions, $perm[$k]);
					}
				}
			}
		}
		return $permissions;
	}
	
	public function hasAdministrativePriviledge(){
		if($this->roles != null){
			for($i = 0; $i < count($this->roles); $i++){
				$role = new Role();
				$role = $this->roles[$i];
				
				if($role.chechIfDefaultAdminRole()){
					return true;
				}
			}
		}
		
		return false;
	}
}
?>