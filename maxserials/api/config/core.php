<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);


// set your default time-zone
date_default_timezone_set( 'Europe/Moscow' );
 
// variables used for jw
$key = "example_key";
$iss = "http://example.org";
$aud = "http://example.com";
$iat = 1356999524;
$nbf = 1357000000;

  
// home page url
$home_url="http://localhost/prj/api/";
  
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// set number of records per page
$records_per_page = 5;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>