<?php
$user = $user ?? [];
?>

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control"
           value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
    <?php if (!empty($errors['name'])): ?>
        <div class="text-danger"><?= htmlspecialchars($errors['name']) ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control"
           value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
    <?php if (!empty($errors['username'])): ?>
        <div class="text-danger"><?= htmlspecialchars($errors['username']) ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
           value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
    <?php if (!empty($errors['email'])): ?>
        <div class="text-danger"><?= htmlspecialchars($errors['email']) ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control"
           value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
    <?php if (!empty($errors['phone'])): ?>
        <div class="text-danger"><?= htmlspecialchars($errors['phone']) ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Website</label>
    <input type="text" name="website" class="form-control"
           value="<?= htmlspecialchars($user['website'] ?? '') ?>" required>
    <?php if (!empty($errors['website'])): ?>
        <div class="text-danger"><?= htmlspecialchars($errors['website']) ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Profile Image</label>
    <input type="file" name="image" class="form-control">
    <?php if (!empty($user['image'])): ?>
        <div class="mt-2">
            <img src="users/images/<?= rawurlencode($user['image']) ?>"
                 alt="User Image" class="img-thumbnail" width="120">
        </div>
    <?php endif; ?>
</div>
