<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/SendStudentsSMS.php';  
$send_sms=new SendStudentsSMS(); 
$resultSendSMS=$send_sms->getSMSStudentsLists();

if($_REQUEST['type'] == 'sending-sms' && is_array($_REQUEST['studentsID'])) {
    $resultSendSMS=$send_sms->SendingSMS($_REQUEST);
        $_SESSION['Msg'] = "SMS sent successfully!";
        $_SESSION['success'] = true;
        header('Location: ' . BASE_ROOT.'send-sms-students.php');
}
?>

<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
            <form>
            <div class="page-header">
                    <div class="row">
                        <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                            <h5 class="text-uppercase">Send SMS</h5>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <ul class="list-inline breadcrumb float-right">
                                <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Send SMS</li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="content-page">
            <form id="addStudents" action="employee/process/processSendStudentsSMS.php" method="post" novalidate="novalidate">
            <input type="hidden" name="type" value="sending-sms" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Student Name</th>
                                        <th style="min-width:50px;">Father's Name</th>
                                        <th style="min-width:50px;">Mobile Number</th>
                                        <th style="min-width:50px;"><input type="checkbox" id="selectall"/> Select All</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php foreach ($resultSendSMS as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['student_name']; ?></td>
                                        <td><?php echo $value['fathers_name']; ?></td>
                                        <td><?php echo $value['mobile_number']; ?></td>
                                        <td class="">
                                            <input type="checkbox" name="studentsID[]" value="<?php echo $value[0]; ?>" class="student-list">
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-center custom-mt-form-group">
                            <button class="btn btn-primary btn-lg mr-2" type="submit">Send</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){
            $('#selectall').change(function () {
                $('.student-list').prop("checked", $(this).prop("checked"));
                if($(this).prop("checked")){
                    $('.student-list').parent('span').addClass('checked');
                }else{
                    $('.student-list').parent('span').removeClass('checked');
                }

            });
        });
        </script>