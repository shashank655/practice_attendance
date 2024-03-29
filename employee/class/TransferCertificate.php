<?php
class TransferCertificate extends MySQLCN {

    function getTCFormsListing() {
        $fetchList = "SELECT * FROM `transfer_certificate` order by `student_name` asc";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }

    function AddTransferCertificate($data) {
        $qry = 'INSERT INTO `transfer_certificate` 
            (`student_name`,`guardian_name`,`address`, `religion`, `joining`,`from_date`,`to_date`,`amount_figures`,`amount_words`,`additional_info`,`class_name`,`tc_date`) 
            VALUES ( "'. $data['student_name'] . '", "'. $data['guardian_name'] . '", "'. $data['address'] .'" , "'. $data['religion'] .'" ,"'. $data['joining'].'" ,"'. $data['from_date'].'" ,"'. $data['to_date'].'","'. $data['amount_figures'].'","'. $data['amount_words'].'" ,"'. $data['additional_info'].'","'. $data['class_name'].'" ,"'. $data['tc_date'].'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getFormInfo($id) {
        $fetch = "SELECT * FROM `transfer_certificate` where id ='" . $id . "'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
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
