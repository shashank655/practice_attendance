<?php
class Sections extends MySQLCN {

    function getSectionsLists() {
        $fetch = "SELECT * FROM `sections`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

}
?>