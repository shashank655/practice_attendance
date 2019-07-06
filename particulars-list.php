<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Particulars.php';  
$fees=new Particulars(); 
$resultFeesList=$fees->getParticularsLists(); 
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
							<h5 class="text-uppercase">Particulars</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Particulars</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-particulars.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Particular</a>
                    </div>
                </div>
			<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Title</th>
                                        <th style="min-width:50px;">Created On</th>
                                        <th style="min-width:50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php 
                                    if ($resultFeesList) {
                                    foreach ($resultFeesList as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo date('d M, Y', strtotime($value['created_at'])); ?></td>
                                        <td class="text-right" >
											<a href="add-particulars.php?feeId=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
                                            <a href="employee/process/processParticulars.php?type=deleteParticulars&id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm mb-1">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
											
										</td>
                                    </tr>
                                	<?php $i++; }  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>