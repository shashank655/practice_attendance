<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Admissions.php';  
$admissions=new Admissions(); 
$resultAdmissionsList=$admissions->getAllAdmissions(); 
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
							<h5 class="text-uppercase">Admissions</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Admissions List</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="new-admission.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> New Admission</a>
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
                                        <th style="min-width:50px;">Name</th>
                                        <th style="min-width:50px;">Email Address</th>
                                        <th style="min-width:50px;">Gender</th>
                                        <th style="min-width:50px;">DOB</th>
                                        <th style="min-width:50px;">Class</th>
                                        <th style="min-width:50px;">Section</th>
                                        <th style="min-width:50px;">Religion</th>
                                        <th style="min-width:50px;">Date of Joining</th>
                                        <th style="min-width:50px;">Mobile No</th>
                                        <th style="min-width:50px;">Father's Name</th>
                                        <th style="min-width:50px;">Father's Occupation</th>
                                        <th style="min-width:50px;">Parents Mobile No</th>
                                        <th style="min-width:50px;">Present Address</th>
                                        <th style="min-width:50px;">Mother's Name</th>
                                        <th style="min-width:50px;">Mother's Occupation</th>
                                        <th style="min-width:50px;">Nationality</th>
                                        <th style="min-width:50px;">Permanent Address</th>
                                        <th style="min-width:50px;">Admission Fee</th>
                                        <th style="min-width:50px;">Created On</th>
                                        <th style="min-width:50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                	<?php foreach ($resultAdmissionsList as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                        <td><?php echo $value['email_address']; ?></td>
                                        <td><?php echo $value['gender']; ?></td>
                                        <td><?php echo $value['dob']; ?></td>
                                        <td><?php echo $value['class_name']; ?></td>
                                        <td><?php echo $value['section_name']; ?></td>
                                        <td><?php echo $value['religion']; ?></td>
                                        <td><?php echo $value['date_of_joining']; ?></td>
                                        <td><?php echo $value['mobile_number']; ?></td>
                                        <td><?php echo $value['fathers_name']; ?></td>
                                        <td><?php echo $value['fathers_occupation']; ?></td>
                                        <td><?php echo $value['parents_mobile_number']; ?></td>
                                        <td><?php echo $value['present_address']; ?></td>
                                        <td><?php echo $value['mothers_name']; ?></td>
                                        <td><?php echo $value['mothers_occupation']; ?></td>
                                        <td><?php echo $value['nationality']; ?></td>
                                        <td><?php echo $value['permanent_address']; ?></td>
                                        <td><?php echo $value['admission_fee']; ?></td>
                                        <td><?php echo date('d M, Y', strtotime($value['created_at'])); ?></td>
                                        <td class="text-right" >
											<a href="new-admission.php?admissionId=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
                                            <a href="employee/process/processNewAdmission.php?type=deleteAdmission&id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm mb-1">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
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