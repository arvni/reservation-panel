<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationSMS;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ResendSmsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Reservation $reservation)
    {
        if ($reservation->VerificationRequests()->count()>3)
            abort(401,"You Have Request Many Verification Sms");
        SendVerificationSMS::dispatch($reservation);
        return redirect()->route("verify",$reservation);
    }
}
