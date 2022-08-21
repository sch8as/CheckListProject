<?php

namespace App\Actions\Auth;

use App\Actions\Action;
use Illuminate\Support\Facades\Validator;

class GetValidatorRegisterAction extends Action
{
    public function execute(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}