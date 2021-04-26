<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api\User
 */
class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::query()
            ->isActive()
            ->paginate(2);

        return response()->json([
            'status'      => 'success',
            'users'       => UserResource::collection($users),
            'currentPage' => $users->currentPage(),
            'lastPage'    => $users->lastPage(),
        ], 200);
    }
}
