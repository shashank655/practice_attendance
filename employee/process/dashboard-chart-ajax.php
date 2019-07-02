<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/StudentAttendance.php';
require_once '../class/ClassSections.php';
require_once '../class/CommonFunction.php';

function actionToFunctionName($string) {
    return 'get' . str_replace('-', '', ucwords($string, '-'));
}

function getStudentMonthlyCartData() {
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;

    $attendance = new StudentAttendance();
    $total = $attendance->getStudentMonthlyAttendence($class_id, $section_id);
    $present = $attendance->getStudentMonthlyAttendence($class_id, $section_id, 'P');

    $results = [];
    $year = date('Y');
    for ($i = 1; $i < 13; $i++) {
        $month_index = sprintf('%02d', $i);
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

function getStudentDailyCartData() {
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;
    $month_index = isset($_GET['month_index']) ? $_GET['month_index'] : 0;

    $month_index = sprintf('%02d', ($month_index + 1));
    $year = date('Y');
    $month = $year . '-' . $month_index;

    $attendance = new StudentAttendance();
    $total = $attendance->getStudentDailyAttendence($class_id, $section_id, $month);
    $present = $attendance->getStudentDailyAttendence($class_id, $section_id, $month, 'P');

    $results = [];
    $days_count = cal_days_in_month (CAL_GREGORIAN, $month_index , $year) + 1;
    for ($i = 1; $i < $days_count; $i++) {
        $day = $month . '-' . sprintf('%02d', $i);
        $value = 0;
        if ( isset($total[$day]) && $present[$day]) {
            $value = round($present[$day] / $total[$day] * 100, 2);
        }

        array_push($results, compact('day', 'value'));
    }

    header('Content-type: application/json');
    echo json_encode($results);
}

function getClassSections() {
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $sections = new ClassSections();
    $results = $sections->getClassSections($class_id);

    header('Content-type: application/json');
    echo json_encode($results);
}

if ( isset($_GET['action'])  ) {
    $function = actionToFunctionName($_GET['action']);
    if ( function_exists($function) ) {
        return $function();
    }
}
