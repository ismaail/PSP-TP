<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'bank_name' => ['required', 'string'],
            'bank_country' => ['required', 'string', 'size:2'],
            'iban' => ['required', 'string', 'regex:/^(?:[A-Z][\s-]*){2}(?:[A-Z0-9][\s-]*){25}$/'], // https://bank.codes/iban/structure/
            'bic' => ['required', 'string', 'regex:/^(?:[A-Z][\s-]*){6}(?:[A-Z0-9][\s-]*){5}$/'], // https://bank-code.net/
        ];
    }
}
