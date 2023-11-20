<?php

namespace App\Http\Requests;

use App\Rules\CheckTimeRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required"],
            "mobile" => ["required",function (string $attribute, mixed $value, $fail): void {
                if (!preg_match("/^((\+|00)?968)?[279]\d{7}$/", $value))
                    $fail(trans("Please enter a valid mobile number"));
            }],
            "time" => ["required",new CheckTimeRule()]
        ];
    }
}
