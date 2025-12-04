<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;

// Default homepage
Route::get('/', function () {
    return view('welcome');
});

// ================================
// MAIL MODULE ROUTES
// ================================

// Show email form to send mail
Route::get('/email', [MailController::class, 'index']);      

// Process sending of email
Route::post('/send-email', [MailController::class, 'send']); 

// ================================
// ADMIN PANEL ROUTES FOR MAIL LOGS
// ================================

// List all mails (paginated)
Route::get('/mail', [MailController::class, 'list']);                

// View details of a single mail by ID
Route::get('/mail/view/{id}', [MailController::class, 'view']);      

// Soft delete a mail (moves to trashed)
Route::get('/mail/delete/{id}', [MailController::class, 'delete']);  

// Restore a soft-deleted mail
Route::get('/mail/restore/{id}', [MailController::class, 'restore']); 

// Permanently delete a mail from database
Route::get('/mail/force-delete/{id}', [MailController::class, 'forceDelete']); 

// Toggle mail status between active (1) and inactive (0)
Route::get('/mail/status/{id}', [MailController::class, 'changeStatus']); 

