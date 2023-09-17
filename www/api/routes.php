<?php
/**
 * Used to store api routes
 */
$routes = array();
$routes["api/upload"] = "api_controller#upload";
$routes["api/employees"] = "api_controller#employees";
$routes["api/companies/average-salary"] = "api_controller#companiesAverageSalary";
$routes["api/employee/:id"] = "api_controller#updateEmployee";


// Handle routes
include_once $_SERVER['DOCUMENT_ROOT'] . '/_process_routes.php';

?>