<?php

namespace Tests\Unit\Rules;

use App\Models\VerificationRequest;
use App\Rules\CheckMobileLocked;
use Illuminate\Translation\PotentiallyTranslatedString;
use PHPUnit\Framework\TestCase;
class CheckMobileLockedTest extends TestCase
{
    public function testValidationPassesForUnlockedMobile()
    {
        // Assuming the ConvertMobileNumberService::convert method works correctly
        $value = '1234567890';

        // Mock the VerificationRequest model to return an unlocked record
        $verificationRequestMock = \Mockery::mock(VerificationRequest::class);
        $verificationRequestMock->shouldReceive('whereMobile')->andReturnSelf();
        $verificationRequestMock->shouldReceive('first')->andReturnNull(); // Unlocked mobile

        // Mock the closure for the fail callback
        $failClosureMock = \Mockery::mock(\Closure::class);
        $failClosureMock->shouldNotReceive('call');

        $rule = new CheckMobileLocked();

        // Run the validation rule
        $rule->validate('mobile', $value, $failClosureMock);

        // Assert that validation passed (no exception thrown)
        $this->addToAssertionCount(1); // PHPUnit 9+ compatibility
    }

    public function testValidationFailsForLockedMobile()
    {
        // Assuming the ConvertMobileNumberService::convert method works correctly
        $value = '1234567890';

        // Mock the VerificationRequest model to return a locked record
        $verificationRequestMock = \Mockery::mock(VerificationRequest::class);
        $verificationRequestMock->shouldReceive('whereMobile')->andReturnSelf();
        $verificationRequestMock->shouldReceive('first')->andReturn($verificationRequestMock); // Locked mobile
        $verificationRequestMock->locked = true;

        // Mock the closure for the fail callback
        $failClosureMock = \Mockery::mock(\Closure::class);
        $failClosureMock->shouldReceive('call')->once()->withArgs([new PotentiallyTranslatedString(__('messages.mobileLocked'))])->andReturnSelf();

        $rule = new CheckMobileLocked();

        // Run the validation rule
        $rule->validate('mobile', $value, $failClosureMock);

        // Assert that validation fails (exception thrown)
        $this->addToAssertionCount(1); // PHPUnit 9+ compatibility
    }
}
