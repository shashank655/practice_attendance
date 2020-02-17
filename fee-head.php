<?php
require_once 'employee/class/dbclass.php';
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';

$accounts = new Accounts();

$fee_heads = $accounts->getFeeHeads();
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
                    <h5 class="text-uppercase">Fee Head</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item"> Fee Head List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-3">

            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="add-edit-fee-head.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Create Fee Head</a>
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
                                    <th>S.No.</th>
                                    <th>Fee Head Title</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($fee_heads->success && $fee_heads->count) : ?>
                                    <?php foreach ($fee_heads->results as $key => $fee_head) : ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= $fee_head->title; ?></td>
                                            <td><?= $fee_head->created_at; ?></td>
                                            <td class="text-center">
                                                <a href="add-edit-fee-head.php?id=<?= $fee_head->id; ?>" class="text-dark">
                                                    <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                                                </a>
                                            </td>
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
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
