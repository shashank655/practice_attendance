<?php
class Exams extends MySQLCN {

    function addExams($data) {

        if(!empty($data)) {
            $examData = array();
                $examData['exam_type_id'] = $data['exam_type_id'];
                $examData['exam_term_id'] = $data['exam_term_id'];
                $examData['class_id'] = $data['class_id'];
                $examData['section_id'] = $data['section_id'];
                $result = $this->checkExamIfExists($examData);

                if($result) {
                    return false;
                }

                $qry = 'INSERT INTO `exams_list` 
                    (`exam_type_id`,`exam_term_id`,`class_id`,`section_id`) 
                    VALUES ( "'. $examData['exam_type_id'] . '","'. $examData['exam_term_id'] . '","'. $examData['class_id'] . '","'. $examData['section_id'] . '")';
                $res = $this->insert($qry);

            foreach ($data['exam_name'] as $key => $value) {
                $examData['exam_name'] = $key;
                $examData['date_of_exam'] = $data['date_of_exam'][$key];
                $examData['time_of_exam'] = $data['time_of_exam'][$key];

                    $qry1 = 'INSERT INTO `exam_list_details` 
                    (`exam_list_id`,`exam_name`,`date_of_exam`,`time_of_exam`) 
                    VALUES ( "'. $res . '","'. $examData['exam_name'] . '","'. $examData['date_of_exam'] . '","'. $examData['time_of_exam'] . '")';
                    $res1 = $this->insert($qry1);
            }
            return true;
        } else {
            return false;
        }
    }

    function getExamsLists() {
        $fetch = "SELECT * FROM `exams_list` LEFT JOIN exam_type on exams_list.exam_type_id=exam_type.id LEFT JOIN exam_term on exams_list.exam_term_id=exam_term.id LEFT JOIN classes_name on exams_list.class_id=classes_name.id LEFT JOIN sections on exams_list.section_id=sections.id order by exams_list.id";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getClassTeachersExamsLists($classId, $sectionId) {
        $fetch = "SELECT * FROM `exams_list` LEFT JOIN classes_name on exams_list.class_id=classes_name.id LEFT JOIN sections on exams_list.section_id=sections.id where exams_list.class_id='{$classId}' and exams_list.section_id='{$sectionId}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getExamInfo($id) {
        $finalData = array();

        $fetch = "SELECT * FROM `exams_list` LEFT JOIN exam_type on exams_list.exam_type_id=exam_type.id LEFT JOIN exam_term on exams_list.exam_term_id=exam_term.id  LEFT JOIN classes_name on exams_list.class_id=classes_name.id  LEFT JOIN sections on exams_list.section_id=sections.id where exams_list.id='{$id}'";
        $fetch_data = $this->select($fetch);

        $fetch_data_list = "SELECT * FROM `exam_list_details` LEFT JOIN subjects on exam_list_details.exam_name=subjects.id where exam_list_details.exam_list_id='{$id}'";
        $fetch_details = $this->select($fetch_data_list);

        $finalData['fetch_data'] = $fetch_data;
        $finalData['fetch_details'] = $fetch_details;
        return $finalData;
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
              `exam_type_id` = '{$data['exam_type_id']}',
              `exam_term_id` = '{$data['exam_term_id']}',
              `class_id` = '{$data['class_id']}',
              `section_id` = '{$data['section_id']}'
               WHERE id = '{$data['examId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            $qry_del = "DELETE FROM `exam_list_details` WHERE exam_list_id = '{$data['examId']}'";
            $res_del = $this->deleteData($qry_del);

            foreach ($data['exam_name'] as $key => $value) {
                $examData['exam_name'] = $key;
                $examData['date_of_exam'] = $data['date_of_exam'][$key];
                $examData['time_of_exam'] = $data['time_of_exam'][$key];

                    $qry1 = 'INSERT INTO `exam_list_details` 
                    (`exam_list_id`,`exam_name`,`date_of_exam`,`time_of_exam`) 
                    VALUES ( "'. $data['examId'] . '","'. $examData['exam_name'] . '","'. $examData['date_of_exam'] . '","'. $examData['time_of_exam'] . '")';
                    $res1 = $this->insert($qry1);
            }
            return true;  
        } else {
            return false;
        }
    }

    function checkExamIfExists($data) {
        $fetch = "SELECT id FROM `exams_list` where exam_type_id='{$data['exam_type_id']}' and exam_term_id='{$data['exam_term_id']}' and class_id='{$data['class_id']}' and section_id='{$data['section_id']}'";
        $fetch_data = $this->select($fetch);
        if ($fetch_data != NULL) {
            return true;
        } else {
            return false;
        }
    }

}
?>