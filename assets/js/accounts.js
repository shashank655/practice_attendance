(function ($) {
    'use strict';

    $('.form-validate').validate({
        ignore: 'input[type="text"]:hidden'
    });
}(jQuery));
(function ($) {
    'use strict';
    var i = typeof window.fee_rows !== 'undefined' ? window.fee_rows : 0;
    var blank_row_tr = '<tr id="blank_row_tr"><td class="text-center" colspan="7">No data here</td></tr>';

    function new_row_template(title, amount, discount_type, discount_value, discount, total) {
        if (discount == 0) discount_type = discount_value = '';
        amount = parseFloat(amount).toFixed(2);
        discount = parseFloat(discount).toFixed(2);
        total = parseFloat(total).toFixed(2);

        var html = '<tr><td><input type="hidden" name="items[' + i + '][title]" value="' + title + '"/><input type="hidden" class="amount" name="items[' + i + '][amount]" value="' + amount + '"/><input type="hidden" class="discount_type" name="items[' + i + '][discount_type]" value="' + discount_type + '"/><input type="hidden" class="discount_value" name="items[' + i + '][discount_value]" value="' + discount_value + '"/><input type="hidden" class="discount" name="items[' + i + '][discount]" value="' + discount + '"/><input type="hidden" class="total" name="items[' + i + '][total]" value="' + total + '"/></td><td>' + title + '</td><td>' + amount + '</td><td>' + discount_type + '</td><td>' + discount + '</td><td>' + total + '</td><td><a href="#" class="remove_fee text-dark"><i class="fa fa-trash fa-lg"></i></a></td></tr>';

        i++;
        return html;
    }

    function calculate_total() {
        var amount = 0, discount = 0, total = 0;
        $('#add-fee-table tbody input:hidden.amount').each(function () {
            amount += parseFloat($(this).val());
        });

        $('#add-fee-table tbody input:hidden.discount').each(function () {
            discount += parseFloat($(this).val());
        });

        $('#add-fee-table tbody input:hidden.total').each(function () {
            total += parseFloat($(this).val());
        });

        $('#total_amount_td').text(parseFloat(amount).toFixed(2));
        $('#total_discount_td').text(parseFloat(discount).toFixed(2));
        $('#total_payable_td').text(parseFloat(total).toFixed(2));
    }

    $(document).on('click', '#add-fee', function (e) {
        e.preventDefault();

        var $title = $('#fee_title');
        var $amount = $('#fee_amount');
        var $discount_type = $('#fee_discount_type');
        var $discount_value = $('#fee_discount_value');

        var title = $title.val();
        var amount = $amount.val();
        var discount_type = $discount_type.val();
        var discount_value = $discount_value.val();

        if (!title) {
            alert('Enter fee type');
            return;
        }

        if (!amount) {
            alert('Enter fee amount');
            return;
        }

        if (isNaN(amount) || 0 >= amount) {
            alert('Fee amount should be a number and greater than zero.');
            return;
        }

        if (discount_value && !discount_type) {
            alert('Select discount type');
            return;
        }

        if (discount_value && isNaN(discount_value)) {
            alert('Discount should be a number');
            return;
        }

        var discount = 0;
        var total = amount = parseFloat(amount).toFixed(2);

        if (discount_value = parseFloat(discount_value).toFixed(2)) {
            if (discount_type === 'fixed') {
                discount = discount_value;
            }

            if (discount_type === 'percentage') {
                discount = amount * discount_value / 100;
            }

            discount = parseFloat(discount).toFixed(2);
            total = parseFloat(amount - discount).toFixed(2);
        }

        if (0 >= total) {
            alert('Discount should be less than fee amount');
            return;
        }

        if ($('#add-fee-table tbody tr#blank_row_tr').length) {
            $('#add-fee-table tbody tr#blank_row_tr').remove();
        }

        $('#add-fee-table tbody').append(
            new_row_template(title, amount, discount_type, discount_value, discount, total)
        );

        $title.val('');
        $amount.val('');
        $discount_type.val('');
        $discount_value.val('');
        calculate_total();
    });

    $(document).on('click', '.remove_fee', function (e) {
        e.preventDefault();
        $(this).parents('tr').remove();
        calculate_total();
    });

    $(document).on('submit', '#add-fee-form', function (e) {
        if ($('[name="student_name"]').val().trim() === '') {
            alert('Select a student before adding fee');
            return;
        }
        if ($('#add-fee-table tbody tr:not(#blank_row_tr)').length == 0) {
            alert('Add fee before submit.');
            e.preventDefault();
            return;
        }
        return true;
    });

    $(document).on('change', '#add-edit-fee-head [name="type"], #add-edit-fee-head [name="class_id"]', function (e) {
        var $from = $('#add-edit-fee-head');
        var type = $from.find('[name="type"] option:selected').text();
        var class_name = $from.find('[name="class_id"] option:selected').text();
        $from.find('[name="title"]').val(type + ' - ' + class_name);
    });

    if (window.fee_items && window.fee_items.length > 0) {
        if ($('#add-fee-table tbody tr#blank_row_tr').length) {
            $('#add-fee-table tbody tr#blank_row_tr').remove();
        }
        for (var j = 0; j < window.fee_items.length; j++) {
            var row = window.fee_items[j];
            $('#add-fee-table tbody').append(
                new_row_template(row.title, row.amount, row.discount_type, row.discount_value, row.discount, row.total)
            );
        }
        calculate_total();
    }
}(jQuery));

