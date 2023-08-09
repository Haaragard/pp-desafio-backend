<?php

namespace App\Http\Requests\Account;

use App\Dtos\Account\DepositDto;
use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return DepositDto::rules();
    }
}
