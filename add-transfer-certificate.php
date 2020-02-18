<?php
require_once 'employee/class/dbclass.php'; 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';
require_once 'employee/class/TransferCertificate.php';
$leaves = new TransferCertificate();

$leaveId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : NULL; 
if ($leaveId != NULL) { $result = $leaves->getLeaveTypeInfo($leaveId); 
    if ($result == NULL) { $leaveId = ''; } }
    ?>
<style type="text/css">
    .tcForm p{
        line-height: 40px;
    }
    .tcForm input[type="text"]{
        border: 0;
        border-bottom: 1px dotted #000;
        width: 190px;
        padding:0 10px;
    }
    .logo {
        height: 57px;
        margin-left: 10px;
        vertical-align: top;
    }
</style>    
        <div class="page-wrapper"> <!-- content -->
        <div class="content container-fluid">
         <div class="row justify-content-between">
        <div class="col"><img src="<?php echo BASE_ROOT; ?>assets/img/logo-tc.jpg" alt="" class="logo"></div>
        <div class="col text-center">
            <h3>U.P. Global School</h3>
            <p>Affiliated to CBSE New Delhi</p>
        </div>
        <div class="col  text-center">
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col"><p>Affilliated number: 213394</p><p>T.C number: 201</p></div>
        <div class="col text-center">
            <h5>Transfer Certificate</h5>
        </div>
        <div class="col  text-center">
        </div>
    </div>
    <div class="tcForm">
    <form id="addLeaveType" action="employee/process/processTransferCertificate.php" method="post" novalidate="novalidate">
    <input type="hidden" name="type" value="<?php echo $leaveId == '' ? 'Add' : 'Update'; ?>" />
        <p>This is to certify <input type="text" name="student_name" value="<?php
            if (isset($result[0]['student_name']))
                echo htmlspecialchars($result[0]['student_name']);
            ?>"> Son/Daughter of <input type="text" name="guardian_name" value="<?php
            if (isset($result[0]['guardian_name']))
                echo htmlspecialchars($result[0]['guardian_name']);
            ?>"> Address of <input type="text" name="address" value="<?php
            if (isset($result[0]['address']))
                echo htmlspecialchars($result[0]['address']);
            ?>"> religion/category <input type="text" name="religion" value="<?php
            if (isset($result[0]['religion']))
                echo htmlspecialchars($result[0]['religion']);
            ?>"> was admitted to U.P Global School <input type="text" name="joining" value="<?php
            if (isset($result[0]['joining']))
                echo htmlspecialchars($result[0]['joining']);
            ?>"> on a transfer certificate from <input type="text" name="from_date" value="<?php
            if (isset($result[0]['from_date']))
                echo htmlspecialchars($result[0]['from_date']);
            ?>"> and left on with a good character <input type="text" name="to_date" value="<?php
            if (isset($result[0]['to_date']))
                echo htmlspecialchars($result[0]['to_date']);
            ?>"> He/She was studying in the <input type="text" name="class_name" value="<?php
            if (isset($result[0]['class_name']))
                echo htmlspecialchars($result[0]['class_name']);
            ?>"> class, the school begin from April to March all sums due to this school on his/her account has been paid, remitted or satisfactorilly aranged for his/her date of birth according to the admission register (in figure) <input type="text" name="amount_figures" value="<?php
            if (isset($result[0]['amount_figures']))
                echo htmlspecialchars($result[0]['amount_figures']);
            ?>"> in words <input type="text" name="amount_words" value="<?php
            if (isset($result[0]['amount_words']))
                echo htmlspecialchars($result[0]['amount_words']);
            ?>"> </p>
        <p>The following additional information must be supplied if the scholar left at the end of the school year promotion has beed granted/refused to</p>
        <p><input type="text" class="w-100" name="additional_info" value="<?php
            if (isset($result[0]['additional_info']))
                echo htmlspecialchars($result[0]['additional_info']);
            ?>"></p>

        <div class="row justify-content-between mt-5">
            <div class="col">
                <p>Date: <input type="text" name="tc_date" value="<?php
            if (isset($result[0]['tc_date']))
                echo htmlspecialchars($result[0]['tc_date']);
            ?>"></p>
            </div>
            <div class="col text-right">
                <p>Principal Signature</p>
            </div>
        </div>
        <div class="form-group text-center custom-mt-form-group">
                            <button class="btn btn-primary btn-lg mr-2" type="submit">Create</button>
                        </div> 
        </form>
    </div>
</div>
</div>
<?php require_once 'includes/footer.php'; ?>
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
    });
</script>