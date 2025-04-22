<div class="container">
    <!-- Player Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <?php if ($player['photo_url']): ?>
                                <img src="<?= APP_URL ?>/public/uploads/<?= $player['photo_url'] ?>" 
                                    alt="<?= htmlspecialchars($player['name']) ?>" 
                                    class="player-photo mb-3">
                            <?php else: ?>
                                <div class="player-photo bg-white text-primary d-flex align-items-center justify-content-center mb-3">
                                    <?= strtoupper(substr($player['name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <h2 class="card-title">
                                <?= htmlspecialchars($player['name']) ?>
                            </h2>
                            <p class="card-text">
                                <i class="fas fa-envelope me-2"></i><?= htmlspecialchars($player['email']) ?>
                            </p>
                            <?php if ($player['id'] === $_SESSION['user_id']): ?>
                                <a href="<?= APP_URL ?>/player/edit-profile" class="btn btn-light">
                                    <i class="fas fa-edit me-2"></i>Edit Profile
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-futbol me-2"></i>Goals
                    </h5>
                    <h2 class="display-4"><?= $player['goals'] ?></h2>
                    <p class="card-text">Total goals scored</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-handshake me-2"></i>Assists
                    </h5>
                    <h2 class="display-4"><?= $player['assists'] ?></h2>
                    <p class="card-text">Total assists provided</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-calendar-check me-2"></i>Matches
                    </h5>
                    <h2 class="display-4"><?= $player['matches_played'] ?></h2>
                    <p class="card-text">Total matches played</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chart-line me-2"></i>Form
                    </h5>
                    <h2 class="display-4">
                        <?= number_format($performanceStats['avg_goals'], 1) ?>
                    </h2>
                    <p class="card-text">Average goals per match</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Recent Form
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Opponent</th>
                                    <th>Goals</th>
                                    <th>Assists</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentForm as $match): ?>
                                    <tr>
                                        <td><?= date('M d, Y', strtotime($match['date'])) ?></td>
                                        <td><?= htmlspecialchars($match['opponent']) ?></td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <?= $match['goals'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= $match['assists'] ?>
                                            </span>
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

    <!-- Match History -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Match History
                    </h5>
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
                                    <th>Assists</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($matchHistory as $match): ?>
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
                                            <span class="badge bg-primary">
                                                <?= $match['goals'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= $match['assists'] ?>
                                            </span>
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