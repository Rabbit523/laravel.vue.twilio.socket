<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Categories;
use App\Models\Consultant;
use App\Models\Customer;
use App\Models\Profile;
use App\Models\Company;
use App\Models\Transactions;
use App\Models\Page;
use App\Models\Review;
use App\Models\Session;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Certificate;
use Hash;

class ApiController extends Controller
{
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
            $customer = Customer::where('user_id', $request->hidden_id)->first();
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
            $customer = Customer::where('user_id', $request->hidden_id)->first();
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
            $customer = Customer::where('user_id', $request->hidden_id)->first();
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
            $customer = Customer::where('user_id', $request->hidden_id)->first();
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
                $customer = Customer::where('user_id', $request->hidden_id)->first();
                $customer->industry_expertise = $request->industry_expertise;
                $customer->save();
                return response()->json(['status' => true]);
            }
        } else if ($request->type == "invoice") {
            $customer = Customer::where('user_id', $request->hidden_id)->first();
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
            $customer = Customer::where('user_id', $request->hidden_id)->first();
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

    public function manageTransaction(Request $request) {
        // manage user status and balance
        $user = User::where('id', $request->id)->first();
        $user->status = "Available";
        $new_cost = $user->balance - $request->cost;
        $user->balance = round($new_cost, 2);
        $user->save();
        // update session table
        $customer = Customer::where('user_id', $request->id)->first();
        Session::create(['customer_id' => $customer->id, 'consultant_id' => $request->consultant_id]);
        // update transaction table
        $transaction = [
            'transaction_id' => $this->getTransactionID(),
            'consultant_id' => $request->consultant_id,
            'user_id' => $user->id,
            'amount' => $request->cost,
            'time_spent' => $request->time
        ];
        Transactions::create($transaction);
        return response()->json($user);
    }
    
    public function manageReview(Request $request) {
        $review = Review::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->first();
        $new_session_count = 0;
        if (isset($review)) {
            $new_session_count = $review->session + 1;
            Review::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'rate' => $request->rate,
                'description' => $request->description,
                'type' => $request->type,
                'session' => $new_session_count
            ]);
            Review::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->update(['session' => $new_session_count]);
        } else {
            $new_session_count = 1;
            Review::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'rate' => $request->rate,
                'description' => $request->description,
                'type' => $request->type,
                'session' => 1
            ]);
        }

        $rates = Review::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->get();
        $total_val = 0;
        foreach($rates as $item) {
            $total_val += $item->rate;
        }
        $avg_rate = count($rates) > 0 ? (float) ($total_val / count($rates)) : 0;
        if ($request->type == 'CUSTOCON') {
            Consultant::where('id', $request->receiver_id)->update(['rate' => $avg_rate ]);
            Customer::where('id', $request->sender_id)->update(['completed_sessions' => $new_session_count]);
        } else {
            Customer::where('id', $request->receiver_id)->update(['rate' => $avg_rate ]);
            Consultant::where('id', $request->sender_id)->update(['completed_sessions' => $new_session_count]);
        }
        return response()->json('success');
    }

    public function getTransactionID(){
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return substr($c,0,15);
    }

    public function getUniversities() {
        $file = file_get_contents(public_path('world_universities_and_domains.json'));
        $array = json_decode($file, true);
        return response()->json(['array' => $array]);
    }

    public function updateMemberProfile(Request $request) {
        $user = User::where('id', $request->user_id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        // $user->email = $request->email;
        $user->save();
        
        if ($user->role == 'consultant') {
            $consultant = Consultant::where('user_id', $request->user_id)->first();
            $profile = Profile::where('id', $consultant->profile_id)->first();
            if (isset($profile)) {
                $profile->cover_img = $request->cover_image;
                $profile->avatar = $request->avatar;
                $profile->profession = $request->profession;
                $profile->from = $request->from;
                $profile->country = $request->country;
                $profile->region = $request->region;
                $profile->college = $request->college;
                $profile->timezone = $request->timezone;
                $profile->description = $request->description;
                $profile->save();
            } else {
                $data = [
                    'cover_img' => $request->cover_image,
                    'avatar' => $request->avatar,
                    'profession' => $request->profession,
                    'from' => $request->from,
                    'country' => $request->country,
                    'region' => $request->region,
                    'college' => $request->college,
                    'timezone' => $request->timezone,
                    'description' => $request->description
                ];
                $profile = Profile::create($data);
                $consultant->profile_id = $profile->id;
                $consultant->save();
            }
        } else {
            $customer = Customer::where('user_id', $request->user_id)->first();
            $profile = Profile::where('id', $customer->profile_id)->first();
            if (isset($profile)) {
                $profile->cover_img = $request->cover_image;
                $profile->avatar = $request->avatar;
                $profile->profession = $request->profession;
                $profile->from = $request->from;
                $profile->country = $request->country;
                $profile->region = $request->region;
                $profile->college = $request->college;
                $profile->timezone = $request->timezone;
                $profile->description = $request->description;
                $profile->save();
            } else {
                $data = [
                    'cover_img' => $request->cover_image,
                    'avatar' => $request->avatar,
                    'profession' => $request->profession,
                    'from' => $request->from,
                    'country' => $request->country,
                    'region' => $request->region,
                    'college' => $request->college,
                    'timezone' => $request->timezone,
                    'description' => $request->description
                ];
                $profile = Profile::create($data);
                $customer->profile_id = $profile->id;
                $customer->save();
            }
        }
        return response()->json(['status' => true]);
    }

    public function memberImageUpload(Request $request) {
        if ($request->remove_url) {
            unlink(public_path($request->remove_url));
        }
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
        if ($request->type == "contact") {
            if ($request->role == 'consultant') {
                $consultant = Consultant::where('user_id', $request->user_id)->first();
                $consultant->phone_contact = $request->phone_contact;
                $consultant->chat_contact = $request->chat_contact;
                $consultant->video_contact = $request->video_contact;
                $consultant->currency = $request->currency;
                $consultant->hourly_rate = $request->rate;
                $consultant->save();
            } else {
                $customer = Customer::where('user_id', $request->user_id)->first();
                $customer->phone_contact = $request->phone_contact;
                $customer->chat_contact = $request->chat_contact;
                $customer->video_contact = $request->video_contact;
                $customer->currency = $request->currency;
                $customer->save();
            }
            return response()->json(['status' => 'success']);
        } else if($request->type == 'company') {
            $customer = Customer::where('user_id', $request->user_id)->first();
            if (isset($customer->company_id)) {
                $company = Company::where('id', $customer->company_id)->first();
                $company->company_name = $request->company_name;
                $company->organization_number = $request->organization_number;
                $company->bank_account = $request->bank_account;
                $company->first_name = $request->first_name;
                $company->last_name = $request->last_name;
                $company->address = $request->address;
                $company->zip_code = $request->zip_code;
                $company->zip_place = $request->zip_place;
                $company->country = $request->country;
                $company->save();
            } else {
                $data = [
                    'company_name' => $request->company_name,
                    'organization_number' => $request->organization_number,
                    'bank_account' => $request->bank_account,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'zip_code' => $request->zip_code,
                    'zip_place' => $request->zip_place,
                    'country' => $request->country
                ];
                $company = Company::create($data);
                $customer->company_id = $company->id;
                $customer->save();
            }
            return response()->json(['status' => 'success']);
        } else if ($request->type == "password") {
            $user = User::where('id', $request->user_id)->first();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 1]);
            }
        }
    }

    public function consultantDoc(Request $request) {
        if ($request->file('file')->isValid()){
            $url = url("/assets/uploads/member") ."/" . $request->file->store('', 'member');
            $arr = explode("/", $url);
            $path = "/".$arr[3]."/".$arr[4]."/".$arr[5]."/".$arr[6];
            return response()->json(['url' => $path, 'status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function becomeConsultant(Request $request) {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->ex_phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'consultant',
            'status' => 'Offline',
            'balance' => '0',
            'account_id' => $request->account,
            'active' => '0'
        ]);
        
        $profile = Profile::create([
            'avatar' => $request->profile_avatar,
            'profession' => $request->profession,
            'from' => $request->from,
            'country' => $request->country,
            'region' => $request->region,
            'timezone' => $request->timezone,
            'description' => $request->consultant_introduction
        ]);

        $company = Company::create([
            'company_name' => $request->company_name,
            'organization_number' => $request->organization_number,
            'bank_account' => $request->bank_account,
            "first_name" => $request->cfirst_name,
            "last_name" => $request->clast_name,
            "address" => $request->company_address,
            "zip_code" => $request->czip_code,
            "zip_place" => $request->company_region,
            "country" => $request->company_from
        ]);

        $consultant = Consultant::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'company_id' => $company->id,
            'chat_contact' => $request->chat_contact,
            'phone_contact' => $request->phone_contact,
            'video_contact' => $request->video_contact,
            'currency' => $request->currency,
            'hourly_rate' => $request->rate
        ]);
        
        if ($request->education_count > 0) {
            for ($i = 0; $i < $request->education_count; $i++) {
                Education::create([
                    "consultant_id" => $consultant->id,
                    "from" => $request["education{$i}_from"],
                    "to" => $request["education{$i}_to"],
                    "institution" => $request["education{$i}_institution"],
                    "major" => $request["education{$i}_major"],
                    "degree" => $request["education{$i}_degree"],
                    "description" => $request["education{$i}_description"],
                    "diploma" => $request["education{$i}_diploma"]
                ]);
            }
        }
        if ($request->experience_count > 0) {
            for ($i = 0; $i < $request->experience_count; $i++) {
                Experience::create([
                    "consultant_id" => $consultant->id,
                    "from" => $request["experience{$i}_from"],
                    "to" => $request["experience{$i}_to"],
                    "company" => $request["experience{$i}_company"],
                    "position" => $request["experience{$i}_position"],
                    "country" => $request["experience{$i}_country"],
                    "city" => $request["experience{$i}_city"],
                    "description" => $request["experience{$i}_description"]
                ]);
            }
        }
        if ($request->certificate_count > 0) {
            for ($i = 0; $i < $request->certificate_count; $i++) {
                Certificate::create([
                    "consultant_id" => $consultant->id,
                    "date" => $request["certificate{$i}_date"],
                    "name" => $request["certificate{$i}_name"],
                    "institution" => $request["certificate{$i}_institution"],
                    "description" => $request["certificate{$i}_description"],
                    "diploma" => $request["certificate{$i}_diploma"]
                ]);
            }
        }
        return redirect()->to('login');
    }
}
