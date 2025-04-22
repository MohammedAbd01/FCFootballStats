# FCStats - Football Team Statistics Platform

A modern, responsive web application for tracking football team statistics, player performance, and match details.

## Features

- 📊 Interactive dashboard with key statistics
- 👥 Detailed player profiles with performance history
- ⚽ Match tracking and statistics
- 🔒 Admin panel for managing players and matches
- 📱 Fully responsive design
- 🎨 Modern UI with smooth animations
- 🔍 Search functionality
- 📈 Performance analytics

## Technologies Used

- React.js
- Tailwind CSS
- Framer Motion
- Node.js
- Express.js
- MongoDB

## Prerequisites

- Node.js (v14 or higher)
- npm or yarn
- MongoDB

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/FCFootballStats.git
cd FCFootballStats
```

2. Install dependencies:
```bash
npm install
```

3. Create a `.env` file in the root directory and add your environment variables:
```env
REACT_APP_API_URL=http://localhost:5000
MONGODB_URI=your_mongodb_connection_string
```

4. Start the development server:
```bash
npm start
```

The application will be available at `http://localhost:3000`.

## Project Structure

```
FCFootballStats/
├── src/
│   ├── components/
│   │   └── Navbar.js
│   │   ├── pages/
│   │   │   ├── Dashboard.js
│   │   │   ├── PlayerProfiles.js
│   │   │   ├── MatchTracking.js
│   │   │   └── AdminPanel.js
│   │   ├── App.js
│   │   ├── index.js
│   │   └── index.css
│   ├── public/
│   │   └── index.html
│   ├── package.json
│   └── README.md
```

## API Endpoints

### Players
- `GET /api/players` - Get all players
- `POST /api/players` - Create a new player
- `PUT /api/players/:id` - Update a player
- `DELETE /api/players/:id` - Delete a player

### Matches
- `GET /api/matches` - Get all matches
- `POST /api/matches` - Create a new match
- `PUT /api/matches/:id` - Update a match
- `DELETE /api/matches/:id` - Delete a match

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [React](https://reactjs.org/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Framer Motion](https://www.framer.com/motion/)
- [Heroicons](https://heroicons.com/) 