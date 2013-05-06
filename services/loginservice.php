<?php
include_once HOME . DS . 'services' . DS . 'userservice.php';

class LoginService extends BaseDAO{

	public function authenticate($username, $password){
		$userService = new UserService();
		return $userService->authenticate($username, $password);
	}
}
?>