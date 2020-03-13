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
            return $lang == 'en' ? Redirect::to('/login')->withErrors($validator)->withInput(Input::except('password')) : Redirect::to('/no/logg-inn')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            // create our user data for the authentication
            $userdata = array(
                'password'  => $request->password,
                'email'     => $request->email
            );
            if (Auth::attempt($userdata,true)) {
                if (Auth::user()->role == "admin") {
                    return $lang == 'en' ? redirect('/pages') : redirect('/no/sider');
                } else if (Auth::user()->role == "customer") {
                    return $lang == 'en' ? redirect("/find-consultant") : redirect("/no/finn-konsulent");
                } else {
                    return $lang == 'en' ? redirect("/find-customer") : redirect("/no/finn-kunde");
                }
            } else {
                return $lang == 'en' ? Redirect::to('/login')->with('alert-success', 'Enter Correct Email and Password') : Redirect::to('/no/logg-inn')->with('alert-success', 'Enter Correct Email and Password');
            }
        }
    }
}
