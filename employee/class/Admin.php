<?php
class Admin extends MySQLCN {

    function getAdminInfo($userId) {
        $qry = "SELECT * FROM users WHERE id = '{$userId}' AND user_role = '1' ";
        $fetch_data = $this->select($qry);
        return $fetch_data;
    }

    function teacherSignUp($data,$files) {
        $result = $this->checkTeacherSignUp($data);
            if($result) {
                return false;
            }
        if ($_FILES['profile_image']['error'] == '0') {
            $profileImageName = time() . strtolower(basename($_FILES['profile_image']['name']));
            $target = PROFILE_PIC_IMAGE_ROOT . $profileImageName;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
        } else {
            $profileImageName = '';
        }
            
         if($data['is_class_teacher'] == '1') {
            $role = '2';
         } else {
            $role = '3';
         }  
        $qry = 'INSERT INTO `users` 
            (`first_name`,`last_name`,`email_address`, `password`, `user_role`) 
            VALUES ( "'. $data['first_name'] . '", "'. $data['last_name'] . '", "'. $data['email_address'] .'" , "'. md5($data['password']) .'" ,"'.$role.'")';
        $res = $this->insert($qry);
        if ($res) {
            $last_id = mysqli_insert_id($this->CONN);

            $qry2 = 'INSERT INTO `teachers` 
            (`user_id`,`gender`,`dob`,`class_id`, `is_class_teacher`, `joining_date`, `mobile_number`, `subject_id`, `teacher_id`, `section`, `permanent_address`,`profile_image`) 
            VALUES ( "'. $last_id . '" ,"'. $data['gender'] . '", "'. $data['dob'] . '", "'. $data['class_id'] .'" , "'. $data['is_class_teacher'] .'" ,"'.$data['joining_date'].'","'.$data['mobile_number'].'","'.$data['subject_id'].'","'.$data['teacher_id'].'","'.$data['section'].'","'.$data['permanent_address'].'","'.$profileImageName.'")';
            $res2 = $this->insert($qry2);
            return true;
        } else {
            return false;
        }
    }

    function teacherInfoUpdate($data,$files) {
         if($data['is_class_teacher'] == '1') {
            $role = '2';
         } else {
            $role = '3';
         }

        if ($_FILES['profile_image']['error'] == '0') {
          $profileImageName = time() . strtolower(basename($_FILES['profile_image']['name']));
          $target = PROFILE_PIC_IMAGE_ROOT . $profileImageName;
          move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
        } else {
          $profileImageName = $_POST['profile_image_name'];
        }

        $qry = "UPDATE `users` SET
              `first_name` = '{$data['first_name']}', 
              `email_address` = '{$data['email_address']}', 
              `last_name` = '{$data['last_name']}'
               WHERE id = '{$data['userId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            $qry2 = "UPDATE `teachers` SET
              `gender` = '{$data['gender']}', 
              `dob` = '{$data['dob']}', 
              `class_id` = '{$data['class_id']}',
              `is_class_teacher` = '{$data['is_class_teacher']}',
              `joining_date` = '{$data['joining_date']}',
              `mobile_number` = '{$data['mobile_number']}',
              `subject_id` = '{$data['subject_id']}',
              `teacher_id` = '{$data['teacher_id']}',
              `section` = '{$data['section']}',
              `permanent_address` = '{$data['permanent_address']}',
              `profile_image` = '{$profileImageName}'
               WHERE user_id = '{$data['userId']}'";
            $res2 = $this->updateData($qry2);
            return true;
        } else {
            return false;
        }
    }

    function checkTeacherSignUp($data) {
        $qry = "SELECT * FROM users WHERE email_address = '{$data['email_address']}'";
        $result = $this->select($qry);
        if ($result != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function getTeacherInfo($id) {
        $fetch = "SELECT * FROM `users` join teachers on users.id =teachers.user_id where users.id ='" . $id . "'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
}
?>