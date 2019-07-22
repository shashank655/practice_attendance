<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Expenses.php';
require_once 'employee/class/ExpenseTypes.php';
$expenses = new Expenses();
$expenseTypes = new ExpenseTypes();
$allExpenseTypes = $expenseTypes->getExpenseTypesLists();
$expenseId = (isset($_REQUEST['expenseId'])) ? $_REQUEST['expenseId'] : NULL; 
if ($expenseId != NULL) { 
    $result = $expenses->getExpenseInfo($expenseId);
}
?>
<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                        <h5 class="text-uppercase">Add Expense</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Expense</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="addExpense" action="employee/process/processExpenses.php" method="post" novalidate="novalidate">
                            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Expense</h4>
                            <input type="hidden" name="type" value="<?php echo $expenseId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="expenseId" value="<?php echo $expenseId; ?>" />
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Expense Type</label>
                                    <div class="col-md-10">
                                        <select name="expense_type_id" class="form-control" id="expense_type_id">
                                            <?php 
                                                foreach ($allExpenseTypes as $expenseType) {
                                            ?>
                                            <option value="<?= $expenseType['id'] ?>"
                                            <?php 
                                                if (isset($result))
                                                {
                                                    if($result[0]['expense_type_id'] == $expenseType['id']) echo 'selected';
                                                }
                                            ?>><?= $expenseType['type'] ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Item Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="item_name" class="form-control" value="<?php
                                                if (isset($result[0]['item_name']))
                                                echo htmlspecialchars($result[0]['item_name']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Purchase From</label>
                                    <div class="col-md-10">
                                        <input type="text" name="purchase_from" class="form-control" value="<?php
                                                if (isset($result[0]['purchase_from']))
                                                echo htmlspecialchars($result[0]['purchase_from']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Purchase Date</label>
                                    <div class="col-md-10">
                                        <input type="text" name="purchase_date" class="datetimepicker form-control" value="<?php
                                                if (isset($result[0]['purchase_date']))
                                                echo htmlspecialchars($result[0]['purchase_date']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Purchase By</label>
                                    <div class="col-md-10">
                                        <input type="text" name="purchased_by" class="form-control" value="<?php
                                                if (isset($result[0]['purchased_by']))
                                                echo htmlspecialchars($result[0]['purchased_by']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Amount</label>
                                    <div class="col-md-10">
                                        <input type="text" name="amount" class="form-control" value="<?php
                                                if (isset($result[0]['amount']))
                                                echo htmlspecialchars($result[0]['amount']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Paid By</label>
                                    <div class="col-md-10">
                                        <select name="paid_by" class="form-control">
                                            <option value="Cheque" 
                                            <?php 
                                                if (isset($result[0]['paid_by'])) {
                                                    if ($result[0]['paid_by'] == 'Cheque') echo 'selected'; 
                                                }
                                            ?>>Cheque</option>
                                            <option value="Cash"
                                            <?php 
                                                if (isset($result[0]['paid_by'])) {
                                                    if ($result[0]['paid_by'] == 'Cash') echo 'selected'; 
                                                }
                                            ?>>Cash</option>
                                            <option value="Online"
                                            <?php 
                                                if (isset($result[0]['paid_by'])) {
                                                    if ($result[0]['paid_by'] == 'Online') echo 'selected'; 
                                                }
                                            ?>>Online</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Status</label>
                                    <div class="col-md-10">
                                        <select name="status" class="form-control">
                                            <option value="Approved" 
                                            <?php 
                                                if (isset($result[0]['status'])) {
                                                    if ($result[0]['status'] == 'Approved') echo 'selected'; 
                                                }
                                            ?>>Approved</option>
                                            <option value="Pending"
                                            <?php 
                                                if (isset($result[0]['status'])) {
                                                    if ($result[0]['status'] == 'Pending') echo 'selected'; 
                                                }
                                            ?>>Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group text-center custom-mt-form-group">
                                    <button class="btn btn-primary btn-lg mr-2" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <script type="text/javascript">
        $(function(){
            $("#addExpenseType").validate({
                ignore: "input[type='text']:hidden",
                rules:{
                    status:{
                        required:true
                    },
                    paid_by:{
                        required:true
                    },
                    purchase_date:{
                        required:true
                    },
                    purchase_from:{
                        required:true
                    },
                    item_name:{
                        required:true
                    },
                    expense_type_id:{
                        required:true
                    },
                    amount:{
                        required:true
                    },
                    purchased_by:{
                        required:true
                    },
                }
            });
        });
    </script>