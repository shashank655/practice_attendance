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

    function getSubjectInfo($id) {
        $fetch = "SELECT * FROM `subjects` where id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteSubjects($sId) {
        $qry = "DELETE FROM `subjects` WHERE id = '{$sId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function subjectInfoUpdate($data) {
        $qry = "UPDATE `subjects` SET
              `subject_name` = '{$data['subject_name']}'
               WHERE id = '{$data['subjectId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>