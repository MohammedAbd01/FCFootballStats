<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-user-circle me-2"></i>
                        Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!
                    </h2>
                    <p class="card-text">Track your team's performance and stay updated with the latest statistics.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <form action="<?= APP_URL ?>/dashboard/search" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2" placeholder="Search players or matches...">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Player Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-futbol me-2"></i>Goals
                    </h5>
                    <h2 class="display-4"><?= $playerStats['goals'] ?></h2>
                    <p class="card-text">Total goals scored</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-handshake me-2"></i>Assists
                    </h5>
                    <h2 class="display-4"><?= $playerStats['assists'] ?></h2>
                    <p class="card-text">Total assists provided</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-calendar-check me-2"></i>Matches
                    </h5>
                    <h2 class="display-4"><?= $playerStats['matches_played'] ?></h2>
                    <p class="card-text">Total matches played</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy me-2"></i>Top Goal Scorers
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Goals</th>
                                    <th>Assists</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topScorers as $player): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($player['name']) ?></td>
                                        <td><?= $player['goals'] ?></td>
                                        <td><?= $player['assists'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>Top Assist Providers
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Player</th>
                                    <th>Assists</th>
                                    <th>Goals</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topAssists as $player): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($player['name']) ?></td>
                                        <td><?= $player['assists'] ?></td>
                                        <td><?= $player['goals'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Matches -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Recent Matches
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Opponent</th>
                                    <th>Result</th>
                                    <th>Goals</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentMatches as $match): ?>
                                    <tr>
                                        <td><?= date('M d, Y', strtotime($match['date'])) ?></td>
                                        <td><?= date('H:i', strtotime($match['time'])) ?></td>
                                        <td><?= htmlspecialchars($match['opponent']) ?></td>
                                        <td><?= $match['result'] ?? 'N/A' ?></td>
                                        <td><?= $match['total_goals'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Performance -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Your Recent Performance
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
                                <?php foreach ($recentPerformance as $performance): ?>
                                    <tr>
                                        <td><?= date('M d, Y', strtotime($performance['date'])) ?></td>
                                        <td><?= htmlspecialchars($performance['opponent']) ?></td>
                                        <td><?= $performance['goals'] ?></td>
                                        <td><?= $performance['assists'] ?></td>
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