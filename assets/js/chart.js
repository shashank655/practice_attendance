// Chart

(function() {
    'use strict';
    var colorsDash = ['#0b2035', '#4e87c0' ,'#086ed5'];
    Morris.Donut({
        element: 'school-chart',
        colors: colorsDash,
        resize: true,
        labels: ['Series A', 'Series B','Series C'],
        data: [
            {label: "Students", value: totalStudent},
            {label: "Teachers", value: totalTeacher},
            {label: "Parents", value: totalStudent}
        ],
        xkey: 'label',
        ykeys: ['value'],
        labels: ['Value']
    });
}());

(function($) {
    'use strict';

    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var studentMonthlyCart = new Morris.Line({
        element: 'incomeChart',
        data: [],
        xkey: 'month',
        ykeys: ['value'],
        labels: ['Value'],
        lineColors: ['#36597c'],
        lineWidth: 4,
        pointSize: 6,
        pointFillColors:['rgba(255,255,255,0.9)'],
        pointStrokeColors: ['#01c0c8'],
        gridLineColor: 'rgba(0,0,0,.5)',
        resize: true,
        gridTextColor: '#36597c',
        xLabelFormat: function (x) {
             return months[x.getMonth()];
        }
    });

    var studentDailyCart = new Morris.Line({
        element: 'daily-student-attendance-cart',
        data: [],
        xkey: 'day',
        ykeys: ['value'],
        labels: ['Value'],
        lineColors: ['#36597c'],
        lineWidth: 4,
        pointSize: 6,
        pointFillColors:['rgba(255,255,255,0.9)'],
        pointStrokeColors: ['#01c0c8'],
        gridLineColor: 'rgba(0,0,0,.5)',
        resize: true,
        gridTextColor: '#36597c',
        xLabelFormat: function (x) {
            return x.getDate();
        }
    });

    function getStudentMonthlyCartData(class_id = '', section_id = '') {
        $.ajax({
            type: 'GET',
            url: '/employee/process/dashboard-chart-ajax.php',
            data: {
                class_id: class_id,
                section_id: section_id,
                action: 'student-monthly-cart-data'
            },
            success: function (res) {
                studentMonthlyCart.setData(res);
            }
        });
    }

    function getStudentDailyCartData(class_id = '', section_id = '', month_index) {
        $.ajax({
            type: 'GET',
            url: '/employee/process/dashboard-chart-ajax.php',
            data: {
                class_id: class_id,
                section_id: section_id,
                month_index: month_index,
                action: 'student-daily-cart-data'
            },
            success: function (res) {
                studentDailyCart.setData(res);
            }
        });
    }

    function getClassSections(class_id = '') {
        $.ajax({
            type: 'GET',
            url: '/employee/process/dashboard-chart-ajax.php',
            data: {
                class_id: class_id,
                action: 'class-sections'
            },
            beforeSend: function () {
                $('#monthly-student-attendance-section-id option').remove();
            },
            success: function (res) {
                $.each(res, function(key, section) {
                    $(new Option(section['section'], section['id'])).appendTo('#monthly-student-attendance-section-id');
                });
            },
            complete: function () {
                $('#monthly-student-attendance-section-id').trigger('change');
            }
        });
    }

    $(document).on('change', '#monthly-student-attendance-class-id', function () {
        getClassSections( $(this).val() );
    });

    $(document).on('change', '#monthly-student-attendance-section-id', function () {
        var section_id = $(this).val();
        var class_id = $('#monthly-student-attendance-class-id').val();
        getStudentMonthlyCartData(class_id, section_id);
    });

    $(document).on('click', '#incomeChart > svg > circle', function () {
        var month_index = $('#incomeChart > svg > circle').index(this);
        var month_name = months[month_index];
        var $modal = $('#daily-student-attendance-cart-modal');
        var class_id = $('#monthly-student-attendance-class-id').val();
        var section_id = $('#monthly-student-attendance-section-id').val();
        getStudentDailyCartData(class_id, section_id, month_index);
        $modal.find('.modal-title').text('Daily Attendance for the month of ' + month_name);
        $modal.modal('show');
    });

    getClassSections( $('#monthly-student-attendance-class-id').val() );
}(jQuery));
