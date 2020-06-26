<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use Braintree_Configuration;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Braintree_Configuration::environment(env('BRAINTREE_ENVIRONMENT'));
        Braintree_Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
        Braintree_Configuration::publicKey(env('BRAINTREE_PUBLIC_KEY'));
        Braintree_Configuration::privateKey(env('BRAINTREE_PRIVATE_KEY'));

        $user_info = null;
        if (Auth::check()) {
            if (Auth::user()->role == 'consultant') {
                $user_info = Consultant::where('user_id', Auth::user()->id)->with('profile')->first();
            } else if (Auth::user()->role == 'customer') {
                $user_info = Customer::where('user_id', Auth::user()->id)->with('profile')->first();
            }
            View::share('user_info', $user_info);
        }
        $categories = Categories::all();
        View::share('categories', $categories);
    }
}
