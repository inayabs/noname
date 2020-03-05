<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $role = Role::all();

        if($role->count() == 0){
            Role::create(['name'=>'Super Admin']);
            Role::create(['name'=>'Admin']);
            Role::create(['name'=>'Staff']);
        }

        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // dd($user->roles()->pluck('name'));
        foreach($user->roles()->pluck('name') as $role){
            if($role == 'Staff'){
                return redirect('/deals');
            }
        }
        return redirect('/dashboard');
    }

    /**
     *
     * Redirect users to default application uri
     *
     * @return string
     */
    public function redirectTo()
    {
        // dd('checked');
        // SET COOKIE in SHARED INBOX
        // $uemail     = \Auth::user()->email()->first();
        // $email      = $uemail->email;
        // $password   = $uemail->email_password;

        // $cookie_name1 = "usrmail";
        // $cookie_value1 = $email;
        // $cookie_name2 = "usrpwd";
        // $cookie_value2 = $password;
        // setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/", ".eti.edu.au"); //name,value,time,url
        // setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/", ".eti.edu.au");

        return $this->redirectTo;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return ['username' => $request->username, 'password' => $request->password, 'is_active' => true];
    }

    public function userLogout()
    {
        // UNSET SHARED INBOX credentials
        unset($_COOKIE['usrmail']);
        unset($_COOKIE['usrpwd']);

        Auth::guard('web')->logout();
        return redirect('/login');
    }

}
