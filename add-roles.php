<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Roles.php';
require_once 'employee/class/Permissions.php';
require_once 'employee/class/RolePermission.php';
$rolePermission = new RolePermission();
$roles=new Roles(); 
$permissions=new Permissions();
$resultPermissionList=$permissions->getPermissionsLists();
$selectedPermissions = [];
$roleId = (isset($_REQUEST['roleId'])) ? $_REQUEST['roleId'] : NULL; 
if ($roleId != NULL) { 
    $result = $roles->getRoleInfo($roleId); 
    $resultRolePermission = $rolePermission->getRolePermissionInfo($roleId);    
    foreach ($resultRolePermission as $rolePermissions) {
        array_push($selectedPermissions, $rolePermissions['permission_id']);
    }
    if ($result == NULL) { $roleId = ''; } } 
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
                        <h5 class="text-uppercase">Add Role</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Add Role</li>
                        </ul>
                    </div>
                </div>
            </div>
            <form id="addRoles" action="employee/process/processRoles.php" method="post" novalidate="novalidate">
                            
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Role</h4>
                            <input type="hidden" name="type" value="<?php echo $roleId == '' ? 'Add' : 'Update'; ?>" />
                            <input type="hidden" name="roleId" value="<?php echo $roleId; ?>" />
                                <div class="form-group row ">
                                    <label class="col-form-label col-md-2">Role Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="role" class="form-control" value="<?php
                                                if (isset($result[0]['role']))
                                                echo htmlspecialchars($result[0]['role']);
                                                ?>">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="card-title">Permissions</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th style="min-width:50px;">S.No.</th>
														<th style="min-width:50px;">Permission</th>
														<th style="min-width:50px;">Description</th>
														<th style="min-width:50px;">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													<?php foreach ($resultPermissionList as $key => $value) { ?>
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo $value['permission']; ?></td>
														<td><?php echo $value['description']; ?></td>
														<td>
															<div class="checkbox">
																<label>
																	<input type="checkbox" value="<?= $value['id']; ?>" name="permissions[]" <?= in_array($value['id'], $selectedPermissions) ? 'checked' : ''; ?>>
																</label>
															</div>
														</td>
													</tr>
													<?php $i++; } ?>
												</tbody>
											</table>
										</div>
                                    </div>
                                </div>
                                <div class="form-group text-center custom-mt-form-group">
                                    <button class="btn btn-primary btn-lg mr-2" type="submit">Update</button>
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