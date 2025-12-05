 Laravel 12 API Mail Send Project

**Project Name:** Laravel12-ApiMailSend  
**Author:** Manasi Patel  
**Date:** 2025  
**Laravel Version:** 12  

This project allows users to send emails via a form, view logs of sent emails, and manage them. It includes Laravel Mailables, soft deletes, status management, and a clean Bootstrap 5 frontend. It also provides API endpoints for all mail operations.

---

## ⭐ Features

- Send emails via a form
- Save email logs in the database
- View email logs with pagination
- Soft delete, restore, and permanently delete email logs
- Toggle email log status (Active/Inactive)
- View details of a single email
- Responsive UI with Bootstrap 5
- API endpoints for all mail operations
- Fully commented and beginner-friendly code

---

## 🔥 Requirements

- PHP 8.1+
- Laravel 12
- MySQL
- Composer
- SMTP account (e.g., Mailtrap for testing)

---

## 🚀 Installation Steps

### Step 1: Install Laravel 12

```bash
composer create-project laravel/laravel laravel12-Apimailsend "^12.0"
cd laravel12-Apimailsend
Step 2: Configure Database
Edit .env file:

makefile

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apimailsend
DB_USERNAME=root
DB_PASSWORD=
Create the database:

sql

CREATE DATABASE apimailsend;
Step 3: Create Migration for Mail Logs Table
bash

php artisan make:migration create_mail_logs_table --create=mail_logs
Edit the migration database/migrations/xxxx_xx_xx_create_mail_logs_table.php:

php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('subject');
            $table->longText('message');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_logs');
    }
};
Run migration:

bash

php artisan migrate
Step 4: Configure Mail Settings
Edit .env:

ini

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="from@example.com"
MAIL_FROM_NAME="Laravel12-Mail"
Step 5: Create Model & Controller
bash

php artisan make:model MailLog -m
php artisan make:controller MailController --resource --model=MailLog
php artisan make:mail TestMail
php artisan make:controller Api/MailApiController --resource --model=MailLog
MailLog Model (app/Models/MailLog.php)
php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email','subject','message','created_by','updated_by','status'
    ];
}
MailController (app/Http/Controllers/MailController.php)
php

<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\MailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index() { return view('mails.form'); }
    public function create() { return view('mails.form'); }

    public function send(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required',
        ]);

        $log = MailLog::create([
            'email'=>$request->email,
            'subject'=>$request->subject,
            'message'=>$request->message,
            'created_by'=>1,
            'status'=>1,
        ]);

        $details = ['title'=>$request->subject,'body'=>$request->message];
        Mail::to($request->email)->send(new TestMail($details));

        return view('mails.success');
    }

    public function list() {
        $mails = MailLog::where('status',1)->orderBy('id','ASC')->paginate(10);
        return view('mails.index', compact('mails'));
    }

    public function view($id) { $mail = MailLog::findOrFail($id); return view('mails.view', compact('mail')); }
    public function delete($id) { MailLog::findOrFail($id)->delete(); return redirect()->back()->with('success','Mail deleted successfully!'); }
    public function restore($id) { MailLog::withTrashed()->findOrFail($id)->restore(); return redirect()->back()->with('success','Mail restored successfully!'); }
    public function forceDelete($id) { MailLog::withTrashed()->findOrFail($id)->forceDelete(); return redirect()->back()->with('success','Mail permanently deleted!'); }
    public function changeStatus($id) { $mail = MailLog::findOrFail($id); $mail->status = $mail->status==1?0:1; $mail->save(); return redirect()->back()->with('success','Status updated!'); }
}
TestMail Mailable (app/Mail/TestMail.php)
php

<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class TestMail extends Mailable
{
    public $details;
    public function __construct($details) { $this->details = $details; }
    public function build() { return $this->subject($this->details['title'])->view('emails.test'); }
}
Step 6: Routes
routes/web.php

php
Copy code
use App\Http\Controllers\MailController;

Route::get('/email',[MailController::class,'index']);
Route::post('/send-email',[MailController::class,'send']);
Route::get('/mail',[MailController::class,'list']);
Route::get('/mail/view/{id}',[MailController::class,'view']);
Route::get('/mail/delete/{id}',[MailController::class,'delete']);
Route::get('/mail/restore/{id}',[MailController::class,'restore']);
Route::get('/mail/force-delete/{id}',[MailController::class,'forceDelete']);
Route::get('/mail/status/{id}',[MailController::class,'changeStatus']);
routes/api.php

php

use App\Http\Controllers\Api\MailApiController;

Route::post('/mail/send',[MailApiController::class,'send']);
Route::get('/mail/list',[MailApiController::class,'list']);
Route::get('/mail/view/{id}',[MailApiController::class,'view']);
Route::get('/mail/delete/{id}',[MailApiController::class,'delete']);
Route::get('/mail/restore/{id}',[MailApiController::class,'restore']);
Route::get('/mail/force-delete/{id}',[MailApiController::class,'forceDelete']);
Route::get('/mail/status/{id}',[MailApiController::class,'changeStatus']);



Step 7: Blade Views

resources/views/layouts/app.blade.php
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Mail App</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .navbar { margin-bottom: 20px; text-align: center; }
        .card { border-radius: 15px; }
        body { background: #f5f6fa; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark w-100 shadow-sm">
    <div class="container-fluid d-flex justify-content-center">
        <span class="navbar-brand mb-0 h1" style="font-size: 22px;">Mail Sender</span>
    </div>
</nav>

<!-- Main content -->
<div class="container">
    @yield('content')
</div>

</body>
</html>

2️⃣ resources/views/mails/form.blade.php
@extends('layouts.app')
@section('content')
<br>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Send Email</h4>
            </div>
            <div class="card-body">
                <form action="/send-email" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Send Email</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

3️⃣ resources/views/mails/index.blade.php
@extends('layouts.app')
@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Mail Logs</h4>
        <a href="{{ url('/email') }}" class="btn btn-success btn-sm mb-3">Send Email</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mails as $mail)
                <tr>
                    <td>{{ $mail->id }}</td>
                    <td>{{ $mail->email }}</td>
                    <td>{{ $mail->subject }}</td>
                    <td>
                        @if($mail->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $mail->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ url('/mail/view/'.$mail->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ url('/mail/delete/'.$mail->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No Email Logs Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $mails->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

4️⃣ resources/views/mails/view.blade.php
@extends('layouts.app')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header text-white text-center py-4 rounded-top-4" style="background: linear-gradient(90deg, #4e73df, #1cc88a);">
                    <h3 class="mb-0"><i class="bi bi-envelope-fill me-2"></i>Email Details</h3>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold">Recipient Email</h6>
                        <div class="p-3 border rounded bg-light text-break">{{ $mail->email }}</div>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold">Subject</h6>
                        <div class="p-3 border rounded bg-light text-break">{{ $mail->subject }}</div>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted fw-bold">Message</h6>
                        <div class="p-3 border rounded bg-light" style="white-space: pre-wrap;">{{ $mail->message }}</div>
                    </div>
                    <div class="row mb-4 g-3 text-center">
                        <div class="col-md-6">
                            <div class="p-3 border rounded shadow-sm bg-white">
                                <h6 class="text-muted fw-bold mb-2"><i class="bi bi-toggle-on me-2"></i>Status</h6>
                                @if($mail->status == 1)
                                    <span class="badge bg-success px-3 py-2 fs-6">Active</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 fs-6">Inactive</span>
                                @endif
                                @if($mail->deleted_at)
                                    <span class="badge bg-warning text-dark px-3 py-2 fs-6 ms-1">Deleted</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded shadow-sm bg-white">
                                <h6 class="text-muted fw-bold mb-2"><i class="bi bi-calendar-check me-2"></i>Created At</h6>
                                <div>{{ $mail->created_at->format('d-m-Y H:i A') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <a href="{{ url('/mail') }}" class="btn btn-secondary btn-lg shadow-sm">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

5️⃣ resources/views/mails/success.blade.php
@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Success!</h4>
            </div>
            <div class="card-body text-center">
                <h3 class="text-success">✔ Email Sent Successfully</h3>
                <p>Your message was delivered to the recipient.</p>
                <a href="/email" class="btn btn-primary mt-3">Send Another Email</a>
                <a href="/mail" class="btn btn-primary mt-3">List Emails</a>
            </div>
        </div>
    </div>
</div>
@endsection

6️⃣ resources/views/emails/test.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $details['title'] }}</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
        img { -ms-interpolation-mode: bicubic; }
        body { margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4; }
        .email-container { max-width:600px; margin:40px auto; background-color:#fff; border-radius:8px; overflow:hidden; box-shadow:0px 4px 10px rgba(0,0,0,0.1); }
        .email-header { background-color:#007bff; color:#fff; padding:20px; text-align:center; }
        .email-body { padding:20px; color:#333; line-height:1.6; }
        .email-footer { background-color:#f1f1f1; color:#555; text-align:center; padding:15px; font-size:12px; }
        @media screen and (max-width: 600px){ .email-container { width:100% !important; margin:0 !important; } }
    </style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f4f4f4">
<tr>
<td>
<table class="email-container" cellpadding="0" cellspacing="0">
<tr><td class="email-header"><h1>{{ $details['title'] }}</h1></td></tr>
<tr><td class="email-body"><p>{{ $details['body'] }}</p></td></tr>
<tr><td class="email-footer">&copy; {{ date('Y') }} Your Company. All rights reserved.</td></tr>
</table>
</td>
</tr>
</table>
</body>
</html>

Step 8: Run the Application
php artisan serve


Visit:

http://localhost:8000/email
http://localhost:8000/mail


API endpoints:

POST   /api/mail/send
GET    /api/mail/list
GET    /api/mail/view/{id}
GET    /api/mail/delete/{id}
GET    /api/mail/restore/{id}
GET    /api/mail/force-delete/{id}
GET    /api/mail/status/{id}


✅ You now have a fully functional Laravel 12 API Mail Send Project with:

Form-based mail sending

Mail logs with pagination

Soft delete, restore, force delete

Status toggle



