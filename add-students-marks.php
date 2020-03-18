<?php 
   require_once 'employee/class/dbclass.php'; 
   require_once 'employee/config/config.php'; 
   require_once 'employee/class/Teacher.php';
   require_once 'employee/class/Exams.php'; 
   require_once 'employee/class/StudentMarks.php';
   $teacher_id = $_SESSION['userId']; 
   $user_role = $_SESSION['user_role'];
   $teacher = new Teacher();
   $exams=new Exams();
   $student_marks = new StudentMarks();
   
   if($_POST) {
       $examId = (isset($_POST['exam_id'])) ? $_POST['exam_id'] : NULL;
       if ($examId != NULL) { $resultExam = $exams->getExamInfo($examId); }
           if(empty($resultExam)) {
               header('Location: ' . BASE_ROOT.'select-exam-list.php');
           } 
           //echo "<pre>";print_r($resultExam);die;   
       if($_SESSION['user_role'] == '2') {
       $output = $teacher->getTeacherClassName($_SESSION['userId']);
       $get_class_id = $output[0]['classId'];
       $get_section_id = $output[0]['sectionId'];
       $get_total_class_students = $teacher->getTotalClassStudents($get_class_id,$get_section_id); 
   
       $get_students_subject_marks = $student_marks->getStudentsSubjectMarks($examId, $teacher_id);
           if(!empty($get_students_subject_marks)) {
               //echo "<pre>";print_r($get_students_subject_marks);die;
           }   
       } else {
           header('Location: ' . BASE_ROOT.'select-exam-list.php');
       }
   } else {
       header('Location: ' . BASE_ROOT.'select-exam-list.php');
   }
   ?>
<?php 
   require_once 'includes/header.php'; 
   require_once 'includes/sidebar.php'; 
   ?>
<style type="text/css">
<style type="text/css">
   .reportCardForm *{
   font-family: 'Source Sans Pro';
   }
   .reportCardForm p{
   font-size: 15px;
   }
   .reportCardForm h3{
   font-size: 15px;
   margin-bottom: 3px;
   }
   .reportCardForm h2{
   font-size: 26px;
   margin-bottom: 5px;
   }
   .reportCardTable input[type="text"]{
   border:0;
   width:100%;
   }
   .reportCardTable,.reportCardTable2{
   border: 1px solid black;
   }
   .reportCardTable th,
   .reportCardTable td{
   border: 1px solid black;
   text-align: center;
   font-size: 15px;
   }
   .reportCardTable2 th,
   .reportCardTable2 td{
   border: 1px solid black;
   font-size: 15px;
   }
   .poweredBy{
   font-size: 12px;
   color: #336699;
   }
   .poweredBy img{
   margin-left: 5px;
   }
   .reportCardForm *{
   color: #336699;
   }
</style>
</style>
<div class="page-wrapper">
   <!-- content -->
   <div class="content container-fluid">
      <div class="row mb-3">
         <div class="col-12">
            <p class="mb-1"><strong>Session: <?php echo $resultExam['fetch_data'][0]['year_session']?></strong></p>
         </div>
         <div class="col-12">
            <p class="mb-1"><strong>Exam Type: <?php echo $resultExam['fetch_data'][0]['exam_type']?></strong></p>
         </div>
         <div class="col-12">
            <p class="mb-1"><strong>Class: <?php echo $resultExam['fetch_data'][0]['class_name']?> </strong></p>
         </div>
         <div class="col-12">
            <p class="mb-1"><strong>Section: <?php echo $resultExam['fetch_data'][0]['section_name']?></strong></p>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="table-responsive">
               <form id="addStudentMarks" action="employee/process/processStudentsMarks.php" method="post" novalidate="novalidate">
                  <input type="hidden" name="type" value="student_marks" />
                  <input type="hidden" name="class_id" value="<?php echo $get_class_id; ?>" />
                  <input type="hidden" name="section_id" value="<?php echo $get_section_id; ?>" />
                  <input type="hidden" name="exam_id" value="<?php echo $examId; ?>" />
                  <input type="hidden" name="exam_term_id" value="<?php echo $resultExam['fetch_data'][0]['exam_term_id']; ?>" />
                  <table class="table reportCardTable">
                     <tr>
                        <th colspan="6">Subjects</th>
                     </tr>
                     <tr>
                        <th>Students</th>
                        <?php if(!empty($resultExam['fetch_details'])) {
                           foreach ($resultExam['fetch_details'] as $key => $value) { 

                        ?>
                        <th><?php echo $value['subject_name'] ?> <br><input type="text" name="totalMarks[<?php echo $value['exam_name'] ?>]" placeholder="Total Marks" value=""></th>
                        <?php } } ?>
                     </tr>
                     
                     <?php if(!empty($get_total_class_students)) { ?>

                        <?php foreach ($get_total_class_students as $key_student => $value_student) { ?> 
                            <tr>
                                <th><?php echo $value_student['first_name'].' '.$value_student['last_name'] ?></th>
                                <?php if(!empty($resultExam['fetch_details'])) {
                                    foreach ($resultExam['fetch_details'] as $key_sub => $value_sub) { ?>
                                <th><input type="text" name="marks_obtain[<?php echo $value_student['id']; ?>][<?php echo $value_sub['exam_name'];?>]"></th>
                                <?php } } ?>
                            </tr>
                            <?php } } ?>
                  </table>
                  <div class="form-group text-center custom-mt-form-group">
                  <button class="btn btn-primary btn-lg mr-2" type="submit">Submit</button>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">
   $(function(){
       $("#addStudentMarks").validate({
           ignore: "input[type='text']:hidden",
           rules:{
               'marks_obtain[]':{
                   required:true
               },
               total_marks:{
                   required:true
               }
           }
       });
   });
</script>