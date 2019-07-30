<?php
class Exams extends MySQLCN {

    function addExams($data) {
        $result = $this->checkExamIfExists($data);
        if($result) {
            return false;
        }
        $qry = 'INSERT INTO `exams_list` 
            (`exam_type_id`,`exam_term_id`,`class_id`,`section_id`,`date_of_exam`,`time_of_exam`,`exam_name`) 
            VALUES ( "'. $data['exam_type_id'] . '","'. $data['exam_term_id'] . '","'. $data['class_id'] . '","'. $data['section_id'] . '","'. $data['date_of_exam'] . '","'. $data['time_of_exam'] . '","'. trim($data['exam_name']) . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getExamsLists() {
        $fetch = "SELECT * FROM `exams_list` LEFT JOIN exam_type on exams_list.exam_type_id=exam_type.id LEFT JOIN exam_term on exams_list.exam_term_id=exam_term.id LEFT JOIN classes_name on exams_list.class_id=classes_name.id LEFT JOIN sections on exams_list.section_id=sections.id LEFT JOIN subjects on subjects.id=exams_list.exam_name";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getClassTeachersExamsLists($classId, $sectionId) {
        $fetch = "SELECT * FROM `exams_list` LEFT JOIN classes_name on exams_list.class_id=classes_name.id LEFT JOIN sections on exams_list.section_id=sections.id LEFT JOIN subjects on subjects.id=exams_list.exam_name where exams_list.class_id='{$classId}' and exams_list.section_id='{$sectionId}' order by date_of_exam DESC";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getExamInfo($id) {
        $fetch = "SELECT * FROM `exams_list` LEFT JOIN exam_type on exams_list.exam_type_id=exam_type.id LEFT JOIN exam_term on exams_list.exam_term_id=exam_term.id  LEFT JOIN classes_name on exams_list.class_id=classes_name.id  LEFT JOIN sections on exams_list.section_id=sections.id LEFT JOIN subjects on subjects.id=exams_list.exam_name where exams_list.id='{$id}'";
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
        $result = $this->checkExamIfExists($data);
        if($result) {
            return false;
        }
        $examName = trim($data['exam_name']);
        $qry = "UPDATE `exams_list` SET
              `exam_type_id` = '{$data['exam_type_id']}',
              `exam_term_id` = '{$data['exam_term_id']}',
              `class_id` = '{$data['class_id']}',
              `section_id` = '{$data['section_id']}',
              `date_of_exam` = '{$data['date_of_exam']}',
              `time_of_exam` = '{$data['time_of_exam']}',
              `exam_name` = '{$examName}'
               WHERE id = '{$data['examId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;    
        } else {
            return false;
        }
    }

    function checkExamIfExists($data) {
        $fetch = "SELECT id FROM `exams_list` where exam_type_id='{$data['exam_type_id']}' and exam_term_id='{$data['exam_term_id']}' and class_id='{$data['class_id']}' and section_id='{$data['section_id']}' and date_of_exam='{$data['date_of_exam']}' and time_of_exam='{$data['time_of_exam']}' and exam_name='{$data['exam_name']}'";
        $fetch_data = $this->select($fetch);
        if ($fetch_data != NULL) {
            return true;
        } else {
            return false;
        }
    }

}
?>