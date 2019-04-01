<?php
class MySQLCN {

    function MySQLCN() {
        $user = DB_USERNAME;
        $pass = DB_PASSWORD;
        $server = DB_SERVER;
        $dbase = DB_DATABASE;
        $conn = mysqli_connect($server, $user, $pass);
        if (!$conn) {
            $this->error("Connection attempt failed");
        }if (!mysqli_select_db($conn, $dbase)) {
            $this->error("Dbase Select failed");
        }
        $this->CONN = $conn;
        return true;
    }

    function close() {
        $conn = $this->CONN;
        $close = mysqli_close($conn);
        if (!$close) {
            $this->error("Connection close failed");
        }
        return true;
    }

    function error($text) {
        $conn = $this->CONN;
        $no = mysqli_errno($conn);
        $msg = mysqli_error($conn);
        exit;
    }
    
    function select($sql = "") {
        if (empty($sql)) {
            return false;
        }
        if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = @mysqli_query($conn, $sql);

        if ((!$results) or (empty($results))) {
            return false;
        }
        $count = 0;
        $data = array();
        while ($row = mysqli_fetch_array($results)) {
            /* echo "<br/>Row >>> <pre>";
              print_r($row);
              echo "</pre>"; */
            foreach ($row as $key => $value) {
                if (!is_array($value)) {
                    $row[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
                }
            }
            $data[$count] = $row;
            $count++;
        }
        /* echo "<br/>Full Data<pre>";
          print_r($data);
          echo "</pre>"; */
        mysqli_free_result($results);
        return $data;
    }

    function selectassoc($sql = "") {
        if (empty($sql)) {
            return false;
        }
        if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = @mysqli_query($conn, $sql);

        if ((!$results) or (empty($results))) {
            return false;
        }
        $count = 0;
        $data = array();
        while ($row = mysqli_fetch_assoc($results)) {
            /* echo "<br/>Row >>> <pre>";
              print_r($row);
              echo "</pre>"; */
            foreach ($row as $key => $value) {
                if (!is_array($value)) {
                    $row[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
                }
            }
            $data[$count] = $row;
            $count++;
        }
        /* echo "<br/>Full Data<pre>";
          print_r($data);
          echo "</pre>"; */
        mysqli_free_result($results);
        return $data;
    }
    function selectForJason($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $data = array();
        $results = @mysqli_query($conn, $sql);
        if ((!$results) or (empty($results))) {
            return $data;
        }
        $count = 0;
        while ($row = mysqli_fetch_assoc($results)) {
            foreach ($row as $key => $value) {
                if (!is_array($value)) {
                    $row[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
                }
            }
            $data[$count] = $row;
            $count++;
        }
        /* echo "<br/>Full Data<pre>";
          print_r($data);
          echo "</pre>"; */

        mysqli_free_result($results);
        return $data;
    }

    function newselect($sql = "") {
        if (empty($sql)) {
            return false;
        }if (!eregi("^select", $sql)) {
            echo "wrongquery<br>$sql<p>";
            echo "<H2>Wrong function silly!</H2>\n";
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = @mysqli_query($conn, $sql);
        if ((!$results) or (empty($results))) {
            return false;
        }
        $count = 0;
        $data = array();
        while ($row = mysqli_fetch_array($results)) {
            $data[$count] = $row;
            $count++;
        }
        mysqli_free_result($results);
        return $data;
    }

    function insert($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = mysqli_query($conn, $sql);

        if (!$results) {
            echo "Insert Operation Failed..<hr>" . mysqli_error($conn);
            $this->error("Insert Operation Failed..");
            $this->error("<H2>No results!</H2>\n");
            return false;
        }
        $id = mysqli_insert_id($this->CONN);
        return $id;
    }

    function updateData($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = mysqli_query($conn, $sql);

        if (!$results) {
            echo "Update Operation Failed..<hr>" . mysqli_error($conn);
            $this->error("Update Operation Failed..");
            $this->error("<H2>No results!</H2>\n");
            return false;
        }
        return $results;
    }
    
    function deleteData($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = mysqli_query($conn, $sql);

        if (!$results) {
            echo "Delete Operation Failed..<hr>" . mysqli_error($conn);
            $this->error("Delete Operation Failed..");
            $this->error("<H2>No results!</H2>\n");
            return false;
        }
        return $results;
    }

    function convertDate($temp) {
        return (substr($temp, 6, 4) . '-' . substr($temp, 0, 2) . '-' . substr($temp, 3, 2));
    }

    function printDate($temp) {
        if ($temp != NULL) {
            return (substr($temp, 5, 2) . '-' . substr($temp, 8, 2) . '-' . substr($temp, 0, 4));
        }
        return '';
    }

    function sql_query($sql = "") {
        if (empty($sql)) {
            return false;
        }if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;

        $results = mysqli_query($conn, $sql) or die("Query Failed..<hr>" . mysqli_error($conn));
        if (!$results) {
            $message = "Query went bad!";
            $this->error($message);
            return false;
        }
        //SHOW... commands return some results
        if (!(preg_match("/^select/i", $sql) || preg_match("/^show/i", $sql))) {
            return true;
        } else {
            $count = 0;
            $data = array();
            while ($row = mysqli_fetch_array($results)) {
                $data[$count] = $row;
                $count++;
            }
            mysqli_free_result($results);
            return $data;
        }
    }
    function send_mail($to,$fromEmail,$fromName,$subject,$message)
    {
        $logArr = array('Subject'=>$subject,'toEmail'=>$to,'fromEmail'=>$fromEmail ,'fromName'=>$fromName ,'emailException' => '');
        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
                
            
            $mail->IsSMTP();                           // tell the class to use SMTP
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->Port       = 25;                    // set the SMTP server port
            $mail->Host       = "smtpout.secureserver.net"; // SMTP server
            $mail->Username   = "reservation@shofur.com";     // SMTP server username
            $mail->Password   = "reservation2013";            // SMTP server password
        
            $mail->IsSendmail();  // tell the class to use Sendmail
        
            $mail->AddReplyTo("reservation@shofur.com","Shofur Reservation");
        
            $mail->From       = $fromEmail;
            $mail->FromName   = $fromName;
            
            $mail->Sender = "reservation@shofur.com";
            
            $mail->AddAddress($to);
        
            $mail->Subject  = $subject;
        
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
            // optional, comment out and test
        
            $mail->WordWrap   = 80; // set word wrap
        
            $mail->MsgHTML($message);
        
            $mail->IsHTML(true); // send as HTML
        
            $mail->Send();
            $systemLogEmail = array('operation' => 'Email Send', 'action' => 'Success', 'info' => urldecode(http_build_query($logArr, '', ', ')));
                systemLogEmail($systemLogEmail);
            //echo 'Message has been sent.';
        } catch (phpmailerException $e) {
            $logArr['emailException'] = $e->errorMessage();
            $systemLogEmail = array('operation' => 'Email Send', 'action' => 'Error', 'info' => urldecode(http_build_query($logArr, '', ', ')));
            systemLogEmail($systemLogEmail);
            echo "dbClass.php Error Sending Email ".$e->errorMessage();
        }
    }

    function realEscapeString($rawString) {
        $results = '';
        if (empty($this->CONN)) {
            return false;
        }
        $conn = $this->CONN;
        $results = mysqli_real_escape_string($conn, $rawString);
        return $results;
    }

//ends the class over here
}

?>