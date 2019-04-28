<?php
class Exams extends MySQLCN {

    function addExams($data) {
        $qry = 'INSERT INTO `exams_list` 
            (`class_id`,`section_id`,`date_of_exam`,`exam_name`) 
            VALUES ( "'. $data['class_id'] . '","'. $data['section_id'] . '","'. $data['date_of_exam'] . '","'. $data['exam_name'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getExamsLists() {
        $fetch = "SELECT * FROM `exams_list` LEFT JOIN classes_name on exams_list.class_id=classes_name.id LEFT JOIN sections on exams_list.section_id=sections.id";
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