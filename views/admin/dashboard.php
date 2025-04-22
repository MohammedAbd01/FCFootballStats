<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-user-shield me-2"></i>
                        Admin Dashboard
                    </h2>
                    <p class="card-text">Manage your team's statistics and matches.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-users me-2"></i>Total Players
                    </h5>
                    <h2 class="display-4"><?= $totalPlayers ?></h2>
                    <p class="card-text">Registered team members</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-futbol me-2"></i>Total Matches
                    </h5>
                    <h2 class="display-4"><?= $totalMatches ?></h2>
                    <p class="card-text">Matches played</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-bullseye me-2"></i>Total Goals
                    </h5>
                    <h2 class="display-4"><?= $totalGoals ?></h2>
                    <p class="card-text">Goals scored</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?= APP_URL ?>/admin/matches" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-futbol me-2"></i>Manage Matches
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= APP_URL ?>/admin/players" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-users me-2"></i>Manage Players
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= APP_URL ?>/admin/matches/add" class="btn btn-success btn-lg w-100 mb-3">
                                <i class="fas fa-plus me-2"></i>Add New Match
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Recent Activities
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentActivities as $activity): ?>
                                    <tr>
                                        <td>
                                            <?php if ($activity['type'] === 'match'): ?>
                                                <i class="fas fa-futbol text-primary"></i> Match
                                            <?php else: ?>
                                                <i class="fas fa-user text-success"></i> Player
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($activity['date'])) ?></td>
                                        <td>
                                            <?php if ($activity['type'] === 'match'): ?>
                                                Match against <?= htmlspecialchars($activity['opponent']) ?>
                                            <?php else: ?>
                                                New player: <?= htmlspecialchars($activity['name']) ?>
                                            <?php endif; ?>
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