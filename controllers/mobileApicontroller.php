<?php

class MobileApiController extends BaseController{
	public function __construct($service, $action){
		parent::__construct($service, $action);
		$this->setService('mdashboard');
	}

	public function dashboard($lastUpdateDate){
		echo $this->service->getDashboardsByUpdateDate($lastUpdateDate);
	}

	public function dashboardcategory($lastUpDate){
		echo $this->service->getDashboardCategoryByUpdateDate($lastUpDate);
	}

	public function buddies($lastUpDate){
		echo $this->service->getBuddiesByUpdateDate($lastUpDate);
	}

	public function buddylocations($lastUpDate){
		echo $this->service->getBuddyLocationsByUpdateDate($lastUpDate);
	}

	public function buddysearchtag($lastUpDate){
		echo $this->service->getBuddySearchTagByUpdateDate($lastUpDate);
	}

	public function usage(){
		echo $this->service->saveMobileUsage($_POST['hits']);
	}

}
?>