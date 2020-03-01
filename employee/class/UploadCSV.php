<?php
class UploadCSV extends MySQLCN {

    function UploadStudentRecordCSV($data) {
        if($_FILES['CsvData']['name']){
            $arrFileName = explode('.',$_FILES['CsvData']['name']);
            if($arrFileName[1] != 'csv'){
                $_SESSION['Msg'] = "Please upload only CSV extentions files. ";
                header('Location: ' . BASE_ROOT.'upload-student-csv.php');
            } else {
            /* File Upload */
            $csv_file = $_FILES['CsvData'];
                if(!empty($csv_file['name'])){
                    $imagename=$csv_file['name'];
                    $target = UPLOAD_CSV_ROOT . $imagename;
                    move_uploaded_file($_FILES['CsvData']['tmp_name'], $target);
                }
                /* File Upload */
                    $handle = fopen(UPLOAD_CSV_PATH.$imagename, "r");
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $item = array();
                            if($data[0] == 'S.No.' || $data[1] == 'FirstName' || $data[1] == 'LastName'){
                                continue;
                            }

                            if(!empty($data[8])) {
                                $checkStudent = $this->checkAdmissionNoExist($data[8]);
                                if($checkStudent) {
                                    continue;
                                } else {

                             $getClassSectionId = $this->gettingClassSectionId($data[6] , $data[7]); 
                             if(!empty($getClassSectionId['class_id']) && !empty($getClassSectionId['section_id'])) {
                                $classId = $getClassSectionId['class_id'];
                                $sectionId = $getClassSectionId['section_id'];
                             } else {
                                $classId = '';
                                $sectionId = '';
                             }     

                $qry = 'INSERT INTO `students` 
            (`first_name`,`last_name`,`gender`,`date_of_joining`,`dob`,`class_id`,`section_id`,`admission_no`,`roll_number`,`religion`,`fathers_name`,`parents_mobile_number`,`fathers_occupation`,`parents_email_address`,`mothers_name`,`nationality`,`present_address`,`permanent_address`) 
            VALUES ( "'. $data[1] . '", "'. $data[2] . '", "'. $data[3] .'" , "'. $data[4] .'" ,"'. $data[5].'" ,"'.$classId.'" ,"'.$sectionId.'" ,"'. $data[8].'" ,"'. $data[9].'" ,"'. $data[10].'" ,"'. $data[11].'" ,"'. $data[12].'" ,"'. $data[13].'" ,"'. $data[14].'" ,"'. $data[15].'" ,"'. $data[16].'" ,"'. $data[17].'","'. $data[18].'")';
                $res = $this->insert($qry);
             }
                } else {
                    continue;
                }   
            }    
            unlink(UPLOAD_CSV_PATH.$imagename);
            return true;
                fclose($handle);
            }
        }
    }

        function checkAdmissionNoExist($admissionNo) {
            $qry = "SELECT * FROM students WHERE admission_no = '{$admissionNo}'";
            $result = $this->select($qry);
            if ($result != NULL) {
                return true;
            } else {
                return false;
            }
        }
        function getCSVStudentsListing() {
            $fetchList = "SELECT * FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id order by `first_name` asc";
            $fetch_list = $this->select($fetchList);
            return $fetch_list;
        }

        function gettingClassSectionId($className , $sectionName)
        {   
            $classSec = array();
            if(!empty($className) && !empty($sectionName) ) {
                $fetchClass = "SELECT id FROM `classes_name` WHERE class_name = '{$className}' ";
                $fetch_class = $this->select($fetchClass);
                if(!empty($fetch_class)){
                    $classSec['class_id'] = $fetch_class[0]['id'];

                    $fetchSection = "SELECT id FROM `sections` WHERE class_id = '{$fetch_class[0]['id']}' and section_name = '{$sectionName}' ";
                    $fetch_section = $this->select($fetchSection);

                    if(!empty($fetch_section)) {
                        $classSec['section_id'] = $fetch_section[0]['id'];
                    }
                }

                return $classSec;
            }   
        }
    }
?>