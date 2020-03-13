<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

use Auth;

class MessageController extends Controller
{
  public function chatChannel(Request $request) {
    $twilio = new Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));
    $current_user = Auth::user();
  
    // Fetch channel or create a new one if it doesn't exist
    try {
      $channel = $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))
        ->channels("private-".$request->consultant_id."-".$request->customer_id)
        ->fetch();
    } catch (RestException $e) {
      $channel = $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))->channels->create(['uniqueName' => "private-".$request->consultant_id."-".$request->customer_id,'type' => 'private']);
    }

    // add consultant to the channel
    try {
      $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members($request->consultant_email)->fetch();
    } catch (RestException $e) {
      $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members->create($request->consultant_email);
    }
    // Add customer to the channel
    try {
      $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members($request->customer_email)->fetch();
    } catch (RestException $e) {
      $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))->channels("private-".$request->consultant_id."-".$request->customer_id)->members->create($request->customer_email);
    }

    return response()->json("success");
  }

  public function generate(Request $request)  {
    $token = new AccessToken(env('TWILIO_AUTH_SID'), env('TWILIO_API_SID'), env('TWILIO_API_SECRET'), 3600, $request->email);
    
    $chatGrant = new ChatGrant();
    $chatGrant->setServiceSid(env('TWILIO_SERVICE_SID'));
    $token->addGrant($chatGrant);

    return response()->json(['token' => $token->toJWT()]);
  }
}
