<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:255|confirmed'
        ],
        [
            'name.required' => 'Неправильно указан имя!',
            'email.required' => 'Неправильно указан почтовый адресс!',
            'email.unique' => 'Почта с таким именем уже существует!',
            'password.required' => 'Неправильно указан пароль!',
            'password.min:6' => 'Пароль должен содержать больше 6 символов!',
            'password.confirmed' => 'Неправильно указан пароль!',
        ]);



        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if ($user) {
                $token = $user->createToken('access_token')->plainTextToken;
                return response()->json(["token" => $token , "type" => "Bearer"]);
            }
    }
}
