import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { MagnifyingGlassIcon } from '@heroicons/react/24/outline';

const PlayerProfiles = () => {
  const [searchQuery, setSearchQuery] = useState('');

  const players = [
    {
      id: 1,
      name: 'John Doe',
      position: 'Forward',
      number: 10,
      goals: 15,
      assists: 8,
      matches: 25,
      image: 'https://via.placeholder.com/150',
    },
    {
      id: 2,
      name: 'Jane Smith',
      position: 'Midfielder',
      number: 8,
      goals: 12,
      assists: 15,
      matches: 28,
      image: 'https://via.placeholder.com/150',
    },
    {
      id: 3,
      name: 'Mike Johnson',
      position: 'Defender',
      number: 4,
      goals: 5,
      assists: 12,
      matches: 30,
      image: 'https://via.placeholder.com/150',
    },
  ];

  const filteredPlayers = players.filter(player =>
    player.name.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <div className="space-y-8">
      <div className="flex justify-between items-center">
        <h1 className="text-3xl font-display font-bold text-gray-900">
          Player Profiles
        </h1>
        <div className="relative">
          <input
            type="text"
            placeholder="Search players..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            className="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
          />
          <MagnifyingGlassIcon className="h-5 w-5 text-gray-400 absolute left-3 top-2.5" />
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {filteredPlayers.map((player, index) => (
          <motion.div
            key={player.id}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: index * 0.1 }}
            className="bg-white rounded-lg shadow-md overflow-hidden"
          >
            <div className="relative h-48 bg-gradient-to-r from-primary-500 to-secondary-500">
              <img
                src={player.image}
                alt={player.name}
                className="w-full h-full object-cover opacity-75"
              />
              <div className="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black to-transparent">
                <h2 className="text-xl font-bold text-white">{player.name}</h2>
                <p className="text-white/80">{player.position} • #{player.number}</p>
              </div>
            </div>

            <div className="p-6">
              <div className="grid grid-cols-3 gap-4 text-center">
                <div>
                  <p className="text-sm text-gray-600">Goals</p>
                  <p className="text-2xl font-bold text-primary-600">{player.goals}</p>
                </div>
                <div>
                  <p className="text-sm text-gray-600">Assists</p>
                  <p className="text-2xl font-bold text-secondary-600">{player.assists}</p>
                </div>
                <div>
                  <p className="text-sm text-gray-600">Matches</p>
                  <p className="text-2xl font-bold text-gray-900">{player.matches}</p>
                </div>
              </div>

              <div className="mt-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-3">Recent Performance</h3>
                <div className="space-y-2">
                  {[
                    { date: '2024-02-15', opponent: 'Team A', goals: 2, assists: 1 },
                    { date: '2024-02-08', opponent: 'Team B', goals: 1, assists: 0 },
                    { date: '2024-02-01', opponent: 'Team C', goals: 0, assists: 2 },
                  ].map((match) => (
                    <div key={match.date} className="flex items-center justify-between p-2 bg-gray-50 rounded">
                      <div>
                        <p className="text-sm text-gray-600">{match.date}</p>
                        <p className="text-sm font-medium">vs {match.opponent}</p>
                      </div>
                      <div className="flex space-x-4">
                        <span className="text-sm text-primary-600">{match.goals}G</span>
                        <span className="text-sm text-secondary-600">{match.assists}A</span>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
};

export default PlayerProfiles; 