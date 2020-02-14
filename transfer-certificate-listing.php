<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/TransferCertificate.php'; 
$transferCertificate = new TransferCertificate(); 
$resultAllListing=$transferCertificate->getTCFormsListing();
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
                            <h5 class="text-uppercase">Transfer Certificate Form</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Transfer Certificate List</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-transfer-certificate.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add T.C. Form</a>
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
                                        <th style="min-width:50px;">Student Name</th>
                                        <th style="min-width:50px;">Guardian Name</th>
                                        <th style="min-width:50px;">Address</th>
                                        <th style="min-width:50px;">Religion/Category</th>
                                        <th style="min-width:50px;">Joining Date</th>
                                        <th style="min-width:50px;">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php foreach ($resultAllListing as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo  $value['student_name']; ?></td>
                                        <td><?php echo $value['guardian_name']; ?></td>
                                        <td><?php echo $value['address']; ?></td>
                                        <td><?php echo $value['religion']; ?></td>
                                        <td><?php echo $value['joining'];?></td>
                                        <td><a href="view-tc-form.php?tcId=<?php echo $value[0];?>">View</a></td>
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