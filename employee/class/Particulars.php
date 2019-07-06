<?php
class Particulars extends MySQLCN {

    function addParticular($data) {
        $qry = 'INSERT INTO `particulars` 
            (`title`) 
            VALUES ( "'. $data['title'] . '")';
        $res = $this->insert($qry);
        $last_id = mysqli_insert_id($this->CONN);
        foreach ($data['fee_amount_ids'] as $key => $fee_amount_id) {
            $qry2 = 'INSERT INTO `particular_fee_discounts` (`particular_id`, `fee_amount_id`, `discount_type`, `discount_amount`) VALUES ("'.$last_id.'", "'.$fee_amount_id.'", "'.$data['discount_type'][$key].'", "'.$data['discount_amount'][$key].'")';
            $res2 = $this->insert($qry2);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getParticularsLists() {
        $fetch = "SELECT * FROM `particulars`";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getParticularFeeDiscounts($id) {
        $sql = 'SELECT `particular_fee_discounts`.`id`, `particular_fee_discounts`.`particular_id`, `particular_fee_discounts`.`fee_amount_id`, `particular_fee_discounts`.`discount_type`, `particular_fee_discounts`.`discount_amount`, `fee_amounts`.`amount`, `fee_amounts`.`title` FROM `particular_fee_discounts` LEFT JOIN fee_amounts ON fee_amounts.id=particular_fee_discounts.fee_amount_id WHERE `particular_fee_discounts`.`particular_id`="'.$id.'"';
        $fetch = $this->select($sql);
        return $fetch;
    }

    function getParticularsInfo($id) {
        $fetch = "SELECT * FROM `particulars` where particulars.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteParticulars($eId) {
        $qry1 = "DELETE FROM `particular_fee_discounts` WHERE particular_id = '{$eId}'";
        $res1 = $this->deleteData($qry1);
        $qry = "DELETE FROM `particulars` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function particularInfoUpdate($data) {
        
        $feeId = $data['feeId'];
        $qry = "UPDATE `particulars` SET
              `title` = '{$data['title']}'
               WHERE id = '{$feeId}'";
        $res = $this->updateData($qry);
        $qry1 = "DELETE FROM `particular_fee_discounts` WHERE particular_id = '{$feeId}'";
        $res1 = $this->deleteData($qry1);
        foreach ($data['fee_amount_ids'] as $key => $fee_amount_id) {
            $qry2 = 'INSERT INTO `particular_fee_discounts` (`particular_id`, `fee_amount_id`, `discount_type`, `discount_amount`) VALUES ("'.$feeId.'", "'.$fee_amount_id.'", "'.$data['discount_type'][$key].'", "'.$data['discount_amount'][$key].'")';
            $res2 = $this->insert($qry2);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>