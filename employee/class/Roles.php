<?php
class Roles extends MySQLCN {

    function addRoles($data) {
        $qry = 'INSERT INTO `roles` 
            (`role`) 
            VALUES ( "'. $data['role'] . '")';
        $res = $this->insert($qry);
        $last_id = mysqli_insert_id($this->CONN);
        foreach ( $data['permissions'] as $permission ) {
            $qry4 = 'INSERT INTO `role_permission` (`permission_id`, `role_id`) VALUES ( "'. $permission . '", "'. $last_id . '")';
            $res4 = $this->insert($qry4);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getRolesLists() {
        $fetch = "SELECT * FROM `roles`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getRoleInfo($id) {
        $fetch = "SELECT * FROM `roles` where roles.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteRoles($eId) {
        $qry = "DELETE FROM `roles` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        $qry2 = "DELETE FROM `role_permission` WHERE `role_id` = '{$roleId}'";
        $res2 = $this->deleteData($qry2);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function roleInfoUpdate($data) {
        $roleId = $data['roleId'];
        $qry2 = "DELETE FROM `role_permission` WHERE `role_id` = '{$roleId}'";
        $res2 = $this->deleteData($qry2);
        
        $qry = "UPDATE `roles` SET
              `role` = '{$data['role']}'
               WHERE id = '{$roleId}'";
        $res = $this->updateData($qry);

        foreach ( $data['permissions'] as $permission ) {
            $qry4 = 'INSERT INTO `role_permission` (`permission_id`, `role_id`) VALUES ( "'. $permission . '", "'. $roleId . '")';
            $res4 = $this->insert($qry4);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>