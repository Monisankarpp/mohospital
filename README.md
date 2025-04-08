# 🏥 Mohospital - Laravel 11/12 Based Healthcare Management System

![Laravel](https://img.shields.io/badge/Laravel-11-red)
![License](https://img.shields.io/badge/License-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-^8.2-blue)
![Status](https://img.shields.io/badge/Project%20Status-In%20Development-yellow)

Mohospital is a **comprehensive healthcare web platform** developed using **Laravel 11/12**, designed to cater to Patients, Doctors, Hospital Owners, Medical Store Owners, and Super Admins. It enables role-based access and includes a full-fledged hospital appointment system, prescription & medicine order management, lab reports, notifications, and financial operations.

---

## 🚀 Features by Modules & Estimated Time

### 🧑‍💻 Authentication & User Management

### 🧑‍⚕️ Patient Module

### 👨‍⚕️ Doctor Module

### 🏥 Hospital Owner Module

### 💊 Medical Store Module

### 💊 Medicine Order Module

### ⏰ Appointment & Scheduling

### 🧾 Prescription & Lab Module

### 💳 Payment & Billing Module

### 🔔 Notifications & Communication

### 👑 Super Admin Panel


---

## 🧰 Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** Blade, Bootstrap 5, jQuery, AdminLTE
- **Database:** MySQL
- **Payments:** Stripe Integration
- **Notifications:** Laravel Notifications (Email, Database)
- **Other:** RESTful APIs, Form Request Validation, Policies & Gates, Soft Deletes, Seeder & Factory Support

---

## 🛠️ Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/mohospital.git
cd mohospital

# Install dependencies
composer install
npm install && npm run build

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your database in .env
php artisan migrate --seed

# Serve the application
php artisan serve
