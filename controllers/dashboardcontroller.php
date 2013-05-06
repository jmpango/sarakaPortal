<?php
include_once HOME . DS . 'model' . DS . 'dashboard.php';
include_once HOME . DS . 'model' . DS . 'buddysearchparameter.php';

class DashboardController extends BaseController{
	public function __construct($service, $action){
		parent::__construct($service, $action);
		$this->setService($service);
	}

	public function index(){
		$buddies = $this->service->getAllBuddies();
		if($buddies == null){
			$buddies = array();
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

		$dashboardCategoryService = new DashcategoryService();

		$dashboards = $dashboardCategoryService->getAllDashboardCategories();

		$this->view->set('pgtotal', $start.' - '. $end. ' of '.$this->service->totalCount);
		$this->view->set('offset', $this->service->offset.','.$this->service->totalCount);
		$this->view->set('buddies', $buddies);
		$this->view->set('dashboards', $dashboards);
		return $this->view->output();
	}

	public function listing(){
		try {

			$dashboards = $this->service->getAllDashboardsPaging();
			if($dashboards == null){
				$dashboards = array();
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
			$this->view->set('dashboards', $dashboards);
			return  $this->view->output();
		} catch (CustomException $e) {
			$message = $e->getMessage() ;
		}

		$this->setView('dashboard' . DS);
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		return $this->view->output();

	}

	public function add(){
		$this->setView('dashboard'.DS.'listing'.DS.'add');
		return $this->view->output();
	}

	public function save(){
		if(!isset($_POST['saveForm'])){
			header('Location:'.BASEURL.DS.'dashboard'.DS.'listing');
		}

		$message = "";
		$name = isset($_POST['name']) ? trim($_POST['name']) : null;

		if(empty($name)){
			$message = 'Empty Listing Name.';
		}else{
			try {
				if(isset($_POST['id']) && !empty($_POST['id'])){
					$existingDashboard = $this->service->getDashboardById($_POST['id']);
					if($existingDashboard != null){
						$existingDashboard->setName($name);
						$existingDashboard->setTagline($_POST['tagline']);
						$existingDashboard->setDateupdated(date('Y-m-d H:i:s'));
						$existingDashboard->setStatus((int)$_POST['status']);
						$this->service->edit($existingDashboard);
						
						$this->setView('dashboard'.DS.'listing');
						$this->view->set(SYSTEM_INFO_MESSAGE, 'Listing Saved Sucessfully');
						return $this->listing();
					}

				}else{
					if($this->service->dashboardExist($name) != 1){
						$newDashBoard = new Dashboard();
						$newDashBoard->setId(null);
						$newDashBoard->setDateupdated(date('Y-m-d H:i:s'));
						$newDashBoard->setName(ucwords($name));
						$newDashBoard->setTagline($_POST['tagline']);
						$newDashBoard->setStatus((int)$_POST['status']);

						$this->service->save($newDashBoard);

						$this->setView('dashboard'.DS.'listing');
						$this->view->set(SYSTEM_INFO_MESSAGE, 'Listing Saved Sucessfully');
						return $this->listing();
					}else{
						$message  = "dashboard with ".$name." already exitsts.";
					}

				}

			} catch (CustomException $e) {
				$message = $e->getMessage();
			}

		}

		$this->setView('dashboard'.DS.'listing'.DS.'add');
		$this->view->set('saveForm', $_POST);
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		return $this->view->output();
	}

	public function pgnext($number){

		$params = explode(",", $number);
		$this->setService('Dashboard');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] + $this->service->maxLimit >= $this->service->totalCount){
			$this->service->setOffSet((int)$params[0] );
		}else{
			$this->service->setOffSet((int)$params[0] + $this->service->maxLimit);
		}
		$this->setView('dashboard'.DS.'listing');
		return $this->listing();
	}

	public function pgprv($number){
		$params = explode(",", $number);
		$this->setService('Dashboard');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] - $this->service->maxLimit < 0){
			$this->service->setOffSet(0);
		}else{
			$this->service->setOffSet((int)$params[0] - $this->service->maxLimit);
		}
		$this->setView('dashboard'.DS.'listing');
		return $this->listing();
	}

	public function search(){
		if(!isset($_POST['searchForm'])){
			header('Location:'.BASEURL.DS.'dashboard'.DS.'listing');
		}
		$this->setView('dashboard'.DS.'listing');
		$message;
		$query = isset($_POST['query']) ? trim($_POST['query']) : null;

		if(!empty($query) || ($_POST['status'] !='')){
			$this->setService('Dashboard');
			$dashboards = $this->service->search(ucwords($query), $_POST['status']);
			if($dashboards == null){
				$message  = 'No record found.';
			}else{
				try {
					$end= $this->service->offset + sizeof($dashboards) ;

					$this->setView('dashboard'.DS.'listing');
					$this->view->set('searchForm', $_POST);
					$this->view->set('pgtotal', '1 - '. $end. ' of '.sizeof($dashboards));
					$this->view->set('offset', $this->service->offset.','.sizeof($dashboards));
					$this->view->set('dashboards', $dashboards);
					$this->view->set(SYSTEM_INFO_MESSAGE, 'Search query returned '.sizeof($dashboards).' records.');
					return  $this->view->output();

				} catch (CustomException $e) {
					$message = $e->getMessage() ;
				}
			}
		}
		$this->view->set('searchForm', $_POST);
		if (!empty($message)){
			$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		}
		return $this->listing();
	}

	public function edit($id){
		if(empty($id)){
			return $this->listing();
		}

		$dashboard = $this->service->getDashboardById($id);

		if($dashboard == null){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id doesnot exist.');
			return $this->listing();
		}

		$this->setView('dashboard'.DS.'listing'.DS.'add');
		$this->view->set('id', $dashboard->id);
		$this->view->set('status', $dashboard->status);
		$this->view->set('name', $dashboard->name);
		$this->view->set('tagline', $dashboard->tagline);
		return $this->view->output();
	}

	public function delete($ids){
		$this->setView('dashboard'.DS.'listing');
		if(empty($ids)){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'No specified items to delete');
			return $this->listing();
		}
		$params = explode(",", $ids);
		foreach ($params as $id){
			try {
				$this->service->delete($id);
			} catch (CustomException $e) {
				$this->view->set(SYSTEM_ERROR_MESSAGE, $e->getMessage());
				return $this->listing();
			}
		}
		$this->view->set(SYSTEM_INFO_MESSAGE, sizeof($ids).' items were deleted sucessfully.');
		return $this->listing();
	}

	public function buddypgnext($number){

		$params = explode(",", $number);
		$this->setService('Dashboard');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] + $this->service->maxLimit >= $this->service->totalCount){
			$this->service->setOffSet((int)$params[0] );
		}else{
			$this->service->setOffSet((int)$params[0] + $this->service->maxLimit);
		}
		$this->setView('dashboard'.DS.'index');
		return $this->index();
	}

	public function buddypgprv($number){
		$params = explode(",", $number);
		$this->setService('Dashboard');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] - $this->service->maxLimit < 0){
			$this->service->setOffSet(0);
		}else{
			$this->service->setOffSet((int)$params[0] - $this->service->maxLimit);
		}
		$this->setView('dashboard'.DS.'index');
		return $this->index();
	}

	public function buddysearch(){
		if(!isset($_POST['searchBtn'])){
			header('Location:'.BASEURL.DS.'dashboard'.DS.'index');
		}
			
		$this->setView('dashboard'.DS.'index');

		$name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$owner = isset($_POST['owner']) ? trim($_POST['owner']) : '';
		$status = isset($_POST['status']) ? trim($_POST['status']) : '';

		if($owner != '' || $status !='' || $name !='' ){
			$searchParm = new BuddySearchParameter();
			$searchParm->setName($name);
			$searchParm->setOwner($owner);
			$searchParm->setStatus($status);

			$buddies = $this->service->buddysearch($searchParm);
			$dashboardCategoryService = new DashcategoryService();
			$dashboards = $dashboardCategoryService->getAllDashboardCategories();
			
			if(!empty($buddies)){
				$this->view->set(SYSTEM_INFO_MESSAGE,'Search found with '.count($buddies).' results');
				$this->view->set('pgtotal','1 - '. count($buddies). ' of '.count($buddies));
				$this->view->set('buddies', $buddies);
				$this->view->set('dashboards', $dashboards);
				return $this->view->output();
			}
			$this->view->set(SYSTEM_INFO_MESSAGE,'No Search found.');
		}
		return $this->index();
	}
	
	
}
?>