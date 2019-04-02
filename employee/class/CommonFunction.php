<?php

class CommonFunction extends MySQLCN {

    function getAllSubjects() {
        $fetch = "SELECT * FROM `subjects` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }
}    