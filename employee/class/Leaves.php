<?php
class Leaves extends MySQLCN {

    function addLeaveTypes($data) {
        $qry = 'INSERT INTO `leave_types` 
            (`leave_type`) 
            VALUES ( "'. $data['leave_type'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getLeavesLists() {
        $fetch = "SELECT * FROM `leave_types`";
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