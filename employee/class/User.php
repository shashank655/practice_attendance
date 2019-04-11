<?php
class User extends MySQLCN {

    function userLogin($data) {
        $qry = "SELECT * FROM users WHERE email_address = '{$data['email_address']}' AND password = md5('{$data['password']}')";
        $result = $this->select($qry);
        if ($result != NULL) {
            $_SESSION['userId'] = $result[0]['id'];
            $_SESSION['name'] = $result[0]['first_name'].' '.$result[0]['last_name'];
            $_SESSION['email_address'] = $result[0]['email_address'];
            $_SESSION['user_role'] = $result[0]['user_role'];
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
        $res = $this->insert($qry);
        if ($res) {
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
}
?>