<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once 'employee/config/config.php';
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
                <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">add teacher</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="index.html">Home</a></li>
								<li class="list-inline-item"><a href="index.html">Teacher</a></li>
								<li class="list-inline-item"> Add Teacher</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-content">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="page-title">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="page-title">basic information</div>
										</div>
										
									</div>
								</div>
								<div class="card-body">	
								<?php if (isset($_SESSION['Msg']) && $_SESSION['Msg'] != '') { ?>    
						                <div class="alert alert-danger alert-dismissible fade show" role="alert">
						                    <strong>Error!</strong> <?php echo $_SESSION['Msg']; ?>
						                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						                    <span aria-hidden="true">&times;</span>
						                    </button>
						                </div>
						                <script>
						                setTimeout(function() {
						                    $(".alert").fadeOut("slow");
						                }, 5000)
						                </script>
						            <?php 
						                $_SESSION['Msg'] = '';
						                unset($_SESSION['Msg']); 
						            } ?>
								<form id="addTeacherForm" action="employee/process/processAddTeacher.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
								<input type="hidden" value="teacher_sign_up" name="type" />
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
												<div class="form-group custom-mt-form-group">
													<input type="text"  name="first_name" />
													<label class="control-label">Firstname</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<input type="text"  name="email_address"/>
													<label class="control-label">Email</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<input type="password" name="password"  />
													<label class="control-label">Password</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<select id="gender" name="gender">
														<option value="male">Male</option>
														<option value="female">Female</option>
													 </select>
													 <label class="control-label">Gender</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													 <input class="datetimepicker" type="text" name="dob"> 
													<label class="control-label">Birth Date</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<input type="text"  name="class"/>
													<label class="control-label">Class</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<select id="is_class_teacher" name="is_class_teacher">
														<option value="1">Yes</option>
														<option value="0">No</option>
													 </select>
													 <label class="control-label">Is Class Teacher ?</label><i class="bar"></i>
												</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-12">
												<div class="form-group custom-mt-form-group">
													<input type="text"  name="last_name">
													<label class="control-label">Lastname</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													 <input class="form-control floating datetimepicker" type="text" name="joining_date">
													<label class="control-label">Joining Date</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<input type="password" name="repeat_password"  />
													<label class="control-label">Confirm Password</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<input type="number" name="mobile_number"  />
													<label class="control-label">Mobile number</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<select name="subject_id" id="subject_id">
														<option value="1">Computer</option>
														<option value="2">Science</option>
														<option value="3">Maths</option>
														<option value="4">Tamil</option>
														<option value="5">English</option>
														<option value="6">Social Science</option>
													 </select>
													 <label class="control-label">Subject</label><i class="bar"></i>
												</div>		
												<div class="form-group custom-mt-form-group">
													<input type="text"  name="teacher_id" />
													<label class="control-label">ID</label><i class="bar"></i>
												</div>
												<div class="form-group custom-mt-form-group">
													<input type="text"  name="section"/>
													<label class="control-label">Section</label><i class="bar"></i>
												</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="form-group">
													<textarea id="message" class="form__field" placeholder="Premanent Address" rows="4" name="permanent_address"></textarea>
													<label for="message" class="form-label">Premanent Address</label>
												</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="form-group custom-mt-form-group">
													  <input type="file" name="profile_image" style="margin-bottom:10px;">
													<label class="control-label"></label><i class="bar"></i>
												</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="form-group text-center custom-mt-form-group">
													<button class="btn btn-primary mr-2" type="submit">Submit</button>
													<button class="btn btn-secondary" type="reset">Cancel</button>
												</div>
										</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
<?php 
require_once 'includes/footer.php';
?>