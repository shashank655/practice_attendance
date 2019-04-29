
<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> 
<!-- content -->
        <div class="content container-fluid">
        <div class="page-header">
                    <div class="row">
                        <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                            <h5 class="text-uppercase">Students Attendance</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <!-- <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Exams List</li>
                            </ul> -->
                        </div>
                    </div>
                </div>
			<div class="row mt-2">
                    <div class="col-lg-12">
                        <div class="content-page">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <!-- <div class="page-title mb-2">
                                     Students Attendance
                                    </div> -->
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table">
                                            <thead>
                                                <tr>
                                                    <th style="min-width:50px;">First Name </th>
                                                    <th style="min-width:74px;">Last Name</th>
                                                    <th style="min-width:50px;">Present</th>
                                                    <th style="min-width:50px;">Absent</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h2><a href="profile.html" class="avatar text-white">P</a></h2>
                                                        <h2><a href="profile.html">Parker <span></span></a></h2>
                                                    </td>
                                                    <td>Last Name</td>
                                                    <td>
                                                        <label class="custom_checkbox">
                                                          <input type="checkbox" checked="checked">
                                                          <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="custom_checkbox red">
                                                          <input type="checkbox">
                                                          <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td>&nbsp;</td>                
                                                </tr>
                                                 <tr>
                                                    <td>
                                                        <h2><a href="profile.html" class="avatar text-white">P</a></h2>
                                                        <h2><a href="profile.html">Peter <span></span></a></h2>
                                                    </td>
                                                    <td>Last Name</td>
                                                    <td>
                                                        <label class="custom_checkbox">
                                                          <input type="checkbox">
                                                          <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="custom_checkbox red">
                                                          <input type="checkbox" checked="checked">
                                                          <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td>&nbsp;</td>                
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>       
                </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>