<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/UploadCSV.php'; 
$uploadCSV = new UploadCSV(); 
$resultAllListing=$uploadCSV->getCSVStudentsListing();
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
                            <h5 class="text-uppercase">Upload Student CSV</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Upload Student CSV</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <form method="post" action="employee/process/processUploadCSV.php" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="upload_student_csv" />
                            <input type="file" name="CsvData" class="btn btn-primary btn-rounded float-left">
                            <button class="btn btn-primary btn-block" type="submit">Submit</button>
                        </form>    
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-transfer-certificate.php" class="btn btn-primary float-right btn-rounded">Download Sample Student CSV</a>
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
                                        <th style="min-width:50px;">Admission.No.</th>
                                        <th style="min-width:50px;">Student Name</th>
                                        <th style="min-width:50px;">Father's Name</th>
                                        <th style="min-width:50px;">Parents Mobile </th>
                                        <th style="min-width:50px;">Email Address</th>
                                        <th style="min-width:50px;">Gender</th>
                                        <th style="min-width:50px;">DOB</th>
                                        <th style="min-width:50px;">Religion</th>
                                        <th style="min-width:50px;">Joining Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php foreach ($resultAllListing as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo  $value['admission_no']; ?></td>
                                        <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                        <td><?php echo $value['fathers_name']; ?></td>
                                        <td><?php echo $value['parents_mobile_number']; ?></td>
                                        <td><?php echo $value['email_address'];?></td>
                                        <td><?php echo $value['gender'];?></td>
                                        <td><?php echo $value['dob'];?></td>
                                        <td><?php echo $value['religion'];?></td>
                                        <td><?php echo $value['date_of_joining'];?></td>
                                        
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