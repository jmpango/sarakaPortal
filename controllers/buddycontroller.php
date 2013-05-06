<?php
include_once HOME . DS . 'services' . DS . 'dashcategoryservice.php';
include_once HOME . DS . 'services' . DS . 'dashboardservice.php';
include_once HOME . DS . 'services' . DS . 'buddyservice.php';
include_once HOME . DS . 'model' . DS . 'resizeimage.php';

class BuddyController extends BaseController{
	var $dashboardCategoryService;

	public function __construct($service, $action){
		parent::__construct($service, $action);
		$this->setService($service);
		$this->dashboardCategoryService = new DashcategoryService();
	}

	public function listing($dashCategoryID){
		try {
			$message;
			$dashboardCategory = $this->getDashboardCategory($dashCategoryID);
			$buddies = $this->service->getAllBuddiesByDashboardCategoryIdPaging($dashboardCategory->getId());
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

			$this->view->set('pgtotal', $start.' - '. $end. ' of '.$this->service->totalCount);
			$this->view->set('offset', $this->service->offset.','.$this->service->totalCount.','.$dashCategoryID);
			$this->view->set('dashcategory', $dashboardCategory);
			$this->view->set('buddies', $buddies);
			return  $this->view->output();
		} catch (CustomException $e) {
			$message = $e->getMessage() ;
			die($message);
		}

		$this->setView('dashboard'.DS.'index' .DS);
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		return $this->view->output();

	}

	public function add($dcategory_id){
		$this->setView('buddy'.DS.'add');
		$this->view->set('dashcategory', $this->getDashboardCategory($dcategory_id));
		return $this->view->output();
	}

	private function  getDashboardCategory($dashCategoryID){
		$dashboardCategory = $this->dashboardCategoryService->getDashboardCategoryById($dashCategoryID);
		$dashboardService = new DashboardService();
		$dashbordId = $this->dashboardCategoryService->getDashboardIdByCategoryById($dashCategoryID);
		$dashboard = $dashboardService->getDashboardById($dashbordId);
		$dashboardCategory->setDashboard($dashboard);
		return $dashboardCategory;
	}

	public function save($dashboardCategoryId){
		if(!isset($_POST['saveForm']) || empty($dashboardCategoryId)){
			header('Location:'.BASEURL.DS.'dashboard'.DS.'listing');
		}
		$message;
		$name = isset($_POST['name']) ? trim($_POST['name']) : null;
		$telphone1 = isset($_POST['telphone1']) ? trim($_POST['telphone1']) : null;

		if(empty($name) || empty($telphone1)){
			$message = 'Buddy should have a name and atleast a telphoneNo.';
		}else{

			try{
				$newBuddy = new Buddy();
				$newBuddy->setId(isset($_POST['id']) ? trim($_POST['id']) : null);
				$newBuddy->setDateupdated(date('Y-m-d H:i:s'));
				$newBuddy->setName(ucwords($name));
				$newBuddy->setStatus((int)$_POST['status']);
				$newBuddy->setTagline(isset($_POST['tagline']) ? trim($_POST['tagline']) : null);
				$newBuddy->setAddress(isset($_POST['address']) ? trim($_POST['address']) : null);

				$telphone1 = preg_replace('/\s+/', '', $telphone1);
				$telphone2 = isset($_POST['telphone2']) ? trim($_POST['telphone2']) : null;
				$telphone3 = isset($_POST['telphone3']) ? trim($_POST['telphone3']) : null;

				if($telphone2 != null){
					$telphone1 = $telphone1 . ',' . preg_replace('/\s+/', '', $telphone2);
				}

				if($telphone3 != null){
					$telphone1 = $telphone1 . ',' . preg_replace('/\s+/', '', $telphone3);
				}

				$newBuddy->setTelphoneNos($telphone1);
				$newBuddy->setEmail(isset($_POST['email']) ? trim($_POST['email']) : null);
				$newBuddy->setFax(isset($_POST['fax']) ? trim($_POST['fax']) : null);
				$newBuddy->setUrl(isset($_POST['url']) ? trim($_POST['url']) : null);
				$newBuddy->setDashboardCategory($this->getDashboardCategory($dashboardCategoryId));
					
				if($newBuddy->getId() != null){
					$this->service->edit($newBuddy);
				}else{
					$this->service->save($newBuddy);
				}
					
				$this->setView('buddy'.DS.'listing');
				$this->view->set(SYSTEM_INFO_MESSAGE, 'buddy Saved Sucessfully');
				return $this->listing($dashboardCategoryId);
			} catch (CustomException $e) {
				$message = $e->getMessage();
			}
		}

		$this->setView('buddy'.DS.'add');
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		$this->view->set('saveForm', $_POST);
		$this->view->set('dashcategory', $this->getDashboardCategory($dashboardCategoryId));
		return $this->view->output();
	}

	public function edit($id){
		if(empty($id)){
			$this->setView('dashboard'.'listing');
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id for buddy object doesnot exist');
			return $this->view->output();
		}

		$params = explode(":", $id);
		$buddyId  = $params[0];
		$dCategoryId = $params[1];

		$dashboardCategory = $this->getDashboardCategory($dCategoryId);

		if($dashboardCategory == null){
			$this->setView('dashboard'.'listing');
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id doesnot exist.');
			return $this->view->output();
		}

		$buddy = $this->service->getBuddyById($buddyId);

		$this->setView('buddy'.DS.'add');
		$this->view->set('id', $buddy->id);
		$this->view->set('status', $buddy->status);
		$this->view->set('name', $buddy->name);
		$this->view->set('tagline', $buddy->tagline);
		$this->view->set('address', $buddy->address);

		$Nos = explode(",", $buddy->telphoneNos);
		if(count($Nos) == 1){
			$this->view->set('telphone1', $Nos[0]);
		}else if(count($Nos) == 2){
			$this->view->set('telphone1', $Nos[0]);
			$this->view->set('telphone2', $Nos[1]);
		}else{
			$this->view->set('telphone1', $Nos[0]);
			$this->view->set('telphone2', $Nos[1]);
			$this->view->set('telphone3', $Nos[2]);
		}

		$this->view->set('telphoneNos', $buddy->telphoneNos);
		$this->view->set('email', $buddy->email);
		$this->view->set('fax', $buddy->fax);
		$this->view->set('url', $buddy->url);
		$this->view->set('dashcategory', $dashboardCategory);
		return $this->view->output();
	}

	public function pgnext($number){

		$params = explode(",", $number);
		$this->setService('buddy');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] + $this->service->maxLimit >= $this->service->totalCount){
			$this->service->setOffSet((int)$params[0] );
		}else{
			$this->service->setOffSet((int)$params[0] + $this->service->maxLimit);
		}
		$this->setView('buddy'.DS.'listing');
		return $this->listing($params[2]);
	}

	public function pgprv($number){
		$params = explode(",", $number);
		$this->setService('buddy');
		$this->service->setTotalCount((int)$params[1]);
		if((int)$params[0] - $this->service->maxLimit < 0){
			$this->service->setOffSet(0);
		}else{
			$this->service->setOffSet((int)$params[0] - $this->service->maxLimit);
		}
		$this->setView('buddy'.DS.'listing');
		return $this->listing($params[2]);
	}

	public function delete($ids){
		$this->setView('buddy'.DS.'listing');
		if(empty($ids)){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'No specified items to delete');
			return $this->listing(null);
		}
		$dashboardCategoryId;
		$params = explode(",", $ids);
		$counter = 0;
		foreach ($params as $paramz){
			try {
				$ids = explode(":", $paramz);
				$dashboardCategoryId = $ids[1];
				$this->service->delete($ids[0]);
			} catch (CustomException $e) {
				$this->view->set(SYSTEM_ERROR_MESSAGE, $e->getMessage());
				return $this->listing($dashboardCategoryId);
			}
			$counter++;
		}
		$this->view->set(SYSTEM_INFO_MESSAGE, $counter.' items were deleted sucessfully.');
		return $this->listing($dashboardCategoryId);
	}

	public function location($buddyId){
		$this->setService('buddy');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$locations = $this->service->getAllLocationsByBuddyId($buddyId);

		if(empty($locations)){
			$locations = array();
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

		$this->setView('buddy'.DS.'location');
		$this->view->set('pgtotal', $start.' - '. $end. ' of '.$this->service->totalCount);
		$this->view->set('offset', $this->service->offset.','.$this->service->totalCount);
		$this->view->set('buddy', $buddy);
		$this->view->set('locations', $locations);
		return $this->view->output();
	}

	public function addLocation($buddyId){
		$this->setService('buddy');
		$this->setView('buddy'.DS.'addLocation');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		return $this->view->output();
	}

	public function saveLocation($buddyId){
		$this->setService('buddy');

		if(!isset($_POST['saveForm']) || empty($buddyId)){
			header('Location:'.BASEURL.DS.'dashboard'.DS.'listing');
		}
		$message;
		$name = isset($_POST['name']) ? trim($_POST['name']) : null;

		if(empty($name)){
			$message = 'Location should have a name.';
		}else{

			try{
				$newLocation = new BuddyLocation();
				$newLocation->setId(isset($_POST['id']) ? trim($_POST['id']) : null);
				$newLocation->setDateupdated(date('Y-m-d H:i:s'));
				$newLocation->setLocationName(ucwords($name));
				$newLocation->setStatus((int)$_POST['status']);
				$newLocation->setBuddy($this->service->getBuddyById($buddyId));
					
				if($newLocation->getId() != null){
					$this->service->editLocation($newLocation);
				}else{
					$this->service->saveLocation($newLocation);
				}
					
				$this->setView('buddy'.DS.'location');
				$this->view->set(SYSTEM_INFO_MESSAGE, 'buddy Saved Sucessfully');
				return $this->location($buddyId);
			} catch (CustomException $e) {
				$message = $e->getMessage();
			}
		}

		$this->setView('buddy'.DS.'addLocation');
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		$this->view->set('saveForm', $_POST);
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		return $this->view->output();

	}

	public function editLocation($id){
		if(empty($id)){
			$this->setView('dashboard'.'listing');
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id for buddy location object doesnot exist');
			return $this->view->output();
		}

		$this->setService('buddy');
		$params = explode(":", $id);
		$buddyId  = $params[1];
		$locationId = $params[0];

		$buddy = $this->service->getBuddyById($buddyId);

		if($buddy == null){
			$this->setView('dashboard'.'listing');
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id doesnot exist.');
			return $this->view->output();
		}

		$location = $this->service->getLocationById($locationId);


		$this->setView('buddy'.DS.'addLocation');
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		$this->view->set('id', $location->id);
		$this->view->set('status', $location->status);
		$this->view->set('name', $location->locationName);
		return $this->view->output();
	}

	public function deleteLocation($ids){
		$this->setView('buddy'.DS.'location');
		if(empty($ids)){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'No specified items to delete');
			return $this->location(null);
		}

		$this->setService('buddy');

		$buddyId;
		$params = explode(",", $ids);
		$counter = 0;
		foreach ($params as $paramz){
			try {
				$ids = explode(":", $paramz);
				$buddyId = $ids[1];
				$this->service->deleteLocation($ids[0]);
			} catch (CustomException $e) {
				$this->view->set(SYSTEM_ERROR_MESSAGE, $e->getMessage());
				return $this->listing($dashboardCategoryId);
			}
			$counter++;
		}
		$this->view->set(SYSTEM_INFO_MESSAGE, $counter.' items were deleted sucessfully.');
		return $this->location($buddyId);
	}

	public function searchtag($buddyId){
		$this->setService('buddy');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$searchtags = $this->service->getAllSearchtagsByBuddyId($buddyId);

		if(empty($searchtags)){
			$searchtags = array();
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

		$this->setView('buddy'.DS.'searchtag');
		$this->view->set('pgtotal', $start.' - '. $end. ' of '.$this->service->totalCount);
		$this->view->set('offset', $this->service->offset.','.$this->service->totalCount);
		$this->view->set('buddy', $buddy);
		$this->view->set('searchtags', $searchtags);
		return $this->view->output();
	}

	public function addSearchtag($buddyId){
		$this->setService('buddy');
		$this->setView('buddy'.DS.'addSearchtag');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		return $this->view->output();
	}

	public function saveSearchtag($buddyId){
		if(!isset($_POST['saveForm']) || empty($buddyId)){
			header('Location:'.BASEURL.DS.'dashboard'.DS.'listing');
		}
		$this->setService('buddy');
		$message;
		$searchtag = isset($_POST['searchtag']) ? trim($_POST['searchtag']) : null;

		if(empty($searchtag)){
			$message = 'Search tag should have a search value.';
		}else{

			try{
				$newSearchtag = new BuddySearchTag();
				$newSearchtag->setId(isset($_POST['id']) ? trim($_POST['id']) : null);
				$newSearchtag->setDateupdated(date('Y-m-d H:i:s'));
				$newSearchtag->setSearchValue(ucwords($searchtag));
				$newSearchtag->setStatus((int)$_POST['status']);
				$newSearchtag->setBuddy($this->service->getBuddyById($buddyId));
				if($newSearchtag->getId() != null){
					$this->service->editSearchtag($newSearchtag);
				}else{
					$this->service->saveSearchtag($newSearchtag);
				}
					
				$this->setView('buddy'.DS.'searchtag');
				$this->view->set(SYSTEM_INFO_MESSAGE, 'buddy Saved Sucessfully');
				return $this->searchtag($buddyId);
			} catch (CustomException $e) {
				$message = $e->getMessage();
			}
		}

		$this->setView('buddy'.DS.'addSearchtag');
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		$this->view->set('saveForm', $_POST);
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		return $this->view->output();

	}

	public function editSearchtag($id){
		if(empty($id)){
			$this->setView('dashboard'.'listing');
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id for buddy location object doesnot exist');
			return $this->view->output();
		}

		$this->setService('buddy');
		$params = explode(":", $id);
		$buddyId  = $params[1];
		$searchtagId = $params[0];

		$buddy = $this->service->getBuddyById($buddyId);

		if($buddy == null){
			$this->setView('dashboard'.'listing');
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'Supplied id doesnot exist.');
			return $this->view->output();
		}

		$searchtag = $this->service->getSearchtagById($searchtagId);

		$this->setView('buddy'.DS.'addSearchtag');
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		$this->view->set('id', $searchtag->id);
		$this->view->set('status', $searchtag->status);
		$this->view->set('searchtag', $searchtag->searchValue);
		return $this->view->output();
	}

	public function deleteSearchtag($ids){
		$this->setView('buddy'.DS.'searchtag');
		if(empty($ids)){
			$this->view->set(SYSTEM_ERROR_MESSAGE, 'No specified items to delete');
			return $this->searchtag(null);
		}

		$this->setService('buddy');

		$buddyId;
		$params = explode(",", $ids);
		$counter = 0;
		foreach ($params as $paramz){
			try {
				$ids = explode(":", $paramz);
				$buddyId = $ids[1];
				$this->service->deleteSearchtag($ids[0]);
			} catch (CustomException $e) {
				$this->view->set(SYSTEM_ERROR_MESSAGE, $e->getMessage());
				return $this->listing($dashboardCategoryId);
			}
			$counter++;
		}
		$this->view->set(SYSTEM_INFO_MESSAGE, $counter.' items were deleted sucessfully.');
		return $this->searchtag($buddyId);
	}

	public function comment($buddyId){
		//	return $this->listing($dashCategoryID);
	}

	public function image($buddyId){
		$this->setService('buddy');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		//$images = $this->service->getAllImagesByBuddyId($buddyId);

		if(empty($images)){
			$images = array();
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

		$this->view->set('pgtotal', $start.' - '. $end. ' of '.count($images));
		$this->view->set('offset', $this->service->offset.','.$this->service->totalCount);
		$this->view->set('buddy', $buddy);

		$imageName = preg_replace('/\s+/', '', strtolower($buddy->name));
		$this->view->set('imageName', $imageName);

		$imagePath = HOME . $this->service->getBuddyImage($imageName);

		if(file_exists($imagePath)){
			$this->view->set('imageurl', BASEURL . $this->service->getBuddyImage($imageName));
		}else{
			$this->view->set('imageurl', "");
		}
		return $this->view->output();
	}


	public function addImage($buddyId){
		$this->setView('buddy'.DS.'addImage');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		$this->view->set('editImageName', "");
		return $this->view->output();
	}

	public function deleteImage($buddyId){
		$buddy = $this->service->getBuddyById($buddyId);
		$imageName = preg_replace('/\s+/', '', strtolower($buddy->name));
		$imagePath = HOME . DS . "utilities". DS . "images" .DS. "uploads" .DS . $imageName . '.png';

		$this->service->deleteBuddyImage($imagePath);

		$this->setView('buddy'.DS.'image');
		$this->view->set(SYSTEM_INFO_MESSAGE, 'Image Deleted Sucessfully');
		return $this->image($buddyId);
	}

	public function editImage($data){
		$params = explode(":", $data);

		$buddyId = $params[1];
		$editImageName = $params[0];
		$this->setView('buddy'.DS.'addImage');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		$this->view->set('editImageName', $editImageName);
		return $this->view->output();
	}

	public function saveImage($buddyId){
		$this->setService('buddy');

		if(!isset($_POST['saveForm']) || empty($buddyId)){
			header('Location:'.BASEURL.DS.'dashboard'.DS.'listing');
		}
		$message;

		try {
			if((!empty($_FILES["pic_file"])) && ($_FILES['pic_file']['error'] == 0)){
				$filename = isset($_POST['name']) ? trim($_POST['name']) : "unknown";
				$ext = $_FILES["pic_file"]["type"];
				$size = $_FILES["pic_file"]["size"];

				$imageSize = getimagesize($_FILES["pic_file"]["tmp_name"]);
				$imageWidth = $imageSize[0];
				$imageHeight = $imageSize[1];

				$filename .= ".png";
				if($ext == "image/png" && $imageWidth <= 54 && $imageHeight <= 54 && $size <= 53289){
					$imagePath = HOME . DS . "utilities". DS . "images" .DS. "uploads" .DS . $filename;

					if($_POST['editImageName'] != ""){
						$existingImagePath = HOME . DS . "utilities". DS . "images" .DS. "uploads" .DS . $_POST['editImageName'].".png";

						if(file_exists($existingImagePath)){
							$this->service->deleteBuddyImage($imagePath);
							$this->service->saveBuddyImage($_FILES["pic_file"]['tmp_name'], $imagePath);
						}
					}else{
						if(!file_exists($imagePath)){
							$this->service->saveBuddyImage($_FILES["pic_file"]['tmp_name'], $imagePath);
						}
					}

					$this->setView('buddy'.DS.'image');
					$this->view->set(SYSTEM_INFO_MESSAGE, 'Image Saved Sucessfully');
					return $this->image($buddyId);
				}
			}

			$message = "Invalid file submitted. Image should be 54 * 54 and size  < 100000";

		} catch (Exception $e) {
			$message = $e->getMessage();
		}


		$this->setView('buddy'.DS.'addImage');
		$this->view->set(SYSTEM_ERROR_MESSAGE, $message);
		$this->setService('buddy');
		$buddy = $this->service->getBuddyById($buddyId);
		$buddy->setDashboardCategory($this->getDashboardCategory($this->service->getDashboardCategoryIdByBuddyId($buddyId)));
		$this->view->set('buddy', $buddy);
		$this->view->set('editImageName', $_POST['editImageName']);
		return $this->view->output();
	}
	
	public function smallImage($imageName){
		ob_start();
		$fileName = HOME . $this->service->getBuddyImage($imageName);
		$resizeImage = new ResizeImage($fileName);
		$newImage  = $resizeImage->getSmall();
		imagepng($newImage);
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
	}
}
?>