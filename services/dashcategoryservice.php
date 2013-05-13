<?php
include_once HOME . DS . 'model' . DS . 'dashboardcategory.php';
include_once HOME . DS . 'model' . DS . 'exception' . DS . 'customexception.php';
include_once HOME . DS . 'services' . DS . 'dashboardservice.php';
include_once HOME . DS . 'services' . DS . 'buddyservice.php';
class DashcategoryService extends BaseDAO{

	public function getDashboardCategories($dashboardId){
		try {

			if($this->totalCount == 0){
				$sql = "SELECT * FROM dashboardcategory";
				$stmt = $this->db->prepare ($sql);
				$stmt->execute();
				$results =  $stmt->rowCount();
				$this->totalCount = $results;
			}

			$sql = "SELECT * FROM dashboardcategory d WHERE dashboard_id = :dashboardId ORDER BY d.cname ASC Limit ".$this->offset.", ".$this->maxLimit;
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('dashboardId', $dashboardId);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllDashCategoryData($results, $dashboardId);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getAllDashboardCategories(){
		try {
			$sql = "SELECT * FROM dashboardcategory d ORDER BY d.cname ASC";
			$stmt = $this->db->prepare ($sql);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllDashCategoryData($results, null);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function buildAllDashCategoryData($results, $dashboardId){
		$dcategories = array();
		foreach ($results as $result){
			$dcategory = new DashboardCategory();
			$dcategory->id = $result['id'];
			$dcategory->dateupdated = $result['date_last_updated'];
			$dcategory->name = $result['cname'];
			$dcategory->status = $result['record_status'];
			if($dashboardId != null){
			 $dashboardService = new DashboardService();
			 $dcategory->dashboard = $dashboardService->getDashboardById($dashboardId);
			}
			array_push($dcategories, $dcategory);
		}
		return $dcategories;
	}

	public function save($newCategory){
		try{
			$sql = "INSERT INTO dashboardcategory(date_last_updated, cname, dashboard_id, record_status) VALUES(:datelastupdated, :name, :dashboardId, :status)";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $newCategory->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("name", $newCategory->name, PDO::PARAM_STR );
			$stmt->bindValue("dashboardId", $newCategory->dashboard->id, PDO::PARAM_STR );
			$stmt->bindValue("status", $newCategory->status, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getDashboardCategoryById($dCategoryId){
		try {
			$sql = "SELECT * FROM dashboardcategory d WHERE d.id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $dCategoryId);
			$stmt->execute();
			$result =  $stmt->fetch();
			if(!empty($result)){
				$dcategory = new DashboardCategory();
				$dcategory->id = $result['id'];
				$dcategory->dateupdated = $result['date_last_updated'];
				$dcategory->name = $result['cname'];
				$dcategory->status = $result['record_status'];
				return $dcategory;
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function edit($dashboardCategory){
		try {
			$sql = "UPDATE dashboardcategory set cname=:name, date_last_updated=:dateupdated, record_status=:status WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $dashboardCategory->id);
			$stmt->bindValue('name', $dashboardCategory->name);
			$stmt->bindValue('dateupdated', $dashboardCategory->dateupdated);
			$stmt->bindValue('status', $dashboardCategory->status);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}
	public function search($name, $dashboardId, $status){
		try {
			$query;
			if($status == ""){
				$query = "";
			}else {
				$query = "AND d.record_status=:status ";
			}

			$sql = "SELECT * FROM dashboardcategory d WHERE d.cname LIKE :query AND d.dashboard_id =:dashboardid ".$query."ORDER BY d.cname ASC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('query', $name.'%');
			$stmt->bindValue('dashboardid', $dashboardId);
			if($status != ""){
				$stmt->bindValue('status', (int)$status);
			}
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildAllDashCategoryData($results, $dashboardId);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function delete($id){
		try {
			$buddyService = new BuddyService();
			$buddies = $buddyService->getAllBuddiesByDashboardCategoryId($id);
			if($buddies != null){
				foreach ($buddies as $buddy){
					$buddyService->delete($buddy->id);
				}
			}

			$sql = "DELETE FROM dashboardcategory WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $id);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getAllDashboardCategoriesByDashboardId($dashboardId){
		$sql = "SELECT * FROM dashboardcategory d WHERE dashboard_id = :dashboardId";
		$stmt = $this->db->prepare ($sql);
		$stmt->bindValue('dashboardId', $dashboardId);
		$stmt->execute();
		$results =  $stmt->fetchAll();
		if(!empty($results)){
			return $this->buildAllDashCategoryData($results, $dashboardId);
		}
		return null;
	}

	public function getDashboardIdByCategoryById($dCategoryId){
		$sql = "SELECT d.dashboard_id FROM dashboardcategory d WHERE d.id = :dcategoryId";
		$stmt = $this->db->prepare ($sql);
		$stmt->bindValue('dcategoryId', $dCategoryId);
		$stmt->execute();
		$result = $stmt->fetch();
		return $result['dashboard_id'];
	}

	public function dashboardCategoryExist($name){
		$sql = "SELECT * FROM dashboardcategory d WHERE cname = :name";
		$stmt = $this->db->prepare ($sql);
		$stmt->bindValue('name', $name);
		$stmt->execute();
		$result =  $stmt->fetch();
		if(!empty($result)){
			return true;
		}
		return false;
	}
}
?>