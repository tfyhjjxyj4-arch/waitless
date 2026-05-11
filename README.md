# WaitLess - Restaurant Reservation & Queue System 🍽️

WaitLess is a professional PHP/MySQL web application designed to manage restaurant reservations and eliminate physical wait times. This project was developed to meet high academic standards, focusing on security, clean architecture, and modern UI/UX.

## ✨ Features
- **User Authentication**: Secure registration and login with Bcrypt password hashing.
- **Role-Based Access**: Separate dashboards for Customers and Administrators.
- **Reservation Engine**: Real-time booking system with status tracking (Pending, Confirmed, Cancelled).
- **Admin Panel**: Comprehensive statistics and booking management tools.
- **Modern UI**: Fully responsive design with Cairo typography and smooth animations.
- **Secure**: Protected against SQL Injection and unauthorized access.

## 🛠️ Tech Stack
- **Backend**: PHP (PDO)
- **Frontend**: HTML5, CSS3, FontAwesome
- **Database**: MySQL (3NF Normalized)

## 🚀 Setup Instructions (XAMPP)
1. **Download/Extract** the project folder into `C:/xampp/htdocs/`.
2. **Start** Apache and MySQL from the XAMPP Control Panel.
3. **Open** `http://localhost/phpmyadmin`.
4. **Create** a new database named `waitless_db`.
5. **Import** the SQL file located at `/database/waitless_db.sql`.
6. **Access** the app at `http://localhost/waitless`.

## 🔑 Default Credentials
- **Admin**: `admin@waitless.com` / `password123`
- **Customer**: `user@example.com` / `password123`

## 📁 Project Structure
```text
/WaitLess
├── /admin             # Admin management pages
├── /assets            # CSS, Images, JS
├── /database          # SQL schema files
├── /docs              # UML diagrams and Final Report
├── /includes          # Shared logic (DB, Auth, Header/Footer)
├── /reservations      # User reservation features
├── dashboard.php      # Customer Dashboard
├── index.php          # Landing Page
├── login.php          # Login Page
└── register.php       # Registration Page
```

---
*Developed for Academic Submission - 2026*
