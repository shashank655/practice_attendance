<?php
class FeeTypes extends MySQLCN {

    function addFeeTypes($data) {
        $qry = 'INSERT INTO `fee_types` 
            (`name`, `class_id`, `section_id`, `fee`) 
            VALUES ( "'. $data['name'] . '", "'. $data['class_id'] .'", "'. $data['section_id'] .'", "'. $data['fee'] .'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getFeeTypesLists() {
        $fetch = "SELECT fee_types.id, fee_types.name, fee_types.class_id, fee_types.section_id, fee_types.fee, fee_types.created_at, fee_types.updated_at, classes_name.class_name, sections.section_name  FROM `fee_types` LEFT JOIN classes_name ON fee_types.class_id=classes_name.id LEFT JOIN sections ON fee_types.section_id=sections.id;";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getFeeTypesInfo($id) {
        $fetch = "SELECT * FROM `fee_types` where fee_types.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteFeeTypes($eId) {
        $qry = "DELETE FROM `fee_types` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function feeTypeInfoUpdate($data) {
        $feeTypeId = $data['feeTypeId'];
        $qry = "UPDATE `fee_types` SET
              `name` = '{$data['name']}', `class_id` = '{$data['class_id']}', `section_id` = '{$data['section_id']}', `fee` = '{$data['fee']}'
               WHERE id = '{$feeTypeId}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>