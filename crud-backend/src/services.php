<?php

require __DIR__ . '/data.php';
require __DIR__ . '/validation.php';

function getAllUsers(string $dataFile): array
{
    $data = findAllUsers($dataFile);
    return ['users' => $data['users']];
}

function createUser(string $dataFile, ?array $input)
{
    if (!is_array($input)) {
        return ['error' => 'Invalid Json Body', 'status' => 400];
    }

    $error = validatedRequiredFields($input, ['name', 'age', 'email']);

    if ($error) {
        return ['error' => $error, 'status' => 400];
    }

    $error = validatedUserFields($input);
    if ($error) {
        return ['error' => $error, 'status' => 400];
    }

    $user = insertUser($dataFile, [
        'name' => trim($input['name']),
        'age' => (int) $input['age'],
        'email' => $input['email'],
    ]);

    return (['data' => $user, 'status' => 201]);
}

function editUser(string $dataFile, ?int $id, ?array $input, bool $partial = false): array
{
    if ($id === null) {
        return ['error' => 'User id is required', 'status' => 400];
    }

    if (!is_array($input)) {
        return ['error' => 'Invalid JSON body', 'status' => 400];
    }

    if (!$partial) {
        $error = validatedRequiredFields($input, ['name', 'age', 'email']);
        if ($error) {
            return ['error' => $error, 'status' => 400];
        }
    }

    $error = validatedUserFields($input);
    if ($error) {
        return ['error' => $error, 'status' => 400];
    }

    $allowed = ['name', 'age', 'email'];
    $fields = array_intersect_key($input, array_flip($allowed));

    if (isset($fields['name'])) {
        $fields['name'] = trim($fields['name']);
    }

    if (isset($fields['age'])) {
        $fields['age'] = trim($fields['age']);
    }

    $user = updateUser($dataFile, $id, $fields);

    if ($user === null) {
        return ['error' => 'User not found', 'status' => 404];
    }

    return ['data' => $user, 'status' => 200];
}
