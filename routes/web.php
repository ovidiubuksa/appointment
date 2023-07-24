<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FOController;
use App\Http\Controllers\BOController;

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
    return redirect()->route('new-appointment-form');
});

// Front Office
Route::get('/appointment/new', [FOController::class, 'new'])->name('new-appointment-form');
Route::post('/appointment/register', [FOController::class, 'registerNewAppointment'])->name('new-appointment-register');
Route::get('/employee/appointments/{consultant}/{date}', [FOController::class, 'getConsultantAppointments'])->name('employee-appointments');

// Back Office
Route::any('/admin', [BOController::class,'index'])->name('admin-index');
Route::any('/admin/client', [BOController::class,'clientList'])->name('admin-clients-list');
Route::any('/admin/client/{id}', [BOController::class,'clientEdit'])->name('admin-client-edit');
Route::any('/admin/client/{id}/delete', [BOController::class,'clientDelete'])->name('admin-client-delete');
Route::any('/admin/consultant', [BOController::class,'consultantList'])->name('admin-consultants-list');
Route::any('/admin/consultant/new', [BOController::class,'consultantNew'])->name('admin-consultant-new');
Route::any('/admin/consultant/{id}', [BOController::class,'consultantEdit'])->name('admin-consultant-edit');
Route::any('/admin/consultant/{id}/delete', [BOController::class,'consultantDelete'])->name('admin-consultant-delete');
Route::any('/admin/appointment', [BOController::class,'appointmentList'])->name('admin-appointments-list');
Route::any('/admin/appointment/{id}', [BOController::class,'appointmentEdit'])->name('admin-appointment-edit');
Route::any('/admin/appointment/{id}/delete', [BOController::class,'appointmentDelete'])->name('admin-appointment-delete');
