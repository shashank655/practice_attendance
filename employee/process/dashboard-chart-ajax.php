<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Student.php';
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

function getMonthlyAttendenceStudentWise() {
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;
    $month_index = isset($_GET['month_index']) ? $_GET['month_index'] : 0;

    $month_index = sprintf('%02d', ($month_index + 1));
    $year = date('Y');
    $month = $year . '-' . $month_index;

    $attendance = new StudentAttendance();
    $totals = $attendance->getMonthlyAttendenceStudentWise($class_id, $section_id, $month);
    $presents = $attendance->getMonthlyAttendenceStudentWise($class_id, $section_id, $month, 'P');

    $students =  (new Student())->getStudentClassSectionWise($class_id, $section_id);

    $results = [];

    foreach ($students as $student_id => $name) {
        $value = 0;
        $total = 0;
        $present = 0;
        if ( isset($totals[$student_id]) && isset($presents[$student_id]) ) {
            $total = $totals[$student_id];
            $present = $presents[$student_id];
            $value = round($present / $total * 100, 2);
        }
        array_push($results, compact('name', 'value', 'total', 'present'));
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
