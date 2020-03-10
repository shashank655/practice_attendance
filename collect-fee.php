<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';
require_once 'employee/class/MinavoVSMS.php';

$accounts = new Accounts();

if (isset($_POST['action']) && $_POST['action'] == 'send-reminder' && count($_POST['student_id'])) {
    $accounts->sendMonthlyDueFeeReminder(array_unique($_POST['student_id']));
    $accounts->redirect(BASE_ROOT . 'monthly-fee.php');
}

$classes = $accounts->getClasses();
$sections = $accounts->getSections();
$fee_heads = $accounts->getFeeHeads();

if ((!isset($_GET['class_id']) || empty($_GET['class_id'])) && $classes->count > 0) {
    $_GET['class_id'] = $classes->results[0]->id;
}

$search = new Optional($_GET);
$students = $accounts->getStudentListByClassAndSection($_GET);

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
                                    <th>Fee Head</th>
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
                                                <select name="fee_head_id[]" class="form-control form-control-sm required">
                                                    <?php if ($fee_heads->count) : ?>
                                                        <option value="">Select fee head</option>
                                                        <?php foreach ($fee_heads->results as $fee_head) : ?>
                                                            <option value="<?= $fee_head->id; ?>"><?= $fee_head->title; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <option value="">No fee head</option>
                                                    <?php endif; ?>
                                                </select>
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

            $('#filter-collet-fee-list').submit(function(e) {
                $(this).find('select,input').map(function(i, element) {
                    element.disabled = !$(element).val();
                });
            });

            $(document).on('click', '.collect-fee-action', function(event) {
                event.preventDefault();
                var date = '<?= date('d/m/Y'); ?>';
                var admission_no = $(this).parents('tr').find('[name="admission_no[]"]').val();
                var fee_head_id = $(this).parents('tr').find('[name="fee_head_id[]"]').val();
                var date_from = $(this).parents('tr').find('[name="date_from[]"]').val();
                var date_to = $(this).parents('tr').find('[name="date_to[]"]').val();

                if (!fee_head_id) {
                    alert('Select fee head.');
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

                window.location.href = encodeURI('/add-edit-monthly-fee.php?fee_head_id=' + fee_head_id + '&date=' + date + '&admission_no=' + admission_no + '&date_from=' + date_from + '&date_to=' + date_to);
            });
        }(jQuery))
    </script>
