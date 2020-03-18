<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php';
require_once 'employee/class/Exams.php'; 
require_once 'employee/class/StudentMarks.php';
$teacher_id = $_SESSION['userId']; 
$user_role = $_SESSION['user_role'];
$teacher = new Teacher();    
    if($_SESSION['user_role'] == '2') {
    $output = $teacher->getTeacherClassName($teacher_id);
    $get_class_id = $output[0]['classId'];
    $get_section_id = $output[0]['sectionId'];
    $get_total_class_students = $teacher->getTotalClassStudents($get_class_id,$get_section_id);    
    } else {
        header('Location: ' . BASE_ROOT.'dashboard.php');
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
                            <h5 class="text-uppercase">Students Listing</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Students List</li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">First Name</th>
                                        <th style="min-width:50px;">Last Name</th>
                                        <th style="min-width:50px;">Add Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php foreach ($get_total_class_students as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['first_name']; ?></td>
                                        <td><?php echo $value['last_name']; ?></td>
                                        <td class="">
                                            <a href="add-students-marks.php?sID=<?php echo $value[0]; ?>" class="btn btn-primary btn-sm mb-1">
                                                Add Marks
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>