<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 11/10/2018
 * Time: 17:06
 */

namespace App\DeclaredPDO\Jwt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait jwtClass
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

    public function get_id()
    {
        $id=$this->guard()->user();
        return $id?$id:false;
    }

    /**
     * this function use for check qualified the cookie token
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Http\RedirectResponse|null
     */
    private function refreshWithCookie()
    {
        $cookie = self::get_cookie_array();
        $check_user = $this->guard()->user();
//        $cookie['token'] = $this->guard()->refresh();


        if (!$check_user || !$check = $this->choose_array(['token', 'name', 'url'], $cookie)) {
            self::remove_cookie();
            return false;
        }
//
//        $check['name'] = $check_user->name;
//        $check['url'] = $check_user->url;
//        $this->cookie_decode($check, 59);

        return self::check_user($check_user->name,$check_user->url);
    }




    public function post_token(array $r)
    {
        return $this->refresh();
    }

    public function validatea($request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    }

}