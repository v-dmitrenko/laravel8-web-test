<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Auth;

use App\Mail\Auth\AccountConfirmationMailer;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class RegisterController
 *
 * @package App\Http\Controllers\Api\Auth
 */
class RegisterController extends Controller
{
    use AuthTrait;

    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'verify_token'  => (string) Str::uuid(),
            'status'        => User::STATUS_INACTIVE,
        ]);

        Mail::to($user)->send(new AccountConfirmationMailer($user));
        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * @param string $email
     * @param string $token
     *
     * @return JsonResponse
     */
    public function confirmEmail(string $email, string $token): JsonResponse
    {
        try {
            $user = User::query()
                ->where('email', $email)
                ->where('verify_token', $token)
                ->firstOrFail();

            $user->status = User::STATUS_ACTIVE;
            $user->verify_token = null;
            $user->save();
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 'error',
            ], 200);
        }

        $token = JWTAuth::fromUser($user);

        return $this->responseWithToken($token, $user);
    }
}
