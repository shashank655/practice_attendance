<?php
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php';
require_once 'employee/class/Users.php';
$users=new Users();
$resultUserList=$users->getUsersLists();
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
							<h5 class="text-uppercase">Users</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Users List</li>
							</ul>
						</div>
					</div>
				</div>
			<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Name</th>
                                        <th style="min-width:50px;">Email</th>
                                        <th style="min-width:50px;">Type</th>
                                        <th style="min-width:50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                	<?php foreach ($resultUserList as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                        <td><?php echo $value['email_address']; ?></td>
                                        <td><?php echo $value['designation']; ?></td>
                                        <td class="text-right" >
											<a href="edit-users.php?userId=<?php echo $value[0]; ?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
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
        <?php require_once 'includes/footer.php'; ?>
