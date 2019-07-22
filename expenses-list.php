<?php 
require_once 'employee/class/dbclass.php'; 
require_once 'employee/config/config.php'; 
require_once 'employee/class/Expenses.php';  
$expenses=new Expenses(); 
$resultExpensesList=$expenses->getExpensesLists(); 
?>

<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php'; 
?>
<div class="page-wrapper"> <!-- content -->
            <div class="content container-fluid">
			<div class="page-header">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12 col-12">
							<h5 class="text-uppercase">Expenses</h5>
						</div>
						<div class="col-lg-5 col-md-12 col-sm-12 col-12">
							<ul class="list-inline breadcrumb float-right">
								<li class="list-inline-item"><a href="dashboard.php">Home</a></li>
                                <li class="list-inline-item"> Expenses</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-sm-4 col-3">
                      
                    </div>
                    <div class="col-sm-8 col-9 text-right m-b-20">
                        <a href="add-expenses.php" class="btn btn-primary float-right btn-rounded"><i class="fa fa-plus"></i> Add Expense</a>
                    </div>
                </div>
			<div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">S.No.</th>
                                        <th style="min-width:50px;">Expense Type</th>
                                        <th style="min-width:50px;">Item Name</th>
                                        <th style="min-width:50px;">Purchase From</th>
                                        <th style="min-width:50px;">Purchase Date</th>
                                        <th style="min-width:50px;">Purchase By</th>
                                        <th style="min-width:50px;">Amount</th>
                                        <th style="min-width:50px;">Paid By</th>
                                        <th style="min-width:50px;">Status</th>
                                        <th style="min-width:50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                    <?php 
                                    if ($resultExpensesList) {
                                    foreach ($resultExpensesList as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value['type']; ?></td>
                                        <td><?php echo $value['item_name']; ?></td>
                                        <td><?php echo $value['purchase_from']; ?></td>
                                        <td><?php echo $value['purchase_date']; ?></td>
                                        <td><?php echo $value['purchased_by']; ?></td>
                                        <td><?php echo $value['amount']; ?></td>
                                        <td><?php echo $value['paid_by']; ?></td>
                                        <td><?php echo $value['status']; ?></td>
                                        <td class="text-right" >
											<a href="add-expenses.php?expenseId=<?php echo $value['id']; ?>" class="btn btn-primary btn-sm mb-1">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
                                            <a href="employee/process/processExpenses.php?type=deleteExpense&id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm mb-1">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
											
										</td>
                                    </tr>
                                	<?php $i++; }  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php'; ?>