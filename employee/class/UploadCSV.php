<?php
class UploadCSV extends MySQLCN {

    function UploadStudentRecordCSV($data) {
        if($_FILES['CsvData']['name']){
            $arrFileName = explode('.',$_FILES['CsvData']['name']);
            if($arrFileName[1] != 'csv'){
                $_SESSION['Msg'] = "Please upload only CSV extentions files. ";
                header('Location: ' . BASE_ROOT.'upload-student-csv.php');
            }
            /* File Upload */
            $csv_file = $_FILES['CsvData'];
                if(!empty($csv_file['name'])){
                    $imagename=$csv_file['name'];
                    $cscName = strtolower(basename($imagename));
                    $target = GALLERY_UPLOADS_ROOT . $cscName;
                    move_uploaded_file($csv_file['tmp_name'], $target);    
                    }
                /* File Upload */
                    $handle = fopen(GALLERY_UPLOADS_PATH.$cscName, "r");
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            echo "<pre>";print_r($data);
                            $item = array();
                            if($data[0] == 'S.No.' || $data[1] == 'FirstName' || $data[1] == 'LastName'){
                                continue;
                            }

                            if(!empty($data[3])) {
                                $checkStudent = $this->checkStudentSignUp($data[3]);
                                if($checkStudent) {
                                    continue;
                                } else {
                                    $qry = 'INSERT INTO `students` 
            (`first_name`,`last_name`,`email_address`, `gender`,`dob`,`religion`,`date_of_joining`,`mobile_number`,`admission_no`,`roll_number`,`fathers_name`,`parents_mobile_number`,`present_address`,`permanent_address`) 
            VALUES ( "'. $data[1] . '", "'. $data[2] . '", "'. $data[3] .'" , "'. $data[4] .'" ,"'. $data[5].'" ,"'. $data[6].'" ,"'. $data[7].'" ,"'. $data[8].'" ,"'. $data[9].'" ,"'. $data[10].'" ,"'. $data[11].'" ,"'. $data[12].'" ,"'. $data[13].'" ,"'. $data[14].'")';
                $res = $this->insert($qry);
             }
                } else {
                    continue;
                }   
            }    
            return true;
                fclose($handle);
            }
        }

        function checkStudentSignUp($emailAddress) {
            $qry = "SELECT * FROM students WHERE email_address = '{$emailAddress}'";
            $result = $this->select($qry);
            if ($result != NULL) {
                return true;
            } else {
                return false;
        }
    }
}
?>