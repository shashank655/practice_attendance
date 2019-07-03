<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/FeeTypes.php';
require_once 'employee/class/ClassSections.php';
require_once 'employee/class/Sections.php';
$sections = new Sections();
$classes=new ClassSections(); 
$fee_types=new FeeTypes();
$sectionsList=$sections->getSectionsLists();
$classesList=$classes->getClassesLists();
$feeTypeId = (isset($_REQUEST['feeTypeId'])) ? $_REQUEST['feeTypeId'] : NULL; 
if ($feeTypeId != NULL) { 
    $result = $fee_types->getFeeTypesInfo($feeTypeId);  
    if ($result == NULL) { $feeTypeId = ''; } 
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
                        <h5 class="text-uppercase">Add Fee Type</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Fee Type</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="addFeeTypes" action="employee/process/processFeeTypes.php" method="post" novalidate="novalidate">
                            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Fee Type</h4>
                            <input type="hidden" name="type" value="<?php echo $feeTypeId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="feeTypeId" value="<?php echo $feeTypeId; ?>" />
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Name</label>
                                <div class="col-md-10">
                                    <input type="text" name="name" class="form-control" value="<?php
                                    if (isset($result[0]['name']))
                                        echo htmlspecialchars($result[0]['name']);
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Select Class</label>
                                <div class="col-md-10">
                                    <select name="class_id" class="form-control">
                                        <?php
                                            foreach ($classesList as $class) {
                                        ?>
                                            <option value="<?= $class['id'] ?>" 
                                            <?php
                                                if (isset($result[0]['class_id'])) {
                                                    if ($class['id'] == $result[0]['class_id']) {
                                                        echo 'selected';
                                                    }
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
                                    <select name="section_id" class="form-control">
                                        <?php
                                            foreach ($sectionsList as $section) {
                                        ?>
                                            <option value="<?= $section['id'] ?>"
                                            <?php
                                                if (isset($result[0]['class_id'])) {
                                                    if ($section['id'] == $result[0]['section_id']) {
                                                        echo 'selected';
                                                    }
                                                }
                                            ?>><?= $section['section_name'] ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-form-label col-md-2">Amount</label>
                                <div class="col-md-10">
                                    <input type="text" name="fee" class="form-control" value="<?php
                                    if (isset($result[0]['fee']))
                                        echo htmlspecialchars($result[0]['fee']);
                                    ?>">
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
    <script type="text/javascript">
        $(function(){
            $("#addFeeTypes").validate({
                ignore: "input[type='text']:hidden",
                rules:{
                    name:{
                        required:true
                    }, 
                    fee: {
                        require:true
                    }
                }
            });
        });
    </script>