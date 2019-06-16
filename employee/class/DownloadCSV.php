<?php
class DownloadCSV extends MySQLCN {

    function DownloadStudentRecordCSV($data) {
        $sWhere = "WHERE 1=1";
        if(!empty($data['class_id_csv']) && !empty($data['section_id_csv'])) {
            $sWhere = $sWhere." And students.class_id='".$data['class_id_csv']."' and students.section_id='".$data['section_id_csv']."'";
        }
        $fetchList = "SELECT * FROM `students` join classes_name on students.class_id=classes_name.id join sections on students.section_id=sections.id $sWhere order by `first_name` asc";
        $fetch_list = $this->select($fetchList);  
        $students_data = array();
        foreach ($fetch_list as $key => $value) {
            $students_data[$key]['FirstName'] = $value['first_name'];
            $students_data[$key]['LastName'] = $value['last_name'];
            $students_data[$key]['Email Address'] = $value['email_address'];
            $students_data[$key]['Gender'] = $value['gender'];
            $students_data[$key]['DOB'] = $value['dob'];
            $students_data[$key]['Class'] = $value['class_name'];
            $students_data[$key]['Section'] = $value['section_name'];
            $students_data[$key]['Religion'] = $value['religion'];
            $students_data[$key]['Date of Joining'] = $value['date_of_joining'];
            $students_data[$key]['Mobile Number'] = $value['mobile_number'];
            $students_data[$key]['Religion'] = $value['religion'];
            $students_data[$key]['Admission No'] = $value['admission_no'];
            $students_data[$key]['Roll Number'] = $value['roll_number'];
            $students_data[$key]['Fathers Name'] = $value['fathers_name'];
            $students_data[$key]['Fathers Mobile Number'] = $value['parents_mobile_number'];
            $students_data[$key]['Present Address'] = $value['present_address'];
            $students_data[$key]['Permanent Address'] = $value['permanent_address'];
        }

        $fileName_1 = 'students_record.csv';
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Description: File Transfer');
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename={$fileName_1}");
            header("Expires: 0");
            header("Pragma: public");
            $fh1 = @fopen( 'php://output', 'w' );
            $headerDisplayed1 = false;
                foreach ( $students_data as $data1 ) {
                    // Add a header row if it hasn't been added yet
                    if ( !$headerDisplayed1 ) {
                        // Use the keys from $data as the titles
                        fputcsv($fh1, array_keys($data1));
                        $headerDisplayed1 = true;
                    }
                    // Put the data into the stream
                    fputcsv($fh1, $data1);
                }
            // Close the file
            fclose($fh1);
            // Make sure nothing else is sent, our file is done
        exit;    
    }

    function DownloadTeachersRecordCSV() {
        $fetch = "SELECT * FROM `users` join teachers on users.id =teachers.user_id ";
        $fetch_list = $this->select($fetch);;

        $teachers_data = array();
        foreach ($fetch_list as $key => $value) {
            $teachers_data[$key]['FirstName'] = $value['first_name'];
            $teachers_data[$key]['LastName'] = $value['last_name'];
            $teachers_data[$key]['Email Address'] = $value['email_address'];
            $teachers_data[$key]['Gender'] = $value['gender'];
            $teachers_data[$key]['DOB'] = $value['dob'];
            $teachers_data[$key]['Date of Joining'] = $value['joining_date'];
            $teachers_data[$key]['Mobile Number'] = $value['mobile_number'];
            $teachers_data[$key]['Permanent Address'] = $value['permanent_address'];
        }

        $fileName_1 = 'teachers_record.csv';
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Description: File Transfer');
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename={$fileName_1}");
            header("Expires: 0");
            header("Pragma: public");
            $fh1 = @fopen( 'php://output', 'w' );
            $headerDisplayed1 = false;
                foreach ( $teachers_data as $data1 ) {
                    // Add a header row if it hasn't been added yet
                    if ( !$headerDisplayed1 ) {
                        // Use the keys from $data as the titles
                        fputcsv($fh1, array_keys($data1));
                        $headerDisplayed1 = true;
                    }
                    // Put the data into the stream
                    fputcsv($fh1, $data1);
                }
            // Close the file
            fclose($fh1);
            // Make sure nothing else is sent, our file is done
        exit;    
    }
}
?>