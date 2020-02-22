// Chart

(function () {
    'use strict';
    var colorsDash = ['#0b2035', '#4e87c0', '#086ed5'];
    Morris.Donut({
        element: 'school-chart',
        colors: colorsDash,
        resize: true,
        labels: ['Series A', 'Series B', 'Series C'],
        data: [
            { label: "Students", value: totalStudent },
            { label: "Teachers", value: totalTeacher },
            { label: "Parents", value: totalStudent }
        ],
        xkey: 'label',
        ykeys: ['value'],
        labels: ['Value']
    });
}());

(function ($) {
    'use strict';

    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var studentMonthlyAttendanceCart = new Morris.Line({
        element: 'studentMonthlyAttendanceCart',
        data: [],
        xkey: 'month',
        ykeys: ['value'],
        labels: ['Value'],
        lineColors: ['#36597c'],
        lineWidth: 4,
        pointSize: 6,
        pointFillColors: ['rgba(255,255,255,0.9)'],
        pointStrokeColors: ['#01c0c8'],
        gridLineColor: 'rgba(0,0,0,.5)',
        resize: true,
        gridTextColor: '#36597c',
        xLabelFormat: function (x) {
            return months[x.getMonth()];
        }
    });

    var teacherMonthlyAttendanceCart = new Morris.Line({
        element: 'teacherMonthlyAttendanceCart',
        data: [],
        xkey: 'month',
        ykeys: ['value'],
        labels: ['Value'],
        lineColors: ['#36597c'],
        lineWidth: 4,
        pointSize: 6,
        pointFillColors: ['rgba(255,255,255,0.9)'],
        pointStrokeColors: ['#01c0c8'],
        gridLineColor: 'rgba(0,0,0,.5)',
        resize: true,
        gridTextColor: '#36597c',
        xLabelFormat: function (x) {
            return months[x.getMonth()];
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
                studentMonthlyAttendanceCart.setData(res);
            }
        });
    }
    function getTeacherMonthlyCartData() {
        $.ajax({
            type: 'GET',
            url: '/employee/process/dashboard-chart-ajax.php',
            data: {
                action: 'teacher-monthly-cart-data'
            },
            success: function (res) {
                teacherMonthlyAttendanceCart.setData(res);
            }
        });
    }

    function getMonthlyAttendenceStudentWiseData(class_id = '', section_id = '', month_index) {
        $.ajax({
            type: 'GET',
            url: '/employee/process/dashboard-chart-ajax.php',
            data: {
                class_id: class_id,
                section_id: section_id,
                month_index: month_index,
                action: 'monthly-attendence-student-wise'
            },
            beforeSend: function () {
                $('#daily-student-attendance-progress .student').remove();
            },
            success: function (res) {
                $.each(res, function (index, value) {
                    $('#daily-student-attendance-progress').append(
                        '<div class="student mb-4"><label>' + value['name'] + ' (' + value['present'] + '/' + value['total'] + ')</label><div class="progress progress-md"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: ' + value['value'] + '%" aria-valuenow="' + value['value'] + '" aria-valuemin="0" aria-valuemax="100"></div></div></div>'
                    );
                });
            }
        });
    }

    function getMonthlyAttendenceTeacherWiseData(month_index) {
        $.ajax({
            type: 'GET',
            url: '/employee/process/dashboard-chart-ajax.php',
            data: {
                month_index: month_index,
                action: 'monthly-attendence-teacher-wise'
            },
            beforeSend: function () {
                $('#daily-teacher-attendance-progress .teacher').remove();
            },
            success: function (res) {
                $.each(res, function (index, value) {
                    $('#daily-teacher-attendance-progress').append(
                        '<div class="teacher mb-4"><label>' + value['name'] + ' (' + value['present'] + '/' + value['total'] + ')</label><div class="progress progress-md"><div class="progress-bar progress-bar-striped" role="progressbar" style="width: ' + value['value'] + '%" aria-valuenow="' + value['value'] + '" aria-valuemin="0" aria-valuemax="100"></div></div></div>'
                    );
                });
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
                $.each(res, function (key, section) {
                    $(new Option(section['section'], section['id'])).appendTo('#monthly-student-attendance-section-id');
                });
            },
            complete: function () {
                $('#monthly-student-attendance-section-id').trigger('change');
            }
        });
    }

    $(document).on('change', '#monthly-student-attendance-class-id', function () {
        getClassSections($(this).val());
    });

    $(document).on('change', '#monthly-student-attendance-section-id', function () {
        var section_id = $(this).val();
        var class_id = $('#monthly-student-attendance-class-id').val();
        getStudentMonthlyCartData(class_id, section_id);
    });

    $(document).on('click', '#studentMonthlyAttendanceCart > svg > circle', function () {
        var month_index = $('#studentMonthlyAttendanceCart > svg > circle').index(this);
        var month_name = months[month_index];
        var $modal = $('#daily-student-attendance-progress-modal');
        var class_id = $('#monthly-student-attendance-class-id').val();
        var section_id = $('#monthly-student-attendance-section-id').val();
        getMonthlyAttendenceStudentWiseData(class_id, section_id, month_index);
        $modal.find('.modal-title').text('Attendance for the month of ' + month_name);
        $modal.modal('show');
    });

    $(document).on('click', '#teacherMonthlyAttendanceCart > svg > circle', function () {
        var month_index = $('#teacherMonthlyAttendanceCart > svg > circle').index(this);
        var month_name = months[month_index];
        var $modal = $('#daily-teacher-attendance-progress-modal');
        getMonthlyAttendenceTeacherWiseData(month_index);
        $modal.find('.modal-title').text('Attendance for the month of ' + month_name);
        $modal.modal('show');
    });

    $('#monthly-student-attendance-class-id').trigger('change');
    getTeacherMonthlyCartData();
}(jQuery));
