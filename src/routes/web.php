<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\MemoryController;
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

Route::get('/', [ MemoryController::class, 'index'])->name('memories.index');
Route::resource('memories', MemoryController::class)->except(['index']);

require __DIR__.'/auth.php';

Route::post('/memories/{memory_id}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/show/{user}', [ UserController::class, 'show'])->name('show');
    Route::get('/create/{user}', [ UserController::class, 'create'])->name('create');
    Route::post('/store/{user}', [ UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [ UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [ UserController::class, 'update'])->name('update');
});

Route::prefix('families')->name('families.')->group(function () {
    Route::get('/create/{family?}', [ FamilyController::class, 'create'])->name('create');
    Route::get('/edit/{family?}', [ FamilyController::class, 'edit'])->name('edit');
    Route::patch('/update/{family?}', [ FamilyController::class, 'update'])->name('update');
    Route::post('/store/{family?}', [ FamilyController::class, 'store'])->name('store');
});

Route::resource('children', ChildController::class)->except(['index','show']);
