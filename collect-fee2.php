<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/config/months.php'; 
require_once 'employee/class/ClassSections.php';
require_once 'employee/class/Sections.php';
require_once 'employee/class/Student.php';
require_once 'employee/class/FeeGroups.php';
require_once 'employee/class/CollectFees.php';
$collect_fees = new CollectFees;
$classes=new ClassSections();
$class = $classes->getClassInfo($_GET['class_id']);
$sections=new Sections();
$section = $sections->getSectionInfo($_GET['section_id']);
$student=new Student();
$student = $student->getStudentInfo($_GET['student_id']);
$feeGroups=new FeeGroups();
$feeGroup = $feeGroups->getFeeGroupsInfo($_GET['fee_group_id']);
$feeGroupFee = $feeGroups->getFeeGroupFees($_GET['fee_group_id']);
if (isset($_GET['feeCollectId'])) {
    $resultCollectFee = $collect_fees->getCollectFeeInfo($_GET['feeCollectId']);
    $due_amount = $collect_fees->getDueAmount($_GET['feeCollectId']);
} else {
    $resultCollectFee = [];
    $due_amount = false;
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
                        <h5 class="text-uppercase">Collect Fee Step 2</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Collect Fee Step 2</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Class Name</label>
                        <input type="text" class="form-control" value="<?= $class[0]['class_name'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Section Name</label>
                        <input type="text" class="form-control" value="<?= $section[0]['section_name'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" class="form-control" value="<?= $student[0]['first_name'].' '.$student[0]['last_name'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fee Group</label>
                        <input type="text" class="form-control" value="<?= $feeGroup[0]['title'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Month</label>
                        <input type="text" class="form-control" value="<?= $months[$_GET['month_id']] ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    $total_amount = 0;
                                    $total_discount = 0;
                                    $grand_total = 0;
                                    foreach($feeGroupFee as $amount) { 
                                        $discount = $feeGroups->calculateDiscount($student[0]['particular_id'], $amount['fee_amount_id'], $amount['amount']);
                                        $sub_total = $amount['amount'] - $discount;
                                        $total_amount = $total_amount + $amount['amount'];
                                        $total_discount = $total_discount + $discount;
                                        $grand_total = $grand_total + $sub_total;
                                ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $amount['title'] ?></td>
                                    <td><?= $amount['amount'] ?></td>
                                    <td><?= $discount ?></td>
                                    <td><?= $sub_total ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total Amount :</strong> <?= $total_amount ?></td>
                                    <td><strong>Total Discount :</strong> <?= $total_discount ?></td>
                                    <td><strong>Grand Total :</strong> <?= $grand_total ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form id="collectFeeForm" action="employee/process/processCollectFee.php" method="post" novalidate="novalidate">
                <input type="hidden" name="feeCollectId" value="<?php if (isset($_GET['feeCollectId'])) echo $_GET['feeCollectId']; ?>">
                <input type="hidden" name="grand_total" id="grand_total" value="<?= $grand_total ?>">
                <input type="hidden" name="class_id" value="<?= $_GET['class_id'] ?>">
                <input type="hidden" name="section_id" value="<?= $_GET['section_id'] ?>">
                <input type="hidden" name="student_id" value="<?= $_GET['student_id'] ?>">
                <input type="hidden" name="particular_id" value="<?= $student[0]['particular_id'] ?>">
                <input type="hidden" name="fee_group_id" value="<?= $feeGroup[0]['id'] ?>">
                <input type="hidden" name="month_id" value="<?= $_GET['month_id'] ?>">
                <input type="hidden" name="fee_paying_mode" value="<?= $_GET['fee_paying_mode'] ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Paid Fee</label>
                            <input type="text" name="paid_fee" id="paid_fee" value="<?php if (count($resultCollectFee) > 0) echo $resultCollectFee[0]['paid_fee']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Due Fee</label>
                            <input type="text" name="due_fee" id="due_fee" value="<?php if ($due_amount) echo $due_amount[0]['due_fee']; ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="text" name="due_date" value="<?php if ($due_amount) echo $due_amount[0]['due_date']; ?>" class="datetimepicker form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Collected By</label>
                            <input type="text" name="collected_by" value="<?= $_SESSION['name'] ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Payment Mode</label>
                            <select name="payment_mode" class="form-control">
                                <option value="Cheque" 
                                <?php 
                                    if (count($resultCollectFee) > 0) {
                                        if ($resultCollectFee[0]['payment_mode'] == 'Cheque') echo 'selected'; 
                                    }
                                ?>>Cheque</option>
                                <option value="Cash"
                                <?php 
                                    if (count($resultCollectFee) > 0) {
                                        if ($resultCollectFee[0]['payment_mode'] == 'Cash') echo 'selected'; 
                                    }
                                ?>>Cash</option>
                                <option value="Online"
                                <?php 
                                    if (count($resultCollectFee) > 0) {
                                        if ($resultCollectFee[0]['payment_mode'] == 'Online') echo 'selected'; 
                                    }
                                ?>>Online</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea name="comment" class="form-control"><?php if (count($resultCollectFee) > 0) echo $resultCollectFee[0]['comment']; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="form-group text-center custom-mt-form-group">
							<button class="btn btn-secondary mr-2" type="submit">Submit</button>
							<button class="btn btn-secondary" type="reset">Cancel</button>
						</div>
					</div>
                </div>
            </form>
        </div>
    </div>
</div>
    <?php require_once 'includes/footer.php'; ?>
    <script>
        $(document).on("change", "#paid_fee", function () {
            var grand_total = $("#grand_total").val();
            var due_fee = grand_total - $(this).val();
            if (due_fee > 0) {
                $("#due_fee").val(due_fee);
            } else {
                $("#due_fee").val(0);
            }
        });
    </script>