<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Profile
                    </h2>
                    <p class="card-text">Update your personal information and settings.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Profile Information
                    </h5>
                    <a href="<?= APP_URL ?>/player/<?= $player['id'] ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to Profile
                    </a>
                </div>
                <div class="card-body">
                    <!-- Profile Photo -->
                    <div class="text-center mb-4">
                        <?php if ($player['photo_url']): ?>
                            <img src="<?= APP_URL ?>/public/uploads/<?= $player['photo_url'] ?>" 
                                alt="<?= htmlspecialchars($player['name']) ?>" 
                                class="player-photo mb-3">
                        <?php else: ?>
                            <div class="player-photo bg-primary text-white d-flex align-items-center justify-content-center mb-3">
                                <?= strtoupper(substr($player['name'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= APP_URL ?>/player/upload-photo" method="POST" enctype="multipart/form-data" class="d-inline">
                            <div class="input-group">
                                <input type="file" class="form-control" name="photo" accept="image/*" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>Upload Photo
                                </button>
                            </div>
                            <?php if (isset($_SESSION['form_errors']['photo'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['photo'] ?>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Profile Form -->
                    <form action="<?= APP_URL ?>/player/edit-profile" method="POST" data-validate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="<?= $_SESSION['form_data']['name'] ?? $player['name'] ?>">
                            <?php if (isset($_SESSION['form_errors']['name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="<?= $_SESSION['form_data']['email'] ?? $player['email'] ?>">
                            <?php if (isset($_SESSION['form_errors']['email'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3">Change Password</h5>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <?php if (isset($_SESSION['form_errors']['current_password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['current_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                            <?php if (isset($_SESSION['form_errors']['new_password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['new_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            <?php if (isset($_SESSION['form_errors']['confirm_password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['confirm_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Clear form data and errors
unset($_SESSION['form_data'], $_SESSION['form_errors']);
?> 