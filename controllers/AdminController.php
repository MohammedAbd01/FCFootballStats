<?php
require_once 'core/Controller.php';

class AdminController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
    }
    
    public function index() {
        // Get total players
        $this->db->query("SELECT COUNT(*) as total FROM players");
        $totalPlayers = $this->db->single()['total'];
        
        // Get total matches
        $this->db->query("SELECT COUNT(*) as total FROM matches");
        $totalMatches = $this->db->single()['total'];
        
        // Get total goals
        $this->db->query("SELECT SUM(goals) as total FROM players");
        $totalGoals = $this->db->single()['total'] ?? 0;
        
        // Get recent activities
        $this->db->query("
            SELECT 'match' as type, m.date, m.opponent, NULL as name
            FROM matches m
            UNION ALL
            SELECT 'player' as type, p.created_at as date, NULL as opponent, u.name
            FROM players p
            JOIN users u ON p.user_id = u.id
            ORDER BY date DESC
            LIMIT 5
        ");
        $recentActivities = $this->db->resultSet();
        
        $this->render('admin/dashboard', [
            'totalPlayers' => $totalPlayers,
            'totalMatches' => $totalMatches,
            'totalGoals' => $totalGoals,
            'recentActivities' => $recentActivities
        ]);
    }
    
    public function players() {
        // Get all players with their stats
        $this->db->query("
            SELECT p.*, u.name, u.email
            FROM players p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.goals DESC
        ");
        $players = $this->db->resultSet();
        
        $this->render('admin/players', [
            'players' => $players
        ]);
    }
    
    public function matches() {
        // Get all matches with total goals
        $this->db->query("
            SELECT m.*, 
                   (SELECT COUNT(*) FROM match_stats WHERE match_id = m.id) as total_goals
            FROM matches m
            ORDER BY m.date DESC, m.time DESC
        ");
        $matches = $this->db->resultSet();
        
        $this->render('admin/matches', [
            'matches' => $matches
        ]);
    }
    
    public function addMatch() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'] ?? '';
            $time = $_POST['time'] ?? '';
            $opponent = $_POST['opponent'] ?? '';
            $result = $_POST['result'] ?? '';
            
            // Validate input
            $errors = $this->validateInput($_POST, [
                'date' => 'required',
                'time' => 'required',
                'opponent' => 'required|min:3'
            ]);
            
            if (empty($errors)) {
                $this->db->query("
                    INSERT INTO matches (date, time, opponent, result)
                    VALUES (:date, :time, :opponent, :result)
                ");
                $this->db->bind(':date', $date);
                $this->db->bind(':time', $time);
                $this->db->bind(':opponent', $opponent);
                $this->db->bind(':result', $result);
                
                if ($this->db->execute()) {
                    $_SESSION['flash_message'] = 'Match added successfully!';
                    $_SESSION['flash_type'] = 'success';
                    $this->redirect('admin/matches');
                } else {
                    $_SESSION['flash_message'] = 'Failed to add match. Please try again.';
                    $_SESSION['flash_type'] = 'danger';
                }
            } else {
                $_SESSION['flash_message'] = 'Please correct the errors below.';
                $_SESSION['flash_type'] = 'danger';
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
            }
        }
        
        $this->render('admin/add_match');
    }
    
    public function editMatch($id) {
        // Get match details
        $this->db->query("SELECT * FROM matches WHERE id = :id");
        $this->db->bind(':id', $id);
        $match = $this->db->single();
        
        if (!$match) {
            $_SESSION['flash_message'] = 'Match not found.';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('admin/matches');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'] ?? '';
            $time = $_POST['time'] ?? '';
            $opponent = $_POST['opponent'] ?? '';
            $result = $_POST['result'] ?? '';
            
            // Validate input
            $errors = $this->validateInput($_POST, [
                'date' => 'required',
                'time' => 'required',
                'opponent' => 'required|min:3'
            ]);
            
            if (empty($errors)) {
                $this->db->query("
                    UPDATE matches 
                    SET date = :date, time = :time, opponent = :opponent, result = :result
                    WHERE id = :id
                ");
                $this->db->bind(':date', $date);
                $this->db->bind(':time', $time);
                $this->db->bind(':opponent', $opponent);
                $this->db->bind(':result', $result);
                $this->db->bind(':id', $id);
                
                if ($this->db->execute()) {
                    $_SESSION['flash_message'] = 'Match updated successfully!';
                    $_SESSION['flash_type'] = 'success';
                    $this->redirect('admin/matches');
                } else {
                    $_SESSION['flash_message'] = 'Failed to update match. Please try again.';
                    $_SESSION['flash_type'] = 'danger';
                }
            } else {
                $_SESSION['flash_message'] = 'Please correct the errors below.';
                $_SESSION['flash_type'] = 'danger';
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
            }
        }
        
        $this->render('admin/edit_match', [
            'match' => $match
        ]);
    }
    
    public function deleteMatch($id) {
        $this->db->query("DELETE FROM matches WHERE id = :id");
        $this->db->bind(':id', $id);
        
        if ($this->db->execute()) {
            $_SESSION['flash_message'] = 'Match deleted successfully!';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Failed to delete match. Please try again.';
            $_SESSION['flash_type'] = 'danger';
        }
        
        $this->redirect('admin/matches');
    }
    
    public function updatePlayerStats() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $playerId = $_POST['player_id'] ?? '';
            $matchId = $_POST['match_id'] ?? '';
            $goals = $_POST['goals'] ?? 0;
            $assists = $_POST['assists'] ?? 0;
            
            // Validate input
            $errors = $this->validateInput($_POST, [
                'player_id' => 'required',
                'match_id' => 'required'
            ]);
            
            if (empty($errors)) {
                // Check if stats already exist
                $this->db->query("
                    SELECT id FROM match_stats 
                    WHERE player_id = :player_id AND match_id = :match_id
                ");
                $this->db->bind(':player_id', $playerId);
                $this->db->bind(':match_id', $matchId);
                $existingStats = $this->db->single();
                
                if ($existingStats) {
                    // Update existing stats
                    $this->db->query("
                        UPDATE match_stats 
                        SET goals = :goals, assists = :assists
                        WHERE player_id = :player_id AND match_id = :match_id
                    ");
                } else {
                    // Insert new stats
                    $this->db->query("
                        INSERT INTO match_stats (player_id, match_id, goals, assists)
                        VALUES (:player_id, :match_id, :goals, :assists)
                    ");
                }
                
                $this->db->bind(':player_id', $playerId);
                $this->db->bind(':match_id', $matchId);
                $this->db->bind(':goals', $goals);
                $this->db->bind(':assists', $assists);
                
                if ($this->db->execute()) {
                    // Update player totals
                    $this->db->query("
                        UPDATE players p
                        SET goals = (
                            SELECT COALESCE(SUM(goals), 0)
                            FROM match_stats
                            WHERE player_id = p.id
                        ),
                        assists = (
                            SELECT COALESCE(SUM(assists), 0)
                            FROM match_stats
                            WHERE player_id = p.id
                        ),
                        matches_played = (
                            SELECT COUNT(DISTINCT match_id)
                            FROM match_stats
                            WHERE player_id = p.id
                        )
                        WHERE id = :player_id
                    ");
                    $this->db->bind(':player_id', $playerId);
                    $this->db->execute();
                    
                    $_SESSION['flash_message'] = 'Player stats updated successfully!';
                    $_SESSION['flash_type'] = 'success';
                } else {
                    $_SESSION['flash_message'] = 'Failed to update player stats. Please try again.';
                    $_SESSION['flash_type'] = 'danger';
                }
            } else {
                $_SESSION['flash_message'] = 'Please correct the errors below.';
                $_SESSION['flash_type'] = 'danger';
                $_SESSION['form_errors'] = $errors;
            }
        }
        
        $this->redirect('admin/matches');
    }
} 