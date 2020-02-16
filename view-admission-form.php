<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/AdmissionForm.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$resultSubjects=$common_function->getAllSubjects(); 
$resultClasses = $common_function->getAllClassesName(); 
$admissionForm = new AdmissionForm(); 
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
    .logo {
        height: 57px;
        margin-left: 10px;
        vertical-align: top;
    }
</style>
<div class="page-wrapper"> <!-- content -->
	<div class="content container-fluid">
	<div class="row">
        <div class="col-sm-8 col-9 text-right m-b-20">
            <a href="javascript:void();" id="print_button" class="btn btn-primary btn-rounded float-left"><i class="fa fa-plus"></i> Print</a>
        </div>
    </div>
	<div class="admissionForm print-div">
	<div class="row justify-content-between">
		<div class="col text-center"><img src="<?php echo BASE_ROOT; ?>assets/img/logo2.png" class="logo" alt="school logo"></div>
		<div class="col text-center">
			<h3>U.P. Global School</h3>
			<p>Affiliated to CBSE New Delhi</p>
		</div>
		<div class="col  text-center">
			<!-- <img src="" alt="student pic"> -->
		</div>
	</div>
	<form id="addStudentForm" action="employee/process/processAddAdmissionForm.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
	<input type="hidden" name="type" value="<?php echo $studentId == '' ? 'Add' : 'Update'; ?>" />
	<input type="hidden" name="formType" value="admissionForm" />
	<input type="hidden" name="studentId" value="<?php echo $studentId; ?>" />
	<div class="col-md-6">
			<label>Admission Number: </label>
			<input type="text" readonly="readonly" name="admission_no" value="<?php
			if (isset($result[0]['admission_no']))
				echo ($result[0]['admission_no']);
			?>"/>
			<i class="bar"></i>
		</div>
		<div class="row">
		  <div class="col-md-6">
		  		<div class="form-group">
		  		<input type="text"  class="form-control" placeholder="First Name" name="first_name" value="<?php
					if (isset($result[0]['first_name']))
						echo htmlspecialchars($result[0]['first_name']);
				?>"/>
			  	</div>
		  </div>
		  <div class="col-md-6">
		  		<div class="form-group">
			   	 	<input type="text"  class="form-control" placeholder="Last Name" name="last_name" value="<?php
					if (isset($result[0]['last_name']))
						echo htmlspecialchars($result[0]['last_name']);
				?>"/>
			  	</div>
		  </div>
		  <div class="col-md-6">
		  		<div class="form-group">
		  		<select id="gender" name="gender" class="form-control">
					<option selected="" value="" disabled="">Select Gender</option>
					<option <?php if($result[0]['gender'] == 'male'){echo 'selected'; } ?> value="male">Male</option>
					<option <?php if($result[0]['gender'] == 'female'){echo 'selected'; } ?> value="female">Female</option>
				</select>
			  	</div>
		  </div>
		   <div class="col-md-6">
		  		<div class="form-group">
		  		<input class="form-control floating datetimepicker" placeholder="Joining Date" type="text" name="date_of_joining" value="<?php
					if (isset($result[0]['date_of_joining']))
					echo htmlspecialchars($result[0]['date_of_joining']);
				?>">
			  	</div>
		  </div>
		  <div class="col-md-6">
		  		<div class="form-group">
		  		<input class="form-control datetimepicker" placeholder="Birth Date" type="text" name="dob" value="<?php
					if (isset($result[0]['dob']))
					echo htmlspecialchars($result[0]['dob']);
				?>">
			  	</div>
		  </div>
		  <div class="col-md-6">
		  		<div class="form-group">
		  		<input type="number" class="form-control" name="mobile_number" placeholder="Mobile number" value="<?php
					if (isset($result[0]['mobile_number']))
					echo htmlspecialchars($result[0]['mobile_number']);
				?>" />
			  	</div>
		  </div>
		  <div class="col-md-6">
		  		<div class="form-group">
		  		<select id="class_id" class="form-control" name="class_id" onchange="getSections(this.value);">
					<option value='' disabled="" selected="">Select Class</option>
					<?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
					<option <?php if (isset($result[0]['class_id'])) { if ($result[0]['class_id']==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
					<?php endfor; ?>	
				</select>
			  	</div>
		  </div>
		  <div class="col-md-6">
		  		<div class="form-group">
		  		<input type="text" class="form-control" name="blood_group" placeholder="Blood Group" value="<?php
					if (isset($result[0]['blood_group']))
					echo htmlspecialchars($result[0]['blood_group']);
				?>" />
			  	</div>
		  </div>
		   <div class="col-md-6">
		  		<div class="form-group">
		  		<select class="form-control" name="section_id" id="section_id">
					<option value='' disabled="" selected="">Select Section</option>
				</select>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
		  		<div class="form-group">
		  		<input type="text" class="form-control" name="religion" placeholder="Religion" value="<?php
					if (isset($result[0]['religion']))
						echo htmlspecialchars($result[0]['religion']);
					?>"/>
			  	</div>
		  	</div>
		</div>
		<h4>Parents Information</h4>
		<div class="row">
			<div class="col-md-6">
		  		<div class="row flex-wrap text-nowrap">
		  			<div class="col">
		  				<div class="form-group">
		  				<input type="text" class="form-control" name="fathers_name" placeholder="Father Name" value="<?php
							if (isset($result[0]['fathers_name']))
								echo htmlspecialchars($result[0]['fathers_name']);
							?>"/>
					  	</div>
		  			</div>
		  			<div class="col">
		  				<div class="form-group">
					   	 	<input type="text" class="form-control" name="fathers_adhar_card" placeholder="Adhar Card Number" value="<?php
							if (isset($result[0]['fathers_adhar_card']))
								echo htmlspecialchars($result[0]['fathers_adhar_card']);
							?>"/>
					  	</div>
		  			</div>
		  		</div>
		  	</div>
		  	<div class="col-md-6">
		  		<div class="row flex-wrap text-nowrap">
		  			<div class="col">
		  				<div class="form-group">
		  				<input type="text"  class="form-control" name="mothers_name" placeholder="Mother Name" value="<?php
							if (isset($result[0]['mothers_name']))
								echo htmlspecialchars($result[0]['mothers_name']);
							?>"/>
					  	</div>
		  			</div>
		  			<div class="col">
		  				<div class="form-group">
					   	 	<input type="text" class="form-control" name="mothers_adhar_card" placeholder="Mother's Adhar Number" value="<?php
							if (isset($result[0]['mothers_adhar_card']))
								echo htmlspecialchars($result[0]['mothers_adhar_card']);
							?>"/>
					  	</div>
		  			</div>
		  		</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="fathers_occupation" placeholder="Father Occupation" value="<?php
					if (isset($result[0]['fathers_occupation']))
						echo htmlspecialchars($result[0]['fathers_occupation']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="mothers_occupation" placeholder="Mother Occupation" value="<?php
					if (isset($result[0]['mothers_occupation']))
						echo htmlspecialchars($result[0]['mothers_occupation']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="email_address" placeholder="Email" value="<?php
					if (isset($result[0]['email_address']))
						echo htmlspecialchars($result[0]['email_address']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="nationality" placeholder="Nationality" value="<?php
					if (isset($result[0]['nationality']))
						echo htmlspecialchars($result[0]['nationality']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="number" class="form-control" name="parents_mobile_number" placeholder="Mobile number" value="<?php
					if (isset($result[0]['parents_mobile_number']))
						echo htmlspecialchars($result[0]['parents_mobile_number']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="present_address" placeholder="Present Address" value="<?php
					if (isset($result[0]['present_address']))
						echo htmlspecialchars($result[0]['present_address']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="current_address" placeholder="Current address/ Office address" value="<?php
					if (isset($result[0]['current_address']))
						echo htmlspecialchars($result[0]['current_address']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="number" class="form-control" name="annual_income" placeholder="Annual Income" value="<?php
					if (isset($result[0]['annual_income']))
						echo htmlspecialchars($result[0]['annual_income']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="name_address_local_guardian" placeholder="Name and address of the local guardian" value="<?php
					if (isset($result[0]['name_address_local_guardian']))
						echo htmlspecialchars($result[0]['name_address_local_guardian']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="name_address_previous_school" placeholder="Name and address of previous school with class" value="<?php
					if (isset($result[0]['name_address_previous_school']))
						echo htmlspecialchars($result[0]['name_address_previous_school']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group"><input type="text" class="form-control" name="name_date_tc_issued" placeholder="Number and date of T.C. issued by previous school with status of result" value="<?php
					if (isset($result[0]['name_date_tc_issued']))
						echo htmlspecialchars($result[0]['name_date_tc_issued']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="previous_school_cbse_status" placeholder="Whether previous school was affliated with CBSE school. (Yes/No)" value="<?php
					if (isset($result[0]['previous_school_cbse_status']))
						echo htmlspecialchars($result[0]['previous_school_cbse_status']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="form-group">
  				<input type="text" class="form-control" name="previous_school_board_name" placeholder="If the previous schools was not affliated with CBSE, specify name of the board" value="<?php
					if (isset($result[0]['previous_school_board_name']))
						echo htmlspecialchars($result[0]['previous_school_board_name']);
					?>"/>
			  	</div>
		  	</div>
		  	<div class="col-md-6">
  				<div class="row">
  					<div class="col">
  						<div class="form-group">
  						<input type="text" class="form-control" name="previous_school_result" placeholder="Result of the previous examination" value="<?php
					if (isset($result[0]['previous_school_result']))
						echo htmlspecialchars($result[0]['previous_school_result']);
					?>"/>
					  	</div>
  					</div>
  					<div class="col">
  						<div class="form-group">
  						<input type="text" class="form-control" name="previous_school_percentage" placeholder="Percentage" value="<?php
					if (isset($result[0]['previous_school_percentage']))
						echo htmlspecialchars($result[0]['previous_school_percentage']);
					?>"/>
					  	</div>
  					</div>
  				</div>
		  	</div>
			<div class="col-md-6">
				<div class="form-group">
				<input type="text" class="form-control" name="tc_attached_status" placeholder="Wether the transfer certificate is attached: Yes/No" value="<?php
					if (isset($result[0]['tc_attached_status']))
						echo htmlspecialchars($result[0]['tc_attached_status']);
					?>"/>
			  	</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col">
						<div class="form-group">
						<input type="text" class="form-control" name="mother_tongue" placeholder="Mother tongue" value="<?php
					if (isset($result[0]['mother_tongue']))
						echo htmlspecialchars($result[0]['mother_tongue']);
					?>"/>
				  	</div>
					</div>
					<div class="col">
						<div class="form-group">
						<input type="text" class="form-control" name="home_town" placeholder="Home town" value="<?php
					if (isset($result[0]['home_town']))
						echo htmlspecialchars($result[0]['home_town']);
					?>"/>
				  	</div>
					</div>
				</div>
			</div>
		</div>
		<h4 class="text-center">Declaration by the parents</h4>
		<p class="text-center">I hereby declare that the above information furnshed by me is correct to the best of my knowledge and belief, if any information or document supplied by me found to incorrect, I will be responsible for the same.</p>
		<div class="row justify-content-between">
			<div class="col-md-2">
				<div class="d-flex">
					<div class="form-group">
					Date: <input class="border-dark ml-2 form-control floating datetimepicker" type="text" name="todays_date" value="<?php
					if (isset($result[0]['todays_date']))
					echo htmlspecialchars($result[0]['todays_date']);
				?>"> 
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
				<input type="text" class="form-control border-dark" placeholder="Signature of the parents" name="">
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
      $('.print-div').printThis();
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