<?php
/**
 * Created by PhpStorm.
 * User: Osweald
 * Date: 11/10/2018
 * Time: 17:06
 */

namespace App\DeclaredPDO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

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


    /**
     * this function use for check qualified the cookie token
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Http\RedirectResponse|null
     */
    private function refreshWithCookie()
    {
        $cookie = self::get_cookie_array();
        $check_user = $this->guard()->user();
        $cookie['token'] = $this->guard()->refresh();


        if (!$check_user || !$check = $this->choose_array(['token', 'name', 'url'], $cookie)) {
            $cookie['token'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzOTMwMzA5OSwiZXhwIjoxNTM5MzA2Njk5LCJuYmYiOjE1MzkzMDMwOTksImp0aSI6IllqVUdXa0xOc0ZhM3R6R00iLCJzdWIiOiIzZTE0M2U5Yy04Nzg1LTQzMDYtODNjNi1jNWExMGI0Yjk0ODciLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.4Q3xgbEsl9DrTHRqe2Mdom7lymZnL-ts49B9oeMlziI';
            self::remove_cookie($cookie, 59);
            return redirect()->route('welcome')->with('msg', 'terdapat kesalahan, silakan login kembali.');
        }
//
        $check['name'] = $check_user->name;
        $check['url'] = $check_user->url;
        $this->cookie_decode($check, 59);

        return $check_user;
    }


    /**
     * checking an array from the object
     * also selection some array
     * @param $selection
     * @param $ar
     * @return array|bool
     */
    public function choose_array($selection, $ar)
    {
        $arr = array();
        foreach ($selection as $row) {
            array_key_exists($row, $ar) ? $arr[$row] = $ar[$row] : $arr[$row] = '';
            if (!$arr) {
                return false;
                break;
            }
        }

        return $arr;
    }

    public function post_token(array $r)
    {
        return $this->refresh();
    }


}