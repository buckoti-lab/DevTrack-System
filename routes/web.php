<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\QuoteController; 
use App\Http\Controllers\ChangepasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DemoController;

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'getLogin'])->name('get.login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('post.login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
      Route::view('/dashboard', 'dashboard')->name('dashboard');
      Route::get('/home',[AdminHomeController::class,'index'])->name('home');
      Route::view('/client_dashboard', 'client_dashboard')->name('client_dashboard');
      Route::get('/progress', [ProgressController::class, 'index'])->name('progress');
      Route::get('/progress/{id}/tasks', [ProgressController::class, 'tasks']);
      Route::put('/tasks/{id}/edit', [ProgressController::class, 'editTask']);
      Route::get('/tasks/{id}/view', [ProgressController::class, 'viewTask']);
      Route::post('/tasks/{task}/status', [ProgressController::class, 'updateTaskStatus']);
      Route::put('/project/edit/{id}/{status}',[ProjectController::class,'edit']);
      Route::get('/project/edit/{id}',[ProjectController::class,'index']);

      Route::get('/demo/{id}',[DemoController::class,'index']);
      Route::post('/demo/store',[DemoController::class,'store'])->name("demo.store");
      Route::get('/demo/view/{id}',[DemoController::class,'view'])->name("demo.view");
      Route::put('/demo/edit/',[DemoController::class,'edit'])->name("demo.edit");
      Route::delete('/demo/delete/{id}',[DemoController::class,'delete'])->name("demo.delete");

});

Route::post('/dashboard_api', [DashboardController::class, 'dashboardApi']); 

Route::get('/edit_profile', [EditProfileController::class, 'edit'])->name('edit_profile'); 
Route::put('/update_profile', [EditProfileController::class, 'update'])->name('update_profile'); 


Route::view('/view_profile','view_profile')->name('view_profile');

Route::view('/change_password','change_password')->name('change_password');
Route::post('/change_password_api', [ChangepasswordController::class, 'changePassword']);


Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
Route::get('/client_quotes', [QuoteController::class, 'client'])->name('quotes.client');
Route::get('/quotes/create', [QuoteController::class, 'create'])->name('quotes.create');
Route::post('/quotes/store', [QuoteController::class, 'store'])->name('quotes.store');
Route::get('/quotes/edit/{id}', [QuoteController::class, 'edit'])->name('quotes.edit');
Route::put('/quotes/update/{id}', [QuoteController::class, 'update'])->name('quotes.update');
Route::delete('/quotes/delete/{id}', [QuoteController::class, 'destroy'])->name('quotes.delete');
Route::get('/quotes/pdf/{id}', [QuoteController::class, 'downloadPdf'])->name('quotes.pdf');
Route::get('/quotes/view/{id}',[QuoteController::class, 'viewPdf']);
Route::get('/quotes/export-pdf', [QuoteController::class, 'exportPDF'])->name('quotes.exportPDF');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
Route::get('/users/export-pdf', [UserController::class, 'exportPDF'])->name('users.exportPDF');



Route::get('/announcements',[AnnouncementController::class,'index'])->name('announcements.index');
Route::get('/announcements/client',[AnnouncementController::class,'index'])->name('announcements.index');
Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
Route::put('/announcements/update/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
Route::delete('/announcements/delete/{id}', [AnnouncementController::class, 'delete'])->name('announcements.delete');
Route::get('/announcements/export-pdf', [AnnouncementController::class, 'exportPDF'])->name('announcements.exportPDF');


Route::get('/documents', [DocumentController::class, 'index'])->name('document.index');
Route::post('/document/store', [DocumentController::class, 'store'])->name('document.store');
Route::put('/document/update/{id}', [DocumentController::class, 'update'])->name('document.update');
Route::delete('/document/delete/{id}', [DocumentController::class, 'delete'])->name('document.delete');
Route::get('/document/view/{id}', [DocumentController::class, 'view'])->name('document.view');
Route::get('/document/download/{id}', [DocumentController::class, 'download'])->name('document.download');


// Show reset password form
Route::get('/reset_user_password', [ResetPasswordController::class, 'showResetForm'])->name('showResetForm');
/*Route::post('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
     ->name('password.reset');*/

// Handle password update
Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])
     ->name('password.update');