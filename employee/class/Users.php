<?php
class Users extends MySQLCN {

    function getUsersLists() {
        $fetch = "SELECT * FROM `users`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getUserInfo($id) {
        $fetch = "SELECT * FROM `users` where users.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function userInfoUpdate($data) {
        $userId = $data['userId'];
        $qry = "DELETE FROM `user_role` WHERE `user_id` = '{$userId}'";
        $res = $this->deleteData($qry);
        $qry2 = "DELETE FROM `user_permission` WHERE `user_id` = '{$userId}'";
        $res2 = $this->deleteData($qry2);
        foreach ( $data['roles'] as $role ) {
            $qry1 = 'INSERT INTO `user_role` (`role_id`, `user_id`) VALUES ( "'. $role . '", "'. $userId . '")';
            $res1 = $this->insert($qry1);
        }
        
        foreach ( $data['permissions'] as $permission ) {
            $qry4 = 'INSERT INTO `user_permission` (`permission_id`, `user_id`) VALUES ( "'. $permission . '", "'. $userId . '")';
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