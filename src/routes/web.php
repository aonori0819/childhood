<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\MemoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\InviteController;


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
    Route::patch('/update/{user}', [ UserController::class, 'update'])->name('update');
});

Route::prefix('families')->name('families.')->group(function () {
    Route::get('/create/', [ FamilyController::class, 'create'])->name('create');
    Route::post('/store/', [ FamilyController::class, 'store'])->name('store');
    Route::get('/edit/{family}', [ FamilyController::class, 'edit'])->name('edit');
    Route::patch('/update/{family}', [ FamilyController::class, 'update'])->name('update');
});

Route::resource('children', ChildController::class)->except(['index','show']);

Route::get('filters', [ FilterController::class, 'index'])->name('filters.index');
Route::get('filters/showByChild/{child_id}', [ FilterController::class, 'showByChild'])->name('filters.showByChild');
Route::get('filters/showByMonth/{month_year}', [ FilterController::class, 'showByMonth'])->name('filters.showByMonth');

Route::get('/invite', [InviteController::class, 'index'])->name('invite.index');;
Route::post('/invite/send', [InviteController::class, 'sendMail'])->name('invite.send');

