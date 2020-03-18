<?php
class ExamType extends MySQLCN {

    function addExamType($data) {
        $result = $this->checkExamType($data);
        if($result) {
            return false;
        }
        $qry = 'INSERT INTO `exam_type` 
            (`exam_type`) 
            VALUES ( "'. $data['exam_type'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getExamTypeLists() {
        $fetch = "SELECT * FROM `exam_type`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getExamTypeInfo($id) {
        $fetch = "SELECT * FROM `exam_type` where id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function deleteExamType($eId) {
        $qry = "DELETE FROM `exam_type` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function examTypeInfoUpdate($data) {
        $result = $this->checkExamType($data);
        if($result) {
            return false;
        }
        $qry = "UPDATE `exam_type` SET
              `exam_type` = '{$data['exam_type']}'
               WHERE id = '{$data['examTypeId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function checkExamType($data) {
        $fetch = "SELECT id FROM `exam_type` where exam_type='{$data['exam_type']}' ";
        $fetch_data = $this->select($fetch);
        if ($fetch_data != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function addExamTerm($data) {
        $result = $this->checkExamTerm($data);
        if($result) {
            return false;
        }
        $qry = 'INSERT INTO `exam_term` 
            (`exam_type_id`,`year_session`,`start_date`,`end_date`) 
            VALUES ( "'. $data['exam_type_id'] . '","'. $data['year_session'] . '","'. $data['start_date'] . '","'. $data['end_date'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getExamTermsLists() {
        $fetch = "SELECT exam_term.*,exam_type.* FROM `exam_term` join exam_type on exam_type.id = exam_term.exam_type_id";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function deleteExamTerm($eId) {
        $qry = "DELETE FROM `exam_term` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getExamTermInfo($id) {
        $fetch = "SELECT exam_term.*,exam_type.* FROM `exam_term` join exam_type on exam_type.id = exam_term.exam_type_id where exam_term.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function examTermInfoUpdate($data) {
        $result = $this->checkExamTerm($data);
        if($result) {
            return false;
        }
        $qry = "UPDATE `exam_term` SET
              `exam_type_id` = '{$data['exam_type_id']}',
              `year_session` = '{$data['year_session']}',
              `start_date` = '{$data['start_date']}',
              `end_date` = '{$data['end_date']}'
               WHERE id = '{$data['examTermId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function checkExamTerm($data) {
        $fetch = "SELECT id FROM `exam_term` where exam_type_id='{$data['exam_type_id']}' and year_session='{$data['year_session']}' and start_date='{$data['start_date']}' and end_date='{$data['end_date']}'";
        $fetch_data = $this->select($fetch);
        if ($fetch_data != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function getExamTermList($examTypeID) {
        $fetchSection = "SELECT * FROM `exam_term` where exam_type_id='{$examTypeID}' order by `id` DESC";
        $fetch_section = $this->select($fetchSection);
        return $fetch_section;
    }

    function getExamNameList($examTypeID,$classId,$sectionId) {
        $fetchData = "SELECT exams_list.id as examId, exam_type.*, exam_term.*, classes_name.*, sections.*  FROM `exams_list` LEFT JOIN exam_type on exams_list.exam_type_id=exam_type.id LEFT JOIN exam_term on exams_list.exam_term_id=exam_term.id LEFT JOIN classes_name on exams_list.class_id=classes_name.id LEFT JOIN sections on exams_list.section_id=sections.id where exams_list.exam_type_id='{$examTypeID}' and exams_list.class_id='{$classId}' and exams_list.section_id='{$sectionId}' order by 'exams_list.id' DESC";
        $fetch_data = $this->select($fetchData);
        return $fetch_data;
    }

    function getExamsSubjectsList($sectionID) {
        $fetchSubject = "SELECT subjects_id FROM `class_sections_subjects` where section_id='{$sectionID}'";
        $fetch_subject_ids = $this->select($fetchSubject);
        $getData = array();
                $fetch_subject_array = explode(',', $fetch_subject_ids[0]['subjects_id']);
                $subjects_array = array();
                foreach ($fetch_subject_array as $key => $value) {

                    $getSubject = "SELECT subject_name FROM `subjects` where id='{$value}'";
                    $subject_name = $this->select($getSubject);
                    $subjects_array[$key]['subject_name'] = $subject_name[0]['subject_name'];
                    $subjects_array[$key]['subId'] = $value;
                } 
        return $subjects_array;
    }
}
?>