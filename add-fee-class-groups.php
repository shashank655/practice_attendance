<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/FeeClassGroup.php';
require_once 'employee/class/Sections.php';
require_once 'employee/class/ClassSections.php';
$classes = new ClassSections;
$fee_class_group = new FeeClassGroup();
$sections = new Sections();
$allClasses = $classes->getClassesLists();
$allSections = $sections->getSectionsLists();
$selectedSections = [];
$feeId = (isset($_REQUEST['feeId'])) ? $_REQUEST['feeId'] : NULL; 
if ($feeId != NULL) { 
$result = $fee_class_group->getFeeClassGroupsInfo($feeId);  
$sections =  $fee_class_group->getSections($feeId);
foreach($sections as $section) {
$selectedSections[] = $section['section_id'];
}
if ($result == NULL) { $feeId = ''; } 
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
<h5 class="text-uppercase">Add Fee Class Group</h5>
</div>
<div class="col-lg-5 col-md-12 col-sm-12 col-12">
<ul class="list-inline breadcrumb float-right">
<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
<li class="list-inline-item"> Add Fee Class Group</li>
</ul>
</div>
</div>
</div>
<form id="addFeeClassGroups" action="employee/process/processFeeClassGroups.php" method="post" novalidate="novalidate">

<div class="row">
<div class="col-lg-12">
<div class="card-box">
<h4 class="card-title">Add Fee Class Group</h4>
<input type="hidden" name="type" value="<?php echo $feeId == '' ? 'Add' : 'Update'; ?>" />
<input type="hidden" name="feeId" value="<?php echo $feeId; ?>" />
<div class="form-group row ">
<label class="col-form-label col-md-2">Group Name</label>
<div class="col-md-10">
<input type="text" name="title" class="form-control" value="<?php
if (isset($result[0]['title']))
    echo htmlspecialchars($result[0]['title']);
?>">
</div>
</div>
<div class="form-group row ">
<label class="col-form-label col-md-2">Classes</label>
<div class="col-md-10">
    <div class="row">
        <?php foreach ($allClasses as $class) { ?>
            <div class="col-md-3 mb-5"> 
                <div class="mb-3">
                <?= $class['class_name']; ?>
                </div> 
                <?php
                foreach ($allSections as $key => $section) {
                    if ( $class['id'] == $section['class_id']) { ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="<?= $section['id'] ?>" name="section_ids[]" <?= in_array($section['id'], $selectedSections) ? 'checked' : ''; ?>> <?= $section['section_name'] ?>
                            </label>  
                        </div>
                    <?php } 
                } ?>
            </div>
        <?php } ?>
    </div>
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
$("#addFeeClassGroups").validate({
ignore: "input[type='text']:hidden",
rules:{
title:{
required:true
},
class_ids: {
required:true
}
}
});
});
</script>