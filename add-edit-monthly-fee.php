<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();

$student = new Optional();
$monthly_fee = new Optional();
$monthly_fee_items = new Optional();

if ($id = isset($_GET['id']) ? intval($_GET['id']) : null) {
    $monthly_fee = $accounts->getMonthlyFee($id);
    $monthly_fee_items = $accounts->getMonthlyFeeItems($id);
    $_GET['admission_no'] = $monthly_fee->admission_no;
}

if ($admission_no = isset($_GET['admission_no']) ? urldecode($_GET['admission_no']) : null) {
    $student = $accounts->getStudentByAdmssionNo($admission_no);
}

if (is_null($id)) {
    $monthly_fee_items_results = [];
    if ($fee_head = $accounts->getClassSectionMonthlyFeeHead($student->class_id, $student->section_id)) {
        $discount = $accounts->getMonthlyFeeHeadDiscount($fee_head->id);
        $discount_amount = 0;

        if (isset($_GET['discount_type']) && $_GET['discount_value']) {
            if ($_GET['discount_type'] == 'fixed') {
                $discount_amount = intval($_GET['discount_value']);
            }

            if ($_GET['discount_type'] == 'percentage') {
                $discount_amount = $fee_head->amount * intval($_GET['discount_value']) / 100;
            }
        }

        $monthly_fee_items_results[] = (object) [
            'fee_type' => $fee_head->type,
            'fee_amount' => $fee_head->amount,
            'discount_type' => $discount_amount ? $_GET['discount_type'] : null,
            'discount_amount' => $discount_amount,
            'total' => $fee_head->amount - $discount_amount
        ];
    }

    if ($transportation_fee_id = (isset($_GET['transportation_fee_id']) ? urldecode($_GET['transportation_fee_id']) : null)) {
        $transportation_fee = $accounts->getTransportationFee($transportation_fee_id);
        $monthly_fee_items_results[] = (object) [
            'fee_type' => 'Transportation Fee (' . $transportation_fee->routeName . ')',
            'fee_amount' => $transportation_fee->addAmount,
            'total' => $transportation_fee->addAmount
        ];
    }

    $monthly_fee_items = new Optional([
        'success' => true, 'count' => count($monthly_fee_items_results), 'results' => $monthly_fee_items_results
    ]);
    unset($monthly_fee_items_results);
}

if (is_null($id) && isset($_GET['date_from'])) $monthly_fee->date_from = $accounts->date('d/m/Y', $_GET['date_from']);
if (is_null($id) && isset($_GET['date_to'])) $monthly_fee->date_to = $accounts->date('d/m/Y', $_GET['date_to']);

if (isset($_POST['action']) && $_POST['action'] == 'add-edit-monthly-fee') {
    $result = $accounts->addEditMonthlyFee($_POST, $id);
    if ($_POST['payment_time'] == 'now') {
        if ($result->success) {
            if (is_null($id)) $id = $result->insert_id;
            $accounts->redirect(BASE_ROOT . 'collect-monthly-fee.php?id=' . $id);
        }
    }
    $accounts->redirect(BASE_ROOT . 'monthly-fee.php');
}

$search_form = new Optional(compact('admission_no'));

$fee_heads_results = [];
$fee_heads = $accounts->getFeeHeads();

$discounts_results = [];
$discount_heads = $accounts->getDiscounts();
foreach ($discount_heads->results as $discount) {
    $discounts_results[$discount->id] = $discount->discount_head;
}

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php $title = $id ? 'Edit Monthly Fee' : 'Add Monthly Fee'; ?>
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
        <?php if (is_null($id)) : ?>
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Admission No</label>
                            <input type="text" name="student_admission_no" class="form-control required" value="<?= $student->admission_no; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control required" value="<?= $student->first_name . ' ' . $student->last_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Class</label>
                            <input type="text" name="student_class" class="form-control required" value="<?= $student->class_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Section</label>
                            <input type="text" name="student_section" class="form-control required" value="<?= $student->section_name; ?>" required readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date From</label>
                            <input type="text" name="date_from" class="form-control datetimepicker required" required value="<?= $monthly_fee->date_from ? $accounts->date('d-m-Y', $monthly_fee->date_from) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date To</label>
                            <input type="text" name="date_to" class="form-control datetimepicker required" required value="<?= $monthly_fee->date_to ? $accounts->date('d-m-Y', $monthly_fee->date_to) : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fee Type</label>
                            <input type="text" id="fee_type" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fee Amount</label>
                            <input type="text" id="fee_amount" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <select id="discount_type" class="form-control">
                                <option value="">Select discount type</option>
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Discount Value</label>
                            <input type="text" id="discount_value" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Action</label>
                            <div class="d-flex">
                                <button class="btn btn-dark w-100 shadow-none" type="button" id="add-fee">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table" id="add-fee-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Discount Type</th>
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
                            <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="add-edit-monthly-fee">Submit</button>
                            <a class="btn btn-secondary shadow-none" href="monthly-fee.php">Cancel</a>
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
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>
<script type="text/javascript">
    (function($) {
        var discounts_results = <?= json_encode($discounts_results); ?>;
        var monthly_fee_items = <?= ($monthly_fee_items->success && $monthly_fee_items->count) ? json_encode($monthly_fee_items->results) : '[]'; ?>;
        monthly_fee_items = monthly_fee_items.map(function(fee_item) {
            fee_item.discount_head_id = fee_item.discount_head_id || '';
            fee_item.discount_amount = fee_item.discount_amount || 0;
            return fee_item;
        });

        var blank_row_tr = '<tr id="blank_row_tr"><td class="text-center" colspan="7">No data here</td></tr>';

        function new_row_template(fee_type, fee_amount, discount_type, discount_amount, total) {
            if (discount_amount == 0) discount_type = '';
            return '<tr>' +
                '<td class="counter"></td>' +
                '<td class="fee_type_td">' +
                '<span>' + fee_type + '</span>' +
                '<input type="hidden" name="fee_type[]" value="' + fee_type + '" />' +
                '</td>' +
                '<td class="fee_amount_td">' +
                '<span>' + fee_amount + '</span>' +
                '<input type="hidden" name="fee_amount[]" value="' + fee_amount + '" />' +
                '</td>' +
                '<td class="discount_type">' +
                '<span>' + (discount_type || '-') + '</span>' +
                '<input type="hidden" name="discount_type[]" value="' + discount_type + '" />' +
                '</td>' +
                '<td class="discount_amount_td">' +
                '<span>' + discount_amount + '</span>' +
                '<input type="hidden" name="discount_amount[]" value="' + discount_amount + '" />' +
                '</td>' +
                '<td class="total_td">' +
                '<span>' + total + '</span>' +
                '<input type="hidden" name="total[]" value="' + total + '" />' +
                '</td>' +
                '<td class="remove_row_td">' +
                '<a href="#" class="text-dark">' +
                '<i class="fa fa-trash fa-lg"></i>' +
                '</a>' +
                '</td>' +
                '</tr>';
        }

        function calculate_total() {
            var fee_amount_total = 0,
                discount_amount_total = 0,
                payable_total = 0;
            $('.fee_amount_td input:hidden').each(function() {
                fee_amount_total += parseFloat($(this).val());
            });

            $('.discount_amount_td input:hidden').each(function() {
                discount_amount_total += parseFloat($(this).val());
            });

            $('.total_td input:hidden').each(function() {
                payable_total += parseFloat($(this).val());
            });

            $('#total_amount_td').text(fee_amount_total);
            $('#total_discount_td').text(discount_amount_total);
            $('#total_payable_td').text(payable_total);
        }

        $(document).on('click', '#add-fee', function(e) {
            e.preventDefault();

            if ($('[name="student_name"]').val().trim() === '') {
                alert('Select a student before adding fee');
                return;
            }

            var $fee_type = $('#fee_type');
            var $fee_amount = $('#fee_amount');
            var $discount_type = $('#discount_type');
            var $discount_value = $('#discount_value');

            var fee_type = $fee_type.val();
            var fee_amount = $fee_amount.val();
            var discount_type = $discount_type.val();
            var discount_value = $discount_value.val();

            if (!fee_type) {
                alert('Enter fee type');
                return;
            }

            if (!fee_amount) {
                alert('Enter fee amount');
                return;
            }

            if (isNaN(fee_amount) || 0 >= fee_amount) {
                alert('Fee amount should be a number and greater than zero.');
                return;
            }

            if (discount_value && !discount_type) {
                alert('Select discount type');
                return;
            }

            if (discount_value && isNaN(discount_value)) {
                alert('Discount should be a number');
                return;
            }

            var discount_amount = 0;
            var total = fee_amount = parseInt(fee_amount);

            if (discount_value = parseInt(discount_value)) {
                if (discount_type === 'fixed') {
                    discount_amount = discount_value;
                }

                if (discount_type === 'percentage') {
                    discount_amount = fee_amount * discount_value / 100;
                }

                total = fee_amount - discount_amount;
            }

            if (0 >= total) {
                alert('Discount should be less than fee amount');
                return;
            }

            if ($('#add-fee-table tbody tr#blank_row_tr').length) {
                $('#add-fee-table tbody tr#blank_row_tr').remove();
            }

            $('#add-fee-table tbody').append(
                new_row_template(fee_type, fee_amount, discount_type, discount_amount, total)
            );

            $fee_type.val('');
            $fee_amount.val('');
            $discount_type.val('');
            $discount_value.val('');
            calculate_total();
        });

        $(document).on('click', '.remove_row_td', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
            calculate_total();
        });

        $(document).on('submit', '#add-fee-form', function(e) {
            if ($('[name="student_name"]').val().trim() === '') {
                alert('Select a student before adding fee');
                return;
            }
            if ($('#add-fee-table tbody tr:not(#blank_row_tr)').length == 0) {
                alert('Add fee before submit.');
                e.preventDefault();
                return;
            }
            return true;
        });

        if (monthly_fee_items.length) {
            if ($('#add-fee-table tbody tr#blank_row_tr').length) {
                $('#add-fee-table tbody tr#blank_row_tr').remove();
            }
            for (var i = 0; i < monthly_fee_items.length; i++) {
                var fee_item = monthly_fee_items[i];
                $('#add-fee-table tbody').append(
                    new_row_template(fee_item.fee_type, fee_item.fee_amount, fee_item.discount_type, fee_item.discount_amount, fee_item.total)
                );
            }
            calculate_total();
        }
    }(jQuery));
</script>