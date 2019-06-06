<?php
class EmployeeSalary extends MySQLCN {

    function addEmployeeSalary($data) {
        $qry = 'INSERT INTO `employee_salary` 
            (`teacher_id`,`gross_salary`,`basic`,`da`,`hra`,`conveyance`,`allowance`,`medical_allowance`,`others`,`tds`,`esi`,`pf`,`leaves`,`prof_tax`,`labour_welfare`,`fund`) 
            VALUES ( "'. $data['teacher_id'] . '" , "'. $data['gross_salary'] . '" , "'. $data['basic'] . '" , "'. $data['da'] . '" , "'. $data['hra'] . '" , "'. $data['conveyance'] . '" , "'. $data['allowance'] . '" , "'. $data['medical_allowance'] . '" , "'. $data['others'] . '" , "'. $data['tds'] . '" , "'. $data['esi'] . '" , "'. $data['pf'] . '" , "'. $data['leaves'] . '" , "'. $data['prof_tax'] . '" , "'. $data['labour_welfare'] . '" , "'. $data['fund'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function viewLeaveRequest($leaveId) {
        $fetch = "SELECT * FROM `leaves_request` join users on leaves_request.userId=users.id join leave_types on leaves_request.leave_type_id=leave_types.id where leaves_request.id='{$leaveId}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getEmployeeSalaryInfo($id) {
        $fetch = "SELECT * FROM `employee_salary` where id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    } 

    function employeeSalaryInfoUpdate($data) {
        $qry = "UPDATE `employee_salary` SET
              `teacher_id` = '{$data['teacher_id']}',
              `gross_salary` = '{$data['gross_salary']}',
              `basic` = '{$data['basic']}',
              `da` = '{$data['da']}',
              `hra` = '{$data['hra']}',
              `conveyance` = '{$data['conveyance']}',
              `allowance` = '{$data['allowance']}',
              `medical_allowance` = '{$data['medical_allowance']}',
              `others` = '{$data['others']}',
              `tds` = '{$data['tds']}',
              `esi` = '{$data['esi']}',
              `pf` = '{$data['pf']}',
              `leaves` = '{$data['leaves']}',
              `prof_tax` = '{$data['prof_tax']}',
              `labour_welfare` = '{$data['labour_welfare']}',
              `fund` = '{$data['fund']}'
               WHERE id = '{$data['salaryId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getEmployeeSalaryList() {
        $fetch = "SELECT users.first_name , users.last_name , users.email_address , employee_salary.id as salaryId , teachers.gender , teachers.mobile_number FROM `employee_salary` LEFT JOIN teachers on employee_salary.teacher_id=teachers.user_id LEFT JOIN users on users.id=employee_salary.teacher_id";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
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

    function viewEmployeeSalary($sId) {
        $fetch = "SELECT users.first_name , users.last_name , users.email_address , employee_salary.* , teachers.gender , teachers.mobile_number FROM `employee_salary` LEFT JOIN teachers on employee_salary.teacher_id=teachers.user_id LEFT JOIN users on users.id=employee_salary.teacher_id where employee_salary.id = '{$sId}' ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
}
?>