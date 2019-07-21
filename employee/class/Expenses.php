<?php
class Expenses extends MySQLCN {

    function addExpense($data) {
        $qry = 'INSERT INTO `expenses`(`item_name`, `purchase_from`, `purchase_date`, `purchased_by`, `amount`, `paid_by`, `status`, `expense_type_id`) VALUES ("'.$data['item_name'].'", "'.$data['purchase_from'].'", "'.$data['purchase_date'].'", "'.$data['purchased_by'].'", "'.$data['amount'].'", "'.$data['paid_by'].'", "'.$data['status'].'", "'.$data['expense_type_id'].'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getExpensesLists() {
        $fetch = "SELECT `expenses`.`id`, `expenses`.`item_name`, `expenses`.`purchase_from`, `expenses`.`purchase_date`, `expenses`.`purchased_by`, `expenses`.`amount`, `expenses`.`paid_by`, `expenses`.`status`, `expenses`.`expense_type_id`, `expense_types`.`type` FROM `expenses` LEFT JOIN `expense_types` ON `expense_types`.`id`=`expenses`.`expense_type_id`;";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getExpenseInfo($id) {
        $fetch = "SELECT * FROM `expenses` where expenses.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    

    function deleteExpense($eId) {
        $qry1 = "DELETE FROM `expenses` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry1);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function expenseInfoUpdate($data) {
        $expenseId = $data['expenseId'];
        $qry = "UPDATE `expenses` SET `item_name`='".$data['item_name']."', `purchase_from`='".$data['purchase_from']."', `purchase_date`='".$data['purchase_date']."', `purchased_by`='".$data['purchased_by']."', `amount`='".$data['amount']."', `paid_by`='".$data['paid_by']."', `status`='".$data['status']."', `expense_type_id`='".$data['expense_type_id']."' WHERE id = '{$expenseId}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>