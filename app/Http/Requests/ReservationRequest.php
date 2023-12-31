<?php

namespace App\Http\Requests;

use App\Rules\CheckMobileLocked;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required"],
            "mobile" => ["required",'regex:/^((\+|00)?968)?[279]\d{7}$/',new CheckMobileLocked()],
            "time" => ["required",new CheckTimeRule()]
        ];
    }
}
