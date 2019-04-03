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
						<li class="list-inline-item"><a href="index.html">Home</a>
						</li>
						<li class="list-inline-item"><a href="index.html">Teacher</a>
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
							<?php if (isset($_SESSION[ 'Msg']) && $_SESSION[ 'Msg'] !='' ) { ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong>Error!</strong> 
								<?php echo $_SESSION[ 'Msg']; ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
								</button>
							</div>
							<script>
								setTimeout(function() {
								                    $(".alert").fadeOut("slow");
								                }, 5000)
							</script>
							<?php $_SESSION[ 'Msg']='' ; unset($_SESSION[ 'Msg']); } ?>
							<form id="addTeacherForm" action="employee/process/processAddTeacher.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
								<input type="hidden" name="type" value="<?php echo $userId == '' ? 'Add' : 'Update'; ?>" />
								<input type="hidden" name="userId" value="<?php echo $userId; ?>" />
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group custom-mt-form-group">
											<input type="text" name="first_name" value="<?php
                                        		if (isset($result[0]['first_name']))
                                            	echo htmlspecialchars($result[0]['first_name']);
                                        		?>" />
											<label class="control-label">Firstname</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="text" name="email_address" value="<?php
                                        		if (isset($result[0]['email_address']))
                                            	echo htmlspecialchars($result[0]['email_address']);
                                        		?>" />
											<label class="control-label">Email</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="password" name="password" />
											<label class="control-label">Password</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select id="gender" name="gender">
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
											<label class="control-label">Gender</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input class="datetimepicker" type="text" name="dob" value="<?php
                                        		if (isset($result[0]['dob']))
                                            	echo htmlspecialchars($result[0]['dob']);
                                        		?>">
											<label class="control-label">Birth Date</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select name="class_id" id="class_id" onclick="getSections(this.value);">
												<?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
												<option <?php if (isset($result[0][ 'class_id'])) { if ($result[0][ 'class_id']==$resultClasses[$i][ 'id']) { echo 'selected'; } } ?>value="
													<?php echo $resultSubjects[$i][ 'id']; ?>">
													<?php echo $resultClasses[$i][ 'class_name']; ?>
												</option>
												<?php endfor; ?>
											</select>
											<label class="control-label">Class Name</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select name="section_id" id="section_id">
											</select>
										</div>
										<div class="form-group custom-mt-form-group">
											<select class="select2" id="is_class_teacher" name="is_class_teacher">
												<option value="1">Yes</option>
												<option value="0">No</option>
											</select>
											<label class="control-label">Is Class Teacher ?</label><i class="bar"></i>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group custom-mt-form-group">
											<input type="text" name="last_name" value="<?php
                                        		if (isset($result[0]['last_name']))
                                            	echo htmlspecialchars($result[0]['last_name']);
                                        		?>">
											<label class="control-label">Lastname</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input class="form-control floating datetimepicker" type="text" name="joining_date" value="<?php
                                        		if (isset($result[0]['joining_date']))
                                            	echo htmlspecialchars($result[0]['joining_date']);
                                        		?>">
											<label class="control-label">Joining Date</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="password" name="repeat_password" />
											<label class="control-label">Confirm Password</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="number" name="mobile_number" value="<?php
                                        		if (isset($result[0]['mobile_number']))
                                            	echo htmlspecialchars($result[0]['mobile_number']);
                                        		?>" />
											<label class="control-label">Mobile number</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<select class="select2" name="subject_id" id="subject_id">
												<?php for ($i=0 ; $i < count($resultSubjects); $i++) : ?>
												<option <?php if (isset($result[0][ 'subject_id'])) { if ($result[0][ 'subject_id']==$resultSubjects[$i][ 'id']) { echo 'selected'; } } ?>value="
													<?php echo $resultSubjects[$i][ 'id']; ?>">
													<?php echo $resultSubjects[$i][ 'subject_name']; ?>
												</option>
												<?php endfor; ?>
											</select>
											<label class="control-label">Subject</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="text" name="teacher_id" value="<?php
                                        		if (isset($result[0]['teacher_id']))
                                            	echo htmlspecialchars($result[0]['teacher_id']);
                                        		?>" />
											<label class="control-label">ID</label><i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="text" name="section" value="<?php
                                        		if (isset($result[0]['section']))
                                            	echo htmlspecialchars($result[0]['section']);
                                        		?>" />
											<label class="control-label">Section</label><i class="bar"></i>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<textarea id="message" class="form__field" placeholder="Premanent Address" rows="4" name="permanent_address"></textarea>
											<?php if (isset($result[0][ 'permanent_address'])) echo $result[0][ 'permanent_address']; ?>
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
											<button class="btn btn-primary mr-2" type="submit">Submit</button>
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
                if(data){
                    $("#section_id").html("<option value=' '>Section Name</option>");
                    for(var i=0;i<data.length;i++){             
                       var option="<option value='"+data[i].id+"'";
                           option+=" >"+data[i].section_name+"</option>"
                        $("#section_id").append(option);
                    }                    
                }else{alert("d");
                    $("#section_id").html("<option value=' ' selected >Section Name</option>");
                }
                $("#section_id").select2();
                
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