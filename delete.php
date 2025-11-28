<?php
require 'users/users.php'; 

$userId = $_GET['id'] ?? null;

if ($userId !== null) {
    deleteUser($userId);
}

header('Location: index.php');
exit;
