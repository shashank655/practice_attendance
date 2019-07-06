<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/FeeGroups.php';
require_once 'employee/class/ClassSections.php';
require_once 'employee/class/Sections.php';
require_once 'employee/class/FeeAmounts.php';
require_once 'employee/class/FeeClassGroup.php';
$fee_group = new FeeGroups();
$classes = new ClassSections();
$sections = new Sections();
$feeAmounts = new FeeAmounts();
$feeClassGroups = new FeeClassGroup();
$allClasses = $classes->getClassesLists();
$allSections = $sections->getSectionsLists();
$allFeeAmounts = $feeAmounts->getFeeAmountsLists();
$allFeeClassGroups = $feeClassGroups->getFeeClassGroupLists();
$feeId = (isset($_REQUEST['feeId'])) ? $_REQUEST['feeId'] : NULL; 
if ($feeId != NULL) { 
    $result = $fee_group->getFeeGroupsInfo($feeId);  
    if ($result == NULL) { $feeId = ''; } 
}
$tab1 = false;
$tab2 = false;
if ($feeId == '') {
    $tab1 = true;
    $tab2 = true;
} else {
    if ($result[0]['class_id'] != '') {
        $tab1 = true;
    } else {
        $tab2 = true;
    }
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
                        <h5 class="text-uppercase">Add Fee Group</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Fee Group</li>
                        </ul>
                    </div>
                </div>
            </div>
                        
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Fee Group</h4><br>
                            <ul class="nav nav-tabs nav-justified">
                                <?php if ($tab1) { ?>
                                <li class="nav-item"><a class="nav-link active" href="#basictab1" data-toggle="tab">Class Section Wise</a></li>
                                <?php } 
                                    if ($tab2) {
                                ?>
                                <li class="nav-item"><a class="nav-link" href="#basictab2" data-toggle="tab">Class Group Wise</a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane <?php echo $tab1 ? 'show active' : ''; ?>" id="basictab1">
                                    <form id="addFeeGroups" action="employee/process/processFeeGroups.php" method="post" novalidate="novalidate">
                                        <input type="hidden" name="type" value="<?php echo $feeId == '' ? 'Add' : 'Update'; ?>" />
                                        <input type="hidden" name="feeId" value="<?php echo $feeId; ?>" />
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label">Title</label>
                                                    <input type="text" name="title" class="form-control" value="<?php
                                                        if (isset($result[0]['title']))
                                                            echo htmlspecialchars($result[0]['title']);
                                                        ?>">
                                                </div>        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label">Select Class</label>
                                                    <select class="form-control" name="class_id">
                                                        <?php foreach($allClasses as $class) { ?>
                                                            <option value="<?= $class['id'] ?>" 
                                                            <?php
                                                            if (isset($result[0]['class_id']) == $class['id'])
                                                                echo "selected";
                                                            ?>
                                                            ><?= $class['class_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label">Select Section</label>
                                                    <select class="form-control" name="section_id">
                                                        <?php foreach($allSections as $section) { ?>
                                                            <option value="<?= $section['id'] ?>"
                                                            <?php
                                                            if (isset($result[0]['section_id']) == $section['id'])
                                                                echo "selected";
                                                            ?>
                                                            ><?= $section['section_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3">Select Fee Amount</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control" name="fee_amount" id="fee_amount_id">
                                                            <?php foreach($allFeeAmounts as $feeAmount) { ?>
                                                                <option value="<?= $feeAmount['id'] ?>" data-amount="<?= $feeAmount['amount'] ?>"><?= $feeAmount['title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
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
                                                        <h4 class="card-title">Fee Amounts</h4><br>
                                                        <div class="table-responsive">
                                                            <table class="table m-b-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Fee Amount Title</th>
                                                                        <th>Amount</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fee-amount">
                                                                    <?php
                                                                        if (isset($result[0]['id'])) {
                                                                            $feeGroupFees = $fee_group->getFeeGroupFees($result[0]['id']);
                                                                            foreach ($feeGroupFees as $feeGroupFee) {
                                                                    ?>
                                                                        <tr class="amount-row fee-id-<?= $feeGroupFee['fee_amount_id'] ?>">
                                                                            <td>
                                                                                <input type="hidden" name="fee_amount_ids[]" value="<?= $feeGroupFee['fee_amount_id'] ?>"><span class="counter"></span>
                                                                            </td> 
                                                                            <td><?= $feeGroupFee['title'] ?></td>
                                                                            <td class="amount"><?= $feeGroupFee['amount'] ?></td> 
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
                                                        <div class="pull-right">
                                                            <strong>Total Amount : </strong> <span class="total-amount">0</span>
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
                                    </form>
                                </div>
                                <div class="tab-pane <?php echo $tab2 ? 'show active' : ''; ?>" id="basictab2">
                                <form id="addFeeGroupsTab2" action="employee/process/processFeeGroupsTab2.php" method="post" novalidate="novalidate">
                                        <input type="hidden" name="type" value="<?php echo $feeId == '' ? 'Add' : 'Update'; ?>" />
                                        <input type="hidden" name="feeId" value="<?php echo $feeId; ?>" />
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="col-form-label">Title</label>
                                                    <input type="text" name="title" class="form-control" value="<?php
                                                        if (isset($result[0]['title']))
                                                            echo htmlspecialchars($result[0]['title']);
                                                        ?>">
                                                </div>        
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label">Select Class Group</label>
                                                    <select class="form-control" name="fee_class_group_id">
                                                        <?php foreach($allFeeClassGroups as $feeClassGroup) { ?>
                                                            <option value="<?= $feeClassGroup['id'] ?>"
                                                            <?php
                                                            if (isset($result[0]['fee_class_group_id']) == $feeClassGroup['id'])
                                                                echo "selected";
                                                            ?>
                                                            ><?= $feeClassGroup['title'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3">Select Fee Amount</label>
                                                    <div class="col-md-7">
                                                        <select class="form-control" name="fee_amount" id="fee_amount_id_tab2">
                                                            <?php foreach($allFeeAmounts as $feeAmount) { ?>
                                                                <option value="<?= $feeAmount['id'] ?>" data-amount="<?= $feeAmount['amount'] ?>"><?= $feeAmount['title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" class="btn btn-md btn-success add-tab2">
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
                                                        <h4 class="card-title">Fee Amounts</h4><br>
                                                        <div class="table-responsive">
                                                            <table class="table m-b-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Fee Amount Title</th>
                                                                        <th>Amount</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="fee-amount-tab2">
                                                                    <?php
                                                                        if (isset($result[0]['id'])) {
                                                                            $feeGroupFees = $fee_group->getFeeGroupFees($result[0]['id']);
                                                                            foreach ($feeGroupFees as $feeGroupFee) {
                                                                    ?>
                                                                        <tr class="amount-row-tab2 fee-id-tab2-<?= $feeGroupFee['fee_amount_id'] ?>">
                                                                            <td>
                                                                                <input type="hidden" name="fee_amount_ids[]" value="<?= $feeGroupFee['fee_amount_id'] ?>"><span class="counter"></span>
                                                                            </td> 
                                                                            <td><?= $feeGroupFee['title'] ?></td>
                                                                            <td class="amount-tab2"><?= $feeGroupFee['amount'] ?></td> 
                                                                            <td>
                                                                                <a href="javascript:;" class="btn btn-danger remove-amount-tab2"><i class="fa fa-trash"></i></a>
                                                                            </td> 
                                                                        </tr>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="pull-right">
                                                            <strong>Total Amount : </strong> <span class="total-amount-tab2">0</span>
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
    <?php require_once 'includes/footer.php'; ?>
    <script type="text/javascript">
        $(function(){
            $("#addFeeGroups").validate({
                ignore: "input[type='text']:hidden",
                rules:{
                    title:{
                        required:true
                    }
                }
            });
            $("#addFeeGroupsTab2").validate({
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
                var html = '<tr class="amount-row fee-id-'+id+'"> <td><input type="hidden" name="fee_amount_ids[]" value="'+id+'"><span class="counter"></span></td> <td>'+title+'</td> <td class="amount">'+amount+'</td> <td><a href="javascript:;" class="btn btn-danger remove-amount"><i class="fa fa-trash"></i></a></td> </tr>';
                $(".fee-amount").append(html);
                getTotalAmount();
            }
        });

        function getTotalAmount() {
            var total_amount = 0;    
            $(".amount").each(function (index, am){
                total_amount = total_amount + parseFloat($(am).text());    
            });
            $(".total-amount").text(total_amount);
        }

        // Remove Fee Amount Tab 1
        $(document).on("click", ".remove-amount", function() {
            $(this).closest('.amount-row').remove();
            getTotalAmount();
        });

        
        // Add Fee Amount Tab 2
        $(document).on("click", ".add-tab2", function () {
            var id = $("#fee_amount_id_tab2").val();
            if ($(".fee-id-tab2-"+id).length > 0) {
                alert("Fees already added.");   
            } else {
                var title = $("#fee_amount_id_tab2 option:selected").text();
                var amount = $("#fee_amount_id_tab2 option:selected").data("amount");
                var html = '<tr class="amount-row-tab2 fee-id-tab2-'+id+'"> <td><input type="hidden" name="fee_amount_ids[]" value="'+id+'"><span class="counter"></span></td> <td>'+title+'</td> <td class="amount-tab2">'+amount+'</td> <td><a href="javascript:;" class="btn btn-danger remove-amount-tab2"><i class="fa fa-trash"></i></a></td> </tr>';
                $(".fee-amount-tab2").append(html);
                getTotalAmountTab2();
            }
        });

        function getTotalAmountTab2() {
            var total_amount = 0;    
            $(".amount-tab2").each(function (index, am){
                total_amount = total_amount + parseFloat($(am).text());    
            });
            $(".total-amount-tab2").text(total_amount);
        }

        // Remove Fee Amount
        $(document).on("click", ".remove-amount-tab2", function() {
            $(this).closest('.amount-row-tab2').remove();
            getTotalAmountTab2();
        });

        $(document).ready(function() {
            getTotalAmount();
            getTotalAmountTab2();
        });
    </script>