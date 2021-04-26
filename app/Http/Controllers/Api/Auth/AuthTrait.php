<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Trait AuthTrait
 * @package App\Http\Controllers\Api\Auth
 */
trait AuthTrait
{
    /**
     * @param string $token
     * @param User $user
     *
     * @return JsonResponse
     */
    protected function responseWithToken(string $token, User $user): JsonResponse
    {
        return response()->json([
            'status'     => 'success',
            'token'      => $token,
            //'expires_in' => auth()->factory()->getTTL() * 60,
            'user'       => $user,
        ], HttpResponse::HTTP_OK); //200
    }
}
