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
        $fetchList = "SELECT * FROM `users` join teachers on users.id=teachers.user_id join subjects on subjects.id=teachers.subject_id where user_role != '1' order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        //echo "<pre>";print_r($fetch_list);die;
        return $fetch_list;
    }

    function getAllStudents() {
        $fetchList = "SELECT * FROM `students` order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
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
}    