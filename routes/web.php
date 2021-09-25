<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MeetingroomController;
use App\Http\Controllers\ObjectiveController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return Inertia::render('HelloWorld');
})->name('helloworld');

Route::get('/calendar', function () {
    return Inertia::render('Calendar');
})->name('calendar');

//ห้องประชุม
Route::get('/mroom/manage_meeting_room', [MeetingroomController::class, 'index'])->name('manage_meeting_room');
Route::get('/mroom/showall', [MeetingroomController::class, 'showall'])->name('show_all_meeting_room');
Route::get('/mroom/showall_delete', [MeetingroomController::class, 'showAllDelete'])->name('show_all_delete_meeting_room');
Route::post('/mroom/add', [MeetingroomController::class, 'store'])->name('add_meeting_room');
Route::post('/mroom/{id}/update', [MeetingroomController::class, 'update'])->name('update_meeting_room');
Route::delete('/mroom/{id}/delete', [MeetingroomController::class, 'delete'])->name('delete_meeting_room_tempolary');
Route::get('/mroom/{id}/restore', [MeetingroomController::class, 'restore'])->name('restore_meeting_room');

//วัตถุประสงค์การใช้ห้องประชุม
Route::get('/objective', [ObjectiveController::class, 'index'])->name('manage_objective');
