<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/FeeAmounts.php';
$fee_amounts=new FeeAmounts();
$feeAmountId = (isset($_REQUEST['feeAmountId'])) ? $_REQUEST['feeAmountId'] : NULL; 
if ($feeAmountId != NULL) { 
    $result = $fee_amounts->getFeeAmountsInfo($feeAmountId);  
    if ($result == NULL) { $feeAmountId = ''; } 
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
                        <h5 class="text-uppercase">Add Fee Amount</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Fee Amount</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="addFeeAmounts" action="employee/process/processFeeAmounts.php" method="post" novalidate="novalidate">
                            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Fee Amount</h4>
                            <input type="hidden" name="type" value="<?php echo $feeAmountId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="feeAmountId" value="<?php echo $feeAmountId; ?>" />
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Title</label>
                                <div class="col-md-10">
                                    <input type="text" name="title" class="form-control" value="<?php
                                    if (isset($result[0]['title']))
                                        echo htmlspecialchars($result[0]['title']);
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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group text-center custom-mt-form-group">
									<button class="btn btn-secondary mr-2" type="submit">Submit</button>
									<button class="btn btn-secondary" type="reset">Cancel</button>
								</div>
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
            $("#addFeeAmounts").validate({
                ignore: "input[type='text']:hidden",
                rules:{
                    title:{
                        required:true
                    },
                    amount: {
                        required:true
                    }
                }
            });
        });
    </script>