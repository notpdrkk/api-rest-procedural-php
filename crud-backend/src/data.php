<?php

function loadData(string $dataFile)
{
    return json_decode(file_get_contents($dataFile), true);
}

function saveData(string $dataFile, array $data)
{
    file_put_contents(
        $dataFile,
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}

function findAllUsers(string $dataFile): array
{
    return loadData($dataFile);
}

function insertUser(string $dataFile, array $user): array
{
    $data = loadData($dataFile);

    $id = $data['nextId'] ?? 1;
    $data['nextId'] = $id + 1;
    $user['id'] = $id;
    $data['users'][] = $user;

    saveData($dataFile, $data);
    return $user;
}
