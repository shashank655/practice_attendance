<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/AdmissionForm.php'; 
$admissionForm = new AdmissionForm(); 
$resultAllListing=$admissionForm->getCancelAdmissionFormsListing();
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
                            <h5 class="text-uppercase">Cancel Admission Form</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Admission Form List</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-admission-form.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Admission Form</a>
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
                                        <th style="min-width:50px;">Fees Status</th>
                                        <th style="min-width:50px;">Full Name</th>
                                        <th style="min-width:50px;">Admission Number</th>
                                        <th style="min-width:50px;">Father's Name</th>
                                        <th style="min-width:50px;">Gender</th>
                                        <th style="min-width:50px;">Class</th>
                                        <th style="min-width:50px;">Sections</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php foreach ($resultAllListing as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>

                                        <?php 
                                            if($value['fees_submit_status'] == '1') {
                                                $paidStatus = 'Paid';
                                            } else {
                                                $paidStatus = 'UnPaid';
                                            }
                                        ?>
                                        <td><strong><?php echo $paidStatus; ?></strong></td>
                                        <td><?php echo  $value['first_name'].' '.$value['last_name']; ?></td>
                                        <td><?php echo $value['admission_no']; ?></td>
                                        <td><?php echo $value['fathers_name']; ?></td>
                                        <td><?php echo $value['gender']; ?></td>
                                        <td><?php echo $value['class_name'];?></td>
                                        <td><?php echo $value['section_name']; ?></td>
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