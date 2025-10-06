# Booking Application

Booking system with Symfony backend and React frontend.

## 📋 Table of Contents

- [Requirements](#requirements)
- [Architecture](#architecture)
- [Installation and Setup](#installation-and-setup)
- [Configuration](#configuration)
- [Frontend Development](#frontend-development)
- [Available API Endpoints](#available-api-endpoints)
- [Running Tests](#running-tests)
- [Admin Panel](#admin-panel)

## 🔧 Requirements

- Docker 20.10+
- Docker Compose 2.0+
- Node.js 20+ (for local frontend development)
- npm or yarn
- Ports 3000, 8080, 8081, 3308 available

## 🏗 Architecture

### Backend (Symfony 6.4)
- PHP 8.2 + FPM
- MySQL 8.0
- Nginx
- Doctrine ORM

### Frontend (React)
- Node 20
- React 18
- Create React App
- Port 3000
- Modern JavaScript (ES6+)

### Support Services
- phpMyAdmin (port 8081)

## 🚀 Installation and Setup

### 1. Clone the repository

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Start Docker containers

```bash
docker-compose up -d
```

### 3. Install PHP dependencies

```bash
docker exec -it booking_api_php composer install
```

### 4. Configure the database

```bash
# Run migrations
docker exec -it booking_api_php php bin/console doctrine:migrations:migrate --no-interaction
```

### 5. Install and start frontend

```bash
cd frontend
npm install
npm start
```

### 6. Verify the application is running

Backend: http://localhost:8080
- API: http://localhost:8080/api
- Admin panel: http://localhost:8080/admin/vacancies

Frontend: http://localhost:3000

phpMyAdmin: http://localhost:8081
- Username: `booking_user`
- Password: `booking_pass`

## ⚙️ Configuration

### Environment Variables

Main configuration is in `backend/.env`:

```env
DATABASE_URL=mysql://booking_user:booking_pass@mysql:3306/booking_db?serverVersion=8.0
APP_ENV=dev
APP_SECRET=your_secret_key_change_in_production
CORS_ALLOW_ORIGIN=^http://localhost:3000$
```

### Database Configuration

MySQL credentials:
- Host: `localhost` (from host) or `mysql` (from containers)
- Port: `3308` (from host) or `3306` (inside Docker network)
- Database: `booking_db`
- Username: `booking_user`
- Password: `booking_pass`

## 💻 Frontend Development

### Frontend Structure

```
frontend/
├── public/              # Static files
├── src/                 # React source code
│   ├── components/      # React components
│   ├── services/        # API services
│   ├── styles/          # CSS styles
│   └── App.js          # Main application component
├── package.json         # Dependencies
└── README.md           # Frontend documentation
```

### Available Frontend Scripts

**Development server:**
```bash
cd frontend
npm start
```
Opens the app at http://localhost:3000 with hot reload enabled.

**Production build:**
```bash
cd frontend
npm run build
```
Creates an optimized production build in the `build/` folder.

### Frontend Features

- **Booking interface** - User-friendly form for making reservations
- **Vacancy calendar** - Visual display of available dates
- **Responsive design** - Works on desktop and mobile devices
- **Real-time validation** - Instant feedback on form inputs
- **API integration** - Seamless connection with Symfony backend

### Frontend-Backend Communication

The frontend communicates with the backend through REST API:
- Base API URL: `http://localhost:8080/api`
- CORS is configured to allow requests from `http://localhost:3000`
- All API endpoints return JSON responses

### Adding New Dependencies

```bash
cd frontend
npm install <package-name>
```

## 📡 Available API Endpoints

### Vacancies

**GET** `/api/vacancies`
```bash
# Get all available vacancies
curl http://localhost:8080/api/vacancies

# Filter by date
curl "http://localhost:8080/api/vacancies?startDate=1735686000&endDate=1735858800"
```

### Reservations

**GET** `/api/reservations`
```bash
curl http://localhost:8080/api/reservations
```

**POST** `/api/reservations`
```bash
curl -X POST http://localhost:8080/api/reservations \
  -H "Content-Type: application/json" \
  -d '{
    "startDate": 1735686000,
    "endDate": 1735858800,
    "name": "John",
    "surname": "Doe",
    "email": "john@example.com",
    "phoneNumber": "+48123456789"
  }'
```

**DELETE** `/api/reservations/{id}`
```bash
curl -X DELETE http://localhost:8080/api/reservations/1
```

## 🧪 Running Tests

### Backend Tests

**All tests:**
```bash
docker exec -it booking_api_php composer test
```

**Unit tests only:**
```bash
docker exec -it booking_api_php composer test:unit
```

**Functional tests only:**
```bash
docker exec -it booking_api_php composer test:functional
```

### Frontend Tests

```bash
cd frontend
npm test
```

## 👨‍💼 Admin Panel

Admin panel available at: http://localhost:8080

### Managing Vacancies

- **List**: `/admin/vacancies`
- **Add new**: `/admin/vacancies/create`
- **Edit**: `/admin/vacancies/edit/{id}`
- **Delete**: "Delete" button next to each vacancy

### Managing Reservations

- **List**: `/reservations`
- **Confirm reservation**: "Confirm" button next to reservations with "Pending" status

## 🛠 Useful Commands

### Backend Commands

**Clear cache:**
```bash
docker exec -it booking_api_php php bin/console cache:clear
```

**Create new migration:**
```bash
docker exec -it booking_api_php php bin/console make:migration
```

**Update dependencies:**
```bash
docker exec -it booking_api_php composer update
```

### Frontend Commands

**Update dependencies:**
```bash
cd frontend
npm update
```

**Check for outdated packages:**
```bash
cd frontend
npm outdated
```

**Clear node_modules and reinstall:**
```bash
cd frontend
rm -rf node_modules package-lock.json
npm install
```

### Docker Commands

**Rebuild containers:**
```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

**Application logs:**
```bash
# Symfony logs
docker exec -it booking_api_php tail -f var/log/dev.log

# Nginx logs
docker logs -f booking_api_nginx

# PHP-FPM logs
docker logs -f booking_api_php
```

## 🐛 Troubleshooting

### Problem: "Connection refused" to database

```bash
# Check if MySQL container is running
docker ps | grep mysql

# Check MySQL logs
docker logs booking_api_mysql
```

### Problem: File permission errors

```bash
# Set proper permissions
docker exec -it booking_api_php chown -R www-data:www-data var/
docker exec -it booking_api_php chmod -R 775 var/
```

### Problem: Port already in use

Change ports in `docker-compose.yml`:
```yaml
nginx:
  ports:
    - "8090:80"  # Change from 8080 to 8090
```

### Problem: Frontend can't connect to API

1. Check if CORS is properly configured in `backend/.env`
2. Verify backend is running on http://localhost:8080
3. Check browser console for CORS errors
4. Ensure API endpoints are accessible

### Problem: npm install fails

```bash
cd frontend
rm -rf node_modules package-lock.json
npm cache clean --force
npm install
```

## 📝 Project Structure

```
.
├── backend/                 # Symfony application
│   ├── config/             # Configuration
│   ├── migrations/         # Database migrations
│   ├── src/
│   │   ├── Controller/     # Controllers
│   │   ├── Entity/         # Doctrine entities
│   │   ├── Repository/     # Repositories
│   │   ├── Service/        # Business logic
│   │   ├── Dto/           # Data Transfer Objects
│   │   └── Factory/        # Factories
│   ├── templates/          # Twig templates
│   └── tests/             # Tests
├── docker/                 # Docker configuration
│   ├── nginx/
│   ├── php/
│   └── mysql/
├── frontend/              # React application
│   ├── public/            # Static files
│   ├── src/               # Source code
│   │   ├── components/    # React components
│   │   ├── services/      # API services
│   │   └── styles/        # Stylesheets
│   └── package.json       # Node dependencies
└── docker-compose.yml     # Container orchestration
```

## 📄 License

Proprietary - All rights reserved
