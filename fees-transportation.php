<?php
   require_once 'employee/config/config.php';
   require_once 'employee/class/Accounts.php';
   $accounts = new Accounts();

   if (isset($_POST['action']) && $_POST['action'] == 'fees-transportation') {
       $result = $accounts->addTransportationFees($_POST);
   
       $redirect_path = BASE_ROOT . 'fees-transportation.php';
       if ($result->success && is_null($id)) $id = $result->insert_id;
       $accounts->redirect($redirect_path);
   }
    $get_trans_fees = $accounts->getTransportationFees();
   require_once 'includes/header.php';
   require_once 'includes/sidebar.php';
   ?>
<div class="page-wrapper">
   <!-- content -->
   <div class="content container-fluid">
      <div class="page-header">
         <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12 col-12">
               <h5 class="text-uppercase">Transportation Fees</h5>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-12">
               <ul class="list-inline breadcrumb float-right">
                  <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                  <li class="list-inline-item">Transportation Fees</li>
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
      <form class="form-validate" id="fees-transportation-form" action="" method="post" novalidate="novalidate">
         <div class="card-box mb-0">
            <div class="card-header border-0">
               <h4 class="card-title">Transportation Fees</h4>
            </div>
            <div class="card-body">
              <?php if(!$get_trans_fees->success) { ?>
               <div class="form-group row">
                  <label class="col-form-label col-md-2">Route Name</label>
                    <div class="col-md-3">
                        <input type="text" placeholder="Route Name" name="routeName[]" class="routeName form-control">
                    </div>
                    <label class="col-form-label">Amount</label>
                    <div class="col-md-3">
                        <input type="text" placeholder="Amount" name="addAmount[]" class="addAmount form-control">
                    </div>
               </div>
               <?php } ?>
               <?php $i=1;?>
               <?php foreach ($get_trans_fees->results as $fees) : ?>
               <div class="form-group row add_fees_type" id="trans-fees-<?php echo $i;?>">
                    <label class="col-form-label col-md-2">Route Name</label>
                    <div class="col-md-3">
                        <input type="text" value = "<?= $fees->routeName; ?>" name="routeName[]" class="routeName form-control">
                    </div>
                    <label class="col-form-label">Amount</label>
                    <div class="col-md-3">
                        <input type="text" value = "<?= $fees->addAmount; ?>" name="addAmount[]" class="addAmount form-control">
                    </div>
                    <div class="col-md-3">
                      <img title="DELETE" src="<?php echo BASE_ROOT;?>assets/img/cancel.png" onclick="javascript:deleteAddress(this.name)" style="cursor: pointer;" name="trans-fees-<?php echo $i;?>">
                    </div>
                </div>
                <?php
                $i++;
                 endforeach; ?>

                <div id="fees-types-div">
                </div>
               <div class="controls addAnotherStop">
                    <a href="javascript:addAnother();" >Add Routes</a>
                </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="pull-right">
                        <button class="btn btn-secondary shadow-none mr-2" type="submit" name="action" value="fees-transportation">Submit</button>
                        <a class="btn btn-secondary shadow-none" href="dashboard.php">Cancel</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
</div>
<div class="form-group row add_fees_type" id="clone-fees-type-div" style="display: none;">
                    <label class="col-form-label col-md-2">Route Name</label>
                    <div class="col-md-3">
                        <input type="text" name="routeName[]" class="routeName form-control">
                    </div>
                    <label class="col-form-label">Amount</label>
                    <div class="col-md-3">
                        <input type="text" name="addAmount[]" class="addAmount form-control">
                    </div>
                    <div class="col-md-3">
                      <img id="delete-icon" title="DELETE" src="<?php echo BASE_ROOT;?>assets/img/cancel.png" border="0" onclick="javascript:deleteAddress(this.name)" style="cursor: pointer;" />
                    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript" src="<?= BASE_ROOT; ?>assets/js/accounts.js"></script>
<script type="text/javascript">
    var sectionLength = $('.add_fees_type').length;
    var k = (sectionLength > 0) ? sectionLength + 1 : 1;

        function addAnother() {
                var aboutAddrow = $("#clone-fees-type-div").clone().removeAttr('style'); 
                aboutAddrow.attr("id", "trans-fees-" + k);

                var feetypeBoxname = aboutAddrow.find('.routeName').attr('name', 'routeName[]');    
                feetypeBoxname.attr('id', 'routeName' + k);
                feetypeBoxname.attr('placeholder', 'Route Name');

                var amountBox = aboutAddrow.find('.addAmount').attr('name', 'addAmount[]');    
                amountBox.attr('id', 'addAmount' + k);
                amountBox.attr('placeholder', 'Amount');

                var deleteicon = aboutAddrow.find('#delete-icon');
                deleteicon.attr('id', 'newdelete' + k);
                deleteicon.attr('name', 'trans-fees-' + k);

                $("#fees-types-div").append(aboutAddrow);

                k = k + 1;
        }

        function deleteAddress(deleteid) {
            $('#' + deleteid).remove();
        }

        $("#fees-transportation-form").validate({
            ignore: "input[type='text']:hidden",
            rules:{
                'routeName[]':{
                    required:true
                },                
                'addAmount[]':{
                    required:true
                }
            }
        });
</script>
