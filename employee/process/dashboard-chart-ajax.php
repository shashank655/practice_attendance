<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Student.php';
require_once '../class/StudentAttendance.php';
require_once '../class/ClassSections.php';
require_once '../class/CommonFunction.php';
require_once '../class/Teacher.php';

function actionToFunctionName($string)
{
    return 'get' . str_replace('-', '', ucwords($string, '-'));
}

function getStudentMonthlyCartData()
{
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;

    $common_function = new CommonFunction();

    $holidays = $common_function->getHolidaysDates();
    $working_days = getWorkingDays(['Sunday'], $holidays);

    $students_count = $common_function->studentsCount($class_id, $section_id);
    $attendance = (new StudentAttendance())->getStudentMonthlyAttendence($class_id, $section_id, 'P');

    $results = [];
    foreach ($working_days as $month => $days) {
        $value = 0;
        if (isset($attendance[$month])) {
            $value = round(($attendance[$month] * 100) / ($days * $students_count), 2);
        }

        array_push($results, compact('month', 'value'));
    }

    header('Content-type: application/json');
    echo json_encode($results);
}

function getMonthlyAttendenceStudentWise()
{
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;
    $month_index = isset($_GET['month_index']) ? $_GET['month_index'] : 0;

    $month = date('Y') . '-' . sprintf('%02d', ($month_index + 1));

    $students =  (new Student())->getStudentClassSectionWise($class_id, $section_id);
    $attendance = (new StudentAttendance())->getMonthlyAttendenceStudentWise($class_id, $section_id, $month, 'P');

    $holidays = (new CommonFunction())->getHolidaysDates();
    $working_days = getWorkingDays(['Sunday'], $holidays);
    $total = $working_days[$month];

    $results = [];
    foreach ($students as $student_id => $name) {
        $value = 0;
        $present = 0;
        if (isset($attendance[$student_id])) {
            $present = $attendance[$student_id];
            $value = round(($present * 100) / $total , 2);
        }
        array_push($results, compact('name', 'value', 'total', 'present'));
    }

    header('Content-type: application/json');
    echo json_encode($results);
}

function getClassSections()
{
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $results = (new ClassSections())->getClassSections($class_id);

    header('Content-type: application/json');
    echo json_encode($results);
}

function getWorkingDays(array $skipdays = ['Sunday'], array $skipdates = [])
{
    $results = [];
    $starttime = strtotime('First Day Of January this Year');
    $endtime = strtotime('Last Day Of December this Year');

    for ($i = 1; $i < 13; $i++) {
        $results[date('Y-m', mktime(0, 0, 0, $i))] = 0;
    }

    for ($i = 0; $i < (($endtime - $starttime) / 86400); $i++) {
        $timestamp = $starttime + ($i * 86400);
        if ((in_array(date('l', $timestamp), $skipdays)) || (in_array(date('Y-m-d', $timestamp), $skipdates))) {
            continue;
        }
        $results[date('Y-m', $timestamp)]++;
    }
    return $results;
}

function getTeacherMonthlyCartData()
{
    $common_function = new CommonFunction();
    $holidays = $common_function->getHolidaysDates();
    $working_days = getWorkingDays(['Sunday'], $holidays);

    $teachers_count = $common_function->teachersCount();
    $attendance = (new Teacher())->getTeacherMonthlyAttendence();

    $results = [];
    foreach ($working_days as $month => $days) {
        $attendance_month = null;
        $value = 0;
        if (isset($attendance[$month])) {
            $value = round(($attendance[$month] * 100) / ($days * $teachers_count), 2);
        }

        array_push($results, compact('month', 'value'));
    }

    header('Content-type: application/json');
    echo json_encode($results);
}

function getMonthlyAttendenceTeacherWise()
{
    $month_index = isset($_GET['month_index']) ? $_GET['month_index'] : 0;
    $month = date('Y') . '-' . sprintf('%02d', ($month_index + 1));

    $teacher = new Teacher();

    $teachers =  $teacher->getAllTeacher();
    $attendance = $teacher->getMonthlyAttendenceTeacherWise($month);

    $holidays = (new CommonFunction())->getHolidaysDates();
    $working_days = getWorkingDays(['Sunday'], $holidays);
    $total = $working_days[$month];

    $results = [];
    foreach ($teachers as $teacher_id => $name) {
        $value = 0;
        $present = 0;
        if (isset($attendance[$teacher_id])) {
            $present = $attendance[$teacher_id];
            $value = round(($present * 100) / $total , 2);
        }
        array_push($results, compact('name', 'value', 'total', 'present'));
    }

    header('Content-type: application/json');
    echo json_encode($results);
}

if (isset($_GET['action'])) {
    $function = actionToFunctionName($_GET['action']);
    if (function_exists($function)) {
        return $function();
    }
}
