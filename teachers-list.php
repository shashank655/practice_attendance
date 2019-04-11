<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php'; 
require_once 'employee/class/CommonFunction.php'; 
$common_function=new CommonFunction(); 
$resultAllTeachers=$common_function->getAllTeachers(); 
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
							<h5 class="text-uppercase">Teachers</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"><a href="#">Teachers</a></li>
								<li class="list-inline-item"> All Teachers</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-teacher.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Teacher</a>
                        <div class="view-icons">
                            <a href="all-teachers.php" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                            <a href="teachers-list.php" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
			<div class="content-page">
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text"  />
							<label class="control-label">Teacher ID</label><i class="bar"></i>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<input type="text"  />
							<label class="control-label">Teacher Name</label><i class="bar"></i>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-3">
						<div class="form-group custom-mt-form-group">
							<select >
								 <option>Maths</option>
                                <option>English</option>
                                <option>Science</option>
                                <option>Social Science</option>
                                <option>Finance</option>
							 </select>
							 <label class="control-label">Subject</label><i class="bar"></i>
						</div>	
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <a href="#" class="btn btn-success btn-block mt-4 mb-2"> Search </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">Name (Subject)</th>
                                        <th style="min-width:70px;">Teacher ID</th>
                                        <th style="min-width:50px;">Gender</th>
										<th style="min-width:50px;">Address</th>
										<th style="min-width:80px;">Date of Birth</th>
                                        <th style="min-width:50px;">Email</th>
                                        <th style="min-width:50px;">Mobile</th>
                                        <th class="text-right" style="width:15%;" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach ($resultAllTeachers as $key => $value) { ?>
                                    <tr>
                                        <td>
                                            <a href="teacher-profile.php?userId=<?php echo $value[0]; ?>" class="avatar"><?php echo substr($value['first_name'], 0, 1) ?></a>
                                            <h2><a href="teacher-profile.php?userId=<?php echo $value[0]; ?>"><?php echo $value['first_name'].' '.$value['last_name']; ?> <span>(<?php echo $value['subject_name']; ?>)</span></a></h2>
                                        </td>
                                        <td><?php echo $value['teacher_id']; ?></td>
                                        <td><?php echo $value['gender']; ?></td>
                                        <td><?php echo $value['permanent_address']; ?></td>
										<td><?php echo $value['dob']; ?></td>
                                        <td><?php echo $value['email_address']; ?></td>
                                        <td><?php echo $value['mobile_number']; ?></td>
                                        <td class="text-right" >
											<a href="add-teacher.php?userId=<?php echo $value[0]; ?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
											<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
											<i class="fa fa-trash" aria-hidden="true"></i>
											</button>
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
        <?php require_once 'includes/footer.php'; ?>