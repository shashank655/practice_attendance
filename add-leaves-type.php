<?php
require_once 'employee/class/dbclass.php'; 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';
require_once 'employee/class/Leaves.php';
$leaves = new Leaves();

$leaveId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
if ($leaveId != NULL) { $result = $leaves->getLeaveTypeInfo($leaveId); 
    if ($result == NULL) { $leaveId = ''; } }
    ?>
    <div class="page-wrapper"> <!-- content -->
        <div class="content container-fluid">
         <div class="page-header">
            <div class="row">
               <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                  <h5 class="text-uppercase">Add Leave</h5>
              </div>
              <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                  <ul class="list-inline breadcrumb float-right">
                     <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                     <li class="list-inline-item"> Add Leave Type</li>
                 </ul>
             </div>
         </div>
     </div>

     <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="card-title">Add Leave</h4>
                <form id="addLeaveType" action="employee/process/processLeavesTypes.php" method="post" novalidate="novalidate">
                    <input type="hidden" name="type" value="<?php echo $leaveId == '' ? 'Add' : 'Update'; ?>" />
                    <input type="hidden" name="leaveId" value="<?php echo $leaveId; ?>" />
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Leave Type</label>
                        <div class="col-md-10">
                            <input type="text" name="leave_type" class="form-control" value="<?php
                            if (isset($result[0]['leave_type']))
                                echo htmlspecialchars($result[0]['leave_type']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Number of days</label>
                        <div class="col-md-10">
                            <input type="text" name="days" class="form-control" value="<?php
                            if (isset($result[0]['days']))
                                echo htmlspecialchars($result[0]['days']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">Select Paid/Unpaid</label>
                        <div class="col-md-10">
                        <select class="form-control" name="paid_type" id="paid_type">
                                <option <?php if($result[0]['paid_type'] == 'paid'){echo 'selected'; } ?> value="paid">Paid</option>
                                <option <?php if($result[0]['paid_type'] == 'unpaid'){echo 'selected'; } ?> value="unpaid">Un Paid</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row" id="paid_div_show" style="display: none;">
                        <label class="col-form-label col-md-2">Amount</label>
                        <div class="col-md-10">
                            <input type="text" name="paid_leave_amount" class="form-control" value="<?php
                            if (isset($result[0]['paid_leave_amount']))
                                echo htmlspecialchars($result[0]['paid_leave_amount']);
                            ?>">
                        </div>
                    </div>    
                        <div class="form-group text-center custom-mt-form-group">
                            <button class="btn btn-primary btn-lg mr-2" type="submit">Create</button>
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
    $(function(){
        $("#addLeaveType").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                leave_type:{
                    required:true
                },                
                days:{
                    required:true
                },                
                paid_leave_amount:{
                    required:true
                }
            }
        });

        var paidType = $('#paid_type').val();
        $('#paid_type_bk').change(function(){
            if($('#paid_type').val() == 'paid') {
                $('#paid_div_show').show();  
            } else {
                $('#paid_div_show').hide(); 
                } 
            });
    });
</script>