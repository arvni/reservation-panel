<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\VerificationRequest;
use App\Services\CheckMobile;
use App\Services\ShowResend;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class VerificationPageController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws ValidationException
     */
    public function __invoke(Reservation $reservation)
    {
        if ($reservation->verified_at)
            return redirect()->route("success", $reservation);

        return Inertia::render("Verify", [
            "mobile" => $reservation->mobile,
            "showResendSMS" => ShowResend::check($reservation->mobile),
            "id" => $reservation->id
        ]);
    }

}
