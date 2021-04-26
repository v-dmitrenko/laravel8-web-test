<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => "required|string|min:6|confirmed",
        ];
    }
}
