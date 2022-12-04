<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\MarkListController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Login  Routes
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

//Teacher Routes
Route::get('teachers', [TeachersController::class, 'index'])->name('teachers');
Route::post('teachers.store',[TeachersController::class, 'store'])->name('teachers.create');
Route::get('teachers/add',[TeachersController::class, 'create'])->name('teachers.add');
Route::get('teachers.edit/{id}',[TeachersController::class, 'edit'])->name('teachers.edit');
Route::post('teachers.update',[TeachersController::class, 'update'])->name('teachers.update');
Route::get('teachers.delete/{id}',[TeachersController::class, 'destroy'])->name('teachers.delete');
Route::get('teachers.show/{id}',[TeachersController::class, 'show'])->name('teachers.show');

//Students Routes
Route::get('students', [StudentsController::class, 'index'])->name('students');
Route::post('students.store',[StudentsController::class, 'store'])->name('students.create');
Route::get('students/add',[StudentsController::class, 'create'])->name('students.add');
Route::get('students.edit/{id}',[StudentsController::class, 'edit'])->name('students.edit');
Route::post('students.update',[StudentsController::class, 'update'])->name('students.update');
Route::get('students.delete/{id}',[StudentsController::class, 'destroy'])->name('students.delete');

// Student MarkList Routes
Route::get('mark-list', [MarkListController::class, 'index'])->name('mark-list');
Route::post('mark-list.store',[MarkListController::class, 'store'])->name('mark-list.create');
Route::get('mark-list/add',[MarkListController::class, 'create'])->name('mark-list.add');
Route::get('mark-list.edit/{id}',[MarkListController::class, 'edit'])->name('mark-list.edit');
Route::post('mark-list.update',[MarkListController::class, 'update'])->name('mark-list.update');
Route::get('mark-list.delete/{id}',[MarkListController::class, 'destroy'])->name('mark-list.delete');
