<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendVerificationSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sid = config("services.twilio.sid");
        $token = config("services.twilio.token");
        $serviceSid = config("services.twilio.serviceSid");
        try {
            $twilio = new Client($sid, $token);
            $twilio->verify->v2->services($serviceSid)
                ->verifications
                ->create($this->reservation->mobile, "sms");
            $this->reservation->VerificationRequests()->create();
        } catch (TwilioException $exception) {
            $this->fail($exception->getMessage());
        }
    }
}
