<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();

$fee_head = $fee_head_items = new Optional();

if ($id = isset($_GET['id']) ? intval($_GET['id']) : null) {
    $fee_head = $accounts->getFeeHead($id);
    $fee_head_items = $accounts->getFeeHeadItems($id);
}

if (isset($_POST['action']) && $_POST['action'] == 'add-edit-fee-head') {
    $result = $accounts->addEditFeeHead($_POST, $id);
    $accounts->redirect(BASE_ROOT . 'fee-head.php');
}

$classes = $accounts->getClasses();

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php $title = $id ? 'Edit FeeHead Fee' : 'Add FeeHead Fee'; ?>
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
            <form class="form-validate" action="" name="add-edit-fee-head" id="add-edit-fee-head" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fee Head Type</label>
                            <select id="type" name="type" class="form-control required" required>
                                <option value="monthly" <?= ($fee_head->type == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                                <option value="admission" <?= ($fee_head->type == 'admission') ? 'selected' : ''; ?>>Admission</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Class</label>
                            <select id="class_id" name="class_id" class="form-control required" required>
                                <?php if ($classes->count) : ?>
                                    <option value="">Select class</option>
                                    <?php foreach ($classes->results as $class) : ?>
                                        <option value="<?= $class->id; ?>" <?= ($fee_head->class_id == $class->id) ? 'selected' : ''; ?>><?= $class->class_name; ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="">No fee head</option>
                                <?php endif; ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Fee Head Title</label>
                            <input type="text" name="title" class="form-control required" value="<?= $fee_head->title; ?>" required>
                        </div>
                    </div>
                </div>

                <?php require_once('./fee-section.php'); ?>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="add-edit-fee-head">Submit</button>
                            <a class="btn btn-secondary shadow-none" href="fee-head.php">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">
    $(function() {window.fee_items = <?= json_encode($fee_head_items->results ?: []); ?>;}());
</script>
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>