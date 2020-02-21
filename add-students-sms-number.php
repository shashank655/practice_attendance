<?php
require_once 'employee/class/dbclass.php'; 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';
require_once 'employee/class/SendStudentsSMS.php';
$send_sms = new SendStudentsSMS();

$studentId = (isset($_REQUEST['sID'])) ? $_REQUEST['sID'] : NULL; 
if ($studentId != NULL) { $result = $send_sms->getStudentInfo($studentId); 
    if ($result == NULL) { $studentId = ''; } }
    ?>
    <div class="page-wrapper"> <!-- content -->
        <div class="content container-fluid">
         <div class="page-header">
            <div class="row">
               <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                  <h5 class="text-uppercase">Add Students</h5>
              </div>
              <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                  <ul class="list-inline breadcrumb float-right">
                     <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                     <li class="list-inline-item"> Add Students</li>
                 </ul>
             </div>
         </div>
     </div>

     <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="card-title">Add Student</h4>
                <form id="addStudents" action="employee/process/processSendStudentsSMS.php" method="post" novalidate="novalidate">
                    <input type="hidden" name="type" value="<?php echo $studentId == '' ? 'Add' : 'Update'; ?>" />
                    <input type="hidden" name="studentId" value="<?php echo $studentId; ?>" />
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Student Name</label>
                        <div class="col-md-10">
                            <input type="text" name="student_name" class="form-control" value="<?php
                            if (isset($result[0]['student_name']))
                                echo htmlspecialchars($result[0]['student_name']);
                            ?>">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Father's Name</label>
                        <div class="col-md-10">
                            <input type="text" name="fathers_name" class="form-control" value="<?php
                            if (isset($result[0]['fathers_name']))
                                echo htmlspecialchars($result[0]['fathers_name']);
                            ?>">
                        </div>
                    </div> 
                    <div class="form-group row ">
                        <label class="col-form-label col-md-2">Mobile Number</label>
                        <div class="col-md-10">
                            <input type="text" name="mobile_number" class="form-control" value="<?php
                            if (isset($result[0]['mobile_number']))
                                echo htmlspecialchars($result[0]['mobile_number']);
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
        $("#addStudents").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                student_name:{
                    required:true
                },                
                fathers_name:{
                    required:true
                },                
                mobile_number:{
                    required:true,
                    number:true
                }
            }
        });
    });
</script>