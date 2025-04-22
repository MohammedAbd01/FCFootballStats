<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-futbol me-2"></i>
                        Match Management
                    </h2>
                    <p class="card-text">View and manage team matches.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Matches Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>All Matches
                    </h5>
                    <div>
                        <a href="<?= APP_URL ?>/admin/matches/add" class="btn btn-success btn-sm me-2">
                            <i class="fas fa-plus me-2"></i>Add Match
                        </a>
                        <a href="<?= APP_URL ?>/admin/dashboard" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Opponent</th>
                                    <th>Result</th>
                                    <th>Goals</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($matches as $match): ?>
                                    <tr>
                                        <td><?= date('M d, Y', strtotime($match['date'])) ?></td>
                                        <td><?= date('H:i', strtotime($match['time'])) ?></td>
                                        <td><?= htmlspecialchars($match['opponent']) ?></td>
                                        <td>
                                            <?php if ($match['result']): ?>
                                                <span class="badge bg-primary">
                                                    <?= htmlspecialchars($match['result']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Not played</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= $match['total_goals'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= APP_URL ?>/match/<?= $match['id'] ?>" 
                                                    class="btn btn-sm btn-primary" 
                                                    title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= APP_URL ?>/admin/matches/edit/<?= $match['id'] ?>" 
                                                    class="btn btn-sm btn-success" 
                                                    title="Edit Match">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteMatchModal<?= $match['id'] ?>"
                                                    title="Delete Match">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Match Modal -->
                                            <div class="modal fade" id="deleteMatchModal<?= $match['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">Confirm Delete</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this match?</p>
                                                            <p class="mb-0">
                                                                <strong>Date:</strong> <?= date('M d, Y', strtotime($match['date'])) ?><br>
                                                                <strong>Time:</strong> <?= date('H:i', strtotime($match['time'])) ?><br>
                                                                <strong>Opponent:</strong> <?= htmlspecialchars($match['opponent']) ?>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <a href="<?= APP_URL ?>/admin/matches/delete/<?= $match['id'] ?>" 
                                                                class="btn btn-danger">Delete Match</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 