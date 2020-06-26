<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Models\Page;
use App\User;
use App;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $page = Page::where('id', 7)->first();
        $data = json_decode($page->page_body);
        return view('auth.login',  compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function logout(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->status = 'Offline';
        $user->save();
        Auth::logout();
        $lang = App::getLocale();
        if ($lang == 'en') {
            return redirect('/login');
        } else {
            return redirect('/no/logg-inn');
        }
    }

    public function login(Request $request) {
        $lang = App::getLocale();
        $rules = array('email' => 'required|email', 'password' => 'required|alphaNum');

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $lang == 'en' ? Redirect::to('/login')->withErrors($validator) : Redirect::to('/no/logg-inn')->withErrors($validator);
        } else {
            // create our user data for the authentication
            $userdata = array(
                'password'  => $request->password,
                'email'     => $request->email
            );
            $user = User::where('email', $request->email)->first();
            if ($user->active == 1) {
                if (Auth::attempt($userdata,true)) {
                    if (Auth::user()->role == "admin") {
                        return $lang == 'en' ? redirect('/pages') : redirect('/no/sider');
                    } else {
                        return $lang == 'en' ? redirect("/sessions") : redirect("/no/moter");
                    }
                } else {
                    return $lang == 'en' ? Redirect::to('/login')->with('alert-success', 'Enter Correct Email and Password') : Redirect::to('/no/logg-inn')->with('alert-success', 'Enter Correct Email and Password');
                }
            } else {
                return $lang == 'en' ? Redirect::to('/login')->with('alert-success', 'Your consultant application is under process. We will inform you once your account is activated.') : Redirect::to('/no/logg-inn')->with('alert-success', 'Din konsulentsøknad er under behandling. Vi vil informere deg når kontoen din er aktivert.');
            }
        }
    }
}
