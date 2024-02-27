<?php

use App\Http\Controllers\HomeController;
use App\Models\Command;
use App\Models\Modifier;
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
    $modifier = 'grep';
    $mods = Modifier::where('command', 'LIKE', '%' . $modifier . '%')
        ->pluck('command');
    dd($mods->toArray());
    // Do what thou wilt
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
