<?php
include_once HOME . DS . 'model' . DS . 'buddy.php';
include_once HOME . DS . 'model' . DS . 'buddysearchparameter.php';
include_once HOME . DS . 'model' . DS . 'buddylocation.php';
include_once HOME . DS . 'model' . DS . 'buddysearchtag.php';
include_once HOME . DS . 'model' . DS . 'exception' . DS . 'customexception.php';
include_once HOME . DS . 'services' . DS . 'dashcategoryservice.php';

class BuddyService extends BaseDAO{

	public function getAllBuddiesByDashboardCategoryIdPaging($dashboardCategoryId){
		try {

			if($this->totalCount == 0){
				$sql = "SELECT * FROM buddy d WHERE dashboard_category_id = :dashboardCategoryId";
				$stmt = $this->db->prepare ($sql);
				$stmt->bindValue('dashboardCategoryId', $dashboardCategoryId);
				$stmt->execute();
				$results =  $stmt->rowCount();
				$this->totalCount = $results;
			}

			$sql = "SELECT * FROM buddy d WHERE dashboard_category_id = :dashboardCategoryId ORDER BY d.name ASC Limit ".$this->offset.", ".$this->maxLimit;
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('dashboardCategoryId', $dashboardCategoryId);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllBuddyData($results, $dashboardCategoryId);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}
	public function getAllBuddiesByDashboardCategoryId($dashboardCategoryId){
		try {

			$sql = "SELECT * FROM buddy d WHERE dashboard_category_id = :dashboardCategoryId";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('dashboardCategoryId', $dashboardCategoryId);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllBuddyData($results, $dashboardCategoryId);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}
	public function buildAllBuddyData($results, $dashboardCategoryId){
		$buddies = array();
		foreach ($results as $result){
			$buddy = new Buddy();
			$buddy->id = $result['id'];
			$buddy->dateupdated = $result['date_last_updated'];
			$buddy->status = $result['record_status'];
			$buddy->name = $result['name'];
			$buddy->tagline = $result['tagline'];
			$buddy->address = $result['address'];
			$buddy->telphoneNos = $result['telphone'];
			$buddy->email = $result['email'];
			$buddy->fax = $result['fax'];
			$buddy->url = $result['url'];
			$dashboardCategoryService = new DashcategoryService();
			$buddy->setDashboardCategory($dashboardCategoryService->getDashboardCategoryById($result['dashboard_category_id']));
			array_push($buddies, $buddy);
		}
		return $buddies;
	}

	public function save($newbuddy){
		try{
			$sql = "INSERT INTO buddy(date_last_updated, record_status, name, tagline, address, telphone, email, fax, url, dashboard_category_id) VALUES(:datelastupdated, :status, :name, :tagline, :address, :telphone, :email, :fax, :url, :dasboardcategoryid)";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $newbuddy->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("status", (int)$newbuddy->status, PDO::PARAM_STR );
			$stmt->bindValue("name", $newbuddy->name, PDO::PARAM_STR );
			$stmt->bindValue("tagline", $newbuddy->tagline, PDO::PARAM_STR );
			$stmt->bindValue("address", $newbuddy->address, PDO::PARAM_STR );
			$stmt->bindValue("telphone", $newbuddy->telphoneNos, PDO::PARAM_STR );
			$stmt->bindValue("email", $newbuddy->email, PDO::PARAM_STR );
			$stmt->bindValue("fax", $newbuddy->fax, PDO::PARAM_STR );
			$stmt->bindValue("url", $newbuddy->url, PDO::PARAM_STR );
			$stmt->bindValue("dasboardcategoryid", $newbuddy->getDashboardCategory()->id, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getBuddyById($buddyId){
		try {
			$sql = "SELECT * FROM buddy d WHERE d.id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $buddyId);
			$stmt->execute();
			$result =  $stmt->fetch();
			if(!empty($result)){
				$buddy = new Buddy();
				$buddy->id = $result['id'];
				$buddy->dateupdated = $result['date_last_updated'];
				$buddy->status = $result['record_status'];
				$buddy->name = $result['name'];
				$buddy->tagline = $result['tagline'];
				$buddy->address = $result['address'];
				$buddy->telphoneNos = $result['telphone'];
				$buddy->email = $result['email'];
				$buddy->fax = $result['fax'];
				$buddy->url = $result['url'];
				return $buddy;
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function edit($newbuddy){
		try {
			$sql = "UPDATE buddy set date_last_updated=:datelastupdated, record_status=:status, name=:name, tagline=:tagline, address=:address, telphone=:telphone, email=:email, fax=:fax, url=:url WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $newbuddy->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("status", (int)$newbuddy->status, PDO::PARAM_STR );
			$stmt->bindValue("name", $newbuddy->name, PDO::PARAM_STR );
			$stmt->bindValue("tagline", $newbuddy->tagline, PDO::PARAM_STR );
			$stmt->bindValue("address", $newbuddy->address, PDO::PARAM_STR );
			$stmt->bindValue("telphone", $newbuddy->telphoneNos, PDO::PARAM_STR );
			$stmt->bindValue("email", $newbuddy->email, PDO::PARAM_STR );
			$stmt->bindValue("fax", $newbuddy->fax, PDO::PARAM_STR );
			$stmt->bindValue("url", $newbuddy->url, PDO::PARAM_STR );
			$stmt->bindValue("id", $newbuddy->id, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function delete($id){
		try {
			$searchtags = $this->getAllSearchtagsByBuddyId($id);
			if($searchtags != null){
				foreach ($searchtags as $searchtag){
					$this->deleteSearchtag($searchtag->id);
				}
			}

			$locations = $this->getAllLocationsByBuddyId($id);
			if($locations != null){
				foreach ($locations as $location){
					$this->deleteLocation($location->id);
				}
			}

			//Rating

			//comment

			$sql = "DELETE FROM buddy WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $id);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getDashboardCategoryIdByBuddyId($buddyId){
		try {
			$sql = "SELECT * FROM buddy d WHERE d.id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $buddyId);
			$stmt->execute();
			$result =  $stmt->fetch();
			return $result['dashboard_category_id'];
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getAllLocationsByBuddyId($buddyId){

		if($this->totalCount == 0){
			$sql = "SELECT * FROM buddy_locations d WHERE d.buddy_id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $buddyId);
			$stmt->execute();
			$results =  $stmt->rowCount();
			$this->totalCount = $results;
		}
		try {
			$sql = "SELECT * FROM buddy_locations d WHERE d.buddy_id = :id ORDER BY d.location_name ASC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $buddyId);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllLocationData($results);
			}
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function buildAllLocationData($results){
		$locations = array();
		foreach ($results as $result){
			$location = new BuddyLocation();
			$location->id = $result['id'];
			$location->dateupdated = $result['date_last_updated'];
			$location->status = $result['record_status'];
			$location->locationName = $result['location_name'];

			array_push($locations, $location);
		}
		return $locations;
	}

	public function saveLocation($newLocation){
		try{
			$sql = "INSERT INTO buddy_locations(date_last_updated, record_status, location_name, buddy_id) VALUES(:datelastupdated, :status, :name, :buddyid)";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $newLocation->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("status", (int)$newLocation->status, PDO::PARAM_STR );
			$stmt->bindValue("name", $newLocation->locationName, PDO::PARAM_STR );
			$stmt->bindValue("buddyid", $newLocation->getBuddy()->id, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getLocationById($locationId){
		try {
			$sql = "SELECT * FROM buddy_locations d WHERE d.id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $locationId);
			$stmt->execute();
			$result =  $stmt->fetch();
			if(!empty($result)){
				$location = new BuddyLocation();
				$location->id = $result['id'];
				$location->dateupdated = $result['date_last_updated'];
				$location->status = $result['record_status'];
				$location->locationName = $result['location_name'];
				return $location;
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function editLocation($location){
		try {
			$sql = "UPDATE buddy_locations set date_last_updated=:datelastupdated, record_status=:status, location_name=:name WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $location->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("status", (int)$location->status, PDO::PARAM_STR );
			$stmt->bindValue("name", $location->locationName, PDO::PARAM_STR );
			$stmt->bindValue("id", $location->id, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function deleteLocation($locationID){
		try {
			$sql = "DELETE FROM buddy_locations WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $locationID);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getAllSearchtagsByBuddyId($buddyId){

		if($this->totalCount == 0){
			$sql = "SELECT * FROM buddy_search_tags d WHERE d.buddy_id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $buddyId);
			$stmt->execute();
			$results =  $stmt->rowCount();
			$this->totalCount = $results;
		}
		try {
			$sql = "SELECT * FROM buddy_search_tags d WHERE d.buddy_id = :id ORDER BY d.search_value ASC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $buddyId);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllSearchtagData($results);
			}
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function buildAllSearchtagData($results){
		$searchtags = array();
		foreach ($results as $result){
			$searchtag = new BuddySearchTag();
			$searchtag->id = $result['id'];
			$searchtag->dateupdated = $result['date_last_updated'];
			$searchtag->status = $result['record_status'];
			$searchtag->searchValue = $result['search_value'];
			array_push($searchtags, $searchtag);
		}
		return $searchtags;
	}

	public function saveSearchtag($newSearchtag){
		try{
			$sql = "INSERT INTO buddy_search_tags(date_last_updated, record_status, search_value, buddy_id) VALUES(:datelastupdated, :status, :searchValue, :buddyid)";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $newSearchtag->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("status", (int)$newSearchtag->status, PDO::PARAM_STR );
			$stmt->bindValue("searchValue", $newSearchtag->searchValue, PDO::PARAM_STR );
			$stmt->bindValue("buddyid", $newSearchtag->getBuddy()->id, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getSearchtagById($searchtagId){
		try {
			$sql = "SELECT * FROM buddy_search_tags d WHERE d.id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $searchtagId);
			$stmt->execute();
			$result =  $stmt->fetch();
			if(!empty($result)){
				$searchtag = new BuddySearchTag();
				$searchtag->id = $result['id'];
				$searchtag->dateupdated = $result['date_last_updated'];
				$searchtag->status = $result['record_status'];
				$searchtag->searchValue = $result['search_value'];
				return $searchtag;
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function editSearchtag($searchtag){
		try {
			$sql = "UPDATE buddy_search_tags set date_last_updated=:datelastupdated, record_status=:status, search_value=:value WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $searchtag->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("status", (int)$searchtag->status, PDO::PARAM_STR );
			$stmt->bindValue("value", $searchtag->searchValue, PDO::PARAM_STR );
			$stmt->bindValue("id", $searchtag->id, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function deleteSearchtag($searchtagID){
		try {
			$sql = "DELETE FROM buddy_search_tags WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $searchtagID);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function buddysearch($searchParm){
		try {
			$query = "";
			if($searchParm->status != ''){
				$query = $query."AND b.record_status=:status ";
			}

			if($searchParm->owner != ''){
				$query = $query."AND b.dashboard_category_id=:dcategoryId ";
			}

			$sql = "SELECT * FROM buddy b WHERE b.name LIKE :name ".$query."ORDER BY b.name ASC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('name', ucfirst($searchParm->name).'%');
			if($searchParm->status != ''){
				$stmt->bindValue('status', (int)$searchParm->status);
			}
			if($searchParm->owner != ''){
				$stmt->bindValue('dcategoryId', (int)$searchParm->owner);
			}
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllBuddyData($results, null);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getBuddyImage($imageName){
		return  DS . "utilities". DS . "images" .DS. "uploads" .DS . $imageName . '.png';
	}

	public function saveBuddyImage($file, $imagePath){
		return move_uploaded_file($file, $imagePath);
	}

	public function deleteBuddyImage($imagePath){
		unlink($imagePath);
	}

}
?>