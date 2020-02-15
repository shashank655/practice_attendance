<?php
class UserPermission extends MySQLCN
{

    function getUserPermissionInfo($id)
    {
        $fetch = "SELECT * FROM `user_permission` where user_permission.user_id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    public function getAllPermisson()
    {
        $fetch_data = $this->select("SELECT permission FROM permissions");
        return array_map(function ($row) {
            return $row['permission'];
        }, $fetch_data);
    }

    public function getUserAllPermisson()
    {
        $fetch_data = $this->select(
            "SELECT permission FROM permissions WHERE EXISTS(
                    SELECT 1 FROM user_permission WHERE user_permission.permission_id = permissions.id AND user_permission.user_id = '{$_SESSION['userId']}'
                ) OR EXISTS(
                    SELECT 1 FROM role_permission WHERE role_permission.permission_id = permissions.id AND EXISTS(
                    SELECT 1 FROM user_role WHERE user_role.role_id = role_permission.role_id AND user_role.user_id = '{$_SESSION['userId']}'
                )
            )"
        );
        return array_map(function ($row) {
            return $row['permission'];
        }, $fetch_data);
    }
}
