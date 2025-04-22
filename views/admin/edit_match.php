<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-edit me-2"></i>
                        Edit Match
                    </h2>
                    <p class="card-text">Update match details.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Match Form -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-futbol me-2"></i>Match Details
                    </h5>
                    <a href="<?= APP_URL ?>/admin/matches" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to Matches
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?= APP_URL ?>/admin/matches/edit/<?= $match['id'] ?>" method="POST" data-validate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required
                                    value="<?= $_SESSION['form_data']['date'] ?? $match['date'] ?>">
                                <?php if (isset($_SESSION['form_errors']['date'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $_SESSION['form_errors']['date'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time" required
                                    value="<?= $_SESSION['form_data']['time'] ?? $match['time'] ?>">
                                <?php if (isset($_SESSION['form_errors']['time'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $_SESSION['form_errors']['time'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="opponent" class="form-label">Opponent</label>
                            <input type="text" class="form-control" id="opponent" name="opponent" required
                                value="<?= $_SESSION['form_data']['opponent'] ?? $match['opponent'] ?>">
                            <?php if (isset($_SESSION['form_errors']['opponent'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['form_errors']['opponent'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="result" class="form-label">Result (Optional)</label>
                            <input type="text" class="form-control" id="result" name="result"
                                placeholder="e.g., 2-1, 3-0"
                                value="<?= $_SESSION['form_data']['result'] ?? $match['result'] ?>">
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Match
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