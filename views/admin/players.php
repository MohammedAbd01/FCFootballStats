<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-users me-2"></i>
                        Player Management
                    </h2>
                    <p class="card-text">View and manage player statistics.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Players Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>All Players
                    </h5>
                    <a href="<?= APP_URL ?>/admin/dashboard" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Goals</th>
                                    <th>Assists</th>
                                    <th>Matches</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players as $player): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if ($player['photo_url']): ?>
                                                    <img src="<?= APP_URL ?>/public/uploads/<?= $player['photo_url'] ?>" 
                                                        alt="<?= htmlspecialchars($player['name']) ?>" 
                                                        class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                                <?php else: ?>
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                        style="width: 40px; height: 40px;">
                                                        <?= strtoupper(substr($player['name'], 0, 1)) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?= htmlspecialchars($player['name']) ?>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($player['email']) ?></td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <?= $player['goals'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= $player['assists'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= $player['matches_played'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= APP_URL ?>/player/<?= $player['id'] ?>" 
                                                    class="btn btn-sm btn-primary" 
                                                    title="View Profile">
                                                    <i class="fas fa-user"></i>
                                                </a>
                                                <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#updateStatsModal<?= $player['id'] ?>"
                                                    title="Update Stats">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>

                                            <!-- Update Stats Modal -->
                                            <div class="modal fade" id="updateStatsModal<?= $player['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">
                                                                Update Stats for <?= htmlspecialchars($player['name']) ?>
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="<?= APP_URL ?>/admin/update-player-stats" method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                                                                
                                                                <div class="mb-3">
                                                                    <label for="match_id" class="form-label">Match</label>
                                                                    <select class="form-select" name="match_id" required>
                                                                        <option value="">Select Match</option>
                                                                        <?php
                                                                        $this->db->query("SELECT * FROM matches ORDER BY date DESC, time DESC");
                                                                        $matches = $this->db->resultSet();
                                                                        foreach ($matches as $match):
                                                                        ?>
                                                                            <option value="<?= $match['id'] ?>">
                                                                                <?= date('M d, Y', strtotime($match['date'])) ?> - 
                                                                                vs <?= htmlspecialchars($match['opponent']) ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="goals" class="form-label">Goals</label>
                                                                    <input type="number" class="form-control" name="goals" 
                                                                        min="0" value="0" required>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="assists" class="form-label">Assists</label>
                                                                    <input type="number" class="form-control" name="assists" 
                                                                        min="0" value="0" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update Stats</button>
                                                            </div>
                                                        </form>
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