<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \JWTAuth;
use App\Models\User;
use App\Http\Requests\LoginRequest;
class AuthController extends Controller
{
    //
     public function refresh(Request $request)
    {
        //
        return response([
            'type' => 'success',
            'msg'  => 'Everything cool',
        ]);
    }

    public function user()
    {
        //
        if($user = User::findOrFail(auth()->id())) {
            return response()->json([
                'type' => 'success',
                'data' => $user,
                'msg'  => 'El usuario existe.'
            ]);
        }
        return response()->json([
            'type' => 'error',
            'msg'  => 'El usuario no existe en la base de datos.'
        ]);
    }

    public function login(LoginRequest $request)
    {
        //
        $credentials = $request->only('email', 'password');
        if ($token = JWTAuth::attempt($credentials)) {
	        return response([
	            'type' => 'success',
	            'msg'  => 'Se ha logueado satisfactoriamente.'
	        ])
	        ->header('Authorization', $token);
        }
        return response([
            'status' => 'error',
            'error' => 'invalid.credentials',
            'msg' => 'Invalid Credentials.'
        ], 401);
    }

    public function logout()
    {
        //
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
}
