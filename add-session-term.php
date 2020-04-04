<?php 
   require_once 'employee/config/config.php';
   require_once 'employee/class/dbclass.php';
   require_once 'employee/class/SessionTerms.php';
   $sessionTerm=new SessionTerms(); 
   $sessionId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
   if ($sessionId != NULL) { 
      $result = $sessionTerm->getSessionInfo($sessionId);
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
         <div class="col-lg-12">
            <div class="card-box">
               <h4 class="card-title">Session Terms</h4>
               <form id="addSessionTerm" action="employee/process/processSessionsTerm.php" method="post" novalidate="novalidate">
                  <input type="hidden" name="type" value="<?php echo $sessionId == '' ? 'Add' : 'Update'; ?>" />
                  <input type="hidden" name="sessionId" value="<?php echo $sessionId; ?>" />
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Select Session Year</label>
                     <div class="col-md-10">
                        <select id="session_year" class="form-control" name="session_year">
                           <option value="">Select Year</option>
                          <option value="2018-2019" <?php if($result[0]['session_year'] == '2018-2019') {echo 'selected';} ?>>2018-2019</option>                
                          <option value="2019-2020"<?php if($result[0]['session_year'] == '2019-2020') {echo 'selected';} ?> >2019-2020</option>
                          <option value="2020-2021"<?php if($result[0]['session_year'] == '2020-2021') {echo 'selected';} ?> >2020-2021</option>
                          <option value="2021-2022"<?php if($result[0]['session_year'] == '2021-2022') {echo 'selected';} ?> >2021-2022</option>
                          <option value="2022-2023"<?php if($result[0]['session_year'] == '2022-2023') {echo 'selected';} ?> >2022-2023</option>
                          <option value="2023-2024"<?php if($result[0]['session_year'] == '2023-2024') {echo 'selected';} ?> >2023-2024</option>
                      </select>                          
                     </div>
                  </div>
                  <?php if(empty($result)) { ?>
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Term Name</label>
                     <div class="col-md-10">
                        <input type="text" name="addTerm[]" class="form-control" value="">
                     </div>
                  </div>
                  <?php } ?> 
                  <?php $i=1;?>  
                  <?php if(!empty($result)) { ?>
                  <?php foreach ($result as $key => $value) { ?>
                  <div id="trans-fees-<?php echo $i;?>" class="form-group row add_terms">
                     <input type="hidden" name="sessionIds[]" value="<?php echo $value['id']; ?>">
                     <label class="col-form-label col-md-2">Term Name</label>
                     <div class="col-md-3">
                        <input type="text" name="addTerm[]" class="form-control" value="<?php
                           if (isset($value['term_name']))
                           echo htmlspecialchars($value['term_name']);
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
                        <a href="javascript:addAnother();" >Add Term</a>
                     </div>
                  </div>
                  <div class="form-group text-center custom-mt-form-group">
                     <button class="btn btn-primary btn-lg mr-2" type="submit">Create</button>
                  </div>
               </form>
               <div id="clone-sections-div" style="display: none;" class="form-group row add_terms">
                  <label class="col-form-label col-md-2">Term Name</label>
                  <div class="col-md-3">
                     <input type="text" name="addTerm[]" class="addTerm form-control">
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
   var sectionLength = $('.add_terms').length;
   var k = (sectionLength > 0) ? sectionLength + 1 : 1;
   
       function addAnother() {
               var aboutAddrow = $("#clone-sections-div").clone().removeAttr('style');
               aboutAddrow.attr("id", "trans-fees-" + k);
               
               var textboxname = aboutAddrow.find('.addTerm').attr('name', 'addTerm[]');    
               textboxname.attr('id', 'addTerm' + k);
    
               var deleteicon = aboutAddrow.find('#delete-icon');
                deleteicon.attr('id', 'newdelete' + k);
                deleteicon.attr('name', 'trans-fees-' + k);
   
               $("#main-sections-div").append(aboutAddrow);
   
               k = k + 1;
       }
       
       $(function(){
           $("#addSessionTerm").validate({
               ignore: "input[type='text']:hidden",
               rules:{
                   session_year:{
                       required:true
                   },
                   'addTerm[]':{
                       required:true
                   }
               }
           });
       });
   
       function deleteAddress(deleteid) {
            $('#' + deleteid).remove();
        }
</script>