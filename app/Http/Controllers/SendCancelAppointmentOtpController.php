<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelAppointmentRequest;
use App\Jobs\SendVerificationSMS;
use App\Models\Reservation;
use App\Services\ConvertMobileNumberService;
use Illuminate\Validation\ValidationException;


class SendCancelAppointmentOtpController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws ValidationException
     */
    public function __invoke(CancelAppointmentRequest $request)
    {
        $mobile=ConvertMobileNumberService::convert($request->get("mobile"));
        $reservation=Reservation::whereMobile($mobile)->first();
        SendVerificationSMS::dispatch($reservation);
        return redirect()->route("verify-cancel-appointment",$reservation);
    }
}
