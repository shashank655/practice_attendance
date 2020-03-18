<?php 
   require_once 'employee/config/config.php';
   require_once 'employee/class/dbclass.php';
   require_once 'employee/class/ClassSections.php';
   require_once 'employee/class/Subjects.php';
   $classes = new ClassSections(); 
   $subjects=new Subjects(); 
   $resultAllSubjects=$subjects->getSubjectLists();
   $classId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
   if ($classId != NULL) { $result = $classes->getClassInfo($classId); 
       if ($result == NULL) { $classId = ''; }
       $getSubjectIDs = $classes->get_subject_ids($result[0]['id']);
       $subjectsIDs = explode(',', $getSubjectIDs[0]['subjects_id']);
   }
   require_once 'includes/header.php'; 
   require_once 'includes/sidebar.php';
   ?>
<div class="page-wrapper">
   <!-- content -->
   <div class="content container-fluid">
      <div class="page-header">
         <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12 col-12">
               <h5 class="text-uppercase">Classes & Sections</h5>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
               <ul class="list-inline breadcrumb float-right">
                  <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                  <li class="list-inline-item"> Add Classes</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <div class="card-box">
               <h4 class="card-title">Classes & Sections</h4>
               <form id="addClassesSections" action="employee/process/processClassSections.php" method="post" novalidate="novalidate">
                  <input type="hidden" name="type" value="<?php echo $classId == '' ? 'Add' : 'Update'; ?>" />
                  <input type="hidden" name="classId" value="<?php echo $classId; ?>" />
                  <div class="form-group row ">
                     <label class="col-form-label col-md-2">Class Name</label>
                     <div class="col-md-10">
                        <input type="text" name="className" class="form-control" value="<?php
                           if (isset($result[0]['class_name']))
                           echo htmlspecialchars($result[0]['class_name']);
                           ?>">
                     </div>
                  </div>
                  <?php if(empty($result)) { ?>
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Sections Name</label>
                     <div class="col-md-10">
                        <input type="text" name="addSection[]" class="form-control" value="">
                     </div>
                  </div>
                  <?php } ?> 
                  <?php $i=1;?>  
                  <?php if(!empty($result)) { ?>
                  <?php foreach ($result as $key => $value) { ?>
                  <div id="trans-fees-<?php echo $i;?>" class="form-group row add_sections">
                     <input type="hidden" name="sectionsIds[]" value="<?php echo $value['secId']; ?>">
                     <label class="col-form-label col-md-2">Sections Name</label>
                     <div class="col-md-3">
                        <input type="text" name="addSection[]" class="form-control" value="<?php
                           if (isset($value['section_name']))
                           echo htmlspecialchars($value['section_name']);
                           ?>">
                     </div>
                     <div class="col-md-3">
                      <img title="DELETE" src="<?php echo BASE_ROOT;?>assets/img/cancel.png" onclick="javascript:deleteAddress(this.name)" style="cursor: pointer;" name="trans-fees-<?php echo $i;?>">
                    </div>
                  </div>
                  <?php $i++;} } ?>
                  <div id="main-sections-div">
                  </div>
                  <div class="control-group other-pick-address">
                     <label class="control-label">&nbsp;</label>
                     <div class="controls addAnotherStop">
                        <a href="javascript:addAnother();" >Add Sections</a>
                     </div>
                  </div>
                  <div class="content-page">
                     <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="table-responsive">
                              <table class="table table-bordered m-b-0">
                                 <thead>
                                    <tr>
                                       <th style="min-width:50px;">Subject Name</th>
                                       <th style="min-width:50px;">Select</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php  foreach ($resultAllSubjects as $key => $value) { 
                                       if (in_array($value['id'], $subjectsIDs))
                                           {
                                           $checked = "checked";
                                       } else {
                                           $checked = "";
                                       }
                                       ?>
                                    <tr>
                                       <td><?php echo $value['subject_name']; ?></td>
                                       <td>
                                          <label class="custom_checkbox">
                                          <input type="checkbox" <?php if (in_array($value['id'], $subjectsIDs))
                                             {
                                                 echo "checked";
                                             } ?> name="subjects_id[<?php echo $key?>]" value="<?php echo $value['id'] ?>">
                                          <span class="checkmark"></span>
                                          </label>
                                       </td>
                                    </tr>
                                    <?php } ?> 
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group text-center custom-mt-form-group">
                     <button class="btn btn-primary btn-lg mr-2" type="submit">Create</button>
                  </div>
               </form>
               <div id="clone-sections-div" style="display: none;" class="form-group row add_sections">
                  <label class="col-form-label col-md-2">Sections Name</label>
                  <div class="col-md-3">
                     <input type="text" name="addSection[]" class="addSection form-control">
                  </div>
                  <div class="col-md-3">
                      <img id="delete-icon" title="DELETE" src="<?php echo BASE_ROOT;?>assets/img/cancel.png" border="0" onclick="javascript:deleteAddress(this.name)" style="cursor: pointer;" />
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
   var sectionLength = $('.add_sections').length;
   var k = (sectionLength > 0) ? sectionLength + 1 : 1;
   
       function addAnother() {
               var aboutAddrow = $("#clone-sections-div").clone().removeAttr('style');
               aboutAddrow.attr("id", "trans-fees-" + k);
               
               var textboxname = aboutAddrow.find('.addSection').attr('name', 'addSection[]');    
               textboxname.attr('id', 'addSection' + k);
    
               var deleteicon = aboutAddrow.find('#delete-icon');
                deleteicon.attr('id', 'newdelete' + k);
                deleteicon.attr('name', 'trans-fees-' + k);

               $("#main-sections-div").append(aboutAddrow);
   
               k = k + 1;
       }
       
       $(function(){
           $("#addClassesSections").validate({
               ignore: "input[type='text']:hidden",
               rules:{
                   className:{
                       required:true
                   },
                   'addSection[]':{
                       required:true
                   }
               }
           });
       });

       function deleteAddress(deleteid) {
            $('#' + deleteid).remove();
        }
</script>