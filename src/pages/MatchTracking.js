import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { CalendarIcon, ClockIcon, UserGroupIcon } from '@heroicons/react/24/outline';

const MatchTracking = () => {
  const [selectedMatch, setSelectedMatch] = useState(null);

  const matches = [
    {
      id: 1,
      date: '2024-02-15',
      time: '19:00',
      opponent: 'Team A',
      venue: 'Home',
      result: '3-1',
      status: 'Completed',
      stats: {
        possession: '55%',
        shots: 15,
        shotsOnTarget: 8,
        corners: 7,
        fouls: 12,
      },
      scorers: [
        { player: 'John Doe', minute: 23, type: 'goal' },
        { player: 'Jane Smith', minute: 45, type: 'goal' },
        { player: 'Mike Johnson', minute: 67, type: 'goal' },
      ],
    },
    {
      id: 2,
      date: '2024-02-08',
      time: '20:00',
      opponent: 'Team B',
      venue: 'Away',
      result: '2-2',
      status: 'Completed',
      stats: {
        possession: '48%',
        shots: 12,
        shotsOnTarget: 6,
        corners: 5,
        fouls: 10,
      },
      scorers: [
        { player: 'John Doe', minute: 15, type: 'goal' },
        { player: 'Sarah Wilson', minute: 78, type: 'goal' },
      ],
    },
  ];

  return (
    <div className="space-y-8">
      <div className="flex justify-between items-center">
        <h1 className="text-3xl font-display font-bold text-gray-900">
          Match Tracking
        </h1>
        <button className="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
          Add New Match
        </button>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Match List */}
        <div className="lg:col-span-1">
          <div className="bg-white rounded-lg shadow-md p-6">
            <h2 className="text-xl font-semibold text-gray-900 mb-4">Upcoming Matches</h2>
            <div className="space-y-4">
              {matches.map((match) => (
                <motion.div
                  key={match.id}
                  whileHover={{ scale: 1.02 }}
                  className={`p-4 rounded-lg cursor-pointer ${
                    selectedMatch?.id === match.id
                      ? 'bg-primary-50 border-2 border-primary-500'
                      : 'bg-gray-50 hover:bg-gray-100'
                  }`}
                  onClick={() => setSelectedMatch(match)}
                >
                  <div className="flex items-center justify-between">
                    <div>
                      <p className="text-sm text-gray-600">{match.date}</p>
                      <p className="font-medium text-gray-900">vs {match.opponent}</p>
                    </div>
                    <div className="text-right">
                      <p className="text-sm text-gray-600">{match.time}</p>
                      <p className="text-sm font-medium text-gray-900">{match.venue}</p>
                    </div>
                  </div>
                </motion.div>
              ))}
            </div>
          </div>
        </div>

        {/* Match Details */}
        <div className="lg:col-span-2">
          {selectedMatch ? (
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="bg-white rounded-lg shadow-md p-6"
            >
              <div className="flex items-center justify-between mb-6">
                <div>
                  <h2 className="text-2xl font-bold text-gray-900">
                    vs {selectedMatch.opponent}
                  </h2>
                  <div className="flex items-center space-x-4 mt-2">
                    <div className="flex items-center text-gray-600">
                      <CalendarIcon className="h-5 w-5 mr-1" />
                      <span>{selectedMatch.date}</span>
                    </div>
                    <div className="flex items-center text-gray-600">
                      <ClockIcon className="h-5 w-5 mr-1" />
                      <span>{selectedMatch.time}</span>
                    </div>
                    <div className="flex items-center text-gray-600">
                      <UserGroupIcon className="h-5 w-5 mr-1" />
                      <span>{selectedMatch.venue}</span>
                    </div>
                  </div>
                </div>
                <div className="text-right">
                  <p className="text-3xl font-bold text-primary-600">{selectedMatch.result}</p>
                  <p className="text-sm text-gray-600">{selectedMatch.status}</p>
                </div>
              </div>

              {/* Match Statistics */}
              <div className="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                {Object.entries(selectedMatch.stats).map(([key, value]) => (
                  <div key={key} className="text-center p-3 bg-gray-50 rounded-lg">
                    <p className="text-sm text-gray-600 capitalize">{key}</p>
                    <p className="text-xl font-bold text-gray-900">{value}</p>
                  </div>
                ))}
              </div>

              {/* Match Events */}
              <div>
                <h3 className="text-lg font-semibold text-gray-900 mb-3">Match Events</h3>
                <div className="space-y-2">
                  {selectedMatch.scorers.map((event) => (
                    <div key={`${event.player}-${event.minute}`} className="flex items-center p-2 bg-gray-50 rounded">
                      <span className="text-sm font-medium text-gray-900">{event.minute}'</span>
                      <span className="mx-2 text-gray-600">•</span>
                      <span className="text-sm text-gray-900">{event.player}</span>
                      <span className="ml-auto">
                        {event.type === 'goal' ? (
                          <span className="text-primary-600 font-medium">Goal</span>
                        ) : (
                          <span className="text-secondary-600 font-medium">Assist</span>
                        )}
                      </span>
                    </div>
                  ))}
                </div>
              </div>
            </motion.div>
          ) : (
            <div className="bg-white rounded-lg shadow-md p-6 text-center">
              <p className="text-gray-600">Select a match to view details</p>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default MatchTracking; 