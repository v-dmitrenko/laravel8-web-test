<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 *
 * @package App\Http\Requests\Auth
 */
class LoginRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ];
    }
}
