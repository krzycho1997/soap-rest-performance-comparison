<?php

require_once '../../Data/DataProvider.php';
require_once '../../Data/Model/FinanceCourseDTO.php';

$data = (new DataProvider())->getAllFinancialCoursesData();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
