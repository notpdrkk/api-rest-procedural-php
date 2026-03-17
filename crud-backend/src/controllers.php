<?php

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
    try {
        echo json_encode(getAllUsers($dataFile));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => '...']);
    }
}

function handlePost(string $dataFile)
{

    try {
        $input = json_decode(file_get_contents('php://input', true));
        respond(createUser($dataFile, $input));
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}
