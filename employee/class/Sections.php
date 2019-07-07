<?php
class Sections extends MySQLCN {

    function getSectionsLists() {
        $fetch = "SELECT `sections`.`id`, `sections`.`class_id`, `sections`.`section_name`, `sections`.`createdDate`, `classes_name`.`class_name` FROM `sections` LEFT JOIN classes_name ON classes_name.id=sections.class_id";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

}
?>