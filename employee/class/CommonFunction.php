<?php

class CommonFunction extends MySQLCN {

    function getAllSubjects() {
        $fetch = "SELECT * FROM `subjects` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }

    function getAllClassesName() {
        $fetch = "SELECT * FROM `classes_name` ";
        $fetch_classes = $this->select($fetch);
        return $fetch_classes;
    }

    function getSectionList($classId) {
        $fetchSection = "SELECT * FROM `sections` where class_id='{$classId}' order by `section_name` asc";
        $fetch_section = $this->select($fetchSection);
        return $fetch_section;
    }

    function getCountStudent() {
        $fetch = "SELECT count(*) FROM `students` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }

    function getCountTeacher() {
        $fetch = "SELECT count(*) FROM `teachers` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }
}    