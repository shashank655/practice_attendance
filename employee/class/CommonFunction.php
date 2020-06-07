<?php

class CommonFunction extends MySQLCN {

    function getAllSubjects() {
        $fetch = "SELECT * FROM `subjects` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }

    function getAllClassesName() {
        $fetch = "SELECT * FROM `classes_name` ";
        $fetch_classes = $this->select($fetch);
        return $fetch_classes;
    }

    function getSectionList($classId) {
        $fetchSection = "SELECT * FROM `sections` where class_id='{$classId}' order by `section_name` asc";
        $fetch_section = $this->select($fetchSection);
        return $fetch_section;
    }

    function getCountStudent() {
        $fetch = "SELECT count(*) FROM `students` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }

    function getCountTeacher() {
        $fetch = "SELECT count(*) FROM `teachers` ";
        $fetch_country = $this->select($fetch);
        return $fetch_country;
    }

    function getAllTeachers() {
        $fetchList = "SELECT * FROM `users` join teachers on users.id=teachers.user_id join subjects on subjects.id=teachers.subject_id where user_role != '1' and isDeleted = '0' order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        //echo "<pre>";print_r($fetch_list);die;
        return $fetch_list;
    }

    function getTeacherPassword() {
        $fetchList = "SELECT * FROM `teachers_password`";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }

    function isAdmin() {
        $fetchList = "SELECT * FROM `users` where user_role='1' ";
        $fetch_list = $this->select($fetchList);
        if(!empty($fetch_list)) {
            return true;
        } else {
            return false;
        }
    }

    public function getHolidaysDates()
    {
        $query = 'SELECT holiday_date FROM holidays';
        $return = [];
        if(empty($results = $this->select($query))) {
            return [];
        } else {
            foreach ($results as $value) {
                $date = str_replace('/', '-', $value['holiday_date']);
                array_push($return, date('Y-m-d', strtotime($date)));
            }
        }

        return $return;
    }

    public function studentsCount($class_id, $section_id)
    {
        $query = "SELECT COUNT(*) AS count FROM students WHERE class_id = '{$class_id}' AND section_id = '{$section_id }'";
        $return = [];
        if(empty($results = $this->select($query))) {
            return 0;
        } else {
            return $results[0]['count'];
        }
    }

    public function teachersCount()
    {
        $query = "SELECT COUNT(*) AS count FROM teachers";
        $return = [];
        if(empty($results = $this->select($query))) {
            return 0;
        } else {
            return $results[0]['count'];
        }
    }

}
