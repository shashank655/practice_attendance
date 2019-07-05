<?php
class FeeClassGroup extends MySQLCN {

    function addFeeClassGroup($data) {
        $qry = 'INSERT INTO `fee_class_groups` 
            (`title`) 
            VALUES ( "'. $data['title'] . '")';
        $res = $this->insert($qry);
        $last_id = mysqli_insert_id($this->CONN);
        foreach ($data['class_ids'] as $class_id) {
            $qry2 = 'INSERT INTO `fee_class_group_classes` (`fee_class_group_id`, `class_id`) VALUES ("'.$last_id.'", "'.$class_id.'")';
            $res2 = $this->insert($qry2);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getFeeClassGroupLists() {
        $fetch = "SELECT * FROM `fee_class_groups`;";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }
    
    function getClasses($id) {
        $sql = 'SELECT `fee_class_group_classes`.`class_id`, `classes_name`.`class_name` FROM `fee_class_group_classes` LEFT JOIN `classes_name` ON `classes_name`.`id` = `fee_class_group_classes`.`class_id` WHERE `fee_class_group_id`="'.$id.'"';
        $fetch = $this->select($sql);
        return $fetch;
    }

    function getFeeClassGroupsInfo($id) {
        $fetch = "SELECT * FROM `fee_class_groups` where fee_class_groups.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    
    function deleteFeeClassGroups($eId) {
        $qry1 = "DELETE FROM `fee_class_group_classes` WHERE fee_class_group_id = '{$eId}'";
        $res1 = $this->deleteData($qry1);
        $qry = "DELETE FROM `fee_class_groups` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function feeClassGroupInfoUpdate($data) {
        $feeId = $data['feeId'];
        $qry = "UPDATE `fee_class_groups` SET
              `title` = '{$data['title']}'
               WHERE id = '{$feeId}'";
        $res = $this->updateData($qry);
        $qry1 = "DELETE FROM `fee_class_group_classes` WHERE fee_class_group_id = '{$feeId}'";
        $res1 = $this->deleteData($qry1);
        foreach ($data['class_ids'] as $class_id) {
            $qry3 = 'INSERT INTO `fee_class_group_classes` (`fee_class_group_id`, `class_id`) VALUES ("'.$feeId.'", "'.$class_id.'")';
            $res3 = $this->insert($qry3);
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
?>