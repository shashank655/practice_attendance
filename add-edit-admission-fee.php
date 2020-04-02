<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();

$admission = new Optional();

$fee_head = new Optional();
$fee_fee_items = new Optional();

$admission_fee = new Optional();
$admission_fee_items = new Optional();

if ($id = isset($_GET['id']) ? intval($_GET['id']) : null) {
    $admission_fee = $accounts->getAdmissionFee($id);
    $admission_fee_items = $accounts->getAdmissionFeeItems($id);
    $_GET['admission_no'] = $admission_fee->admission_no;
}

if ($admission_no = isset($_GET['admission_no']) ? urldecode($_GET['admission_no']) : null) {
    $admission = $accounts->getAdmissionByAdmssionNo($admission_no);
    $fee_head = $accounts->getFeeHeadByClassId('admission', $admission->class_id);
    $fee_head_items = $accounts->getFeeHeadItems($fee_head->id);
}

if (isset($_POST['action']) && $_POST['action'] == 'add-edit-admission-fee') {
    $result = $accounts->addEditAdmissionFee($_POST, $id);
    if ($_POST['payment_time'] == 'now') {
        if ($result->success) {
            if (is_null($id)) $id = $result->insert_id;
            $accounts->redirect(BASE_ROOT . 'collect-admission-fee.php?id=' . $id);
        }
    }
    $accounts->redirect(BASE_ROOT . 'admission-fee.php');
}

$search_form = new Optional(compact('admission_no'));

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php $title = $id ? 'Edit Admission Fee' : 'Add Admission Fee'; ?>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Admission No</label>
                            <input type="text" name="student_admission_no" class="form-control required" value="<?= $admission->admission_no; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Class</label>
                            <input type="text" name="student_class" class="form-control required" value="<?= $admission->class_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control required" value="<?= $admission->first_name . ' ' . $admission->last_name; ?>" required readonly>
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
                            <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="add-edit-admission-fee">Submit</button>
                            <a class="btn btn-secondary shadow-none" href="admission-fee.php">Cancel</a>
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
            window.fee_items = <?= json_encode($fee_head_items->results ?: []); ?>;
        <?php else : ?>
            window.fee_items = <?= json_encode($admission_fee_items->results ?: []); ?>;
        <?php endif; ?>
    }());
</script>
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>