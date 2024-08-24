<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PixWebhookRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'movementId' => 'required|integer',
            'value' => 'required',
            'afterBalance' => 'required',
            'beforeBalance' => 'required',
            'createDate' => 'required',
            'modifiedDate' => 'required',
            'originAgency' => 'required',
            'originAccount' => 'required',
            'originName' => 'required',
            'originDocument' => 'required',
            'destinationAgency' => 'required',
            'destinationAccount' => 'required',
            'destinationName' => 'required',
            'destinationDocument' => 'required'
        ];
    }
}
