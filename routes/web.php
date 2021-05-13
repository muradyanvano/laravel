<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


Auth::routes(['verify'=>true]);

Route::get('/', [NoteController::class, 'index'])->name('home')->middleware('verified');

//Route::get('/home', [NoteController::class, 'index'])->name('home')->middleware('verified');

Route::resource('notes',NoteController::class);


Route::get('/recycle-notes',[NoteController::class, 'trash'])->name('notes.trash');
Route::get('/recycle-notes/{id}',[NoteController::class, 'restore'])->name('notes.restore');
Route::post('/recycle-notes',[NoteController::class, 'remove'])->name('notes.remove');
