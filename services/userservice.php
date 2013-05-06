<?php
include_once HOME . DS . 'model' . DS . 'user.php';
include_once HOME . DS . 'services' . DS . 'roleservice.php';
include_once HOME . DS . 'model' . DS . 'exception' . DS . 'customexception.php';

class UserService extends BaseDAO{
	private $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";

	public function authenticate($username, $password){
		try{
			$sql = "SELECT * FROM users u WHERE u.username = :username AND u.password = :password LIMIT 1";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('username', $username, PDO::PARAM_STR);
			$stmt->bindValue('password', hash("sha256", $password . $this->salt), PDO::PARAM_STR);
			$stmt->execute();
			$result =  $stmt->fetchAll();

			if(!empty($result)){
				return $this->buildUser($result);
			}

			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	private function buildUser($result){
		$user = new User();
		$user->id = $result[0]['id'];
		$user->dateupdated = $result[0]['date_last_updated'];
		$user->secretQuestion = $result[0]['secret_question'];
		$user->secretAnswer = $result[0]['secret_answer'];
		$user->status = $result[0]['record_status'];
		$user->username = $result[0]['username'];
		$user->firstname = $result[0]['first_name'];
		$user->lastname = $result[0]['last_name'];
		$user->gender = $result[0]['gender'];
		$user->password = $result[0]['password'];

		$roleService = new RoleService();
		$user->roles = $roleService->getRolesByUserId($user->getId());

		return  $user;
	}
}
?>