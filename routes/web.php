<?php

use App\Http\Controllers\HomeController;
use App\Models\Command;
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
    $command = 'rm rm_test.txt';
    $disallowed = false;
    !d(ShellService::DISALLOWED_COMMANDS);
    collect(explode(' ', $command))
        ->each(function ($word) use (&$disallowed) {

            if (in_array($word, ShellService::DISALLOWED_COMMANDS)) {
                $disallowed = true;
            }
        });

    if ($disallowed) {
        echo 'zap';
    }
    // Do what thou wilt
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/shell', [HomeController::class, 'index'])->name('shell');
Route::get('/script_edit', [HomeController::class, 'editScripts'])->name('script_edit');
Route::get('/modifier_edit', [HomeController::class, 'editModifiers'])->name('modifier_edit');
