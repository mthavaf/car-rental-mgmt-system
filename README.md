# Car Rental Management System

A web-based car rental management system with support for multiple user roles: Admin, Customer, Organization, and Supplier.

## Features

- **Admin Panel**: Manage cars, customers, organizations, and suppliers
- **Customer Portal**: Browse cars, make bookings, manage reservations
- **Organization Portal**: Manage fleet of cars
- **Supplier Portal**: Supply and manage cars

## Tech Stack

- **Backend**: PHP 8.1 with MySQLi
- **Database**: MySQL 8.0
- **Frontend**: HTML5, CSS3, JavaScript
- **Containerization**: Docker & Docker Compose

## Getting Started with Docker (Recommended)

### Requirements
- Docker Desktop installed
- Docker Compose v2.0+

### 1. Start the Application
```bash
cd /Users/thavaf/projects/car-rental
docker-compose up -d
```

This will:
- Start MySQL database on port 3306
- Start PHP/Apache server on port 8080
- Automatically import the database schema

### 2. Access the Application
- **Homepage**: http://localhost:8080
- **Admin**: http://localhost:8080/adminhome.html
- **Customer**: http://localhost:8080/index.html

### 3. Default Test Accounts
```
Admin: admin / admin
Organization: org1 / org123
Customer: Register via portal
Supplier: supplier1 / supplier123
```

### 4. Stop the Application
```bash
docker-compose down
```

## File Structure

```
├── admin/                  - Admin portal
├── customer/               - Customer portal
├── organization/           - Organization portal
├── supplier/               - Supplier portal
├── schema/                 - Database schema
├── images/                 - Static images
├── index.html              - Homepage
├── config.php              - Database config
├── docker-compose.yml      - Docker setup
└── .env                    - Environment variables
```

## Database Schema

Core tables:
- `admin` - Admin users
- `customer` - Customers
- `organization` - Organizations
- `supplier` - Suppliers
- `car_list` - Available cars
- `image` - Stored images
- `transaction` - Bookings

## Security Note

⚠️ Current version has SQL injection vulnerabilities. For production use, updates are needed:
- Use prepared statements
- Hash passwords
- Add CSRF protection
- Enable HTTPS

## Troubleshooting

```bash
# View logs
docker-compose logs php
docker-compose logs mysql

# Check database
docker exec car-rental-db mysql -ucar_user -pcar_password car -e "SHOW TABLES;"

# Reset everything
docker-compose down -v
docker-compose up -d
```

---

**Version**: 1.0 | **Updated**: March 31, 2026