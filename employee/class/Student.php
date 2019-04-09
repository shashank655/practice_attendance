<?php
class Student extends MySQLCN {

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

    function StudentSignUp($data,$files) {
        $result = $this->checkStudentSignUp($data);
            if($result) {
                return false;
            }
        if ($_FILES['student_profile_image']['error'] == '0') {
            $studentProfileImageName = time() . strtolower(basename($_FILES['student_profile_image']['name']));
            $target = PROFILE_PIC_IMAGE_ROOT . $studentProfileImageName;
            move_uploaded_file($_FILES['student_profile_image']['tmp_name'], $target);
        } else {
            $studentProfileImageName = '';
        }

        if ($_FILES['parents_profile_image']['error'] == '0') {
            $parentsProfileImageName = time() . strtolower(basename($_FILES['parents_profile_image']['name']));
            $target = PROFILE_PIC_IMAGE_ROOT . $parentsProfileImageName;
            move_uploaded_file($_FILES['parents_profile_image']['tmp_name'], $target);
        } else {
            $parentsProfileImageName = '';
        }
  
        $qry = 'INSERT INTO `students` 
            (`first_name`,`last_name`,`email_address`, `gender`, `dob`,`class_id`,`section_id`,`religion`,`date_of_joining`,`mobile_number`,`admission_no`,`student_id`,`fathers_name`,`fathers_occupation`,`parents_mobile_number`,`present_address`,`mothers_name`,`mothers_occupation`,`nationality`,`permanent_address`,`student_profile_image`,`parents_profile_image`) 
            VALUES ( "'. $data['first_name'] . '", "'. $data['last_name'] . '", "'. $data['email_address'] .'" , "'. $data['gender'] .'" ,"'. $data['dob'].'" ,"'. $data['class_id'].'" ,"'. $data['section_id'].'" ,"'. $data['religion'].'" ,"'. $data['date_of_joining'].'" ,"'. $data['mobile_number'].'" ,"'. $data['admission_no'].'" ,"'. $data['student_id'].'" ,"'. $data['fathers_name'].'" ,"'. $data['fathers_occupation'].'" ,"'. $data['parents_mobile_number'].'","'. $data['present_address'].'","'. $data['mothers_name'].'","'. $data['mothers_occupation'].'" ,"'. $data['nationality'].'" ,"'. $data['permanent_address'].'" ,"'.$studentProfileImageName.'" ,"'.$parentsProfileImageName.'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function StudentInfoUpdate($data,$files) {

        if ($_FILES['student_profile_image']['error'] == '0') {
            $studentProfileImageName = time() . strtolower(basename($_FILES['student_profile_image']['name']));
            $target = PROFILE_PIC_IMAGE_ROOT . $studentProfileImageName;
            move_uploaded_file($_FILES['student_profile_image']['tmp_name'], $target);
        } else {
            $studentProfileImageName = $_POST['student_profile_image_name'];
        }

        if ($_FILES['parents_profile_image']['error'] == '0') {
            $parentsProfileImageName = time() . strtolower(basename($_FILES['parents_profile_image']['name']));
            $target = PROFILE_PIC_IMAGE_ROOT . $parentsProfileImageName;
            move_uploaded_file($_FILES['parents_profile_image']['tmp_name'], $target);
        } else {
            $parentsProfileImageName = $_POST['parents_profile_image_name'];
        }

        $qry = "UPDATE `students` SET
              `first_name` = '{$data['first_name']}', 
              `email_address` = '{$data['email_address']}', 
              `last_name` = '{$data['last_name']}',
              `gender` = '{$data['gender']}',
              `dob` = '{$data['dob']}',
              `class_id` = '{$data['class_id']}',
              `section_id` = '{$data['section_id']}',
              `religion` = '{$data['religion']}',
              `date_of_joining` = '{$data['date_of_joining']}',
              `mobile_number` = '{$data['mobile_number']}',
              `admission_no` = '{$data['admission_no']}',
              `student_id` = '{$data['student_id']}',
              `fathers_name` = '{$data['fathers_name']}',
              `fathers_occupation` = '{$data['fathers_occupation']}',
              `parents_mobile_number` = '{$data['parents_mobile_number']}',
              `present_address` = '{$data['present_address']}',
              `mothers_name` = '{$data['mothers_name']}',
              `mothers_occupation` = '{$data['mothers_occupation']}',
              `nationality` = '{$data['nationality']}',
              `permanent_address` = '{$data['permanent_address']}',
              `student_profile_image` = '{$studentProfileImageName}',
              `parents_profile_image` = '{$parentsProfileImageName}'
               WHERE id = '{$data['studentId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function checkStudentSignUp($data) {
        $qry = "SELECT * FROM students WHERE email_address = '{$data['email_address']}'";
        $result = $this->select($qry);
        if ($result != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function getStudentInfo($id) {
        $fetch = "SELECT * FROM `students` where students.id ='" . $id . "'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
}
?>