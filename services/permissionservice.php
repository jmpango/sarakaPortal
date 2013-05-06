<?php
include_once HOME . DS . 'model' . DS . 'permission.php';

class PermissionService extends BaseDAO{
	public function getPermissionsByRoleID($roleId){
		$permissions = array();
		$sql = "SELECT t2.id, t2.description, t2.permission_name, t2.date_last_updated FROM role_permission as t1 JOIN permissions as t2 ON t1.perm_id = t2.id where t1.role_id = :roleID";
		$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('roleID', $roleId, PDO::PARAM_STR);
			$stmt->execute();
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$permission = new Permission();
				$permission->id = $row['id'];
				$permission->dateupdated = $row['date_last_updated'];
				$permission->description = $row['description'];
				$permission->name = $row['permission_name'];
				array_push($permissions, $permission);
			}
			return $permissions;
	}
}
?>