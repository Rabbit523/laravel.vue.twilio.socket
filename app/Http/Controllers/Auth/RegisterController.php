<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\User;
use App\Models\Consultant;
use App\Models\Customer;
use App\Models\Page;
use App;

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
    protected $redirectTo = '/';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function register (Request $request) {
        $rules = array(
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'industry_expertise' => 'required',
            'phone' => 'required||regex:/[0-9]{9}/',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return App::getLocale() == 'en' ? Redirect::to('/register')->withErrors($validator) ->withInput(Input::except('password')) : Redirect::to('/no/registrer')->withErrors($validator) ->withInput(Input::except('password'));
        } else {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'Offline',
                'balance' => '0'
            ]);
            if($request->has('checkbox')) {
                $consultant=new Consultant;
                $consultant->unique_id = $user->id;
                $consultant->industry_expertise = $request->industry_expertise;
                $consultant->save();
                $user->role='consultant';
                $user->save();
                return App::getLocale() == 'en' ? Redirect::to('/login')->with('alert-success', 'Consultant addess sucessfully') : Redirect::to('/no/logg-inn')->with('alert-success', 'Consultant addess sucessfully');
            } else {
                $customer=new Customer;
                $customer->unique_id = $user->id;
                $customer->industry_expertise = $request->industry_expertise;
                $customer->save();
                $user->role='customer';
                $user->save();
                return App::getLocale() == 'en' ? Redirect::to('/login')->with('alert-success', 'Customer addess sucessfully') : Redirect::to('/no/logg-inn')->with('alert-success', 'Customer addess sucessfully');
            }
        }
    }

    protected function showRegistrationForm()
    {
        $page = Page::where('id', 8)->first();
        $data = json_decode($page->page_body);
        return view('auth.register', compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);       
    }
}
