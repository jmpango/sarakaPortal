<?php
include_once HOME . DS . 'model' . DS . 'dashboardcategory.php';
include_once HOME . DS . 'services' . DS . 'dashboardservice.php';

class DashcategoryController extends BaseController{
	var $dashboardService;

	public function __construct($service, $action){
		parent::__construct($service, $action);
		$this->setService($service);
		$this->dashboardService = new DashboardService();
	}

	public function index($dashboardId){
		$message;
		try {
			if($dashboardId == null){
				header('Location:'.BASEURL.DS.'dashboard'.DS.'index');
			}

			$isExsiting = $this->dashboardService->getDashboardById($dashboardId);
			if($isExsiting == null){
				$message = 'unknown supplied dashboard item';
			}else{
				$dashCategories = $this->service->getDashboardCategories($dashboardId);
				if($dashCategories == null){
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

				$this->view->set('dashboard', $isExsiting);
				$this->view->set('pgtotal', $start.' - '. $end. ' of '.$this->service->totalCount);
				$this->view->set('offset', $this->service->offset.','.$this->service->totalCount.','.$dashboardId);
				$this->view->set('dashCategories', $dashCategories);
				return  $this->view->output();
			}
		} catch (CustomException $e) {
			$message = $e->getMessage() ;
		}

		$this->setView('dashboard' . DS . 'listing');
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		return $this->view->output();
	}

	public function add($dashboard_id){
		$this->setView('dashcategory'.DS.'add');
		$this->view->set('dashboard', $this->dashboardService->getDashboardById($dashboard_id));
		return $this->view->output();
	}

	public function save($dashboard_id){
		if(!isset($_POST['saveForm'])){
			header('Location:'.BASEURL.DS.'dashcategory'.DS.'cat'.DS.'index'.DS.$dashboard_id);
		}

		if($this->dashboardService->getDashboardById($dashboard_id) == null){
			$message = 'Unknown dashboard id supplied';
		}else{

			$message;
			$name = isset($_POST['name']) ? trim($_POST['name']) : null;

			if(empty($name)){
				$message = 'Empty Listing Name.';
			}else{
				try {
					if(isset($_POST['id']) && !empty($_POST['id'])){
						$existingDashboardCategory = $this->service->getDashboardCategoryById($_POST['id']);
						if($existingDashboardCategory != null){
							$existingDashboardCategory->setName($name);
							$existingDashboardCategory->setDateupdated(date('Y-m-d H:i:s'));
							$existingDashboardCategory->setStatus((int)$_POST['status']);
							$existingDashboardCategory->setDashboard($this->dashboardService->getDashboardById($dashboard_id));
							$this->service->edit($existingDashboardCategory);
							$this->setView('dashcategory'.DS.'index');
							$this->view->set(SYSTEM_INFO_MESSAGE, 'Dashboard Category Saved Sucessfully');
							return $this->index($dashboard_id);
						}
					}else{

						if($this->service->dashboardCategoryExist($name) != 1){

							$newCategory = new DashboardCategory();
							$newCategory->setId(null);
							$newCategory->setDateupdated(date('Y-m-d H:i:s'));
							$newCategory->setName(ucwords($name));
							$newCategory->setStatus((int)$_POST['status']);
							$newCategory->setDashboard($this->dashboardService->getDashboardById($dashboard_id));

							$this->service->save($newCategory);
								
							$this->setView('dashcategory'.DS.'index');
							$this->view->set(SYSTEM_INFO_MESSAGE, 'Dashboard Category Saved Sucessfully');
							return $this->index($dashboard_id);
						}else{
							$message  = "dashboard category with ".$name." already exitsts.";
						}
					}

				} catch (CustomException $e) {
					$message = $e->getMessage();
				}
			}
		}

		$this->setView('dashcategory'.DS.'add');
		$this->view->set('dashboard', $this->dashboardService->getDashboardById($dashboard_id));
		$this->view->set('saveForm', $_POST);
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		return $this->view->output();
	}

	public function edit($id){
		$params = explode(":", $id);
		$dashboardId  = $params[0];
		$dCategoryId = $params[1];

		$dCategory = $this->service->getDashboardCategoryById($dCategoryId);

		if($dCategory == null){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id doesnot exist');
			return $this->index($dashboardId);
		}

		$this->setView('dashcategory'.DS.'add');
		$this->view->set('id', $dCategory->id);
		$this->view->set('name', $dCategory->name);
		$this->view->set('status', $dCategory->status);
		$this->view->set('dashboard', $this->dashboardService->getDashboardById($id));
		return $this->view->output();

	}

	public function pgnext($number){

		$params = explode(",", $number);
		$this->setService('Dashcategory');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] + $this->service->maxLimit >= $this->service->totalCount){
			$this->service->setOffSet((int)$params[0]);
		}else{
			$this->service->setOffSet((int)$params[0] + $this->service->maxLimit);
		}
		$this->setView('dashcategory'.DS.'index');
		return $this->index($params[2]);
	}

	public function pgprv($number){

		$params = explode(",", $number);
		$this->setService('Dashcategory');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] - $this->service->maxLimit < 0){
			$this->service->setOffSet(0);
		}else{
			$this->service->setOffSet((int)$params[0] - $this->service->maxLimit);
		}
		$this->setView('dashcategory'.DS.'index');
		return $this->index($params[2]);
	}

	public function search($dashboardId){
		if(!isset($_POST['searchForm'])){
			header('Location:'.BASEURL.DS.'dashcategory'.DS.'index'.DS.$dashboardId);
		}
		$this->setView('dashcategory'.DS.'index');
		$message;
		$query = isset($_POST['query']) ? trim($_POST['query']) : null;

		if(!empty($query) || ($_POST['status'] !='')){
			$this->setService('Dashcategory');
			$dashboardCategories = $this->service->search($query, $dashboardId, $_POST['status']);
			if($dashboardCategories == null){
				$message  = 'No record found.';
			}else{
				try {
					$end= $this->service->offset + sizeof($dashboardCategories) ;

					$this->view->set('dashboard', $this->dashboardService->getDashboardById($dashboardId));
					$this->view->set('searchForm', $_POST);
					$this->view->set('pgtotal', '1 - '. $end. ' of '.sizeof($dashboardCategories));
					$this->view->set('offset', $this->service->offset.','.sizeof($dashboardCategories).','.$dashboardId);
					$this->view->set('dashCategories', $dashboardCategories);
					$this->view->set(SYSTEM_INFO_MESSAGE, 'Search query returned '.sizeof($dashboardCategories).' records.');
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
		return $this->index($dashboardId);
	}

	public function delete($ids){
		$this->setView('dashcategory'.DS.'index');
		if(empty($ids)){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'No specified items to delete');
			return $this->index(null);
		}
		$dashboardId;
		$params = explode(",", $ids);
		$counter = 0;
		foreach ($params as $paramz){
			try {
				$ids = explode(":", $paramz);
				$dashboardId = $ids[0];
				$this->service->delete($ids[1]);
			} catch (CustomException $e) {
				$this->view->set(SYSTEM_ERROR_MESSAGE, $e->getMessage());
				return $this->index($dashboardId);
			}
			$counter++;
		}
		$this->view->set(SYSTEM_INFO_MESSAGE, $counter.' items were deleted sucessfully.');
		return $this->index($dashboardId);
	}
}
?>