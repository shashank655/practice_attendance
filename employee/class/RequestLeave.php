<?php
class RequestLeave extends MySQLCN {

    function addLeaveRequest($data) {
        if ($_FILES['leave_attachment']['error'] == '0') {
            $leaveAttachmentName = time() . strtolower(basename($_FILES['leave_attachment']['name']));
            $target = LEAVES_ATTACHMENT_ROOT . $leaveAttachmentName;
            move_uploaded_file($_FILES['leave_attachment']['tmp_name'], $target);
        } else {
            $leaveAttachmentName = '';
        }

        $userId = $_SESSION['userId'];
        $qry = 'INSERT INTO `leaves_request` 
            (`userId`,`leave_type_id`,`number_of_days`,`effective_from`,`effective_to`,`reason_to_leave`,`leaveAttachmentName`) 
            VALUES ( "'. $userId . '","'. $data['leave_type_id'] . '","'. $data['number_of_days'] . '","'. $data['effective_from'] . '","'. $data['effective_to'] . '","'. $data['reason_to_leave'] . '","'. $leaveAttachmentName . '")';
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

    function getLeavesAppliedLists($userId, $get_current_year, $get_current_month) {
        $fetch = "SELECT * FROM `leaves_request` join leave_types on leaves_request.leave_type_id=leave_types.id where userId='{$userId}' and MONTH(leaves_request.createdDate)='".$get_current_month."' and YEAR(leaves_request.createdDate)='".$get_current_year."'order by leaves_request.id DESC";
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

    function getEmployeeLeaveRecord($userId) {
        $fetch = "SELECT * FROM `leave_types`";
        $fetch_data = $this->select($fetch);
        $leaveData = array();
            foreach ($fetch_data as $key => $value) {
                $fetch2 = "SELECT * FROM `employee_leave_record` where leave_type_id = '{$value['id']}' and user_id = '{$userId}' ";
                $fetch_data2 = $this->select($fetch2);
                $leaveData[$key]['leave_type'] = $value['leave_type']; 
                $leaveData[$key]['total_leave'] = $value['days']; 
                $leaveData[$key]['total_leave_availed'] = $fetch_data2[0]['leave_count']; 
            }
        return $leaveData;
    }

}
?>