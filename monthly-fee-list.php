<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';
require_once 'employee/class/MinavoVSMS.php';

$accounts = new Accounts();
$monthly_fees = $accounts->getStudentMonthlyFeeList($_SESSION['userId']);
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
                    <h5 class="text-uppercase">Monthly Fee</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item"> Monthly Fee List</li>
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
                    <div class="table-responsive">
                        <table class="table datable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th>Fee Amount</th>
                                    <th>Fee Paid</th>
                                    <th>Fee Due</th>
                                    <th>Fee Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($monthly_fees->success && $monthly_fees->count) : ?>
                                    <?php foreach ($monthly_fees->results as $key => $monthly_fee) : ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= $monthly_fee->admission_no; ?></td>
                                            <td><?= $monthly_fee->student_name; ?></td>
                                            <td><?= $monthly_fee->amount; ?></td>
                                            <td><?= $monthly_fee->payment ?: 0; ?></td>
                                            <td><?= ($monthly_fee->amount - $monthly_fee->payment) ?: 0; ?></td>
                                            <td><?= $monthly_fee->due_date ? date('d/m/Y', strtotime($monthly_fee->due_date)) : '-'; ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <?php if ($monthly_fee->amount == $monthly_fee->payment) : ?>
                                                        <a href="monthly-fee-receipt.php?id=<?= $monthly_fee->id; ?>" class="text-dark p-2">
                                                            <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($monthly_fee->amount > $monthly_fee->payment) : ?>
                                                        <a href="collect-online-fee.php?id=<?= $monthly_fee->id; ?>&type=monthly" class="text-dark p-2">
                                                            <i class="fa fa-rupee fa-lg" aria-hidden="true"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr class="col-sm-12">
                                        <td class="text-center" colspan="8">No data here</td>
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
