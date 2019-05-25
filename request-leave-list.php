<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/RequestLeave.php'; 
require_once 'employee/class/CommonFunction.php'; 
$requestLeave=new RequestLeave(); 
$userId = $_SESSION['userId'];
$resultAllLeaves=$requestLeave->getLeavesAppliedLists($userId); ;
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
							<h5 class="text-uppercase">Leaves</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Leave Type List</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="request-leave.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i>Request Leave</a>
                    </div>
                </div>
			<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Leave Type</th>
                                        <th style="min-width:50px;">Effective From</th>
                                        <th style="min-width:50px;">Number of days</th>
                                        <th style="min-width:50px;">Reason to Leave </th>
                                        <th style="min-width:50px;">Leave Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                	<?php foreach ($resultAllLeaves as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['leave_type']; ?></td>
                                        <td><?php echo $value['effective_from']; ?></td>
                                        <td><?php echo $value['number_of_days']; ?></td>
                                        <td><?php echo $value['reason_to_leave']; ?></td>
                                        <?php 
                                            if($value['leave_status'] == '0') {
                                                $status = 'Pending';
                                                $class = 'leave_pending';
                                            } else if($value['leave_status'] == '1') {
                                                $status = 'Approve';
                                                $class = 'leave_approve';
                                            } else {
                                                $status = 'Rejected';
                                                $class = 'leave_reject';
                                            } ?>
                                        <td class="text-center">
                                            <div class="action-label">
                                                <a class="btn btn-white <?php echo $class?> btn-sm btn-rounded" href="#">
                                                    <i class="fa fa-dot-circle-o"></i> <?php echo $status; ?>
                                                </a>
                                            </div>
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