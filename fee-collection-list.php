<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/config/months.php'; 
require_once 'employee/class/CollectFees.php';
require_once 'employee/class/FeeAmounts.php';
$collect_fees = new CollectFees;
$resultCollectFees = $collect_fees->getCollectFees();
$feeAmounts = new FeeAmounts;
$allFeeAmounts = $feeAmounts->getFeeAmountsLists();
if (isset($_GET['fee_amount_title']) || isset($_GET['fee_paying_mode']) || isset($_GET['from_date']) || isset($_GET['to_date'])) {
    $resultCollectFees = $collect_fees->getCollectFeesBy($_GET['fee_amount_title'], $_GET['fee_paying_mode'], $_GET['from_date'], $_GET['to_date']);
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
							<h5 class="text-uppercase">Fee Collection</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Fee Collection List</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="collect-fee1.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Fee Collection</a>
                    </div>
                </div>
			<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="get" class="form-inline">
                            <div class="form-group">
                                <select name="fee_amount_title" class="form-control">
                                    <option value="">Select Fee Amount</option>
                                    <?php 
                                        foreach ($allFeeAmounts as $feeAmount) {
                                    ?>
                                        <option value="<?= $feeAmount['title']; ?>"><?= $feeAmount['title']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="fee_paying_mode" class="form-control">
                                    <option value="">Select Payment Duration</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Half Yearly">Half Yearly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input name="from_date" class="datetimepicker form-control">
                            </div>
                            <div class="form-group">
                                <input name="to_date" class="datetimepicker form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Search" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Paid Fee</th>
                                        <th style="min-width:50px;">Collected By</th>
                                        <th style="min-width:50px;">Payment Mode</th>
                                        <th style="min-width:50px;">Comment</th>
                                        <th style="min-width:50px;">Class</th>
                                        <th style="min-width:50px;">Section</th>
                                        <th style="min-width:50px;">Student</th>
                                        <th style="min-width:50px;">Fee Group</th>
                                        <th style="min-width:50px;">Due Fees</th>
                                        <th style="min-width:50px;">Created On</th>
                                        <th style="min-width:50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $i=1; 
                                    foreach ($resultCollectFees as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['paid_fee']; ?></td>
                                        <td><?php echo $value['collected_by']; ?></td>
                                        <td><?php echo $value['payment_mode']; ?></td>
                                        <td><?php echo $value['comment']; ?></td>
                                        <td><?php echo $value['class_name']; ?></td>
                                        <td><?php echo $value['section_name']; ?></td>
                                        <td><?php echo $value['first_name'].' '.$value['last_name'] ; ?></td>
                                        <td><?php echo $value['title'] ; ?></td>
                                        <td><?php echo $value['due_fee'] ; ?></td>
                                        <td><?php echo date('d M, Y', strtotime($value['created_at'])); ?></td>
                                        <td class="text-right" >
											<a href="collect-fee1.php?feeCollectId=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
                                            <a href="employee/process/processFeeAmounts.php?type=deleteFeeAmounts&id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm mb-1">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
											
										</td>
                                    </tr>
                                	<?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>