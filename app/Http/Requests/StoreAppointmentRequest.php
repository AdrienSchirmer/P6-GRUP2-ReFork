<?php

namespace App\Http\Requests;

use App\Rules\TurnstileRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            //
            'service_id' => [
                'required',
                'exists:services,id',
            ],

            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'customer_phone' => [
                'required',
                'regex:/^[0-9]{9}$/',
            ],

            'customer_email' => [
                'required',
                'email',
                'max:255',
            ],

            'appointment_date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'cf-turnstile-response' => app()->environment('testing')
                ? ['nullable']
                : ['required', 'string', new TurnstileRule],
        ];
    }

    public function messages(): array
    {
        return [
            'cf-turnstile-response.required' => 'Por favor, completa la verificación.',

            'customer_phone.regex' => 'El telèfon ha de tenir 9 dígits.',
        ];
    }
}
