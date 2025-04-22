<?php
require_once 'core/Controller.php';

class DashboardController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireLogin();
    }
    
    public function index() {
        // Get top goal scorers
        $this->db->query("
            SELECT p.id, u.name, p.goals, p.assists, p.matches_played
            FROM players p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.goals DESC
            LIMIT 5
        ");
        $topScorers = $this->db->resultSet();
        
        // Get top assist providers
        $this->db->query("
            SELECT p.id, u.name, p.goals, p.assists, p.matches_played
            FROM players p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.assists DESC
            LIMIT 5
        ");
        $topAssists = $this->db->resultSet();
        
        // Get recent matches
        $this->db->query("
            SELECT m.*, 
                   (SELECT COUNT(*) FROM match_stats WHERE match_id = m.id) as total_goals
            FROM matches m
            ORDER BY m.date DESC, m.time DESC
            LIMIT 5
        ");
        $recentMatches = $this->db->resultSet();
        
        // Get player's own stats
        $this->db->query("
            SELECT p.*, u.name
            FROM players p
            JOIN users u ON p.user_id = u.id
            WHERE p.user_id = :user_id
        ");
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $playerStats = $this->db->single();
        
        // Get player's recent performance
        $this->db->query("
            SELECT ms.*, m.date, m.opponent
            FROM match_stats ms
            JOIN matches m ON ms.match_id = m.id
            WHERE ms.player_id = :player_id
            ORDER BY m.date DESC, m.time DESC
            LIMIT 5
        ");
        $this->db->bind(':player_id', $playerStats['id']);
        $recentPerformance = $this->db->resultSet();
        
        $this->render('dashboard/index', [
            'topScorers' => $topScorers,
            'topAssists' => $topAssists,
            'recentMatches' => $recentMatches,
            'playerStats' => $playerStats,
            'recentPerformance' => $recentPerformance
        ]);
    }
    
    public function search() {
        $query = $_GET['q'] ?? '';
        
        if (!empty($query)) {
            // Search players
            $this->db->query("
                SELECT p.id, u.name, p.goals, p.assists, p.matches_played
                FROM players p
                JOIN users u ON p.user_id = u.id
                WHERE u.name LIKE :query
                ORDER BY p.goals DESC
            ");
            $this->db->bind(':query', "%$query%");
            $players = $this->db->resultSet();
            
            // Search matches
            $this->db->query("
                SELECT m.*, 
                       (SELECT COUNT(*) FROM match_stats WHERE match_id = m.id) as total_goals
                FROM matches m
                WHERE m.opponent LIKE :query
                ORDER BY m.date DESC, m.time DESC
            ");
            $this->db->bind(':query', "%$query%");
            $matches = $this->db->resultSet();
            
            $this->render('dashboard/search', [
                'query' => $query,
                'players' => $players,
                'matches' => $matches
            ]);
        } else {
            $this->redirect('dashboard');
        }
    }
} 