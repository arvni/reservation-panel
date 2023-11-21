<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ShowResend;
use Inertia\Inertia;

class CancelAppointmentVerificationPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Reservation $reservation)
    {
        return Inertia::render("VerifyCancelAppointment", [
            "mobile" => $reservation->mobile,
            "showResendSMS" => ShowResend::check($reservation->mobile),
            "id" => $reservation->id
        ]);
    }
}
