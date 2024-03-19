<?php

use App\Http\Controllers\HomeController;
use App\Models\Command;
use App\Models\Connection;
use App\Models\Modifier;
use App\Services\ShellService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;

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

Route::get('/dev', function () {
    $connectName = 'Bogusx';
    $connection = Connection::where('name', $connectName)->first();
    !d($connection);

    // Do what thou wilt
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/connection', [HomeController::class, 'editConnection'])->name('connection');
Route::get('/script', [HomeController::class, 'editScripts'])->name('script');
Route::get('/modifier', [HomeController::class, 'editModifiers'])->name('modifier');
