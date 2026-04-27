# PHP JWT Authentication and Product Management API

This project is a lightweight full-stack application built using Core PHP, MySQL, and Vanilla JavaScript. It demonstrates authentication using JWT, protected API routes, and basic CRUD operations.

---

## Tech Stack

* Frontend: HTML, JavaScript
* Backend: Core PHP
* Database: MySQL
* Authentication: JWT (firebase/php-jwt)
* Database Access: PDO
* Environment Variables: phpdotenv
* Package Manager: Composer




---

## Setup Instructions

### 1. Clone the Repository

```
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
```

---

### 2. Install Dependencies

```
composer install
```

---

### 3. Configure Environment

Create a `.env` file in the root directory:

```
DB_HOST=localhost
DB_NAME=your_database
DB_USER=root
DB_PASS=

JWT_SECRET=your_secret_key
```

---

### 4. Setup Database

Create required tables:

```
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(255)
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  price DECIMAL(10,2)
);
```

Insert a test user:

```
INSERT INTO users (username, password)
VALUES ('admin', '$2y$10$examplehashedpassword');
```

Use PHP `password_hash()` to generate a valid password hash.

---

### 5. Run the Project

* Start Apache and MySQL (XAMPP or similar)
* Place the project inside the `htdocs` directory
* Open in browser:

```
http://localhost/PHP/public/login
```

---

## Authentication Flow

1. User submits login credentials
2. Backend validates username and password
3. JWT token is generated
4. Token is stored in browser localStorage
5. All API requests include Authorization header

```
Authorization: Bearer <token>
```

---

## API Endpoints

### Authentication

* POST `/api/login`
  Authenticates user and returns JWT token

---

### Products

* GET `/api/products`
  Returns all products

* POST `/api/products`
  Creates a new product

* PATCH `/api/products`
  Updates an existing product

* DELETE `/api/products/{id}`
  Deletes a product

---

## Application Flow

```
Frontend (JavaScript)
    ↓
Fetch API Requests
    ↓
index.php (Entry Point)
    ↓
Router (web.php)
    ↓
Controller
    ↓
Middleware (JWT validation)
    ↓
Model
    ↓
Database (MySQL)
```

---

## Security Features

* Password hashing using password_hash and password_verify
* JWT-based authentication
* Middleware protection for secured routes
* Prepared statements using PDO to prevent SQL injection

---


