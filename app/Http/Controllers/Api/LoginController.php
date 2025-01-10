<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);    
        }

        $credentials = $request->only('username', 'password');
        $user = User::where('username', $request->username)->first();

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => 'error',
                'message' => 'Username atau password salah',
                'admin' => ''
            ], 401);
        }

        return response()->json([
            'success' => 'success',
            'message' => 'Berhasil login',
            'admin' => [
                'token' => $token,
                'admin' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'email' => $user->email,
                ]
            ]
        ], 200);
    }
}
