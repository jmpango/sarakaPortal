<?php
include_once HOME . DS . 'model' . DS . 'role.php';
include_once HOME . DS . 'services' . DS . 'permissionservice.php';

class RoleService extends BaseDAO{
	public function getRolesByUserId($userId){
		$roles = array();
		$sql = "SELECT t2.id, t2.description, t2.role_name, t2.date_last_updated FROM role_user as t1 JOIN roles as t2 ON t1.role_id = t2.id where t1.user_id = :userID";
		$stmt = $this->db->prepare ($sql);
			$stmt->bindValue('userID', $userId, PDO::PARAM_STR);
			$stmt->execute();
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$role = new Role();
				$role->id = $row['id'];
				$role->dateupdated = $row['date_last_updated'];
				$role->description = $row['description'];
				$role->name = $row['role_name'];
				$permissionService  = new PermissionService();
				$role->permissions = $permissionService->getPermissionsByRoleID($role->getId());
				array_push($roles, $role);
			}
			return $roles;
	}
}
?>