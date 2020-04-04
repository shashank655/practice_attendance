<style>
    #add-fee-table {
        counter-reset: tablerows;
    }

    #add-fee-table tbody tr:not(#blank_row_tr) {
        counter-increment: tablerows;
    }

    #add-fee-table tbody tr:not(#blank_row_tr) td:nth-child(1)::before {
        content: counter(tablerows);
    }
</style>
<h6 class="mb-0">Add Fees</h6>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Fee Title</label>
            <input type="text" id="fee_title" class="form-control">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Fee Amount</label>
            <input type="text" id="fee_amount" class="form-control">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Discount Type</label>
            <select id="fee_discount_type" class="form-control">
                <option value="">Select discount type</option>
                <option value="fixed">Fixed</option>
                <option value="percentage">Percentage</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Discount Value</label>
            <input type="text" id="fee_discount_value" class="form-control">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Action</label>
            <div class="d-flex">
                <button class="btn btn-dark w-100 shadow-none" type="button" id="add-fee">Add</button>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="table-responsive">
    <table class="table" id="add-fee-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Fee Title</th>
                <th>Amount</th>
                <th>Discount Type</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr id="blank_row_tr">
                <td class="text-center" colspan="7">No data here</td>
            </tr>
        </tbody>
        <tfoot class="border-bottom">
            <tr>
                <th class="text-center" colspan="2">Total</th>
                <th id="total_amount_td">0</th>
                <th></th>
                <th id="total_discount_td">0</th>
                <th colspan="2" id="total_payable_td">0</th>
            </tr>
        </tfoot>
    </table>
</div>