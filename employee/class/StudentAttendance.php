<?php
class StudentAttendance extends MySQLCN {

    function addingStudentsAttendance($data) { 
        $todaysDate = date('Y-m-d');
        $teacher_id = $data['teacher_id']; 
        $class_id = $data['class_id'];

        foreach ($data['userId'] as $key => $value) {
          $qry = 'INSERT INTO `students_attendance` 
              (`class_id`,`student_id`,`teacher_id`,`date_of_attendance`,`attendance`) 
              VALUES ( "'. $class_id . '", "'. $value['student_id'] . '", "'. $teacher_id . '", "'. $todaysDate . '", "'. $data['attendance'][$key] . '")';
          $res = $this->insert($qry);
        }
        return true;  
    }

    function getStudentDetails($classId , $teacherId) {
        $fetch = "SELECT DISTINCT students_attendance.student_id, students.first_name, students.last_name from students_attendance join students on students.id = students_attendance.student_id where students_attendance.class_id='".$classId."' and students_attendance.teacher_id= '".$teacherId."'";
        $fetch_result = $this->select($fetch);
        return $fetch_result;
    }

    function getCurrentMonthAttendance($classId , $teacherId , $currentMonth, $studentId) {
        $fetch = "SELECT students_attendance.attendance , DAY(date_of_attendance) as day_number from students_attendance where students_attendance.class_id='".$classId."' and students_attendance.teacher_id= '".$teacherId."' and students_attendance.student_id= '".$studentId."' and MONTH(students_attendance.date_of_attendance)='".$currentMonth."'";
        $fetch_result = $this->select($fetch); 
        if (!empty($fetch_result)) {
          $student_data = array();
          $get_current_month_days = date('t');
            for ($i=1; $i <= $get_current_month_days; $i++) { 
                if ($i < 10) {
                  $search_day = '0'.$i;
                } else {
                  $search_day = $i;
                }
            }

          //echo "<pre>";print_r($student_data);die;  
        } else {
          return false;
      }
    }     
}
?>