<?php
class UserRole extends MySQLCN {

    function getUserRoleInfo($id) {
        $fetch = "SELECT * FROM `user_role` where user_role.user_id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

}
?>