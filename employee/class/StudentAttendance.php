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

    function getCurrentMonthAttendance($classId , $teacherId , $currentMonth) {
        $fetch = "SELECT students_attendance.* , DAY(date_of_attendance) as day_number, students.first_name , students.last_name from students_attendance join students on students.id = students_attendance.student_id where students_attendance.class_id='".$classId."' and students_attendance.teacher_id= '".$teacherId."' and MONTH(students_attendance.date_of_attendance)='".$currentMonth."'";
        $fetch_result = $this->select($fetch);
        echo "<pre>";print_r($fetch_result);die;  
        if (!empty($fetch_result)) {
          $student_data = array();
          foreach ($fetch_result as $key => $value) {
              $student_data[$key]['name'] = $value['first_name'].' '.$value['last_name'];
          }
          echo "<pre>";print_r($student_data);die;  
        } else {
          return false;
      }
    }     
}
?>