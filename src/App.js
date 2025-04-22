import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { motion } from 'framer-motion';
import Navbar from './components/Navbar';
import Dashboard from './pages/Dashboard';
import PlayerProfiles from './pages/PlayerProfiles';
import MatchTracking from './pages/MatchTracking';
import AdminPanel from './pages/AdminPanel';

function App() {
  return (
    <Router>
      <div className="min-h-screen bg-gray-50">
        <Navbar />
        <main className="container mx-auto px-4 py-8">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
          >
            <Routes>
              <Route path="/" element={<Dashboard />} />
              <Route path="/players" element={<PlayerProfiles />} />
              <Route path="/matches" element={<MatchTracking />} />
              <Route path="/admin" element={<AdminPanel />} />
            </Routes>
          </motion.div>
        </main>
      </div>
    </Router>
  );
}

export default App; 