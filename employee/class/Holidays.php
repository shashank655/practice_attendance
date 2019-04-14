<?php
class Holidays extends MySQLCN {

    function AddHoliday($data) {

        $qry = 'INSERT INTO `holidays` 
            (`holiday_name`,`holiday_date`) 
            VALUES ( "'. $data['holiday_name'] . '", "'. $data['holiday_date'] . '")';
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
              `section_id` = '0',
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

    function getHolidaysList() {
        $fetch = "SELECT * FROM `holidays` order by `holiday_date` asc ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function DeleteHoliday($HId) {
        $qry = "DELETE FROM `holidays` WHERE id = '{$HId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }    
}
?>