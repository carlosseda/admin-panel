<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Front\LoginRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Vendor\Locale\Manager;
use App\Models\DB\User;
use App\Models\DB\BusinessInformation;
use App\Models\DB\Login;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $login;
    protected $user;
    protected $manager;
    protected $business;
    protected $redirectTo = '/admin/faqs';

    public function __construct(Login $login, User $user, Manager $manager, BusinessInformation $business)
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);

        $this->login = $login;
        $this->user = $user;
        $this->manager = $manager;
        $this->business = $business;
    }

    public function index()
    {
        if($this->user->get()->count() > 0){
            return view('front.pages.login.index');
        }else{
            return view('front.pages.register.index');
        }
    }

    public function register(UserRequest $request)
    {

        $user = $this->user->create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'active' => 1,
        ]);

        $this->business->create([
            'name' => request('business'),
            'active' => 1,
        ]);

        $this->manager->importTranslations();  

        return $this->sendLoginResponse($request);
    }

    public function login(LoginRequest $request)
    {

        if ($this->hasTooManyLoginAttempts($request)) {

            $this->fireLockoutEvent($request);
            
            return $this->sendLockoutResponse($request);
        }
       
        if ($this->attemptLogin($request)) {

            if (Auth::guard('web')->user()->active) {

                $this->login->create([
                    'user_id' =>  Auth::id(),
                    'action' => 'login'
                ]);

                return $this->sendLoginResponse($request);
            }else {
                Auth::guard('web')->logout();
                $request->session()->invalidate();

                return redirect()->route('front_login');
            } 
        }
        
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->login->create([
            'user_id' =>  Auth::id(),
            'action' => 'logout'
        ]);
        
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        return redirect('/');
    }
}
