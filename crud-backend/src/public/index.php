<?php

require __DIR__ . "/../config/config.php";

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

in_array($origin, $alllowedOrigins) ?
    header("Access-Control-Allow-Origin: *") : null;
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'Options') {
    http_response_code(204);
    exit;
}

$uri = strtok($_SERVER['REQUEST_URI'], '?');

match ($uri) {
    '/api/users' => require __DIR__ . '/../api.php',
    'docs' => serveView(__DIR__ . '/../views/index.html'),
    'openapi.json' => serveJson(__DIR__ . '/../openapi.json'),
    default      => notFound(),
};

function notFound()
{
    http_response_code(204);
    echo json_encode(['error' => 'Not found']);
}

function serveJson(string $file): void
{
    header('Content-Type: application/json');
    echo file_get_contents($file);
}

function serveView(string $file): void
{
    header('Content-Type: text/html');
    echo file_get_contents($file);
}
