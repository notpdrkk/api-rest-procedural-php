<?php

require_once __DIR__ . '/services.php';

function respond(array $result)
{
    http_response_code($result['status']);

    if (isset($result['error'])) {
        echo json_encode(['error' => $result['error']]);
    } else {
        echo json_encode($result['data']);
    }
}

function handleGet($dataFile)
{
    echo json_encode(getAllUsers($dataFile));
}

function handlePost(string $dataFile): void
{
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        respond(createUser($dataFile, $input));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handlePut(string $dataFile): void
{
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        respond(editUser($dataFile, $id, $input));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handlePatch(string $dataFile): void
{
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        respond(editUser($dataFile, $id, $input, partial: true));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handleDelete(string $dataFile): void
{
    try {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        respond(removeUser($dataFile, $id));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error', 'status' => 500]);
    }
}

function handleMethodNotAllowed()
{
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
