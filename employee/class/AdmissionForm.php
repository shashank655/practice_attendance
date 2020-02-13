<?php
class AdmissionForm extends MySQLCN {

    function getAdmissionFormsListing() {
        $fetchList = "SELECT * FROM `admission_form_listing` join classes_name on admission_form_listing.class_id=classes_name.id join sections on admission_form_listing.section_id=sections.id order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }

    function StudentAdmissionForm($data) {
        $result = $this->checkStudentExist($data);
            if($result) {
                return false;
            }
  
        $qry = 'INSERT INTO `admission_form_listing` 
            (`first_name`,`last_name`,`email_address`, `gender`, `dob`,`class_id`,`section_id`,`religion`,`date_of_joining`,`mobile_number`,`admission_no`,`roll_number`,`fathers_name`,`fathers_occupation`,`parents_mobile_number`,`present_address`,`mothers_name`,`mothers_occupation`,`nationality`) 
            VALUES ( "'. $data['first_name'] . '", "'. $data['last_name'] . '", "'. $data['email_address'] .'" , "'. $data['gender'] .'" ,"'. $data['dob'].'" ,"'. $data['class_id'].'" ,"'. $data['section_id'].'" ,"'. $data['religion'].'" ,"'. $data['date_of_joining'].'" ,"'. $data['mobile_number'].'" ,"'. $data['admission_no'].'" ,"'. $data['roll_number'].'" ,"'. $data['fathers_name'].'" ,"'. $data['fathers_occupation'].'" ,"'. $data['parents_mobile_number'].'","'. $data['present_address'].'","'. $data['mothers_name'].'","'. $data['mothers_occupation'].'" ,"'. $data['nationality'].'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function checkStudentExist($data) {
        $qry = "SELECT * FROM admission_form_listing WHERE email_address = '{$data['email_address']}'";
        $result = $this->select($qry);
        if ($result != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function getLastFormId() {
        $fetchList = "SELECT id FROM `admission_form_listing` order by `id` desc limit 1";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
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
