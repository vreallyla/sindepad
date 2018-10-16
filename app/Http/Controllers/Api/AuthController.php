<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\DeclaredPDO\jwtClass;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use jwtClass;

//    /**
//     * Create a new AuthController instance.
//     *
//     * @return void
//     */
    public function __construct()
    {
        $this->middleware('jwttes', ['except' => ['login']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
        if (!Hash::check(true, $this->guard()->user()->code_status)){
            return response()->json(['error' =>/* [
                'id'=>*/'Mohon konfirmasi email anda',
                /*'en'=>'Check your email first'
            ]*/], 401);
        }
            return response()->json($this->respondWithToken($token));
        }

        return response()->json(['error' /*=> [
            'id'*/=>'email atau password salah',
           /* 'en'=>'email or password wrong'
        ]*/], 401);
    }



}
