<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'employee/class/Optional.php';

$accounts = new Accounts();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (isset($_POST['action']) && $_POST['action'] == 'add-edit-fee-head') {
    $result = $accounts->addEditMonthlyFeeHead($_POST, $id);
    $accounts->redirect(BASE_ROOT . 'monthly-fee-head.php');
}

if ($id) {
    $fee_head = $accounts->getMonthlyFeeHead($id);
} else {
    $fee_head = new Optional();
}

$classes = $accounts->getClasses();
$sections = $accounts->getSections();
$fee_heads = $accounts->getMonthlyFeeHeads();

$class_results = [];
foreach ($classes->results as $class) {
    $class_results[$class->id] = $class->class_name;
}
$section_results = [];
foreach ($sections->results as $section) {
    $section_results[$section->id] = $section->section_name;
}

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php $title = $id ? 'Edit Fee Head' : 'Create Fee Head'; ?>
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
        <div class="card-box">
            <ul class="nav nav-tabs nav-tabs-top nav-justified">
                <li class="nav-item">
                    <a class="nav-link<?= $current_url == 'fee-head.php' ? ' active show' : '' ?>" href="fee-head.php">
                        <h4>Admission Fee Head</h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= $current_url == 'monthly-fee-head.php' ? ' active show' : '' ?>" href="monthly-fee-head.php">
                        <h4>Monthly Fee Head</h4>
                    </a>
                </li>
            </ul>
            <form class="form-validate" action="" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Class</label>
                            <select name="class_id" id="class_id" class="form-control required" required>
                                <?php if ($classes->count) : ?>
                                    <option value="">Select class</option>
                                    <?php foreach ($classes->results as $class) : ?>
                                        <option value="<?= $class->id; ?>" <?= ($fee_head->class_id == $class->id) ? 'selected' : ''; ?>><?= $class->class_name; ?></option>
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
                            <select name="section_id" id="section_id" class="form-control required" required>
                                <option value=""><?= $sections->count ? 'Select Section' : 'No fee head'; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control required" value="<?= $fee_head->title; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control required" value="<?= $fee_head->type; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" class="form-control required" value="<?= $fee_head->amount; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Action</label>
                            <div class="d-flex">
                                <button class="btn btn-dark w-50 shadow-none mr-2" type="submit" name="action" value="add-edit-fee-head"><?= $id ? 'Update' : 'Add'; ?></button>
                                <a class="btn btn-light w-50 shadow-none" href="fee-head.php">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($fee_heads->success && $fee_heads->count) : ?>
                            <?php foreach ($fee_heads->results as $key => $_fee_head) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= $class_results[$_fee_head->class_id]; ?></td>
                                    <td><?= $section_results[$_fee_head->section_id]; ?></td>
                                    <td><?= $_fee_head->title; ?></td>
                                    <td><?= $_fee_head->type; ?></td>
                                    <td><?= $_fee_head->amount; ?></td>
                                    <td class="text-center">
                                        <a href="monthly-fee-head.php?id=<?= $_fee_head->id; ?>" class="text-dark">
                                            <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="col-sm-12">
                                <td class="text-center" colspan="6">No data here</td>
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
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>
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

        <?php if ($fee_head->class_id) : ?>
            $('[name="class_id"]').trigger('change');
        <?php endif; ?>
        <?php if ($fee_head->section_id) : ?>
            setTimeout(function() {
                $('[name="section_id"]').val('<?= $fee_head->section_id; ?>');
            }, 100);
        <?php endif; ?>
    }(jQuery))
</script>