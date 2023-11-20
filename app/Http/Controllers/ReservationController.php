<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Jobs\SendVerificationSMS;
use App\Models\Reservation;
use App\Models\Time;

class ReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationRequest $request)
    {
        preg_match("/^((\+|00)?968)?[279]\d{7}$/", $request->get("mobile"), $match);
        $mobile = count($match) > 1 ? substr($match[0],  strlen($match[1])) : $match[0];
        $reservation = Reservation::where("mobile", $mobile)->first();
        if ($reservation)
            return redirect()->route("verify", $reservation);
        $reservation = new Reservation(["name" => $request->get("name"), "mobile" => $mobile]);
        $time = Time::whereId($request->get("time"))->with("Doctor")->first();
        $reservation->Doctor()->associate($time->Doctor);
        $reservation->Time()->associate($time);
        $reservation->save();
        SendVerificationSMS::dispatch($reservation);
        return redirect()->route("verify", $reservation);
    }
}
