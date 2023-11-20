<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationSMS;
use App\Models\Reservation;
use Carbon\Carbon;
use Inertia\Inertia;

class VerificationPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Reservation $reservation)
    {
        if ($reservation->verified)
            return redirect()->route("success",$reservation);
        if ($reservation->VerificationRequests()->count()>3)
            abort(401,"You Have Request Many Verification Sms");
        $latestVerificationRequest=$reservation->VerificationRequests()->latest()->first();
        $showResend= !$latestVerificationRequest || Carbon::parse($latestVerificationRequest->created_at)->addMinutes(2)->isBefore(now());
        return Inertia::render("Verify",["mobile"=>$reservation->mobile,"showResendSMS"=>$showResend,"id"=>$reservation->id]);
    }
}
