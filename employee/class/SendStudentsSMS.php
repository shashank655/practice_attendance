<?php
class SendStudentsSMS extends MySQLCN {

    function addStudentsInfo($data) {
        $qry = 'INSERT INTO `students_sms_listing` 
            (`student_name`,`fathers_name`,`mobile_number`) 
            VALUES ( "'. $data['student_name'] . '" , "'. $data['fathers_name'] . '" , "'. $data['mobile_number'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getSMSStudentsLists() {
        $fetch = "SELECT * FROM `students_sms_listing` order by student_name ASC";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getLeavesRequestsLists() {
        $fetch = "SELECT * FROM `leaves_request` join users on leaves_request.userId=users.id join leave_types on leaves_request.leave_type_id=leave_types.id order by leaves_request.id DESC";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function SendingSMS($data) {
        if($data['type'] == 'sending-sms') {
            foreach ($data['studentsID'] as $key => $value) {
                $fetch = "SELECT * FROM `students_sms_listing` where id='{$value}'";
                $fetch_data = $this->select($fetch);
                $phoneNumber = $fetch_data[0]['mobile_number'];
                // Get cURL resource
                    $curl = curl_init();
                    // Set some options - we are passing in a useragent too here
                    curl_setopt_array($curl, [
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'https://vsms.minavo.in/api/singlesms.php?auth_key=e7a1c23b0323cc6767bd547f4246c8d820180328124449&mobilenumber='.$phoneNumber.'&message=AdhyaySoftware&sid=Minavo&mtype=N'
                    ]);
                    // Send the request & save response to $resp
                    $resp = curl_exec($curl);
                    // Close request to clear up some resources
                    curl_close($curl);
            }
            return true;
        }
    }

    function getStudentInfo($id) {
        $fetch = "SELECT * FROM `students_sms_listing` where id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    } 

    function studentInfoUpdate($data) {
        $qry = "UPDATE `students_sms_listing` SET
              `student_name` = '{$data['student_name']}',
              `fathers_name` = '{$data['fathers_name']}',
              `mobile_number` = '{$data['mobile_number']}'
               WHERE id = '{$data['studentId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }   
}
?>