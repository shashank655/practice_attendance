<?php
class RequestLeave extends MySQLCN {

    function addLeaveRequest($data) {
        $userId = $_SESSION['userId'];
        $qry = 'INSERT INTO `leaves_request` 
            (`userId`,`leave_type_id`,`number_of_days`,`effective_from`,`reason_to_leave`) 
            VALUES ( "'. $userId . '","'. $data['leave_type_id'] . '","'. $data['number_of_days'] . '","'. $data['effective_from'] . '","'. $data['reason_to_leave'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getLeaveTypeList() {
        $fetch = "SELECT * FROM `leave_types` ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getLeavesAppliedLists($userId) {
        $fetch = "SELECT * FROM `leaves_request` join leave_types on leaves_request.leave_type_id=leave_types.id where userId='{$userId}' order by leaves_request.id DESC";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getExamInfo($id) {
        $fetch = "SELECT * FROM `exams_list` LEFT JOIN classes_name on exams_list.class_id=classes_name.id  LEFT JOIN sections on exams_list.section_id=sections.id where exams_list.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteExams($eId) {
        $qry = "DELETE FROM `exams_list` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function examInfoUpdate($data) {
        $qry = "UPDATE `exams_list` SET
              `class_id` = '{$data['class_id']}',
              `section_id` = '{$data['section_id']}',
              `date_of_exam` = '{$data['date_of_exam']}',
              `exam_name` = '{$data['exam_name']}'
               WHERE id = '{$data['examId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>