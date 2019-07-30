<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/EmployeeSalary.php'; 
$employee_salary=new EmployeeSalary(); 
$resultSalaryData=$employee_salary->getEmployeeSalaryList();
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
                            <h5 class="text-uppercase">Teacher Salary</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="#">Home</a></li>
                                <li class="list-inline-item"><a href="#">Payroll</a></li>
                                <li class="list-inline-item"> Teacher's Salary</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-5">
                        
                    </div>
                    <div class="col-sm-8 col-7 text-right m-b-30">
                        <a href="add-employee-salary.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Salary</a>
                    </div>
                </div>
            <div class="content-page">
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12">
                        <div class="form-group custom-mt-form-group">
                             <input class="form-control" type="text" >
                            <label class="control-label">Employee Name</label><i class="bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group custom-mt-form-group">
                        <select >
                            <option> -- Select -- </option>
                            <option>Employee</option>
                            <option>H.O.D</option>
                         </select>
                         <label class="control-label">Role</label><i class="bar"></i>
                    </div>
                    </div>
                     <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12">
                        <div class="form-group custom-mt-form-group">
                             <input class="form-control floating datetimepicker" type="text" >
                            <label class="control-label">From</label><i class="bar"></i>
                        </div>
                    </div>
                     <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group custom-mt-form-group">
                             <input class="form-control floating datetimepicker" type="text" >
                            <label class="control-label">To</label><i class="bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12 ">
                        <a href="#" class="btn btn-success btn-block mt-4 mb-2"> Search </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive mt-2">
                            <table class="table custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="width:25%;">Teacher</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Payslip</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultSalaryData as $key => $value) { ?>
                                    <tr>
                                        <td>
                                            <h2><?php echo $value['first_name'].' '.$value['last_name'] ?></h2>
                                        </td>
                                        <td><?php echo $value['email_address']; ?></td>
                                        <td><?php echo $value['gender']; ?></td>
                                        <td><?php echo $value['mobile_number']; ?></td>
                                        <td><a class="btn btn-sm btn-primary" href="view-employee-salary.php?sId=<?php echo $value['salaryId']; ?>">Generate Slip</a></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="add-employee-salary.php?sId=<?php echo $value['salaryId']; ?>" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_salary" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
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
        </div>
        <?php require_once 'includes/footer.php'; ?>