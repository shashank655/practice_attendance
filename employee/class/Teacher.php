<?php
class Teacher extends MySQLCN {

    function userLogin($data) {
        $qry = "SELECT * FROM users WHERE email_address = '{$data['email_address']}' AND password = md5('{$data['password']}')";
        $result = $this->select($qry);
        if ($result != NULL) {
            $_SESSION['userId'] = $result[0]['id'];
            $_SESSION['name'] = $result[0]['first_name'].' '.$result[0]['last_name'];
            $_SESSION['email_address'] = $result[0]['email_address'];
            return true;
        } else {
            return false;
        }
    }

    function teacherSignUp($data,$files,$teacherPassword) {
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
         
         $get_password = $this->getTeacherPassword();
         $tPass = md5($get_password[0]['password']); 

         if($data['is_class_teacher'] == '1') {
            $role = '2';
         } else {
            $role = '3';
         }  
        $qry = 'INSERT INTO `users` 
            (`first_name`,`last_name`,`email_address`, `password`, `user_role`) 
            VALUES ( "'. $data['first_name'] . '", "'. $data['last_name'] . '", "'. $data['email_address'] .'" , "'. $tPass.'" ,"'.$role.'")';
        $res = $this->insert($qry);
        if ($res) {
            $last_id = mysqli_insert_id($this->CONN);

            $qry2 = 'INSERT INTO `teachers` 
            (`user_id`,`gender`,`dob`,`class_id`, `is_class_teacher`, `joining_date`, `mobile_number`, `subject_id`, `teacher_id`, `section_id`, `permanent_address`,`profile_image`) 
            VALUES ( "'. $last_id . '" ,"'. $data['gender'] . '", "'. $data['dob'] . '", "'. $data['class_id'] .'" , "'. $data['is_class_teacher'] .'" ,"'.$data['joining_date'].'","'.$data['mobile_number'].'","'.trim($data['subject_id']).'","'.$data['teacher_id'].'","'.$data['section_id'].'","'.$data['permanent_address'].'","'.$profileImageName.'")';
            $res2 = $this->insert($qry2);

            $send_email = $this->emailDetailsToTeacher($data,$teacherPassword);
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
          $subject_id = trim($data['subject_id']);
            $qry2 = "UPDATE `teachers` SET
              `gender` = '{$data['gender']}', 
              `dob` = '{$data['dob']}', 
              `class_id` = '{$data['class_id']}',
              `is_class_teacher` = '{$data['is_class_teacher']}',
              `joining_date` = '{$data['joining_date']}',
              `mobile_number` = '{$data['mobile_number']}',
              `subject_id` = '{$subject_id}',
              `teacher_id` = '{$data['teacher_id']}',
              `section_id` = '{$data['section_id']}',
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

    function getTeacherPassword(){
      $fetch = "SELECT * FROM `teachers_password`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    } 

    function isCheckEmailAddress() {
        if($_POST['oldEmailAddress'] == $_POST['emailAddress']) {
            return false;
        } else {
            $fetch = "SELECT * FROM `users` where email_address='".$_POST['emailAddress']."'";
            $fetch_result = $this->select($fetch);
            if (!empty($fetch_result)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function assignTeacherPassword($data) {
      $qry = "TRUNCATE TABLE `teachers_password`";
      $res = $this->deleteData($qry);
        if ($res) {
            $qry2 = 'INSERT INTO `teachers_password` 
            (`password`) 
            VALUES ( "'. $data['password'] . '")';
            $res2 = $this->insert($qry2);

            $tPass = md5($data['password']);
            $qry2 = "UPDATE `users` SET
              `password` = '{$tPass}' where user_role!= 1 ";
            $res2 = $this->updateData($qry2);

            return true;
        } else {
            return false;
        }
    }

    function emailDetailsToTeacher($result,$teachPass) {
        if (!empty($result)) {
                $to = $result['email_address'];
                $subject = "Teacher Login Details";
            $txt = '
                  Hi '.$result['first_name'].',<br/><br/>
                  Below are the details of Email address and Password to login .<br/><br/>
                  Email '.$to.'.<br/><br/>
                  Password '.$teachPass[0]['password'].'.<br/><br/>
                  Thank you!
                    PreSchool!<br/>';
            $fromEmail = 'shashankgarg655@gmail.com';
            $fromName = 'Test Email';
            $res = $this->send_mail($to, $fromEmail, $fromName, $subject, $txt);
                if($res){
                    return true;
                } else {
                    return false;
                }    
        } else {
            return false;
        }
    }

    function getTeacherClassName($teacherId) {
      $fetch = "SELECT classes_name.class_name, sections.id as sectionId, classes_name.id as classId FROM `teachers` join classes_name on classes_name.id=teachers.class_id join sections on sections.id=teachers.section_id where user_id='".$teacherId."'";
      $fetch_result = $this->select($fetch);
        if (!empty($fetch_result)) {
          return $fetch_result;
        } else {
          return false;
      }
    }

    function getTotalClassStudents($classId, $sectionId) {
      $fetch = "SELECT id,first_name,last_name FROM `students` where class_id='".$classId."' and section_id='".$sectionId."'";
      $fetch_result = $this->select($fetch);
        if (!empty($fetch_result)) {
          return $fetch_result;
        } else {
          return false;
      }
    }

    function isTodaysAttendanceCheck($teacher_id , $class_id , $section_id) {
        $todaysDate = date('Y-m-d');
        $fetch = "SELECT * FROM `students_attendance` where class_id='".$class_id."' and teacher_id= '".$teacher_id."' and section_id= '".$section_id."' and date_of_attendance='".$todaysDate."'";
        $fetch_result = $this->select($fetch);
        if (!empty($fetch_result)) {
          return true;
        } else {
          return false;
      }

    }     
}
?>