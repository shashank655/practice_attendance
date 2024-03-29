<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
				 <div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Calender</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
								<li class="list-inline-item">Calender</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box m-b-0">
                            <div class="row">
                                <div class="col-md-12">
                                        <div id="event_holidays_calender"></div> 
                                </div>
                            </div>
                        </div>
                        <div class="modal none-border" id="event-modal">
                            <div class="modal-dialog">
                                <div class="modal-content modal-md">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add New Event</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer text-center">
                                        <button type="button" class="btn btn-primary btn-lg save-event">Create event</button>
                                        <button type="button" class="btn btn-danger btn-lg delete-event" data-dismiss="modal">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
				<!-- The Modal -->
		  <div class="modal" id="add_event">
			<div class="modal-dialog">
			  <div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
				  <h3 class="modal-title">Add Event</h3>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
				  <form id="addEvents" action="employee/process/processEvents.php" method="post" novalidate="novalidate">
				  <input type="hidden" name="type" value="insertFormData" />
					<div class="form-group custom-mt-form-group">
						<input type="text" name="title" id="title">
						<label class="control-label">Event Name <span class="text-danger">*</span></label><i class="bar"></i>
					</div>
					<div class="form-group custom-mt-form-group">
						 <input class="form-control floating datetimepicker" type="text" name="start" id="start">
						<label class="control-label">Event Date <span class="text-danger">*</span></label><i class="bar"></i>
					</div>
					<div class="form-group text-center custom-mt-form-group">
						<button class="btn btn-primary btn-lg mr-2" type="submit">Create Event</button>
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
        $("#addEvents").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                title:{
                    required:true
                },                
                start:{
                    required:true
                }
            }
        });
    });
    </script>