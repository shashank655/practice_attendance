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
         <div  class="editTerm">
  
  <form action="" method="" accept-charset="utf-8">
    <div class="row">
      <div class="col-md-4  mb-3 mb-md-0">
        <div class="">
          <label for="exampleInputPassword1">Select Term</label>
          <select class="custom-select" required>
            <option value="">Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
      </div>
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="">
          <label for="exampleInputPassword1">Class</label>
          <select class="custom-select" required>
            <option value="">Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <label for="exampleInputPassword1">Section</label>
        <div class="row">
          <div class="col-10">
            <div class="">
              <select class="custom-select" required>
                <option value="">Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-2 py-1">
            <span class="addNew"> <i class="fa fa-plus" aria-hidden="true"></i> </span>
          </div>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="form-inline">
          <div class="form-group w-100">
            <label for="" class=" mr-3">Scholastic</label>
            <input type="text" id="" class="form-control mr-3 mb-3 mb-md-0" aria-describedby="" placeholder="Exam Head">
            <div class="mr-5 d-flex align-items-center  mb-3 mb-md-0">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Max Marks">
              <span class="addNew"> <i class="fa fa-plus mr-3" aria-hidden="true"></i> </span>
              <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
            </div>
            <div class="d-flex align-items-center">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Max Marks">
              <span class="addNew"> <i class="fa fa-plus mr-3" aria-hidden="true"></i> </span>
              <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-4">
        <div class="row">
          <div class="col-10">
            <div class="">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Add Subjects">
            </div>
          </div>
          <div class="col-2">
            <span class="addNew"> <i class="fa fa-plus" aria-hidden="true"></i> </span>
            <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="row">
          <div class="col-10">
            <div class="">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Add Subjects">
            </div>
          </div>
          <div class="col-2">
            <span class="addNew"> <i class="fa fa-plus" aria-hidden="true"></i> </span>
            <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-12">
        <div class="form-inline">
          <div class="form-group w-100">
            <label for="" class=" mr-3">Co-Scholastic</label>
            <input type="text" id="" class="form-control mr-3  mb-3 mb-md-0" aria-describedby="" placeholder="Exam Head">
            <div class="mr-5 d-flex align-items-center  mb-3 mb-md-0">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Max Marks">
              <span class="addNew"> <i class="fa fa-plus mr-3" aria-hidden="true"></i> </span>
              <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
            </div>
            <div class="d-flex align-items-center">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Max Marks">
              <span class="addNew"> <i class="fa fa-plus mr-3" aria-hidden="true"></i> </span>
              <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-4">
        <div class="row">
          <div class="col-10">
            <div class="">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Add Subjects">
            </div>
          </div>
          <div class="col-2">
            <span class="addNew"> <i class="fa fa-plus" aria-hidden="true"></i> </span>
            <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-md-4">
        <div class="row">
          <div class="col-10">
            <div class="">
              <input type="text" id="" class="form-control mr-3" aria-describedby="" placeholder="Add Subjects">
            </div>
          </div>
          <div class="col-2">
            <span class="addNew"> <i class="fa fa-plus" aria-hidden="true"></i> </span>
            <span class="removeItem"> <i class="fa fa-times" aria-hidden="true"></i> </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-primary" type="submit">Create</button>
      <button class="btn btn-primary" type="submit">Cancel</button>
    </div>
  </form>
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