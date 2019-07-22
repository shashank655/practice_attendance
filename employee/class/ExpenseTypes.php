<?php
class ExpenseTypes extends MySQLCN {

    function addExpenseType($data) {
        $qry = 'INSERT INTO `expense_types`(`type`) VALUES ("'.$data['expense_type'].'")';
        $res = $this->insert($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function getExpenseTypesLists() {
        $fetch = "SELECT * FROM `expense_types`;";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }

    function getExpenseTypeInfo($id) {
        $fetch = "SELECT * FROM `expense_types` where expense_types.id='{$id}'";
        $fetch_data = $this->select($fetch);
        return $fetch_data;
    }    

    function deleteExpenseType($eId) {
        $qry1 = "DELETE FROM `expense_types` WHERE id = '{$eId}'";
        $res = $this->deleteData($qry1);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function expenseTypeInfoUpdate($data) {
        $expenseId = $data['expenseId'];
        $qry = "UPDATE `expense_types` SET
              `type` = '{$data['expense_type']}'
               WHERE id = '{$expenseId}'";
        $res = $this->updateData($qry);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>