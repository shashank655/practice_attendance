<?php
require_once '../employee/class/dbclass.php';
require_once '../employee/config/config.php';
require_once 'models/Teacher.php';
require_once '../employee/class/ClassSections.php';
$classSections = new ClassSections();
$resultClassSections = $classSections->getClassesWithSectionsLists();
$teachers = new Teacher();
$userId = (isset($_REQUEST['userId'])) ? $_REQUEST['userId'] : NULL;
$result=$teachers->getTeacherInfo($userId);
$assigned = $teachers->getAssignedClassSection($userId);
$selectedIsClassTeacher = '';
$selectedClassSection = [];
if (is_array($assigned)) {
  foreach ($assigned as $key => $assign) {
    $classIdSectionId = $assign['class_id'].','.$assign['section_id'];
    if ($assign['is_class_teacher'] == '1'){
      $selectedIsClassTeacher = $classIdSectionId;
    }
    array_push($selectedClassSection, $classIdSectionId);
  }
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
                    <h5 class="text-uppercase">Assign Teacher</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="all-teachers.php">Teachers</a></li>
                        <li class="list-inline-item"> Assign Teacher</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="card-title">Teacher</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="<?= $result[0]['first_name'].' '.$result[0]['last_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="<?= $result[0]['email_address']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Type</label>
                                <input type="text" class="form-control" value="<?= $result[0]['designation']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="assignTeacherClass" action="controller/TeacherController.php" method="post" novalidate="novalidate">
            <input type="hidden" name="type" value="Add" />
            <input type="hidden" name="userId" value="<?php echo $userId; ?>" />
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="card-title">Assign Course & Section</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th style="min-width:50px;">S.No.</th>
												<th style="min-width:50px;">Is Class Teacher</th>
				    							<th style="min-width:50px;">Class</th>
				    							<th style="min-width:50px;">Section</th>
												<th style="min-width:50px;">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $i=1; ?>
                                            <?php
                                                foreach ($resultClassSections as $key => $value) {
                                                    foreach ($value['sections'] as $sectionKey => $sectionValue) {
                                                        $classAndSection = $value['id'].','.$sectionValue['id'];
                                            ?>

											<tr>
											    <td><?php echo $i; ?></td>
											    <td>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="is_class_teacher" value="<?= $classAndSection; ?>" <?php if ($classAndSection == $selectedIsClassTeacher) { echo 'checked'; } ?>>
                                                        </label>
                                                    </div>
                                                </td>
												<td><?php echo $value['class_name']; ?></td>
												<td><?php echo $sectionValue[2]; ?></td>
												<td>
													<div class="checkbox">
														<label>
															<input type="checkbox" value="<?= $classAndSection; ?>" name="teaches[]" <?= in_array($classAndSection, $selectedClassSection) ? 'checked' : ''; ?>>
														</label>
													</div>
												</td>
											</tr>
											<?php $i++; }} ?>
										</tbody>
									</table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-lg mr-2" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<?php require_once '../includes/footer.php'; ?>
    <script type="text/javascript">
        $(function(){
            $("#addRoles").validate({
                ignore: "input[type='text']:hidden",
                rules:{
                    role:{
                        required:true
                    }
                }
            });
        });
    </script>
