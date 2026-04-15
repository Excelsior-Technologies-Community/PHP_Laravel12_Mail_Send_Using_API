<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MailApiController;

// ================================
// MAIL API ROUTES (ONLY GET + POST)
// ================================

// Send Email (POST)
Route::post('/mail/send', [MailApiController::class, 'send']);

// List Emails (GET)
Route::get('/mail/list', [MailApiController::class, 'list']);

// View Single Email (GET)
Route::get('/mail/view/{id}', [MailApiController::class, 'view']);

// Soft Delete Email (GET)
Route::get('/mail/delete/{id}', [MailApiController::class, 'delete']);

// Restore Soft Deleted Email (GET)
Route::get('/mail/restore/{id}', [MailApiController::class, 'restore']);

// Permanent Delete Email (GET)
Route::get('/mail/force-delete/{id}', [MailApiController::class, 'forceDelete']);

// Change Email Status (GET)
Route::get('/mail/status/{id}', [MailApiController::class, 'changeStatus']);

// Resend Email (GET)
Route::get('/mail/resend/{id}', [MailApiController::class, 'resend']);
