<?php
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php';
require_once 'employee/class/Users.php';
require_once 'employee/class/Roles.php';
require_once 'employee/class/Permissions.php';
require_once 'employee/class/UserRole.php';
require_once 'employee/class/UserPermission.php';
$userPermission = new UserPermission();
$userRole = new UserRole();
$permissions=new Permissions();
$resultPermissionList=$permissions->getPermissionsLists();
$roles=new Roles();
$resultRoleList=$roles->getRolesLists();
$users=new Users();
$userId = (isset($_REQUEST['userId'])) ? $_REQUEST['userId'] : NULL;
if ($userId != NULL) {
    $result = $users->getUserInfo($userId);
    $resultUserRoles = $userRole->getUserRoleInfo($userId);
    $resultUserPermission = $userPermission->getUserPermissionInfo($userId);
    if ($result == NULL) {
        $userId = '';
    }
}
$selectedRoles = [];
foreach ($resultUserRoles as $userRoles) {
    array_push($selectedRoles, $userRoles['role_id']);
}
$selectedPermissions = [];
foreach ($resultUserPermission as $userPermissions) {
    array_push($selectedPermissions, $userPermissions['permission_id']);
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
                        <h5 class="text-uppercase">Edit User</h5>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline breadcrumb float-right">
                            <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                            <li class="list-inline-item"> Edit User</li>
                        </ul>
                    </div>
                </div>
            </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Edit User</h4>
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
                <form id="editUsers" action="employee/process/processUsers.php" method="post" novalidate="novalidate">
                    <input type="hidden" name="type" value="Update" />
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>" />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="card-title">Roles</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th style="min-width:50px;">S.No.</th>
						    							<th style="min-width:50px;">Role</th>
														<th style="min-width:50px;">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php $i=1; ?>
													<?php foreach ($resultRoleList as $key => $value) { ?>
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo $value['role']; ?></td>
														<td>
															<div class="checkbox">
																<label>
																	<input type="checkbox" value="<?= $value['id']; ?>" name="roles[]" <?= in_array($value['id'], $selectedRoles) ? 'checked' : ''; ?>>
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
