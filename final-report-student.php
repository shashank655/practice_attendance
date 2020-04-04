<?php 
   require_once 'employee/config/config.php';
   require_once 'employee/class/dbclass.php';
   require_once 'employee/class/SessionTerms.php';
   require_once 'employee/class/Teacher.php';
   require_once 'employee/class/Student.php';
   require_once 'employee/class/StudentMarks.php';

   $sessionTerm=new SessionTerms(); 
   $teacher = new Teacher();
   $student = new Student();
   $student_marks = new StudentMarks();

   $studentId = (isset($_REQUEST['sID'])) ? $_REQUEST['sID'] : NULL; 
  
   if($_POST) {
      $studentID = (isset($_POST['studentID'])) ? $_POST['studentID'] : NULL;
      $session_year_id = (isset($_POST['session_year_id'])) ? $_POST['session_year_id'] : NULL;  

       if ($session_year_id != NULL) { 
          if($_SESSION['user_role'] == '2') {
             $output = $teacher->getTeacherClassName($_SESSION['userId']);
             $get_class_id = $output[0]['classId'];
             $get_section_id = $output[0]['sectionId']; 
             } else {
                 header('Location: ' . BASE_ROOT.'students-exam-list.php');
             }

        $resultTerms = $sessionTerm->getSessionTermsInfo($session_year_id , $get_class_id , $get_section_id);
          if(!$resultTerms) {
            header('Location: ' . BASE_ROOT.'students-exam-list.php');
          } else {
            $result = $student->getStudentInfo($studentID);
          }
        }    
   } else {
       header('Location: ' . BASE_ROOT.'select-session-list.php?sID='.$studentId);
   }

   ?>
   <?php 
   require_once 'includes/header.php'; 
   require_once 'includes/sidebar.php';
   ?>
     <style type="text/css" media="screen">

.report-card .table-bordered td,.report-card .table-bordered th{
  border-color: #000;
}
.report-card .report-table{
  text-align: center;
}
.report-card .report-table td:nth-of-type(1){
  text-align: left
}
.report-card .report-table .topHead{
  background-color: #87B2E7
}
   </style>
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
      <div class="row print-button-div mb-2">
            <div class="col-12">
                <div class="pull-right">
                    <a href="final-report-card-pdf.php" class="btn btn-sm btn-dark" target="_blank">Download PDF</a>
                </div>
            </div>
        </div>
      <div class="row">
         <div class="report-card w-100">
  <div class="table-responsive">
  <form id="addFinalStudentMarks" action="employee/process/processStudentsMarks.php" method="post" novalidate="novalidate">
    <input type="hidden" name="type" value="student_final_marks" />
    <input type="hidden" name="student_id" value="<?php echo $studentID; ?>" />
    <table class="table table-bordered mb-3">
      <thead>
        <tr>
          <th>Student's Name : <?php echo $result[0]['first_name'].' '.$result[0]['last_name']?></th>
          <th>Class: <?php echo $result[0]['class_name'];?></th>
          <th>Sec: <?php echo $result[0]['section_name'];?></th>
          <th>Roll: <?php echo $result[0]['roll_number'];?></th>
        </tr>
        <tr>
          <th>Admission No: <?php echo $result[0]['admission_no'];?></th>
          <th>Address: <?php echo $result[0]['permanent_address'];?></th>
          <th colspan="3">D.O.B: <?php echo $result[0]['dob'];?></th>
        </tr>
      </thead>     
    </table>
    <?php if(!empty($resultTerms)) { 
      foreach ($resultTerms['termId'] as $key => $value) {
    ?>
    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th>Scholastic Area:</th>
          <th colspan="6"><?php echo $value['term_name']; ?> - ( 100 MARKS )</th>
        </tr>
        <tr>
          <th>Sub Name</th>
          <?php $getTermSubjectsLists = $sessionTerm->gettingTermSubjectsLists($value['editSessionTermId']); 
            if(!empty($getTermSubjectsLists['scholastic_heads'])) {
              foreach ($getTermSubjectsLists['scholastic_heads'] as $key_heads => $value_heads) { ?> 
          <th><?php echo $value_heads['headName']; ?> (<?php echo $value_heads['totalMarks']; ?>)</th>
          <?php } } ?>
        </tr>
      </thead>  
      <tbody>
      <?php  if(!empty($getTermSubjectsLists['scholastic_subects'])) {
          foreach ($getTermSubjectsLists['scholastic_subects'] as $key_subjects => $value_subjects) { ?> 
        <tr>
          <td><?php echo $value_subjects['subjectName']?></td>
          <?php if(!empty($getTermSubjectsLists['scholastic_heads'])) {
          foreach ($getTermSubjectsLists['scholastic_heads'] as $key_head_2 => $value_heads_2) { 

              $getStudMarks = $student_marks->getStudentsFinalMarks($value['editSessionTermId'] , $value_heads_2['headId'] , $value_subjects['subjectId'] , $studentID);
          ?>  
          <td><input type="text" value="<?php echo $getStudMarks[0]['marks_obtain']; ?>" class="border-0" name="marks_obtain[<?php echo $value['editSessionTermId']; ?>][<?php echo $value_heads_2['headId']; ?>][<?php echo $value_subjects['subjectId']; ?>]"></td>
          <?php } } ?>
        </tr>
      <?php } } ?>  
      </tbody>    
    </table>
    <?php } } ?>
    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th>Co-Scholastic Area: [ on 3-point (A-C) Grade Scale]</th>
          <?php 
          if(!empty($resultTerms)){
            foreach ($resultTerms['termId'] as $key => $value) {
          ?>
          <th>Grade(<?php echo $value['term_name'];?>)</th>
          <?php } }?>
        </tr>
      </thead>  
      <tbody>
      <?php 
        if(!empty($resultTerms)){
            foreach ($resultTerms['termId'] as $key_2 => $value_2) {
              $getCoScholasticLists = $sessionTerm->gettingCoScholasticSubjectsLists($value_2['editSessionTermId']); 
              break;
            } } 
        ?>

        <?php foreach ($getCoScholasticLists as $key_sub => $value_sub) { ?>
        <tr>
          <td><?php echo $value_sub['subjectCoSName']; ?></td>
            <?php foreach ($resultTerms['termId'] as $key_term => $value_term) {

              $getStudCoSMarks = $student_marks->getStudentsFinalCosMarks($value_term['editSessionTermId'] , $value_sub['subjectId'] , $studentID);

            ?>
              <td><input type="text" value="<?php echo $getStudCoSMarks[0]['marks_obtain']; ?>" class="border-0" name="marks_obtain_CoScholastic[<?php echo $value_term['editSessionTermId']; ?>][<?php echo $value_sub['subjectId']; ?>]"></td>
            <?php } ?>
        </tr>
        <?php } ?>
      </tbody>    
    </table>
    <table class="report-table table table-bordered mb-3">
      <thead>
        <tr class="topHead">
          <th></th>
          <?php 
          if(!empty($resultTerms)){
            foreach ($resultTerms['termId'] as $key => $value) {
          ?>
          <th><?php echo $value['term_name'];?></th>
          <?php } }?>
        </tr>
      </thead>  
      <tbody>
        <tr>
          <td>Total Attendance</td>
          <?php 
            if(!empty($resultTerms)){
            foreach ($resultTerms['termId'] as $key_2 => $value_2) { 

              $getStudAtten = $student_marks->getStudentsFinalAttendance($value_2['editSessionTermId'], $studentID);
            ?>
            <td><input type="text" value="<?php echo $getStudAtten[0]['attendance_value']; ?>"  class="border-0" name="total_attendance_term[<?php echo $value_2['editSessionTermId']; ?>]"></td>
          <?php  } } ?>
        </tr>
        <tr>
          <td>Total Working Days</td>
          <?php 
            if(!empty($resultTerms)){
            foreach ($resultTerms['termId'] as $key_2 => $value_2) { 

              $getStudWorkDays = $student_marks->getStudentsFinalWorkingDays($value_2['editSessionTermId'], $studentID);

            ?>
          <td><input type="text" value="<?php echo $getStudWorkDays[0]['working_days_value']; ?>" class="border-0" name="total_working_term[<?php echo $value_2['editSessionTermId']; ?>]"></td>
          <?php  } } ?>
        </tr>
        <tr>
          <td>Sign of Class Teacher</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>    
    </table>

    <table class="report-table mb-3">
      <tbody>
        <tr>
          <td>Class Teacher's Remarks:</td>
        </tr>
        <tr>
          <td>Over All Result: Granted to Class</td>
          <td>Grade: </td>
        </tr>
        <tr>
          <td>New Session Begins On: April 2019, Sharp at 8:00am.</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>    
    </table>

    <p class="text-right px-2">
      <strong><em>Signature of principal</em></strong>
    </p>
    <div class="form-group text-center custom-mt-form-group">
      <button class="btn btn-primary btn-lg mr-2" type="submit">Submit</button>
    </form>
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