<?php
class StudentMarks extends MySQLCN {

    function addingStudentsMarks($data) { 
        $teacher_id = $_SESSION['userId']; 
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        $exam_id = $data['exam_id'];
        $exam_name = $data['exam_name'];
        $exam_term_id = $data['exam_term_id'];

        $qry = "DELETE FROM `students_marks` WHERE exam_id = '{$exam_id}' and teacher_id = '{$teacher_id}' ";
        $res = $this->deleteData($qry);

        foreach ($data['student_id'] as $key => $value) {
          $qry1 = 'INSERT INTO `students_marks` 
              (`class_id`,`section_id`,`exam_id`,`exam_term_id`,`teacher_id`,`exam_name`,`student_id`,`total_marks`,`marks_obtain`) 
              VALUES ( "'. $class_id . '", "'. $section_id . '", "'. $exam_id . '", "'. $exam_term_id . '", "'. $teacher_id . '", "'. $exam_name . '", "'. $value . '", "'.$data['total_marks'].'", "'. $data['marks_obtain'][$key] . '")';
          $res1 = $this->insert($qry1);
        }
        return true;  
    }
    
    function getStudentsSubjectMarks($examId, $teacherId) {
        $qry = "SELECT student_id,total_marks,marks_obtain FROM students_marks WHERE exam_id = '{$examId}' AND teacher_id = '{$teacherId}' ";
        $result = $this->select($qry);
        if ($result != NULL) {
            return $result;
        } else {
            return false;
        }
    }

    function getResultIfExist($examTermId,$get_class_id,$get_section_id,$teacher_id) {
        $qry = "SELECT id FROM students_marks WHERE exam_term_id = '{$examTermId}' AND class_id = '{$get_class_id}' AND section_id = '{$get_section_id}' AND teacher_id = '{$teacher_id}'";
        $result = $this->select($qry);
        if ($result != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function getExamTermData($examTermId) {
        $qry = "SELECT * FROM exam_term join exam_type on exam_term.exam_type_id= exam_type.id WHERE exam_term.id = '{$examTermId}' ";
        $result = $this->select($qry);
        if ($result != NULL) {
            return $result;
        } else {
            return false;
        }
    }

    function getStudentsMarks($examTermId , $studentId) {
        $qry = "SELECT * FROM students_marks join subjects on subjects.id= students_marks.exam_name WHERE students_marks.exam_term_id = '{$examTermId}' and students_marks.student_id = '{$studentId}' ";
        $result = $this->select($qry);
        $data = array();
        $studentData = array();
        if(!empty($result)) {
            foreach ($result as $key => $value) {
                $data[$key]['subject_name'] = $value['subject_name'];
                $data[$key]['total_marks'] = $value['total_marks'];
                $data[$key]['marks_obtain'] = $value['marks_obtain'];
            }
            $studentData['status'] = true;
            $studentData['message'] = 'data found!';
            $studentData['student_data'] = $data;
        } else {
            $studentData['status'] = false;
            $studentData['message'] = 'data not found!';
        } 
        return $studentData;  
    }
}
?>