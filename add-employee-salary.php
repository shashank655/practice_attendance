<?php
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php';
require_once 'employee/class/EmployeeSalary.php';
$teacher = new Teacher();
$employee_salary = new EmployeeSalary();
$get_teachers_list = $teacher->getTeachersList(); 

$salaryId = (isset($_REQUEST['sId'])) ? $_REQUEST['sId'] : NULL; 
if ($salaryId != NULL) { $result = $employee_salary->getEmployeeSalaryInfo($salaryId); 
    if ($result == NULL) { $salaryId = ''; } } 
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
						<h5 class="text-uppercase">Add Salary</h5>
					</div>
					<div class="col-lg-5 col-md-12 col-sm-12 col-12">
						<ul class="list-inline breadcrumb float-right">
							<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Employee Salary</li>
						</ul>
					</div>
				</div>
			</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <form id="addEmployeeSalary" action="employee/process/processEmployeeSalary.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $salaryId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="salaryId" value="<?php echo $salaryId; ?>" />
                            <div class="form-group row">
                                    <label class="col-form-label col-md-2">Teachers</label>
                                    <div class="col-md-10">
                                        <select name="teacher_id" class="form-control" id="teacher_id">
                                            <option value="">Select Teacher</option>
                                            <?php for ($i=0 ; $i < count($get_teachers_list); $i++) : ?>
                                                <option <?php if (isset($result[0]['teacher_id'])) { if ($result[0]['teacher_id']==$get_teachers_list[$i]['id']) { echo 'selected'; } } ?> value="<?php echo $get_teachers_list[$i][ 'id']; ?>"><?php echo $get_teachers_list[$i][ 'first_name'].' '.$get_teachers_list[$i][ 'last_name']; ?></option>
                                            <?php endfor; ?>
                                 </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Gross Salary</label>
                                    <div class="col-md-10">
                                        <input type="text" name="gross_salary" class="form-control" value="<?php
                                                if (isset($result[0]['gross_salary']))
                                                echo htmlspecialchars($result[0]['gross_salary']);
                                                ?>">
                                    </div>
                                </div>
                                <h4 class="card-title">Earnings</h4>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Basic</label>
                                    <div class="col-md-10">
                                        <input type="text" name="basic" class="form-control" value="<?php
                                                if (isset($result[0]['basic']))
                                                echo htmlspecialchars($result[0]['basic']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">DA(4%)</label>
                                    <div class="col-md-10">
                                        <input type="text" name="da" class="form-control" value="<?php
                                                if (isset($result[0]['da']))
                                                echo htmlspecialchars($result[0]['da']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">HRA(15%)</label>
                                    <div class="col-md-10">
                                        <input type="text" name="hra" class="form-control" value="<?php
                                                if (isset($result[0]['hra']))
                                                echo htmlspecialchars($result[0]['hra']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Conveyance</label>
                                    <div class="col-md-10">
                                        <input type="text" name="conveyance" class="form-control" value="<?php
                                                if (isset($result[0]['conveyance']))
                                                echo htmlspecialchars($result[0]['conveyance']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Allowance</label>
                                    <div class="col-md-10">
                                        <input type="text" name="allowance" class="form-control" value="<?php
                                                if (isset($result[0]['allowance']))
                                                echo htmlspecialchars($result[0]['allowance']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Medical Allowance</label>
                                    <div class="col-md-10">
                                        <input type="text" name="medical_allowance" class="form-control" value="<?php
                                                if (isset($result[0]['medical_allowance']))
                                                echo htmlspecialchars($result[0]['medical_allowance']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Others</label>
                                    <div class="col-md-10">
                                        <input type="text" name="others" class="form-control" value="<?php
                                                if (isset($result[0]['others']))
                                                echo htmlspecialchars($result[0]['others']);
                                                ?>">
                                    </div>
                                </div>
                                <h4 class="card-title">Deductions</h4>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">TDS</label>
                                    <div class="col-md-10">
                                        <input type="text" name="tds" class="form-control" value="<?php
                                                if (isset($result[0]['tds']))
                                                echo htmlspecialchars($result[0]['tds']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">ESI</label>
                                    <div class="col-md-10">
                                        <input type="text" name="esi" class="form-control" value="<?php
                                                if (isset($result[0]['esi']))
                                                echo htmlspecialchars($result[0]['esi']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">PF</label>
                                    <div class="col-md-10">
                                        <input type="text" name="pf" class="form-control" value="<?php
                                                if (isset($result[0]['pf']))
                                                echo htmlspecialchars($result[0]['pf']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Leave</label>
                                    <div class="col-md-10">
                                        <input type="text" name="leaves" class="form-control" value="<?php
                                                if (isset($result[0]['leaves']))
                                                echo htmlspecialchars($result[0]['leaves']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Prof. Tax</label>
                                    <div class="col-md-10">
                                        <input type="text" name="prof_tax" class="form-control" value="<?php
                                                if (isset($result[0]['prof_tax']))
                                                echo htmlspecialchars($result[0]['prof_tax']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Labour Welfare</label>
                                    <div class="col-md-10">
                                        <input type="text" name="labour_welfare" class="form-control" value="<?php
                                                if (isset($result[0]['labour_welfare']))
                                                echo htmlspecialchars($result[0]['labour_welfare']);
                                                ?>">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Fund</label>
                                    <div class="col-md-10">
                                        <input type="text" name="fund" class="form-control" value="<?php
                                                if (isset($result[0]['fund']))
                                                echo htmlspecialchars($result[0]['fund']);
                                                ?>">
                                    </div>
                                </div>
                            <div class="form-group text-center custom-mt-form-group">
								<button class="btn btn-primary btn-lg mr-2" type="submit">Create</button>
							</div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <script type="text/javascript">
    jQuery.validator.addMethod("dropdownValidation", function(value, element, params) {        
        return $.trim(value) != '';
    },'This field is required.');
        
    $(function(){
        $("#addEmployeeSalary").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                teacher_id:{
                    required:true,
                    dropdownValidation:true
                },
                gross_salary:{
                    required:true
                }
            }
        });
    });