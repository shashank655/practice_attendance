<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Leaves.php'; 
require_once 'employee/class/CommonFunction.php'; 
$leaves=new Leaves(); 
$resultLeavesRequest=$leaves->getLeavesRequestsLists(); ;
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
							<h5 class="text-uppercase">Leaves Request</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Leave Request List</li>
							</ul>
						</div>
					</div>
				</div>
			<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Employee Name</th>
                                        <th style="min-width:50px;">Leave Type</th>
                                        <th style="min-width:50px;">Effective From</th>
                                        <th style="min-width:50px;">Number of days</th>
                                        <th style="min-width:50px;">Leave Status </th>
                                        <th style="min-width:50px;">Edit Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                	<?php foreach ($resultLeavesRequest as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                        <td><?php echo $value['leave_type']; ?></td>
                                        <td><?php echo $value['effective_from']; ?></td>
                                        <td><?php echo $value['number_of_days']; ?></td>
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
                                        <td class="">
                                            <a href="view-leave-requests.php?leaveId=<?php echo $value[0]; ?>" class="btn btn-primary btn-sm mb-1">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
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