<?php
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php';
require_once 'employee/class/StudentAttendance.php'; 
require_once 'employee/class/Teacher.php';
require_once 'employee/class/CommonFunction.php';
$common_function=new CommonFunction();  
$resultClasses = $common_function->getAllClassesName();

$student_attendance = new StudentAttendance();
$teacher = new Teacher();
if($_SESSION['user_role'] == '1') { 
    $class_id = (isset($_REQUEST['class_id'])) ? $_REQUEST['class_id'] : NULL;
        $get_class_id = $class_id;
    $section_id = (isset($_REQUEST['section_id'])) ? $_REQUEST['section_id'] : NULL;
        $get_section_id = $section_id;
    $searchYear = (isset($_REQUEST['year'])) ? $_REQUEST['year'] : NULL;
        $get_selected_year = $searchYear;
    $searchMonth = (isset($_REQUEST['month'])) ? $_REQUEST['month'] : NULL;
        $get_selected_month = $searchMonth;      
    $get_all_student_details = $student_attendance->getAllClassesStudentDetails($get_class_id , $get_section_id);
    $get_selected_month_days = cal_days_in_month(CAL_GREGORIAN, $searchMonth, $get_selected_year);
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
							<h5 class="text-uppercase">attendance sheet</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
								<li class="list-inline-item"> Attendance List</li>
							</ul>
						</div>

                    <!-- <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="student-attendance.php" class="float-right btn-rounded">Take today's Attendance</a>
                    </div> -->
					</div>
				</div>
				<div class="content-page">
                 <form id="searchAttendance" action="all-students-attendance-list.php" method="get" novalidate="novalidate">
				 <div class="row">
                    <!-- <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text" />
							<label class="control-label">Employee name</label><i class="bar"></i>
						</div>
                    </div> -->
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <select id="class_id" name="class_id" onchange="getSections(this.value);">
                                <option value='' disabled="" selected="">Select Class</option>
                                    <?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
                                        <option <?php if (isset($get_class_id)) { if ($get_class_id==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
                                    <?php endfor; ?>
                             </select>
                             <label class="control-label">Select Class</label><i class="bar"></i>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <select name="section_id" id="section_id">
                                <option value='' disabled="" selected="">Select Section</option>
                            </select>
                             <label class="control-label">Select Section</label><i class="bar"></i>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<select name="month" id="month">
                                <option value="">Select Month</option>
                                <option <?php if($get_selected_month == '01'){echo 'selected'; } ?> value="01">Jan</option>
                                <option <?php if($get_selected_month == '02'){echo 'selected'; } ?> value="02">Feb</option>
                                <option <?php if($get_selected_month == '03'){echo 'selected'; } ?> value="03">Mar</option>
                                <option <?php if($get_selected_month == '04'){echo 'selected'; } ?> value="04">Apr</option>
                                <option <?php if($get_selected_month == '05'){echo 'selected'; } ?> value="05">May</option>
                                <option <?php if($get_selected_month == '06'){echo 'selected'; } ?> value="06">Jun</option>
                                <option <?php if($get_selected_month == '07'){echo 'selected'; } ?> value="07">Jul</option>
                                <option <?php if($get_selected_month == '08'){echo 'selected'; } ?> value="08">Aug</option>
                                <option <?php if($get_selected_month == '09'){echo 'selected'; } ?> value="09">Sep</option>
                                <option <?php if($get_selected_month == '10'){echo 'selected'; } ?> value="10">Oct</option>
                                <option <?php if($get_selected_month == '11'){echo 'selected'; } ?> value="11">Nov</option>
                                <option <?php if($get_selected_month == '12'){echo 'selected'; } ?> value="12">Dec</option>
							 </select>
							 <label class="control-label">Select Month</label><i class="bar"></i>
						</div>	
                    </div>
                    <div class="col-sm-6 col-md-3">
					<div class="form-group custom-mt-form-group">
							<select name="year" id="year">
                                <option value="">Select Year</option>
                                <option <?php if($get_selected_year == '2021'){echo 'selected'; } ?> value="2021">2021</option>
                                <option <?php if($get_selected_year == '2020'){echo 'selected'; } ?> value="2020">2020</option>
                                <option <?php if($get_selected_year == '2019'){echo 'selected'; } ?> value="2019">2019</option>
							 </select>
							 <label class="control-label">Select Year</label><i class="bar"></i>
						</div>	
                       
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
						</div>
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered m-b-0">
                                <thead>
                                    <tr>
                                        <th>Students</th>
                                        <?php for ($i=1; $i <= $get_selected_month_days; $i++) { ?>
                                        <th>Day <?php echo $i; ?></th>
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($get_all_student_details)) { 
                                        foreach ($get_all_student_details as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                    <?php
                                    $student_id = $value['student_id'];  
                                        $get_selected_month_attendance = $student_attendance->getSelectedMonthAttendance($get_class_id ,  $get_selected_month , $get_selected_year , $student_id , $get_selected_month_days);
                                        if(!empty($get_selected_month_attendance)) {
                                            foreach ($get_selected_month_attendance as $key1 => $value1) { 
                                                if($value1['output'] == 'A') {
                                                    $class = 'fa fa-times text-danger';
                                                } elseif($value1['output'] == 'P') {
                                                    $class = 'fa fa-check text-success';
                                                } elseif($value1['output'] == 'S') {
                                                    $class = '';
                                                } else {
                                                    $class = 'fa fa-check fa fa-minus';
                                                }
                                            ?>    
                                        <td><?php echo $value1['output']; ?></td>
                                    <?php } } ?>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
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
        $("#searchAttendance").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                class_id:{
                    required:true,
                    dropdownValidation:true
                },                
                section_id:{
                    required:true,
                    dropdownValidation:true
                },
                month:{
                    required:true,
                    dropdownValidation:true
                },
                year:{
                    required:true,
                    dropdownValidation:true
                }
            }
        });
    });

        <?php  if($get_class_id!=''){ ?>
            section_id='<?php echo $get_section_id; ?>';        
            getSections('<?php echo $get_class_id; ?>');
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
                console.log(data);        
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