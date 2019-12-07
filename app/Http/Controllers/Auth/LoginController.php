<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/cms/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function verify(Request $request)
    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
          $user = Auth::user();

          $username = $user->name;
          // return redirect()->route('/cms/page/home');
          return response()->json(['message'=> 'validated']);

        }
        else
        {
          // return redirect()->route('/');
          return response()->json(['message'=> 'blocked']);
        }
    }
    public function logout(Request $request) {
      Auth::logout();
      return redirect('/');
    }
}
