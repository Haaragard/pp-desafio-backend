<?php

namespace App\Http\Requests\Account;

use App\Dtos\Account\WithdrawDto;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return WithdrawDto::rules();
    }
}
