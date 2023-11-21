<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\OtpService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VerifyAppointmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Reservation $reservation, Request $request)
    {
        try {
            OtpService::checkOtp("+968" . $reservation->mobile, $request->get("code"));
            $reservation->update(["verified" => true, "verified_at" => Carbon::now()]);
            $reservation->Time->update(["disabled" => true]);
            return redirect()->route("success", $reservation);
        } catch (Exception $exception) {
            return back()->withErrors(["mobile" => $exception->getMessage()]);
        }
    }
}
