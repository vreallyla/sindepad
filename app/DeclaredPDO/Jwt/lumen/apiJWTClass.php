<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 17/10/2018
 * Time: 19:45
 */

namespace App\DeclaredPDO\Jwt\lumen;


use App\DeclaredPDO\Jwt\extraClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class apiJWTClass
{
    use extraClass;

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $datas = $this->guard()->user();
        return response()->json($datas ? $datas : ['error' => 'Unauthorized'], 401);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json($this->response_refresh($this->guard()->refresh()));
    }

    public function response_refresh($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = $this->response_refresh($token);
        $data['data'] = $this->guard()->user()->only('name', 'url');
        return $data;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    public function validates($request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    }

    public function get_id()
    {
        $id=$this->guard()->user()->id;
         return $id?$id:false;
    }





}