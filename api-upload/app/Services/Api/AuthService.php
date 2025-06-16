<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;


class AuthService
{
    public function __construct(private \App\Repositories\ActivityLogRepository $activityLogRepository)
    {
        $this->activityLogRepository = $activityLogRepository;
    }

    public function register($request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $request->input('name', ''),
                'email'    => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->accessToken;
            $expiresAt = $tokenResult->token->expires_at;

            DB::commit();

            return response()->json([
                'user'              => new UserResource($user),
                'token'             => $token,
                'token_expires_at'  => $expiresAt,
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro no registro de usuário: ' . $e->getMessage());

            return response()->json([
                'message' => 'Erro ao registrar usuário. Tente novamente.',
            ], 500);
        }
    }
}