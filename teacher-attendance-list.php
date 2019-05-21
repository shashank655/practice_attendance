<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php'; 
$teacher_id = $_SESSION['userId']; 
$user_role = $_SESSION['user_role'];
$teacher = new Teacher();
if($user_role == '1') {
    $get_teachers_list = $teacher->getTeachersList();
}
$searchYear = (isset($_REQUEST['year'])) ? $_REQUEST['year'] : NULL;
    if ($searchYear != NULL) {
        $current_year = $searchYear;
    } else {
        $current_year = date('Y');
    } 
$searchMonth = (isset($_REQUEST['month'])) ? $_REQUEST['month'] : NULL;
    if ($searchMonth != NULL) {
        $current_month = $searchMonth;
    } else {
        $current_month = date('m');
    }   
$teacherId = (isset($_REQUEST['teacher_id'])) ? $_REQUEST['teacher_id'] : NULL;
    if ($teacherId != NULL) {
        $teacher_id = $teacherId;
    }
$resultAttendanceList=$teacher->getAttendanceLists($teacher_id, $current_year, $current_month); 
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
							<h5 class="text-uppercase">Attendance</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Attendance List</li>
							</ul>
						</div>
					</div>
				</div>
			<div class="content-page">
                <form id="searchAttendance" action="teacher-attendance-list.php" method="get" novalidate="novalidate">
                 <div class="row">
                    <?php if($user_role == '1') { ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                                <select name="teacher_id" id="teacher_id">
                                    <option value="">Select Teacher</option>
                                    <?php for ($i=0 ; $i < count($get_teachers_list); $i++) : ?>
                                        <option <?php if (isset($teacherId)) { if ($teacherId==$get_teachers_list[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $get_teachers_list[$i][ 'id']; ?>"><?php echo $get_teachers_list[$i][ 'first_name'].' '.$get_teachers_list[$i][ 'last_name']; ?></option>
                                    <?php endfor; ?>
                                 </select>
                                 <label class="control-label">Select Year</label><i class="bar"></i>
                            </div>        
                    </div>
                    <?php } ?> 
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                            <select name="month" id="month">
                                <option value="">Select Month</option>
                                <option <?php if($current_month == '01'){echo 'selected'; } ?> value="01">Jan</option>
                                <option <?php if($current_month == '02'){echo 'selected'; } ?> value="02">Feb</option>
                                <option <?php if($current_month == '03'){echo 'selected'; } ?> value="03">Mar</option>
                                <option <?php if($current_month == '04'){echo 'selected'; } ?> value="04">Apr</option>
                                <option <?php if($current_month == '05'){echo 'selected'; } ?> value="05">May</option>
                                <option <?php if($current_month == '06'){echo 'selected'; } ?> value="06">Jun</option>
                                <option <?php if($current_month == '07'){echo 'selected'; } ?> value="07">Jul</option>
                                <option <?php if($current_month == '08'){echo 'selected'; } ?> value="08">Aug</option>
                                <option <?php if($current_month == '09'){echo 'selected'; } ?> value="09">Sep</option>
                                <option <?php if($current_month == '10'){echo 'selected'; } ?> value="10">Oct</option>
                                <option <?php if($current_month == '11'){echo 'selected'; } ?> value="11">Nov</option>
                                <option <?php if($current_month == '12'){echo 'selected'; } ?> value="12">Dec</option>
                             </select>
                             <label class="control-label">Select Month</label><i class="bar"></i>
                        </div>  
                    </div>
                    <div class="col-sm-6 col-md-3">
                    <div class="form-group custom-mt-form-group">
                            <select name="year" id="year">
                                <option value="">Select Year</option>
                                <option <?php if($current_year == '2021'){echo 'selected'; } ?> value="2021">2021</option>
                                <option <?php if($current_year == '2020'){echo 'selected'; } ?> value="2020">2020</option>
                                <option <?php if($current_year == '2019'){echo 'selected'; } ?> value="2019">2019</option>
                             </select>
                             <label class="control-label">Select Year</label><i class="bar"></i>
                        </div>  
                       
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                        <button class="btn btn-success btn-block" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Date of Attendance</th>
                                        <th style="min-width:50px;">Login Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                	<?php foreach ($resultAttendanceList as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php 
                                        echo date('jS F, Y', strtotime($value['date_of_attendance'])); ?></td>
                                        <td><?php echo $value['login_time'];?></td>
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