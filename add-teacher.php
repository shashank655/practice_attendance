<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$resultSubjects=$common_function->getAllSubjects(); 
$resultClasses = $common_function->getAllClassesName(); 
$teacher = new Teacher(); 
$userId = (isset($_REQUEST['userId'])) ? $_REQUEST['userId'] : NULL; 
if ($userId != NULL) { $result = $teacher->getTeacherInfo($userId); 
	if ($result == NULL) { $userId = ''; } } ?>
<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper">
	<!-- content -->
	<div class="content container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-7 col-md-12 col-sm-12 col-12">
					<h5 class="text-uppercase">add teacher</h5>
				</div>
				<div class="col-lg-5 col-md-12 col-sm-12 col-12">
					<ul class="list-inline breadcrumb float-right">
						<li class="list-inline-item"><a href="dashboard.php">Home</a>
						</li>
						<li class="list-inline-item">Add Teacher</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="card">
						<div class="page-title">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="page-title">basic information</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<form id="addTeacherForm" action="employee/process/processAddTeacher.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
								<input type="hidden" name="type" value="<?php echo $userId == '' ? 'Add' : 'Update'; ?>" />
								<input type="hidden" name="userId" value="<?php echo $userId; ?>" />
								<input type="hidden" name="oldEmailAddress" value='<?php if (isset($result[0]['email_address'])) echo $result[0]['email_address']; ?>'  />
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group custom-mt-form-group">
											<input type="text" placeholder="First Name" name="first_name" value="<?php
                                        		if (isset($result[0]['first_name']))
                                            	echo htmlspecialchars($result[0]['first_name']);
                                        		?>" />
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="text" placeholder="Email" name="email_address" value="<?php
                                        		if (isset($result[0]['email_address']))
                                            	echo htmlspecialchars($result[0]['email_address']);
                                        		?>" />
											<i class="bar"></i>
										</div>
										<!-- <div class="form-group custom-mt-form-group">
											<input placeholder="Password" type="password" id="password" name="password" />
											<i class="bar"></i>
										</div> -->
										<div class="form-group custom-mt-form-group">
											<select id="gender" name="gender">
												<option selected="" value="" disabled="">Gender</option>
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
											<label class="control-label"></label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input placeholder="Birth Date" class="datetimepicker" type="text" name="dob" value="<?php
                                        		if (isset($result[0]['dob']))
                                            	echo htmlspecialchars($result[0]['dob']);
                                        		?>">
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select id="class_id" name="class_id" onchange="getSections(this.value);">
											<option value='' >Select Class</option>
											<?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
												<option <?php if (isset($result[0]['class_id'])) { if ($result[0]['class_id']==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
											<?php endfor; ?>	
											</select>
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select name="section_id" id="section_id">
												<option value='' selected="" disabled="">Select Section</option>
											</select>
											<i class="bar"></i>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group custom-mt-form-group">
											<input placeholder="Lastname" type="text" name="last_name" value="<?php
                                        		if (isset($result[0]['last_name']))
                                            	echo htmlspecialchars($result[0]['last_name']);
                                        		?>">
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input placeholder="Joining Date" class="form-control floating datetimepicker" type="text" name="joining_date" value="<?php
                                        		if (isset($result[0]['joining_date']))
                                            	echo htmlspecialchars($result[0]['joining_date']);
                                        		?>">
											<i class="bar"></i>
										</div>
										<!-- <div class="form-group custom-mt-form-group">
											<input placeholder="Confirm Password" type="password" name="repeat_password" />
											<i class="bar"></i>
										</div> -->
										<div class="form-group custom-mt-form-group">
											<input placeholder="Mobile number" type="number" name="mobile_number" value="<?php
                                        		if (isset($result[0]['mobile_number']))
                                            	echo htmlspecialchars($result[0]['mobile_number']);
                                        		?>" />
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select name="subject_id" id="subject_id">
												<option selected="" disabled="" value="">Subject</option>
												<?php for ($i=0 ; $i < count($resultSubjects); $i++) : ?>
												<option <?php if (isset($result[0][ 'subject_id'])) { if ($result[0][ 'subject_id']==$resultSubjects[$i][ 'id']) { echo 'selected'; } } ?> value="
													<?php echo $resultSubjects[$i][ 'id']; ?>">
													<?php echo $resultSubjects[$i][ 'subject_name']; ?>
												</option>
												<?php endfor; ?>
											</select>
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input placeholder="ID" type="text" name="teacher_id" value="<?php
                                        		if (isset($result[0]['teacher_id']))
                                            	echo htmlspecialchars($result[0]['teacher_id']);
                                        		?>" />
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select id="is_class_teacher" name="is_class_teacher">
												<option selected="" disabled="" value="">Is Class Teacher ?</option>
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
											<i class="bar"></i>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<textarea  id="message" class="form__field" placeholder="Premanent Address" name="permanent_address"><?php if (isset($result[0][ 'permanent_address'])) echo $result[0][ 'permanent_address']; ?></textarea>
											<label for="message" class="form-label">Premanent Address</label>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group custom-mt-form-group">
											<input type="file" name="profile_image" id="profile_image" style="margin-bottom:10px;">
											<?php if($userId) { ?>
											<input type="hidden" name="profile_image_name" id="profile_image_name" value="<?php if (isset($result[0]['profile_image'])) echo $result[0]['profile_image']; ?>"/>
											<?php } ?>

											<?php if (!empty($result[0]['profile_image'])): ?>
                                            <span id="profile_image_div">    
                                            <img src="<?php if (isset($result[0]['profile_image'])) echo PROFILE_PIC_IMAGE_PATH . $result[0]['profile_image']; ?>" height="100" width="100"/>
                                            <span class="del_slider_img">
                                                <img src="<?php echo BASE_ROOT; ?>assets/img/cancel.png" style="cursor:pointer"/>
                                            </span>
                                        </span>
                                    <?php endif; ?>

											<label class="control-label"></label><i class="bar"></i>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group text-center custom-mt-form-group">
											<button class="btn btn-secondary mr-2" type="submit">Submit</button>
											<button class="btn btn-secondary" type="reset">Cancel</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">
	jQuery.validator.addMethod("isCheckEmailAddress", function(value, element) {
        var emailValue = $.trim(value);
        var oldEmailAddress = $("input[name=oldEmailAddress]").val();
        var check_result = false;
        $.ajax({
           type: "POST",
           async: false,
           url: "employee/process/processAddTeacher.php",
           data:{oldEmailAddress:oldEmailAddress, emailAddress:emailValue, type:'isCheckEmailAddress'},
           success: function(response)
           {
              // if the url exists, it returns a string "true"
              if(response == true) {
                check_result =  false;  // already exists
              } else {
                check_result =  true;   // url is free to use
              } 
           }
        });
        return check_result;
    }, "Email address is already exist!");

	jQuery.validator.addMethod("dropdownValidation", function(value, element, params) {        
        return $.trim(value) != '';
    },'This field is required.');

	$(function(){
        $("#addTeacherForm").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                first_name:{
                    required:true
                },                
                last_name:{
                    required:true
                },
                email_address:{
                    required:true,
                    email:true,
                    isCheckEmailAddress:true
                },
                gender:{
                    required:true,
                    dropdownValidation:true
                },
                subject_id:{
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
                is_class_teacher:{
                    required:true,
                    dropdownValidation:true
                },
                joining_date:{
                    required:true
                },
                mobile_number:{
                    required:true
                },
                dob:{
                    required:true
                },
                teacher_id:{
                    required:true
                },
                permanent_address:{
                    required:true
                }
            }
        });
    });

	<?php  if($userId!=''){ ?>        
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

    // for delete image
    	$(".del_slider_img").click(function(){
  			var r = confirm("Are you sure to delete this image?");
            if (r == true) {
               $("#profile_image_div").hide();
               $("#profile_image_name").val('');
            }
		});
</script>