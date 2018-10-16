<?php

namespace App\Exceptions;

use App\DeclaredPDO\jwtClass;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class Laravel extends ExceptionHandler
{
    use jwtClass;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
//        if ($exception instanceof TokenInvalidException) {
//            $this->remove_cookie(['dasdasd'=>'dasdasd'],59);
//            return redirect()->route('welcome')->with('msg', 'token salah, silakan login kembali.');
//        } elseif ($exception instanceof TokenExpiredException) {
//            $this->remove_cookie(['dasdasd'=>'dasdasd'],59);
//            return redirect()->route('welcome')->with('msg', 'sesi masuk habis, silakan login kembali.');
//        } elseif ($exception instanceof JWTException) {
//            $this->remove_cookie(['dasdasd'=>'dasdasd'],59);
//            return redirect()->route('welcome')->with('msg', 'terdapat kesalahan, silakan login kembali.');
//        } elseif ($exception instanceof TokenBlacklistedException) {
//            $this->remove_cookie(['dasdasd'=>'dasdasd'],59);
//            return redirect()->route('welcome')->with('sesi masuk habis, silakan login kembali.');
//        } elseif ($exception instanceof UserNotDefinedException) {
//            $this->remove_cookie(['dasdasd'=>'dasdasd'],59);
//            return redirect()->route('welcome')->with('terdapat kesalahan, akun anda tidak terdaftar');
//        }
        return parent::render($request, $exception);
    }

    public function remove_cookie($val,$time)
    {
        Cookie::get('uzanto',$val,$time);
        Cookie::get('uzanto',$val,-$time);
    }

    public function removeCookie()
    {
        if ($this->checkCookie()){
//            Cookie::
        }
    }
}
