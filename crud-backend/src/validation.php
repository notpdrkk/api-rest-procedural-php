<?php

function validatedRequiredFields(array $input, array $fields): ?string
{
    $missing = [];

    foreach ($fields as $field) {
        if (!isset($input[$field])) {
            $missing[] = $field;
        }
    }

    if (!empty($missing)) {
        return implode(', ', $missing) . ' are required';
    }

    return null;
}

function validatedUserFields(array $input): ?string
{
    if (isset($input['age'])) {
        if (!is_numeric($input['age'])) return 'Age must be a number';
        $age = (int) $input['age'];
        if ($age < 1 || $age > 150) return 'Age must be between 1 and 150';
    }

    if (isset($input['email'])) {
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL))
            return 'Invalid email format';
    }

    return null;
}
