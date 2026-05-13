<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DownloadAppointmentPdfRequest extends FormRequest
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
            'service' => [
                'required',
                'exists:services,id',
            ],

            'date' => [
                'required',
                'date',
            ],

            'time' => [
                'required',
                'string',
            ],

            'name' => [
                'required',
                'string',
            ],

            'email' => [
                'required',
                'email',
            ],
        ];
    }
}
