<?php
class AdmissionForm extends MySQLCN {

    function getAdmissionFormsListing() {
        $fetchList = "SELECT * FROM `admission_form_listing` join classes_name on admission_form_listing.class_id=classes_name.id join sections on admission_form_listing.section_id=sections.id where admission_form_listing.cancel_form_status='0' order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }

    function getCancelAdmissionFormsListing() {
        $fetchList = "SELECT * FROM `admission_form_listing` join classes_name on admission_form_listing.class_id=classes_name.id join sections on admission_form_listing.section_id=sections.id where admission_form_listing.cancel_form_status='1' order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }

    function StudentAdmissionForm($data) {
        $result = $this->checkStudentExist($data);
            if($result) {
                return false;
            }
  
        $qry = 'INSERT INTO `admission_form_listing` 
            (`first_name`,`last_name`,`parents_email_address`, `gender`, `dob`,`class_id`,`section_id`,`religion`,`date_of_joining`,`admission_no`,`roll_number`,`fathers_name`,`fathers_occupation`,`parents_mobile_number`,`present_address`,`mothers_name`,`mothers_occupation`,`nationality`,`blood_group`,`fathers_adhar_card`,`mothers_adhar_card`,`current_address`,`annual_income`,`name_address_local_guardian`,`name_address_previous_school`,`name_date_tc_issued`,`previous_school_cbse_status`,`previous_school_board_name`,`previous_school_result`,`tc_attached_status`,`mother_tongue`,`home_town`) 
            VALUES ( "'. $data['first_name'] . '", "'. $data['last_name'] . '", "'. $data['parents_email_address'] .'" , "'. $data['gender'] .'" ,"'. $data['dob'].'" ,"'. $data['class_id'].'" ,"'. $data['section_id'].'" ,"'. $data['religion'].'" ,"'. $data['date_of_joining'].'" ,"'. $data['admission_no'].'" ,"'. $data['roll_number'].'" ,"'. $data['fathers_name'].'" ,"'. $data['fathers_occupation'].'" ,"'. $data['parents_mobile_number'].'","'. $data['present_address'].'","'. $data['mothers_name'].'","'. $data['mothers_occupation'].'" ,"'. $data['nationality'].'","'. $data['blood_group'].'","'. $data['fathers_adhar_card'].'","'. $data['mothers_adhar_card'].'","'. $data['current_address'].'","'. $data['annual_income'].'","'. $data['name_address_local_guardian'].'","'. $data['name_address_previous_school'].'","'. $data['name_date_tc_issued'].'","'. $data['previous_school_cbse_status'].'","'. $data['previous_school_board_name'].'","'. $data['previous_school_result'].'","'. $data['tc_attached_status'].'","'. $data['mother_tongue'].'","'. $data['home_town'].'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function checkStudentExist($data) {
        $qry = "SELECT * FROM students WHERE admission_no = '{$data['admission_no']}'";
        $result = $this->select($qry);
        if ($result != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function getLastFormId() {
        $fetchList = "SELECT admission_no FROM `admission_form_listing` order by `id` desc limit 1";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }
    
    function getFormInfo($id) {
        $fetch = "SELECT * FROM `admission_form_listing` join classes_name on admission_form_listing.class_id=classes_name.id join sections on admission_form_listing.section_id=sections.id where admission_form_listing.id ='" . $id . "'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }
        
    function getStudentsByFeeGroup($fee_group_id) {
        $feeGroup = "SELECT * FROM `fee_groups` WHERE id='{$fee_group_id}'";
        $fetch = $this->select($feeGroup);
        if ($fetch[0]['class_id'] != '' && $fetch[0]['section_id'] != '') {
            return $this->getStudents($fetch[0]['class_id'], $fetch[0]['section_id']);
        }
        return [];
    }

    function getStudentsLists() {
        $fetchList = "SELECT * FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }

        function getStudentClassSectionWise($class_id, $section_id) {
            $query = "SELECT * FROM `students` WHERE class_id = '{$class_id}' AND section_id = '{$section_id}';";

            if (empty( $result = $this->select($query) )) {
                return [];
            }

            $results = [];
            foreach ($result as $row) {
                $results[$row['id']] = $row['first_name'] . ' ' . $row['last_name'];
            }
            return $results;
        }
    
    function getStudentsBySection($section_id) {
        $fetchList = "SELECT * FROM `students` WHERE section_id = '{$section_id}';";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }
}
?>
