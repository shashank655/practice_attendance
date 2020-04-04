<?php 
   require_once 'employee/class/dbclass.php'; 
   require_once 'employee/config/config.php'; 
   require_once 'employee/class/SessionTerms.php';
   $sessionTerm=new SessionTerms();
   $resultAllSession=$sessionTerm->getSessionYearLists(); 
   ?>
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
               <h5 class="text-uppercase">Student Marks</h5>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
               <ul class="list-inline breadcrumb float-right">
                  <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                  <li class="list-inline-item">Student Marks</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <div class="card-box">
               <h4 class="card-title">Select Session</h4>
               <form id="sessionList" action="final-report-student.php" method="post" enctype="multipart/form-data" novalidate="novalidate">
               <input type="hidden" name="studentID" value="<?php echo $_REQUEST['sID']; ?>">
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Select Session</label>
                     <div class="col-md-10">
                        <select id="session_year_id" class="form-control" name="session_year_id">
                           <option value="">Session Year</option>
                           <?php for ($i=0 ; $i < count($resultAllSession); $i++) : ?>
                           <option value="<?php echo $resultAllSession[$i][ 'id']; ?>"><?php echo $resultAllSession[$i][ 'session_year']; ?></option>
                           <?php endfor; ?>    
                        </select>
                     </div>
                  </div>
                  <div class="form-group text-center custom-mt-form-group">
                     <button class="btn btn-primary btn-lg mr-2" type="submit">Apply</button>
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
       $("#sessionList").validate({
           ignore: "input[type='text']:hidden",
           rules:{
               session_year_id:{
                   required:true,
                   dropdownValidation:true
               }
           }
       });
   });
</script>