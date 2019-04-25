<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Admin.php'; 
$admin = new Admin(); 
$userId = $_SESSION['userId'];
$adminInfo = $admin->getAdminInfo($_SESSION['userId']);
?>
<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper">
	<!-- content -->
	<div class="content container-fluid">
		<div class="page-content">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="card">
						<div class="page-title">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="page-title">Admin information</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<?php if (isset($_SESSION[ 'Msg']) && $_SESSION[ 'Msg'] !='' ) { 
								if($_SESSION['success']) {
									$alertClass = 'success';
									$alertValue = 'Success';
								} else {
									$alertClass = 'danger';
									$alertValue = 'Error';
								}
							?>
							<div class="alert alert-<?php echo $alertClass; ?> alert-dismissible fade show" role="alert"> <strong><?php echo $alertValue; ?>!</strong> 
								<?php echo $_SESSION[ 'Msg']; ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span>
								</button>
							</div>
							<script>
								setTimeout(function() {
								                    $(".alert").fadeOut("slow");
								                }, 5000)
							</script>
							<?php $_SESSION[ 'Msg']='' ; unset($_SESSION[ 'Msg']); } ?>
							<form id="addAdminForm" action="employee/process/processUser.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
								<input type="hidden" name="type" value="update_admin_info" />
								<input type="hidden" name="userId" value="<?php echo $userId; ?>" />
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="form-group custom-mt-form-group">
											<input type="text" placeholder="First Name" name="first_name" value="<?php
                                        		if (isset($adminInfo[0]['first_name']))
                                            	echo htmlspecialchars($adminInfo[0]['first_name']);
                                        		?>" />
											<i class="bar"></i>
										</div>
										<div class="form-group custom-mt-form-group">
											<input type="text" placeholder="Last Name" name="last_name" value="<?php
                                        		if (isset($adminInfo[0]['last_name']))
                                            	echo htmlspecialchars($adminInfo[0]['last_name']);
                                        		?>" />
											<i class="bar"></i>
										</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group custom-mt-form-group">
											<input type="file" name="admin_profile_image" id="admin_profile_image" style="margin-bottom:10px;">
											<?php if(!empty($adminInfo[0]['admin_profile_image'])) { ?>
												<input type="hidden" name="profile_image_name" id="profile_image_name" value="<?php if (isset($adminInfo[0]['admin_profile_image'])) echo $adminInfo[0]['admin_profile_image']; ?>"/>
	                                            <span id="profile_image_div">    
	                                            <img src="<?php if (isset($adminInfo[0]['admin_profile_image'])) echo PROFILE_PIC_IMAGE_PATH . $adminInfo[0]['admin_profile_image']; ?>" height="100" width="100"/>
	                                            <span class="del_slider_img">
	                                                <img src="<?php echo BASE_ROOT; ?>assets/img/cancel.png" style="cursor:pointer"/>
	                                            </span>
                                        	<?php } ?>
                                        </span>

											<label class="control-label"></label><i class="bar"></i>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group text-center custom-mt-form-group">
											<button class="btn btn-secondary mr-2" type="submit">Submit</button>
											<button class="btn btn-secondary" type="reset">Cancel</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php require_once 'includes/footer.php'; ?>