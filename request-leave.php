<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/RequestLeave.php'; 
$request_leave=new RequestLeave();
$leaveType = $request_leave->getLeaveTypeList();
$examId = (isset($_REQUEST['examId'])) ? $_REQUEST['examId'] : NULL; 
if ($examId != NULL) { $result = $request_leave->getExamInfo($examId); 
    if ($result == NULL) { $examId = ''; } } 
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
                        <h5 class="text-uppercase">Request Leave</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item">Request Leave</li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Request Leave</h4>
                            <form id="requestLeave" action="employee/process/processRequestLeave.php" method="post" enctype="multipart/form-data" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $examId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="examId" value="<?php echo $examId; ?>" />
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Select Leave Type</label>
                                    <div class="col-md-10">
                                        <select id="leave_type_id" class="form-control" name="leave_type_id">
                                            <option value="">Leave Type</option>
                                            <?php for ($i=0 ; $i < count($leaveType); $i++) : ?>
                                                <option <?php if (isset($result[0]['leave_type_id'])) { if ($result[0]['leave_type_id']==$leaveType[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $leaveType[$i][ 'id']; ?>"><?php echo $leaveType[$i][ 'leave_type'].'('.$leaveType[$i]['days'].')'; ?></option>
                                            <?php endfor; ?>    
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">No  of days</label>
                                    <div class="col-md-10">
                                        <input type="text" name="number_of_days" class="form-control" value="<?php
                                                if (isset($result[0]['number_of_days']))
                                                echo htmlspecialchars($result[0]['number_of_days']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Effective from</label>
                                    <div class="col-md-10">
                                        <input type="text" name="effective_from" class="form-control datetimepicker" value="<?php
                                                if (isset($result[0]['effective_from']))
                                                echo htmlspecialchars($result[0]['effective_from']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Effective to</label>
                                    <div class="col-md-10">
                                        <input type="text" name="effective_to" class="form-control datetimepicker" value="<?php
                                                if (isset($result[0]['effective_to']))
                                                echo htmlspecialchars($result[0]['effective_to']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Reason for leave</label>
                                    <div class="col-md-10">
                                        <input type="text" name="reason_to_leave" class="form-control" value="<?php
                                                if (isset($result[0]['reason_to_leave']))
                                                echo htmlspecialchars($result[0]['reason_to_leave']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Attachment</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="file" name="leave_attachment">
                                    </div>
                                </div>
                            <div class="form-group text-center custom-mt-form-group">
                                <button class="btn btn-primary btn-lg mr-2" type="submit">Apply</button>
                            </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <script type="text/javascript">
    jQuery.validator.addMethod("dropdownValidation", function(value, element, params) {        
        return $.trim(value) != '';
    },'This field is required.');

    $(function(){
        $("#requestLeave").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                leave_type_id:{
                    required:true,
                    dropdownValidation:true
                },
                number_of_days:{
                    required:true
                },
                effective_from:{
                    required:true
                },
                effective_to:{
                    required:true
                },                
                reason_to_leave:{
                    required:true
                }
            }
        });
    });
    </script>