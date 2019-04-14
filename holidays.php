<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Holidays.php';  
$holidays=new Holidays(); 
$resultHolidays=$holidays->getHolidaysList();  
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
							<h5 class="text-uppercase">holidays</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="#">Home</a></li>
								<li class="list-inline-item"> Holidays</li>
							</ul>
						</div>
					</div>
				</div>

			<div class="content-page">
                <div class="row">
                    <div class="col-sm-5 col-5">
                        <h4 class="page-title">Holidays <?php echo date('Y'); ?></h4>
                    </div>
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
                    <div class="col-sm-7 col-7 text-right m-b-30">
                        <a href="#" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add New Holiday</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title </th>
                                        <th>Holiday Date</th>
                                        <th>Day</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php 
                                	$i = 1;
                                	foreach ($resultHolidays as $key => $value) { ?>
                                    <tr class="holiday-upcoming">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['holiday_name']; ?></td>
                                        <td><?php echo $value['holiday_date']; ?></td>
                                        <td>Monday</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="<?php echo $value['id']?>" data-toggle="modal" data-target="#edit_holiday" title="Edit"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="" val="<?php echo $value['id']?>" id="delete_holiday" title="Delete"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
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
        <div id="add_holiday" class="modal" role="dialog">
            <div class="modal-dialog">
				
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Holiday</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="addHolidays" action="employee/process/processHolidays.php" method="post" novalidate="novalidate">
                        	<input type="hidden" name="type" value="Add" />
							<!-- <input type="hidden" name="studentId" value="<?php echo $studentId; ?>" /> -->

                            <div class="form-group custom-mt-form-group">
								<input type="text" name="holiday_name" value="" />
								<label class="control-label">Holiday Name <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="form-group custom-mt-form-group">
								<input class="form-control floating datetimepicker" type="text" name="holiday_date" value="" >
								<label class="control-label">Holiday Date <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Create Holiday</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="edit_holiday" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Holiday</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form>
							<div class="form-group custom-mt-form-group">
								<input type="text" value="New Year"  />
								<label class="control-label">Holiday Name <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                           <div class="form-group custom-mt-form-group">
								<input id="date5" value="01-01-2018" class="form-control floating datetimepicker" type="text" >
								<label for="date5" class="control-label">Holiday Date <span class="text-danger">*</span></label><i class="bar"></i>
							</div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary btn-lg">Edit Holiday</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <script type="text/javascript">
    	$(function(){
        $("#addHolidays").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                holiday_name:{
                    required:true
                },                
                holiday_date:{
                    required:true
                }
            }
        });
    });
	$( "#delete_holiday" ).click(function() {
        var id = $(this).attr('val');
        var r = confirm("Are You Sure Delete this Holiday ?");
            if (r==true){
                $.ajax({
                    type: "POST",
                    url: "employee/process/processHolidays.php",
                    data:{holidayId:id,type:'delete'},
                    beforeSend : function () {
                    },
                    success:function(data){
                    	alert('Deleted Successfully');
                    }
                });
            }else{   
            }
    });
    </script>