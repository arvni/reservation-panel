<?php

namespace App\Services;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class OtpService
{
    public string $serviceSid, $token, $sid;

    public function __construct()
    {
        $this->sid = config("services.twilio.sid");
        $this->token = config("services.twilio.token");
        $this->serviceSid = config("services.twilio.serviceSid");
    }


    public static function senOtp($mobile)
    {
        $self = (new self);
        $twilio = new Client($self->sid, $self->token);
        $twilio->verify->v2->services($self->serviceSid)
            ->verifications
            ->create($mobile, "sms");
        return true;
    }

    /**
     * @throws TwilioException
     * @throws ConfigurationException
     */
    public static function checkOtp($mobile, $code): ?bool
    {
        $self = (new self);
        $twilio = new Client($self->sid, $self->token);
        $result = $twilio->verify->v2->services($self->serviceSid)
            ->verificationChecks
            ->create([
                    "to" => $mobile,
                    "code" => $code
                ]
            );
        return $result->valid;
    }

}
