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