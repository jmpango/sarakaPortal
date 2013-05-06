<?php

class CpanelController extends BaseController{
	public function __construct($service, $action){
		parent::__construct($service, $action);
		$this->setService($service);
	}

	public function index(){
		return $this->view->output();
	}

	public function vseeding(){
		$seedings = $this->service->getAllSeedings();
		if($seedings == null){
			$seedings = array();
		}

		$start = $this->service->offset;
		$end= $this->service->offset + $this->service->maxLimit ;
		if($this->service->offset == 0){
			$start = 1;
		}else{
			++$start;
			--$end;
		}
		if($end > $this->service->totalCount){
			$end = $this->service->totalCount;
		}

		$this->view->set('pgtotal', $start.' - '. $end. ' of '.$this->service->totalCount);
		$this->view->set('offset', $this->service->offset.','.$this->service->totalCount);
		$this->view->set("seedings", $seedings);
		return $this->view->output();
	}

	public function addseeding(){
		return $this->view->output();
	}

	public function saveseeding(){
		if(!isset($_POST['saveForm'])){
			return $this->vseeding();
		}

		$message = "";
		$name = isset($_POST['name']) ? trim($_POST['name']) : null;
		$description = isset($_POST['description']) ? trim($_POST['description']) : null;

		if(empty($name) || empty($description)){
			$message = 'Both seeding name and description are needed.';
		}else{
			try {
				$seeding = new Seeding();
				$seeding->name = $name;
				$seeding->description = $description;
					
				if(isset($_POST['id']) && !empty($_POST['id'])){
					$seeding->id  = $_POST['id'];
					$this->service->editseeding($seeding);
				}else {
					$this->service->saveseeding($seeding);
				}

				$this->setView('cpanel'.DS.'vseeding');
				$this->view->set(SYSTEM_INFO_MESSAGE, 'Seeding Saved Sucessfully');
				return $this->vseeding();
					
			} catch (CustomException $e) {
				$message = $e->getMessage();
				$this->setView('cpanel'.DS.'addseeding');
				$this->view->set('saveForm', $_POST);
				$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
				return $this->view->output();
			}

		}

		$this->setView('cpanel'.DS.'addseeding');
		$this->view->set('saveForm', $_POST);
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		return $this->view->output();
	}

	public function editseeding($id){
		if(empty($id)){
			return $this->vseeding();
		}

		$seeding = $this->service->getSeedingById($id);

		if($seeding == null){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id doesnot exist.');
			return $this->vseeding();
		}

		$this->setView('cpanel'.DS. 'addseeding');
		$this->view->set('id', $seeding->id);
		$this->view->set('name', $seeding->name);
		$this->view->set('description', $seeding->description);
		return $this->view->output();
	}

	public function deleteseeding($ids){
		$this->setView('cpanel'.DS.'vseeding');
		if(empty($ids)){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'No specified items to delete');
			return $this->vseeding();
		}
		$params = explode(",", $ids);
		foreach ($params as $id){
			try {
				$this->service->deleteseeding($id);
			} catch (CustomException $e) {
				$this->view->set(SYSTEM_ERROR_MESSAGE, $e->getMessage());
				return $this->listing();
			}
		}
		$this->view->set(SYSTEM_INFO_MESSAGE, sizeof($ids).' items were deleted sucessfully.');
		return $this->vseeding();
	}

	public function seedingpgnext($number){

		$params = explode(",", $number);
		$this->setService('cpanel');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] + $this->service->maxLimit >= $this->service->totalCount){
			$this->service->setOffSet((int)$params[0] );
		}else{
			$this->service->setOffSet((int)$params[0] + $this->service->maxLimit);
		}
		$this->setView('cpanel'.DS.'vseeding');
		return $this->vseeding();
	}

	public function seedingpgprv($number){
		$params = explode(",", $number);
		$this->setService('cpanel');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] - $this->service->maxLimit < 0){
			$this->service->setOffSet(0);
		}else{
			$this->service->setOffSet((int)$params[0] - $this->service->maxLimit);
		}
		$this->setView('cpanel'.DS.'vseeding');
		return $this->vseeding();
	}

}

?>