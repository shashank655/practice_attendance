<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/FeeAmounts.php';
require_once 'employee/class/Particulars.php';
$particulars = new Particulars();
$feeAmounts = new FeeAmounts();
$allFeeAmounts = $feeAmounts->getFeeAmountsLists();
$feeId = (isset($_REQUEST['feeId'])) ? $_REQUEST['feeId'] : NULL; 
if ($feeId != NULL) { 
    $result = $particulars->getParticularsInfo($feeId);  
    if ($result == NULL) { $feeId = ''; } 
} 
?>
<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<style>
    body {
        /* Set "my-sec-counter" to 0 */
        counter-reset: my-sec-counter;
    }

    span.counter::before {
        /* Increment "my-sec-counter" by 1 */
        counter-increment: my-sec-counter;
        content: counter(my-sec-counter);
    }
</style>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                        <h5 class="text-uppercase">Add Discount Fields</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Discount Fields</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="addParticular" action="employee/process/processParticulars.php" method="post" novalidate="novalidate">
                            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Discount Fields</h4>
                            <input type="hidden" name="type" value="<?php echo $feeId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="feeId" value="<?php echo $feeId; ?>" />
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Title</label>
                                <div class="col-md-10">
                                    <input type="text" name="title" class="form-control" value="<?php
                                    if (isset($result[0]['title']))
                                        echo htmlspecialchars($result[0]['title']);
                                    ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Select Fee Amount</label>
                                        <select class="form-control" name="fee_amount" id="fee_amount_id">
                                            <?php foreach($allFeeAmounts as $feeAmount) { ?>
                                                <option value="<?= $feeAmount['id'] ?>" data-amount="<?= $feeAmount['amount'] ?>"><?= $feeAmount['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Select Discount Type</label>
                                        <select class="form-control" id="fee_discount_type">
                                            <option value="Fixed">Fixed</option>
                                            <option value="Percentage">Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Discount Amount</label>
                                        <input type="text" class="form-control" id="fee_discount_amount">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>Add</label>
                                    <div class="form-group">
                                        <a href="javascript:;" class="btn btn-md btn-success add">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <div class="card-block">
                                        <h4 class="card-title">Particular Fee Discounts</h4><br>
                                            <div class="table-responsive">
                                                <table class="table m-b-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fee Amount Title</th>
                                                            <th>Amount</th>
                                                            <th>Discount Type</th>
                                                            <th>Discount Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fee-amount">
                                                        <?php
                                                            if (isset($result[0]['id'])) {
                                                                $particularFeeDiscounts = $particulars->getParticularFeeDiscounts($result[0]['id']);
                                                                    foreach ($particularFeeDiscounts as $particularFeeDiscount) {

                                                            ?>
                                                            <tr class="amount-row fee-id-<?= $particularFeeDiscount['fee_amount_id'] ?>">
                                                                <td>
                                                                    <input type="hidden" name="fee_amount_ids[]" value="<?= $particularFeeDiscount['fee_amount_id'] ?>">
                                                                    <input type="hidden" name="discount_type[]" value="<?= $particularFeeDiscount['discount_type'] ?>">
                                                                    <input type="hidden" name="discount_amount[]" value="<?= $particularFeeDiscount['discount_amount'] ?>">
                                                                    <span class="counter"></span>
                                                                </td> 
                                                                <td><?= $particularFeeDiscount['title'] ?></td>
                                                                <td class="amount"><?= $particularFeeDiscount['amount'] ?></td> 
                                                                <td><?= $particularFeeDiscount['discount_type'] ?></td>
                                                                <td><?= $particularFeeDiscount['discount_amount'] ?></td>
                                                                <td>
                                                                    <a href="javascript:;" class="btn btn-danger remove-amount"><i class="fa fa-trash"></i></a>
                                                                </td> 
                                                            </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
            $("#addParticular").validate({
                ignore: "input[type='text']:hidden",
                rules:{
                    title:{
                        required:true
                    }
                }
            });
        });
        
        // Add Fee Amount Tab 1
        $(document).on("click", ".add", function () {
            var id = $("#fee_amount_id").val();
            if ($(".fee-id-"+id).length > 0) {
                alert("Fees already added.");   
            } else {
                var title = $("#fee_amount_id option:selected").text();
                var amount = $("#fee_amount_id option:selected").data("amount");
                var discount_type = $("#fee_discount_type").val();
                var discount_amount = $("#fee_discount_amount").val();
                var html = '<tr class="amount-row fee-id-'+id+'"> <td><input type="hidden" name="fee_amount_ids[]" value="'+id+'"><input type="hidden" name="discount_type[]" value="'+discount_type+'"><input type="hidden" name="discount_amount[]" value="'+discount_amount+'"><span class="counter"></span></td> <td>'+title+'</td> <td class="amount">'+amount+'</td> <td>'+discount_type+'</td> <td class="amount">'+discount_amount+'</td> <td><a href="javascript:;" class="btn btn-danger remove-amount"><i class="fa fa-trash"></i></a></td> </tr>';
                $(".fee-amount").append(html);
            }
        });

        // Remove Fee Amount Tab 1
        $(document).on("click", ".remove-amount", function() {
            $(this).closest('.amount-row').remove();
        });

    </script>