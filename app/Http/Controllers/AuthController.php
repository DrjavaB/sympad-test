<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Jobs\UserRegistered;
use App\Models\User;
use DB;
use JetBrains\PhpStorm\NoReturn;
use Log;

class AuthController extends Controller
{
    #[NoReturn] public function login(UserLoginRequest $request)
    {
        try {
            $user = User::whereMobile($request->mobile)->firstOrFail();
            $response = ['token' => $user->attempt($request)];
            return successResponse($response, 'کاربر عزیز خوش آمدید');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return errorResponse($e->getMessage());
        }
    }

    public function register(UserRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            // user registration logic
            $user = User::create($request->validated());
            $response = ['token' => $user->attempt($request)];
            UserRegistered::dispatch($user)->onQueue('notification')->afterCommit();
            DB::commit();
            return successResponse($response, 'کاربر عزیز به خانواده بزرگ سیمپاد خوش آمدید');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return errorResponse($e->getMessage());
        }
    }
}
