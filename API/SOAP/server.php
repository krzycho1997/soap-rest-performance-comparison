<?php
// turn off WSDL caching
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../Data/DataProvider.php';
require_once '../../Data/Model/FinanceCourseDTO.php';

// model, which uses in web service functions as parameter
//exec('pwd', $o);
//echo $o;
class Page
{
    public $count;
}

class Book
{
    public $name;
    public $year;
    public Page $page;
}

/**
 * Determines published year of the book by name.
 * @param Book $book book instance with name set.
 * @return Book|null published year of the book or 0 if not found.
 */
function BookYear($book)
{
    // list of the books
    $_books = [
        ['name' => 'test 1', 'year' => 2011, 'pageCount' => 135],
        ['name' => 'test 2', 'year' => 2012, 'pageCount' => 333],
        ['name' => 'test 3', 'year' => 2013, 'pageCount' => 582],
    ];
    // search book by name
    foreach ($_books as $bk) {
        if ($bk['name'] == $book->name) {

            $page = new Page();
            $page->count = $bk['pageCount'];

            $book = new Book();
            $book->page = $page;
            $book->name = $bk['name'];
            $book->year = $bk['year'];

            return $book; // book found
        }
    }

//    $page = new Page();
//    $page->count = 123;
//
//    $book = new Book();
//    $book->name = 'Testoowa';
//    $book->year = 1997;
//    $book->page = $page;

//    return $book; // book found

    return null; // book not found
}

function GetAllBooks()
{
    $page = new Page();
    $page->count = 123;

    $book = new Book();
    $book->name = 'Testoowa';
    $book->year = 1997;
    $book->page = $page;

    $page1 = new Page();
    $page1->count = 123;

    $book1 = new Book();
    $book1->name = 'Testoowa';
    $book1->year = 1997;
    $book1->page = $page1;

    return [$book, $book1];

//    return [
//        $book,
//        $book,
//        $book,
//    ];
}

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
$server->addFunction('BookYear');
$server->addFunction('GetAllBooks');
$server->addFunction('GetAllFinanceCourses');

// start handling requests
$server->handle();
