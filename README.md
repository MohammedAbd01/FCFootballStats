# FCFootballStats - Football Team Statistics Platform

A modern, responsive web application for tracking football team statistics, built with PHP 8.x and Bootstrap 5.

## Features

- 🔐 Secure authentication system for admins and players
- 📊 Comprehensive player statistics tracking
- 🎯 Match management and results recording
- 📱 Responsive design for all devices
- 🎨 Modern and clean user interface
- 🔍 Advanced search and filtering capabilities
- 📅 Calendar view for matches
- 📈 Interactive dashboards
- 📤 Data export functionality

## Technology Stack

- **Frontend:**
  - Bootstrap 5
  - jQuery
  - DataTables
  - FullCalendar
  - Google Fonts (Poppins)

- **Backend:**
  - PHP 8.x
  - MySQL
  - MVC Architecture

## Project Structure

```
FCFootballStats/
├── config/
│   └── config.php
├── controllers/
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── MatchController.php
│   └── PlayerController.php
├── core/
│   ├── Database.php
│   └── Router.php
├── models/
│   ├── MatchModel.php
│   ├── PlayerModel.php
│   └── UserModel.php
├── public/
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── scripts.js
│   └── uploads/
├── views/
│   ├── admin/
│   ├── auth/
│   ├── dashboard/
│   ├── matches/
│   └── players/
└── index.php
```

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/FCFootballStats.git
```

2. Set up your web server (Apache/Nginx) to point to the project directory

3. Create a MySQL database and import the schema:
```bash
mysql -u your_username -p your_database < setup.sql
```

4. Configure your database connection in `config/config.php`

5. Set up the initial admin user in the database

## Requirements

- PHP 8.x
- MySQL 5.7+
- Apache/Nginx web server
- Composer (for dependency management)

## Security Features

- Password hashing using `password_hash()`
- Prepared statements for all database queries
- Input validation and sanitization
- Session management
- Role-based access control

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the GitHub repository or contact the development team.

## File Structure Details

| File | Description |
|------|-------------|
| `index.php` | Main entry point |
| `config/config.php` | Configuration settings |
| `core/Router.php` | URL routing system |
| `core/Database.php` | Database connection handler |
| `controllers/*.php` | Controller classes |
| `models/*.php` | Model classes |
| `views/*.php` | View templates |
| `public/css/styles.css` | Custom styles |
| `public/js/scripts.js` | Custom JavaScript |
| `setup.sql` | Database schema | 