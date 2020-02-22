<?php
require_once 'employee/config/config.php';
require_once 'employee/class/Accounts.php';
require_once 'vendor/autoload.php';

$accounts = new Accounts();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$is_download = isset($_GET['download']) ? boolval($_GET['download']) : null;

$user = $accounts->getUser($_SESSION['userId']);
$admission_fee = $accounts->getAdmissionFee($id);
$admission_total_fee = $accounts->getAdmissionTotalFee($id);
$admission_total_payment = $accounts->getAdmissionTotalPayment($id);

if ($admission_total_fee == 0) $accounts->redirect(BASE_ROOT . 'admission-fee.php');
if ($is_download) {
    ob_start();
    include_once 'admission-fee-receipt-content.php';
    $html = ob_get_clean();
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->load_html($html);
    $dompdf->setPaper('A4');
    $dompdf->render();
    return $dompdf->stream('Admission Fee Recepit #'. $id);
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
                    <h5 class="text-uppercase">Admission Fee Recepit</h5>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                    <ul class="list-inline breadcrumb float-right">
                        <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                        <li class="list-inline-item"> Admission Fee Recepit</li>
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
        <div class="row print-button-div mb-2">
            <div class="col-12">
                <div class="pull-right">
                    <a href="admission-fee-receipt.php?id=<?= $id; ?>&download=true" class="btn btn-sm btn-dark" target="_blank">Download</a>
                    <button type="button" id="print" class="btn btn-sm btn-dark">Print</button>
                </div>
            </div>
        </div>
        <?php require_once 'admission-fee-receipt-content.php'; ?>
    </div>
    <?php require_once 'includes/footer.php'; ?>
    <style type="text/css">
        @media print {

            .header,
            #sidebar,
            .page-header,
            .print-button-div {
                display: none;
            }

            .page-wrapper {
                margin-left: 0;
            }
        }
    </style>
    <script type="text/javascript">
        (function($) {
            $(document).on('click', '#print', function(e) {
                e.preventDefault();
                window.print();
            });
        }(jQuery));
    </script>
