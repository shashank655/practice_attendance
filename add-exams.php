<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Exams.php';
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$resultClasses = $common_function->getAllClassesName(); 
$exams=new Exams(); 
$examId = (isset($_REQUEST['examId'])) ? $_REQUEST['examId'] : NULL; 
if ($examId != NULL) { $result = $exams->getExamInfo($examId); 
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
                        <h5 class="text-uppercase">Add Exam</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Exam</li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Exam</h4>
                            <form id="addExams" action="employee/process/processExams.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $examId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="examId" value="<?php echo $examId; ?>" />
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Class</label>
                                    <div class="col-md-10">
                                        <select id="class_id" class="form-control" name="class_id" onchange="getSections(this.value);">
                                            <option value='' >Select Class</option>
                                            <?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
                                                <option <?php if (isset($result[0]['class_id'])) { if ($result[0]['class_id']==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
                                            <?php endfor; ?>    
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Section</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="section_id" id="section_id">
                                            <option value='' selected="" disabled="">Select Section</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Date</label>
                                    <div class="col-md-10">
                                        <input type="text" name="date_of_exam" class="form-control datetimepicker" value="<?php
                                                if (isset($result[0]['date_of_exam']))
                                                echo htmlspecialchars($result[0]['date_of_exam']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Exam Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="exam_name" class="form-control" value="<?php
                                                if (isset($result[0]['exam_name']))
                                                echo htmlspecialchars($result[0]['exam_name']);
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
        $("#addExams").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                date_of_exam:{
                    required:true
                },                
                exam_name:{
                    required:true
                }
            }
        });
    });
    <?php  if($examId!=''){ ?>        
        section_id='<?php echo $result[0]['section_id']; ?>';
        getSections('<?php echo $result[0]['class_id']; ?>');
     <?php }?>

    function getSections(classID){
        $.ajax({
            type: "POST",
            url: "employee/process/processAddTeacher.php",
            data:{type:'getSection',classID:classID},
            beforeSend : function () {
                //$('#wait').html("Wait for checking");
            },
            success:function(data){                
                
                data = $.parseJSON(data);         
                if(data.length > 0){
                    $("#section_id").html("<option value=''>Select Section</option>");
                    for(var i=0;i<data.length;i++){        
                       var option="<option value='"+data[i].id+"'";
                            if(data[i].id==section_id){
                               option+=" selected";
                            }
                           option+=" >"+data[i].section_name+"</option>"
                        $("#section_id").append(option);
                    }                    
                }else{
                    $("#section_id").html("<option value='' selected >No Section Found</option>");
                }
            }
        });
    }
    </script>