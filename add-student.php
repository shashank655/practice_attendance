<?php 
   require_once 'employee/class/dbclass.php'; 
   require_once 'employee/config/config.php'; 
   require_once 'employee/class/Student.php'; 
   require_once 'employee/class/CommonFunction.php'; 
   require_once 'employee/class/Accounts.php';
   $common_function=new CommonFunction(); 
   $accounts = new Accounts();
   $resultSubjects=$common_function->getAllSubjects(); 
   $resultClasses = $common_function->getAllClassesName();
   $resultClasses = $common_function->getAllClassesName(); 
   $get_trans_fees = $accounts->getTransportationFees();
   $student = new Student(); 
   $studentId = (isset($_REQUEST['studentId'])) ? $_REQUEST['studentId'] : NULL; 
   if ($studentId != NULL) { $result = $student->getStudentInfo($studentId); 
   	if ($result == NULL) { $studentId = ''; } }?>
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
               <h5 class="text-uppercase">Add Student</h5>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
               <ul class="list-inline breadcrumb float-right">
                  <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                  <li class="list-inline-item"> Add Student</li>
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
                           <div class="Page-title">Student information</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form id="addStudentForm" action="employee/process/processAddStudent.php" method="post" novalidate="novalidate" enctype="multipart/form-data" class="custom-mt-form">
                        <input type="hidden" name="type" value="<?php echo $studentId == '' ? 'Add' : 'Update'; ?>" />
                        <input type="hidden" name="oldAdmissionNo" value='<?php if (isset($result[0]['admission_no'])) echo $result[0]['admission_no']; ?>'  />
                        <input type="hidden" name="oldParentEmail" value='<?php if (isset($result[0]['parents_email_address'])) echo $result[0]['parents_email_address']; ?>'  />
                        <input type="hidden" name="studentId" value="<?php echo $studentId; ?>" />
                        <div class="row">
                           <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                              <div class="form-group custom-mt-form-group">
                                 <input type="text"  placeholder="*First Name" name="first_name" value="<?php
                                    if (isset($result[0]['first_name']))
                                      	echo htmlspecialchars($result[0]['first_name']);
                                    ?>"/>
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <select id="gender" name="gender">
                                    <option selected="" value="" disabled="">*Select Gender</option>
                                    <option <?php if($result[0]['gender'] == 'male'){echo 'selected'; } ?> value="male">Male</option>
                                    <option <?php if($result[0]['gender'] == 'female'){echo 'selected'; } ?> value="female">Female</option>
                                 </select>
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <input class="datetimepicker" placeholder="Birth Date" type="text" name="dob" value="<?php
                                    if (isset($result[0]['dob']))
                                      	echo htmlspecialchars($result[0]['dob']);
                                    ?>"> 
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <select id="class_id" name="class_id" onchange="getSections(this.value);">
                                    <option value='' disabled="" selected="">*Select Class</option>
                                    <?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
                                    <option <?php if (isset($result[0]['class_id'])) { if ($result[0]['class_id']==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
                                    <?php endfor; ?>	
                                 </select>
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <select name="section_id" id="section_id">
                                    <option value='' disabled="" selected="">*Select Section</option>
                                 </select>
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <input type="text"  name="religion" placeholder="Religion" value="<?php
                                    if (isset($result[0]['religion']))
                                      	echo htmlspecialchars($result[0]['religion']);
                                    ?>"/>
                                 <i class="bar"></i>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                              <div class="form-group custom-mt-form-group">
                                 <input type="text"  name="last_name" placeholder="*Last Name" value="<?php
                                    if (isset($result[0]['last_name']))
                                      	echo htmlspecialchars($result[0]['last_name']);
                                    ?>">
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <input class="form-control floating datetimepicker" placeholder="Joining Date" type="text" name="date_of_joining" value="<?php
                                    if (isset($result[0]['date_of_joining']))
                                      	echo htmlspecialchars($result[0]['date_of_joining']);
                                    ?>">
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <input type="text"  name="admission_no" placeholder="*Admission No" value="<?php
                                    if (isset($result[0]['admission_no']))
                                      	echo htmlspecialchars($result[0]['admission_no']);
                                    ?>"/>
                                 <i class="bar"></i>
                              </div>
                              <div class="form-group custom-mt-form-group">
                                 <input type="text"  name="roll_number" placeholder="Roll Number" value="<?php
                                    if (isset($result[0]['roll_number']))
                                      	echo htmlspecialchars($result[0]['roll_number']);
                                    ?>"/>
                                 <i class="bar"></i>
                              </div>
                           </div>
                            <div class="page-title w-100 mt-4">
                              <div class="row">
                                 <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="page-title pl-3">Transportation</div>
                                 </div>
                              </div>
                           </div>

                           <div class="card-body w-100 p-3">
                              <div class="row">
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group custom-mt-form-group">
                                       <select id="transportation_taken" name="transportation_taken">
                                          <option <?php if($result[0]['transportation_taken'] == 'no'){echo 'selected'; } ?> value="no">No</option>
                                          <option <?php if($result[0]['transportation_taken'] == 'yes'){echo 'selected'; } ?> value="yes">Yes</option>
                                       </select>
                                       <i class="bar"></i>
                                    </div>
                                 </div>
                                 <?php 
                                    if(!empty($result[0]['transportation_id'])) {
                                       $styleValue = "";
                                    } else {
                                       $styleValue = "display: none;";
                                    }
                                 ?>
                                 <div id="transportation_section" style="<?php echo $styleValue; ?>" class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group custom-mt-form-group">
                                    <select id="transportation_id" name="transportation_id" >
                                       <option value='' disabled="" selected="">Select Route</option>
                                       <?php foreach ($get_trans_fees->results as $fees) : ?>   
                                       <option <?php if($result[0]['transportation_id'] == $fees->id){echo 'selected'; } ?>  value="<?php echo $fees->id; ?>"><?php echo $fees->routeName. ' ('.$fees->addAmount.')'; ?></option>
                                       <?php
                                         endforeach; ?>
                                    </select>
                                    <i class="bar"></i>
                                 </div>
                              </div>
                              </div> 
                           </div>               
                           <div class="page-title w-100 mt-4">
                              <div class="row">
                                 <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="page-title pl-3">Parents information</div>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body w-100 p-3">
                              <div class="row">
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group custom-mt-form-group">
                                       <input type="text" name="fathers_name" placeholder="Father Name" value="<?php
                                          if (isset($result[0]['fathers_name']))
                                            	echo htmlspecialchars($result[0]['fathers_name']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group custom-mt-form-group">
                                       <input type="text" name="fathers_occupation" placeholder="Father Occupation" value="<?php
                                          if (isset($result[0]['fathers_occupation']))
                                            	echo htmlspecialchars($result[0]['fathers_occupation']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group custom-mt-form-group">
                                       <input type="text"  name="parents_email_address" placeholder="Parents Email" value="<?php
                                          if (isset($result[0]['parents_email_address']))
                                            	echo htmlspecialchars($result[0]['parents_email_address']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group custom-mt-form-group">
                                       <input type="text"  name="nationality" placeholder="Nationality" value="<?php
                                          if (isset($result[0]['nationality']))
                                            	echo htmlspecialchars($result[0]['nationality']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group custom-mt-form-group">
                                       <input type="number"  name="parents_mobile_number" placeholder="Mobile number" value="<?php
                                          if (isset($result[0]['parents_mobile_number']))
                                            	echo htmlspecialchars($result[0]['parents_mobile_number']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group">
                                       <textarea id="message" class="form__field" placeholder="Present Address" name="present_address"><?php if (isset($result[0][ 'present_address'])) echo $result[0][ 'present_address']; ?></textarea>
                                       <label for="message" class="form-label">Present Address</label>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group custom-mt-form-group">
                                       <input type="text"  name="mothers_name" placeholder="Mother Name" value="<?php
                                          if (isset($result[0]['mothers_name']))
                                            	echo htmlspecialchars($result[0]['mothers_name']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group custom-mt-form-group">
                                       <input type="text"  name="mothers_occupation" placeholder="Mother Occupation" value="<?php
                                          if (isset($result[0]['mothers_occupation']))
                                            	echo htmlspecialchars($result[0]['mothers_occupation']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group custom-mt-form-group">
                                       <input type="password"  name="parents_password" placeholder="Password" value="<?php
                                          if (isset($result[0]['[parents_password]']))
                                            	echo htmlspecialchars($result[0]['[parents_password]']);
                                          ?>"/>
                                       <i class="bar"></i>
                                    </div>
                                    <div class="form-group">
                                       <textarea id="message" class="form__field" placeholder="Permanent Address" name="permanent_address"><?php if (isset($result[0][ 'permanent_address'])) echo $result[0][ 'permanent_address']; ?></textarea>
                                       <label for="message" class="form-label">Permanent Address</label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                              <div class="form-group custom-mt-form-group">
                                 <input type="file" name="student_profile_image" id="student_profile_image" style="margin-bottom:10px;">
                                 <?php if($studentId) { ?>
                                 <input type="hidden" name="student_profile_image_name" id="student_profile_image_name" value="<?php if (isset($result[0]['student_profile_image'])) echo $result[0]['student_profile_image']; ?>"/>
                                 <?php } ?>
                                 <?php if (!empty($result[0]['student_profile_image'])): ?>
                                 <span id="student_profile_image_div">    
                                 <img src="<?php if (isset($result[0]['student_profile_image'])) echo PROFILE_PIC_IMAGE_PATH . $result[0]['student_profile_image']; ?>" height="100" width="100"/>
                                 <span class="del_slider_img">
                                 <img src="<?php echo BASE_ROOT; ?>assets/img/cancel.png" style="cursor:pointer"/>
                                 </span>
                                 </span>
                                 <?php endif; ?>
                                 <label class="control-label">Student Image</label><i class="bar"></i>
                              </div>
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                              <div class="form-group custom-mt-form-group">
                                 <input type="file" name="parents_profile_image" id="parents_profile_image" style="margin-bottom:10px;">
                                 <?php if($studentId) { ?>
                                 <input type="hidden" name="parents_profile_image_name" id="parents_profile_image_name" value="<?php if (isset($result[0]['parents_profile_image'])) echo $result[0]['parents_profile_image']; ?>"/>
                                 <?php } ?>
                                 <?php if (!empty($result[0]['parents_profile_image'])): ?>
                                 <span id="parents_profile_image_div">    
                                 <img src="<?php if (isset($result[0]['parents_profile_image'])) echo PROFILE_PIC_IMAGE_PATH . $result[0]['parents_profile_image']; ?>" height="100" width="100"/>
                                 <span class="del_slider_img_parents">
                                 <img src="<?php echo BASE_ROOT; ?>assets/img/cancel.png" style="cursor:pointer"/>
                                 </span>
                                 </span>
                                 <?php endif; ?>
                                 <label class="control-label">Parents Image</label><i class="bar"></i>
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
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">

	jQuery.validator.addMethod("isCheckAdmissionNo", function(value, element) {
        var admissionNoValue = $.trim(value);
        var oldAdmissionNo = $("input[name=oldAdmissionNo]").val();
        var check_result = false;
        $.ajax({
           type: "POST",
           async: false,
           url: "employee/process/processAddStudent.php",
           data:{oldAdmissionNo:oldAdmissionNo, admissionNo:admissionNoValue, type:'isCheckAdmissionNo'},
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
    }, "This Admission Number already exist in student Database!");

	jQuery.validator.addMethod("isCheckParentEmail", function(value, element) {
        var parentEmailValue = $.trim(value);
        var oldParentEmail = $("input[name=oldParentEmail]").val();
        var check_result = false;
        $.ajax({
           type: "POST",
           async: false,
           url: "employee/process/processAddStudent.php",
           data:{oldParentEmail:oldParentEmail, parentEmail:parentEmailValue, type:'isCheckParentEmail'},
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
    }, "Parent email address already exist in student Database!");

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
                  mobile_number:{
                      required:true
                  },
                  admission_no:{
                      required:true,
                      isCheckAdmissionNo:true
                  },
                  transportation_id:{
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
      $('#transportation_taken').change(function(){
         if($('#transportation_taken').val() == 'yes') {
            $('#transportation_section').show(); 
         } else {
            $('#transportation_section').hide(); 
         } 
      });   
</script>