# অতিথি | Atithi 🏨

> A vulnerable hotel booking system built for cybersecurity (SQL Injection) practice.

---

## 🎯 Project Purpose

This project is built as part of a **Cybersecurity Course** at **BUBT (Bangladesh University of Business and Technology)**. It demonstrates common web vulnerabilities — especially **SQL Injection** — in a controlled, ethical lab environment running on **Kali Linux + Apache**.

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML, Tailwind CSS (CDN), Axios |
| Backend | PHP |
| Database | MySQL |
| Server | Apache (Kali Linux) |

---

## 📁 File Structure

```
/var/www/html/
│
├── index.html                  # Home page
├── rooms.html                  # All rooms list with filter
├── booking.html                # Room booking form
├── login.html                  # User login
├── register.html               # User registration
├── dashboard.html              # User dashboard & bookings
│
├── css/
│   └── style.css               # Custom styles
│
├── js/
│   ├── main.js                 # Common JS (navbar, utils)
│   ├── rooms.js                # Rooms page logic
│   ├── booking.js              # Booking form logic
│   ├── auth.js                 # Login/Register logic
│   └── dashboard.js            # Dashboard logic
│
├── api/                        # PHP Backend
│   ├── config/
│   │   └── db.php              # MySQL connection
│   │
│   ├── auth/
│   │   ├── login.php           # Login API
│   │   └── register.php        # Register API
│   │
│   ├── rooms/
│   │   ├── get_rooms.php       # Fetch all rooms
│   │   └── get_room.php        # Fetch single room
│   │
│   └── booking/
│       ├── create.php          # Create booking
│       └── my_bookings.php     # User bookings list
│
└── assets/
    └── images/
        └── rooms/              # Room images
```

---

## 🗄️ Database Schema

```sql
CREATE DATABASE atithi_db;
USE atithi_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  phone VARCHAR(20),
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  type VARCHAR(50),
  price DECIMAL(10,2),
  capacity INT,
  description TEXT,
  image VARCHAR(255)
);

CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  room_id INT,
  check_in DATE,
  check_out DATE,
  guests INT,
  special_requests TEXT,
  payment_method VARCHAR(50),
  status VARCHAR(50) DEFAULT 'confirmed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (room_id) REFERENCES rooms(id)
);
```

---

## ⚙️ Installation & Setup

### 1. Prerequisites

```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysqli -y
```

### 2. Start Services

```bash
sudo service apache2 start
sudo service mysql start
```

### 3. Clone Repository

```bash
cd /var/www/html
sudo git clone https://github.com/Tarikul3639/atithi.git .
```

### 4. Setup Database

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE atithi_db;
USE atithi_db;
SOURCE /var/www/html/database/schema.sql;
```

### 5. Configure DB Connection

Edit `api/config/db.php`:

```php
<?php
$host = "localhost";
$user = "root";
$password = "your_password";
$database = "atithi_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
  die(json_encode(["success" => false, "message" => "Connection failed"]));
}
?>
```

### 6. Open in Browser

```
http://localhost
```

---

## 🔥 SQL Injection Vulnerabilities

This project is **intentionally vulnerable** for educational purposes. The following endpoints are vulnerable to SQL Injection:

| Endpoint | Type | Payload Example |
|----------|------|----------------|
| `api/auth/login.php` | Authentication Bypass | `' OR '1'='1` |
| `api/rooms/get_room.php?id=` | URL Parameter Injection | `1 OR 1=1` |
| `api/booking/my_bookings.php` | Data Extraction | `' UNION SELECT ...` |

### Example Attack — Login Bypass

```
Email:    ' OR '1'='1' --
Password: anything
```

---

## 📄 Pages Overview

| Page | URL | Description |
|------|-----|-------------|
| Home | `/index.html` | Landing page with hotel info |
| Rooms | `/rooms.html` | Browse & filter rooms |
| Booking | `/booking.html` | Book a room |
| Login | `/login.html` | User login |
| Register | `/register.html` | New user registration |
| Dashboard | `/dashboard.html` | View & manage bookings |

---

## ⚠️ Disclaimer

> This project is built **strictly for educational and ethical hacking practice**. All attacks must be performed only on this local lab environment. Unauthorized use on real systems is illegal.

---

## 👨‍💻 Author

**Tarikul Islam**
BSc in Computer Science & Engineering
Bangladesh University of Business and Technology (BUBT)
GitHub: [@Tarikul3639](https://github.com/Tarikul3639)
Portfolio: [tarikul-islam.me](https://tarikul-islam.me)