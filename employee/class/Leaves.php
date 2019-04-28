<?php
class Leaves extends MySQLCN {

    function addLeaveTypes($data) {
        $qry = 'INSERT INTO `leave_types` 
            (`leave_type`,`days`) 
            VALUES ( "'. $data['leave_type'] . '" , "'. $data['days'] . '")';
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

    function getLeaveTypeInfo($id) {
        $fetch = "SELECT * FROM `leave_types` where id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    } 

    function leaveInfoUpdate($data) {
        $qry = "UPDATE `leave_types` SET
              `leave_type` = '{$data['leave_type']}',
              `days` = '{$data['days']}'
               WHERE id = '{$data['leaveId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function deleteLeaves($lId) {
        $qry = "DELETE FROM `leave_types` WHERE id = '{$lId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }    
}
?>