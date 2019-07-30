<?php 
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php'; 
require_once 'employee/class/ExamType.php';
$exam_type = new ExamType();

$examTypeId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
if ($examTypeId != NULL) { $result = $exam_type->getExamTypeInfo($examTypeId); 
    if ($result == NULL) { $examTypeId = ''; } }
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
                        <h5 class="text-uppercase">Exam Type</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Exam Type</li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <form id="addExamType" action="employee/process/processExamType.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $examTypeId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="examTypeId" value="<?php echo $examTypeId; ?>" />
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Exam Type</label>
                                    <div class="col-md-10">
                                        <input type="text" name="exam_type" class="form-control" value="<?php
                                                if (isset($result[0]['exam_type']))
                                                echo htmlspecialchars($result[0]['exam_type']);
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
        $("#addExamType").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                exam_type:{
                    required:true
                }
            }
        });
    });
    </script>