<?php
require 'users/users.php';

$userId = $_GET['id'] ?? null;

if ($userId === null) {
    header('Location: index.php');
    exit;
}

$user = getUserById($userId);

$pageTitle = "View User – " . ($user['username'] ?? '');
require 'partials/header.php';

// If user does not exist → include not_found and stop
if (!$user) {
    require 'partials/not_found.php';
    require 'partials/footer.php';
    exit;
}
?>

<h2 class="mb-4">User Details – <?= htmlspecialchars($user['name']) ?></h2>

<div class="card shadow-sm">
    <div class="card-body">

        <?php if (!empty($user['image'])): ?>
            <div class="text-center mb-4">
                <img src="users/images/<?= rawurlencode($user['image']) ?>" 
                     alt="User Image" 
                     class="rounded-circle" 
                     width="150" 
                     height="150">
            </div>
        <?php else: ?>
            <div class="text-center mb-4">
                <span class="text-muted">No Image</span>
            </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <tr>
                <th width="20%">Name</th>
                <td><?= htmlspecialchars($user['name']) ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= htmlspecialchars($user['username']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?= htmlspecialchars($user['phone']) ?></td>
            </tr>
            <tr>
                <th>Website</th>
                <td>
                    <a href="https://<?= htmlspecialchars($user['website']) ?>" target="_blank">
                        <?= htmlspecialchars($user['website']) ?>
                    </a>
                </td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Back</a>
            <a href="update.php?id=<?= $user['id'] ?>" class="btn btn-primary">Update</a>
            <a href="delete.php?id=<?= $user['id'] ?>" 
               class="btn btn-danger"
               onclick="return confirm('Are you sure you want to delete this user?')">
               Delete
            </a>
        </div>

    </div>
</div>

<?php require 'partials/footer.php'; ?>
