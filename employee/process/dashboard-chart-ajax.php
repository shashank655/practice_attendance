<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/StudentAttendance.php';
require_once '../class/CommonFunction.php';

function __dashToCamelCase($string) {
    return lcfirst(str_replace('-', '', ucwords($string, '-')));
}

function getStudentMonthlyCartData() {
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;

    $attendance = new StudentAttendance();
    $total = $attendance->getStudentMonthlyAttendence($class_id, $section_id);
    $present = $attendance->getStudentMonthlyAttendence($class_id, $section_id, 'P');

    $results = [];
    $year = date('Y');
    $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    foreach ($months as $month_index) {
        $month = $year . '-' . $month_index;
        $value = 0;
        if ( isset($total[$month]) && $present[$month]) {
            $value = round($present[$month] / $total[$month] * 100, 2);
        }

        array_push($results, compact('month', 'value'));
    }

    header('Content-type: application/json');
    echo json_encode($results);
}

if ( isset($_GET['action'])  ) {
    $function = __dashToCamelCase($_GET['action']);
    if ( function_exists($function) ) {
        return $function();
    }
}
