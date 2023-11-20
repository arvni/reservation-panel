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
            "doctor.id" => ["required", "exists:doctors,id"],
            "firstName" => ["required"],
            "lastName" => ["required"],
            "mobile" => ["required"],
            "time" => ["required",new CheckTimeRule()]
        ];
    }
}
