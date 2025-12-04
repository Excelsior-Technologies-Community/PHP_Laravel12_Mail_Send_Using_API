# Laravel 12 API Mail Send Project Tutorial

**By:** Manasi Patel  
**Date:** 2025  
**Laravel Version:** 12  

This project demonstrates how to build a **Mail Send Project** using Laravel 12. Users can send emails via a form, view mail logs, and manage them via API endpoints. The project includes soft delete, status management, and full CRUD functionality for mail logs.

---

## Features

- Send emails via a form or API  
- Save sent emails in a `mail_logs` table  
- View list of emails (paginated)  
- Soft delete emails with restore option  
- Change email status (Active/Inactive)  
- Fully functional API endpoints  
- Beginner-friendly, fully commented  

---

## Prerequisites

- PHP >= 8.1  
- Composer  
- MySQL or MariaDB  
- Laravel 12  

---

## Installation & Setup

### 1. Install Laravel 12

```bash
composer create-project laravel/laravel laravel12-apimailsend "^12.0"
cd laravel12-apimailsend
2. Configure Database
Update .env:

env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apimailsend
DB_USERNAME=root
DB_PASSWORD=
Create the database:

sql

CREATE DATABASE apimailsend;
3. Create Migration for mail_logs Table
bash

php artisan make:migration create_mail_logs_table --create=mail_logs
Migration Columns:

id → Primary key

email → Recipient email address

subject → Email subject

message → Full email message

created_by → User ID who created the log (nullable)

updated_by → User ID who updated the log (nullable)

status → TinyInteger, default 1 (Active)

timestamps → created_at and updated_at

softDeletes → Adds deleted_at for soft deletes

Run migration:

bash

php artisan migrate
4. Configure Mail Settings
Update .env:

env

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="from@example.com"
MAIL_FROM_NAME="Laravel12-Mail"
Use Mailtrap for testing emails in a sandbox environment.

5. Create Model & Controller
bash

php artisan make:model MailLog -m
php artisan make:controller MailController --resource --model=MailLog
MailLog Model (app/Models/MailLog.php):

Use SoftDeletes trait

Fillable fields: email, subject, message, created_by, updated_by, status

MailController Responsibilities:

Show mail form

Send email and save logs

List all mails

View single mail

Soft delete and restore

Force delete

Change status (Active/Inactive)

6. Create API Controller
bash

php artisan make:controller Api/MailApiController --resource --model=MailLog
MailApiController Responsibilities:

Send email via API (POST /api/mail/send)

List emails (GET /api/mail/list)

View single email (GET /api/mail/view/{id})

Soft delete (GET /api/mail/delete/{id})

Restore soft deleted (GET /api/mail/restore/{id})

Force delete (GET /api/mail/force-delete/{id})

Change status (GET /api/mail/status/{id})

7. Define Routes
Web Routes (routes/web.php):

GET /email → Show email form

POST /send-email → Send email

GET /mail → List all mails

GET /mail/view/{id} → View mail

GET /mail/delete/{id} → Soft delete

GET /mail/restore/{id} → Restore soft deleted

GET /mail/force-delete/{id} → Permanently delete

GET /mail/status/{id} → Change status

API Routes (routes/api.php):

POST /mail/send → Send email via API

GET /mail/list → List emails

GET /mail/view/{id} → View single email

GET /mail/delete/{id} → Soft delete

GET /mail/restore/{id} → Restore soft deleted

GET /mail/force-delete/{id} → Permanent delete

GET /mail/status/{id} → Toggle Active/Inactive status

8. Create Mail Mailable
bash

php artisan make:mail TestMail
TestMail (app/Mail/TestMail.php):

Constructor accepts an array $details (title & body)

build() method sets subject and view

9. Run the Application
bash

php artisan serve
Access:

Web interface: http://localhost:8000/email

API endpoints: http://localhost:8000/api/mail/...

Workflow
User fills the email form or calls API endpoint.

Email is validated and saved in mail_logs.

Email is sent using Laravel Mailables.

Admin can view all email logs, with pagination.

Soft delete allows temporary deletion and restoration.

Status can be toggled between Active (1) and Inactive (0).

Force delete permanently removes a record from the database.

Commands Summary
bash

# 1. Create Laravel 12 project
composer create-project laravel/laravel laravel12-apimailsend "^12.0"

# 2. Create migration for mail_logs table
php artisan make:migration create_mail_logs_table --create=mail_logs

# 3. Run migrations
php artisan migrate

# 4. Create Model and Controller
php artisan make:model MailLog -m
php artisan make:controller MailController --resource --model=MailLog

# 5. Create API Controller
php artisan make:controller Api/MailApiController --resource --model=MailLog

# 6. Create Mail Mailable
php artisan make:mail TestMail

# 7. Run Laravel server
php artisan serve

✅ Congratulations!
