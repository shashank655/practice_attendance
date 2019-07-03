<?php
class Admissions extends MySQLCN {

    
    function addAdmissions($data,$files) {
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
  
        $qry = 'INSERT INTO `admissions` 
            (`first_name`,`last_name`,`email_address`, `gender`, `dob`,`class_id`,`section_id`,`religion`,`date_of_joining`,`mobile_number`,`fathers_name`,`fathers_occupation`,`parents_mobile_number`,`present_address`,`mothers_name`,`mothers_occupation`,`nationality`,`permanent_address`,`student_profile_image`,`parents_profile_image`, `admission_fee`) 
            VALUES ( "'. $data['first_name'] . '", "'. $data['last_name'] . '", "'. $data['email_address'] .'" , "'. $data['gender'] .'" ,"'. $data['dob'].'" ,"'. $data['class_id'].'" ,"'. $data['section_id'].'" ,"'. $data['religion'].'" ,"'. $data['date_of_joining'].'" ,"'. $data['mobile_number'].'" ,"'. $data['fathers_name'].'" ,"'. $data['fathers_occupation'].'" ,"'. $data['parents_mobile_number'].'","'. $data['present_address'].'","'. $data['mothers_name'].'","'. $data['mothers_occupation'].'" ,"'. $data['nationality'].'" ,"'. $data['permanent_address'].'" ,"'.$studentProfileImageName.'" ,"'.$parentsProfileImageName.'", "'. $data['admission_fee'] .'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function admissionInfoUpdate($data,$files) {

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

        $qry = "UPDATE `admissions` SET
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
              `fathers_name` = '{$data['fathers_name']}',
              `fathers_occupation` = '{$data['fathers_occupation']}',
              `parents_mobile_number` = '{$data['parents_mobile_number']}',
              `present_address` = '{$data['present_address']}',
              `mothers_name` = '{$data['mothers_name']}',
              `mothers_occupation` = '{$data['mothers_occupation']}',
              `nationality` = '{$data['nationality']}',
              `permanent_address` = '{$data['permanent_address']}',
              `student_profile_image` = '{$studentProfileImageName}',
              `parents_profile_image` = '{$parentsProfileImageName}',
              `admission_fee`         = '{$data['admission_fee']}'
               WHERE id = '{$data['admissionId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getAdmissionInfo($id) {
        $fetch = "SELECT * FROM `admissions` join classes_name on admissions.class_id=classes_name.id join sections on admissions.section_id=sections.id where admissions.id ='" . $id . "'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function deleteAdmission($sId) {
        $qry = "DELETE FROM `admissions` WHERE id = '{$sId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getAllAdmissions() {
        $fetchList = "SELECT admissions.id, admissions.first_name, admissions.last_name, admissions.email_address, admissions.gender, admissions.dob, admissions.class_id, admissions.section_id, admissions.religion, admissions.date_of_joining, admissions.mobile_number, admissions.fathers_name, admissions.fathers_occupation, admissions.parents_mobile_number, admissions.present_address, admissions.mothers_name, admissions.mothers_occupation, admissions.nationality, admissions.permanent_address, admissions.student_profile_image, admissions.parents_profile_image, admissions.admission_fee, admissions.created_at, admissions.admission_fee, classes_name.class_name, sections.section_name FROM admissions join classes_name on admissions.class_id=classes_name.id join sections on admissions.section_id=sections.id";
        $fetch_list = $this->select($fetchList);
        return $fetch_list;
    }    
}
?>