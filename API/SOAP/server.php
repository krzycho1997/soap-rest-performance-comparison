<?php
// turn off WSDL caching
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../Data/DataProvider.php';
require_once '../../Data/Model/FinanceCourseDTO.php';

function GetAllFinanceCourses()
{
    return (new DataProvider())->getAllFinancialCoursesData();
}

// initialize SOAP Server
//libxml_disable_entity_loader(false);
//$server = new SoapServer(__DIR__ . "/sample.wsdl", [
$server = new SoapServer(__DIR__ . '/finance_courses.wsdl', [
//    'classmap' => [
//        'book' => 'Book', // 'book' complex type in WSDL file mapped to the Book PHP class
//        'page' => 'Page', // 'page' complex type in WSDL file mapped to the Book PHP class
//    ]
]);

// register available functions
$server->addFunction('GetAllFinanceCourses');

// start handling requests
$server->handle();
