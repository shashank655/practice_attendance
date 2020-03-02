<?php
class Permissions extends MySQLCN {

    function getPermissionsLists() {
        $fetch = "SELECT * FROM `permissions`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

}
?>