<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (isset($_POST['action']) && $_POST['action'] == 'collect-admission-fee') {
    $result = $accounts->collectAdmissionFee($_POST, $id);

    $accounts->redirect(BASE_ROOT . 'admission-fee.php');
}

$admission_fee = $accounts->getAdmissionFee($id);
$admission_total_fee = $accounts->getAdmissionTotalFee($id);
$admission_total_payment = $accounts->getAdmissionTotalPayment($id);

if (0 >= ($admission_total_fee = $admission_total_fee - $admission_total_payment)) {
    $accounts->redirect(BASE_ROOT . 'admission-fee.php');
}

$admission = $accounts->getAdmissionByAdmssionNo($admission_fee->admission_no);

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php $title = 'Collect Admission Fee'; ?>
<div class="page-wrapper">
    <!-- content -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                    <h5 class="text-uppercase"><?= $title; ?></h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item"><?= $title; ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php if ($alert = $accounts->alert()) : ?>
            <div class="alert alert-<?= $alert['type']; ?> alert-dismissible fade show" role="alert">
                <?= $alert['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="card-box">
            <form class="form-validate" action="" id="collect-admission-fee-form" name="collect-admission-fee-form" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Admission No</label>
                            <input type="text" name="student_roll_no" class="form-control required" value="<?= $admission->admission_no; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Class</label>
                            <input type="text" name="student_class" class="form-control required" value="<?= $admission->class_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control required" value="<?= $admission->first_name . ' ' . $admission->last_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="text" name="total_amount" class="form-control required" value="<?= $admission_total_fee; ?>" required readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control required" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Due Fee</label>
                            <input type="text" name="fee_due" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="text" name="due_date" class="form-control datetimepicker" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Payment Mode</label>
                            <select name="method" id="method" class="form-control required">
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                                <option value="bank_transter">Bank Transter</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Collected By</label>
                            <input type="text" id="collected_by" class="form-control required" value="<?= $_SESSION['name']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea name="comment" id="comment" cols="30" class="form-control required"></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <h5>Billing Information</h5>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="billing[first_name]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="billing[last_name]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="billing[phone]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="billing[email]" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" name="billing[address_1]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" name="billing[address_2]" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>City/District</label>
                            <input type="text" name="billing[city]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>State/Province</label>
                            <input type="text" name="billing[state]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" name="billing[postal_code]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="billing[country]" class="form-control">
                        </div>
                    </div>
                </div>
                <hr>
                <h4>Payment Information</h4>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Payment relation Info (Optional)</label>
                            <textarea name="description" id="description" cols="30" class="form-control" placeholder="Enter payment info like cheque no, transaction no if bank transter or other payment related info."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="collect-admission-fee">Submit</button>
                            <a class="btn btn-secondary shadow-none" href="admission-fee.php">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>
<script type="text/javascript">
    (function($) {
        var total_fee = parseFloat($('[name="total_amount"]').val());

        function update_due_fee() {
            var fee_due = total_fee - parseFloat($('[name="amount"]').val());
            if (isNaN(fee_due)) return;
            $('[name="fee_due"]').val(fee_due);
            if (fee_due > 0) {
                $('[name="due_date"]').addClass('required').removeAttr('readonly');
            } else {
                $('[name="due_date"]').removeClass('required').val('').attr('readonly', 'true');
            }
        }

        function validate_amount() {
            var amount = $('[name="amount"]').val();
            if (isNaN(amount) || 0 >= amount) {
                alert('Fee amount should be a number and greater than zero.');
                return false;
            }

            if (amount > total_fee) {
                alert('Fee amount should not be more than total fee.');
                return false;
            }

            update_due_fee();

            return true;
        }

        $(document).on('blur', '[name="amount"]', function() {
            return validate_amount();
        });

        $(document).on('submit', '#collect-admission-fee-form', function(e) {
            return validate_amount();
        });
    }(jQuery));
</script>