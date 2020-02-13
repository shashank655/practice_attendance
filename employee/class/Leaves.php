<?php
class Leaves extends MySQLCN {

    function addLeaveTypes($data) {
        $qry = 'INSERT INTO `leave_types` 
            (`leave_type`,`days`,`paid_type`) 
            VALUES ( "'. $data['leave_type'] . '" , "'. $data['days'] . '" , "'. $data['paid_type'] . '")';
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

    function getLeavesRequestsLists() {
        $fetch = "SELECT * FROM `leaves_request` join users on leaves_request.userId=users.id join leave_types on leaves_request.leave_type_id=leave_types.id order by leaves_request.id DESC";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function viewLeaveRequest($leaveId) {
        $fetch = "SELECT * FROM `leaves_request` join users on leaves_request.userId=users.id join leave_types on leaves_request.leave_type_id=leave_types.id where leaves_request.id='{$leaveId}'";
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
              `days` = '{$data['days']}',
              `paid_type` = '{$data['paid_type']}'
               WHERE id = '{$data['leaveId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function assignLeaveStatus($data) { 
        if($data['send_note']!='') {
            $sendNote = $data['send_note'];
        } else {
            $sendNote = '';
        }
        $qry = "UPDATE `leaves_request` SET
              `leave_status` = '{$data['leave_status']}',
              `send_note` = '{$sendNote}',
              `notify_status` = '2'
               WHERE id = '{$data['leaveId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            if($data['leave_status'] == '1') {
                $this->update_leaves_record($data['userId'], $data['leave_type_id'], $data['number_of_days']);
            }
            return true;
        } else {
            return false;
        }
    }


    function update_leaves_record($userId, $leaveTypeID, $numberOfDays) {
        $fetch = "SELECT * FROM `employee_leave_record` where user_id='{$userId}' and leave_type_id='{$leaveTypeID}' ";
        $fetch_data = $this->select($fetch);
            if(!empty($fetch_data)) {
                $leaveCount = $fetch_data[0]['leave_count'] + $numberOfDays;
                $qry = "UPDATE `employee_leave_record` SET
                    `leave_count` = '{$leaveCount}' WHERE user_id = '{$userId}' and leave_type_id = '{$leaveTypeID}'";
                $res = $this->updateData($qry);
            } else {
                $qry = 'INSERT INTO `employee_leave_record` 
            (`user_id`,`leave_type_id`,`leave_count`) 
            VALUES ( "'. $userId . '","'. $leaveTypeID . '","'. $numberOfDays . '")';
                $res = $this->insert($qry);
            }

        return true;
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

    function getLeaveNotifyCount() {
        $fetch = "SELECT count(*) FROM `leaves_request` where notify_status=0";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    } 

    function getTeacherLeaveNotifyCount($userId) {
        $fetch = "SELECT count(*) FROM `leaves_request` where notify_status=2 and userId='{$userId}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }
    function adminClickNotification() {
        $qry = "UPDATE `leaves_request` SET
              `notify_status` = '1'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }    
}
?>