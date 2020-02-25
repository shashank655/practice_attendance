<?php
require_once 'employee/class/dbclass.php'; 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';
require_once 'employee/class/Admin.php';
require_once 'employee/class/TransferCertificate.php';
$transferCertificate = new TransferCertificate();
$admin = new Admin();
$adminData = $admin->getAdminInfo($_SESSION['userId']);
$tcId = (isset($_REQUEST['tcId'])) ? $_REQUEST['tcId'] : NULL; 
if ($tcId != NULL) { $result = $transferCertificate->getFormInfo($tcId); 
    if ($result == NULL) { $tcId = ''; } }
?>
<style type="text/css">

    .formHeaderBar, .formHeaderBar *{
        color:#336699;
    }
    .poweredBy{
        font-size: 12px;
    }
    .tcFormBlock h3{
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .tcFormBlock p{
        font-size: 14px;
    }
    .tcFormBlock h5{
        font-size: 14px;
        color: #336699;
        font-weight: 600;
    }
    .tcformHeading p{
        color: #336699;
    }
    .tcForm p{
        line-height: 40px;
        color: #336699;
    }
    .tcForm input[type="text"]{
        border: 0;
        border-bottom: 1px dotted #336699;
        width: 190px;
        color: #000;
        padding:0 10px;
    }
</style>    
<div class="page-wrapper tcFormBlock">
    <!-- content -->
    <div class="content container-fluid print-div">
        <div class="tcFormBlock">
            <div class="container">
                <div class="row d-print-flex d-none justify-content-between mb-5 formHeaderBar">
                    <div class="col"><img src="<?php echo BASE_ROOT; ?>assets/img/logo-tc.jpg" alt="school logo" width="80"></div>
                    <div class="col-6 text-center pt-3">
                        <h3><?php echo $adminData[0]['school_name'];?></h3>
                        <p class="mb-1"><?php echo $adminData[0]['address'];?></p>
                        <p class="mb-1">Phone number: <?php echo $adminData[0]['phone_number'];?> </p>
                        <p class="mb-1">Email: <em><strong><?php echo $adminData[0]['email_address'];?></strong></em>
                    </div>
                    <div class="col text-right pt-5">
                        <p class="poweredBy" style="text-align: right">Powered by Adhyay <img src="<?php echo BASE_ROOT; ?>assets/img/adhyay-logo-color.png" style="width: 30px;"></p>
                    </div>
                </div>
                <div class="row d-print-none justify-content-between mb-5 formHeaderBar">
                    <div class="col-md-3 text-md-left text-center"><img src="<?php echo BASE_ROOT; ?>assets/img/logo-tc.jpg" alt="school logo" width="80"></div>
                    <div class="col-md-6 text-center pt-3">
                        <h3><?php echo $adminData[0]['school_name'];?></h3>
                        <p class="mb-1"><?php echo $adminData[0]['address'];?></p>
                        <p class="mb-1">Phone number: <?php echo $adminData[0]['phone_number'];?> </p>
                        <p class="mb-1">Email: <em><strong><?php echo $adminData[0]['email_address'];?></strong></em>
                    </div>
                    <div class="col-md-3 text-md-right text-center pt-5">
                        <p class="poweredBy">Powered by Adhyay <img src="<?php echo BASE_ROOT; ?>assets/img/adhyay-logo-color.png" style="width: 30px;"></p>
                    </div>
                    <div class="col  text-right" style="text-align: right">
        <a href="javascript:void(0);" id="print_button" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Print</a>
        </div>
                </div>
                <div class="row justify-content-between mb-3 tcformHeading">
                    <div class="col">
                        <p class="mb-1"><strong>Affilliated number:</strong> 213394</p>
                        <p class="mb-1"><strong>T.C number:</strong> 201</p>
                    </div>
                    <div class="col text-center">
                        <h5>Transfer Certificate</h5>
                    </div>
                    <div class="col  text-center">
                    </div>
                </div>
                <form id="addLeaveType" action="employee/process/processTransferCertificate.php" method="post" novalidate="novalidate">
                <input  type="hidden" name="type" value="<?php echo $leaveId == '' ? 'Add' : 'Update'; ?>" />
                <div class="tcForm">
                    <p>This is to certify
                        <input type="text" readonly="readonly" name="student_name" value="<?php
            if (isset($result[0]['student_name']))
                echo htmlspecialchars($result[0]['student_name']);
            ?>"> Son/Daughter of
                        <input type="text" readonly="readonly" name="guardian_name" value="<?php
            if (isset($result[0]['guardian_name']))
                echo htmlspecialchars($result[0]['guardian_name']);
            ?>"> Address of
                        <input type="text" readonly="readonly" name="address" value="<?php
            if (isset($result[0]['address']))
                echo htmlspecialchars($result[0]['address']);
            ?>"> religion/category
                        <input type="text" readonly="readonly" name="religion" value="<?php
            if (isset($result[0]['religion']))
                echo htmlspecialchars($result[0]['religion']);
            ?>"> was admitted to U.P Global School
                        <input type="text" readonly="readonly" name="joining" value="<?php
            if (isset($result[0]['joining']))
                echo htmlspecialchars($result[0]['joining']);
            ?>"> on a transfer certificate from
                        <input type="text" value="<?php
            if (isset($result[0]['from_date']))
                echo htmlspecialchars($result[0]['from_date']);
            ?>" name="from_date" readonly="readonly" > and left on with a good character
                        <input type="text" value="<?php
            if (isset($result[0]['to_date']))
                echo htmlspecialchars($result[0]['to_date']);
            ?>" name="to_date" readonly="readonly" > He/She was studying in the
                        <input type="text" value="<?php
            if (isset($result[0]['class_name']))
                echo htmlspecialchars($result[0]['class_name']);
            ?>" name="class_name" readonly="readonly" > class, the school begin from April to March all sums dut to this school on his/her account has been paid, remitted or satisfactorilly aranged for his/her date of birth according to the admission register (in figure)
                        <input type="text" value="<?php
            if (isset($result[0]['amount_figures']))
                echo htmlspecialchars($result[0]['amount_figures']);
            ?>" name="amount_figures" readonly="readonly" > in words
                        <input type="text" value="<?php
            if (isset($result[0]['amount_words']))
                echo htmlspecialchars($result[0]['amount_words']);
            ?>" name="amount_words" readonly="readonly"> </p>
                    <p>The following additional information must be supplied if the scholar left at the end of the school year promotion has beed granted/refused to</p>
                    <p>
                        <input type="text" value="<?php
            if (isset($result[0]['additional_info']))
                echo htmlspecialchars($result[0]['additional_info']);
            ?>" class="w-100" name="additional_info" readonly="readonly">
                    </p>

                    <div class="row justify-content-between mt-5">
                        <div class="col">
                            <p>Date:
                                <input type="text" value="<?php
            if (isset($result[0]['tc_date']))
                echo htmlspecialchars($result[0]['tc_date']);
            ?>" name="tc_date" readonly="readonly">
                            </p>
                        </div>
                        <div class="col text-right">
                            <p>Principal Signature</p>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script src="employee/js/printThis.js"></script>
<script type="text/javascript">
    $(function(){
        $("#addLeaveType").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                student_name:{
                    required:true
                },                
                guardian_name:{
                    required:true
                },                
                address:{
                    required:true
                },
                religion:{
                    required:true
                },
                joining:{
                    required:true
                },
                from_date:{
                    required:true
                },
                to_date:{
                    required:true
                },
                class_name:{
                    required:true
                },
                tc_date:{
                    required:true
                }
            }
        });

        var paidType = $('#paid_type').val();
        $('#paid_type_bk').change(function(){
            if($('#paid_type').val() == 'paid') {
                $('#paid_div_show').show();  
            } else {
                $('#paid_div_show').hide(); 
                } 
            });

        $('#print_button').on("click", function () {
            $('.print-div').printThis({
                importCSS: true,
                loadCSS:"<?php echo BASE_ROOT; ?>assets/css/print.css"
            });
        });
    });
</script>