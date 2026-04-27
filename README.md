# MediCore — Hospital Management System

A full-stack Hospital Management System built as a DBMS course project at BITS Pilani Dubai Campus.

## Live Demo
https://hospitalmanagement-production-5612.up.railway.app

## Tech Stack
- **Frontend:** HTML, CSS, JavaScript (React via Babel, single-page app)
- **Backend:** PHP 8.2 with MySQLi
- **Database:** MySQL
- **Hosting:** Railway

## Features
- Dashboard with live stats — total patients, doctors, appointments, and billed amount
- Register new patients
- View doctors by department and specialization
- Book appointments (patient + doctor + date + time)
- View all appointments with status badges
- Auto-generated bills via MySQL `auto_bill` trigger after each booking

## Database Schema
**Tables:** Patient, Doctor, Department, Appointment, Bill

**Key feature:** The `auto_bill` trigger fires after every `INSERT` into `Appointment` and automatically creates a ₹500 bill record — no extra PHP required.

## Project Structure
```
index.html              — Full frontend SPA (React + Babel)
db.php                  — MySQL connection via Railway env vars
add_patient.php         — INSERT new patient, returns patient_id
book_appointment.php    — INSERT appointment (triggers auto bill)
get_patients.php        — SELECT all patients
get_doctors.php         — SELECT doctors with Department JOIN
get_appointments.php    — SELECT appointments with Patient + Doctor JOIN
get_bills.php           — SELECT bills with Patient JOIN
Hospital.sql            — Full schema, triggers, and sample data
nixpacks.toml           — Railway PHP 8.2 build config
```

## Local Setup
1. Install [XAMPP](https://www.apachefriends.org/)
2. Import `Hospital.sql` into phpMyAdmin
3. Copy all project files to `C:\xampp\htdocs\hospital\`
4. Visit `http://localhost/hospital/index.html`

## Deployment (Railway)
Environment variables required:
- `MYSQLHOST`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQL_DATABASE`, `MYSQLPORT`

## Team
- Adithya Sharath Kumar
- Daksh Anjaria
- Kriti Choudhary
- Ashima Elizabeth Reji
- Sharukesh Surendranth Easwar

**Course:** HSS F232 — Introduction to Development Studies  
**Institution:** BITS Pilani Dubai Campus
