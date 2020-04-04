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
                        (`session_year_id`,`term_name`)
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

                $qryDel = "DELETE FROM `session_terms_details` WHERE session_year_id = '{$data['sessionId'] }'";
                $resDel = $this->deleteData($qryDel);

                foreach ($data['addTerm'] as $key => $value) {
                    if(!empty($data['sessionIds'][$key])) {
                        $qry2 = 'INSERT INTO `session_terms_details`
                            (`id`,`session_year_id`,`term_name`)
                        VALUES ("'. $data['sessionIds'][$key] . '","'. $data['sessionId'] . '", "'. $value . '")';
                        $res2 = $this->insert($qry2);

                    } else {
                        $qry3 = 'INSERT INTO `session_terms_details`
                            (`session_year_id`,`term_name`)
                        VALUES ("'. $data['sessionId'] . '", "'. $value . '")';
                        $res3 = $this->insert($qry3);
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function getSessionYearLists() {
        $fetch = "SELECT * FROM `session_terms`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getSessionTermList($sessionId) {
        $fetchSection = "SELECT * FROM `session_terms_details` where session_year_id='{$sessionId}' order by `term_name` asc";
        $fetch_section = $this->select($fetchSection);
        return $fetch_section;
    }

    function getSessionInfo($id){
        $fetch = "SELECT * from session_terms left join session_terms_details on session_terms.id=session_terms_details.session_year_id where session_terms.id='{$id}' ";
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

    function editSessionTerms($data) {
        $qry = 'INSERT INTO `edit_session_terms`
            (`session_year_id`,`session_term_id`,`class_id`,`section_id`)
            VALUES ( "'. $data['session_year_id'] . '","'. $data['session_term_id'] . '","'. $data['class_id'] . '","'. $data['section_id'] . '")';
        $res = $this->insert($qry);

            if(!empty($res)) {
                if(!empty($data['headName'])){
                    foreach ($data['headName'] as $key => $value) {
                            $qry2 = 'INSERT INTO `scholastic_heads_detail`
                                (`edit_session_term_id`,`headName`,`totalMarks`)
                            VALUES ("'. $res . '", "'. $value . '", "'. $data['totalMarks'][$key] . '")';
                        $res2 = $this->insert($qry2);
                    }
                } 

                if(!empty($data['subjectName'])){
                    foreach ($data['subjectName'] as $key1 => $value1) {
                            $qry3 = 'INSERT INTO `scholastic_subjects_detail`
                                (`edit_session_term_id`,`subjectName`)
                            VALUES ("'. $res . '", "'. $value1 . '")';
                        $res3 = $this->insert($qry3);
                    }
                }

                if(!empty($data['subjectCoSName'])){
                    foreach ($data['subjectCoSName'] as $key2 => $value2) {
                            $qry4 = 'INSERT INTO `co_scholastic_subjects_detail`
                                (`edit_session_term_id`,`subjectCoSName`)
                            VALUES ("'. $res . '", "'. $value2 . '")';
                        $res4 = $this->insert($qry4);
                    }
                }
                return true;
            }
    }

    function getSessionTermsInfo($session_year_id , $get_class_id , $get_section_id) {
        $fetch = "SELECT * FROM `session_terms_details` where session_terms_details.session_year_id='{$session_year_id}'";
        $fetch_data = $this->select($fetch);
        if(!empty($fetch_data)) {
            $termsInfo = array();
                foreach ($fetch_data as $key => $value) {
                    $fetch_term = "SELECT edit_session_terms.id as editSessionTermId FROM `edit_session_terms` where session_term_id='{$value['id']}' and class_id='{$get_class_id}' and section_id='{$get_section_id}'";
                    $fetch_data_term = $this->select($fetch_term);
                    $fetch_data_term[0]['term_name'] = $value['term_name'];
                        if(!empty($fetch_data_term)) {
                            $termsInfo['termId'][$value['id']] = $fetch_data_term[0];
                        }
                }
                //echo "<pre>";print_r($termsInfo);die;
            return $termsInfo;
        } else {
            return false;
        }
    }

    function gettingTermSubjectsLists($editSessionTermId) {
        $finalData = array();
        $fetch = "SELECT scholastic_heads_detail.id as headId, scholastic_heads_detail.headName, scholastic_heads_detail.totalMarks FROM `scholastic_heads_detail` where edit_session_term_id='{$editSessionTermId}'";
        $fetch_data = $this->select($fetch);

        $fetch_sub = "SELECT scholastic_subjects_detail.id as subjectId, scholastic_subjects_detail.subjectName FROM `scholastic_subjects_detail` where edit_session_term_id='{$editSessionTermId}'";
        $fetch_data_sub = $this->select($fetch_sub);

            $finalData['scholastic_heads'] = $fetch_data;
            $finalData['scholastic_subects'] = $fetch_data_sub;
        return $finalData;
    }

    function gettingCoScholasticSubjectsLists($editSessionTermId) {
        $fetch = "SELECT co_scholastic_subjects_detail.id as subjectId, co_scholastic_subjects_detail.subjectCoSName FROM `co_scholastic_subjects_detail` where edit_session_term_id='{$editSessionTermId}'";
        $fetch_data = $this->select($fetch);

        return $fetch_data;
    }

}
?>