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
use App\Models\Profile;
use App;
use Auth;

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('register')->withErrors($validator);
        } else {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'status' => 'Offline',
                'balance' => '0',
                'active' => '1'
            ]);
            $customer = Customer::create(['user_id' => $user->id]);
            if ($request->remember == 'true') {
                Auth::login($user);
                return App::getLocale() == 'en' ? Redirect::to('/sessions') : Redirect::to('/no/moter');
            } else {
                return App::getLocale() == 'en' ? Redirect::to('/login') : Redirect::to('/no/logg-inn');
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
