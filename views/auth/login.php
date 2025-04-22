<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">Welcome Back!</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= APP_URL ?>/login" data-validate>
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
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <?php if (isset($_SESSION['form_errors']['password'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small">
                        Don't have an account? 
                        <a href="<?= APP_URL ?>/signup" class="text-primary">Sign up now!</a>
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