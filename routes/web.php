<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'searched'])->name('search');

Route::post('/note/store', [NoteController::class, 'store'])->name('note.store');
Route::post('/note/delete', [NoteController::class, 'destroy'])->name('note.delete');
Route::get('/getNoteInfo/{id}', [NoteController::class, 'edit'])->name('note.edit');
Route::post('/note/updated', [NoteController::class, 'update'])->name('note.update');
