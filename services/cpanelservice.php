<?php
include_once HOME . DS . 'model' . DS . 'exception' . DS . 'customexception.php';

class CpanelService extends BaseDAO{


	public  function getSeedings(){
		try {
			$sql = "SELECT * FROM seeding d ORDER BY d.name";
			$stmt = $this->db->prepare ($sql);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildSeedingData($results);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getALLSeedings(){
		try {

			if($this->totalCount == 0){
				$sql = "SELECT * FROM seeding";
				$stmt = $this->db->prepare ($sql);
				$stmt->execute();
				$results =  $stmt->rowCount();
				$this->totalCount = $results;
			}

			$sql = "SELECT * FROM seeding d ORDER BY d.name ASC Limit ".$this->offset.", ".$this->maxLimit;
			$stmt = $this->db->prepare ($sql);
			$stmt->execute();
			$results =  $stmt->fetchAll();
			if(!empty($results)){
				return $this->buildSeedingData($results);
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function buildSeedingData($results){
		$seedings = array();
		foreach ($results as $result){
			$seeding = new Seeding();
			$seeding->id = $result['id'];
			$seeding->name = $result['name'];
			$seeding->description = $result['description'];
			array_push($seedings, $seeding);
		}
		return $seedings;
	}

	public function editseeding($seeding){
		try {
			$sql = "UPDATE seeding set name=:name, description=:description WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $seeding->id);
			$stmt->bindValue('name', strtoupper($seeding->name));
			$stmt->bindValue('description', $seeding->description);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function saveseeding($seeding){
		try{
			$sql = "INSERT INTO seeding(name, description) VALUES(:name, :description)";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue("name", strtoupper($seeding->name), PDO::PARAM_STR );
			$stmt->bindValue("description", $seeding->description, PDO::PARAM_STR );
			$stmt->execute();
			return true;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function deleteseeding($id){
		try{
			$sql = "DELETE FROM seeding WHERE id=:id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $id);
			return $stmt->execute();
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}

	public function getSeedingById($id){
		try {
			$sql = "SELECT * FROM seeding d WHERE d.id = :id";
			$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('id', $id);
			$stmt->execute();
			$result =  $stmt->fetch();
			if(!empty($result)){
				$seeding = new Seeding();
				$seeding->id = $result['id'];
				$seeding->name = $result['name'];
				$seeding->description = $result['description'];
				return $seeding;
			}
			return null;
		}catch (PDOException $e){
			throw new CustomException($e->getMessage());
		}
	}
}
?>