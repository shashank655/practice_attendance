<?php
   require_once 'employee/config/config.php';
   require_once 'employee/class/Accounts.php';
   require_once 'employee/class/Optional.php';
   
   $accounts = new Accounts();
   
   $id = isset($_GET['id']) ? intval($_GET['id']) : null;
   
   if (isset($_POST['action']) && $_POST['action'] == 'add-edit-fee-head') {
       $result = $accounts->addEditFeeHead($_POST, $id);
   
       $redirect_path = BASE_ROOT . 'add-edit-fee-head.php?id=' . $id;
       if ($result->success && is_null($id)) $id = $result->insert_id;
       $accounts->redirect($redirect_path);
   }
   
   if ($id) {
       $fee_head = $accounts->getFeeHead($id);
       $fee_head_fees_types = $accounts->getFeeHeadFeesTypes($id);
   } else {
       $fee_head = new Optional();
       $fee_head->sections = [];
   }
   
   $fee_head->sections_ids = array_map(function ($fee_head_section) {
       return $fee_head_section->section_id;
   }, $fee_head->sections);
   
   $classes = $accounts->getClasses();
   $sections = $accounts->getSections();
   
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
      <form class="form-validate" action="" method="post" novalidate="novalidate">
         <div class="card-box mb-0">
            <div class="card-header border-0">
               <h4 class="card-title"><?= $title; ?></h4>
            </div>
            <div class="card-body">
               <div class="form-group row">
                  <label class="col-form-label col-md-2">Title</label>
                  <div class="col-md-10">
                     <input type="text" name="title" class="form-control required" value="<?= $fee_head->title; ?>" required>
                  </div>
               </div>
               <?php foreach ($fee_head_fees_types->results as $fees_types) : ?>
               <div class="form-group row add_fees_type">
                    <label class="col-form-label col-md-2">Fees Type</label>
                    <div class="col-md-3">
                        <input type="text" value = "<?= $fees_types->fees_type; ?>" name="addFeesTypes[]" class="addFeesTypes form-control">
                    </div>
                    <label class="col-form-label">Amount</label>
                    <div class="col-md-3">
                        <input type="text" value = "<?= $fees_types->amount; ?>" name="addAmount[]" class="addAmount form-control">
                    </div>
                </div>
                <?php endforeach; ?>

                <div id="fees-types-div">
                </div>
               <div class="controls addAnotherStop">
                    <a href="javascript:addAnother();" >Add Fees Types</a>
                </div>
               <div class="form-group row">
                  <label class="col-form-label col-md-2">Classes</label>
                  <div class="col-md-10">
                     <div class="row">
                        <?php if ($classes->success && $classes->count) : ?>
                        <?php foreach ($classes->results as $class) : ?>
                        <div class="col-md-4">
                           <h4><?= $class->class_name; ?></h4>
                           <ul class="list-group list-group-flush border-bottom ml-4 mb-4">
                              <?php foreach ($sections->results as $section) : ?>
                              <?php if ($class->id == $section->class_id) : ?>
                              <li class="list-group-item p-2">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="section-<?= $section->id; ?>" name="section_id[<?= $class->id; ?>][<?= $section->id; ?>]" <?= in_array($section->id, $fee_head->sections_ids) ? 'checked' : ''; ?> />
                                    <label class="custom-control-label" for="section-<?= $section->id; ?>"><?= $section->section_name; ?></label>
                                 </div>
                              </li>
                              <?php endif; ?>
                              <?php endforeach; ?>
                           </ul>
                        </div>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <div class="col-sm-12">
                           <span>No data here</span>
                        </div>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="pull-right">
                        <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="add-edit-fee-head">Submit</button>
                        <a class="btn btn-secondary shadow-none" href="fee-head.php">Cancel</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
</div>
<div id="clone-fees-type-div" style="display: none;" class="form-group row add_fees_type">
                    <label class="col-form-label col-md-2">Fees Type</label>
                    <div class="col-md-3">
                        <input type="text" name="addFeesTypes[]" class="addFeesTypes form-control">
                    </div>
                    <label class="col-form-label">Amount</label>
                    <div class="col-md-3">
                        <input type="text" name="addAmount[]" class="addAmount form-control">
                    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>
<script type="text/javascript">
    var sectionLength = $('.add_fees_type').length;
    var k = (sectionLength > 0) ? sectionLength + 1 : 1;

        function addAnother() {
                var aboutAddrow = $("#clone-fees-type-div").clone().removeAttr('style'); 
                aboutAddrow.attr("id", "fees_types_list" + k);

                var feetypeBoxname = aboutAddrow.find('.addFeesTypes').attr('name', 'addFeesTypes[]');    
                feetypeBoxname.attr('id', 'addFeesTypes' + k);
                feetypeBoxname.attr('placeholder', 'Fees Types');

                var amountBox = aboutAddrow.find('.addAmount').attr('name', 'addAmount[]');    
                amountBox.attr('id', 'addAmount' + k);
                amountBox.attr('placeholder', 'Amount');

                $("#fees-types-div").append(aboutAddrow);

                k = k + 1;
        }
</script>