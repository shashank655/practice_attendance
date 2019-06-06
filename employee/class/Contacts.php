<?php
class Contacts extends MySQLCN {

    function getAllTeachersList($search) {
      if($search == 'students') {
         $fetchList = "SELECT students.first_name,students.last_name,students.mobile_number,students.student_profile_image,classes_name.class_name,sections.section_name FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id order by `first_name` asc";
      } else if($search == 'parents') {
        $fetchList = "SELECT students.first_name,students.last_name,students.fathers_name,students.parents_mobile_number,students.parents_profile_image,classes_name.class_name,sections.section_name FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id order by `first_name` asc";
      } else {
         $fetchList = "SELECT users.first_name,users.last_name,users.email_address,teachers.mobile_number,teachers.profile_image,users.user_role,subjects.subject_name FROM `users` join teachers on users.id=teachers.user_id join subjects on subjects.id=teachers.subject_id where user_role != '1' order by `first_name` asc";
      }
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    } 
}
?>