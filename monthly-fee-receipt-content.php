<?php
$monthly_fee_items = $accounts->getMonthlyFeeItems($id);
$monthly_fee_payments = $accounts->getMonthlyFeePayments($id);
$billing_address = null;
if ($monthly_fee_payments->success && $monthly_fee_payments->count) {
    try {
        $billing_address = (object) unserialize($monthly_fee_payments->results[0]->billing_address);
    } catch (\Throwable $th) {
    }
}

$discounts_results = [];
$discount_heads = $accounts->getDiscounts();
foreach ($discount_heads->results as $discount) {
    $discounts_results[$discount->id] = $discount->discount_head;
}
$base_path_or_url = $is_download ? DOCUMENT_ROOT : BASE_ROOT;
?>
<?php if ($is_download) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Monthly Fee Recepit</title>

        <link rel="stylesheet" type="text/css" href="<?= $base_path_or_url; ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $base_path_or_url; ?>assets/css/style.css">
        <style>
            html {
                margin: 25px;
            }

            body {
                font-size: 80%;
                line-height: 1.2;
            }
            h4 {
                font-size: 80%;
            }
        </style>
    </head>

    <body>
    <?php endif; ?>
    <div class="content-page">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Monthly Fee Recepit</h3>
            </div>
            <div class="col-md-6">
                <img src="<?= $base_path_or_url; ?>assets/img/school-logo.png" alt="School Logo" height="60">
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
                    <li><?= $admin_user->school_name; ?></li>
                    <li><?= $admin_user->phone_number; ?></li>
                    <li><?= $admin_user->address; ?></li>
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
                    <?php if ($monthly_fee_items->success && $monthly_fee_items->count) : ?>
                        <?php foreach ($monthly_fee_items->results as $key => $monthly_fee_item) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $monthly_fee_item->fee_type; ?></td>
                                <td><?= $monthly_fee_item->fee_amount; ?></td>
                                <td><?= isset($discounts_results[$monthly_fee_item->discount_head_id]) ? $discounts_results[$monthly_fee_item->discount_head_id] : '-'; ?></td>
                                <td><?= $monthly_fee_item->discount_amount; ?></td>
                                <td><?= $monthly_fee_item->total; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
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
                    <?php if ($monthly_fee_payments->success && $monthly_fee_payments->count) : ?>
                        <?php foreach ($monthly_fee_payments->results as $key => $monthly_fee_payment) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $monthly_fee_payment->payment_date ? date('d/m/Y', strtotime($monthly_fee_payment->payment_date)) : '-'; ?></td>
                                <td><?= $monthly_fee_payment->payment_method; ?></td>
                                <td><?= $monthly_fee_payment->fee_paid; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
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
                        <td><?= $monthly_total_fee; ?></td>
                    </tr>
                    <tr>
                        <th class="text-right">Total Fee Amount</th>
                        <th>:</th>
                        <td><?= $monthly_total_payment; ?></td>
                    </tr>
                    <?php if ($monthly_total_fee > $monthly_total_payment) : ?>
                        <tr>
                            <th class="text-right">Due Fee Amount</th>
                            <th>:</th>
                            <td><?= $monthly_total_fee - $monthly_total_payment; ?></td>
                        </tr>
                        <tr>
                            <th class="text-right">Due Fee Date</th>
                            <th>:</th>
                            <td><?= date('d/m/Y', strtotime($monthly_fee->due_date)); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if ($is_download) : ?>
    </body>
    </html>
<?php endif; ?>
