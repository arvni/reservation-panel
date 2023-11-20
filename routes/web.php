<?php

use App\Http\Controllers\FirstPageController;
use App\Http\Controllers\ResendSmsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VerificationPageController;
use App\Http\Controllers\VerifyMobileController;
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

Route::get('/', FirstPageController::class);
Route::post("reserve", ReservationController::class)->name("reserve");
Route::get("verify/{reservation}", VerificationPageController::class)->name("verify");
Route::post("verify/{reservation}", VerifyMobileController::class);
Route::post("resend-sms/{reservation}", ResendSmsController::class)->name("resend-sms");
Route::get("success",function (){
    return \Inertia\Inertia::render("Success");
})->name("success");
