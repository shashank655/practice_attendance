<?php
class UserPermission extends MySQLCN {

    function getUserPermissionInfo($id) {
        $fetch = "SELECT * FROM `user_permission` where user_permission.user_id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

}
?>