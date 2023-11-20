<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class VerifyMobileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Reservation $reservation,Request $request)
    {
       if ($this->checkOtp($reservation->mobile,$request->get("code"))){
           $reservation->update(["verified"=>true,"verified_at"=>Carbon::now()]);
           $reservation->Time->update(["disabled"=>true]);
           return redirect()->route("success");
       }
       return back()->withErrors(["mobile"=>"the code you have entered does not correct"]);
    }

    private function checkOtp($mobile,$code)
    {
        try {
            $sid = config("services.twilio.sid");
            $token = config("services.twilio.token");
            $serviceSid = config("services.twilio.serviceSid");
            $twilio = new Client($sid, $token);
            $result = $twilio->verify->v2->services($serviceSid)
                ->verificationChecks
                ->create([
                        "to" => $mobile,
                        "code" => $code
                    ]
                );
            return $result->valid;
        } catch (TwilioException $exception) {
            return false;
        }
    }
}
