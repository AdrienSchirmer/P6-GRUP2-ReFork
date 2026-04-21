<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\TurnstileRule;

class CreateAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // For anyone even without an account
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|email|max:255',
            'phone_number' => 'required|integer',
            'description' => 'nullable|string',
            'cf-turnstile-response' => ['required', 'string', new TurnstileRule],
        ];
    }

    public function messages(): array
    {
        return [
            'cf-turnstile-response.required' => 'Por favor, completa la verificación de seguridad.',
            'cf-turnstile-response.string' => 'La verificación de seguridad no es válida.',
        ];
    }

    public function attributes(): array
    {
        return [
            'cf-turnstile-response' => 'verificación de seguridad',
        ];
    }
}
