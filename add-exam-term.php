<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/ExamType.php'; 
$exam_type=new ExamType();
$examTypeList = $exam_type->getExamTypeLists();
$examTermId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL;
if ($examTermId != NULL) { $result = $exam_type->getExamTermInfo($examTermId); 
    if ($result == NULL) { $examTermId = ''; } } 
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
                        <h5 class="text-uppercase">Add Exam Term</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item">Exam Term</li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <form id="addExamTerm" action="employee/process/processExamType.php" method="post" enctype="multipart/form-data" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $examTermId == '' ? 'AddExamTerm' : 'UpdateExamTerm'; ?>" />
                            <input type="hidden" name="examTermId" value="<?php echo $examTermId; ?>" />
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Select Exam Type</label>
                                    <div class="col-md-10">
                                        <select id="exam_type_id" class="form-control" name="exam_type_id">
                                            <option value="">Exam Type</option>
                                            <?php for ($i=0 ; $i < count($examTypeList); $i++) : ?>
                                                <option <?php if (isset($result[0]['exam_type_id'])) { if ($result[0]['exam_type_id']==$examTypeList[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $examTypeList[$i][ 'id']; ?>"><?php echo $examTypeList[$i][ 'exam_type']; ?></option>
                                            <?php endfor; ?>    
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Session</label>
                                    <div class="col-md-10">
                                        <select id="year_session" class="form-control" name="year_session">
                                            <option value='' >Select Year</option>
                                            <option <?php if (isset($result[0][ 'year_session'])) { if ($result[0][ 'year_session']=='2018-19') { echo 'selected'; } } ?>  value='2018-19'>2018-19</option>
                                            <option <?php if (isset($result[0][ 'year_session'])) { if ($result[0][ 'year_session']=='2019-20') { echo 'selected'; } } ?>  value='2019-20'>2019-20</option>
                                            <option <?php if (isset($result[0][ 'year_session'])) { if ($result[0][ 'year_session']=='2020-21') { echo 'selected'; } } ?>  value='2020-21'>2020-21</option>
                                            <option <?php if (isset($result[0][ 'year_session'])) { if ($result[0][ 'year_session']=='2021-22') { echo 'selected'; } } ?>  value='2021-22'>2021-22</option>
                                            <option <?php if (isset($result[0][ 'year_session'])) { if ($result[0][ 'year_session']=='2022-23') { echo 'selected'; } } ?>  value='2022-23'>2022-23</option>
                                            <option <?php if (isset($result[0][ 'year_session'])) { if ($result[0][ 'year_session']=='2023-24') { echo 'selected'; } } ?>  value='2023-24'>2023-24</option>
                                            <option <?php if (isset($result[0][ 'year_session'])) { if ($result[0][ 'year_session']=='2024-25') { echo 'selected'; } } ?>  value='2024-25'>2024-25</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Start Date</label>
                                    <div class="col-md-10">
                                        <input type="text" name="start_date" class="form-control datetimepicker" value="<?php
                                                if (isset($result[0]['start_date']))
                                                echo htmlspecialchars($result[0]['start_date']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">End Date</label>
                                    <div class="col-md-10">
                                        <input type="text" name="end_date" class="form-control datetimepicker" value="<?php
                                                if (isset($result[0]['end_date']))
                                                echo htmlspecialchars($result[0]['end_date']);
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
    <script type="text/javascript">
    jQuery.validator.addMethod("dropdownValidation", function(value, element, params) {        
        return $.trim(value) != '';
    },'This field is required.');

    $(function(){
        $("#addExamTerm").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                exam_type_id:{
                    required:true,
                    dropdownValidation:true
                },
                start_date:{
                    required:true
                },
                end_date:{
                    required:true
                },                
                year_session:{
                    required:true
                }
            }
        });
    });
    </script>