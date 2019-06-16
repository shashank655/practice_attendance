<?php
class Roles extends MySQLCN {

    function addRoles($data) {
        $qry = 'INSERT INTO `roles` 
            (`role`) 
            VALUES ( "'. $data['role'] . '")';
        $res = $this->insert($qry);
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
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function roleInfoUpdate($data) {
        $qry = "UPDATE `roles` SET
              `role` = '{$data['role']}'
               WHERE id = '{$data['roleId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>