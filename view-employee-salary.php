<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/EmployeeSalary.php';
require_once 'employee/class/Admin.php'; 
$employee_salary=new EmployeeSalary(); 
$admin = new Admin(); 
$adminData = $admin->getAdminInfo($_SESSION['userId']);
$sId = (isset($_REQUEST['sId'])) ? $_REQUEST['sId'] : NULL; 
if ($sId != NULL) { $result=$employee_salary->viewEmployeeSalary($sId); 
    if ($result == NULL) { $sId = ''; } }
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
							<h5 class="text-uppercase">Payslip</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"><a href="#">Payroll</a></li>
								<li class="list-inline-item"> Payslip</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-5 col-4">
                        
                    </div>
                    <div class="col-sm-7 col-8 text-right m-b-30">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-white">CSV</button>
                            <button class="btn btn-white">PDF</button>
                            <button onClick="window.print()" class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="payslip-title"><b>Payslip for the month of <?php echo date('F Y'); ?></b></h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">
                                    <img src="<?php echo BASE_ROOT ?>assets/img/logo.png" class="inv-logo" alt="">
                                    <ul class="list-unstyled m-b-0">
                                        <li><?php echo $adminData[0]['school_name'] ?></li>
                                        <li><?php echo $adminData[0]['phone_number'] ?></li>
                                        <li><?php echo $adminData[0]['address'] ?></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase"><b>Payslip #49029</b></h3>
                                        <ul class="list-unstyled">
                                            <li>Salary Month: <span><?php echo date('F Y'); ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-b-20">
                                    <ul class="list-unstyled">
                                        <li>
                                            <h5 class="m-b-0"><strong><?php echo $result[0]['first_name'].' '.$result[0]['last_name'] ?></strong></h5></li>
                                        <li><?php echo $result[0]['email_address']; ?></li>
                                        <li><?php echo $result[0]['gender']; ?></li>
                                        <li><?php echo $result[0]['mobile_number']; ?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Basic Salary</strong> <span class="float-right"><?php
                                                if (isset($result[0]['basic']))
                                                echo $result[0]['basic'];
                                                ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>House Rent Allowance (H.R.A.)</strong> <span class="float-right"><?php
                                                if (isset($result[0]['hra']))
                                                echo $result[0]['hra'];
                                                ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Conveyance</strong> <span class="float-right"><?php
                                                if (isset($result[0]['conveyance']))
                                                echo $result[0]['conveyance'];
                                                ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Medical Allowance</strong> <span class="float-right"><?php
                                                if (isset($result[0]['medical_allowance']))
                                                echo $result[0]['medical_allowance'];
                                                ?></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <h4 class="m-b-10"><strong>Deductions</strong></h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Tax Deducted at Source (T.D.S.)</strong> <span class="float-right"><?php
                                                if (isset($result[0]['tds']))
                                                echo $result[0]['tds'];
                                                ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Provident Fund</strong> <span class="float-right"><?php
                                                if (isset($result[0]['pf']))
                                                echo $result[0]['pf'];
                                                ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>ESI</strong> <span class="float-right"><?php
                                                if (isset($result[0]['esi']))
                                                echo $result[0]['esi'];
                                                ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Loan</strong> <span class="float-right">$300</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Deductions</strong> <span class="float-right"><strong>$59698</strong></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p><strong>Net Salary: $59698</strong> (Fifty nine thousand six hundred and ninety eight only.)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>