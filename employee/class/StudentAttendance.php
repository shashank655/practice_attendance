<?php
class StudentAttendance extends MySQLCN {

    function addingStudentsAttendance($data) { 
        $todaysDate = date('Y-m-d');
        $teacher_id = $data['teacher_id']; 
        $class_id = $data['class_id'];
        $section_id = $data['section_id'];
        foreach ($data['student_id'] as $key => $value) {
            if(empty($data['attendance_status'][$key])) {
                $attenStatus = '';
            } else {
                $attenStatus = $data['attendance_status'][$key];
            }
          $qry = 'INSERT INTO `students_attendance` 
              (`class_id`,`section_id`,`student_id`,`teacher_id`,`date_of_attendance`,`attendance`,`attendance_status`) 
              VALUES ( "'. $class_id . '", "'. $section_id . '", "'. $value . '", "'. $teacher_id . '", "'. $todaysDate . '", "'. $data['attendance'][$key] . '", "'. $attenStatus . '")';
          $res = $this->insert($qry);
        }
        return true;  
    }

    function getStudentDetails($classId , $teacherId , $sectionId) {
        $fetch = "SELECT DISTINCT students_attendance.student_id, students.first_name, students.last_name from students_attendance join students on students.id = students_attendance.student_id where students_attendance.class_id='".$classId."' and students_attendance.section_id='".$sectionId."' and students_attendance.teacher_id= '".$teacherId."'";
        $fetch_result = $this->select($fetch);
        return $fetch_result;
    }

    function getAllClassesStudentDetails($classId , $sectionId) {
        $fetch = "SELECT DISTINCT students_attendance.student_id, students.first_name, students.last_name from students_attendance join students on students.id = students_attendance.student_id where students_attendance.class_id='".$classId."' and students_attendance.section_id='".$sectionId."'";
        $fetch_result = $this->select($fetch);
        return $fetch_result;
    }

    function getCurrentMonthAttendance($classId , $teacherId , $currentMonth , $currentYear , $studentId , $numberOfDays) {
        $fetch = "SELECT students_attendance.attendance, students_attendance.attendance_status , DAY(date_of_attendance) as day_number from students_attendance where students_attendance.class_id='".$classId."' and students_attendance.teacher_id= '".$teacherId."' and students_attendance.student_id= '".$studentId."' and MONTH(students_attendance.date_of_attendance)='".$currentMonth."' and YEAR(students_attendance.date_of_attendance)='".$currentYear."'";
        $fetch_result = $this->select($fetch);
        if (!empty($fetch_result)) {
          $student_data = array();
          $attendanceArray = array();
            for ($i=1; $i <= $numberOfDays; $i++) {
                if ($i < 10) {
                  $search_day = '0'.$i;
                    $findDate = $currentYear.'-'.$currentMonth.'-'.$search_day;
                    $unixTimestamp = strtotime($findDate);
                    $dayOfWeek = date("D", $unixTimestamp);
                     foreach ($fetch_result as $key => $val) {
                         if ($val['day_number'] == $search_day) {
                             $attendanceArray[$search_day]['output'] = $val['attendance'];
                             break;
                         } else if($dayOfWeek == 'Sun') {
                            $attendanceArray[$search_day]['output']='Sun';
                         } else {
                             $attendanceArray[$search_day]['output']='---';
                         }
                     } 
                } else {
                  $search_day = $i;
                    $findDate = $currentYear.'-'.$currentMonth.'-'.$search_day;
                    $unixTimestamp = strtotime($findDate);
                    $dayOfWeek = date("D", $unixTimestamp);
                     foreach ($fetch_result as $key => $val) {
                         if ($val['day_number'] == $search_day) {
                             $attendanceArray[$search_day]['output'] = $val['attendance'];
                             break;
                         } else if($dayOfWeek == 'Sun') {
                            $attendanceArray[$search_day]['output']='Sun';
                         } else {
                             $attendanceArray[$search_day]['output']='---';
                         }
                     }
                }
            }
          return $attendanceArray;
        } else {
          return false;
      }
    }

    function getSelectedMonthAttendance($classId , $selectedMonth , $selectedYear , $studentId , $numberOfDays) {
        $fetch = "SELECT students_attendance.attendance , DAY(date_of_attendance) as day_number from students_attendance where students_attendance.class_id='".$classId."' and students_attendance.student_id= '".$studentId."' and MONTH(students_attendance.date_of_attendance)='".$selectedMonth."' and YEAR(students_attendance.date_of_attendance)='".$selectedYear."'";
        $fetch_result = $this->select($fetch); 
        if (!empty($fetch_result)) {
          $student_data = array();
          $attendanceArray = array();
            for ($i=1; $i <= $numberOfDays; $i++) { 
                if ($i < 10) {
                  $search_day = '0'.$i;
                    $findDate = $selectedYear.'-'.$selectedMonth.'-'.$search_day;
                    $unixTimestamp = strtotime($findDate);
                    $dayOfWeek = date("D", $unixTimestamp);
                     foreach ($fetch_result as $key => $val) {
                         if ($val['day_number'] == $search_day) {
                             $attendanceArray[$search_day]['output'] = $val['attendance'];
                             break;
                         } else if($dayOfWeek == 'Sun') {
                            $attendanceArray[$search_day]['output']='Sun';
                         } else {
                             $attendanceArray[$search_day]['output']='---';
                         }
                     } 
                } else {
                  $search_day = $i;
                    $findDate = $selectedYear.'-'.$selectedMonth.'-'.$search_day;
                    $unixTimestamp = strtotime($findDate);
                    $dayOfWeek = date("D", $unixTimestamp);
                     foreach ($fetch_result as $key => $val) {
                         if ($val['day_number'] == $search_day) {
                             $attendanceArray[$search_day]['output'] = $val['attendance'];
                             break;
                         } else if($dayOfWeek == 'Sun') {
                            $attendanceArray[$search_day]['output']='Sun';
                         } else {
                             $attendanceArray[$search_day]['output']='---';
                         }
                     }
                }
            }
          return $attendanceArray;
        } else {
          return false;
      }
    }

    function getStudentMonthlyAttendence($class_id = null, $section_id = null, $attendance_type = null)
    {
        $query = "SELECT count(*) as count, DATE_FORMAT(date_of_attendance, \"%Y-%m\") as month";
        $query .= " FROM students_attendance";

            $where = [];
        if ($class_id) array_push($where,  "class_id = '{$class_id}'");
        if ($section_id) array_push($where, "section_id = '{$section_id}'");
        if ($attendance_type) array_push($where, "attendance = '{$attendance_type}'");
        array_push($where, "DATE_FORMAT(date_of_attendance, \"%Y\") = '" . date('Y') . "'");

            $query .= " WHERE " . implode(' AND ', $where);
        $query .= " GROUP BY month;";

        if (empty($result = $this->select($query))) {
            return [];
        }

        $results = [];
        foreach ($result as $row) {
            $results[$row['month']] = $row['count'];
        }
        return $results;
    }

    function getMonthlyAttendenceStudentWise($class_id = null, $section_id = null, $month = null, $attendance_type = null)
    {
        $query = "SELECT count(attendance) as count, student_id";
        $query .= " FROM students_attendance";

            $where = [];
        if ($class_id) array_push($where,  "class_id = '{$class_id}'");
        if ($section_id) array_push($where, "section_id = '{$section_id}'");
        if ($month) array_push($where, "DATE_FORMAT(date_of_attendance, \"%Y-%m\") = '{$month}'");
        if ($attendance_type) array_push($where, "attendance = '{$attendance_type}'");
        array_push($where, "DATE_FORMAT(date_of_attendance, \"%Y\") = '" . date('Y') . "'");

            $query .= " WHERE " . implode(' AND ', $where);
        $query .= " GROUP BY student_id;";

        if (empty($result = $this->select($query))) {
            return [];
        }

        $results = [];
        foreach ($result as $row) {
            $results[$row['student_id']] = $row['count'];
        }
        return $results;
    }
}
