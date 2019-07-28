<?php
class SendingSMS extends MySQLCN {

    function sendSMS($data) {
    $phoneNumber = $data['phone_number'];
    $holidayName = $data['holiday_name'];
    $holidayDate = $data['holiday_date'];
    $textSMS = $holidayName.''.$holidayDate;

    $curl = curl_init();    
        curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://vsms.minavo.in/api/singlesms.php?auth_key=e7a1c23b0323cc6767bd547f4246c8d820180328124449&mobilenumber='.$phoneNumber.'&message='.$textSMS.'&sid=Minavo&mtype=N'
    ]);
    $resp = curl_exec($curl);
    $result = json_decode($resp);
        if($result->status == 'success') {
            return true;
        } else {
            return false;
        }
    curl_close($curl);  
    } 
}
?>