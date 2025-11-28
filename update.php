<?php
require 'users/users.php';

$userId = $_GET['id'] ?? null;
$user = getUserById($userId);

if (!$user) {
    $pageTitle = "User Not Found";
    require 'partials/header.php';
    require 'partials/not_found.php';
    require 'partials/footer.php';
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'name' => trim($_POST['name'] ?? ''),
        'username' => trim($_POST['username'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'website' => trim($_POST['website'] ?? ''),
    ];

    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploaded = uploadImage($_FILES['image']);
        if ($uploaded) $updatedData['image'] = $uploaded;
    }

    if (validateUser($updatedData, $errors)) {
        updateUser($updatedData, $userId);
        header("Location: view.php?id=$userId");
        exit;
    }

    // Merge back for pre-filling form
    $user = array_merge($user, $updatedData);
}

$pageTitle = "Update User – " . htmlspecialchars($user['username']);
require 'partials/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Update User – <?= htmlspecialchars($user['username']) ?></h2>

    <form method="POST" enctype="multipart/form-data">
        <?php require 'partials/user_form.php'; ?>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="view.php?id=<?= $userId ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require 'partials/footer.php'; ?>
