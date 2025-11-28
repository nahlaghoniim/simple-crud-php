<?php
// users/users.php

// Path to JSON file (one level up from this folder)
define('USER_JSON_FILE', __DIR__ . '/../users.json');

/**
 * Get all users
 */
function getUsers() {
    if (!file_exists(USER_JSON_FILE)) {
        file_put_contents(USER_JSON_FILE, json_encode([]));
    }
    return json_decode(file_get_contents(USER_JSON_FILE), true);
}

/**
 * Save users array to JSON
 */
function saveUsers($users) {
    file_put_contents(USER_JSON_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

/**
 * Get user by ID
 */
function getUserById($id) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['id'] == $id) return $user;
    }
    return null;
}

/**
 * Create a new user
 */
function createUser($data) {
    $users = getUsers();
    $data['id'] = !empty($users) ? end($users)['id'] + 1 : 1;
    $users[] = $data;
    saveUsers($users);
}

/**
 * Update an existing user
 */
function updateUser($data, $id) {
    $users = getUsers();
    foreach ($users as $index => $user) {
        if ($user['id'] == $id) {
            $users[$index] = array_merge($user, $data);
            saveUsers($users);
            return true;
        }
    }
    return false;
}

/**
 * Delete a user by ID
 */
function deleteUser($id) {
    $users = getUsers();
    foreach ($users as $index => $user) {
        if ($user['id'] == $id) {
            array_splice($users, $index, 1);
            saveUsers($users);
            return true;
        }
    }
    return false;
}

/**
 * Upload an image and return the filename or null
 */
function uploadImage($file) {
    if (!isset($file) || $file['error'] !== 0) return null;

    // Save inside users/images/
    $uploadDir = __DIR__ . '/images/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = time() . '_' . uniqid() . '.' . $ext;
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) return $fileName;
    return null;
}
function validateUser(&$user, &$errors) {
    $isValid = true;
    $errors = [];

    // Name
    if (empty($user['name'])) {
        $isValid = false;
        $errors['name'] = 'Name is mandatory';
    }

    // Username
    if (empty($user['username']) || strlen($user['username']) < 6 || strlen($user['username']) > 16) {
        $isValid = false;
        $errors['username'] = 'Username is required and must be 6-16 characters';
    }

    // Email
    if (empty($user['email']) || !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $errors['email'] = 'This must be a valid email address';
    }

    // Phone (simple numeric check)
    if (empty($user['phone']) || !preg_match('/^\+?\d{7,15}$/', $user['phone'])) {
        $isValid = false;
        $errors['phone'] = 'This must be a valid phone number';
    }

    // Website
    if (!empty($user['website'])) {
        if (!preg_match('#^https?://#', $user['website'])) {
            $user['website'] = 'http://' . $user['website'];
        }
        if (!filter_var($user['website'], FILTER_VALIDATE_URL)) {
            $isValid = false;
            $errors['website'] = 'This must be a valid website URL';
        }
    }

    return $isValid;
}
