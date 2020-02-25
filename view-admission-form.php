<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/AdmissionForm.php'; 
require_once 'employee/class/Admin.php';
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$resultSubjects=$common_function->getAllSubjects(); 
$resultClasses = $common_function->getAllClassesName(); 
$admissionForm = new AdmissionForm(); 
$admin = new Admin();
$adminData = $admin->getAdminInfo($_SESSION['userId']);
$getLastId = $admissionForm->getLastFormId();
$admissionNo = date("Y").'00'.$getLastId[0]['id'];

$formId = (isset($_REQUEST['formId'])) ? $_REQUEST['formId'] : NULL; 
if ($formId != NULL) { $result = $admissionForm->getFormInfo($formId); 
	if ($result == NULL) { $formId = ''; } }
?>
<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<style type="text/css">
	.formHeaderBar, .formHeaderBar *{
		color:#336699;
	}
	.admissionForm *{
		color:#336699;
		border-color:#336699;
	}
	.adm-number {
		border: 1px solid #336699;
	}
	.admissionForm input[type="text"],
	.admissionForm input[type="number"],
	.admissionForm select{
		flex: auto;
		border-radius: 0;
		border:none;
		border-bottom: 1px solid #336699;
		flex:  auto;
		width: auto;
		color: #000;
	}
	.admissionForm label{
		text-transform: capitalize;
		margin-right: 5px;
	}
</style>
<div class="page-wrapper">
    <!-- content -->
    <div class="content container-fluid">
        <dib class="row">
            <div class="col  text-right d-print-none">
                <a href="javascript:void();" style="text-align: right;" id="print_button" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Print</a>
            </div>
        </dib>
        <div class="admissionForm print-div">
            <div class="row justify-content-between d-print-none formHeaderBar">
                <div class="col-md-3 text-md-left text-center"><img src="<?php echo BASE_ROOT; ?>assets/img/logo-tc.jpg" alt="school logo" width="80"></div>
                <div class="col-md-6 text-center pt-3">
                    <h3><?php echo $adminData[0]['school_name'];?></h3>
                    <p class="mb-1"><?php echo $adminData[0]['address'];?></p>
                    <p class="mb-1">Phone number: <?php echo $adminData[0]['phone_number'];?> </p>
                    <p class="mb-1">Email: <em><strong><?php echo $adminData[0]['email_address'];?></strong></em>
                </div>
                <div class="col-md-3 text-md-right text-center pt-5">
                    <p class="poweredBy" style="text-align: right">Powered by Adhyay <img src="<?php echo BASE_ROOT; ?>assets/img/adhyay-logo-color.png" style="width: 30px;"></p>
                </div>
            </div>
            <div class="row justify-content-between d-print-flex d-none formHeaderBar">
                <div class="col"><img src="<?php echo BASE_ROOT; ?>assets/img/logo-tc.jpg" alt="school logo" width="80"></div>
                <div class="col-6 text-center pt-3">
                    <h3><?php echo $adminData[0]['school_name'];?></h3>
                    <p class="mb-1"><?php echo $adminData[0]['address'];?></p>
                    <p class="mb-1">Phone number: <?php echo $adminData[0]['phone_number'];?> </p>
                    <p class="mb-1">Email: <em><strong><?php echo $adminData[0]['email_address'];?></strong></em>
                </div>
                <div class="col text-right pt-5">
                    <p class="poweredBy" style="text-align: right">Powered by Adhyay <img src="<?php echo BASE_ROOT; ?>assets/img/adhyay-logo-color.png" style="width: 30px;"></p>
                </div>
            </div>
            <form id="addStudentForm" action="employee/process/processAddAdmissionForm.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="type" value="Add">
                <input type="hidden" name="formType" value="admissionForm">
                <input type="hidden" name="studentId" value="">
                <div class="col-md-12 d-flex align-items-center justify-content-center">
                    <span class="adm-number px-3 py-2 mt-4 mb-5">
			<label>Admission Number: </label>
			<input class="ml-3 border-0 d-inline-block w-auto text-center" type="text" class="form-control" readonly="readonly" name="admission_no" value="<?php
            if (isset($result[0]['admission_no']))
                echo ($result[0]['admission_no']);
            ?>">
			<i class="bar"></i>
		</span>
                </div>
                <div class="row d-print-flex mb-3">
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?php
                    if (isset($result[0]['first_name']))
                        echo htmlspecialchars($result[0]['first_name']);
                ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="<?php
                    if (isset($result[0]['last_name']))
                        echo htmlspecialchars($result[0]['last_name']);
                ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">gender</label>
                            <select id="gender" name="gender" class="form-control">
                                <option selected="" value="" disabled="">Select Gender</option>
                    <option <?php if($result[0]['gender'] == 'male'){echo 'selected'; } ?> value="male">Male</option>
                    <option <?php if($result[0]['gender'] == 'female'){echo 'selected'; } ?> value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">joining date</label>
                            <input class="form-control floating datetimepicker" type="text" name="date_of_joining" value="<?php
                    if (isset($result[0]['date_of_joining']))
                    echo htmlspecialchars($result[0]['date_of_joining']);
                ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Birth date</label>
                            <input class="form-control datetimepicker" type="text" name="dob" value="<?php
                    if (isset($result[0]['dob']))
                    echo htmlspecialchars($result[0]['dob']);
                ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Mobile Number</label>
                            <input type="number" class="form-control" name="mobile_number" value="<?php
                    if (isset($result[0]['mobile_number']))
                    echo htmlspecialchars($result[0]['mobile_number']);
                ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Class</label>
                            <select id="class_id" class="form-control" name="class_id" onchange="getSections(this.value);">
                    <option value='' disabled="" selected="">Select Class</option>
                    <?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
                    <option <?php if (isset($result[0]['class_id'])) { if ($result[0]['class_id']==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
                    <?php endfor; ?>    
                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Section</label>
                            <select class="form-control" name="section_id" id="section_id">
                    <option value='' disabled="" selected="">Select Section</option>
                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Blood Group</label>
                            <input type="text" class="form-control" name="blood_group" value="<?php
                    if (isset($result[0]['blood_group']))
                    echo htmlspecialchars($result[0]['blood_group']);
                ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Religion</label>
                            <input type="text" class="form-control" name="religion" value="<?php
                    if (isset($result[0]['religion']))
                    echo htmlspecialchars($result[0]['religion']);
                ?>">
                        </div>
                    </div>
                </div>
                <h4 style="margin-bottom: 20px;">Parents Information</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Fathers Name</label>
                            <input type="text" class="form-control" name="fathers_name" value="bmnbnb">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Father's Adhar</label>
                            <input type="text" class="form-control" name="fathers_adhar_card" value="<?php
                            if (isset($result[0]['fathers_name']))
                                echo htmlspecialchars($result[0]['fathers_name']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Mother Name</label>
                            <input type="text" class="form-control" name="mothers_name" value="<?php
                            if (isset($result[0]['mothers_name']))
                                echo htmlspecialchars($result[0]['mothers_name']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Mother's Adhar</label>
                            <input type="text" class="form-control" name="mothers_adhar_card" value="<?php
                            if (isset($result[0]['mothers_adhar_card']))
                                echo htmlspecialchars($result[0]['mothers_adhar_card']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Father's Occupation</label>
                            <input type="text" class="form-control" name="fathers_occupation" value="<?php
                            if (isset($result[0]['fathers_occupation']))
                                echo htmlspecialchars($result[0]['fathers_occupation']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Mother's Occupation</label>
                            <input type="text" class="form-control" name="mothers_occupation" value="<?php
                            if (isset($result[0]['mothers_occupation']))
                                echo htmlspecialchars($result[0]['mothers_occupation']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email_address" value="<?php
                            if (isset($result[0]['email_address']))
                                echo htmlspecialchars($result[0]['email_address']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Phone Number</label>
                            <input type="number" class="form-control" name="parents_mobile_number" value="<?php
                            if (isset($result[0]['parents_mobile_number']))
                                echo htmlspecialchars($result[0]['parents_mobile_number']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Nationality</label>
                            <input type="text" class="form-control" name="nationality" value="<?php
                            if (isset($result[0]['nationality']))
                                echo htmlspecialchars($result[0]['nationality']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Religion</label>
                            <input type="text" class="form-control" name="religion" value="<?php
                            if (isset($result[0]['religion']))
                                echo htmlspecialchars($result[0]['religion']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Current Address</label>
                            <input type="text" class="form-control" name="current_address" value="<?php
                            if (isset($result[0]['current_address']))
                                echo htmlspecialchars($result[0]['current_address']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Permanent Add.</label>
                            <input type="text" class="form-control" name="present_address" value="<?php
                            if (isset($result[0]['present_address']))
                                echo htmlspecialchars($result[0]['present_address']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Guardian Name</label>
                            <input type="text" class="form-control" name="name_address_local_guardian" value="<?php
                            if (isset($result[0]['name_address_local_guardian']))
                                echo htmlspecialchars($result[0]['name_address_local_guardian']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <label for="">Name and address of previous school</label>
                            <input type="text" class="form-control" name="name_address_previous_school" value="<?php
                            if (isset($result[0]['name_address_previous_school']))
                                echo htmlspecialchars($result[0]['name_address_previous_school']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group d-flex">
                            <label for="">Number & Date of TC Isued</label>
                            <input type="text" class="form-control valid" name="name_date_tc_issued" value="<?php
                            if (isset($result[0]['name_date_tc_issued']))
                                echo htmlspecialchars($result[0]['name_date_tc_issued']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group d-flex">
                                    <label for="">Result of the previous exam</label>
                                    <input type="text" class="form-control" name="previous_school_result" value="<?php
                            if (isset($result[0]['previous_school_result']))
                                echo htmlspecialchars($result[0]['previous_school_result']);
                            ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group d-flex">
                                    <label for="">Percentage</label>
                                    <input type="text" class="form-control" name="previous_school_percentage" value="<?php
                            if (isset($result[0]['previous_school_percentage']))
                                echo htmlspecialchars($result[0]['previous_school_percentage']);
                            ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="text-center mt-4">Declaration by the parents</h4>
                <p class="text-center">I hereby declare that the above information furnshed by me is correct to the best of my knowledge and belief, if any information or document supplied by me found to incorrect, I will be responsible for the same.</p>
                <div class="row justify-content-between">
                    <div class="col-3">
                        <div class="form-group d-flex">
                            <label for="">Date: </label>
                            <input class="border-dark ml-2 form-control floating datetimepicker" type="text" name="todays_date" value="<?php
                            if (isset($result[0]['todays_date']))
                                echo htmlspecialchars($result[0]['todays_date']);
                            ?>">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group d-flex">
                            <label for="">Signature of the parents</label>
                            <input type="text" class="form-control border-dark" name="">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script src="employee/js/printThis.js"></script>
<script type="text/javascript">
	jQuery.validator.addMethod("dropdownValidation", function(value, element, params) {        
		return $.trim(value) != '';
	},'This field is required.');

	$(function(){
		$("#addStudentForm").validate({
			ignore: "input[type='text']:hidden",
			rules:{
				first_name:{
					required:true
				},                
				last_name:{
					required:true
				},
				gender:{
					required:true,
					dropdownValidation:true
				},
				class_id:{
					required:true,
					dropdownValidation:true
				},
				section_id:{
					required:true,
					dropdownValidation:true
				},
				date_of_joining:{
					required:true
				},
				mobile_number:{
					required:true
				},
				admission_no:{
					required:true
				},
				dob:{
					required:true
				},
				roll_number:{
					required:true
				},
				religion:{
					required:true
				},
				parents_mobile_number:{
					required:true
				},
				present_address:{
					required:true
				},
				permanent_address:{
					required:true
				}
			}
		});
	});

	<?php  if($studentId!=''){ ?>        
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
	
	$('#print_button').on("click", function () {
      $('.print-div').printThis({
                importCSS: true,
                loadCSS:"<?php echo BASE_ROOT; ?>assets/css/print.css"
            });
    });

    // for delete image
    $(".del_slider_img").click(function(){
    	var r = confirm("Are you sure to delete this image?");
    	if (r == true) {
    		$("#student_profile_image_div").hide();
    		$("#student_profile_image_name").val('');
    	}
    });

    $(".del_slider_img_parents").click(function(){
    	var r = confirm("Are you sure to delete this image?");
    	if (r == true) {
    		$("#parents_profile_image_div").hide();
    		$("#parents_profile_image_name").val('');
    	}
    });
</script>