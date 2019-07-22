<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php'; 
require_once 'employee/class/StudentMarks.php';
$teacher_id = $_SESSION['userId']; 
$user_role = $_SESSION['user_role'];
$teacher = new Teacher();
$student_marks = new StudentMarks();
// $examTermData = $student_marks->getStudentsMarks($_POST['exam_term_id'] , '10');
// die;
if($_POST) {
    if($_SESSION['user_role'] == '2') {
        $output = $teacher->getTeacherClassName($teacher_id);
        $get_class_id = $output[0]['classId'];
        $get_section_id = $output[0]['sectionId'];

        $examTermId = (isset($_POST['exam_term_id'])) ? $_POST['exam_term_id'] : NULL;
        if ($examTermId != NULL) { 
            $checkResultIfExist = $student_marks->getResultIfExist($examTermId,$get_class_id,$get_section_id,$teacher_id);

            $examTermData = $student_marks->getExamTermData($examTermId);
        }
        if(empty($checkResultIfExist)) {
            $_SESSION['Msg'] = "Results data not found!";
            $_SESSION['success'] = true;
            header('Location: ' . BASE_ROOT.'select-term-session.php');
        }    
        $get_total_class_students = $teacher->getTotalClassStudents($get_class_id,$get_section_id); 

    } else {
        header('Location: ' . BASE_ROOT.'select-term-session.php');
    }
} else {
    header('Location: ' . BASE_ROOT.'select-term-session.php');
}
?>

<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> <!-- content -->
    <div class="content container-fluid">
     <div class="page-header">
       <div class="row">
          <div class="col-lg-7 col-md-12 col-sm-12 col-12">
             <h5 class="text-uppercase">Student Marks</h5>
         </div>
         <div class="col-lg-5 col-md-12 col-sm-12 col-12">
             <ul class="list-inline breadcrumb float-right">
                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                <li class="list-inline-item"> Student Marks</li>
            </ul>
        </div>

        <?php if(!empty($get_total_class_students)) { ?>
        <div class="contact-cat col-sm-4 col-lg-3">
            <div class="roles-menu">
                <ul>
                    <?php foreach ($get_total_class_students as $key => $value) { ?>
                    <li class=""><a href="javascript:void();" studentId="<?php echo $value['id'] ?> " class="student_id" /><?php echo $value['first_name'].' '.$value['last_name']; ?></a></li>
                    <?php } ?>    
                </ul>
            </div>
        </div>
        <?php } ?>

    </div>
</div>
<div class="content-page">
    <ul>
        <li>Year Session: <?php echo $examTermData[0]['year_session']?></li>
        <li>Exams start date: <?php echo $examTermData[0]['start_date']?></li>
        <li>Exams end date: <?php echo $examTermData[0]['end_date']?></li>
        <li>Exam Type: <?php echo $examTermData[0]['exam_type']?></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <form id="addStudentMarks" action="employee/process/processStudentsMarks.php" method="post" novalidate="novalidate">
                <div class="table-responsive">
                    <table class="table table-bordered m-b-0">
                        <thead>
                            <tr>

                                <th style="min-width:50px;">Subjects Name</th>
                                <th style="min-width:50px;">Maximum Marks</th>
                                <th style="min-width:50px;">Marks obtain</th>
                            </tr>
                        </thead>
                        <tbody class="student-data-show">
                
                        </tbody>
                    </table>
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

        $( ".student_id" ).click(function() {
            var examTermId = "<?php echo $examTermId; ?>";
            var student_id=$(this).attr('studentId');
            $.ajax({
                type: "POST",
                url: "employee/process/processStudentsMarks.php",
                data:{student_id:student_id,examTermId:examTermId,type:'get_student_marks'},
                beforeSend : function () {
                },
                success:function(data){
                   data = $.parseJSON(data);
                   $(".student-data-show").empty();
                    var i;
                     for(var i=0;i<data.student_data.length;i++){  
                          var divAppend = "<tr><td>"+data.student_data[i]['subject_name']+"<td>"+data.student_data[i]['total_marks']+"</td><td>"+data.student_data[i]['marks_obtain']+"</td></tr>";
                          $(".student-data-show").append(divAppend);
                    }
                }
            });
        });

    });
</script>