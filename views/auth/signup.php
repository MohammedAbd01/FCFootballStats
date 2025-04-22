<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">Create Your Account</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= APP_URL ?>/signup" data-validate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name" required
                                    value="<?= $_SESSION['form_data']['name'] ?? '' ?>">
                            </div>
                            <?php if (isset($_SESSION['form_errors']['name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" required
                                    value="<?= $_SESSION['form_data']['email'] ?? '' ?>">
                            </div>
                            <?php if (isset($_SESSION['form_errors']['email'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" required
                                    minlength="6">
                            </div>
                            <?php if (isset($_SESSION['form_errors']['password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="confirm_password" 
                                    name="confirm_password" required>
                            </div>
                            <?php if (isset($_SESSION['form_errors']['confirm_password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['confirm_password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Sign Up
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small">
                        Already have an account? 
                        <a href="<?= APP_URL ?>/login" class="text-primary">Login here!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Clear form data and errors
unset($_SESSION['form_data'], $_SESSION['form_errors']);
?> 