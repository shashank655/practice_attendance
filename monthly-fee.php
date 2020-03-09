<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';
require_once 'employee/class/MinavoVSMS.php';

$accounts = new Accounts();

$monthly_fees = $accounts->getMonthlyFeeList();

if (isset($_POST['action']) && $_POST['action'] == 'send-reminder' && count($_POST['student_id'])) {
    $accounts->sendMonthlyDueFeeReminder(array_unique($_POST['student_id']));
    $accounts->redirect(BASE_ROOT . 'monthly-fee.php');
}

$classes = $accounts->getClasses();
$sections = $accounts->getSections();
$search = new Optional($_GET);
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
        <div class="row">
            <div class="col-sm-4 col-3">

            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="add-edit-monthly-fee.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Monthly Fee</a>
                <a href="#" id="send-reminder" class="btn btn-primary float-right btn-rounded">Send Reminder</a>
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
        <form class="form-validate" action="" method="get" novalidate="novalidate" id="filter-monthly-fee-list" name="filter-monthly-fee-list">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Class</label>
                        <select name="class_id" id="class_id" class="form-control">
                            <?php if ($classes->count) : ?>
                                <option value="">Select class</option>
                                <?php foreach ($classes->results as $class) : ?>
                                    <option value="<?= $class->id; ?>" <?= ($search->class_id == $class->id) ? 'selected' : ''; ?>><?= $class->class_name; ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">No fee head</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Section</label>
                        <select name="section_id" id="section_id" class="form-control">
                            <option value=""><?= $sections->count ? 'Select Section' : 'No fee head'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Admission No</label>
                        <input type="text" name="admission_no" id="admission_no" class="form-control" value="<?= $search->admission_no ?: ''; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date From</label>
                        <input type="text" name="date_from" class="form-control datetimepicker required" required value="<?= $search->date_from ? $accounts->date('d-m-Y', $search->date_from) : ''; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date To</label>
                        <input type="text" name="date_to" class="form-control datetimepicker required" required value="<?= $search->date_to ? $accounts->date('d-m-Y', $search->date_to) : ''; ?>">
                    </div>
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
        <div class="content-page">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="monthly-fee-list">
                            <thead>
                                <tr>
                                    <th></th>
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
                                <?php if ($monthly_fees->success && $monthly_fees->count) : ?>
                                    <?php foreach ($monthly_fees->results as $key => $monthly_fee) : ?>
                                        <tr>
                                            <td><?= $monthly_fee->student_id; ?></td>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= $monthly_fee->admission_no; ?></td>
                                            <td><?= $monthly_fee->student_name; ?></td>
                                            <td><?= $monthly_fee->total_fee_amount; ?></td>
                                            <td><?= $monthly_fee->total_fee_payment ?: 0; ?></td>
                                            <td><?= ($monthly_fee->total_fee_amount - $monthly_fee->total_fee_payment) ?: 0; ?></td>
                                            <td><?= $monthly_fee->due_date ? date('d/m/Y', strtotime($monthly_fee->due_date)) : '-'; ?></td>
                                            <td>
                                                <?php if ($monthly_fee->total_fee_payment) : ?>
                                                    <a href="monthly-fee-receipt.php?id=<?= $monthly_fee->id; ?>" class="text-dark p-2">
                                                        <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>
                                                    </a>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <?php if ($monthly_fee->total_fee_payment == 0) : ?>
                                                        <a href="add-edit-monthly-fee.php?id=<?= $monthly_fee->id; ?>" class="text-dark p-2">
                                                            <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($monthly_fee->total_fee_amount > $monthly_fee->total_fee_payment) : ?>
                                                        <a href="collect-monthly-fee.php?id=<?= $monthly_fee->id; ?>" class="text-dark p-2">
                                                            <i class="fa fa-rupee fa-lg" aria-hidden="true"></i>
                                                        </a>
                                                    <?php else : ?>
                                                        -
                                                    <?php endif; ?>
                                                </div>

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
    <link rel="stylesheet" href="<?= BASE_ROOT; ?>assets/css/dataTables.checkboxes.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <style>
        .dt-buttons {
            float: right !important;
        }

        #monthly-fee-list {
            margin-top: 0 !important;
        }
    </style>
    <script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/dataTables.checkboxes.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        (function($) {
            var sections = <?= ($sections->success && $sections->count) ? json_encode($sections->results) : '[]'; ?>;

            <?php if ($search->class_id) : ?>
                setTimeout(() => {
                    $('[name="class_id"]').trigger('change');
                }, 1000);
            <?php endif; ?>

            $(document).on('change', '[name="class_id"]', function(event) {
                var $sectionEl = $('[name="section_id"]');
                $sectionEl.find('option:not(:first-child)').remove();
                for (let index = 0; index < sections.length; index++) {
                    if (sections[index]['class_id'] == $(this).val()) {
                        $sectionEl.append(
                            $('<option />', {
                                value: sections[index]['id']
                            }).text(sections[index]['section_name'])
                        );
                    }
                }
            });

            $('#filter-monthly-fee-list').submit(function(e) {
                $(this).find('select,input').map(function(i, element) {
                    element.disabled = !$(element).val();
                });
            });

            var table = $('#monthly-fee-list').DataTable({
                dom: 'Blrtip',
                buttons: [
                    'excel', 'print'
                ],
                columnDefs: [{
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }],
                select: {
                    style: 'multi'
                }
            });

            $(document).on('click', '#send-reminder', function(e) {
                e.preventDefault();

                var selected = table.column(0).checkboxes.selected();
                if (selected.length == 0) {
                    alert('Select records before send reminder.');
                    return;
                }
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                $.each(selected, function(i, student_id) {
                    var input = document.createElement('input');
                    input.name = 'student_id[]';
                    input.value = student_id;
                    form.appendChild(input);
                });

                var submit = document.createElement('input');
                submit.name = 'action';
                submit.value = 'send-reminder';
                form.appendChild(submit);
                document.body.appendChild(form);
                form.submit();
            });
        }(jQuery))
    </script>
