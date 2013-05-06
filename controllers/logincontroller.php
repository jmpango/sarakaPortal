<?php
include_once HOME . DS . 'model' . DS . 'user.php';

class LoginController extends BaseController{
	public function __construct($service, $action){
		parent::__construct($service, $action);
		$this->setService($service);
	}

	public function index(){
		return $this->view->output();
	}

	public function validate(){
		if(!isset($_POST['loginForm'])){
			header('Location:'.BASEURL.DS.'login'.DS);
		}
		$message;
		$username = isset($_POST['username']) ? trim($_POST['username']) : null;
		$password = isset($_POST['password']) ? trim($_POST['password']) : null;
		if(empty($username) || empty($password)){
			$message = 'Empty password or username.';
		}else{
			try {
				$user = $this->service->authenticate($username, $password);
				if($user == null){
					$message = 'invalid username OR password.';
				}else{
					session_start();
					$_SESSION['user'] = $user;
					$this->setView('dashboard'.DS.'index');
					$dashboardController  = new DashboardController('Dashboard', 'index');
					return $dashboardController->index();
				}
					
			} catch (CustomException $e) {
				$message = $e ;
			}
		}
		$this->setView($_POST['pageName']);
		$this->view->set('loginForm', $_POST);
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		return $this->view->output();
	}

	public function logout(){
		session_start();
		if(isset($_SESSION['user'])){
			session_destroy();
			$this->setView('login' .DS .'index');
			$this->view->set(SYSTEM_INFO_MESSAGE, 'Logged out sucessfully.');
			$this->view->output();
		}else {
			header('Location:'.BASEURL.DS.'login'.DS);
		}
	}
}
?>