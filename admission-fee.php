<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';
require_once 'employee/class/MinavoVSMS.php';

$accounts = new Accounts();

if (isset($_POST['action']) && $_POST['action'] == 'send-reminder' && count($_POST['admission_id'])) {
    $accounts->sendAdmissionDueFeeReminder(array_unique($_POST['admission_id']));
    $accounts->redirect(BASE_ROOT . 'admission-fee.php');
}

$admission_fees = $accounts->getAdmissionFeeList();
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
        <form class="form-validate" action="" method="get" novalidate="novalidate" id="filter-admission-fee-list" name="filter-admission-fee-list">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Class</label>
                        <select name="class_id" id="class_id" class="form-control update-section-on-change" data-section-ref="#section_id">
                            <?php if ($classes->count) : ?>
                                <option value="">Select class</option>
                                <?php foreach ($classes->results as $class) : ?>
                                    <option value="<?= $class->id; ?>" <?= ($search->class_id == $class->id) ? 'selected' : ''; ?>><?= $class->class_name; ?></option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">No class</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Section</label>
                        <select name="section_id" id="section_id" class="form-control" data-value="<?= $search->section_id; ?>">
                            <option value=""><?= $sections->count ? 'Select Section' : 'No Section'; ?></option>
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
                        <table class="table" id="admission-fee-list">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th>Total Amount</th>
                                    <th>Fee Paid</th>
                                    <th>Balance</th>
                                    <th>Balance Date</th>
                                    <th>Invoice</th>
                                    <th>Edit</th>
                                    <th>Pay Now</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_amount = $total_fee_paid = 0; ?>
                                <?php if ($admission_fees->success && $admission_fees->count) : ?>
                                    <?php foreach ($admission_fees->results as $key => $admission_fee) : ?>
                                        <?php
                                        $total_amount += $admission_fee->total;
                                        $total_fee_paid += $admission_fee->payment;
                                        ?>
                                        <tr>
                                            <td><?= $admission_fee->admission_id; ?></td>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= $admission_fee->admission_no; ?></td>
                                            <td><?= $admission_fee->student_name; ?></td>
                                            <td><?= $admission_fee->total; ?></td>
                                            <td><?= $admission_fee->payment ?: 0; ?></td>
                                            <td><?= ($admission_fee->total - $admission_fee->payment) ?: 0; ?></td>
                                            <td><?= $admission_fee->due_date ? date('d/m/Y', strtotime($admission_fee->due_date)) : '-'; ?></td>
                                            <td>
                                                <?php if ($admission_fee->payment) : ?>
                                                    <a href="admission-fee-receipt.php?id=<?= $admission_fee->id; ?>" class="text-dark p-2">
                                                        <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>
                                                    </a>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($admission_fee->payment == 0) : ?>
                                                    <a href="add-edit-admission-fee.php?id=<?= $admission_fee->id; ?>" class="text-dark p-2">
                                                        <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                                                    </a>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($admission_fee->total > $admission_fee->payment) : ?>
                                                    <a href="collect-admission-fee.php?id=<?= $admission_fee->id; ?>" class="btn btn-link p-2">
                                                        Pay Now
                                                    </a>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td class="text-center" colspan="10">No data here</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center">Total</td>
                                    <td><?= $total_amount; ?></td>
                                    <td><?= $total_fee_paid; ?></td>
                                    <td><?= $total_amount - $total_fee_paid; ?></td>
                                    <td colspan="4" class="text-center">-</td>
                                </tr>
                            </tfoot>
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

        #admission-fee-list {
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
            var sections = <?= json_encode($sections->results ?: []); ?>;

            function getClassSections(class_id) {
                return sections.filter(function(section) {
                    return section.class_id == class_id;
                });
            }

            $(document).on('change', '.update-section-on-change', function() {
                var $sectionEl = $($(this).data('sectionRef'));
                var sections = getClassSections($(this).val());
                if ($sectionEl.length && sections.length) {
                    var section_id = $sectionEl.data('value');
                    $sectionEl.find('option:not(:first-child)').remove();
                    for (var i = 0; i < sections.length; i++) {
                        var attrs = {
                            value: sections[i]['id']
                        };
                        if (attrs.value == section_id) attrs.selected = true;
                        $sectionEl.append($('<option />', attrs).text(sections[i]['section_name']));
                    }
                }
            });

            $('.update-section-on-change').trigger('change');

            $('#filter-admission-fee-list').submit(function(e) {
                $(this).find('select,input').map(function(i, element) {
                    element.disabled = !$(element).val();
                });
            });

            var table = $('#admission-fee-list').DataTable({
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
                $.each(selected, function(i, admission_id) {
                    var input = document.createElement('input');
                    input.name = 'admission_id[]';
                    input.value = admission_id;
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