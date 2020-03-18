<?php 
   require_once 'includes/header.php'; 
   require_once 'includes/sidebar.php'; 
   ?>
<style type="text/css">
.addTerm .form-group{
  display: flex;
  align-items: center;
}
.addTerm .form-group label{
  margin-right: 15px;
  margin-bottom: 0;
}
.addTerm .form-group .form-control{
  flex: 1;
  margin-right: 15px
}
.addTerm .form-group .addNew{
  font-size: 22px;
  color: #323941;
  font-weight: bold;


}
</style>
<div class="page-wrapper">
   <!-- content -->
   <div class="content container-fluid">
      <div class="page-header">
         <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12 col-12">
               <h5 class="text-uppercase">Add Exam</h5>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
               <ul class="list-inline breadcrumb float-right">
                  <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                  <li class="list-inline-item"> Add Exam</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <div  class="addTerm">
  
<form action="" method="" accept-charset="utf-8">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Term Type</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
        <span class="addNew"> <i class="fa fa-plus" aria-hidden="true"></i> </span>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputPassword1">Add Session</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
        <!-- <span class="addNew"> <i class="fa fa-plus" aria-hidden="true"></i> </span> -->
      </div>
    </div>
    <div class="col-12 text-center">
      <button class="btn btn-primary" type="submit">Submit</button>
    </div>
  </div>
</form>
</div>
         </div>
      </div>
   </div>
</div>
</div>
<?php require_once 'includes/footer.php'; ?>