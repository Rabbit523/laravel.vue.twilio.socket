<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Page;
use App\User;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;

class PagesController extends Controller
{
    public function __construct () {
        if(!Auth::check()){
            return redirect('//');
        }
    }
    //PAGES
    public function pages () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $pages = Page::all();
        return view('admin.pages', compact('pages'), ['active' => '3']);
    }
    public function createPage() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.create_page', ['active' => '3']);
    }
    public function editPage(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $page = Page::where('id', $request->id)->first();
        $page_body = json_decode($page->page_body);
        if ($request->id == 6) {
            return view('admin.edit_privacy', compact('page', 'page_body'), ['active' => '3']);
        } else if ($request->id == 5) {
            return view('admin.edit_terms_customer', compact('page', 'page_body'), ['active' => '3']);
        } else if ($request->id == 9) {
            return view('admin.edit_terms_provider', compact('page', 'page_body'), ['active' => '3']);
        } else {
            return view('admin.edit_page', compact('page', 'page_body'), ['active' => '3']);
        }
    }
    //CATEGORIES
    public function categories () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.categories', compact('categories'), ['active' => '2']);
    }
    public function createCategory () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.create_category', ['active' => '2']);
    }
    public function editCategory (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $category = Categories::where('id', $request->id)->first();
        return view('admin.edit_category', compact('category'), ['active' => '2']);
    }
    //CUSTOMERS
    public function customers () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $customers = Customer::with('user')->get();
        return view('admin.customers', compact('customers'), ['active' => '0']);
    }
    public function createCustomer () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.create_customer', compact('categories'), ['active' => '0']);
    }
    public function editCustomer (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user = User::where('id', $request->id)->first();
        $customer = Customer::where('unique_id', $request->id)->first();
        $categories = Categories::all();
        return view('admin.edit_customer', compact('customer', 'user', 'categories'), ['active' => '0']);
    }
    //CONSULTANTS
    public function consultants () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $consultants = Consultant::with('user')->get();
        return view('admin.consultants', compact('consultants'), ['active' => '1']);
    }
    public function createConsultant () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.create_consultant', compact('categories'), ['active' => '1']);
    }
    public function editConsultant (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user = User::where('id', $request->id)->first();
        $consultant = Consultant::where('unique_id', $request->id)->first();
        $categories = Categories::all();
        return view('admin.edit_consultant', compact('consultant', 'user', 'categories'), ['active' => '1']);
    }
    //SETTING
    public function settting () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.settings', ['active' => '4']);
    }
}
