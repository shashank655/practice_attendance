<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/config/months.php'; 
require_once 'employee/class/ClassSections.php';
require_once 'employee/class/Sections.php';
require_once 'employee/class/Student.php';
require_once 'employee/class/FeeGroups.php';
require_once 'employee/class/CollectFees.php';
$collect_fees = new CollectFees;
$classes=new ClassSections();
$allClasses = $classes->getClassesLists();
$sections=new Sections();
$allSections = $sections->getSectionsLists();
$student=new Student();
$allStudents = $student->getStudentsLists();
$feeGroups=new FeeGroups();
$allFeeGroups = $feeGroups->getFeeGroupsLists();
if (isset($_GET['feeCollectId'])) {
    $resultCollectFee = $collect_fees->getCollectFeeInfo($_GET['feeCollectId']);
    $resultSections = $sections->getSectionsByClass($resultCollectFee[0]['class_id']);
    $resultStudents = $student->getStudentsBySection($resultCollectFee[0]['section_id']);
    $resultFeeGroups = $feeGroups->getFeeGroupsBySection($resultCollectFee[0]['section_id']);
} else {
    $resultCollectFee = [];
    $resultSections = [];
    $resultStudents = [];
}
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
                        <h5 class="text-uppercase">Collect Fee Step 1</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Collect Fee Step 1</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="addCollectFee1" action="collect-fee2.php" method="get" novalidate="novalidate">
                <input type="hidden" name="feeCollectId" value="<?php if (isset($_GET['feeCollectId'])) echo $_GET['feeCollectId']; ?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Collect Fee Step 1</h4>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Select Fee Group</label>
                                <div class="col-md-10">
                                    <select name="fee_group_id" class="form-control" id="fee_group_id">
                                        <option value="">Select Fee Group</option>
                                        <?php 
                                            foreach ($allFeeGroups as $fee_group) {
                                        ?>
                                        <option value="<?= $fee_group['id'] ?>"
                                        <?php 
                                            if (count($resultCollectFee) > 0)
                                            {
                                                if($resultCollectFee[0]['fee_group_id'] == $fee_group['id']) echo 'selected';
                                            }
                                        ?>><?= $fee_group['title'] ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Select Student</label>
                                <div class="col-md-10">
                                    <select name="student_id" class="form-control" id="student_id">
                                        <?php
                                            if (count($resultStudents) > 0) {
                                                foreach ($resultStudents as $_student) {
                                        ?>
                                        <option value="<?= $_student['id'] ?>"
                                        <?php
                                            if($resultCollectFee[0]['student_id'] == $_student['id']) echo 'selected';
                                        ?>
                                        ><?= $_student['first_name'].' '.$_student['last_name'] ?></option>
                                        <?php
                                                }
                                            }
                                        ?>  
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Select Payment Duration</label>
                                <div class="col-md-10">
                                    <select name="fee_paying_mode" class="form-control" id="fee_paying_mode">
                                        <option value="Monthly" 
                                        <?php 
                                            if (count($resultCollectFee) > 0) {
                                                if($resultCollectFee[0]['fee_paying_mode'] == 'Monthly') echo 'selected';
                                            }
                                        ?>>Monthly</option>
                                        <option value="Quarterly" 
                                        <?php 
                                            if (count($resultCollectFee) > 0) {
                                                if($resultCollectFee[0]['fee_paying_mode'] == 'Quarterly') echo 'selected';
                                            }
                                        ?>>Quarterly</option>
                                        <option value="Half Yearly" 
                                        <?php 
                                            if (count($resultCollectFee) > 0) {
                                                if($resultCollectFee[0]['fee_paying_mode'] == 'Half Yearly') echo 'selected';
                                            }
                                        ?>>Half Yearly</option>
                                        <option value="Yearly" 
                                        <?php 
                                            if (count($resultCollectFee) > 0) {
                                                if($resultCollectFee[0]['fee_paying_mode'] == 'Yearly') echo 'selected';
                                            }
                                        ?>>Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group text-center custom-mt-form-group">
									<button class="btn btn-secondary mr-2" type="submit">Submit</button>
									<button class="btn btn-secondary" type="reset">Cancel</button>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <?php require_once 'includes/footer.php'; ?>
    <script>
        
        $(document).on("change", "#fee_group_id", function () {
            var fee_group_id = $(this).val();
            var option = '<option value="">Select Student</option>';
            $("#student_id").html('');
            $("#student_id").append(option);
            $.get('employee/process/accounts-ajax.php', { action: 'students', fee_group_id: fee_group_id }, function(res) {
                $.each(res, function(index, student) {
                    option = '<option value="'+student.id+'">'+student.first_name+' '+student.last_name+'</option>';
                    $("#student_id").append(option);
                });
            });
        });

    </script>