<?php
require 'users/users.php';

$errors = [];
$user = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = [
        'name' => trim($_POST['name'] ?? ''),
        'username' => trim($_POST['username'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'website' => trim($_POST['website'] ?? ''),
    ];

    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploaded = uploadImage($_FILES['image']);
        if ($uploaded) $user['image'] = $uploaded;
    }

    if (validateUser($user, $errors)) {
        createUser($user);
        header('Location: index.php');
        exit;
    }
}

$pageTitle = "Create User";
require 'partials/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Create New User</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php require 'partials/user_form.php'; ?>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Create User</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require 'partials/footer.php'; ?>
