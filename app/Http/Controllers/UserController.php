<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $r)
    {
        $user = \App\User::where('name', $r->input('username'))->orWhere('email', $r->input('username'))->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 401);
        }

        $check = Hash::check($r->input('password'), $user->password);
        if (!$check) {
            return response()->json([
                'success' => false,
                'message' => 'Username and password doesn\'t match',
            ], 401);
        }

        /* generate api token */
        $api_token = base64_encode(md5($user->email . time()));

        /* update user token */
        $user->api_token = $api_token;
        $user->save();

        return response()->json([
            'data' => [
                'user' => $user,
                'api_token' => $api_token,
            ],
        ]);
    }
}
