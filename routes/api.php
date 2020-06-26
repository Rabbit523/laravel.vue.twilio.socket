<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/chat', 'Api\MessageController@chat');
    Route::post('/chat_channel', 'Api\MessageController@chatChannel');
    Route::post('/chat_token', 'Api\MessageController@generate');

    Route::post('/call', 'Api\VoiceController@initiateCall');
    Route::post('/call_token', 'Api\VoiceController@generate');
    Route::post('/new_token', 'Api\VoiceController@newToken');
    Route::post('/call_status', 'Api\VoiceController@callStatus');

    Route::post('/video_token', 'Api\VideoController@joinRoom');
    Route::post('/create_room', 'Api\VideoController@createRoom');

    Route::post('/manage_status', 'Api\ApiController@manageStatus');
    Route::post('/manage_transaction', 'Api\ApiController@manageTransaction');
    Route::post('/submit_review', 'Api\ApiController@manageReview');
    Route::get('/get-universities', 'Api\ApiController@getUniversities');
    
    Route::post('/member_image_upload', 'Api\ApiController@memberImageUpload');
    Route::post('/update_member_profile', 'Api\ApiController@updateMemberProfile');
    Route::post('/update_member_setting', 'Api\ApiController@updateMemberSetting');
    Route::post('/consultant_doc_upload', 'Api\ApiController@consultantDoc');

    Route::post('/become-consultant', 'Api\ApiController@becomeConsultant');
});

