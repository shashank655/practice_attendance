<?php
//require_once '../../dompdf/dompdf_config.inc.php';

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

    function addSampleStudentsMarks($studentId) {
        $qryDel = "DELETE FROM `sample_examination_marks` WHERE student_id = '{$studentId}' ";
        $res = $this->deleteData($qryDel);

        $qryInsert = "INSERT INTO `sample_examination_marks`
            (`student_id`,`hindi_periodic_test`,`hindi_note_book`,`hindi_subject_enrichment`,`hindi_annual_examination`,`hindi_marks_obtained`,`hindi_grade`,`english_periodic_test`,`english_note_book`,`english_subject_enrichment`,`english_annual_examination`,`english_marks_obtained`,`english_grade`,`maths_periodic_test`,`maths_note_book`,`maths_subject_enrichment`,`maths_annual_examination`,`maths_marks_obtained`,`maths_grade`,`gs_periodic_test`,`gs_note_book`,`gs_subject_enrichment`,`gs_annual_examination`,`gs_marks_obtained`,`gs_grade`,`ss_periodic_test`,`ss_note_book`,`ss_subject_enrichment`,`ss_annual_examination`,`ss_marks_obtained`,`ss_grade`,`art_education`,`health_pysical_education`,`teachers_remark`,`final_result`)
            VALUES
            ('{$studentId}', '{$_POST['hindi_periodic_test']}', '{$_POST['hindi_note_book']}', '{$_POST['hindi_subject_enrichment']}', '{$_POST['hindi_annual_examination']}', '{$_POST['hindi_marks_obtained']}', '{$_POST['hindi_grade']}', '{$_POST['english_periodic_test']}', '{$_POST['english_note_book']}', '{$_POST['english_subject_enrichment']}', '{$_POST['english_annual_examination']}', '{$_POST['english_marks_obtained']}', '{$_POST['english_grade']}', '{$_POST['maths_periodic_test']}', '{$_POST['maths_note_book']}', '{$_POST['maths_subject_enrichment']}', '{$_POST['maths_annual_examination']}', '{$_POST['maths_marks_obtained']}', '{$_POST['maths_grade']}', '{$_POST['gs_periodic_test']}', '{$_POST['gs_note_book']}', '{$_POST['gs_subject_enrichment']}', '{$_POST['gs_annual_examination']}', '{$_POST['gs_marks_obtained']}', '{$_POST['gs_grade']}', '{$_POST['ss_periodic_test']}', '{$_POST['ss_note_book']}', '{$_POST['ss_subject_enrichment']}', '{$_POST['ss_annual_examination']}', '{$_POST['ss_marks_obtained']}', '{$_POST['ss_grade']}', '{$_POST['art_education']}', '{$_POST['health_pysical_education']}', '{$_POST['teachers_remark']}', '{$_POST['final_result']}' )";
        $aboutUsId = $this->insert($qryInsert);

        //$create_pdf = $this->createPDF();

        return true;

    }

    function createPDF() {
        $txt = '';
        $txt = str_replace('&nbsp;', '', $txt);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->load_html(html_entity_decode($txt));
        $dompdf->render();
        $output = $dompdf->output();
        $pdfname = md5(strtotime('now')) . '.pdf';
        file_put_contents(PDF_ATTACHMENT_ROOT . $pdfname, $output);

        echo "done";die;
    }

    function getSampleStudentMarks($studentId) {
        $qry = "SELECT * FROM sample_examination_marks WHERE student_id = '{$studentId}'";
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
