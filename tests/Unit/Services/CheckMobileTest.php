<?php

namespace Services;

use App\Services\CheckMobile;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;

class CheckMobileTest extends TestCase
{
    public function testValidMobile()
    {
        // Assuming your CheckMobileLocked class is implemented and working correctly
        // You can replace '1234567890' with a valid mobile number for testing
        $this->expectNotToPerformAssertions();
        CheckMobile::check('+96878454640');
    }

    public function testInvalidMobile()
    {
        // Assuming your CheckMobileLocked class correctly identifies a locked mobile
        // You can replace '0987654321' with an invalid mobile number for testing
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(__('messages.mobileLocked'));

        CheckMobile::check('0987654321');
    }
}
