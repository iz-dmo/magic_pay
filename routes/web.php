<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/',[PageController::class,'index']);
Route::get('admin/login',[AdminLoginController::class,'showLoginForm']);
Route::post('admin/login',[AdminLoginController::class,'login'])->name('admin-login');
Route::get('admin/register',[AdminLoginController::class,'showRegisterForm']);
Route::post('admin/register',[AdminLoginController::class,'Register'])->name('admin-submit');

Route::prefix('backend')->middleware('auth:admin_user')->group(function(){
    Route::get('/',[DashboardController::class,'Dashboard'])->name('dashboard');
    // admin crud path
    Route::get('admin-managements', [AdminUserController::class, 'AdminList'])->name('admin-managements');
    Route::get('admin-register',[AdminUserController::class,"RegisterPage"]);
    Route::post('admin-register',[AdminUserController::class,"AdminRegister"])->name('admin-register');
    Route::get('admin-users-edit/{id}',[AdminUserController::class,"AdminEdit"])->name('admin-users-edit');
    Route::post('admin-users-update/{id}',[AdminUserController::class,"AdminUpdate"])->name('admin-users-update');
    Route::delete('admin-users-delete/{id}',[AdminUserController::class,"Delete"])->name('admin-users-delete');

    //user crud path
    Route::resource('users',UserController::class);
});


