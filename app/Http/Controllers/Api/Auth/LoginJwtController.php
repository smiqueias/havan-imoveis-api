<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class LoginJwtController extends Controller
{
    public function login(Request $request) : JsonResponse
    {

        $credentials = $request->all(['email','password']);

        $validator = Validator::make($credentials,[
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $isAuthenticated = auth('api')->attempt($credentials);

        if ($isAuthenticated) {
            return response()->json([
                'token' => $isAuthenticated
            ]);
        } else {
            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessage(),401);
        }



    }

    public function logout() : JsonResponse {
        auth('api')->logout();

        return response()->json([
            'message' => 'User Logout Successfully',
        ],200);
    }

    public function refreshToken()  : JsonResponse {
        $token = auth('api')->refresh();
        return response()->json([
            'message' => $token,
        ],200);
    }

}
