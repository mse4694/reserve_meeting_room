<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MeetingroomController;
use App\Http\Controllers\RecycleBinMeetingRoomController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\WorkUnitController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;

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

//MeetingroomController => จัดการ เพิ่ม แก้ไข หรือ ลบห้องประชุมแบบชั่วคราว  
Route::get('/mroom/manage_meeting_room', [MeetingroomController::class, 'index'])->name('manage_meeting_room');
Route::post('/mroom/add', [MeetingroomController::class, 'store'])->name('add_meeting_room');
Route::post('/mroom/{id}/update', [MeetingroomController::class, 'update'])->name('update_meeting_room');
Route::delete('/mroom/{id}/tdelete', [MeetingroomController::class, 'destroy'])->name('delete_meeting_room_tempolary');

//RecycleBinMeetingRoomController => จัดการ restore หรือ ลบห้องประชุมแบบถาวร 
Route::get('/mroom/recycle_bin', [RecycleBinMeetingRoomController::class, 'index'])->name('recycle_bin_meeting_room');
Route::patch('/mroom/{id}/restore', [RecycleBinMeetingRoomController::class, 'store'])->name('restore_meeting_room');
Route::delete('/mroom/{id}/pdelete', [RecycleBinMeetingRoomController::class, 'destroy'])->name('delete_meeting_room_permanance');

//ObjectiveController => วัตถุประสงค์การใช้ห้องประชุม
Route::get('/objective', [ObjectiveController::class, 'index'])->name('manage_objective');
Route::post('/objective/add', [ObjectiveController::class, 'store'])->name('add_objective');
Route::patch('/objective/{id}/update', [ObjectiveController::class, 'update'])->name('update_objective');

//WorkUnitController => หน่วยงาน
Route::get('/workunit', [WorkUnitController::class, 'index'])->name('manage_workunit');

//EventController => แสดง และ จัดการ event การจองห้องประชุม
Route::get('/event', [EventController::class, 'index'])->name('event_all');
Route::get('/event/{id}/show', [EventController::class, 'show'])->name('event_show');
Route::get('/event/add', [EventController::class, 'create'])->name('event_add');

//แสดง Event 
// Route::get('/eventDisplay/{eventId}', function ( $eventId ) {
//     \Log::info($eventId);
//     return Inertia::render('EventDisplay', ['eventDetail' => $eventId]);
// })->name('event_display');

Route::get('/calendarResources', [CalendarController::class, 'index'])->name('get_calendar_resources');
