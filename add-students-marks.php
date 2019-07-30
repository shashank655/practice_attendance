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
                                <li class="list-inline-item"> Add Student Marks</li>
							</ul>
						</div>
					</div>
				</div>
			<div class="content-page">
            <ul>
                <li>Date of Exam: <?php echo $resultExam[0]['date_of_exam']?></li>
                <li>Time: <?php echo $resultExam[0]['time_of_exam']?></li>
                <li>Session: <?php echo $resultExam[0]['year_session']?></li>
                <li>Exam Type: <?php echo $resultExam[0]['exam_type']?></li>
                <li>Class: <?php echo $resultExam[0]['class_name']?></li>
                <li>Section: <?php echo $resultExam[0]['section_name']?></li>
                <li>Subject Name: <?php echo $resultExam[0]['subject_name']?></li>
            </ul>
                <div class="row">
                    <div class="col-md-12">
                    <form id="addStudentMarks" action="employee/process/processStudentsMarks.php" method="post" novalidate="novalidate">
                        <div class="table-responsive">
                            <table class="table table-bordered m-b-0">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Student Name</th>
                                        <th style="min-width:50px;">Maximum Marks: <input type="text" name="total_marks" placeholder="Max marks" value="<?php echo $get_students_subject_marks[0]['total_marks']?>"  ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <input type="hidden" name="type" value="student_marks" />
                                <input type="hidden" name="class_id" value="<?php echo $get_class_id; ?>" />
                                <input type="hidden" name="section_id" value="<?php echo $get_section_id; ?>" />
                                <input type="hidden" name="exam_id" value="<?php echo $examId; ?>" />
                                <input type="hidden" name="exam_term_id" value="<?php echo $resultExam[0]['exam_term_id']; ?>" />
                                <input type="hidden" name="exam_name" value="<?php echo $resultExam[0]['exam_name']; ?>" />
                                <?php $i=1; ?>
                                	<?php foreach ($get_total_class_students as $key => $value) {
                                    if(!empty($get_students_subject_marks)) {
                                        if($get_students_subject_marks[$key]['student_id'] == $value['id']) {
                                            $subjectMarks = $get_students_subject_marks[$key]['marks_obtain'];
                                        }
                                    }
                                    ?>
                                    <input type="hidden" name="student_id[]" value="<?php echo $value['id'] ?>" />
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['first_name'].' '.$value['last_name'] ?></td>
                                        <td>
                                            <input type="text" name="marks_obtain[]" value="<?php echo $subjectMarks; ?>"  >
                                        </td>
                                    </tr>
                                	<?php $i++; } ?>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-center custom-mt-form-group">
                            <button class="btn btn-primary btn-lg mr-2" type="submit">Submit</button>
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