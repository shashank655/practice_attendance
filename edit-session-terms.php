<?php 
   require_once 'employee/config/config.php';
   require_once 'employee/class/dbclass.php';
   require_once 'employee/class/SessionTerms.php';
   require_once 'employee/class/CommonFunction.php'; 
   $sessionTerm=new SessionTerms(); 
   $common_function=new CommonFunction();
   $resultAllSession=$sessionTerm->getSessionYearLists();
   $resultClasses = $common_function->getAllClassesName();
   
    $session_year_id = (isset($_REQUEST['session_year_id'])) ? $_REQUEST['session_year_id'] : NULL;
    $session_term_id = (isset($_REQUEST['session_term_id'])) ? $_REQUEST['session_term_id'] : NULL;
    $class_id = (isset($_REQUEST['class_id'])) ? $_REQUEST['class_id'] : NULL;
    $section_id = (isset($_REQUEST['section_id'])) ? $_REQUEST['section_id'] : NULL;
   
    //$resultAllStudents=$student->getAllStudents($get_class_id,$get_section_id,$admission_no,$student_name);
   
   require_once 'includes/header.php'; 
   require_once 'includes/sidebar.php';
   ?>
<div class="page-wrapper">
   <!-- content -->
   <div class="content container-fluid">
      <div class="page-header">
         <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12 col-12">
               <h5 class="text-uppercase">Session Terms</h5>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
               <ul class="list-inline breadcrumb float-right">
                  <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                  <li class="list-inline-item"> Add Terms</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div  class="editTerm">
            <form id="searchSession" action="edit-session-terms.php" method="get" accept-charset="utf-8">
               <div class="row">
                  <div class="col-md-4  mb-3 mb-md-0">
                     <div class="">
                        <label for="exampleInputPassword1">Select Session</label>
                        <select class="custom-select" id="session_year_id" name="session_year_id" onchange="getSessionTerm(this.value);">
                           <option value='' >Select Session</option>
                           <?php foreach ($resultAllSession as $key => $value) { ?>
                           <option value="<?php echo $value['id']?>"><?php echo $value['session_year']?></option>
                           <?php } ?>  
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <label for="exampleInputPassword1">Select Term</label>
                     <div class="row">
                        <div class="col-10">
                           <div class="">
                              <select name="session_term_id" id="session_term_id" class="custom-select">
                                 <option value='' selected="" disabled="">Select Term</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 mb-3 mb-md-0">
                     <div class="">
                        <label for="exampleInputPassword1">Class</label>
                        <select id="class_id" class="custom-select" name="class_id" onchange="getSections(this.value);">
                           <option value='' >Select Class</option>
                           <?php for ($i=0 ; $i < count($resultClasses); $i++) : ?>
                           <option <?php if (isset($result['fetch_data'][0]['class_id'])) { if ($result['fetch_data'][0]['class_id']==$resultClasses[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $resultClasses[$i][ 'id']; ?>"><?php echo $resultClasses[$i][ 'class_name']; ?></option>
                           <?php endfor; ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <label for="exampleInputPassword1">Section</label>
                     <div class="row">
                        <div class="col-10">
                           <div class="">
                              <select name="section_id" id="section_id" class="custom-select">
                                 <option value='' selected="" disabled="">Select Section</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-12 text-center">
                  <button class="btn btn-primary" type="submit">Search</button>
               </div>
            </form>
            <?php if(!empty($session_year_id) && !empty($session_term_id) && !empty($class_id) && !empty($section_id) ) { ?>
            <div class="col-12 mb-3">
               <form class="form-validate" id="fees-transportation-form" action="employee/process/processSessionsTerm.php" method="post" novalidate="novalidate">
               <input type="hidden" name="type" value="edit-sessions-terms">
               <input type="hidden" name="session_year_id" value="<?php echo $session_year_id;?>">
               <input type="hidden" name="session_term_id" value="<?php echo $session_term_id;?>">
               <input type="hidden" name="class_id" value="<?php echo $class_id;?>">
               <input type="hidden" name="section_id" value="<?php echo $section_id;?>">

                  <div class="card-box mb-0">
                     <div class="card-header border-0">
                        <h4 class="card-title">Scholastic</h4>
                     </div>
                     <div class="card-body">
                        <?php if(!$get_trans_fees->success) { ?>
                        <div class="form-group row">
                           <label class="col-form-label col-md-2">Head Name</label>
                           <div class="col-md-3">
                              <input type="text" placeholder="Head Name" name="headName[]" class="headName form-control">
                           </div>
                           <label class="col-form-label">Total  Marks</label>
                           <div class="col-md-3">
                              <input type="text" placeholder="Amount" name="totalMarks[]" class="totalMarks form-control">
                           </div>
                        </div>
                        <?php } ?>  
                        <div id="heads-types-div">
                        </div>
                        <div class="controls">
                           <a href="javascript:addAnotherHeads();" >Add Heads</a>
                        </div>
                     </div>
                     <div class="card-body">
                        <?php if(!$get_trans_fees->success) { ?>
                        <div class="form-group row">
                           <label class="col-form-label col-md-2">Subject Name</label>
                           <div class="col-md-3">
                              <input type="text" placeholder="Subject Name" name="subjectName[]" class="subjectName form-control">
                           </div>
                        </div>
                        <?php } ?>
                        <div id="subjects-types-div">
                        </div>
                        <div class="controls">
                           <a href="javascript:addSubjects();" >Add Subjects</a>
                        </div>
                     </div>
                  </div>
                  <div class="card-box mb-0">
                     <div class="card-header border-0">
                        <h4 class="card-title">Co-Scholastic</h4>
                     </div>
                     <div class="card-body">
                        <?php if(!$get_trans_fees->success) { ?>
                        <div class="form-group row">
                           <label class="col-form-label col-md-2">Subject Name</label>
                           <div class="col-md-3">
                              <input type="text" placeholder="Subject Name" name="subjectCoSName[]" class="subjectCoSName form-control">
                           </div>
                        </div>
                        <?php } ?>
                        <div id="subjects-coschol-types-div">
                        </div>
                        <div class="controls">
                           <a href="javascript:addCoScholSubjects();" >Add Co-Scholastic Subjects</a>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                           <div class="col-md-12">
                              <div class="pull-right">
                                 <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="">Submit</button>
                                 <a class="btn btn-secondary shadow-none" href="dashboard.php">Cancel</a>
                              </div>
                           </div>
                        </div>
               </form>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
</div>
<div class="form-group row add_heads_type" id="clone-heads-type-div" style="display: none;">
<label class="col-form-label col-md-2">Head Name</label>
<div class="col-md-3">
   <input type="text" name="headName[]" class="headName form-control">
</div>
<label class="col-form-label">Total Marks</label>
<div class="col-md-3">
   <input type="text" name="totalMarks[]" class="totalMarks form-control">
</div>
<div class="col-md-3">
   <img id="delete-icon" title="DELETE" src="<?php echo BASE_ROOT;?>assets/img/cancel.png" border="0" onclick="javascript:deleteAddress(this.name)" style="cursor: pointer;" />
</div>
</div>

<div class="form-group row add_subjects_type" id="clone-subjects-type-div" style="display: none;">
<label class="col-form-label col-md-2">Subject Name</label>
<div class="col-md-3">
   <input type="text" name="subjectName[]" class="subjectName form-control">
</div>
<div class="col-md-3">
   <img id="delete-icon" title="DELETE" src="<?php echo BASE_ROOT;?>assets/img/cancel.png" border="0" onclick="javascript:deleteAddress(this.name)" style="cursor: pointer;" />
</div>
</div>

<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">
   var sectionLength = $('.add_heads_type').length;
       var k = (sectionLength > 0) ? sectionLength + 1 : 1;
   
           function addAnotherHeads() {
                   var aboutAddrow = $("#clone-heads-type-div").clone().removeAttr('style'); 
                   aboutAddrow.attr("id", "trans-fees-" + k);
   
                   var feetypeBoxname = aboutAddrow.find('.headName').attr('name', 'headName[]');    
                   feetypeBoxname.attr('id', 'headName' + k);
                   feetypeBoxname.attr('placeholder', 'Head Name');
   
                   var amountBox = aboutAddrow.find('.totalMarks').attr('name', 'totalMarks[]');    
                   amountBox.attr('id', 'totalMarks' + k);
                   amountBox.attr('placeholder', 'Total Marks');
   
                   var deleteicon = aboutAddrow.find('#delete-icon');
                   deleteicon.attr('id', 'newdelete' + k);
                   deleteicon.attr('name', 'trans-fees-' + k);
   
                   $("#heads-types-div").append(aboutAddrow);
   
                   k = k + 1;
           }
  
     var subjectLength = $('.add_subjects_type').length;
       var J = (subjectLength > 0) ? subjectLength + 1 : 1;
   
           function addSubjects() {
                   var aboutAddrow = $("#clone-subjects-type-div").clone().removeAttr('style'); 
                   aboutAddrow.attr("id", "trans-subject-" + J);
   
                   var feetypeBoxname = aboutAddrow.find('.subjectName').attr('name', 'subjectName[]');    
                   feetypeBoxname.attr('id', 'subjectName' + J);
                   feetypeBoxname.attr('placeholder', 'Subject Name');
   
                   var deleteicon = aboutAddrow.find('#delete-icon');
                   deleteicon.attr('id', 'newdelete' + J);
                   deleteicon.attr('name', 'trans-subject-' + J);
   
                   $("#subjects-types-div").append(aboutAddrow);
   
                   J = J + 1;
           }

      
     var subjectLength = $('.add_subjects_type').length;
       var L = (subjectLength > 0) ? subjectLength + 1 : 1;
   
           function addCoScholSubjects() {
                   var aboutAddrow = $("#clone-subjects-type-div").clone().removeAttr('style'); 
                   aboutAddrow.attr("id", "trans-coschol-subject-" + L);
   
                   var feetypeBoxname = aboutAddrow.find('.subjectName').attr('name', 'subjectCoSName[]');    
                   feetypeBoxname.attr('id', 'subjectCoSName' + L);
                   feetypeBoxname.attr('placeholder', 'Subject Name');
   
                   var deleteicon = aboutAddrow.find('#delete-icon');
                   deleteicon.attr('id', 'newdelete' + L);
                   deleteicon.attr('name', 'trans-coschol-subject-' + L);
   
                   $("#subjects-coschol-types-div").append(aboutAddrow);
   
                   L = L + 1;
           }

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
      
         function getSessionTerm(ID){
             $.ajax({
                 type: "POST",
                 url: "employee/process/processSessionsTerm.php",
                 data:{type:'getSessionTerm',sessionID:ID},
                 beforeSend : function () {
                     //$('#wait').html("Wait for checking");
                 },
                 success:function(data){                
                     
                     data = $.parseJSON(data);         
                     if(data.length > 0){
                         $("#session_term_id").html("<option value=''>Select Term</option>");
                         for(var i=0;i<data.length;i++){        
                            var option="<option value='"+data[i].id+"'";
                                 if(data[i].id==session_term_id){
                                    option+=" selected";
                                 }
                                option+=" >"+data[i].term_name+"</option>"
                             $("#session_term_id").append(option);
                         }                    
                     }else{
                         $("#session_term_id").html("<option value='' selected >No Terms Found</option>");
                     }
                 }
             });
         }

         function deleteAddress(deleteid) {
            $('#' + deleteid).remove();
        }
</script>