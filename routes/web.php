<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\StepsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;

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
Route::get('/steps/project/{projects}', [StepsController::class, 'getStepByProject']);
Route::get('/tasks/step/{stepId}', [TasksController::class, 'getTaskByStep']);

Route::resource('projects', ProjectsController::class, ['index', 'store', 'update', 'destroy']);
Route::resource('steps', StepsController::class, ['store', 'update', 'destroy']);
Route::resource('tasks', TasksController::class, ['store', 'update', 'destroy']);


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/get-users', [UserController::class, 'getUsers']);
