<?php
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php';
require_once 'employee/class/Teacher.php'; 
$teacher = new Teacher();
if($_SESSION['user_role'] == '2') {
    $output = $teacher->getTeacherClassName($_SESSION['userId']);
    $get_class_id = $output[0]['classId'];
    $get_section_id = $output[0]['sectionId'];
    $get_total_class_students = $teacher->getTotalClassStudents($get_class_id,$get_section_id);
    $isTodaysAttendanceCheck = $teacher->isTodaysAttendanceCheck($_SESSION['userId'], $get_class_id, $get_section_id);
        if($isTodaysAttendanceCheck) {
            $_SESSION['Msg'] = "Today's attendance has already been marked!";
            $_SESSION['success'] = true;
            header('Location: ' . BASE_ROOT.'student-attendance-list.php');
        }
} else {
    header('Location: ' . BASE_ROOT.'dashboard.php');
}
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
                            <h5 class="text-uppercase">Students Attendance</h5>
                        </div>
                    </div>
                </div>
			<div class="row mt-2">
                <div class="col-lg-12">
                    <form id="addAttendance" action="employee/process/processStudentsAttendance.php" method="post" novalidate="novalidate" onclick="return confirm('Are you sure you want to submit the attendance ?');">
                        <div class="content-page">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <!-- <div class="page-title mb-2">
                                     Students Attendance
                                    </div> -->
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table">
                                            <thead>
                                                <tr>
                                                    <th style="min-width:50px;">First Name </th>
                                                    <th style="min-width:74px;">Last Name</th>
                                                    <th style="min-width:50px;">Present</th>
                                                    <th style="min-width:50px;">Absent</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="type" value="student_attendance" />
                                                <input type="hidden" name="class_id" value="<?php echo $get_class_id; ?>" />
                                                <input type="hidden" name="section_id" value="<?php echo $get_section_id; ?>" />
                                                <input type="hidden" name="teacher_id" value="<?php echo $_SESSION['userId']; ?>" />
                                                <?php  foreach ($get_total_class_students as $key => $value) { ?>
                                                <input type="hidden" name="userId[]" value="<?php echo $value['id'] ?>" />
                                                <tr>
                                                    <td>
                                                        <h2><a href="profile.html" class="avatar text-white">P</a></h2>
                                                        <h2><a href="profile.html"><?php echo $value['first_name']; ?> <span></span></a></h2>
                                                    </td>
                                                    <td><?php echo $value['last_name']; ?></td>
                                                    <td>
                                                        <label class="custom_checkbox">
                                                          <input type="checkbox" checked="checked" name="attendance[]" value="P">
                                                          <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="custom_checkbox red">
                                                          <input type="checkbox" name="attendance[]" value="A">
                                                          <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td><?php echo date('Y-m-d') ?></td>                
                                                </tr>
                                                <?php } ?> 
                                            </form>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center custom-mt-form-group">
                            <button class="btn btn-primary btn-lg mr-2" type="submit">Submit</button>
                        </div>
                     </div>       
                </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>