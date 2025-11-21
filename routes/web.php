<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\checkloggedin;
use App\Http\Middleware\RoleCheckMiddleware;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

Route::get('/', [HomeController:: class, 'home'])->name('home');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/registration_submit', [AuthController::class, 'registration_submit'])->name('registration_submit');

Route::middleware(checkloggedin::class)->group(function(){
    Route::get('/dashboards', [HomeController::class, 'dashboards'])->name('dashboards');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/student/start_test', [HomeController::class, 'start_test'])->name('start_test');
    Route::post('/student/submit_answers', [HomeController::class, 'submit_answers'])->name('submit_answers');


    Route::middleware(RoleCheckMiddleware::class)->group(function(){
    Route::post('/show_single_question', [TeacherController::class, 'show_single_question'])->name('show_single_question');
    Route::post('/teacher/assign_test', [TeacherController::class, 'assign_test'])->name('assign_test');
    Route::get('/questions', [TeacherController:: class, 'add_questions'])->name('add_questions');
    Route::post('/teacher/delete_question', [TeacherController::class, 'delete_question'])->name('delete_question');
    Route::get('/view_questions', [TeacherController::class, 'view_questions'])->name('view_questions');
    Route::get('/teacher/assign_tests', [TeacherController::class, 'assign_tests'])->name('assign_tests');
    Route::post('/submit_questions', [TeacherController:: class, 'submit_questions'])->name('submit_questions');
    Route::get('/teacher/view_tests', [TeacherController::class, 'view_tests'])->name('view_tests');
    Route::post('/teacher/remove_tests', [TeacherController::class, 'remove_tests'])->name('remove_tests');
    Route::get('/teacher/add_category', [TeacherController::class, 'add_category'])->name('add_category');
    Route::get('/teacher/view_categories', [TeacherController::class, 'view_categories'])->name('view_categories');
    Route::post('/teacher/delete_category', [TeacherController::class, 'delete_category'])->name('delete_category');
    Route::post('/teacher/edit_category_submit', [TeacherController::class, 'edit_category_submit'])->name('edit_category_submit');
    Route::post('/teacher/add_category_submit', [TeacherController::class, 'add_category_submit'])->name('add_category_submit');


});
});
