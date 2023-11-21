<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Inertia\Inertia;

class SuccessPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Reservation $reservation)
    {
        $time=$reservation->Time->started_at;
        $date = Carbon::parse($time)->isoFormat("MMMM D, Y");
        $time = Carbon::parse($time)->format("H:i");
        return Inertia::render("Success", [
            "message" => __("messages.appointmentSuccessfully",[
                "name"=>$reservation->name,
                "time"=>$time,
                "date"=>$date
            ])]);
    }
}
