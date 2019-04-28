<?php $currentURL = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>
<div class="sidebar" id="sidebar"> <!-- sidebar -->
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>
                    	<li class="<?php if($currentURL =='dashboard.php'){echo 'active';}?>">
                            <a href="dashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
                        </li>
                        <?php if($_SESSION['user_role'] == '1' ) { ?>
						<li class="submenu">
                            <a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span> Teachers</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='all-teachers.php'){echo 'active';}?>" href="all-teachers.php">All Teachers</a></li>
                                <li><a class="<?php if($currentURL =='add-teacher.php'){echo 'active';}?>" href="add-teacher.php">Add Teacher</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span> Students</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='all-students.php'){echo 'active';}?>" href="all-students.php">All Students</a></li>
                                <li><a class="<?php if($currentURL =='add-student.php'){echo 'active';}?>" class="" href="add-student.php">Add Student</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-table" aria-hidden="true"></i> <span> Classes & Sections</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='class-section-list.php'){echo 'active';}?>" href="class-section-list.php">Classes List</a></li>
                                <li><a class="<?php if($currentURL =='class-section.php'){echo 'active';}?>" class="" href="class-section.php">Add Classes</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="fa fa-table" aria-hidden="true"></i> <span> Subjects</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='subject-lists.php'){echo 'active';}?>" href="subject-lists.php">Subjects List</a></li>
                                <li><a class="<?php if($currentURL =='add-subjects.php'){echo 'active';}?>" class="" href="add-subjects.php">Add Subjects</a></li>
                            </ul>
                        </li>

                        <li class="<?php if($currentURL =='holidays.php'){echo 'active';}?>">
                            <a href="holidays.php"><i class="fa fa-tasks" aria-hidden="true"></i> Holidays</a>
                        </li>
                        <li class="<?php if($currentURL =='events.php'){echo 'active';}?>">
                            <a href="events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Events</a>
                        </li>
                        <li class="<?php if($currentURL =='leaves-types.php'){echo 'active';}?>">
                            <a href="leaves-types.php"><i class="fa fa-table" aria-hidden="true"></i>Add Leaves Types</a>
                        </li>
                        <li class="<?php if($currentURL =='request-leave-list.php' || $currentURL =='add-leaves-type.php'){echo 'active';}?>">
                            <a href="request-leave-list.php"><i class="fa fa-table" aria-hidden="true"></i>Request Leave List</a>
                        </li>
                        <li class="<?php if($currentURL =='exams-list.php' || $currentURL =='add-exams.php'){echo 'active';}?>">
                            <a href="exams-list.php"><i class="fa fa-table" aria-hidden="true"></i>Exams List</a>
                        </li>
						<!-- <li class="submenu">
                            <a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span> Students</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a href="all-students.html">All Students</a></li>
                                <li><a href="add-student.html">Add Student</a></li>
                                <li><a href="edit-student.html">Edit Student</a></li>
								<li><a href="about-student.html">About Student</a></li>
                            </ul>
                        </li>
						<li class="submenu">
                            <a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span> Parents</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a href="all-parents.html">All Parents</a></li>
                                <li><a href="add-parent.html">Add Parent</a></li>
                                <li><a href="edit-parent.html">Edit Parent</a></li>
								<li><a href="about-parent.html">About Parent</a></li>
                            </ul>
                        </li>
						<li class="submenu">
                            <a href="javascript:void(0);"><i class="fa fa-share-alt" aria-hidden="true"></i> <span>Apps</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li class="submenu">
                                    <a href="javascript:void(0);"><span>Email</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="compose.html"><span>Compose Mail</span></a></li>
                                        <li>
                                            <a href="inbox.html"> <span> Inbox</span> </a>
										</li>
                                        <li><a href="mail-view.html"><span>Mailview</span></a></li>
                                    </ul>
                                </li>
                                <li>
									<a href="chat.html"> Chat <span class="badge badge-pill bg-primary float-right">5</span></a>
								</li>
								 <li class="submenu">
									<a href="#"><span> Calls</span> <span class="menu-arrow"></span></a>
									<ul class="list-unstyled" style="display: none;">
										<li><a href="voice-call.html">Voice Call</a></li>
										<li><a href="video-call.html">Video Call</a></li>
										<li><a href="incoming-call.html">Incoming Call</a></li>
									</ul>
								</li>
								 <li>
									<a href="contacts.html"> Contacts</a>
								</li>
                            </ul>
                        </li>
                        <li>
                            <a href="calendar.html" style="width: 80%; display: inline-block;"><i class="fa fa-calendar" aria-hidden="true"></i> Calendar</a>
                        </li>
						<li>
                            <a href="exam-list.html"><i class="fa fa-table" aria-hidden="true"></i> Exam list</a>
                        </li>
                        <li>
                            <a href="holidays.html"><i class="fa fa-tasks" aria-hidden="true"></i> Holidays</a>
                        </li>
						<li>
                            <a href="calendar.html"><i class="fa fa-table" aria-hidden="true"></i> Events</a>
                        </li>
						<li class="submenu">
							<a href="#"><i class="fa fa-book" aria-hidden="true"></i><span> Accounts </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled" style="display: none;">
								<li><a href="invoices.html">Invoices</a></li>
								<li><a href="payments.html">Payments</a></li>
								<li><a href="expenses.html">Expenses</a></li>
								<li><a href="provident-fund.html">Provident Fund</a></li>
								<li><a href="taxes.html">Taxes</a></li>
							</ul>
						</li>
						 <li class="submenu">
							<a href="#"><i class="fa fa-money" aria-hidden="true"></i><span> Payroll </span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled" style="display: none;">
								<li><a href="salary.html"> Employee Salary </a></li>
								<li><a href="salary-view.html"> Payslip </a></li>
							</ul>
						</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-details.html">Blog View</a></li>
                                <li><a href="add-blog.html">Add Blog</a></li>
                                <li><a href="edit-blog.html">Edit Blog</a></li>
                            </ul>
                        </li>
						 <li class="submenu">
                            <a href="javascript:void(0);" class="noti-dot"><i class="fa fa-rocket" aria-hidden="true"></i> <span>Management </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li class="submenu">
                                    <a href="#" class="noti-dot"><span> Employees</span> <span class="menu-arrow"></span></a>
                                    <ul class="list-unstyled" style="display: none;">
										<li><a href="all-employees.html">All Employees</a></li>
                                        <li><a href="holidays.html">Holidays</a></li>
                                        <li><a href="leaves.html"><span>Leave Requests</span> <span class="badge badge-pill bg-primary float-right">1</span></a></li>
                                        <li><a href="attendance.html">Attendance</a></li>
                                        <li><a href="departments.html">Departments</a></li>
                                        <li><a href="designations.html">Designations</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="activities.html">Activities</a>
                                </li>
                                <li>
                                    <a  href="users.html">Users</a>
                                </li>
                                <li class="submenu">
                                    <a href="#"><span> Reports </span> <span class="menu-arrow"></span></a>
                                    <ul class="list-unstyled" style="display: none;">
                                        <li><a href="expense-reports.html"> Expense Report </a></li>
                                        <li><a href="invoice-reports.html"> Invoice Report </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="settings.html"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                        </li>
                        <li class="menu-title">UI Elements</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-laptop" aria-hidden="true"></i> <span> Components</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a href="uikit.html">UI Kit</a></li>
                                <li><a href="typography.html">Typography</a></li>
                                <li><a href="tabs.html">Tabs</a></li>
                            </ul>
                        </li>
                         <li class="submenu">
                            <a href="#"><i class="fa fa-edit" aria-hidden="true"></i> <span> Forms</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a href="basic-inputs.html">Basic Input</a></li>
                                <li><a href="form-basic-inputs.html">Basic Inputs</a></li>
                                <li><a href="form-input-groups.html">Input Groups</a></li>
                                <li><a href="form-horizontal.html">Horizontal Form</a></li>
                                <li><a href="form-vertical.html">Vertical Form</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-table" aria-hidden="true"></i> <span> Tables</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a href="tables-basic.html">Basic Tables</a></li>
                                <li><a href="tables-datatables.html">Data Table</a></li>
                            </ul>
                        </li>
                        <li class="menu-title">Extras</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-columns" aria-hidden="true"></i> <span>Pages</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a href="login.html"> Login </a></li>
                                <li><a href="register.html"> Register </a></li>
                                <li><a href="forgot-password.html"> Forgot Password </a></li>
                                <li><a href="change-password2.html"> Change Password </a></li>
                                <li><a href="lock-screen.html"> Lock Screen </a></li>
                                <li><a href="profile.html"> Profile </a></li>
                                <li><a href="gallery.html"> Gallery </a></li>
                                <li><a href="error-404.html">404 Error </a></li>
                                <li><a href="error-500.html">500 Error </a></li>
                                <li><a href="blank-page.html"> Blank Page </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="fa fa-share-alt" aria-hidden="true"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li class="submenu">
                                    <a href="javascript:void(0);"><span>Level 1</span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                        <li class="submenu">
                                            <a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
                                            <ul class="list-unstyled" style="display: none;">
                                                <li><a href="javascript:void(0);">Level 3</a></li>
                                                <li><a href="javascript:void(0);">Level 3</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"><span>Level 1</span></a>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>