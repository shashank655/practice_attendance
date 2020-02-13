<?php
require_once 'employee/class/dbclass.php'; 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';
require_once 'employee/class/TransferCertificate.php';
$leaves = new TransferCertificate();

$leaveId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
if ($leaveId != NULL) { $result = $leaves->getLeaveTypeInfo($leaveId); 
    if ($result == NULL) { $leaveId = ''; } }
    ?>
    <div class="page-wrapper"> <!-- content -->
        <div class="content container-fluid">
         <div class="page-header">
            <div class="row">
               <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                  <h5 class="text-uppercase">Add Transfer Certificate</h5>
              </div>
              <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                  <ul class="list-inline breadcrumb float-right">
                     <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                     <li class="list-inline-item"> Add Transfer Certificate</li>
                 </ul>
             </div>
         </div>
     </div>

     <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="card-title">Add TC</h4>
                <form id="addLeaveType" action="employee/process/processTransferCertificate.php" method="post" novalidate="novalidate">
                    <input type="hidden" name="type" value="<?php echo $leaveId == '' ? 'Add' : 'Update'; ?>" />
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Student Name </label>
                        <div class="col-md-10">
                            <input type="text" name="student_name" class="form-control" value="<?php
                            if (isset($result[0]['student_name']))
                                echo htmlspecialchars($result[0]['student_name']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Father's/Mother's Name</label>
                        <div class="col-md-10">
                            <input type="text" name="guardian_name" class="form-control" value="<?php
                            if (isset($result[0]['guardian_name']))
                                echo htmlspecialchars($result[0]['guardian_name']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Address</label>
                        <div class="col-md-10">
                            <input type="text" name="address" class="form-control" value="<?php
                            if (isset($result[0]['address']))
                                echo htmlspecialchars($result[0]['address']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Religion/Category</label>
                        <div class="col-md-10">
                            <input type="text" name="religion" class="form-control" value="<?php
                            if (isset($result[0]['religion']))
                                echo htmlspecialchars($result[0]['religion']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Joining Date</label>
                        <div class="col-md-10">
                            <input type="text" name="joining" class="form-control" value="<?php
                            if (isset($result[0]['joining']))
                                echo htmlspecialchars($result[0]['joining']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">From</label>
                        <div class="col-md-10">
                            <input type="text" name="from_date" class="form-control" value="<?php
                            if (isset($result[0]['from_date']))
                                echo htmlspecialchars($result[0]['from_date']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">To</label>
                        <div class="col-md-10">
                            <input type="text" name="to_date" class="form-control" value="<?php
                            if (isset($result[0]['to_date']))
                                echo htmlspecialchars($result[0]['to_date']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Class Name</label>
                        <div class="col-md-10">
                            <input type="text" name="class_name" class="form-control" value="<?php
                            if (isset($result[0]['class_name']))
                                echo htmlspecialchars($result[0]['class_name']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Date</label>
                        <div class="col-md-10">
                            <input type="text" name="tc_date" class="form-control" value="<?php
                            if (isset($result[0]['tc_date']))
                                echo htmlspecialchars($result[0]['tc_date']);
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
                student_name:{
                    required:true
                },                
                guardian_name:{
                    required:true
                },                
                address:{
                    required:true
                },
                religion:{
                    required:true
                },
                joining:{
                    required:true
                },
                from_date:{
                    required:true
                },
                to_date:{
                    required:true
                },
                class_name:{
                    required:true
                },
                tc_date:{
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