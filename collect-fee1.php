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
                                <label class="col-form-label col-md-2">Select Class</label>
                                <div class="col-md-10">
                                    <select name="class_id" class="form-control" id="class_id">
                                        <option value="">Select Class</option>
                                        <?php 
                                            foreach ($allClasses as $class) {
                                        ?>
                                        <option value="<?= $class['id'] ?>"
                                        <?php 
                                            if (count($resultCollectFee) > 0)
                                            {
                                                if($resultCollectFee[0]['class_id'] == $class['id']) echo 'selected';
                                            }
                                        ?>><?= $class['class_name'] ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Select Section</label>
                                <div class="col-md-10">
                                    <select name="section_id" class="form-control" id="section_id">
                                        <?php
                                            if (count($resultSections) > 0) {
                                                foreach ($resultSections as $_section) {
                                        ?>
                                        <option value="<?= $_section['id'] ?>"
                                        <?php
                                            if($resultCollectFee[0]['section_id'] == $_section['id']) echo 'selected';
                                        ?>
                                        ><?= $_section['section_name'] ?></option>
                                        <?php
                                                }
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
                                <label class="col-form-label col-md-2">Select Fee Group</label>
                                <div class="col-md-10">
                                    <select name="fee_group_id" class="form-control" id="fee_group_id">
                                        <?php
                                            if (count($resultFeeGroups) > 0) {
                                                foreach ($resultFeeGroups as $_feeGroup) {
                                        ?>
                                        <option value="<?= $_feeGroup['id'] ?>"
                                        <?php
                                            if($resultCollectFee[0]['fee_group_id'] == $_feeGroup['id']) echo 'selected';
                                        ?>
                                        ><?= $_feeGroup['title'] ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Select Month</label>
                                <div class="col-md-10">
                                    <select name="month_id" class="form-control" id="month_id">
                                        <?php
                                            foreach ($months as $key => $month) {
                                        ?>
                                        <option value="<?= $key ?>"
                                        <?php 
                                            if (count($resultCollectFee) > 0)
                                            {
                                                if($resultCollectFee[0]['month_id'] == $key) echo 'selected';
                                            }
                                        ?>><?= $month ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Select Fee Paying Mode</label>
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
        
        $(document).on("change", "#class_id", function () {
            var class_id = $(this).val();
            var option = '<option value="">Select Section</option>';
            $("#section_id").html('');
            $("#section_id").append(option);
            $.get('employee/process/accounts-ajax.php', { action: 'sections', class_id: class_id }, function(res) {
                $.each(res, function(index, section) {
                    option = '<option value="'+section.id+'">'+section.section_name+'</option>';
                    $("#section_id").append(option);
                });
            });
        });

        $(document).on("change", "#section_id", function () {
            var class_id = $("#class_id").val();
            var section_id = $(this).val();
            var option = '';
            $("#student_id").html('');
            $.get('employee/process/accounts-ajax.php', { action: 'students-with-fee-groups', class_id: class_id, section_id: section_id }, function(res) {
                $.each(res.students, function(index, student) {
                    option = '<option value="'+student.id+'">'+student.first_name+' '+student.last_name+'</option>';
                    $("#student_id").append(option);
                });
                $.each(res.fee_groups, function(index, fee_group) {
                    option = '<option value="'+fee_group.id+'">'+fee_group.title+'</option>';
                    $("#fee_group_id").append(option);
                });
            });
        });

    </script>