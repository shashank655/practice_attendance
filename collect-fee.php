<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';
require_once 'employee/class/MinavoVSMS.php';

$accounts = new Accounts();

$classes = $accounts->getClasses();
$sections = $accounts->getSections();
$transportation_fees = $accounts->getTransportationFees();

if ((!isset($_GET['class_id']) || empty($_GET['class_id'])) && $classes->count > 0) {
    $_GET['class_id'] = $classes->results[0]->id;
}

if ((!isset($_GET['section_id']) || empty($_GET['section_id'])) && $sections->count > 0) {
    $_GET['section_id'] = $sections->results[0]->id;
}

$search = new Optional($_GET);
$students = $accounts->getCollectFeeStudentListing($_GET);
$fee_head = $accounts->getClassSectionFeeHead($search->class_id, $search->section_id);

$classes_results = [];
foreach ($classes->results as $classe) {
    $classes_results[$classe->id] = $classe->class_name;
}

$sections_results = [];
foreach ($sections->results as $section) {
    $sections_results[$section->id] = $section->section_name;
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
                    <h5 class="text-uppercase">Collect Fee</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item"> Collect Fee List</li>
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
        <form class="form-validate" action="" method="get" novalidate="novalidate" id="filter-collet-fee-list" name="filter-collet-fee-list">
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
                        <input type="text" class="form-control" name="admission_no" value="<?= $search->admission_no; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" class="form-control" name="student_name" value="<?= $search->student_name; ?>">
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
                                    <th>#</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th>Class/Section</th>
                                    <th>Total Fee</th>
                                    <th>Transportation Route</th>
                                    <th>Discount Type</th>
                                    <th>Discount Amount</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($students->success && $students->count) : ?>
                                    <?php foreach ($students->results as $key => $student) : ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td>
                                                <input type="hidden" name="admission_no[]" value="<?= $student->admission_no; ?>">
                                                <?= $student->admission_no; ?>
                                            </td>
                                            <td><?= $student->first_name . ' ' . $student->last_name; ?></td>
                                            <td><?= $classes_results[$student->class_id] . '/' . $sections_results[$student->section_id]; ?></td>
                                            <td>
                                                <?= $student->total_fee ?? '-'; ?>
                                                <input type="hidden" name="fee_amount[]" value="<?= $student->total_fee ?? 0; ?>">
                                            </td>
                                            <td>
                                                <select name="transportation_fee_id[]" class="form-control form-control-sm required">
                                                    <?php if ($transportation_fees->count) : ?>
                                                        <option value="">Select fee head</option>
                                                        <?php foreach ($transportation_fees->results as $transportation_fee) : ?>
                                                            <option value="<?= $transportation_fee->id; ?>"><?= $transportation_fee->routeName; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <option value="">No fee head</option>
                                                    <?php endif; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="discount_type[]" class="form-control form-control-sm">
                                                    <option value="">Select discount type</option>
                                                    <option value="fixed">Fixed</option>
                                                    <option value="percentage">Percentage</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="discount_value[]" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="text" name="date_from[]" class="form-control form-control-sm datetimepicker required" required />
                                            </td>
                                            <td>
                                                <input type="text" name="date_to[]" class="form-control form-control-sm datetimepicker required" required />
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="#" class="text-dark p-2 collect-fee-action">
                                                        <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td class="text-center" colspan="11">No data here</td>
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

    <script type="text/javascript">
        (function($) {
            var sections = <?= ($sections->success && $sections->count) ? json_encode($sections->results) : '[]'; ?>;

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

            <?php if (isset($search->class_id)) : ?>
                $('[name="class_id"]').trigger('change');
            <?php endif; ?>

            <?php if (isset($search->section_id)) : ?>
                setTimeout(function() {
                    $('[name="section_id"]').val('<?= $search->section_id; ?>');
                }, 100);
            <?php endif; ?>

            $('[name="class_id"]').trigger('change');

            $('#filter-collet-fee-list').submit(function(e) {
                $(this).find('select,input').map(function(i, element) {
                    element.disabled = !$(element).val();
                });
            });

            $(document).on('click', '.collect-fee-action', function(event) {
                event.preventDefault();
                var admission_no = $(this).parents('tr').find('[name="admission_no[]"]').val();
                var fee_amount = $(this).parents('tr').find('[name="fee_amount[]"]').val();
                var discount_type = $(this).parents('tr').find('[name="discount_type[]"]').val();
                var discount_value = $(this).parents('tr').find('[name="discount_value[]"]').val();
                var transportation_fee_id = $(this).parents('tr').find('[name="transportation_fee_id[]"]').val();

                var date_from = $(this).parents('tr').find('[name="date_from[]"]').val();
                var date_to = $(this).parents('tr').find('[name="date_to[]"]').val();


                if (!transportation_fee_id) {
                    alert('Select transportation route head.');
                    return;
                }

                if (discount_value && !discount_type) {
                    alert('Select discount type.');
                    return;
                }

                if (!date_from) {
                    alert('Enter from date');
                    return;
                }

                if (!date_to) {
                    alert('Enter to date');
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

                var params = {};
                if (admission_no) params['admission_no'] = admission_no;
                if (transportation_fee_id) params['transportation_fee_id'] = transportation_fee_id;
                if (date_from) params['date_from'] = date_from;
                if (date_to) params['date_to'] = date_to;
                if (discount_type && discount_value) {
                    params['discount_type'] = discount_type;
                    params['discount_value'] = discount_value;
                }

                window.location.href = encodeURI('/add-edit-monthly-fee.php?' + Object.keys(params).map(key => key + '=' + params[key]).join('&'));
            });
        }(jQuery))
    </script>