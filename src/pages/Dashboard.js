import React from 'react';
import { motion } from 'framer-motion';
import { ChartBarIcon, UserGroupIcon, CalendarIcon } from '@heroicons/react/24/outline';

const Dashboard = () => {
  const stats = [
    {
      title: 'Total Goals',
      value: '156',
      icon: ChartBarIcon,
      color: 'bg-primary-500',
    },
    {
      title: 'Active Players',
      value: '24',
      icon: UserGroupIcon,
      color: 'bg-secondary-500',
    },
    {
      title: 'Matches Played',
      value: '45',
      icon: CalendarIcon,
      color: 'bg-green-500',
    },
  ];

  return (
    <div className="space-y-8">
      <div className="flex justify-between items-center">
        <h1 className="text-3xl font-display font-bold text-gray-900">
          Dashboard
        </h1>
        <div className="flex space-x-4">
          <select className="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            <option>This Season</option>
            <option>Last Season</option>
            <option>All Time</option>
          </select>
        </div>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {stats.map((stat, index) => (
          <motion.div
            key={stat.title}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: index * 0.1 }}
            className="bg-white rounded-lg shadow-md p-6"
          >
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm font-medium text-gray-600">{stat.title}</p>
                <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
              </div>
              <div className={`p-3 rounded-full ${stat.color}`}>
                <stat.icon className="h-6 w-6 text-white" />
              </div>
            </div>
          </motion.div>
        ))}
      </div>

      {/* Top Performers Section */}
      <div className="bg-white rounded-lg shadow-md p-6">
        <h2 className="text-xl font-display font-semibold text-gray-900 mb-4">
          Top Performers
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {/* Top Scorers */}
          <div>
            <h3 className="text-lg font-medium text-gray-900 mb-3">Top Scorers</h3>
            <div className="space-y-3">
              {[
                { name: 'John Doe', goals: 15 },
                { name: 'Jane Smith', goals: 12 },
                { name: 'Mike Johnson', goals: 10 },
              ].map((player, index) => (
                <div key={player.name} className="flex items-center justify-between">
                  <span className="text-gray-600">{player.name}</span>
                  <span className="font-semibold text-primary-600">{player.goals} goals</span>
                </div>
              ))}
            </div>
          </div>

          {/* Top Assists */}
          <div>
            <h3 className="text-lg font-medium text-gray-900 mb-3">Top Assists</h3>
            <div className="space-y-3">
              {[
                { name: 'Sarah Wilson', assists: 12 },
                { name: 'Tom Brown', assists: 10 },
                { name: 'Emma Davis', assists: 8 },
              ].map((player, index) => (
                <div key={player.name} className="flex items-center justify-between">
                  <span className="text-gray-600">{player.name}</span>
                  <span className="font-semibold text-secondary-600">{player.assists} assists</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Recent Matches */}
      <div className="bg-white rounded-lg shadow-md p-6">
        <h2 className="text-xl font-display font-semibold text-gray-900 mb-4">
          Recent Matches
        </h2>
        <div className="space-y-4">
          {[
            { date: '2024-02-15', opponent: 'Team A', result: '3-1 W' },
            { date: '2024-02-08', opponent: 'Team B', result: '2-2 D' },
            { date: '2024-02-01', opponent: 'Team C', result: '4-0 W' },
          ].map((match) => (
            <div key={match.date} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
              <div>
                <p className="text-sm text-gray-600">{match.date}</p>
                <p className="font-medium text-gray-900">vs {match.opponent}</p>
              </div>
              <span className={`px-3 py-1 rounded-full text-sm font-medium ${
                match.result.includes('W') ? 'bg-green-100 text-green-800' :
                match.result.includes('D') ? 'bg-yellow-100 text-yellow-800' :
                'bg-red-100 text-red-800'
              }`}>
                {match.result}
              </span>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default Dashboard; 