<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationSMS;
use App\Models\Reservation;
use App\Services\CheckMobile;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class ResendSmsController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws ValidationException
     */
    public function __invoke(Reservation $reservation, Request $request)
    {
        CheckMobile::check($reservation->mobile);
        SendVerificationSMS::dispatch($reservation);
        return redirect()->route("verify", $reservation);
    }
}
