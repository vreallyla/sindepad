<?php

namespace App\Http\Controllers\Auth;

use App\Mail\verifyMail;
use App\Model\sideGender;
use App\Model\sideStatusUser;
use App\User;
use App\Http\Controllers\Controller;
use App\verifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\DeclaredPDO\allNeeded as Selingan;
use App\DeclaredPDO\photoUser as checkGender;
use App\Rules\Captcha;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'gender' => 'required|exists:side_genders,id',
//            'g-recaptcha-response'=> new Captcha(),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'gender_id' => $data['gender'],
            'url' => checkGender::check($data['gender']),
            'code_status'=>bcrypt(false),
            'status_id'=>$this->getUserStatus(),
        ]);

        $verify=verifyUser::create([
           'user_id'=>$user->id,
            'token'=>str_random(45)
        ]);

        Mail::to($user->email)->send(new verifyMail($user));
//        Mail::send(new verifyMail($user), $user, function ($message) use ($user) {
//            $message->from(env('MAIL_HOST'), 'Sanggar ABK');
//            $message->to($user->email);
//            $message->subject('Aktivasi Akun Sanggar ABK');
//        });

        return $user;
    }

    private function getUserStatus()
    {
        $status=sideStatusUser::where('eng','User')->first();

        if (isset($status)){
            return $status->id;
        }

        return abort(404);
    }

    public function verification($token)
    {
        $verify=verifyUser::where('token',$token)->first();
        if (isset($verify)){

            $user=$verify->user;
            if (Hash::check(false,$user->code_status)){

                $verify->user->update([
                   'code_status'=>bcrypt(true)
                ]);
                $status="your email is verified, you can login right now...";
            }
            else{
                $status="your email is already verified, you can login right now...";

            }
        }
        else{
            return redirect()->route('welcome')->with('msg','sorry, your email cannot identified..');
        }
        return redirect()->route('welcome')->with('msg',$status);
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect()->route('welcome')->with('msg', 'We sent you an activication code. Check your email and click on the link to verify.');
    }

    public function showRegistrationForm()
    {
        $default = Selingan::index('Pendaftaran');
        $default[] = sideGender::all();
        $title='Daftar';
        $user_cookie=false;
        return view('auth.register', compact('default','title','user_cookie'));
    }
}
