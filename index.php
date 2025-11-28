<?php
require 'users/users.php';


// Handle form submission for creating a new user via modal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {

    $newUser = [
        'name'     => $_POST['name'],
        'username' => $_POST['username'],
        'email'    => $_POST['email'],
        'phone'    => $_POST['phone'],
        'website'  => $_POST['website'],
    ];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploaded = uploadImage($_FILES['image']);
        if ($uploaded) {
            $newUser['image'] = $uploaded;
        }
    }

    createUser($newUser);
    header('Location: index.php'); 
    exit;
}

// Fetch all users
$users = getUsers();
$pageTitle = "Users List";

require 'partials/header.php';
?>

<h2 class="mb-4 text-center">Users List</h2>

<!-- Create User Button (opens modal) -->
<div class="mb-3 text-end">
    <a href="create.php" class="btn btn-success">
        + Create User
    </a>
</div>


<!-- Users Table -->
<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <?php if (!empty($user['image'])): ?>
                                <img src="users/images/<?= rawurlencode($user['image']) ?>" 
                                     alt="User Image" 
                                     class="rounded-circle"
                                     width="50" height="50">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>

                        <td>
                            <a href="https://<?= htmlspecialchars($user['website']) ?>" target="_blank">
                                <?= htmlspecialchars($user['website']) ?>
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="view.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">View</a>
                            <a href="update.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary">Update</a>
                            <a href="delete.php?id=<?= $user['id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this user?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>


<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="create_user" value="1">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <?php require 'partials/user_form.php'; ?>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Create User</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </form>
  </div>
</div>

<?php require 'partials/footer.php'; ?>
