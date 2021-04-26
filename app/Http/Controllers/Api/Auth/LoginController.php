<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Api\Auth
 */
class LoginController extends Controller
{
    use AuthTrait;

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     * @throws \RuntimeException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password']);
        $user = User::where('email', $request->email)->where('status', User::STATUS_ACTIVE)->first();
        if (empty($user)) {
            return response()->json([
                'error' => 'Data is missing or you need to confirm your account. Please check your email.'
            ], HttpResponse::HTTP_BAD_REQUEST); //400
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Unauthorized. Invalid credentials.'
                ], HttpResponse::HTTP_UNAUTHORIZED); //401
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token.'
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR); //500
        }

        return $this->responseWithToken($token, $user);
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        $token = '';
        $user = '';

        try {
            if ($user = JWTAuth::parseToken()->authenticate()) {
                JWTAuth::parseToken()->invalidate();
                $token = JWTAuth::fromUser($user);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Not able to refresh Token'
            ], HttpResponse::HTTP_METHOD_NOT_ALLOWED); //405
        }

        if (!$token) {
            return response()->json([
                'error' => 'Token not provided.'
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR); //500
        }

        return response()->json([
            'status'     => 'success',
            'token'      => $token,
        ], HttpResponse::HTTP_OK); //200
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::guard('api')->logout();  //or JWTAuth::parseToken()->invalidate();
            return response()->json(['status' => 'success', 'message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Failed to logout, please try again.'
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR); //500
        }
    }
}
