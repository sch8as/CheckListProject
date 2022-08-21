<?php

namespace App\Actions\Auth;

use App\Actions\Action;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateRegisterAction extends Action
{
    public function execute(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}