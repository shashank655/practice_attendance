<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/ExpenseTypes.php';
$expenseTypes = new ExpenseTypes();
$expenseId = (isset($_REQUEST['expenseId'])) ? $_REQUEST['expenseId'] : NULL; 
if ($expenseId != NULL) { 
    $result = $expenseTypes->getExpenseTypeInfo($expenseId);
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
                        <h5 class="text-uppercase">Add Expense Type</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Expense Type</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="addExpenseType" action="employee/process/processExpenseTypes.php" method="post" novalidate="novalidate">
                            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Expense Type</h4>
                            <input type="hidden" name="type" value="<?php echo $expenseId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="expenseId" value="<?php echo $expenseId; ?>" />
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Type</label>
                                    <div class="col-md-10">
                                        <input type="text" name="expense_type" class="form-control" value="<?php
                                                if (isset($result[0]['type']))
                                                echo htmlspecialchars($result[0]['type']);
                                                ?>">
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
                    type:{
                        required:true
                    }
                }
            });
        });
    </script>