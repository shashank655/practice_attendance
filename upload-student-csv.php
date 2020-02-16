<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Student.php'; 
require_once 'employee/class/CommonFunction.php';

?>

<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
        <div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
            <form method="post" action="employee/process/processUploadCSV.php" novalidate="novalidate" enctype="multipart/form-data">
            <input type="hidden" name="type" value="upload_student_csv" />
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                            <h5 class="text-uppercase">Upload Students</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        
                        <input type="file" name="CsvData" class="btn btn-primary btn-rounded float-left">

                        <a href="#" class="btn btn-primary btn-rounded float-right" data-toggle="modal" data-target="#student_csv_report"><i class="fa fa-plus"></i> Download CSV Format</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                        <div class="form-group custom-mt-form-group">
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
			</div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>