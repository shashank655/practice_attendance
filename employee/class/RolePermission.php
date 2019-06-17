<?php
class RolePermission extends MySQLCN {

    function getRolePermissionInfo($id) {
        $fetch = "SELECT * FROM `role_permission` where role_permission.role_id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

}
?>