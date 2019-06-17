<?php
class TeacherModel extends MySQLCN {

    function getTeacherInfo($id) {
      $fetch = "SELECT * FROM `users` where users.id='{$id}'";
      $fetch_data = $this->select($fetch);
      return $fetch_data;
    }

    function getTeachersList() {
      $fetch = "SELECT * from users where users.user_role!='1' order by first_name";
      $fetch_result = $this->select($fetch);
      return $fetch_result;
    }     

    function assignTeacher($data) {
      $teacher_id = $data['userId'];
      $qry = "DELETE FROM `assign_teacher` WHERE `teacher_id` = '{$teacher_id}'";
      $res = $this->deleteData($qry);
      $is_class_teacher = explode(',', $data['is_class_teacher']);
      foreach ($data['teaches'] as $teach) {
        $classSections = explode(',', $teach);
        $class_id = $classSections[0];
        $section_id = $classSections[1];
        $qry = 'INSERT INTO `assign_teacher`(`teacher_id`, `class_id`, `section_id`, `is_class_teacher`) VALUES ("'.$teacher_id.'", "'.$class_id.'", "'.$section_id.'", "0")';
        $res = $this->insert($qry);
      }
      if ($res) {
        if(count($is_class_teacher) > 0){
          $class_id = $is_class_teacher[0];
          $section_id = $is_class_teacher[1];
          $qry2 = 'UPDATE `assign_teacher` SET `is_class_teacher`="1" WHERE `teacher_id` =  "'.$teacher_id.'" AND `class_id` = "'.$class_id.'" AND `section_id` = "'.$section_id.'"';
          $res2 = $this->insert($qry2);
        }
        return true;
      } else {
          return false;
      }
    }

    function getAssignedClassSection($id) {
      $fetch = "SELECT * FROM `assign_teacher` where assign_teacher.teacher_id='{$id}'";
      $fetch_data = $this->select($fetch);
      return $fetch_data;
    }

}
?>