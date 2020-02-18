<?php
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';


$accounts = new Accounts();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$user = $accounts->getUser($_SESSION['userId']);
$admission_fee = $accounts->getAdmissionFee($id);
$admission_total_fee = $accounts->getAdmissionTotalFee($id);
$admission_total_payment = $accounts->getAdmissionTotalPayment($id);

if ($admission_total_fee == 0) $accounts->redirect(BASE_ROOT . 'admission-fee.php');

$admission_fee_items = $accounts->getAdmissionFeeItems($id);
$admission_fee_payments = $accounts->getAdmissionFeePayments($id);
$billing_address = null;
if ($admission_fee_payments->success && $admission_fee_payments->count) {
    try {
        $billing_address = (object) unserialize($admission_fee_payments->results[0]->billing_address);
    } catch (\Throwable $th) {
    }
}

$discounts_results = [];
$discount_heads = $accounts->getDiscounts();
foreach ($discount_heads->results as $discount) {
    $discounts_results[$discount->id] = $discount->discount_head;
}
?>

<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>
<div class="page-wrapper">
    <!-- content -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                    <h5 class="text-uppercase">Admission Fee Recepit</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item"> Admission Fee Recepit</li>
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
        <div class="content-page">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Admission Fee Recepit</h3>
                </div>
                <div class="col-md-6">
                    <img src="<?= BASE_ROOT; ?>assets/img/school-logo.png" alt="School Logo" height="60">
                </div>
                <div class="col-md-6 text-right">
                    <h5>Fee Receipt: #<?= $id; ?></h5>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-unstyled m-b-0">
                        <li><?= $user->school_name; ?></li>
                        <li><?= $user->phone_number; ?></li>
                        <li><?= $user->address; ?></li>
                    </ul>
                </div>
            </div>
            <br>
            <br>
            <?php if ($billing_address) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-unstyled m-b-0">
                            <li><?= $billing_address->first_name . ' ' . $billing_address->last_name; ?></li>
                            <li><?= $billing_address->phone; ?></li>
                            <li><?= $billing_address->email; ?></li>
                            <li><?= $billing_address->address_1; ?></li>
                            <li><?= $billing_address->address_2; ?></li>
                            <li><?= $billing_address->city . ', ' . $billing_address->state; ?></li>
                            <li><?= $billing_address->postal_code . ', ' . $billing_address->country; ?></li>
                        </ul>
                    </div>
                </div>
                <br>
                <br>
            <?php endif; ?>
            <h4>Fees</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fee Type</th>
                            <th>Amount</th>
                            <th>Discount Head</th>
                            <th>Discount Amount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($admission_fee_items->success && $admission_fee_items->count) : ?>
                            <?php foreach ($admission_fee_items->results as $key => $admission_fee_item) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $admission_fee_item->fee_type; ?></td>
                                    <td><?= $admission_fee_item->fee_amount; ?></td>
                                    <td><?= isset($discounts_results[$admission_fee_item->discount_head_id]) ? $discounts_results[$admission_fee_item->discount_head_id] : '-'; ?></td>
                                    <td><?= $admission_fee_item->discount_amount; ?></td>
                                    <td><?= $admission_fee_item->total; ?></td>
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
            <br>
            <br>
            <h4>Payments</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($admission_fee_payments->success && $admission_fee_payments->count) : ?>
                            <?php foreach ($admission_fee_payments->results as $key => $admission_fee_payment) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $admission_fee_payment->payment_date ? date('d/m/Y', strtotime($admission_fee_payment->payment_date)) : '-'; ?></td>
                                    <td><?= $admission_fee_payment->payment_method; ?></td>
                                    <td><?= $admission_fee_payment->fee_paid; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="col-sm-12">
                                <td class="text-center" colspan="4">No data here</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <h4>Totals</h4>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="text-right">Total Fee Amount</th>
                            <th>:</th>
                            <td><?= $admission_total_fee; ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Total Fee Amount</th>
                            <th>:</th>
                            <td><?= $admission_total_payment; ?></td>
                        </tr>
                        <?php if ($admission_total_fee > $admission_total_payment) : ?>
                            <tr>
                                <th class="text-right">Due Fee Amount</th>
                                <th>:</th>
                                <td><?= $admission_total_fee - $admission_total_payment; ?></td>
                            </tr>
                            <tr>
                                <th class="text-right">Due Fee Date</th>
                                <th>:</th>
                                <td><?= date('d/m/Y', strtotime($admission_fee->due_date)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>