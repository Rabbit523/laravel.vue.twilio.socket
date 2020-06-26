<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\User;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use App\Models\Profile;
use App\Models\Page;
class PagesController extends Controller
{
    public function __construct () {
        if(!Auth::check()){
            return redirect('/');
        }
    }
    public function adminDashboard() {
        $customers = Customer::count();
        $consultants = Consultant::count();
        $search = [
            "start" => 'null',
            "end" => 'null'
        ];
        return view('admin.dashboard', ['active' => '0', 'customers' => $customers, 'consultants' => $consultants, 'search' => $search]);
    }
    public function noAdminDashboard() {
        $customers = Customer::count();
        $consultants = Consultant::count();
        $search = [
            "start" => 'null',
            "end" => 'null'
        ];
        return view('admin.dashboard', ['active' => '0', 'customers' => $customers, 'consultants' => $consultants, "search" => $search]);
    }
    public function adminDashboardSearch(Request $request) {
        $startDate_array = explode("/", $request->input('start'));
        $startDate = "$startDate_array[2]-$startDate_array[0]-$startDate_array[1]"." 00:00:00";
        $endDate_array = explode("/", $request->input('end')); 
        $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]"." 23:59:59";
        $customers = Customer::whereBetween('created_at', [$startDate, $endDate])->count();
        $consultants = Consultant::whereBetween('created_at', [$startDate, $endDate])->count();
        $search = [
            "start" => $request->start,
            "end" => $request->end
        ];
        return view('admin.dashboard', ['active' => '0', 'customers' => $customers, 'consultants' => $consultants, "search" => $search]);
    }
    public function noAdminDashboardSearch(Request $request) {
        $startDate_array = explode("/", $request->input('start'));
        $startDate = "$startDate_array[2]-$startDate_array[0]-$startDate_array[1]"." 00:00:00";
        $endDate_array = explode("/", $request->input('end')); 
        $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]"." 23:59:59";
        $customers = Customer::whereBetween('created_at', [$startDate, $endDate])->count();
        $consultants = Consultant::whereBetween('created_at', [$startDate, $endDate])->count();
        $search = [
            "start" => $request->start,
            "end" => $request->end
        ];
        return view('admin.dashboard', ['active' => '0', 'customers' => $customers, 'consultants' => $consultants, "search" => $search]);
    }
    //PAGES
    public function pages () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $pages = Page::all();
        return view('admin.pages', compact('pages'), ['active' => '4']);
    }
    public function createPage() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.create_page', ['active' => '4']);
    }
    public function editPage(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $page = Page::where('id', $request->id)->first();
        $page_body = json_decode($page->page_body);
        if ($request->id == 6) {
            return view('admin.edit_privacy', compact('page', 'page_body'), ['active' => '4']);
        } else if ($request->id == 5) {
            return view('admin.edit_terms_customer', compact('page', 'page_body'), ['active' => '4']);
        } else if ($request->id == 9) {
            return view('admin.edit_terms_provider', compact('page', 'page_body'), ['active' => '4']);
        } else {
            return view('admin.edit_page', compact('page', 'page_body'), ['active' => '4']);
        }
    }
    //CATEGORIES
    public function categories () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.categories', compact('categories'), ['active' => '3']);
    }
    public function createCategory () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.create_category', ['active' => '3']);
    }
    public function editCategory (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $category = Categories::where('id', $request->id)->first();
        return view('admin.edit_category', compact('category'), ['active' => '3']);
    }
    //CUSTOMERS
    public function customers () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $customers = Customer::with('user')->get();
        return view('admin.customers', compact('customers'), ['active' => '1']);
    }
    public function createCustomer () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.create_customer', compact('categories'), ['active' => '1']);
    }
    public function editCustomer (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user = User::where('id', $request->id)->first();
        $customer = Customer::where('user_id', $request->id)->with('user', 'profile')->first();
        $categories = Categories::all();
        return view('admin.edit_customer', compact('customer', 'user', 'categories'), ['active' => '1']);
    }
    //CONSULTANTS
    public function consultants () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $consultants = Consultant::with('user')->get();
        return view('admin.consultants', compact('consultants'), ['active' => '2']);
    }
    public function createConsultant () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $categories = Categories::all();
        return view('admin.create_consultant', compact('categories'), ['active' => '2']);
    }
    public function editConsultant (Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user = User::where('id', $request->id)->first();
        $consultant = Consultant::where('user_id', $request->id)->with('profile', 'user')->first();
        $categories = Categories::all();
        return view('admin.edit_consultant', compact('consultant', 'user', 'categories'), ['active' => '2']);
    }
    //SETTING
    public function settting () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('admin.settings', ['active' => '4']);
    }
}
