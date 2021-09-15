<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MeetingroomController;

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

Route::get('/sysadmin/manage_meeting_room', [MeetingroomController::class, 'index'])->name('manage_meeting_room');
