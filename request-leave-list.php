<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/RequestLeave.php'; 
require_once 'employee/class/CommonFunction.php'; 
$requestLeave=new RequestLeave(); 
$userId = $_SESSION['userId'];
$searchYear = (isset($_REQUEST['year'])) ? $_REQUEST['year'] : NULL;
    if ($searchYear != NULL) {
        $current_year = $searchYear;
    } else {
        $current_year = date('Y');
    } 
$searchMonth = (isset($_REQUEST['month'])) ? $_REQUEST['month'] : NULL;
    if ($searchMonth != NULL) {
        $current_month = $searchMonth;
    } else {
        $current_month = date('m');
    }

$resultAllLeaves=$requestLeave->getLeavesAppliedLists($userId, $current_year, $current_month); ;
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
            <form id="searchLeaves" action="request-leave-list.php" method="get" novalidate="novalidate">
                 <div class="row"> 
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <select name="month" id="month">
                                <option value="">Select Month</option>
                                <option <?php if($current_month == '01'){echo 'selected'; } ?> value="01">Jan</option>
                                <option <?php if($current_month == '02'){echo 'selected'; } ?> value="02">Feb</option>
                                <option <?php if($current_month == '03'){echo 'selected'; } ?> value="03">Mar</option>
                                <option <?php if($current_month == '04'){echo 'selected'; } ?> value="04">Apr</option>
                                <option <?php if($current_month == '05'){echo 'selected'; } ?> value="05">May</option>
                                <option <?php if($current_month == '06'){echo 'selected'; } ?> value="06">Jun</option>
                                <option <?php if($current_month == '07'){echo 'selected'; } ?> value="07">Jul</option>
                                <option <?php if($current_month == '08'){echo 'selected'; } ?> value="08">Aug</option>
                                <option <?php if($current_month == '09'){echo 'selected'; } ?> value="09">Sep</option>
                                <option <?php if($current_month == '10'){echo 'selected'; } ?> value="10">Oct</option>
                                <option <?php if($current_month == '11'){echo 'selected'; } ?> value="11">Nov</option>
                                <option <?php if($current_month == '12'){echo 'selected'; } ?> value="12">Dec</option>
                             </select>
                             <label class="control-label">Select Month</label><i class="bar"></i>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-md-3">
                    <div class="form-group custom-mt-form-group">
                            <select name="year" id="year">
                                <option value="">Select Year</option>
                                <option <?php if($current_year == '2021'){echo 'selected'; } ?> value="2021">2021</option>
                                <option <?php if($current_year == '2020'){echo 'selected'; } ?> value="2020">2020</option>
                                <option <?php if($current_year == '2019'){echo 'selected'; } ?> value="2019">2019</option>
                             </select>
                             <label class="control-label">Select Year</label><i class="bar"></i>
                        </div>  
                       
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Leave Type</th>
                                        <th style="min-width:50px;">Effective From</th>
                                        <th style="min-width:50px;">Number of days</th>
                                        <th style="min-width:50px;">Reason to Leave </th>
                                        <th style="min-width:50px;">Note</th>
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
                                        <td><?php echo $value['send_note']; ?></td>
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