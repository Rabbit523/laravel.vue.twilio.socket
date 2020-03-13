<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Klarna\Rest\Transport\Connector;
use Klarna\Rest\Transport\ConnectorInterface;
use Klarna\Rest\Checkout\Order;
use Klarna\Rest\OrderManagement\Order as OrderInStore;

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

use App\User;
use App\Models\Page;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;

use App;
use Auth;
class PagesController extends Controller
{
    public function index () {
        $categories = Categories::all();
        $page = Page::where('id','63')->first();
        $data = json_decode($page->page_body);
        return view('pages.home', compact('categories','data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function updateLang(Request $request) {
        $lang = $request->lang;
        if ($lang == 'English') {
            App::setLocale("en");
            session()->put('locale', "en");
            return $request->address ? redirect('/'.$request->address) : redirect('/');
        } else {
            App::setlocale('no');
            session()->put('locale', "no");
            return $request->address ? redirect('/no/'.$request->address) : redirect('/no');
        }
    }

    public function category_info(Request $request) {
        $categories = Categories::all();
        $category = Categories::where('category_url', $request->type)->first();
        $count = Consultant::where('industry_expertise', $request->type)->count();
        $consultants = Consultant::where('industry_expertise', $request->type)->get();
        $page = Page::where('id', 1)->first();
        $data = json_decode($page->page_body);
        return view('pages.category_info',
            compact('category', 'categories', 'count', 'consultants', 'data'), ['title' => 'GoToConsult - '.$category->meta_title, 'description' => $category->meta_description]
        );
    }

    public function become_consultant () {
        $categories = Categories::all();
        $count = Categories::count();
        $page = Page::where('id','2')->first();
        $data = json_decode($page->page_body);
        return view('pages.become_consultant', compact('categories', 'count', 'data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function about_us () {
        $page = Page::where('id','3')->first();
        $data = json_decode($page->page_body);
        return view('pages.about_us', compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function faq () {
        $page = Page::where('id','4')->first();
        $data = json_decode($page->page_body);
        return view('pages.faq', compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function privacy() {
        $page = Page::where('id','6')->first();
        $data = json_decode($page->page_body);
        return view('pages.privacy', compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function terms_customer() {
        $page = Page::where('id','5')->first();
        $data = json_decode($page->page_body);
        return view('pages.terms_customer', compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function terms_provider() {
        $page = Page::where('id','9')->first();
        $data = json_decode($page->page_body);
        return view('pages.terms_provider', compact('data'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function find_consultant() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $consultants = Consultant::with('user')->get();
        $authCustomer = Customer::where('unique_id', Auth::user()->id)->first();
        return view('member.customerchat', compact('consultants', 'authCustomer'), ['title' => 'LiveChat', 'description' => '', 'active' => '0']);
    }

    public function find_customer() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $customers = Customer::with('user')->get();
        $authConsultant = Consultant::where('unique_id', Auth::user()->id)->first();
        return view('member.consultantchat', compact('customers', 'authConsultant'), ['title' => 'LiveChat', 'description' => '', 'active' => '0']);
    }

    public function prepaid_card() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user = Auth::User();
        $cur_balance = 0;
        if ($user->role == 'consultant') {
            $consultant = Consultant::where('unique_id', $user->id)->first();
            $cur_balance = $consultant->balance;
        } else if ($user->role == 'customer') {
            $customer = Customer::where('unique_id', $user->id)->first();
            $cur_balance = $customer->balance;
        }
        return view('member.prepaid_card', ['title' => 'PaymentCard', 'description' => '', 'active' => '1', 'balance' => $cur_balance, 'is_popup' => 'false', 'amount' => '0']);
    }

    public function invoice() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        return view('member.invoice', ['title' => 'Invoice', 'description' => '', 'active' => '2']);
    }

    public function member_settings() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user_role = Auth::User()->role;
        $user_info = null;
        if ($user_role == 'consultant') {
            $user_info = Consultant::with('user')->first();
        } else {
            $user_info = Customer::with('user')->first();
        }
        return view('member.member_settings', compact('user_info'), ['title' => 'Profile', 'description' => '', 'active' => '3']);
    }

    public function klarna_checkout(Request $request) {
        $html_snippet = $request->html_snippet;
        return view('member.klarna_checkout', ['html_snippet' => $html_snippet, 'active' => '1']);
    }

    public function klarna_confirmation(Request $request) {
        $sid = $request->sid;
        $merchantId = getenv('KLARNA_MERCHANT_ID') ?: 'PK12126_ebf20e785379';
        $sharedSecret = getenv('KLARNA_SHARED_SECRET') ?: 'eDWpqm3sIuKBi8jq';

        $connector = Connector::create(
            $merchantId,
            $sharedSecret,
            getenv('APP_ENV') === 'local' ? 
                ConnectorInterface::EU_TEST_BASE_URL :
                ConnectorInterface::EU_BASE_URL
        );

        try {
            $order = new OrderInStore($connector, $sid);
            $order->acknowledge();

            $id = $request->uid;
            $amount = $request->amount;
            $cur_balance = 0;
            $user = User::where('id', $id)->first();
            $user->balance += $amount;
            $user->last_purchased_id = $sid;
            $user->save();
            $cur_balance = $user->balance;
            
            return view('member.prepaid_card', ['title' => 'PaymentCard', 'description' => '', 'active' => '1', 'balance' => $cur_balance, 'is_popup' => 'true', 'amount' => $amount]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
