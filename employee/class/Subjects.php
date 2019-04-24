<?php
class Subjects extends MySQLCN {

    function addSubjects($data) {
        $qry = 'INSERT INTO `subjects` 
            (`subject_name`) 
            VALUES ( "'. $data['subject_name'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getSubjectLists() {
        $fetch = "SELECT * FROM `subjects`";
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