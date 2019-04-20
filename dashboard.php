<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$totalStudent=$common_function->getCountStudent(); 
$totalTeacher = $common_function->getCountTeacher();
$resultAllStudents=$common_function->getAllStudents();

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>
<div class="page-wrapper"> <!-- content -->
<?php if (isset($_SESSION[ 'Msg']) && $_SESSION[ 'Msg'] !='' ) { 
									if($_SESSION['success']) {
										$alertClass = 'success';
										$alertValue = 'Success';
									} else {
										$alertClass = 'danger';
										$alertValue = 'Error';
									}
								?>
							<div class="alert alert-<?php echo $alertClass; ?> alert-dismissible fade show" role="alert"> <strong><?php echo $alertValue; ?>!</strong> 
								<?php echo $_SESSION[ 'Msg']; ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
								</button>
							</div>
							<script>
								setTimeout(function() {
								                    $(".alert").fadeOut("slow");
								                }, 5000)
							</script>
							<?php $_SESSION[ 'Msg']='' ; unset($_SESSION[ 'Msg']); } ?>
            <div class="content container-fluid">
               <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-primary"><i class="fa fa-users" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $totalStudent[0][0]; ?></h3>
                                <span>Students</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-info"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php echo $totalTeacher[0][0]; ?></h3>
                                <span>Teachers</span>
                            </div>
                        </div>
                    </div>
                   <!--  <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-warning"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3><?php //echo $totalStudent[0][0]; ?></h3>
                                <span>Parents</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="fa fa-money" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3>1000</h3>
                                <span>Total Absentees</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                            <span><a href="#" data-toggle="modal" data-target="#assign_teacher_password">Teacher Global Password</a></span>
                            </div>
                        </div>
                    </div>

                </div>
				<div class="row">
					<div class="col-lg-6">
						<div class="content-page">
							<div class="page-title">Total Members</div>
							<div id="school-chart"></div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="content-page">
							<div class="page-title">Income Monthwise</div>
							<div id="incomeChart" style="height: 350px;"></div>
						</div>
					</div>
				</div>
				
				<div class="row mt-4">
					<div class="col-lg-6 col-md-12 col-12">
						 <div class="card-box m-b-2">
							<div class="page-title mb-2">
								Events
							</div>
							<div class="card-body p-0">
                              <div id="calendar"></div>
							 </div>
                        </div>
					</div>
					<div class="col-lg-6">
						<div class="content-page">
							<div class="row">
								<div class="col-md-12">
									<div class="page-title mb-2">
										Exam-list
									</div>
									<div class="table-responsive">
										<table class="table table-striped custom-table">
											<thead>
												<tr>
													<th style="min-width:91px;">Exam Name </th>
													<th style="min-width:50px;">Subject</th>
													<th style="min-width:50px;">Class</th>
													<th style="min-width:50px;">Section</th>
													<th style="min-width:50px;">Time</th>
													<th style="min-width:50px;">Date</th>
													<th class="text-right" style="width:30%;">Action</th>
												</tr>
											</thead>
											<tbody>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>English</td>
													<td>5</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right" >
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>English</td>
													<td>4</td>
													<td>A</td>
													<td>10.00am</td>
													<td>2/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												
												<tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Maths</td>
													<td>6</td>
													<td>B</td>
													<td>10.00am</td>
													<td>2/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Science</td>
													<td>3</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Maths</td>
													<td>6</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>English</td>
													<td>7</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Science</td>
													<td>5</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-lg-12">
						<div class="content-page">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="page-title mb-2">
										All Students
									</div>
									<div class="table-responsive">
										<table class="table table-striped custom-table">
											<thead>
												<tr>
													<th style="min-width:50px;">Name </th>
													<th style="min-width:74px;">Student ID</th>
													<th style="min-width:50px;">Fathers Name</th>
													<th style="min-width:50px;">Address</th>
													<th style="min-width:98px;">Date of Birth</th>
													<th style="min-width:90px;">Mobile</th>
													<th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($resultAllStudents as $key => $value) { ?>
												<tr>
													<td>
														<h2><a href="student-profile.php?studentId=<?php echo $value[0]; ?>" class="avatar text-white"><?php echo substr($value['first_name'], 0, 1) ?></a></h2>
														<h2><a href="student-profile.php?studentId=<?php echo $value[0]; ?>"><?php echo $value['first_name'].' '.$value['last_name']; ?> <span></span></a></h2>
													</td>
													<td><?php echo $value['student_id'];?></td>
			                                        <td><?php echo $value['fathers_name'];?></td>
			                                        <td><?php echo $value['permanent_address'];?></td>
													<td><?php echo $value['dob'];?></td>
			                                        <td><?php echo $value['mobile_number'];?></td>
													<td class="text-right">
														<a href="add-student.php?studentId=<?php echo $value[0]; ?>" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<a href="#" val="<?php echo $value[0]; ?>" id="delete_student" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</a>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					 </div>       
				</div>
			</div>
		</div>
	</div>
	<div id="assign_teacher_password" class="modal" role="dialog">
            <div class="modal-dialog">
				
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign Teacher Password</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="teacher_password" action="employee/process/processAddTeacher.php" method="post" novalidate="novalidate">
                        	<input type="hidden" name="type" value="assign_teacher_password" />
                            <div class="form-group custom-mt-form-group">
								<input type="password" id="password" name="password" value="" />
								<label class="control-label">Enter Password <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="form-group custom-mt-form-group">
								<input type="password" name="repeat_password" value="" >
								<label class="control-label">Re-Enter Password <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
	var totalStudent = <?php echo $totalStudent[0][0]?> ;
	var totalTeacher = <?php echo $totalTeacher[0][0]?> ;
</script>
<?php 
require_once 'includes/footer.php';
?>
<script type="text/javascript">
	$( "#delete_student" ).click(function() {
        var id = $(this).attr('val');
        var r = confirm("Are You Sure Delete Student ?");
            if (r==true){
                $.ajax({
                    type: "POST",
                    url: "employee/process/processAddStudent.php",
                    data:{studentId:id,type:'delete'},
                    beforeSend : function () {
                    },
                    success:function(data){
                    	alert('Deleted Successfully');
                    }
                });
            }else{   
            }
    });

    $(function(){
        $("#teacher_password").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                password:{
                    required:true,
                    minlength: 4
                },
                repeat_password:{
                    required:true,
                    equalTo:"#password"
                }
            }
        });
    });
</script>