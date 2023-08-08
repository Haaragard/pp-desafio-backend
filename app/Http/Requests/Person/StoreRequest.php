<?php

namespace App\Http\Requests\Person;

use App\Dtos\Person\StoreDto;
use App\Dtos\User\StoreDto as StoreUserDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            ...StoreUserDto::rules(),
            ...StoreDto::rules(),
        ];
    }
}
