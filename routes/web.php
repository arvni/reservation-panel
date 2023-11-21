<?php

use App\Http\Controllers\CancelAppointmentPageController;
use App\Http\Controllers\CancelAppointmentVerificationPageController;
use App\Http\Controllers\FirstPageController;
use App\Http\Controllers\ResendSmsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SendCancelAppointmentOtpController;
use App\Http\Controllers\SuccessPageController;
use App\Http\Controllers\VerificationPageController;
use App\Http\Controllers\VerifyAppointmentController;
use App\Http\Controllers\VerifyCancelAppointmentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', FirstPageController::class);
Route::post("reserve", ReservationController::class)->name("reserve");

Route::get("verify/{reservation}", VerificationPageController::class)->name("verify");
Route::post("verify/{reservation}", VerifyAppointmentController::class)->middleware("throttle:10,6");
Route::get("success/{reservation}", SuccessPageController::class)->name("success");

Route::post("resend-sms/{reservation}", ResendSmsController::class)->middleware("throttle:3,10")->name("resend-sms");

Route::get("verify-cancel-appointment/{reservation}", CancelAppointmentVerificationPageController::class)->name("verify-cancel-appointment");
Route::post("verify-cancel-appointment/{reservation}", VerifyCancelAppointmentController::class)->middleware("throttle:10,6");

Route::get("cancel", CancelAppointmentPageController::class)->name("cancel-appointment");
Route::Post("cancel", SendCancelAppointmentOtpController::class)->middleware("throttle:10,6");

Route::get('/{any}', function () {
    return Inertia::render("404");
})->where('any', '.*');
