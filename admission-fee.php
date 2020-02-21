<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';

$accounts = new Accounts();

$admission_fees = $accounts->getAdmissionFeeList();
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
                    <h5 class="text-uppercase">Admission Fee</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item"> Admission Fee List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-3">

            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="add-edit-admission-fee.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Admission Fee</a>
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
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th>Fee Amount</th>
                                    <th>Fee Paid</th>
                                    <th>Fee Due</th>
                                    <th>Fee Due Date</th>
                                    <th>Invoice</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($admission_fees->success && $admission_fees->count) : ?>
                                    <?php foreach ($admission_fees->results as $key => $admission_fee) : ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= $admission_fee->admission_no; ?></td>
                                            <td><?= $admission_fee->student_name; ?></td>
                                            <td><?= $admission_fee->total_fee_amount; ?></td>
                                            <td><?= $admission_fee->total_fee_payment ?: 0; ?></td>
                                            <td><?= ($admission_fee->total_fee_amount - $admission_fee->total_fee_payment) ?: 0; ?></td>
                                            <td><?= $admission_fee->due_date ? date('d/m/Y', strtotime($admission_fee->due_date)) : '-'; ?></td>
                                            <td>
                                                <?php if ($admission_fee->total_fee_payment) : ?>
                                                    <a href="admission-fee-receipt.php?id=<?= $admission_fee->id; ?>" class="btn btn-sm btn-dark">
                                                        View
                                                    </a>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($admission_fee->total_fee_amount > $admission_fee->total_fee_payment) : ?>
                                                    <a href="collect-admission-fee.php?id=<?= $admission_fee->id; ?>" class="btn btn-sm btn-dark">
                                                        Collect
                                                    </a>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr class="col-sm-12">
                                        <td class="text-center" colspan="9">No data here</td>
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
