<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use App\Models\Page;
use App\Models\Rate;
use Hash;

class ApiController extends Controller
{   
    public function __construct () {
        if(!Auth::check()){
            return redirect('/');
        }
    }

    public function updateSetting(Request $request) {
        if ($request->type == 'personal') {
            $rules = array('first_name' => 'required','last_name' => 'required','phone' => 'required|regex:/[0-9]{9}/');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = Auth::user();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->save();
                return response()->json(['status' => 'success']);
            }
        } else if ($request->type == 'mail') {
            $rules = array('old_mail' => 'required|email','new_mail' => 'required|email');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => 0,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                if($request->old_mail !=Auth::user()->email) {
                    return response()->json(['status' => 1]);
                } else {
                    if (User::where('email', $request->new_mail)->count() > 0) {
                        return response()->json(['status' => 3]);
                    } else {
                        $user = Auth::user();
                        $user->email = $request->new_mail;
                        $user->save();
                        return response()->json(['status' => 2]);
                    }
                }
            }
        } else {
            $rules = array('old_password' => 'required','new_password' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => 0,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                if (Hash::check($request->old_password, Auth::user()->password)) {
                    $user = Auth::user();
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    return response()->json(['status' => 1]);
                } else {
                    return response()->json(['status' => 2]);
                }
            }
        }
    }

    public function createCategory(Request $request) {
        if($request->type == 'profile') {
            $rules = array('category_name' => 'required|unique:categories', 'category_url' => 'required|unique:categories','category_description' => 'required|max:220');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $category = new Categories;
                $category->category_name = $request->category_name;
                $category->category_url = strtolower(str_replace(" ", "_", $request->category_url));
                $category->category_description = $request->category_description;;
                $category->save();
                return response()->json(['status' => true, 'id' => $category->id]);
            }
        } else if ($request->type == 'meta') {
            $category = Categories::where('id', $request->hidden_id)->first();
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->save();
        } else {
            $validation = Validator::make($request->all(), [
                'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:256'
            ]);
            if($validation->passes()) {
                $image = $request->file('select_file');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/categories'), $new_name);
                $category = Categories::where('id', $request->hidden_id)->first();
                $category->category_icon = 'images/categories'.$new_name;
                $category->image_access = $request->checkbox_value;
                $category->save();
                return response()->json([
                    'message'   => 'Image Upload Successfully',
                    'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
                    'class_name'  => 'alert-success'
                ]);
            } else {
                return response()->json([
                    'message'   => $validation->errors()->all(),
                    'uploaded_image' => '',
                    'class_name'  => 'alert-danger'
                ]);
            }
        }
    }
    public function updateCategory(Request $request) {
        if($request->type == 'profile') {
            $rules = array('category_name' => 'required', 'category_name_no' => 'required', 'category_url' => 'required','category_description' => 'required', 'category_description_no' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $category = Categories::where('id', $request->hidden_id)->first();
                $category->category_name = $request->category_name;
                $category->category_name_no = $request->category_name_no;
                $category->category_url = strtolower(str_replace(" ", "_", $request->category_url));
                $category->category_description = $request->category_description;
                $category->category_description_no = $request->category_description_no;
                $category->save();
                return response()->json(['status' => 'true']);
            }
        } else if ($request->type == 'meta') {
            $category = Categories::where('id', $request->hidden_id)->first();
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->save();
            return response()->json(['status' => 'true']);
        } else {
            $validation = Validator::make($request->all(), [
                'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:256'
            ]);
            if($validation->passes()) {
                $image = $request->file('select_file');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/categories'), $new_name);
                $category = Categories::where('id', $request->hidden_id)->first();
                $category->category_icon = 'images/categories/'.$new_name;
                $category->image_access = $request->checkbox_value;
                $category->save();
                return response()->json([
                    'message'   => 'Image Upload Successfully',
                    'uploaded_image' => '<img src="'.$category->category_icon.'" class="img-thumbnail" width="300" />',
                    'class_name'  => 'alert-success'
                ]);
            } else {
                return response()->json([
                    'message'   => $validation->errors()->all(),
                    'uploaded_image' => '',
                    'class_name'  => 'alert-danger'
                ]);
            }
        }
    }

    public function createPage(Request $request) {
        if ($request->type == "page") {
            $rules = array('page_name' => 'required', 'page_url' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = new Page;
                $page->page_name = $request->page_name;
                $page->page_url = strtolower(str_replace(" ", "_", $request->page_url));
                $page->save();
                return response()->json(['status' => true, 'id' => $page->id]);
            }
        } else if ($request->type == 'meta') {
            $rules = array('meta_title' => 'required|max:55', 'meta_description' => 'required|max:55');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->meta_title = $request->meta_title;
                $page->meta_description = $request->meta_description;
                $page->save();
                return response()->json(['status' => true]);
            }
        } else {
            $rules = array('page_body' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->page_body = $request->page_body;
                $page->save();
                return response()->json(['status' => true]);
            }
        }
    }
    public function updatePage(Request $request) {
        if ($request->type == "page") {
            $rules = array('page_name' => 'required', 'page_url' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->page_name = $request->page_name;
                $page->page_url = strtolower(str_replace(" ", "_", $request->page_url));
                $page->save();
                return response()->json(['status' => true]);
            }
        } else if ($request->type == 'meta') {
            $rules = array('meta_title' => 'required|max:55', 'meta_description' => 'required|max:55');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $page->meta_title = $request->meta_title;
                $page->meta_description = $request->meta_description;
                $page->save();
                return response()->json(['status' => true]);
            }
        } else {
            $rules = array('page_body' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $page = Page::where('id', $request->hidden_id)->first();
                $data = json_decode($page->page_body);

                if ($page->id == 63) {
                    $key = $request->detail_type;
                    if (strstr($key, 'benefit_title')) {
                        $data->benefit_list->en_title = $request->page_body['en'];
                        $data->benefit_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'review_title')) {
                        $data->review_list->en_title = $request->page_body['en'];
                        $data->review_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'benefit_arr')) {
                        $data->benefit_list->arr = $request->page_body;
                    } else if (strstr($key, 'benefit_button')) {
                        $data->benefit_list->buttons = $request->page_body;
                    } else if (strstr($key, 'review_arr')) {
                        $data->review_list->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 1) {
                    $key = $request->detail_type;
                    if (strstr($key, 'review_title')) {
                        $data->review_list->en_title = $request->page_body['en'];
                        $data->review_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'review_arr')) {
                        $data->review_list->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 2) {
                    $key = $request->detail_type;
                    if (strstr($key, 'platform_title')) {
                        $data->platform_list->en_title = $request->page_body['en'];
                        $data->platform_list->no_title = $request->page_body['no'];
                        $data->platform_list->plat_img = $request->page_body['plat_img'];
                    } else if (strstr($key, 'become_consult_arr')) {
                        $data->platform_list->arr = $request->page_body;
                    } else if (strstr($key, 'review_title')) {
                        $data->review_list->en_title = $request->page_body['en'];
                        $data->review_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'review_arr')) {
                        $data->review_list->arr = $request->page_body;
                    } else if (strstr($key, 'register_title')) {
                        $data->register_list->en_title = $request->page_body['en'];
                        $data->register_list->no_title = $request->page_body['no'];
                        $data->register_list->en_des_title = $request->page_body['en_des'];
                        $data->register_list->no_des_title = $request->page_body['no_des'];
                    } else if (strstr($key, 'register_arr')) {
                        $data->register_list->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 3) {
                    $key = $request->detail_type;
                    if (strstr($key, 'article_title')) {
                        $data->article_list->en_title = $request->page_body['en'];
                        $data->article_list->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'article_arr')) {
                        $data->article_list->arr = $request->page_body;
                    } else if (strstr($key, 'team_title')) {
                        $data->team->en_part_title = $request->page_body['en_part_title'];
                        $data->team->no_part_title = $request->page_body['no_part_title'];
                        $data->team->en_title = $request->page_body['en_title'];
                        $data->team->no_title = $request->page_body['en_title'];
                    } else if (strstr($key, 'team_arr')) {
                        $data->team->arr = $request->page_body;
                    } else if (strstr($key, 'get_started_title')) {
                        $data->get_started->en_title = $request->page_body['en'];
                        $data->get_started->no_title = $request->page_body['no'];
                    } else if (strstr($key, 'get_started_arr')) {
                        $data->get_started->arr = $request->page_body;
                    } else {
                        $data->$key = $request->page_body;
                    }
                }

                if ($page->id == 8 || $page->id == 7 || $page->id == 6 || $page->id == 4 || $page->id == 5 || $page->id == 9 || $page->id == 10) {
                    $key = $request->detail_type;
                    $data->$key = $request->page_body;
                }

                $page->page_body = json_encode($data);
                $page->save();
                return response()->json(['status' => true]);
            }
        }
    }
    
    public function homeHelpImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/home") ."/" . $request->file->store('', 'home');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function homeBenefitImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/home") ."/" . $request->file->store('', 'home');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function homeReviewImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/home") ."/" . $request->file->store('', 'home');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function becomeConsultantPlatformImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/become_consultant") ."/" . $request->file->store('', 'become_consultant');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function memberImageUpload(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/member") ."/" . $request->file->store('', 'member');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function updateMemberSetting(Request $request) {
        if ($request->type == "personal") {
            $rules = array(
                'prof_image' => 'required',
                'first_name' => 'required', 
                'last_name' => 'required',
                'phone' => 'required|regex:/[0-9]{9}/',
                'industry_expertise' => 'required');
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::where('id', $request->hidden_id)->first();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->save();
                if ($user->role == 'consultant') {
                    $consultant = Consultant::where('unique_id', $request->hidden_id)->first();
                    $consultant->industry_expertise = $request->industry_expertise;
                    $consultant->prof_image = $request->prof_image;
                    $consultant->save();
                } else {
                    $customer = Customer::where('unique_id', $request->hidden_id)->first();
                    $customer->industry_expertise = $request->industry_expertise;
                    $customer->prof_image = $request->prof_image;
                    $customer->save();
                }
                return response()->json(['status' => true]);
            }
        } else if ($request->type == "contact") {
            if ($request->role == 'consultant') {
                $consultant = Consultant::where('unique_id', $request->hidden_id)->first();
                $consultant->phone_contact = $request->phone_contact;
                $consultant->chat_contact = $request->chat_contact;
                $consultant->video_contact = $request->video_contact;
                $consultant->save();
            } else {
                $customer = Customer::where('unique_id', $request->hidden_id)->first();
                $customer->phone_contact = $request->phone_contact;
                $customer->chat_contact = $request->chat_contact;
                $customer->video_contact = $request->video_contact;
                $customer->save();
            }
            
            return response()->json(['status' => 'success']);
        } else if ($request->type == "invoice") {
            $rules = array(
                'company_name' => 'required',
                'invoice_mail' => 'required', 
                'invoice_first_name' => 'required',
                'invoice_last_name' => 'required',
                'invoice_address' => 'required',
                'invoice_zip_code' => 'required',
                'invoice_zip_place' => 'required');
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                if ($request->role == 'consultant') {
                    $consultant = Consultant::where('unique_id', $request->hidden_id)->first();
                    $consultant->company_name = $request->company_name;
                    $consultant->invoice_mail = $request->invoice_mail;
                    $consultant->invoice_first_name = $request->invoice_first_name;
                    $consultant->invoice_last_name = $request->invoice_last_name;
                    $consultant->invoice_address = $request->invoice_address;
                    $consultant->invoice_zip_code = $request->invoice_zip_code;
                    $consultant->invoice_zip_place = $request->invoice_zip_place;
                    $consultant->save();
                } else {
                    $customer = Customer::where('unique_id', $request->hidden_id)->first();
                    $customer->company_name = $request->company_name;
                    $customer->invoice_mail = $request->invoice_mail;
                    $customer->invoice_first_name = $request->invoice_first_name;
                    $customer->invoice_last_name = $request->invoice_last_name;
                    $customer->invoice_address = $request->invoice_address;
                    $customer->invoice_zip_code = $request->invoice_zip_code;
                    $customer->invoice_zip_place = $request->invoice_zip_place;
                    $customer->save();
                }
                return response()->json(['status' => 'success']);
            }
        } else if ($request->type == "password") {
            $user = User::where('id', $request->hidden_id)->first();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        }
    }

    public function createConsultant(Request $request) {
        if ($request->type == "profile") {
            $rules = array('first_name' => 'required', 'last_name' => 'required','email' => 'required|email', 'phone' => 'required|regex:/[0-9]{9}/','industry_expertise' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = new User;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->role = 'consultant';
                $user->save();
                $consultant = new Consultant;
                $consultant->prof_image = $request->prof_image;
                $consultant->image_access = $request->image_access;
                $consultant->industry_expertise = $request->industry_expertise;
                $consultant->unique_id = $user->id;
                $consultant->save();
                return response()->json(['status' => 1, 'id' => $user->id]);
            }
        } else if ($request->type == "invoice") {
            $consultant = Consultant::where('unique_id', $request->hidden_id)->first();
            $consultant->company_name = $request->company_name;
            $consultant->invoice_mail = $request->invoice_mail;
            $consultant->invoice_first_name = $request->invoice_first_name;
            $consultant->invoice_last_name = $request->invoice_last_name;
            $consultant->invoice_address = $request->address;
            $consultant->invoice_zip_code = $request->zip_code;
            $consultant->invoice_zip_place = $request->zip_place;
            $consultant->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "contact") {
            $consultant = Consultant::where('unique_id', $request->hidden_id)->first();
            $consultant->phone_contact = $request->phone_contact;
            $consultant->chat_contact = $request->chat_contact;
            $consultant->video_contact = $request->video_contact;
            $consultant->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "password") {
            $consultant = User::where('id', $request->hidden_id)->first();
            if ($request->password == $request->confirm_password) {
                $consultant->password = Hash::make($request->confirm_password);
                $consultant->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        }
    }
    public function updateConsultant(Request $request) {
        if ($request->type == "profile") {
            $rules = array('first_name' => 'required', 'last_name' => 'required','email' => 'required|email', 'phone' => 'required|regex:/[0-9]{9}/','industry_expertise' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = new User;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->role = 'customer';
                $user->save();
                $customer = new Customer;
                $customer->prof_image = $request->prof_image;
                $customer->image_access = $request->image_access;
                $customer->industry_expertise = $request->industry_expertise;
                $customer->unique_id = $user->id;
                $customer->save();
                return response()->json(['status' => 1, 'id' => $user->id]);
            }
        } else if ($request->type == "invoice") {
            $customer = Customer::where('unique_id', $request->hidden_id)->first();
            $customer->company_name = $request->company_name;
            $customer->invoice_mail = $request->invoice_mail;
            $customer->invoice_first_name = $request->invoice_first_name;
            $customer->invoice_last_name = $request->invoice_last_name;
            $customer->invoice_address = $request->address;
            $customer->invoice_zip_code = $request->zip_code;
            $customer->invoice_zip_place = $request->zip_place;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "contact") {
            $customer = Customer::where('unique_id', $request->hidden_id)->first();
            $customer->phone_contact = $request->phone_contact;
            $customer->chat_contact = $request->chat_contact;
            $customer->video_contact = $request->video_contact;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "password") {
            $customer = User::where('id', $request->hidden_id)->first();
            if ($request->password == $request->confirm_password) {
                $customer->password = Hash::make($request->confirm_password);
                $customer->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        }
    }

    public function createCustomer(Request $request) {
        if ($request->type == "profile") {
            $rules = array('first_name' => 'required', 'last_name' => 'required','email' => 'required|email', 'phone' => 'required|regex:/[0-9]{9}/','industry_expertise' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = new User;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->role = 'customer';
                $user->save();
                $customer = new Customer;
                $customer->prof_image = $request->prof_image;
                $customer->image_access = $request->image_access;
                $customer->industry_expertise = $request->industry_expertise;
                $customer->unique_id = $user->id;
                $customer->save();
                return response()->json(['status' => 1, 'id' => $user->id]);
            }
        } else if ($request->type == "invoice") {
            $customer = Customer::where('unique_id', $request->hidden_id)->first();
            $customer->company_name = $request->company_name;
            $customer->invoice_mail = $request->invoice_mail;
            $customer->invoice_first_name = $request->invoice_first_name;
            $customer->invoice_last_name = $request->invoice_last_name;
            $customer->invoice_address = $request->address;
            $customer->invoice_zip_code = $request->zip_code;
            $customer->invoice_zip_place = $request->zip_place;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "contact") {
            $customer = Customer::where('unique_id', $request->hidden_id)->first();
            $customer->phone_contact = $request->phone_contact;
            $customer->chat_contact = $request->chat_contact;
            $customer->video_contact = $request->video_contact;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "password") {
            $customer = User::where('id', $request->hidden_id)->first();
            if ($request->password == $request->confirm_password) {
                $customer->password = Hash::make($request->confirm_password);
                $customer->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        }
    }
    public function updateCustomer(Request $request) {
        if ($request->type == "profile") {
            $rules = array('first_name' => 'required', 'last_name' => 'required', 'phone' => 'required|regex:/[0-9]{9}/','industry_expertise' => 'required');
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response = array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                );
                return response()->json($response);
            } else {
                $user = User::where('id', $request->hidden_id)->first();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->save();
                $customer = Customer::where('unique_id', $request->hidden_id)->first();
                $customer->industry_expertise = $request->industry_expertise;
                $customer->save();
                return response()->json(['status' => true]);
            }
        } else if ($request->type == "invoice") {
            $customer = Customer::where('unique_id', $request->hidden_id)->first();
            $customer->company_name = $request->company_name;
            $customer->invoice_mail = $request->invoice_mail;
            $customer->invoice_first_name = $request->invoice_first_name;
            $customer->invoice_last_name = $request->invoice_last_name;
            $customer->invoice_address = $request->address;
            $customer->invoice_zip_code = $request->zip_code;
            $customer->invoice_zip_place = $request->zip_place;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "contact") {
            $customer = Customer::where('unique_id', $request->hidden_id)->first();
            $customer->phone_contact = $request->phone_contact;
            $customer->chat_contact = $request->chat_contact;
            $customer->video_contact = $request->video_contact;
            $customer->save();
            return response()->json(['status' => 'success']);
        } else if ($request->type == "password") {
            $user = User::where('id', $request->hidden_id)->first();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        } else {
            $customer = Customer::where('id', $request->hidden_id)->first();
            $customer->prof_image = 'images/customer'.$new_name;
            $customer->image_access = $request->checkbox_value;
            $customer->save();
            return response()->json(['status' => 'success']);
        }
    }

    public function manageStatus(Request $request) {
        $user = User::where('id', $request->id)->first();
        $user->status = $request->status;
        $user->save();
        return response()->json('success');
    }

    public function manageBalance(Request $request) {
        $user = User::where('id', $request->id)->first();
        $user->status = "Available";
        $user->balance = (float)$user->balance - (float)$request->cost;
        $user->save();
        return response()->json($user);
    }

    public function manageRate(Request $request) {
        $rate = new Rate;
        $rate->user_id = $request->id;
        $rate->rate = (int)$request->rate;
        $rate->save();

        $rates = Rate::where('user_id', $request->id)->get();
        $total_val = 0;
        foreach($rates as $item) {
            $total_val += $item->rate;
        }
        $avg_rate = (float) ($total_val / count($rates));
        
        $user = User::where('id', $request->id)->first();
        $user->rate = $avg_rate;
        $user->save();

        $consultant = Consultant::where('unique_id', $request->id)->with('user')->first();
        return response()->json($consultant);
    }
}
