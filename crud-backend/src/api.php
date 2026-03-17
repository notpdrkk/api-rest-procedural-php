<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/controllers.php';

$method = $_SERVER['REQUEST_METHOD'];

match ($method) {
    'GET' => handleGet($dataFile),
    'POST' => handlePost($dataFile),
};
