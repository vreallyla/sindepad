<?php

namespace App\Http\Controllers\Api;

use App\DeclaredPDO\Jwt\jwtClass;
use App\Rules\Captcha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    use jwtClass;

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

        $this->validate($request, [
            'g-recaptcha-response' => new Captcha(),
        ]);

        if ($token = $this->guard()->attempt($credentials)) {
            if (!Hash::check(true, $this->guard()->user()->code_status)) {
                return response()->json(['error' =>/* [
                'id'=>*/
                    'Mohon konfirmasi email anda',
                    /*'en'=>'Check your email first'
                ]*/], 401);
            }

            $data = $this->respondWithToken($token);

            return response()->json($data);
        }

        return response()->json(['error' /*=> [
            'id'*/ => 'email atau password salah',
            /* 'en'=>'email or password wrong'
         ]*/], 401);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


}
