<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('login.index', ['username' => Cookie::get('username'), 'password' => Cookie::get('password')]);
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|alphaNum|min:3'
        ];

        $messages = [
            'password.alphaNum' => 'Mật khẩu chỉ bao gồm chữ và số',
            'password.min' => 'Mật khẩu phải chứa ít nhất 3 kí tự'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $userName = $request->get('username');
            $password = $request->get('password');
            $rememberMe = $request->get('remember-me');

            if (Auth::attempt(['username' => $userName, 'password' => $password])) {
                if ($rememberMe == true) {
                    Cookie::queue('username', $userName, 86400 * 30);
                    Cookie::queue('password', $password, 86400 * 30);
                } else {
                    setcookie("username", "", time() - 3600);
                    setcookie("password", "", time() - 3600);
                }
                $user = User::query()->where('username', '=', $userName)->first();
                session(['user-name' => strtoupper($user->username[0])]);
                return redirect('/admin');
            } else {
                $errors = new MessageBag(['error' => 'Tên tài khoản hoặc mật khẩu không đúng']);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();
            if ($findUser) {
                session(['user' => $findUser, 'user-avatar' => $findUser->avatar]);
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'username' => $user->getEmail(),
                    'password' => $user->getName(),
                    'email' => $user->getEmail(),
                    'avatar' => $user->getAvatar(),
                    'google_id' => $user->getId()
                ]);
                session(['user-avatar' => $newUser->avatar]);
                return redirect('/home');
            }
        } catch (Exception $e) {
            return redirect('login/google');
        }
    }
}
