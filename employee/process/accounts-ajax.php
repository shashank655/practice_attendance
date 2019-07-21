<?php
require_once '../config/config.php';
require_once '../class/dbclass.php';
require_once '../class/Student.php';
require_once '../class/Sections.php';
require_once '../class/FeeGroups.php';

function actionToFunctionName($string) {
    return 'get' . str_replace('-', '', ucwords($string, '-'));
}

function getSections() {
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $sections = new Sections;
    $fetch_data = $sections->getSections($class_id);
    header('Content-type: application/json');
    echo json_encode($fetch_data);
}

function getStudentsWithFeeGroups() {
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    $section_id = isset($_GET['section_id']) ? $_GET['section_id'] : null;
    $students = new Student;
    $allStudents = $students->getStudents($class_id, $section_id);
    $feeGroups = new FeeGroups;
    $allFeeGroups = $feeGroups->getFeeGroups($class_id, $section_id);
    header('Content-type: application/json');
    echo json_encode(['students' => $allStudents, 'fee_groups' => $allFeeGroups]);
}

if ( isset($_GET['action'])  ) {
    $function = actionToFunctionName($_GET['action']);
    if ( function_exists($function) ) {
        return $function();
    }
}
