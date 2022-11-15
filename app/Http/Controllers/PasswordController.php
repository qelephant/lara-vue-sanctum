<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'password' => 'required|min:6|max:255|confirmed',
        ], [
            'password.required' => 'Неправильно указан пароль!',
            'password.min:6' => 'Пароль должен содержать больше 6 символов!',
            'password.confirmed' => 'Неправильно указан пароль!',
        ]);
        $user->update(['password' => Hash::make($request->password)]);
        return response()->json([
            'message' => 'password updated successfully .'
        ], 200);
    }
}
