<?php
class SessionTerms extends MySQLCN {

    function addSessionTerm($data) {
        $result = $this->checkExists($data);
        if($result) {
            return false;
        }

        $qry = 'INSERT INTO `session_terms`
            (`session_year`)
            VALUES ( "'. $data['session_year'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            if(!empty($data['addTerm'])){
                foreach ($data['addTerm'] as $key => $value) {
                    $qry2 = 'INSERT INTO `session_terms_details`
                        (`session_term_id`,`term_name`)
                    VALUES ("'. $res . '", "'. $value . '")';
                    $res2 = $this->insert($qry2);
                }
            }
            return true;
        } else {
            return false;
        }
    }

     function sessionTermInfoUpdate($data){
        $qry = "UPDATE `session_terms` SET
              `session_year` = '{$data['session_year']}'
               WHERE id = '{$data['sessionId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            if(!empty($data['addTerm'])){
                foreach ($data['addTerm'] as $key => $value) {
                    if(!empty($data['addTerm'][$key])) {
                        $qry2 = "UPDATE `session_terms_details` SET `term_name` = '{$value}' WHERE id = '{$data['sessionIds'][$key]}'";
                        $res2 = $this->updateData($qry2);
                    } else {
                        $qry4 = 'INSERT INTO `session_terms_details`
                            (`session_term_id`,`term_name`)
                        VALUES ("'. $data['sessionId'] . '", "'. $value . '")';
                        $res4 = $this->insert($qry4);
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function getSessionTermLists() {
        $fetch = "SELECT * FROM `session_terms`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getSessionInfo($id){
        $fetch = "SELECT * from session_terms left join session_terms_details on session_terms.id=session_terms_details.session_term_id where session_terms.id='{$id}' ";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function checkExists($data) {
        $fetch = "SELECT id FROM `session_terms` where session_year='{$data['session_year']}' ";
        $fetch_data = $this->select($fetch);
        if ($fetch_data != NULL) {
            return true;
        } else {
            return false;
        }
    }

    function getSubjectInfo($id) {
        $fetch = "SELECT * FROM `subjects` where id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteSession($sId) {
        $qry = "DELETE FROM `session_terms` WHERE id = '{$sId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function subjectInfoUpdate($data) {
        $qry = "UPDATE `subjects` SET
              `subject_name` = '{$data['subject_name']}'
               WHERE id = '{$data['subjectId']}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>