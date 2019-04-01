<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
               <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-primary"><i class="fa fa-users" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3>60,000</h3>
                                <span>Students</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-info"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3>12,000</h3>
                                <span>Teachers</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-warning"><i class="fa fa-user-plus" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3>20,000</h3>
                                <span>Parents</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget dash-widget5">
                            <span class="dash-widget-icon bg-success"><i class="fa fa-money" aria-hidden="true"></i></span>
                            <div class="dash-widget-info">
                                <h3>$20,000</h3>
                                <span>Total Earnings</span>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col-lg-6">
						<div class="content-page">
							<div class="page-title">Total Members</div>
							<div id="school-chart"></div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="content-page">
							<div class="page-title">Income Monthwise</div>
							<div id="incomeChart" style="height: 350px;"></div>
						</div>
					</div>
				</div>
				
				<div class="row mt-4">
					<div class="col-lg-6 col-md-12 col-12">
						 <div class="card-box m-b-2">
							<div class="page-title mb-2">
								Events
							</div>
							<div class="card-body p-0">
                              <div id="calendar"></div>
							 </div>
                        </div>
					</div>
					<div class="col-lg-6">
						<div class="content-page">
							<div class="row">
								<div class="col-md-12">
									<div class="page-title mb-2">
										Exam-list
									</div>
									<div class="table-responsive">
										<table class="table table-striped custom-table">
											<thead>
												<tr>
													<th style="min-width:91px;">Exam Name </th>
													<th style="min-width:50px;">Subject</th>
													<th style="min-width:50px;">Class</th>
													<th style="min-width:50px;">Section</th>
													<th style="min-width:50px;">Time</th>
													<th style="min-width:50px;">Date</th>
													<th class="text-right" style="width:30%;">Action</th>
												</tr>
											</thead>
											<tbody>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>English</td>
													<td>5</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right" >
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>English</td>
													<td>4</td>
													<td>A</td>
													<td>10.00am</td>
													<td>2/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												
												<tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Maths</td>
													<td>6</td>
													<td>B</td>
													<td>10.00am</td>
													<td>2/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Science</td>
													<td>3</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Maths</td>
													<td>6</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>English</td>
													<td>7</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												 <tr>
													<td>
														<a href="exam-detail.html" class="avatar">C</a>
													</td>
													<td>Science</td>
													<td>5</td>
													<td>B</td>
													<td>10.00am</td>
													<td>20/1/2019</td>
													<td class="text-right">
														<a href="edit-exam.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-lg-12">
						<div class="content-page">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="page-title mb-2">
										All Students
									</div>
									<div class="table-responsive">
										<table class="table table-striped custom-table">
											<thead>
												<tr>
													<th style="min-width:50px;">Name </th>
													<th style="min-width:74px;">Student ID</th>
													<th style="min-width:50px;">Class</th>
													<th style="min-width:50px;">Section</th>
													<th style="min-width:98px;">Mobile</th>
													<th style="min-width:90px;">Date of Birth</th>
													<th class="text-right">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<h2><a href="profile.html" class="avatar text-white">P</a></h2>
														<h2><a href="profile.html">Parker <span></span></a></h2>
													</td>
													<td>ST-0d001</td>
													<td>1</td>
													<td>A</td>
													<td>973-584-58700</td>
													<td>5th June</td>
													<td class="text-right">
														<a href="edit-student.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<h2><a href="profile.html" class="avatar text-white">S</a></h2>
														<h2><a href="profile.html">Smith <span></span></a></h2>
													</td>
													<td>ST-0d002</td>
													<td>2</td>
													<td>B</td>
													<td>973-584-58700</td>
													<td>6th April</td>
													<td class="text-right">
														<a href="edit-student.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
											   <tr>
													<td>
														<h2><a href="profile.html" class="avatar text-white">H</a></h2>
														<h2><a href="profile.html">Hensley<span></span></a></h2>
													</td>
													<td>ST-0d003</td>
													<td>1</td>
													<td>A</td>
													<td>973-584-58700</td>
													<td>5th Jan</td>
													<td class="text-right">
														<a href="edit-student.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<h2><a href="profile.html" class="avatar text-white">F</a></h2>
														<h2><a href="profile.html">Friesen<span></span></a></h2>
													</td>
													<td>ST-0d004</td>
													<td>1</td>
													<td>A</td>
													<td>973-584-58700</td>
													<td>2nd June</td>
													<td class="text-right">
														<a href="edit-student.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<h2><a href="profile.html" class="avatar text-white">J</a></h2>
														<h2><a href="profile.html">Jackson<span></span></a></h2>
													</td>
													<td>ST-0d005</td>
													<td>1</td>
													<td>A</td>
													<td>973-584-58700</td>
													<td>7th July</td>
													<td class="text-right">
														<a href="edit-student.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<h2><a href="profile.html" class="avatar text-white">M</a></h2>
														<h2><a href="profile.html">Mason<span></span></a></h2>
													</td>
													<td>ST-0d006</td>
													<td>1</td>
													<td>A</td>
													<td>973-584-58700</td>
													<td>5th June</td>
													<td class="text-right">
														<a href="edit-student.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
												<tr>
													<td>
														<h2><a href="profile.html" class="avatar text-white">G</a></h2>
														<h2><a href="profile.html">Garrett <span></span></a></h2>
													</td>
													<td>ST-0d007</td>
													<td>1</td>
													<td>A</td>
													<td>973-584-58700</td>
													<td>5th April</td>
													<td class="text-right">
														<a href="edit-student.html" class="btn btn-primary btn-sm mb-1">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</a>
														<button type="submit" data-toggle="modal" data-target="#delete_employee" class="btn btn-danger btn-sm mb-1">
														<i class="fa fa-trash" aria-hidden="true"></i>
														</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					 </div>       
				</div>
				<div class="notification-box">
					<div class="msg-sidebar notifications msg-noti">
						<div class="topnav-dropdown-header">
							<span>Messages</span>
						</div>
						<div class="drop-scroll msg-list-scroll">
							<ul class="list-box">
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author">Richard Miles </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item new-message">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">Ruth C. Gault</span>
												<span class="message-time">1 Aug</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Tarah Shropshire </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Mike Litorus</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Catherine Manseau </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">D</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Domenic Houston </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">B</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Buster Wigton </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">R</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Rolland Webber </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">C</span>
											</div>
											<div class="list-body">
												<span class="message-author"> Claire Mapes </span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">M</span>
											</div>
											<div class="list-body">
												<span class="message-author">Melita Faucher</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">J</span>
											</div>
											<div class="list-body">
												<span class="message-author">Jeffery Lalor</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">L</span>
											</div>
											<div class="list-body">
												<span class="message-author">Loren Gatlin</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="chat.html">
										<div class="list-item">
											<div class="list-left">
												<span class="avatar">T</span>
											</div>
											<div class="list-body">
												<span class="message-author">Tarah Shropshire</span>
												<span class="message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="chat.html">See all messages</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
require_once 'includes/footer.php';
?>