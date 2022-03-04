<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoryController;

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

Route::get('/', [ MemoryController::class, 'index'])->middleware('auth')->name('memories.index');
Route::resource('memories', MemoryController::class)->except(['index'])->middleware('auth');

require __DIR__.'/auth.php';
