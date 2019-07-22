<?php
class Sections extends MySQLCN {

    function getSectionsLists() {
        $fetch = "SELECT `sections`.`id`, `sections`.`class_id`, `sections`.`section_name`, `sections`.`createdDate`, `classes_name`.`class_name` FROM `sections` LEFT JOIN classes_name ON classes_name.id=sections.class_id";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getSections() {
        $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
        $fetch = "SELECT `sections`.`id`, `sections`.`class_id`, `sections`.`section_name`, `sections`.`createdDate`, `classes_name`.`class_name` FROM `sections` LEFT JOIN classes_name ON classes_name.id=sections.class_id WHERE `sections`.`class_id`='".$class_id."'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function  getSectionInfo($id) {
        $fetch = "SELECT * FROM `sections` WHERE `sections`.`id`={$id}";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getSectionsByClass($class_id) {
        $fetch = "SELECT * FROM `sections` WHERE `sections`.`class_id`={$class_id}";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }
}
?>