<?php
class FeeGroups extends MySQLCN {

    function addFeeGroup($data) {
        $qry = 'INSERT INTO `fee_groups` 
            (`title`, `class_id`, `section_id`) 
            VALUES ( "'. $data['title'] . '",  "'. $data['class_id'] . '",  "'. $data['section_id'] . '")';
        $res = $this->insert($qry);
        $last_id = mysqli_insert_id($this->CONN);
        foreach ($data['fee_amount_ids'] as $fee_amount_id) {
            $qry2 = 'INSERT INTO `fee_group_fees` (`fee_group_id`, `fee_amount_id`) VALUES ("'.$last_id.'", "'.$fee_amount_id.'")';
            $res2 = $this->insert($qry2);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function addFeeGroupTab2($data) {
        $qry = 'INSERT INTO `fee_groups` 
            (`title`, `fee_class_group_id`) 
            VALUES ( "'. $data['title'] . '",  "'. $data['fee_class_group_id'] . '")';
        $res = $this->insert($qry);
        $last_id = mysqli_insert_id($this->CONN);
        foreach ($data['fee_amount_ids'] as $fee_amount_id) {
            $qry2 = 'INSERT INTO `fee_group_fees` (`fee_group_id`, `fee_amount_id`) VALUES ("'.$last_id.'", "'.$fee_amount_id.'")';
            $res2 = $this->insert($qry2);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getFeeGroupsLists() {
        $fetch = "SELECT `fee_groups`.`id`, `fee_groups`.`title`, `fee_groups`.`class_id`, `fee_groups`.`section_id`, `fee_groups`.`fee_class_group_id`, `fee_groups`.`created_at`, `classes_name`.`class_name`, `sections`.`section_name`, `fee_class_groups`.`title` as `fee_class_group_title` FROM `fee_groups` LEFT JOIN `classes_name` ON `fee_groups`.`class_id`=`classes_name`.`id` LEFT JOIN `sections` ON `fee_groups`.`section_id`=`sections`.`id` LEFT JOIN `fee_class_groups` ON `fee_class_groups`.`id`=`fee_groups`.`fee_class_group_id`;";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }
    
    function getFeeGroups($class_id, $section_id) {
        $fetch = "SELECT * FROM `fee_groups` WHERE ( `fee_groups`.`class_id` = '{$class_id}' AND `fee_groups`.`section_id` = '{$section_id}' ) OR EXISTS ( SELECT * FROM `fee_class_group_classes` WHERE `fee_class_group_classes`.`fee_class_group_id` = `fee_groups`.`fee_class_group_id` AND `fee_class_group_classes`.`section_id` = '{$section_id}' );";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getClasses($id) {
        $sql = 'SELECT `fee_class_group_classes`.`class_id`, `classes_name`.`class_name` FROM `fee_class_group_classes` LEFT JOIN `classes_name` ON `classes_name`.`id` = `fee_class_group_classes`.`class_id` WHERE `fee_class_group_id`="'.$id.'"';
        $fetch = $this->select($sql);
        return $fetch;
    }

    function getFeeGroupFees($id) {
        $sql = 'SELECT `fee_group_fees`.`id`, `fee_group_fees`.`fee_group_id`, `fee_group_fees`.`fee_amount_id`, `fee_group_fees`.`created_at`, `fee_amounts`.`amount`, `fee_amounts`.`title` FROM `fee_group_fees` LEFT JOIN fee_amounts ON fee_amounts.id=fee_group_fees.fee_amount_id WHERE `fee_group_fees`.`fee_group_id`="'.$id.'"';
        $fetch = $this->select($sql);
        return $fetch;
    }

    function getFeeGroupsInfo($id) {
        $fetch = "SELECT * FROM `fee_groups` where fee_groups.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteFeeGroups($eId) {
        $qry1 = "DELETE FROM `fee_group_fees` WHERE fee_group_id = '{$eId}'";
        $res1 = $this->deleteData($qry1);
        $qry = "DELETE FROM `fee_groups` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function feeGroupInfoUpdate($data) {
        $feeId = $data['feeId'];
        $qry = "UPDATE `fee_groups` SET
              `title` = '{$data['title']}',
              `class_id`='{$data['class_id']}',
              `section_id`='{$data['section_id']}'
               WHERE id = '{$feeId}'";
        $res = $this->updateData($qry);
        $qry1 = "DELETE FROM `fee_group_fees` WHERE fee_group_id = '{$feeId}'";
        $res1 = $this->deleteData($qry1);
        foreach ($data['fee_amount_ids'] as $fee_amount_id) {
            $qry2 = 'INSERT INTO `fee_group_fees` (`fee_group_id`, `fee_amount_id`) VALUES ("'.$feeId.'", "'.$fee_amount_id.'")';
            $res2 = $this->insert($qry2);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
    function feeGroupInfoUpdateTab2($data) {
        $feeId = $data['feeId'];
        $qry = "UPDATE `fee_groups` SET
              `title` = '{$data['title']}',
              `fee_class_group_id`='{$data['fee_class_group_id']}'
               WHERE id = '{$feeId}'";
        $res = $this->updateData($qry);
        $qry1 = "DELETE FROM `fee_group_fees` WHERE fee_group_id = '{$feeId}'";
        $res1 = $this->deleteData($qry1);
        foreach ($data['fee_amount_ids'] as $fee_amount_id) {
            $qry2 = 'INSERT INTO `fee_group_fees` (`fee_group_id`, `fee_amount_id`) VALUES ("'.$feeId.'", "'.$fee_amount_id.'")';
            $res2 = $this->insert($qry2);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function calculateDiscount($particular_id, $fee_amount_id, $amount) {
        $sql = "SELECT * FROM `particular_fee_discounts` WHERE `particular_id`='{$particular_id}' AND `fee_amount_id`='{$fee_amount_id}'";
        $fetch = $this->select($sql);
        $discount = 0;
        if (count($fetch) > 0) {
            if ($fetch[0]['discount_type'] == 'Percentage') {
                $discount = ($amount*$fetch[0]['discount_amount'])/100;
            }
            if ($fetch[0]['discount_type'] == 'Fixed') {
                $discount = $fetch[0]['discount_amount'];
            }
        }
        return $discount;
    }

    function getFeeGroupsBySection($section_id) {
        $fetch = "SELECT * FROM `fee_groups` where fee_groups.section_id='{$section_id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }
}
?>