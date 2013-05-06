<?php
include_once HOME . DS . 'model' . DS . 'buddy.php';
include_once HOME . DS . 'model' . DS . 'dashboard.php';
include_once HOME . DS . 'model' . DS . 'dashboardcategory.php';
include_once HOME . DS . 'model' . DS . 'exception' . DS . 'customexception.php';
include_once HOME . DS . 'services' . DS . 'dashcategoryservice.php';
include_once HOME . DS . 'services' . DS . 'buddyservice.php';

class DashboardService extends BaseDAO{

	public function getAllDashboardsPaging(){
		try {

			if($this->totalCount == 0){
				$sql = "SELECT * FROM dashboard";
				$stmt = $this->db->prepare ($sql);
				$stmt->execute();
				$results =  $stmt->rowCount();
				$this->totalCount = $results;
			}

			$sql = "SELECT * FROM dashboard d ORDER BY d.dname ASC Limit ".$this->offset.", ".$this->maxLimit;
			$stmt = $this->db->prepare ($sql);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildDashboardData($results);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getAllDashboards(){
		try {
			$sql = "SELECT * FROM dashboard d ORDER BY d.dname ASC";
			$stmt = $this->db->prepare ($sql);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildDashboardData($results);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function save($newDashBoard){
		try{
			$sql = "INSERT INTO dashboard(date_last_updated, dname, tagline, record_status) VALUES(:datelastupdated, :name, :tagline, :status)";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("datelastupdated", $newDashBoard->dateupdated, PDO::PARAM_STR );
			$stmt->bindValue("name", $newDashBoard->name, PDO::PARAM_STR );
			$stmt->bindValue("tagline", $newDashBoard->tagline, PDO::PARAM_STR );
			$stmt->bindValue("status", $newDashBoard->status, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function buildDashboardData($results){
		$dashboards = array();
		foreach ($results as $result){
			$dashboard = new Dashboard();
			$dashboard->id = $result['id'];
			$dashboard->dateupdated = $result['date_last_updated'];
			$dashboard->name = $result['dname'];
			$dashboard->tagline = $result['tagline'];
			$dashboard->status = $result['record_status'];
			array_push($dashboards, $dashboard);
		}
		return $dashboards;
	}

	public function search($name, $status){
		try {
			$query;
			if($status == ""){
				$query = "";
			}else {
				$query = "AND d.record_status=:status ";
			}
				
			$sql = "SELECT * FROM dashboard d WHERE d.dname LIKE :query ". $query. "ORDER BY d.dname ASC";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('query', $name.'%');
				
			if($status != ""){
				$stmt->bindValue('status', (int)$status);
			}
				
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildDashboardData($results);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getDashboardById($id){
		try {
			$sql = "SELECT * FROM dashboard d WHERE d.id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $id);
			$stmt->execute();
			$result =  $stmt->fetch();
			if(!empty($result)){
				$dashboard = new Dashboard();
				$dashboard->id = $result['id'];
				$dashboard->dateupdated = $result['date_last_updated'];
				$dashboard->name = $result['dname'];
				$dashboard->tagline = $result['tagline'];
				$dashboard->status = $result['record_status'];
				return $dashboard;
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function edit($dashboard){
		try {
			$sql = "UPDATE dashboard set dname=:name, tagline=:tagline, date_last_updated=:dateupdated, record_status=:status WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $dashboard->id);
			$stmt->bindValue('name', $dashboard->name);
			$stmt->bindValue('tagline', $dashboard->tagline);
			$stmt->bindValue('dateupdated', $dashboard->dateupdated);
			$stmt->bindValue('status', $dashboard->status);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function delete($id){
		try {
			$dashCategoryService = new DashcategoryService();
			$dashCategories = $dashCategoryService->getAllDashboardCategoriesByDashboardId($id);
			if($dashCategories != null){
				foreach ($dashCategories as $dashCategory){
					$dashCategoryService->delete($dashCategory->id);
				}
			}

			$sql = "DELETE FROM dashboard WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $id);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function dashboardExist($name){
		$sql = "SELECT * FROM dashboard d WHERE d.dname = :name ";
		$stmt = $this->db->prepare ($sql);
		$stmt->bindValue('name', $name);
		$stmt->execute();
		$result =  $stmt->fetch();
		if(!empty($result)){
			return true;
		}
		return false;
	}

	public function getAllBuddies(){
		try {

			if($this->totalCount == 0){
				$sql = "SELECT * FROM buddy";
				$stmt = $this->db->prepare ($sql);
				$stmt->execute();
				$results =  $stmt->rowCount();
				$this->totalCount = $results;
			}

			$sql = "SELECT * FROM buddy d ORDER BY d.name ASC Limit ".$this->offset.", ".$this->maxLimit;
			$stmt = $this->db->prepare ($sql);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				$buddies = array();
				foreach ($results as $result){
					$buddy = new Buddy();
					$buddy->id = $result['id'];
					$buddy->dateupdated = $result['date_last_updated'];
					$buddy->name = $result['name'];
					$buddy->status = $result['record_status'];
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
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function buddysearch($searchParm){
		$buddyService = new BuddyService();
		return $buddyService->buddysearch($searchParm);
	}
}
?>