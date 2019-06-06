<?php
class User extends MySQLCN {

    function userLogin($data) {
        $qry = "SELECT * FROM users WHERE email_address = '{$data['email_address']}' AND password = md5('{$data['password']}')";
        $result = $this->select($qry);
        if ($result != NULL) {
                if($result[0]['user_role'] == '1') {
                    if($result[0]['email_verification'] == '0') {
                        return false;
                    }
                }
            $_SESSION['userId'] = $result[0]['id'];
            $_SESSION['name'] = $result[0]['first_name'].' '.$result[0]['last_name'];
            $_SESSION['email_address'] = $result[0]['email_address'];
            $_SESSION['user_role'] = $result[0]['user_role'];
            $_SESSION['last_login_timestamp'] = time();
            if($result[0]['user_role'] == '3' || $result[0]['user_role'] == '2') {
                $this->takeTeacherAttendance($result[0]['id']);
                $this->recordTeachersAttendance($result[0]['id']);
                return true;
            }
            return true;
        } else {
            return false;
        }
    }

    function userRegistration($data) {
        $result = $this->checkUserSignUp($data);
            if($result) {
                return false;
            }
        $qry = 'INSERT INTO `users` 
            (`first_name`,`last_name`,`email_address`, `password`, `user_role`) 
            VALUES ( "'. $data['first_name'] . '" , "'. $data['last_name'] . '" , "'. $data['email_address'] .'" , "'. md5($data['password']) .'" ,"1")';
        $userId = $this->insert($qry);
        if ($userId) {
            $send_email = $this->sendEmailVericationEmail($data,$userId);
            return true;
        } else {
            return false;
        }
    }


    function checkUserSignUp($data) {
        $qry = "SELECT * FROM users WHERE email_address = '{$data['email_address']}'";
        $dbObj = new MySQLCN();
        $result = $dbObj->select($qry);
        if ($result != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function sendEmailVericationEmail($result,$userId) {
        if (!empty($result)) {
                $to = $result['email_address'];
                $subject = "Sign up Email Verification";
            $txt = '
                  Hi '.$result['first_name'].',<br/><br/>
                  Please click on below link to verify your email address.<br/><br/>
                  <a href="'.BASE_ROOT.'employee/process/processUser.php?type=email_verification&userId='.base64_encode($userId).'">Link</a>
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


    function userEmailVerification($data) {
        $userId = base64_decode($data['userId']);
        $qry = "UPDATE `users` SET
              `email_verification` = '1'
               WHERE id = '{$userId}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function userForgetPassword($data) {
        $qry = "SELECT * FROM users WHERE email_address = '{$data['email_address']}' and user_role = '1' ";
        $result = $this->select($qry);
        if ($result != NULL) {

            $to = $result[0]['email_address'];
            $subject = "Forget Password!";
            $txt = '
                  Hi '.$result[0]['first_name'].',<br/><br/>
                  Please click on below link to reset your password.<br/><br/>
                  <a href="'.BASE_ROOT.'reset-password.php?userId='.base64_encode($result[0]['id']).'">Link</a>
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

    function userResetPassword($data) {
        $userId = base64_decode($data['userId']);
        $password = md5($data['password']);
        $qry = "UPDATE `users` SET
              `password` = '{$password}'
               WHERE id = '{$userId}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function takeTeacherAttendance($teacherId) {
        $todaysDate = date('Y-m-d');
        $teacher_id = $teacherId;
            $qry = "SELECT * FROM teachers_attendance WHERE teacher_id = '{$teacher_id}' and date_of_attendance = '{$todaysDate}' ";
            $dbObj = new MySQLCN();
            $result = $dbObj->select($qry);
        if ($result != NULL) {
            return true;
        } else {
            $qry1 = 'INSERT INTO `teachers_attendance` 
            (`teacher_id`,`date_of_attendance`) 
            VALUES ( "'. $teacher_id . '" , "'. $todaysDate . '")';
            $this->insert($qry1);
            return true;
        }
    }

    function recordTeachersAttendance($teacherId) {
        date_default_timezone_set('Asia/Kolkata');
        $expiryTime = "+".TEACHERS_EXPIRY_TIME." minutes";
        $loginTime = date('Y-m-d H:i:s');
        $logoutTime = date('Y-m-d H:i:s', strtotime($expiryTime));
        $qry = 'INSERT INTO `teachers_attendance_record` 
            (`teacher_id`,`login_time`,`logout_time`) 
            VALUES ( "'. $teacherId . '" , "'. $loginTime . '" , "'. $logoutTime . '")';
            $this->insert($qry);
            return true;
    }
}
?>