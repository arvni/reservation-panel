<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Jobs\SendVerificationSMS;
use App\Models\Reservation;
use App\Models\Time;
use App\Services\ConvertMobileNumberService;

class ReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationRequest $request)
    {
        $mobile=ConvertMobileNumberService::convert($request->get("mobile"));
        $reservation = Reservation::where("mobile", $mobile)->first();
        if ($reservation)
            return redirect()->route("verify", $reservation);
        $reservation = new Reservation(["name" => $request->get("name"), "mobile" => $mobile]);
        $time = Time::whereId($request->get("time"))->with("Doctor")->first();
        $reservation->Doctor()->associate($time->doctor);
        $reservation->Time()->associate($time);
        $reservation->save();
        SendVerificationSMS::dispatch($reservation);
        return redirect()->route("verify", $reservation);
    }
}
