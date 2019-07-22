<?php
class FeeAmounts extends MySQLCN {

    function addFeeAmounts($data) {
        $qry = 'INSERT INTO `fee_amounts` 
            (`title`, `amount`) 
            VALUES ( "'. $data['title'] . '", "'. $data['amount'] . '")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getFeeAmountsLists() {
        $fetch = "SELECT *  FROM `fee_amounts`;";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getFeeAmountsInfo($id) {
        $fetch = "SELECT * FROM `fee_amounts` where fee_amounts.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteFeeAmounts($eId) {
        $qry = "DELETE FROM `fee_amounts` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function feeAmountInfoUpdate($data) {
        $feeAmountId = $data['feeAmountId'];
        $qry = "UPDATE `fee_amounts` SET
              `title` = '{$data['title']}',
              `amount` = '{$data['amount']}'
               WHERE id = '{$feeAmountId}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>