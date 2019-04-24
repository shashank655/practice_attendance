<?php
class ClassSections extends MySQLCN {

    function addClasses($data) {
        $qry = 'INSERT INTO `classes_name` 
            (`class_name`) 
            VALUES ( "'. $data['className'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            if(!empty($data['addSection'])){
                foreach ($data['addSection'] as $key => $value) {
                    $qry2 = 'INSERT INTO `sections` 
                        (`class_id`,`section_name`) 
                    VALUES ("'. $res . '", "'. $value . '")';
                    $res2 = $this->insert($qry2);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function getClassesLists() {
        $fetch = "SELECT * FROM `classes_name` ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function DeleteStudent($sId) {
        $qry = "DELETE FROM `students` WHERE id = '{$sId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }    
}
?>