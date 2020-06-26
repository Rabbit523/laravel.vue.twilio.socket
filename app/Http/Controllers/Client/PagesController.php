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
use App\Models\ChargingTransactions;
use App\Models\Transactions;
use App\Models\Review;
use App\Models\Session;
use App\Models\Requests;
use App\Models\Profile;

use App;
use Auth;
use DateTime;
use Agent;
class PagesController extends Controller
{
    public function index () {
        $page = Page::where('id','63')->first();
        $data = json_decode($page->page_body);
        $review_list = [];
        $customers = Review::where('rate', '>=', '4')->with(['customer' => function($sub1) {
            $sub1->with(['profile', 'user']);
        }])->get();
        $ids = [];
        foreach ($customers as $customer) {
            if (isset($customer->customer)) {
                array_push($review_list, $customer);
            } else {
                array_push($ids, $customer->id);
            }
        }
        foreach ($ids as $id) {
            $review =  Review::where('id', $id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->first();
            if (isset($review->consultant)) {
                array_push($review_list, $review);
            }
        }
        return view('pages.home', compact('categories','data', 'review_list'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function updateLang(Request $request) {
        $lang = $request->lang;
        if ($lang == 'en') {
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
        $category = Categories::where('category_url', $request->type)->first();
        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
            $q->where('profession', '=', $request->type);
        })->with('profile', 'user')->get();
        $count = count($consultants);
        $page = Page::where('id', 1)->first();
        $data = json_decode($page->page_body);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => 'null',
            'category' => $request->type,
            'price' => 'null',
            'status' => 'null',
            'country' => 'null'
        ];
        $review_list = [];
        $customers = Review::where('rate', '>=', '4')->with(['customer' => function($sub1) {
            $sub1->with(['profile', 'user']);
        }])->get();
        $ids = [];
        foreach ($customers as $customer) {
            if (isset($customer->customer)) {
                array_push($review_list, $customer);
            } else {
                array_push($ids, $customer->id);
            }
        }
        foreach ($ids as $id) {
            $review =  Review::where('id', $id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->first();
            if (isset($review->consultant)) {
                array_push($review_list, $review);
            }
        }
        return view('pages.category_info', compact('category', 'count', 'consultants', 'data', 'countries', 'search', 'review_list'), ['title' => 'GoToConsult - '.$category->meta_title, 'description' => $category->meta_description]);
    }

    public function categorySearch(Request $request) {
        $category = Categories::where('category_url', $request->category)->first();
        
        if ($request->price != 'null') { //AB
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            if ($request->status != 'null') { //ABC
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->country != 'null') { // ABCD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->name != 'null') { //ABCDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->name != 'null') { // ABCE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->country != 'null') { //ABD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->name != 'null') { // ABDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->name != 'null') { //ABE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            }
        } else if ($request->status != 'null') { //AC
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->whereHas('user', function($q) use ($request) {
                if ($request->status != 'busy') {
                    $q->where('status', '=', $request->status);
                } else {
                    $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                }
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->status != 'null') { //ACD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->name != 'null') { //ACDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->name != 'null') { //ACE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if ($request->country != 'null') { //AD
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->name != 'null') { // ADE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if ($request->name != 'null') { //AE
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->whereHas('user', function($q) use ($request) {
                $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
            })->orderBy('hourly_rate', 'desc')->get();
        } else {
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->with('profile', 'user')->get();
        }

        $count = count($consultants);
        $page = Page::where('id', 1)->first();
        $data = json_decode($page->page_body);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'status' => $request->status,
            'country' => $request->country
        ];
        $review_list = [];
        $customers = Review::where('rate', '>=', '4')->with(['customer' => function($sub1) {
            $sub1->with(['profile', 'user']);
        }])->get();
        $ids = [];
        foreach ($customers as $customer) {
            if (isset($customer->customer)) {
                array_push($review_list, $customer);
            } else {
                array_push($ids, $customer->id);
            }
        }
        foreach ($ids as $id) {
            $review =  Review::where('id', $id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->first();
            if (isset($review->consultant)) {
                array_push($review_list, $review);
            }
        }
        return view('pages.category_info', compact('category', 'count', 'consultants', 'data', 'countries', 'search', 'review_list'), ['title' => 'GoToConsult - '.$category->meta_title, 'description' => $category->meta_description]);
    }

    public function nocategorySearch(Request $request) {
        $category = Categories::where('category_url', $request->category)->first();

        if ($request->price != 'null') { //AB
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            if ($request->status != 'null') { //ABC
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->country != 'null') { // ABCD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->name != 'null') { //ABCDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->name != 'null') { // ABCE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->country != 'null') { //ABD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->name != 'null') { // ABDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->name != 'null') { //ABE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            }
        } else if ($request->status != 'null') { //AC
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->whereHas('user', function($q) use ($request) {
                if ($request->status != 'busy') {
                    $q->where('status', '=', $request->status);
                } else {
                    $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                }
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->status != 'null') { //ACD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->name != 'null') { //ACDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->name != 'null') { //ACE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if ($request->country != 'null') { //AD
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->name != 'null') { // ADE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if ($request->name != 'null') { //AE
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->whereHas('user', function($q) use ($request) {
                $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
            })->orderBy('hourly_rate', 'desc')->get();
        } else {
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->with('profile', 'user')->get();
        }

        $count = count($consultants);
        $page = Page::where('id', 1)->first();
        $data = json_decode($page->page_body);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'status' => $request->status,
            'country' => $request->country
        ];
        $review_list = [];
        $customers = Review::where('rate', '>=', '4')->with(['customer' => function($sub1) {
            $sub1->with(['profile', 'user']);
        }])->get();
        $ids = [];
        foreach ($customers as $customer) {
            if (isset($customer->customer)) {
                array_push($review_list, $customer);
            } else {
                array_push($ids, $customer->id);
            }
        }
        foreach ($ids as $id) {
            $review =  Review::where('id', $id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->first();
            if (isset($review->consultant)) {
                array_push($review_list, $review);
            }
        }
        return view('pages.category_info', compact('category', 'count', 'consultants', 'data', 'countries', 'search', 'review_list'), ['title' => 'GoToConsult - '.$category->meta_title, 'description' => $category->meta_description]);
    }

    public function features() {
        $page = Page::where('id','10')->first();
        $data = json_decode($page->page_body);
        $review_list = [];
        $customers = Review::where('rate', '>=', '4')->with(['customer' => function($sub1) {
            $sub1->with(['profile', 'user']);
        }])->get();
        $ids = [];
        foreach ($customers as $customer) {
            if (isset($customer->customer)) {
                array_push($review_list, $customer);
            } else {
                array_push($ids, $customer->id);
            }
        }
        foreach ($ids as $id) {
            $review =  Review::where('id', $id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->first();
            if (isset($review->consultant)) {
                array_push($review_list, $review);
            }
        }
        return view('pages.features', compact('data', 'review_list'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function noFeatures() {
        $page = Page::where('id','10')->first();
        $data = json_decode($page->page_body);
        $review_list = [];
        $customers = Review::where('rate', '>=', '4')->with(['customer' => function($sub1) {
            $sub1->with(['profile', 'user']);
        }])->get();
        $ids = [];
        foreach ($customers as $customer) {
            if (isset($customer->customer)) {
                array_push($review_list, $customer);
            } else {
                array_push($ids, $customer->id);
            }
        }
        foreach ($ids as $id) {
            $review =  Review::where('id', $id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->first();
            if (isset($review->consultant)) {
                array_push($review_list, $review);
            }
        }
        return view('pages.features', compact('data', 'review_list'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function become_consultant () {
        $categories = Categories::all();
        $count = Categories::count();
        $page = Page::where('id','2')->first();
        $data = json_decode($page->page_body);
        $terms_page = Page::where('id', '9')->first();
        $terms = json_decode($terms_page->page_body);
        return view('pages.become_consultant', compact('categories', 'count', 'data', 'terms'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
    }

    public function about_us () {
        $page = Page::where('id','3')->first();
        $data = json_decode($page->page_body);
        $review_list = [];
        $customers = Review::where('rate', '>=', '4')->with(['customer' => function($sub1) {
            $sub1->with(['profile', 'user']);
        }])->get();
        $ids = [];
        foreach ($customers as $customer) {
            if (isset($customer->customer)) {
                array_push($review_list, $customer);
            } else {
                array_push($ids, $customer->id);
            }
        }
        foreach ($ids as $id) {
            $review =  Review::where('id', $id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->first();
            if (isset($review->consultant)) {
                array_push($review_list, $review);
            }
        }
        return view('pages.about_us', compact('data', 'review_list'), ['title' => $page->meta_title, 'description' => $page->meta_description]);
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
    
    public function findConsultant() {
        $consultants = Consultant::with('user', 'profile')->get();
        $count = count($consultants);
        $countries = [];
        $auth_user = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => 'null',
            'category' => 'null',
            'price' => 'null',
            'status' => 'null',
            'country' => 'null'
        ];
        
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.find_consultant', compact('consultants', 'count', 'countries', 'search', 'auth_user'), ['title' => 'Find Consultant', 'description' => '', 'active' => '']);
    }

    public function findConsultantSearch(Request $request) {
        $consultants = null;
        if ($request->category != 'null') { //A
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->price != 'null') { //AB
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->status != 'null') { //ABC
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->country != 'null') { // ABCD
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status);
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                        if ($request->name != 'null') { //ABCDE
                            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                                $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                            })->whereHas('user', function($q) use ($request) {
                                if ($request->status != 'busy') {
                                    $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                                } else {
                                    $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                                }
                            })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                        }
                    } else if ($request->name != 'null') { // ABCE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->country != 'null') { //ABD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->name != 'null') { // ABDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->name != 'null') { //ABE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->status != 'null') { //AC
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->status != 'null') { //ACD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                    if ($request->name != 'null') { //ACDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', 'desc')->get();
                    }
                } else if ($request->name != 'null') { //ACE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->country != 'null') { //AD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->name != 'null') { // ADE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->name != 'null') { //AE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if ($request->price != 'null') { //B
            $consultants = Consultant::orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            if ($request->status != 'null') { //BC
                $consultants = Consultant::whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->country != 'null') { //BCD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->name != 'null') { //BCDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->name != 'null') { //BCE
                    $consultants = Consultant::whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->country != 'null') { //BD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('country', '=', $request->country);
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->name != 'null') { //BDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->name != 'null') { //BE
                $consultants = Consultant::whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            }
        } else if ($request->status != 'null') { //C
            $consultants = Consultant::whereHas('user', function($q) use ($request) {
                if ($request->status != 'busy') {
                    $q->where('status', '=', $request->status);
                } else {
                    $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                }
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->country != 'null') { //CD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->name != 'null') { //CDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->name != 'null') { //CE
                $consultants = Consultant::whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if($request->country != 'null') { //D
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('country', '=', $request->country);
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->name != 'null') { //DE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if($request->name != 'null') { //E
            $consultants = Consultant::whereHas('user', function($q) use ($request) {
                $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
            })->orderBy('hourly_rate', 'desc')->get();
        } else {
            $consultants = Consultant::with('user', 'profile')->get();
        }
        
        $count = count($consultants);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'status' => $request->status,
            'country' => $request->country
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.find_consultant', compact('consultants', 'count', 'countries', 'search', 'auth_user'), ['title' => 'Find Consultant', 'description' => '', 'active' => '']);
    }

    public function noFindConsultantSearch(Request $request) {
        $consultants = null;
        if ($request->category != 'null') { //A
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('profession', '=', $request->category);
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->price != 'null') { //AB
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->status != 'null') { //ABC
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->country != 'null') { // ABCD
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status);
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                        if ($request->name != 'null') { //ABCDE
                            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                                $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                            })->whereHas('user', function($q) use ($request) {
                                if ($request->status != 'busy') {
                                    $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                                } else {
                                    $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                                }
                            })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                        }
                    } else if ($request->name != 'null') { // ABCE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->country != 'null') { //ABD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->name != 'null') { // ABDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->name != 'null') { //ABE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->status != 'null') { //AC
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->status != 'null') { //ACD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                    if ($request->name != 'null') { //ACDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', 'desc')->get();
                    }
                } else if ($request->name != 'null') { //ACE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->country != 'null') { //AD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->name != 'null') { // ADE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('profession', '=', $request->category)->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->name != 'null') { //AE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('profession', '=', $request->category);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if ($request->price != 'null') { //B
            $consultants = Consultant::orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            if ($request->status != 'null') { //BC
                $consultants = Consultant::whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->country != 'null') { //BCD
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status);
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    if ($request->name != 'null') { //BCDE
                        $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                            $q->where('country', '=', $request->country);
                        })->whereHas('user', function($q) use ($request) {
                            if ($request->status != 'busy') {
                                $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            } else {
                                $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                            }
                        })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                    }
                } else if ($request->name != 'null') { //BCE
                    $consultants = Consultant::whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->country != 'null') { //BD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('country', '=', $request->country);
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                if ($request->name != 'null') { //BDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
                }
            } else if ($request->name != 'null') { //BE
                $consultants = Consultant::whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', $request->price == 'high-row' ? 'desc' : 'asc')->get();
            }
        } else if ($request->status != 'null') { //C
            $consultants = Consultant::whereHas('user', function($q) use ($request) {
                if ($request->status != 'busy') {
                    $q->where('status', '=', $request->status);
                } else {
                    $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                }
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->country != 'null') { //CD
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status);
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
                if ($request->name != 'null') { //CDE
                    $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                        $q->where('country', '=', $request->country);
                    })->whereHas('user', function($q) use ($request) {
                        if ($request->status != 'busy') {
                            $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        } else {
                            $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                        }
                    })->orderBy('hourly_rate', 'desc')->get();
                }
            } else if ($request->name != 'null') { //CE
                $consultants = Consultant::whereHas('user', function($q) use ($request) {
                    if ($request->status != 'busy') {
                        $q->where('status', '=', $request->status)->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    } else {
                        $q->where('status', '=', 'In a chat')->orWhere('status', '=', 'In a call')->orWhere('status', '=', 'In a Video call')->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                    }
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if($request->country != 'null') { //D
            $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                $q->where('country', '=', $request->country);
            })->orderBy('hourly_rate', 'desc')->get();
            if ($request->name != 'null') { //DE
                $consultants = Consultant::whereHas('profile', function($q) use ($request) {
                    $q->where('country', '=', $request->country);
                })->whereHas('user', function($q) use ($request) {
                    $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
                })->orderBy('hourly_rate', 'desc')->get();
            }
        } else if($request->name != 'null') { //E
            $consultants = Consultant::whereHas('user', function($q) use ($request) {
                $q->where('first_name', 'LIKE', '%'.$request->name.'%')->orWhere('last_name', 'LIKE', '%'.$request->name.'%');
            })->orderBy('hourly_rate', 'desc')->get();
        } else {
            $consultants = Consultant::with('user', 'profile')->get();
        }
        
        $count = count($consultants);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $search = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'status' => $request->status,
            'country' => $request->country
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.find_consultant', compact('consultants', 'count', 'countries', 'search', 'auth_user'), ['title' => 'Finn konsulent', 'description' => '', 'active' => '']);
    }

    public function noFindConsultant() {
        $consultants = Consultant::with('user', 'profile')->get();
        $count = count($consultants);
        $countries = [];
        $profiles = Profile::get();
        foreach ($profiles as $profile) {
            if (!in_array($profile->country, $countries)) {
                array_push($countries, $profile->country);
            }
        }
        $countries = json_encode($countries);
        $search = [
            'name' => 'null',
            'category' => 'null',
            'price' => 'null',
            'status' => 'null',
            'country' => 'null'
        ];
        $search = json_encode($search);
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.find_consultant', compact('consultants', 'count', 'countries', 'search', 'auth_user'), ['title' => 'Finn Konsulent', 'description' => '', 'active' => '']);
    }

    public function dashboard () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == "consultant") {
            $user_info = Consultant::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $dt = new DateTime;
            $today_start = $dt->setTime(0, 0);
            $today_end = $dt->setTime(23, 59, 59);
            $transactions = Transactions::where('consultant_id', $user_info->id)->where('created_at', '>=', $today_start)->where('created_at', '<=', $today_end)->get();
            $total_amount = 0;
            foreach ($transactions as $transaction) {
                $total_amount += $transaction->amount;
            }
            $consultants['earning'] = $total_amount;
            $customer_ids = [];
            $sessions = Session::where('consultant_id', $user_info->id)->latest('created_at')->take(5)->get(); 
            foreach ($sessions as $session) {
                if (!in_array($session->customer_id, $customer_ids)) {
                    array_push($customer_ids, $session->customer_id);
                }
            }
            $customers = [];
            foreach ($customer_ids as $id) {
                $customer = Customer::where('id', $id)->with('user', 'profile')->first();
                array_push($customers, $customer);
            }
        } else if (Auth::user()->role == "customer") {
            $user_info = Customer::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $consultants = Consultant::with('profile', 'user')->orderBy('rate', 'desc')->take(5)->get();
            $customers = [];
        }
        
        return view('member.dashboard', compact('user_info', 'consultants', 'customers'), ['title' => 'Dashboard', 'description' => '', 'active' => '0']);
    }
    public function noDashboard () {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == "consultant") {
            $user_info = Consultant::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $dt = new DateTime;
            $today_start = $dt->setTime(0, 0);
            $today_end = $dt->setTime(23, 59, 59);
            $transactions = Transactions::where('consultant_id', $user_info->id)->where('created_at', '>=', $today_start)->where('created_at', '<=', $today_end)->get();
            $total_amount = 0;
            foreach ($transactions as $transaction) {
                $total_amount += $transaction->amount;
            }
            $consultants['earning'] = $total_amount;
            $customer_ids = [];
            $sessions = Session::where('consultant_id', $user_info->id)->latest('created_at')->take(5)->get(); 
            foreach ($sessions as $session) {
                if (!in_array($session->customer_id, $customer_ids)) {
                    array_push($customer_ids, $session->customer_id);
                }
            }
            $customers = [];
            foreach ($customer_ids as $id) {
                $customer = Customer::where('id', $id)->with('user', 'profile')->first();
                array_push($customers, $customer);
            }
        } else if (Auth::user()->role == "customer") {
            $user_info = Customer::where('user_id', Auth::user()->id)->with('profile', 'user')->first();
            $consultants = Consultant::with('profile', 'user')->orderBy('rate', 'desc')->take(5)->get();
            $customers = [];
        }
        return view('member.dashboard', compact('user_info', 'consultants', 'customers'), ['title' => 'Oversikt', 'description' => '', 'active' => '0']);
    }

    public function session() {
         if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == 'consultant') {
            $customers = Customer::with('user', 'profile')->get();
            $authConsultant = Consultant::where('user_id', Auth::user()->id)->with('profile','user')->first();
            return view('member.consultantchat', compact('customers', 'authConsultant'), ['title' => 'My Sessions', 'description' => '', 'active' => '1']);
        } else {
            $consultants = Consultant::with('user', 'profile')->get();
            $authCustomer = Customer::where('user_id', Auth::user()->id)->with('profile','user')->first();
            return view('member.customerchat', compact('consultants', 'authCustomer'), ['title' => 'My Sessions', 'description' => '', 'active' => '1']);
        }
    }
    public function noSession() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == 'consultant') {
            $customers = Customer::with('user', 'profile')->get();
            $authConsultant = Consultant::where('user_id', Auth::user()->id)->with('profile','user')->first();
            return view('member.consultantchat', compact('customers', 'authConsultant'), ['title' => 'Mine møter', 'description' => '', 'active' => '1']);
        } else {
            $consultants = Consultant::with('user', 'profile')->get();
            $authCustomer = Customer::where('user_id', Auth::user()->id)->with('profile','user')->first();
            return view('member.customerchat', compact('consultants', 'authCustomer'), ['title' => 'Mine møter', 'description' => '', 'active' => '1']);
        }
    }

    public function wallet() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $agent = new \Jenssegers\Agent\Agent;
        $cur_balance = Auth::User()->balance;
        $currency = Auth::User()->currency != null ? Auth::User()->currency : 'NOK';
        $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->get();
        $credits = [
            ["id" => 'card1', 'amount' => $currency == 'NOK'?100:10],
            ["id" => 'card2', 'amount' => $currency == 'NOK'?200:20],
            ["id" => 'card3', 'amount' => $currency == 'NOK'?300:30],
            ["id" => 'card4', 'amount' => $currency == 'NOK'?500:50],
            ["id" => 'card5', 'amount' => $currency == 'NOK'?1000:100],
            ["id" => 'card6', 'amount' => $currency == 'NOK'?2000:200],
            ["id" => 'card7', 'amount' => $currency == 'NOK'?5000:500],
            ["id" => 'card8', 'amount' => 0]
        ];
        $search = [
            'start' => 'null',
            'end' => 'null',
            'type' => 'null'
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.wallet', [
            'title' => 'My Wallet',
            'description' => '',
            'active' => '2',
            'transactions' => $transactions,
            'balance' => $cur_balance,
            'currency' => $currency,
            'is_popup' => 'false',
            'amount' => '3',
            'agent' => $agent,
            'credits' => $credits,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }
    public function noWallet() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $agent = new \Jenssegers\Agent\Agent;
        $cur_balance = Auth::User()->balance;
        $currency = Auth::User()->currency != null ? Auth::User()->currency : 'NOK';
        $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->get();
        $credits = [
            ["id" => 'card1', 'amount' => $currency == 'NOK'?100:10],
            ["id" => 'card2', 'amount' => $currency == 'NOK'?200:20],
            ["id" => 'card3', 'amount' => $currency == 'NOK'?300:30],
            ["id" => 'card4', 'amount' => $currency == 'NOK'?500:50],
            ["id" => 'card5', 'amount' => $currency == 'NOK'?1000:100],
            ["id" => 'card6', 'amount' => $currency == 'NOK'?2000:200],
            ["id" => 'card7', 'amount' => $currency == 'NOK'?5000:500],
            ["id" => 'card8', 'amount' => 0]
        ];
        $search = [
            'start' => 'null',
            'end' => 'null',
            'type' => 'null'
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.wallet', [
            'title' => 'Min lommebok',
            'description' => '',
            'active' => '2',
            'transactions' => $transactions,
            'balance' => $cur_balance,
            'currency' => $currency,
            'is_popup' => 'false',
            'amount' => '3',
            'agent' => $agent,
            'credits' => $credits,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }
    public function walletSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $agent = new \Jenssegers\Agent\Agent;
        $cur_balance = Auth::User()->balance;
        $currency = Auth::User()->currency != null ? Auth::User()->currency : 'NOK';

        if ($request->start != 'null') {
            $startDate_array = explode("/", $request->input('start'));
            $startDate = "$startDate_array[2]-$startDate_array[0]-$startDate_array[1]"." 00:00:00";
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->where('created_at', '>=', $startDate)->get();
            if ($request->end != 'null') {
                $endDate_array = explode("/", $request->input('end')); 
                $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]"." 23:59:59";
                $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->whereBetween('created_at', [$startDate, $endDate])->get();
                if ($request->type != 'null') {
                    $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
                                    ->whereBetween('created_at', [$startDate, $endDate])
                                    ->where(function($q) use ($request) {
                                        if ($request->type != "Klarna") {
                                            $q->where('type', '!=', 'Klarna');
                                        } else {
                                            $q->where('type', 'Klarna');
                                        }
                                    })->get();
                }
            } else {
                if ($request->type != 'null') {
                    $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
                                    ->where('created_at', '>=', $startDate)
                                    ->where(function($q) use ($request) {
                                        if ($request->type != "Klarna") {
                                            $q->where('type', '!=', 'Klarna');
                                        } else {
                                            $q->where('type', 'Klarna');
                                        }
                                    })->get();
                }
            }
        } else if ($request->end != 'null') {
            $endDate_array = explode("/", $request->input('end')); 
            $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]"." 23:59:59";
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->where('created_at', '<=', $endDate)->get();
            if ($request->type != 'null') {
                $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
                                ->where('created_at', '<=', $endDate)
                                ->where(function($q) use ($request) {
                                    if ($request->type != "Klarna") {
                                        $q->where('type', '!=', 'Klarna');
                                    } else {
                                        $q->where('type', 'Klarna');
                                    }
                                })->get();
            }
        }  else if ($request->type != 'null') {
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
            ->where(function($q) use ($request) {
                if ($request->type != "Klarna") {
                    $q->where('type', '!=', 'Klarna');
                } else {
                    $q->where('type', 'Klarna');
                }
            })->get();
        } else {
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->get();
        }
        $credits = [
            ["id" => 'card1', 'amount' => $currency == 'NOK'?100:10],
            ["id" => 'card2', 'amount' => $currency == 'NOK'?200:20],
            ["id" => 'card3', 'amount' => $currency == 'NOK'?300:30],
            ["id" => 'card4', 'amount' => $currency == 'NOK'?500:50],
            ["id" => 'card5', 'amount' => $currency == 'NOK'?1000:100],
            ["id" => 'card6', 'amount' => $currency == 'NOK'?2000:200],
            ["id" => 'card7', 'amount' => $currency == 'NOK'?5000:500],
            ["id" => 'card8', 'amount' => 0]
        ];
        $search = [
            'start' => $request->start,
            'end' => $request->end,
            'type' => $request->type
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.wallet', [
            'title' => 'My Wallet',
            'description' => '',
            'active' => '2',
            'transactions' => $transactions,
            'balance' => $cur_balance,
            'currency' => $currency,
            'is_popup' => 'false',
            'amount' => '3',
            'agent' => $agent,
            'credits' => $credits,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }
    public function noWalletSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $agent = new \Jenssegers\Agent\Agent;
        $cur_balance = Auth::User()->balance;
        $currency = Auth::User()->currency != null ? Auth::User()->currency : 'NOK';

        if ($request->start != 'null') {
            $startDate_array = explode("/", $request->input('start'));
            $startDate = "$startDate_array[2]-$startDate_array[0]-$startDate_array[1]"." 00:00:00";
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->where('created_at', '>=', $startDate)->get();
            if ($request->end != 'null') {
                $endDate_array = explode("/", $request->input('end')); 
                $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]"." 23:59:59";
                $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->whereBetween('created_at', [$startDate, $endDate])->get();
                if ($request->type != 'null') {
                    $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
                                    ->whereBetween('created_at', [$startDate, $endDate])
                                    ->where(function($q) use ($request) {
                                        if ($request->type != "Klarna") {
                                            $q->where('type', '!=', 'Klarna');
                                        } else {
                                            $q->where('type', 'Klarna');
                                        }
                                    })->get();
                }
            } else {
                if ($request->type != 'null') {
                    $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
                                    ->where('created_at', '>=', $startDate)
                                    ->where(function($q) use ($request) {
                                        if ($request->type != "Klarna") {
                                            $q->where('type', '!=', 'Klarna');
                                        } else {
                                            $q->where('type', 'Klarna');
                                        }
                                    })->get();
                }
            }
        } else if ($request->end != 'null') {
            $endDate_array = explode("/", $request->input('end')); 
            $endDate = "$endDate_array[2]-$endDate_array[0]-$endDate_array[1]"." 23:59:59";
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->where('created_at', '<=', $endDate)->get();
            if ($request->type != 'null') {
                $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
                                ->where('created_at', '<=', $endDate)
                                ->where(function($q) use ($request) {
                                    if ($request->type != "Klarna") {
                                        $q->where('type', '!=', 'Klarna');
                                    } else {
                                        $q->where('type', 'Klarna');
                                    }
                                })->get();
            }
        }  else if ($request->type != 'null') {
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)
            ->where(function($q) use ($request) {
                if ($request->type != "Klarna") {
                    $q->where('type', '!=', 'Klarna');
                } else {
                    $q->where('type', 'Klarna');
                }
            })->get();
        } else {
            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->get();
        }
        $credits = [
            ["id" => 'card1', 'amount' => $currency == 'NOK'?100:10],
            ["id" => 'card2', 'amount' => $currency == 'NOK'?200:20],
            ["id" => 'card3', 'amount' => $currency == 'NOK'?300:30],
            ["id" => 'card4', 'amount' => $currency == 'NOK'?500:50],
            ["id" => 'card5', 'amount' => $currency == 'NOK'?1000:100],
            ["id" => 'card6', 'amount' => $currency == 'NOK'?2000:200],
            ["id" => 'card7', 'amount' => $currency == 'NOK'?5000:500],
            ["id" => 'card8', 'amount' => 0]
        ];
        $search = [
            'start' => $request->start,
            'end' => $request->end,
            'type' => $request->type
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.wallet', [
            'title' => 'My Wallet',
            'description' => '',
            'active' => '2',
            'transactions' => $transactions,
            'balance' => $cur_balance,
            'currency' => $currency,
            'is_popup' => 'false',
            'amount' => '3',
            'agent' => $agent,
            'credits' => $credits,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }

    public function transactions() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == 'customer') {
            $transactions = Transactions::where('user_id', Auth::User()->id)->with(['consultant' => function($sub1) {
                $sub1->with(['user']);
            }])->get();
        } else {
            $consultant = Consultant::where('user_id', Auth::User()->id)->first();
            $transactions = Transactions::where('consultant_id', $consultant->id)->with('user')->get();
        }
        $consultants = Consultant::with('user')->get();
        $search = [
            'number' => 'null',
            'consultant' => 'null',
            'date' => 'null'
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.transaction', [
            'title' => 'My Transactions',
            'description' => '',
            'active' => '3',
            'transactions' => $transactions,
            'consultants' => $consultants,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }
    public function noTransactions() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == 'customer') {
            $transactions = Transactions::where('user_id', Auth::User()->id)->with(['consultant' => function($sub1) {
                $sub1->with(['user']);
            }])->get();
        } else {
            $consultant = Consultant::where('user_id', Auth::User()->id)->first();
            $transactions = Transactions::where('consultant_id', $consultant->id)->with('user')->get();
        }
        $consultants = Consultant::with('user')->get();
        $search = [
            'number' => 'null',
            'consultant' => 'null',
            'date' => 'null'
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.transaction', [
            'title' => 'Transaksjonene mine',
            'description' => '',
            'active' => '3',
            'transactions' => $transactions,
            'consultants' => $consultants,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }
    public function transactionSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == 'customer') {
            if ($request->name != 'null') {
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                if ($request->consultant != 'null') {
                    $transactions = Transactions::where('user_id', Auth::User()->id)
                    ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                    ->where('consultant_id', $request->consultant)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                    if ($request->date != 'null') {
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                        $transactions = Transactions::where('user_id', Auth::User()->id)
                            ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                            ->where('created_at', '<=', $date)
                            ->where('consultant_id', $request->consultant)
                            ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                    }
                } else if($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                    $transactions = Transactions::where('user_id', Auth::User()->id)
                    ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                    ->where('created_at', ',=', $date)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                }
            } else if ($request->consultant != 'null'){
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->where('consultant_id', $request->consultant)
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                if ($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                    $transactions = Transactions::where('user_id', Auth::User()->id)
                    ->where('created_at', '<=', $date)
                    ->where('consultant_id', $request->consultant)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                }
            } else if ($request->date != 'null') {
                $date_array = explode("/", $request->input('date'));
                $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->where('created_at', '<=', $date)
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
            } else {
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
            }
        } else {
            $consultant = Consultant::where('user_id', Auth::User()->id)->first();
            if ($request->name != 'null') {
                $transactions = Transactions::where('consultant_id', $consultant->id)
                ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                if ($request->consultant != 'null') {
                    $transactions = Transactions::where('consultant_id', $consultant->id)
                    ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                    ->where('consultant_id', $request->consultant)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                    if ($request->date != 'null') {
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                        $transactions = Transactions::where('consultant_id', $consultant->id)
                            ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                            ->where('created_at', '<=', $date)
                            ->where('consultant_id', $request->consultant)
                            ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                    }
                } else if($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                    $transactions = Transactions::where('consultant_id', $consultant->id)
                    ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                    ->where('created_at', '<=', $date)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                }
            } else if ($request->consultant != 'null'){
                $transactions = Transactions::where('consultant_id', $consultant->id)
                ->where('consultant_id', $request->consultant)
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                if ($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                    $transactions = Transactions::where('consultant_id', $consultant->id)
                    ->where('created_at', '<=', $date)
                    ->where('consultant_id', $request->consultant)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
                }
            } else if ($request->date != 'null') {
                $date_array = explode("/", $request->input('date'));
                $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                $transactions = Transactions::where('consultant_id', $consultant->id)
                ->where('created_at', '<=', $date)
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
            } else {
                $transactions = Transactions::where('consultant_id', $consultant->id)
                ->with(['consultant' => function($sub1) {$sub1->with(['user']);}])->get();
            }
        }
        $consultants = Consultant::with('user')->get();
        $search = [
            'number' => $request->number,
            'consultant' => $request->consultant,
            'date' => $request->date
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.transaction', [
            'title' => 'My Transactions',
            'description' => '',
            'active' => '3',
            'transactions' => $transactions,
            'consultants' => $consultants,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }
    public function noTransactionSearch(Request $request) {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        if (Auth::user()->role == 'customer') {
            if ($request->number != 'null') {
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
                if ($request->consultant != 'null') {
                    $transactions = Transactions::where('user_id', Auth::User()->id)
                    ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                    ->where('consultant_id', $request->consultant)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
                    if ($request->date != 'null') {
                        $date_array = explode("/", $request->input('date'));
                        $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                        $transactions = Transactions::where('user_id', Auth::User()->id)
                            ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                            ->where('created_at', '>=', $date)
                            ->where('consultant_id', $request->consultant)
                            ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
                    }
                } else if($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                    $transactions = Transactions::where('user_id', Auth::User()->id)
                    ->where('transaction_id', 'LIKE', '%'.$request->number.'%')
                    ->where('created_at', '>=', $date)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
                }
            } else if ($request->consultant != 'null'){
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->where('consultant_id', $request->consultant)
                ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
                if ($request->date != 'null') {
                    $date_array = explode("/", $request->input('date'));
                    $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                    $transactions = Transactions::where('user_id', Auth::User()->id)
                    ->where('created_at', '>=', $date)
                    ->where('consultant_id', $request->consultant)
                    ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
                }
            } else if ($request->date != 'null') {
                $date_array = explode("/", $request->input('date'));
                $date = "$date_array[2]-$date_array[0]-$date_array[1]"." 00:00:00";
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->where('created_at', '>=', $date)
                ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
            } else {
                $transactions = Transactions::where('user_id', Auth::User()->id)
                ->with(['consultant' => function($sub1) {$sub1->with(['user', 'profile']);}])->get();
            }
        } else {
            $consultant = Consultant::where('user_id', Auth::User()->id)->first();
            $transactions = Transactions::where('consultant_id', $consultant->id)->with(['user', 'profile'])->get();
        }
        $consultants = Consultant::with('user')->get();
        $search = [
            'number' => $request->number,
            'consultant' => $request->consultant,
            'date' => $request->date
        ];
        $auth_user = [];
        if (auth()->user()->role == 'consultant') {
            $auth_user = Consultant::where('user_id', auth()->user()->id)->with('profile')->first();
        } else {
            $auth_user = Customer::where('user_id', auth()->user()->id)->with('profile')->first();
        }
        return view('member.transaction', [
            'title' => 'Transaksjonene mine',
            'description' => '',
            'active' => '3',
            'transactions' => $transactions,
            'consultants' => $consultants,
            'search' => $search,
            'auth_user' => $auth_user
        ]);
    }
    public function profile() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user_info = null;
        $review_info = null;
        $chart_info = [
            'request_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'completed_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'response_rates' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ]                
        ];
        if (Auth::User()->role == 'consultant') {
            $user_info = Consultant::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CUSTOCON')->where('receiver_id', $user_info->id)->with(['customer' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('consultant_id', $user_info->id)->get();
            $requests = Requests::where('consultant_id', $user_info->id)->get();
            foreach ($requests as $request) {
                $newDate = date('M d, Y', strtotime($request->created_at));
                $month = explode(" ",$newDate)[0];
                $chart_info['request_sessions'][$month] += 1;
            }
        } else {
            $user_info = Customer::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CONTOCUS')->where('receiver_id', $user_info->id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('customer_id', $user_info->id)->get();
        }
        foreach ($sessions as $session) {
            $newDate = date('M d, Y', strtotime($session->created_at));
            $month = explode(" ",$newDate)[0];
            $chart_info['completed_sessions'][$month] += 1;
        }
        if (Auth::User()->role == 'consultant') {
            foreach ($chart_info['response_rates'] as $key => $value) {
                if ($chart_info['request_sessions'][$key] != 0) {
                    $chart_info['response_rates'][$key] = $chart_info['completed_sessions'][$key] / $chart_info['request_sessions'][$key] * 100;
                    $chart_info['response_rates'][$key] = round($chart_info['response_rates'][$key], 2);
                }
            }
        }
        $agent = new \Jenssegers\Agent\Agent;
        return view('member.profile', compact('user_info', 'chart_info', 'review_info', 'agent'), ['title' => 'My Profile', 'description' => '', 'active' => '4']);
    }
    public function noProfile() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user_info = null;
        $review_info = null;
        $chart_info = [
            'request_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'completed_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'response_rates' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ]                
        ];
        if (Auth::User()->role == 'consultant') {
            $user_info = Consultant::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CUSTOCON')->where('receiver_id', $user_info->id)->with(['customer' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('consultant_id', $user_info->id)->get();
            $requests = Requests::where('consultant_id', $user_info->id)->get();
            foreach ($requests as $request) {
                $newDate = date('M d, Y', strtotime($request->created_at));
                $month = explode(" ",$newDate)[0];
                $chart_info['request_sessions'][$month] += 1;
            }
        } else {
            $user_info = Customer::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CONTOCUS')->where('receiver_id', $user_info->id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('customer_id', $user_info->id)->get();
        }
        foreach ($sessions as $session) {
            $newDate = date('M d, Y', strtotime($session->created_at));
            $month = explode(" ",$newDate)[0];
            $chart_info['completed_sessions'][$month] += 1;
        }
        if (Auth::User()->role == 'consultant') {
            foreach ($chart_info['response_rates'] as $key => $value) {
                if ($chart_info['request_sessions'][$key] != 0) {
                    $chart_info['response_rates'][$key] = $chart_info['completed_sessions'][$key] / $chart_info['request_sessions'][$key] * 100;
                    $chart_info['response_rates'][$key] = round($chart_info['response_rates'][$key], 2);
                }
            }
        }
        $agent = new \Jenssegers\Agent\Agent;
        return view('member.profile', compact('user_info', 'chart_info', 'review_info', 'agent'), ['title' => 'Min profil', 'description' => '', 'active' => '4']);
    }

    public function singleProfile(Request $request) {
        $user_info = null;
        $review_info = null;
        $chart_info = [
            'request_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'completed_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'response_rates' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ]                
        ];
        $user = User::where('id', $request->id)->first();
        if ($user->role == 'consultant') {
            $user_info = Consultant::where('user_id', $user->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CUSTOCON')->where('receiver_id', $user_info->id)->with(['customer' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('consultant_id', $user_info->id)->get();
            $requests = Requests::where('consultant_id', $user_info->id)->get();
            foreach ($requests as $request) {
                $newDate = date('M d, Y', strtotime($request->created_at));
                $month = explode(" ",$newDate)[0];
                $chart_info['request_sessions'][$month] += 1;
            }
        } else {
            $user_info = Customer::where('user_id', $user->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CONTOCUS')->where('receiver_id', $user_info->id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('customer_id', $user_info->id)->get();
        }
        foreach ($sessions as $session) {
            $newDate = date('M d, Y', strtotime($session->created_at));
            $month = explode(" ",$newDate)[0];
            $chart_info['completed_sessions'][$month] += 1;
        }
        if ($user->role == 'consultant') {
            foreach ($chart_info['response_rates'] as $key => $value) {
                if ($chart_info['request_sessions'][$key] != 0) {
                    $chart_info['response_rates'][$key] = $chart_info['completed_sessions'][$key] / $chart_info['request_sessions'][$key] * 100;
                    $chart_info['response_rates'][$key] = round($chart_info['response_rates'][$key], 2);
                }
            }
        }
        $agent = new \Jenssegers\Agent\Agent;
        return view('member.profile', compact('user_info', 'chart_info', 'review_info', 'agent'), ['title' => 'Profile', 'description' => '', 'active' => '']);
    }
    public function noSingleProfile(Request $request) {
        $user_info = null;
        $review_info = null;
        $chart_info = [
            'request_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'completed_sessions' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ],
            'response_rates' => [ 'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0 ]                
        ];
        $user = User::where('id', $request->id)->first();
        if ($user->role == 'consultant') {
            $user_info = Consultant::where('user_id', $user->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CUSTOCON')->where('receiver_id', $user_info->id)->with(['customer' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('consultant_id', $user_info->id)->get();
            $requests = Requests::where('consultant_id', $user_info->id)->get();
            foreach ($requests as $request) {
                $newDate = date('M d, Y', strtotime($request->created_at));
                $month = explode(" ",$newDate)[0];
                $chart_info['request_sessions'][$month] += 1;
            }
        } else {
            $user_info = Customer::where('user_id', $user->id)->with('user', 'profile', 'company')->first();
            $review_info = Review::where('type', 'CONTOCUS')->where('receiver_id', $user_info->id)->with(['consultant' => function($sub1) {
                $sub1->with(['profile', 'user']);
            }])->get();
            $sessions = Session::where('customer_id', $user_info->id)->get();
        }
        foreach ($sessions as $session) {
            $newDate = date('M d, Y', strtotime($session->created_at));
            $month = explode(" ",$newDate)[0];
            $chart_info['completed_sessions'][$month] += 1;
        }
        if ($user->role == 'consultant') {
            foreach ($chart_info['response_rates'] as $key => $value) {
                if ($chart_info['request_sessions'][$key] != 0) {
                    $chart_info['response_rates'][$key] = $chart_info['completed_sessions'][$key] / $chart_info['request_sessions'][$key] * 100;
                    $chart_info['response_rates'][$key] = round($chart_info['response_rates'][$key], 2);
                }
            }
        }
        $agent = new \Jenssegers\Agent\Agent;
        return view('member.profile', compact('user_info', 'chart_info', 'review_info', 'agent'), ['title' => 'profil', 'description' => '', 'active' => '']);
    }

    public function settings() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user_info = null;
        if (Auth::User()->role == 'consultant') {
            $user_info = Consultant::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
        } else {
            $user_info = Customer::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
        }
        return view('member.settings', compact('user_info'), ['title' => 'Settings', 'description' => '', 'active' => '5']);
    }
    public function noSettings() {
        if(!Auth::check()){
            return App::getLocale() == 'en' ? redirect('/') : redirect('/no');
        }
        $user_info = null;
        if (Auth::User()->role == 'consultant') {
            $user_info = Consultant::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
        } else {
            $user_info = Customer::where('user_id', Auth::User()->id)->with('user', 'profile', 'company')->first();
        }
        return view('member.settings', compact('user_info'), ['title' => 'Innstillinger', 'description' => '', 'active' => '5']);
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
            $user->save();
            $cur_balance = $user->balance;
            $currency = $request->currency;
            $charging_transaction = [
                'user_id' => Auth::user()->id,
                'type' => 'Klarna',
                'amount' => $amount,
                'transaction_id' => $sid,
                'status' => 'success'
            ];
            ChargingTransactions::create($charging_transaction);

            $transactions = ChargingTransactions::where('user_id', Auth::User()->id)->get();
            return view('member.wallet', ['title' => 'PaymentCard', 'description' => '', 'transactions' => $transactions, 'active' => '1', 'balance' => $cur_balance, 'currency' => $currency, 'is_popup' => 'true', 'amount' => $amount]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
