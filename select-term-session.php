<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Exams.php'; 
require_once 'employee/class/ExamType.php'; 
$exam_type=new ExamType(); 
$examTypeList = $exam_type->getExamTypeLists();
$exams=new Exams();
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
                        <h5 class="text-uppercase">Select Term</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Select Term</li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Exam</h4>
                            <form id="addExams" action="students-result.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $examId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="examId" value="<?php echo $examId; ?>" />
                            <div class="form-group row">
                                    <label class="col-form-label col-md-2">Select Exam Type</label>
                                    <div class="col-md-10">
                                        <select id="exam_type_id" class="form-control" name="exam_type_id" onchange="getExamTerm(this.value);">
                                            <option value="">Exam Type</option>
                                            <?php for ($i=0 ; $i < count($examTypeList); $i++) : ?>
                                                <option <?php if (isset($result[0]['exam_type_id'])) { if ($result[0]['exam_type_id']==$examTypeList[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $examTypeList[$i][ 'id']; ?>"><?php echo $examTypeList[$i][ 'exam_type']; ?></option>
                                            <?php endfor; ?>    
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Select Exam Term</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="exam_term_id" id="exam_term_id">
                                            <option value='' selected="" disabled="">Select Exam Term</option>
                                        </select>
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
    jQuery.validator.addMethod("dropdownValidation", function(value, element, params) {        
        return $.trim(value) != '';
    },'This field is required.');
        
    $(function(){
        $("#addExams").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                exam_type_id:{
                    required:true,
                    dropdownValidation:true
                },
                exam_term_id:{
                    required:true,
                    dropdownValidation:true
                }
            }
        });
    });
    <?php  if($examId!=''){ ?>        
        exam_term_id='<?php echo $result[0]['exam_term_id']; ?>';
        getExamTerm('<?php echo $result[0]['exam_type_id']; ?>');
     <?php }?>

    function getExamTerm(examTypeID){
        $.ajax({
            type: "POST",
            url: "employee/process/processExamType.php",
            data:{type:'getExamTerm',examTypeID:examTypeID},
            beforeSend : function () {
                //$('#wait').html("Wait for checking");
            },
            success:function(data){                
                
                data = $.parseJSON(data);         
                if(data.length > 0){
                    $("#exam_term_id").html("<option value=''>Select Exam Term</option>");
                    for(var i=0;i<data.length;i++){        
                       var option="<option value='"+data[i].id+"'";
                            if(data[i].id==exam_term_id){
                               option+=" selected";
                            }
                           option+=" >"+'Session: '+data[i].year_session+', Start Date: '+data[i].start_date+', End Date: '+data[i].end_date+"</option>"
                        $("#exam_term_id").append(option);
                    }                    
                }else{
                    $("#exam_term_id").html("<option value='' selected >No result Found</option>");
                }
            }
        });
    }
    </script>