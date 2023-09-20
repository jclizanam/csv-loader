<?php

// ALLOWING REQUESTS FROM LOCAL HOST.
//TODO REMOVE THIS ON PRODUCTION ENV
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/routes.php';
