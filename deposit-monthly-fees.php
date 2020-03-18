<?php
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/CommonFunction.php';
$common_function=new CommonFunction();
$accounts = new Accounts();
$resultClasses = $common_function->getAllClassesName();
//echo "<pre>";print_r($resultClasses);die;
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


require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<div class="page-wrapper">
    <!-- content -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                    <h5 class="text-uppercase">Collect Admission Fees</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item">Collect Admission Fees</li>
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
            <?php if (is_null($id)) : ?>
                <form class="form-validate" action="" method="get" novalidate="novalidate">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fee Head</label>
                                <select name="fee_head_id" id="fee_head_id" class="form-control required">
                                    <?php if ($fee_heads->count) : ?>
                                        <option value="">Select fee head</option>
                                        <?php foreach ($fee_heads->results as $fee_head) : ?>
                                            <option value="<?= $fee_head->id; ?>" <?= ($search_form->fee_head_id == $fee_head->id) ? 'selected' : ''; ?>><?= $fee_head->title; ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="">No fee head</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Action</label>
                                <div class="d-flex">
                                    <button class="btn btn-light w-100 shadow-none" type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
            <?php endif; ?>
            <form class="form-validate" action="" name="add-fee-form" id="add-fee-form" method="post" novalidate="novalidate">
                <hr>
                <div class="table-responsive">
                    <table class="table" id="add-fee-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Discount Head</th>
                                <th>Discount Amount</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="blank_row_tr">
                                <td class="text-center" colspan="7">No data here</td>
                            </tr>
                        </tbody>
                        <tfoot class="border-bottom">
                            <tr>
                                <th class="text-center" colspan="2">Total</th>
                                <th class="text-center" id="total_amount_td">0</th>
                                <th class="text-center" colspan="2" id="total_discount_td">0</th>
                                <th class="text-center" colspan="2" id="total_payable_td">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="test">Submit</button>
                            <a class="btn btn-secondary shadow-none" href="deposit-monthly-fees.php">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<style>
    #add-fee-table {
        counter-reset: tablerows;
    }

    #add-fee-table tbody tr {
        counter-increment: tablerows;
    }

    #add-fee-table tbody tr td.counter::before {
        content: counter(tablerows);
    }
</style>