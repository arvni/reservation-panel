<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Models\VerificationRequest;
use App\Services\OtpService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Mockery\Exception;
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
        try {
            OtpService::senOtp( "+968" . $this->reservation->mobile);
            $verificationRequest=VerificationRequest::whereMobile($this->reservation->mobile)->first();
            if (!$verificationRequest)
                VerificationRequest::create(["mobile"=>$this->reservation->mobile]);
            else
                $verificationRequest->update(["counter"=>$verificationRequest->counter+1,"locked"=>$verificationRequest->counter>2]);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }
}
