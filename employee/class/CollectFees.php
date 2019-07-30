<?php
class CollectFees extends MySQLCN {

    function submitFees($data) {
        $qry = 'INSERT INTO `collect_fees`(`paid_fee`, `collected_by`, `payment_mode`, `comment`, `fee_paying_mode`,  `class_id`, `section_id`, `student_id`, `fee_group_id`, `from_month_id`, `to_month_id`) VALUES ("'.$data['paid_fee'].'", "'.$data['collected_by'].'", "'.$data['payment_mode'].'", "'.$data['comment'].'", "'.$data['fee_paying_mode'].'", "'.$data['class_id'].'", "'.$data['section_id'].'", "'.$data['student_id'].'", "'.$data['fee_group_id'].'", "'.$data['from_month_id'].'", "'.$data['to_month_id'].'")';
        $res = $this->insert($qry);
        $last_id = mysqli_insert_id($this->CONN);
        if ($res) {
            $qry2 = 'INSERT INTO `due_amounts`(`collect_fee_id`, `month_id`, `due_fee`, `due_date`) VALUES ("'.$last_id.'", "'.$data['month_id'].'", "'.$data['due_fee'].'", "'.$data['due_date'].'")';
            $res2 = $this->insert($qry2);
            
            return $last_id;
        } else {
            return false;
        }
    }

    function submitCollectFeeDetails($amount, $last_id, $discount) {
        $qry3 = 'INSERT INTO `collect_fee_details`(`collect_fee_id`, `fee_title`, `fee_amount`, `fee_discount`) VALUES ("'.$last_id.'", "'.$amount['title'].'", "'.$amount['amount'].'", "'.$discount.'")';
        $result = $this->insert($qry3);
        return true;
    }

    function getCollectFees() {
        $qry = 'SELECT `collect_fees`.`id`, `collect_fees`.`paid_fee`, `collect_fees`.`collected_by`, `collect_fees`.`payment_mode`, `collect_fees`.`comment`, `classes_name`.`class_name`, `sections`.`section_name`, `students`.`first_name`, `students`.`last_name`, `fee_groups`.`title`, `collect_fees`.`created_at`, `due_amounts`.`due_fee` FROM `collect_fees` LEFT JOIN `classes_name` ON `classes_name`.`id`=`collect_fees`.`class_id` LEFT JOIN `sections` ON `sections`.`id`=`collect_fees`.`section_id` LEFT JOIN `students` ON `students`.`id`=`collect_fees`.`student_id` LEFT JOIN `fee_groups` ON `fee_groups`.`id`=`collect_fees`.`fee_group_id` LEFT JOIN `due_amounts` ON `due_amounts`.`collect_fee_id`=`collect_fees`.`id`;';
        $collect_fees_data = $this->select($qry);
        return $collect_fees_data;
    }

    function getCollectFeeInfo($id) {
        $qry = 'SELECT * FROM `collect_fees` WHERE `id` = "'.$id.'";';
        $collect_fees_data = $this->select($qry);
        return $collect_fees_data;
    }

    function getCollectFeesBy($feeAmount = '', $feePayingMode = '', $from_date = '', $to_date = '') {
        $qry = 'SELECT `collect_fees`.`id`, `collect_fees`.`paid_fee`, `collect_fees`.`collected_by`, `collect_fees`.`payment_mode`, `collect_fees`.`comment`, `classes_name`.`class_name`, `sections`.`section_name`, `students`.`first_name`, `students`.`last_name`, `fee_groups`.`title`, `collect_fees`.`created_at`, `due_amounts`.`due_fee` FROM `collect_fees` LEFT JOIN `classes_name` ON `classes_name`.`id`=`collect_fees`.`class_id` LEFT JOIN `sections` ON `sections`.`id`=`collect_fees`.`section_id` LEFT JOIN `students` ON `students`.`id`=`collect_fees`.`student_id` LEFT JOIN `fee_groups` ON `fee_groups`.`id`=`collect_fees`.`fee_group_id` LEFT JOIN `due_amounts` ON `due_amounts`.`collect_fee_id`=`collect_fees`.`id`';
        $where = [];
        if ($feeAmount != '') {
            $where[] = ' EXISTS (SELECT * FROM `collect_fee_details` WHERE `collect_fees`.`id` = `collect_fee_details`.`collect_fee_id` AND `collect_fee_details`.`fee_title`="'.$feeAmount.'")';
        }
        if ($feePayingMode != '') {
            $where[] = '`collect_fees`.`fee_paying_mode`="'.$feePayingMode.'"';
        }
        if ($from_date != '') {
            $date=strtotime(str_replace('/', '-', $from_date));
            $from_date = date("Y-m-d", $date);
            $where[] = '`collect_fees`.`created_at`>="'.$from_date.'"';
        }
        if ($to_date != '') {
            $date=strtotime(str_replace('/', '-', $to_date));
            $to_date = date("Y-m-d", $date);
            $where[] = '`collect_fees`.`created_at`<="'.$to_date.'"';
        }
        $qry .= " WHERE " . implode(' AND ', $where);
        
        $collect_fees_data = $this->select($qry);
        return $collect_fees_data;
    }

    function getDueAmount($collect_fee_id) {
        $qry = 'SELECT `due_fee`, `due_date` FROM `due_amounts` WHERE `collect_fee_id` = "'.$collect_fee_id.'";';
        $collect_fees_data = $this->select($qry);
        return $collect_fees_data;
    }

    
    function updateFees($data) {
        $qry = 'UPDATE `collect_fees` SET `paid_fee`="'.$data['paid_fee'].'", `collected_by`="'.$data['collected_by'].'", `payment_mode`="'.$data['payment_mode'].'", `comment`="'.$data['comment'].'", `fee_paying_mode`="'.$data['fee_paying_mode'].'", `class_id`="'.$data['class_id'].'", `section_id`="'.$data['section_id'].'", `student_id`="'.$data['student_id'].'", `fee_group_id`="'.$data['fee_group_id'].'", `from_month_id`="'.$data['from_month_id'].'" , `to_month_id`="'.$data['to_month_id'].'" WHERE `id`="'.$data['feeCollectId'].'"';
        $res = $this->updateData($qry);
        if ($res) {
            $qry2 = 'UPDATE `due_amounts` SET `month_id`="'.$data['month_id'].'", `due_fee`="'.$data['due_fee'].'",`due_date`="'.$data['due_date'].'" WHERE `collect_fee_id`="'.$data['feeCollectId'].'"';
            $res2 = $this->updateData($qry2);
            return true;
        } else {
            return false;
        }
    }

    function updateCollectFeeDetails($amount, $last_id, $discount) {
        $qry3 = 'INSERT INTO `collect_fee_details`(`collect_fee_id`, `fee_title`, `fee_amount`, `fee_discount`) VALUES ("'.$last_id.'", "'.$amount['title'].'", "'.$amount['amount'].'", "'.$discount.'")';
        $result = $this->insert($qry3);
        return true;
    }

    function removeOldCollectFeeDetails($collect_fee_id) {
        $qry1 = "DELETE FROM `collect_fee_details` WHERE `collect_fee_id`='".$collect_fee_id."'";
        $result = $this->deleteData($qry1);
        return true;
    }
}
?>