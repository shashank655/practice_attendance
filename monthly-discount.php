<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (isset($_POST['action']) && $_POST['action'] == 'add-edit-monthly-discount') {
    $result = $accounts->addEditMonthlyDiscount($_POST, $id);
    $accounts->redirect(BASE_ROOT . 'monthly-discount.php');
}

if ($id) {
    $discount = $accounts->getMonthlyDiscount($id);
} else {
    $discount = new Optional();
}

$fee_heads = $accounts->getMonthlyFeeHeads();
$fee_heads_results = [];
foreach ($fee_heads->results as $fee_head) {
    $fee_heads_results[$fee_head->id] = $fee_head->title;
}

$discounts = $accounts->getMonthlyDiscounts();

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php $title = $id ? 'Edit Monthly Discount' : 'Create Monthly Discount'; ?>
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
            <ul class="nav nav-tabs nav-tabs-top nav-justified">
                <li class="nav-item">
                    <a class="nav-link<?= $current_url == 'discount.php' ? ' active show' : '' ?>" href="discount.php">
                        <h4>Admission Fee</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= $current_url == 'monthly-discount.php' ? ' active show' : '' ?>" href="monthly-discount.php">
                        <h4>Monthly Fee</h4>
                    </a>
                </li>
            </ul>
            <form class="form-validate" action="" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fee Head</label>
                            <select name="fee_head_id" id="fee_head_id" class="form-control required">
                                <?php if ($fee_heads->count) : ?>
                                    <option value="">Select fee head</option>
                                    <?php foreach ($fee_heads->results as $fee_head) : ?>
                                        <option value="<?= $fee_head->id; ?>" <?= $discount->fee_head_id == $fee_head->id ? 'selected' : ''; ?>><?= $fee_head->title; ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="">No fee head</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <input type="text" name="discount_type" class="form-control required" value="<?= $discount->discount_type; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Discount Head</label>
                            <input type="text" name="discount_head" class="form-control required" value="<?= $discount->discount_head; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Action</label>
                            <div class="d-flex">
                                <button class="btn btn-dark w-50 shadow-none mr-2" type="submit" name="action" value="add-edit-monthly-discount"><?= $id ? 'Update' : 'Add'; ?></button>
                                <a class="btn btn-light w-50 shadow-none" href="monthly-discount.php">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fee Head</th>
                            <th>Discount Type</th>
                            <th>Discount Head</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($discounts->success && $discounts->count) : ?>
                            <?php foreach ($discounts->results as $key => $discount) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $fee_heads_results[$discount->fee_head_id]; ?></td>
                                    <td><?= $discount->discount_type; ?></td>
                                    <td><?= $discount->discount_head; ?></td>
                                    <td><?= $discount->created_at; ?></td>
                                    <td class="text-center">
                                        <a href="monthly-discount.php?id=<?= $discount->id; ?>" class="text-dark">
                                            <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="col-sm-12">
                                <td class="text-center" colspan="6">No data here</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>
