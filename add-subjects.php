<?php 
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php'; 
require_once 'employee/class/Subjects.php';
$subjects = new Subjects();

$subjectId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
if ($subjectId != NULL) { $result = $subjects->getSubjectInfo($subjectId); 
	if ($result == NULL) { $subjectId = ''; } }
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
						<h5 class="text-uppercase">Subjects</h5>
					</div>
					<div class="col-lg-5 col-md-12 col-sm-12 col-12">
						<ul class="list-inline breadcrumb float-right">
							<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Subject</li>
						</ul>
					</div>
				</div>
			</div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Subjects</h4>
                            <form id="addSubjects" action="employee/process/processSubjects.php" method="post" novalidate="novalidate">
                            <input type="hidden" name="type" value="<?php echo $subjectId == '' ? 'Add' : 'Update'; ?>" />
							<input type="hidden" name="subjectId" value="<?php echo $subjectId; ?>" />
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Subject Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="subject_name" class="form-control" value="<?php
                                        		if (isset($result[0]['subject_name']))
                                            	echo htmlspecialchars($result[0]['subject_name']);
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
    $(function(){
        $("#addSubjects").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                subject_name:{
                    required:true
                }
            }
        });
    });
    </script>