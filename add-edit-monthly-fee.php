<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();

$student = new Optional();

$fee_head = new Optional();
$fee_fee_items = new Optional();

$monthly_fee = new Optional();
$monthly_fee_items = new Optional();

$transportation_fee = null;

if ($id = isset($_GET['id']) ? intval($_GET['id']) : null) {
    $monthly_fee = $accounts->getMonthlyFee($id);
    $monthly_fee_items = $accounts->getMonthlyFeeItems($id);
    $_GET['admission_no'] = $monthly_fee->admission_no;
}

if ($admission_no = isset($_GET['admission_no']) ? urldecode($_GET['admission_no']) : null) {
    $student = $accounts->getStudentByAdmssionNo($admission_no);
    $fee_head = $accounts->getFeeHeadByClassId('monthly', $student->class_id);
    $fee_head_items = $accounts->getFeeHeadItems($fee_head->id);
    $transportation_fee = $accounts->getTransportationIfExists($student->transportation_id);
}

if (is_null($id) && isset($_GET['date_from'])) $monthly_fee->date_from = $accounts->date('d/m/Y', $_GET['date_from']);
if (is_null($id) && isset($_GET['date_to'])) $monthly_fee->date_to = $accounts->date('d/m/Y', $_GET['date_to']);
if (isset($_POST['action']) && $_POST['action'] == 'add-edit-monthly-fee') {
    $result = $accounts->addEditMonthlyFee($_POST, $id);
    if ($_POST['payment_time'] == 'now') {
        if ($result->success) {
            if (is_null($id)) $id = $result->insert_id;
            $accounts->redirect(BASE_ROOT . 'collect-monthly-fee.php?id=' . $id);
        }
    }
    $accounts->redirect(BASE_ROOT . 'monthly-fee.php');
}

$search_form = new Optional(compact('admission_no'));

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php $title = $id ? 'Edit Monthly Fee' : 'Add Monthly Fee'; ?>
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
        <?php if (is_null($admission_no)) : ?>
            <form class="form-validate" action="" method="get" novalidate="novalidate">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Admission No</label>
                            <input type="text" name="admission_no" class="form-control required" value="<?= $search_form->admission_no; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-8">

                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Action</label>
                            <div class="d-flex">
                                <button class="btn btn-light w-100 shadow-none" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
        <div class="card-box">
            <form class="form-validate" action="" name="add-fee-form" id="add-fee-form" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Admission No</label>
                            <input type="text" name="student_admission_no" class="form-control required" value="<?= $student->admission_no; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Class</label>
                            <input type="text" name="student_class" class="form-control required" value="<?= $student->class_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control required" value="<?= $student->first_name . ' ' . $student->last_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date From</label>
                            <input type="text" name="date_from" class="form-control datetimepicker required" required value="<?= $monthly_fee->date_from ? $accounts->date('d-m-Y', $monthly_fee->date_from) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date To</label>
                            <input type="text" name="date_to" class="form-control datetimepicker required" required value="<?= $monthly_fee->date_to ? $accounts->date('d-m-Y', $monthly_fee->date_to) : ''; ?>">
                        </div>
                    </div>
                </div>

                <?php require_once('./fee-section.php'); ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Collect Payment</label>
                            <select name="payment_time" id="payment_time" class="form-control required">
                                <option value="now">Now</option>
                                <option value="later">Later</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="add-edit-monthly-fee">Submit</button>
                            <a class="btn btn-secondary shadow-none" href="monthly-fee.php">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">
    $(function() {
        <?php if (is_null($id)) : ?>
            <?php
            if (!is_null($transportation_fee)) {
                array_push($fee_head_items->results, [
                    'title' => "Transportation ({$transportation_fee->routeName})",
                    'amount' => $transportation_fee->addAmount,
                    'discount_type' => null,
                    'discount_value' => null,
                    'discount' => 0,
                    'total' => $transportation_fee->addAmount
                ]);
            }
            ?>
            window.fee_items = <?= json_encode($fee_head_items->results ?: []); ?>;
        <?php else : ?>
            window.fee_items = <?= json_encode($monthly_fee_items->results ?: []); ?>;
        <?php endif; ?>
    }());
</script>
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>