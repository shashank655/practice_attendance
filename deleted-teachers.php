<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Teacher.php'; 
$teacher = new Teacher();
$resultAllTeachers=$teacher->getAllDeletedTeachers();
?>

<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
            <div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table" id="student-listing">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Full Name</th>
                                        <th style="min-width:50px;">Email Address</th>
                                        <th style="min-width:50px;">Gender</th>
                                        <th style="min-width:50px;">Mobile Number </th>
                                        <th style="min-width:50px;">Address</th>
                                        <th style="min-width:50px;">DOB</th>
                                        <th style="min-width:50px;">Joining Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php foreach ($resultAllTeachers as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo  $value['first_name'].' '.$value['last_name']; ?></td>
                                        <td><?php echo $value['email_address']; ?></td>
                                        <td><?php echo $value['gender']; ?></td>
                                        <td><?php echo $value['mobile_number'];?></td>
                                        <td><?php echo $value['permanent_address'];?></td>
                                        <td><?php echo $value['dob'];?></td>
                                        <td><?php echo $value['joining_date'];?></td>
                                        
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        var table = $('#student-listing').DataTable({
                dom: 'Blrtip',
                buttons: [
                    'excel', 'print'
                ],
                columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }],
                select: {
                    style: 'multi'
                }
            });
    </script>