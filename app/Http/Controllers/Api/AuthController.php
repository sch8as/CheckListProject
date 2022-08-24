<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\CreateRegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAuthRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterAuthRequest $request, CreateRegisterAction $createAction)
    {
        $user = $createAction->execute($request->all());

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'state' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(LoginRequest $request){

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'state' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
