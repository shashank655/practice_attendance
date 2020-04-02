<?php
$admission_fee_items = $accounts->getAdmissionFeeItems($id);
$admission_fee_payments = $accounts->getAdmissionFeePayments($id);
$billing_address = null;
if ($admission_fee_payments->success && $admission_fee_payments->count) {
    try {
        $billing_address = (object) unserialize($admission_fee_payments->results[0]->billing_address);
    } catch (\Throwable $th) {
    }
}

$base_path_or_url = $is_download ? DOCUMENT_ROOT : BASE_ROOT;
?>
<?php if ($is_download) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admission Fee Recepit</title>

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
                <h3 class="text-center">Admission Fee Recepit</h3>
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
                        <th>Fee Title</th>
                        <th>Amount</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($admission_fee_items->success && $admission_fee_items->count) : ?>
                        <?php foreach ($admission_fee_items->results as $key => $admission_fee_item) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $admission_fee_item->title; ?></td>
                                <td><?= $admission_fee_item->amount; ?></td>
                                <td><?= $admission_fee_item->discount_type ?: '-'; ?></td>
                                <td><?= $admission_fee_item->discount; ?></td>
                                <td><?= $admission_fee_item->total; ?></td>
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
                    <?php if ($admission_fee_payments->success && $admission_fee_payments->count) : ?>
                        <?php foreach ($admission_fee_payments->results as $key => $admission_fee_payment) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $admission_fee_payment->date ? date('d/m/Y', strtotime($admission_fee_payment->payment_date)) : '-'; ?></td>
                                <td><?= $admission_fee_payment->method; ?></td>
                                <td><?= $admission_fee_payment->amount; ?></td>
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
    <?php if ($is_download) : ?>
    </body>
    </html>
<?php endif; ?>