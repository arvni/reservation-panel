<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\OtpService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerifyCancelAppointmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Reservation $reservation, Request $request)
    {
        try {
            OtpService::checkOtp("+968" . $reservation->mobile, $request->get("code"));
            $reservation->load(["Time", "Doctor"]);
            $message = __("messages.appointmentCanceledSuccessfully", [
                "time" => $reservation->time->title,
                "date" => Carbon::parse($reservation->time->started_at)->isoFormat("MMM D, Y"),
                "doctor" => $reservation->doctor->title
            ]);
            $reservation->Time->update(["disabled" => false]);
            $reservation->delete();
            return Inertia::render("Success", ["message" => $message]);
        } catch (Exception $exception) {
            return back()->withErrors(["mobile" => $exception->getMessage()]);
        }
    }
}
