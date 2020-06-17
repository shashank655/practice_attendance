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
                            <a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span> Teachers Listing</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='all-teachers.php'){echo 'active';}?>" href="all-teachers.php">All Teachers</a></li>
                                <li><a class="<?php if($currentURL =='add-teacher.php'){echo 'active';}?>" href="add-teacher.php">Add Teacher</a></li>
                                <li><a class="<?php if($currentURL =='deleted-teachers.php'){echo 'active';}?>" href="deleted-teachers.php">Deleted Teachers</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span> Students Listing</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='add-student.php'){echo 'active';}?>" class="" href="add-student.php">Add Student</a></li>
                                <li><a class="<?php if($currentURL =='upload-student-csv.php'){echo 'active';}?>" class="" href="upload-student-csv.php">Upload Student Data</a></li>
                                <li><a class="<?php if($currentURL =='all-students.php'){echo 'active';}?>" href="all-students.php">All Students</a></li>
                                <li><a class="<?php if($currentURL =='deleted-student.php'){echo 'active';}?>" href="deleted-student.php">Deleted Students</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span> Exam Management</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='exam-types-lists.php'){echo 'active';}?>" class="" href="exam-types-lists.php">Add Exam Type</a></li>
                                <li><a class="<?php if($currentURL =='manage-exam-terms-lists.php'){echo 'active';}?>" class="" href="manage-exam-terms-lists.php">Manage Exam Term</a></li>
                                <li><a class="<?php if($currentURL =='exams-list.php'){echo 'active';}?>" href="exams-list.php">Manage Exam List</a></li>
                                <li><a class="<?php if($currentURL =='session-terms-list.php'){echo 'active';}?>" href="session-terms-list.php">Add Term</a></li>
                                <li><a class="<?php if($currentURL =='edit-session-terms.php'){echo 'active';}?>" href="edit-session-terms.php">Edit Term</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-building" aria-hidden="true"></i> <span> Classes & Sections</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='class-section-list.php'){echo 'active';}?>" href="class-section-list.php">Classes List</a></li>
                                <li><a class="<?php if($currentURL =='class-section.php'){echo 'active';}?>" class="" href="class-section.php">Add Classes</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-book" aria-hidden="true"></i> <span> Subjects</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='subject-lists.php'){echo 'active';}?>" href="subject-lists.php">Subjects List</a></li>
                                <li><a class="<?php if($currentURL =='add-subjects.php'){echo 'active';}?>" class="" href="add-subjects.php">Add Subjects</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-table" aria-hidden="true"></i> <span> HR</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='admission-form-listing.php'){echo 'active';}?>" href="admission-form-listing.php">Admission Form</a></li>
                                <li><a class="<?php if($currentURL =='transfer-certificate-listing.php'){echo 'active';}?>" class="" href="transfer-certificate-listing.php">TC Form</a></li>
                                <li><a class="<?php if($currentURL =='cancel-admission-form-listing.php'){echo 'active';}?>" class="" href="cancel-admission-form-listing.php">Canceled Adm. forms</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-money" aria-hidden="true"></i> <span> Accounts</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='fee-head.php'){echo 'active';}?>" href="fee-head.php">Fees Head</a></li>
                                <li><a class="<?php if($currentURL =='fees-transportation.php'){echo 'active';}?>" class="" href="fees-transportation.php">Transportation</a></li>
                                <li><a class="<?php if($currentURL =='collect-fee.php'){echo 'active';}?>" class="" href="collect-fee.php">Collect Fees</a></li>
                                <li><a class="<?php if($currentURL =='admission-fee.php'){echo 'active';}?>" class="" href="admission-fee.php">Admission Fee List</a></li>
                                <li><a class="<?php if($currentURL =='monthly-fee.php'){echo 'active';}?>" class="" href="monthly-fee.php">Monthly Fee List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-money" aria-hidden="true"></i> <span> Expenses</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='expense-types-list.php'){echo 'active';}?>" href="expense-types-list.php">Expense Types</a></li>
                                <li><a class="<?php if($currentURL =='expenses-list.php'){echo 'active';}?>" class="" href="expenses-list.php">Expenses List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-bullhorn" aria-hidden="true"></i> <span> Leave Management</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='leaves-types.php'){echo 'active';}?>" href="leaves-types.php">Add Leaves Types</a></li>
                                <li><a class="<?php if($currentURL =='leave-requests-list.php'){echo 'active';}?>" class="" href="leave-requests-list.php">Leave Requests List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-shield" aria-hidden="true"></i> <span> Roles & Permission</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='roles-list.php'){echo 'active';}?>" href="roles-list.php">Roles</a></li>
                                <li><a class="<?php if($currentURL =='permissions-list.php'){echo 'active';}?>" class="" href="permissions-list.php">Permission</a></li>
                                <li><a class="<?php if($currentURL =='users-list.php'){echo 'active';}?>" class="" href="users-list.php">Users</a></li>
                                <li><a class="<?php if($currentURL =='teachers.php'){echo 'active';}?>" class="" href="teachers.php">Teachers</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if($_SESSION['user_role'] == '2' ) { ?>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span> Examination</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='students-exam-list.php.php'){echo 'active';}?>" class="" href="students-exam-list.php">Add Student Marks</a></li>
                            </ul>
                        </li>
                        <li class="<?php if($currentURL =='all-students.php'){echo 'active';}?>">
                           <a href="all-students.php">
                           <i class="fa fa-users" aria-hidden="true"></i>
                           <span>All Student List</span>
                           </a>
                        </li>
                        <li class="<?php if($currentURL =='request-leave-list.php'){echo 'active';}?>">
                           <a href="request-leave-list.php">
                           <i class="fa fa-address-card-o" aria-hidden="true"></i>
                           <span>Request Leave List</span>
                           </a>
                        </li>
                        <li class="<?php if($currentURL =='student-attendance-list.php'){echo 'active';}?>">
                           <a href="student-attendance-list.php">
                           <i class="fa fa-users" aria-hidden="true"></i>
                           <span>Student Attendance</span>
                           </a>
                        </li>
                        <li class="<?php if($currentURL =='teacher-attendance-list.php'){echo 'active';}?>">
                           <a href="teacher-attendance-list.php">
                           <i class="fa fa-address-card-o" aria-hidden="true"></i>
                           <span>My Attendance</span>
                           </a>
                        </li>
                        <li class="<?php if($currentURL =='teacher-login-records-list.php'){echo 'active';}?>">
                           <a href="teacher-login-records-list.php">
                           <i class="fa fa-files-o" aria-hidden="true"></i>
                           <span>My Login Record</span>
                           </a>
                        </li>
                        <li class="<?php if($currentURL =='contacts.php'){echo 'active';}?>">
                           <a href="contacts.php">
                           <i class="fa fa-address-book" aria-hidden="true"></i>
                           <span>Contacts</span>
                           </a>
                        </li>
                        <?php } ?>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i> <span> Holidays / Events</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li><a class="<?php if($currentURL =='calender.php'){echo 'active';}?>" href="calender.php">Calender</a></li>
                                <li><a class="<?php if($currentURL =='holidays.php'){echo 'active';}?>" class="" href="holidays.php">Holidays</a></li>
                                <li><a class="<?php if($currentURL =='events.php'){echo 'active';}?>" class="" href="events.php">Events</a></li>
                            </ul>
                        </li>
                        <li class="<?php if($currentURL =='gallery.php'){echo 'active';}?>">
                        <a href="gallery.php">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            <span>Gallery</span>
                        </a></li>
                                            
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>