<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php';
require_once 'employee/class/Exams.php'; 
require_once 'employee/class/ExamType.php';  
$exams=new Exams(); 
$teacher = new Teacher();
$exam_type=new ExamType();
$examTypeList = $exam_type->getExamTypeLists();
if($_SESSION['user_role'] == '2') {
    $output = $teacher->getTeacherClassName($_SESSION['userId']);
    $get_class_id = $output[0]['classId'];
    $get_section_id = $output[0]['sectionId'];
    $resultExamList=$exams->getClassTeachersExamsLists($get_class_id , $get_section_id);
} else {
    header('Location: ' . BASE_ROOT.'dashboard.php');
} 
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
                        <h5 class="text-uppercase">Add Student Marks</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item">Student Marks</li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Student Marks</h4>
                            <form id="examList" action="add-students-marks.php" method="post" enctype="multipart/form-data" novalidate="novalidate">  
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Select Exam Type</label>
                                    <div class="col-md-10">
                                        <select id="exam_type_id" class="form-control" name="exam_type_id" onchange="getExamNameList(this.value);">
                                            <option value="">Exam Type</option>
                                            <?php for ($i=0 ; $i < count($examTypeList); $i++) : ?>
                                                <option <?php if (isset($result[0]['exam_type_id'])) { if ($result[0]['exam_type_id']==$examTypeList[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $examTypeList[$i][ 'id']; ?>"><?php echo $examTypeList[$i][ 'exam_type']; ?></option>
                                            <?php endfor; ?>    
                                            </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Exam List</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="exam_id" id="exam_id">
                                            <option value='' selected="" disabled="">Select Exam List</option>
                                        </select>
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
        $("#examList").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                exam_type_id:{
                    required:true,
                    dropdownValidation:true
                },
                exam_id:{
                    required:true,
                    dropdownValidation:true
                }
            }
        });
    });

    function getExamNameList(examTypeID){
        var classId = <?php echo $get_class_id ?>;
        var sectionId = <?php echo $get_section_id ?>;
        $.ajax({
            type: "POST",
            url: "employee/process/processExamType.php",
            data:{type:'getExamNameList',examTypeID:examTypeID,classId:classId,sectionId:sectionId},
            beforeSend : function () {
                //$('#wait').html("Wait for checking");
            },
            success:function(data){                
                
                data = $.parseJSON(data);        
                if(data.length > 0){
                    $("#exam_id").html("<option value=''>Select Exam List</option>");
                    for(var i=0;i<data.length;i++){        
                       var option="<option value='"+data[i].examId+"'";
                            // if(data[i].id==exam_term_id){
                            //    option+=" selected";
                            // }
                           option+=" >"+'Session: '+data[i].year_session+', Start Date: '+data[i].start_date+', End Date: '+data[i].end_date+"</option>"
                        $("#exam_id").append(option);
                    }                    
                }else{
                    $("#exam_id").html("<option value='' selected >No result Found</option>");
                }
            }
        });
    }
    </script>