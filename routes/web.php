<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\BotController;
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

Route::get('/', [MainController::class, 'index'])->name('index');
Route::post('register', [MainController::class, 'register'])->name('register');
Route::post('login', [MainController::class, 'login'])->name('login');
Route::get('/participation/{participation}', [ParticipationController::class, 'participation'])->name('participation');
Route::post('bot', [BotController::class, 'interact'])->name('interact');
Route::post('conversation', [BotController::class, 'conversation'])->name('conversation');
