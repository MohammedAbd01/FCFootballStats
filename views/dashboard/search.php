<div class="container">
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fas fa-search me-2"></i>
                        Search Results for "<?= htmlspecialchars($query) ?>"
                    </h2>
                    <p class="card-text">Found results in players and matches.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-12">
            <form action="<?= APP_URL ?>/dashboard/search" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2" 
                    value="<?= htmlspecialchars($query) ?>" placeholder="Search players or matches...">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Players Results -->
    <?php if (!empty($players)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-users me-2"></i>Players
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Goals</th>
                                        <th>Assists</th>
                                        <th>Matches</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($players as $player): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($player['name']) ?></td>
                                            <td><?= $player['goals'] ?></td>
                                            <td><?= $player['assists'] ?></td>
                                            <td><?= $player['matches_played'] ?></td>
                                            <td>
                                                <a href="<?= APP_URL ?>/player/<?= $player['id'] ?>" 
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-user me-1"></i>View Profile
                                                </a>
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
    <?php endif; ?>

    <!-- Matches Results -->
    <?php if (!empty($matches)): ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-futbol me-2"></i>Matches
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($matches as $match): ?>
                                        <tr>
                                            <td><?= date('M d, Y', strtotime($match['date'])) ?></td>
                                            <td><?= date('H:i', strtotime($match['time'])) ?></td>
                                            <td><?= htmlspecialchars($match['opponent']) ?></td>
                                            <td><?= $match['result'] ?? 'N/A' ?></td>
                                            <td><?= $match['total_goals'] ?></td>
                                            <td>
                                                <a href="<?= APP_URL ?>/match/<?= $match['id'] ?>" 
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-info-circle me-1"></i>View Details
                                                </a>
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
    <?php endif; ?>

    <!-- No Results -->
    <?php if (empty($players) && empty($matches)): ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>No results found</h4>
                        <p class="text-muted">Try different search terms or browse the dashboard.</p>
                        <a href="<?= APP_URL ?>/dashboard" class="btn btn-primary mt-3">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div> 