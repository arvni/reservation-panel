<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Jobs\SendVerificationSMS;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ReservationRequest $request)
    {
        $reservation=Reservation::where("mobile",$request->get("mobile"))->first();
        if ($reservation)
            return redirect()->route("verify",$reservation);
        $reservation=new Reservation($request->except(["time","doctor"]));
        $reservation->Doctor()->associate($request->get("doctor")["id"]);
        $reservation->Time()->associate($request->get("time"));
        $reservation->save();
        SendVerificationSMS::dispatch($reservation);
        return redirect()->route("verify",$reservation);
    }
}
