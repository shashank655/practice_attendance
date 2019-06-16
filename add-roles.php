<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Roles.php';
$roles=new Roles(); 
$roleId = (isset($_REQUEST['roleId'])) ? $_REQUEST['roleId'] : NULL; 
if ($roleId != NULL) { $result = $roles->getRoleInfo($roleId); 
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
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="card-title">Add Role</h4>
                            <form id="addRoles" action="employee/process/processRoles.php" method="post" novalidate="novalidate">
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