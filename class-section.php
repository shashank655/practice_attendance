<?php 
require_once 'employee/config/config.php';
require_once 'employee/class/dbclass.php';
require_once 'employee/class/ClassSections.php';
$classes = new ClassSections(); 
$classId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
if ($classId != NULL) { $result = $classes->getClassInfo($classId); 
    if ($result == NULL) { $classId = ''; } }
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			<div class="page-header">
				<div class="row">
					<div class="col-lg-7 col-md-12 col-sm-12 col-12">
						<h5 class="text-uppercase">Classes & Sections</h5>
					</div>
					<div class="col-lg-5 col-md-12 col-sm-12 col-12">
						<ul class="list-inline breadcrumb float-right">
							<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Classes</li>
						</ul>
					</div>
				</div>
			</div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Classes & Sections</h4>
                            <form id="addClassesSections" action="employee/process/processClassSections.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $classId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="classId" value="<?php echo $classId; ?>" />
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Class Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="className" class="form-control" value="<?php
                                                if (isset($result[0]['class_name']))
                                                echo htmlspecialchars($result[0]['class_name']);
                                                ?>">
                                    </div>
                                </div>
                                <?php if(!empty($result)) { ?>
                                <?php foreach ($result as $key => $value) { ?>
                                    <div id="" class="form-group row">    
                                        <label class="col-form-label col-md-2">Sections Name</label>
                                            <div class="col-md-10">
                                                <input type="text" name="addSection[]" class="form-control" value="<?php
                                                        if (isset($value['section_name']))
                                                        echo htmlspecialchars($value['section_name']);
                                                        ?>">
                                            </div>
                                    </div>           
                                    <?php } } ?>
                                <div id="main-sections-div">
	                                
                                </div>
                            <div class="control-group other-pick-address">
                                <label class="control-label">&nbsp;</label>
                            <div class="controls addAnotherStop">
                                <a href="javascript:addAnother();" >Add Sections</a>
                            </div>
                            </div>
                            <div class="form-group text-center custom-mt-form-group">
								<button class="btn btn-primary btn-lg mr-2" type="submit">Create</button>
							</div>    
                            </form>

                            <div id="clone-sections-div" style="display: none;" class="form-group row add_sections">
                                <label class="col-form-label col-md-2">Sections Name</label>
                                <div class="col-md-10">
                                    <input type="text" name="addSection[]" class="addSection form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <script type="text/javascript">
    var sectionLength = $('.add_sections').length;
    var k = (sectionLength > 0) ? sectionLength + 1 : 1;

    	function addAnother() {
                var aboutAddrow = $("#clone-sections-div").clone().removeAttr('style');
                aboutAddrow.attr("id", "sections_list" + k);
                
                var textboxname = aboutAddrow.find('.addSection').attr('name', 'addSection[]');    
                textboxname.attr('id', 'addSection' + k);

                console.log(aboutAddrow);
                $("#main-sections-div").append(aboutAddrow);

                k = k + 1;
        }
    </script>