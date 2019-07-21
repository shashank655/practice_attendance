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
            (`first_name`,`last_name`,`email_address`, `gender`, `dob`,`class_id`,`section_id`,`religion`,`date_of_joining`,`mobile_number`,`admission_no`,`roll_number`,`fathers_name`,`fathers_occupation`,`parents_mobile_number`,`present_address`,`mothers_name`,`mothers_occupation`,`nationality`,`permanent_address`,`student_profile_image`,`parents_profile_image`) 
            VALUES ( "'. $data['first_name'] . '", "'. $data['last_name'] . '", "'. $data['email_address'] .'" , "'. $data['gender'] .'" ,"'. $data['dob'].'" ,"'. $data['class_id'].'" ,"'. $data['section_id'].'" ,"'. $data['religion'].'" ,"'. $data['date_of_joining'].'" ,"'. $data['mobile_number'].'" ,"'. $data['admission_no'].'" ,"'. $data['roll_number'].'" ,"'. $data['fathers_name'].'" ,"'. $data['fathers_occupation'].'" ,"'. $data['parents_mobile_number'].'","'. $data['present_address'].'","'. $data['mothers_name'].'","'. $data['mothers_occupation'].'" ,"'. $data['nationality'].'" ,"'. $data['permanent_address'].'" ,"'.$studentProfileImageName.'" ,"'.$parentsProfileImageName.'")';
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
              `roll_number` = '{$data['roll_number']}',
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
        $fetch = "SELECT * FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id where students.id ='" . $id . "'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function DeleteStudent($sId) {
        $qry = "DELETE FROM `students` WHERE id = '{$sId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getAllStudents($get_class_id,$get_section_id,$roll_number,$student_name) {
        $fetchList = "SELECT * FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id where students.first_name='{$student_name}' or students.roll_number='{$roll_number}' or ( students.class_id='{$get_class_id}' and students.section_id='{$get_section_id}' ) order by `first_name` asc";
       // echo $fetchList;die;
        $fetch_list = $this->select($fetchList);
        //echo "<pre>";print_r($fetch_list);die;
        return $fetch_list;
    }

    function getStudents($class_id, $section_id) {
        $fetchList = "SELECT * FROM `students` where students.class_id='{$class_id}' and students.section_id='{$section_id}' order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }
    
    function getStudentsLists() {
        $fetchList = "SELECT * FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id order by `first_name` asc";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }

        function getStudentClassSectionWise($class_id, $section_id) {
            $query = "SELECT * FROM `students` WHERE class_id = '{$class_id}' AND section_id = '{$section_id}';";

            if (empty( $result = $this->select($query) )) {
                return [];
            }

            $results = [];
            foreach ($result as $row) {
                $results[$row['id']] = $row['first_name'] . ' ' . $row['last_name'];
            }
            return $results;
        }
    
    function getStudentsBySection($section_id) {
        $fetchList = "SELECT * FROM `students` WHERE section_id = '{$section_id}';";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }
}
?>
