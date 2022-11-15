<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $input = $request->all();
        if ($image = $request->file('avatar')) {
            $name = '/avatars/' . uniqid().$image->getClientOriginalName();
            //$name = '../uploads/' . time().'.'.$request->image->extension();
            $image->storePubliclyAs('public', $name);
            $input['avatar'] = $name;
        }

        $user->avatar = $name;

        $user->update();

        return response()->json([
                'user' => $user,
                'message' => 'avatar updated successfully .'
            ], 200);
        }
}
