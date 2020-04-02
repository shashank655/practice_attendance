<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';
require_once 'employee/class/MinavoVSMS.php';

$accounts = new Accounts();

$classes = $accounts->getClasses();
$sections = $accounts->getSections();

if (!isset($_GET) || count($_GET) == 0) {
    if ($sections->success && $sections->count) {
        $_GET['class_id'] = $sections->results[0]->class_id;
        $_GET['section_id'] = $sections->results[0]->id;
    }
}

$search = new Optional($_GET);
$students = $accounts->getCollectFeeStudentListing($_GET);
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
                            <option value=""><?= $sections->count ? 'Select Section' : 'No section'; ?></option>
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
                                            <td><?= $student->class_name . '/' . $student->section_name; ?></td>
                                            <td>
                                                <?= $student->total ?? '-'; ?>
                                            </td>
                                            <td>
                                                <?= $student->transportation; ?>
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

            $('#filter-collet-fee-list').submit(function(e) {
                $(this).find('select,input').map(function(i, element) {
                    element.disabled = !$(element).val();
                });
            });

            $(document).on('click', '.collect-fee-action', function(event) {
                event.preventDefault();
                var admission_no = $(this).parents('tr').find('[name="admission_no[]"]').val();
                var date_from = $(this).parents('tr').find('[name="date_from[]"]').val();
                var date_to = $(this).parents('tr').find('[name="date_to[]"]').val();

                if (!date_from) {
                    alert('Enter from date');
                    return;
                }

                if (!date_to) {
                    alert('Enter to date');
                    return;
                }

                var params = {};
                if (admission_no) params['admission_no'] = admission_no;
                if (date_from) params['date_from'] = date_from;
                if (date_to) params['date_to'] = date_to;

                window.location.href = encodeURI('/add-edit-monthly-fee.php?' + Object.keys(params).map(key => key + '=' + params[key]).join('&'));
            });
        }(jQuery))
    </script>