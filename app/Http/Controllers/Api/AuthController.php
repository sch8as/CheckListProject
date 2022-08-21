<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\CreateRegisterAction;
use App\Actions\Auth\GetValidatorRegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;

class AuthController extends Controller
{
    public function register(Request $request, GetValidatorRegisterAction $validatorAction, CreateRegisterAction $createAction)
    {
        $validator = $validatorAction->execute($request->all());

        if($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $user = $createAction->execute($request->all());

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request){
        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login information is invalid.'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
