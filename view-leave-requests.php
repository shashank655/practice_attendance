<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Leaves.php'; 
$leaves=new Leaves();
$leaveId = (isset($_REQUEST['leaveId'])) ? $_REQUEST['leaveId'] : NULL; 
if ($leaveId != NULL) { $result = $leaves->viewLeaveRequest($leaveId); 
    if ($result == NULL) { $leaveId = ''; } } 
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
                        <h5 class="text-uppercase">Leave Request</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item">Leave Request</li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Leave Request</h4>
                            <form id="leaveRequest" action="employee/process/processLeavesTypes.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="assign_leave_status" />
                            <input type="hidden" name="leaveId" value="<?php echo $leaveId; ?>" />
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Employee Name</label>
                                    <div class="col-md-10">
                                        <input type="text" readonly="readonly" class="form-control" value="<?php
                                                if (isset($result[0]['first_name']))
                                                echo htmlspecialchars($result[0]['first_name'].' '.$result[0]['last_name']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Leave Type</label>
                                    <div class="col-md-10">
                                        <input type="text" readonly="readonly" class="form-control" value="<?php
                                                if (isset($result[0]['leave_type']))
                                                echo htmlspecialchars($result[0]['leave_type']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Effective From</label>
                                    <div class="col-md-10">
                                        <input type="text" readonly="readonly" class="form-control" value="<?php
                                                if (isset($result[0]['effective_from']))
                                                echo htmlspecialchars($result[0]['effective_from']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Effective To</label>
                                    <div class="col-md-10">
                                        <input type="text" readonly="readonly" class="form-control" value="<?php
                                                if (isset($result[0]['effective_to']))
                                                echo htmlspecialchars($result[0]['effective_to']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">No. of days</label>
                                    <div class="col-md-10">
                                        <input type="text" readonly="readonly" class="form-control" value="<?php
                                                if (isset($result[0]['number_of_days']))
                                                echo htmlspecialchars($result[0]['number_of_days']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Reason to leave</label>
                                    <div class="col-md-10">
                                        <input type="text" readonly="readonly" class="form-control" value="<?php
                                                if (isset($result[0]['reason_to_leave']))
                                                echo htmlspecialchars($result[0]['reason_to_leave']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Action</label>
                                    <div class="col-md-10">
                                        <select id="leave_status" class="form-control" name="leave_status">
                                            <option <?php if($result[0]['leave_status'] == '1') { echo 'selected'; } ?>value="1">Approve</option>
                                            <option <?php if($result[0]['leave_status'] == '2') { echo 'selected'; } ?> value="2">Rejected</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Send Note</label>
                                    <div class="col-md-10">
                                        <input type="text" name="send_note" class="form-control" value="<?php
                                                if (isset($result[0]['send_note']))
                                                echo htmlspecialchars($result[0]['send_note']);
                                                ?>">
                                    </div>
                                </div>
                            <div class="form-group text-center custom-mt-form-group">
                                <button class="btn btn-primary btn-lg mr-2" type="submit">Submit</button>
                            </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>