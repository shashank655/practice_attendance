<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Exams.php';  
$exams=new Exams(); 
$resultExamList=$exams->getExamsLists(); 
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
							<h5 class="text-uppercase">Exams</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Exams List</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-exams.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Exams</a>
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
                                        <th style="min-width:50px;">Exam Type</th>
                                        <th style="min-width:50px;">Exam Term</th>
                                        <th style="min-width:50px;">Class</th>
                                        <th style="min-width:50px;">Sections</th>
                                        <th style="min-width:50px;">Date of exam</th>
                                        <th style="min-width:50px;">Time of exam</th>
                                        <th style="min-width:50px;">Exam Name</th>
                                        <th style="min-width:50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                	<?php foreach ($resultExamList as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['exam_type']; ?></td>
                                        <td><?php echo 'Session:'.$value['year_session'].', Start Date:'.$value['start_date'].', End Date:'.$value['end_date']; ?></td>
                                        <td><?php echo $value['class_name']; ?></td>
                                        <td><?php echo $value['section_name'];?></td>
                                        <td><?php echo $value['date_of_exam']; ?></td>
                                        <td><?php echo $value['time_of_exam']; ?></td>
                                        <td><?php echo $value['subject_name']; ?></td>
                                        <td class="text-right" >
											<a href="add-exams.php?examId=<?php echo $value[0]; ?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
                                            <a href="employee/process/processExams.php?type=deleteExams&id=<?php echo $value[0]; ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger btn-sm mb-1">
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