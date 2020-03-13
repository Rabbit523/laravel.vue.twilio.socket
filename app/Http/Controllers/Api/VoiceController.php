<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\ClientToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\Twiml;

class VoiceController extends Controller
{
   /**
  * Making an outgoing call
  */
  public function initiateCall(Request $request) {
    // Twilio credentials
    $account_sid = env('ACCOUNT_SID');
    $auth_token = env('AUTH_TOKEN');

    //The twilio number you purchased
    $from = env('TWILIO_PHONE_NUMBER');

    // Initialize the Programmable Voice API
    $client = new Client($this->account_sid, $this->auth_token);

    // Validate form input
    $this->validate($request, [
      'phone_number' => 'required|string',
    ]);

    try {
      //Lookup phone number to make sure it is valid before initiating call
      $phone_number = $client->lookups->v1->phoneNumbers($request->phone_number)->fetch();
      // If phone number is valid and exists
      if($phone_number) {
        // Initiate call and record call
        $call = $client->account->calls->create(
          $request->phone_number, // Destination phone number
          $from, // Valid Twilio phone number
          array("url" => "http://demo.twilio.com/docs/voice.xml"));

        if($call) {
          echo 'Call initiated successfully';
        } else {
          echo 'Call failed!';
        }
      }
    } catch (Exception $e) {
      echo 'Error: ' . $e->getMessage();
    } catch (RestException $rest) {
      $msg = $rest->getMessage();
      echo 'Error: ' . $rest->getMessage();
    }
  }

  public function generate(Request $request) {
    // Create access token, which we will serialize and send to the client
    $token = new AccessToken(env('TWILIO_AUTH_SID'), env('TWILIO_API_SID'), env('TWILIO_API_SECRET'), 3600, $request->phone);
    // Create Voice grant
    $voiceGrant = new VoiceGrant();
    $voiceGrant->setOutgoingApplicationSid(env('TWILIO_TWIML_APP_SID'));
    // Optional: add to allow incoming calls
    $voiceGrant->setIncomingAllow(true);
    // Add grant to token
    $token->addGrant($voiceGrant);

    return response()->json(['token' => $token->toJWT()]);
  }

  public function newToken(Request $request) {
    $account_sid = env('TWILIO_AUTH_SID');
    $auth_token = env('TWILIO_AUTH_TOKEN');
    // Create access token, which we will serialize and send to the client
    $clientToken = new ClientToken($account_sid, $auth_token);
    $clientToken->allowClientOutgoing(env('TWILIO_TWIML_APP_SID'));
    
    // Optional: add to allow incoming calls
    $clientToken->allowClientIncoming($request->name);

    $token = $clientToken->generateToken();

    return response()->json(['token' => $token]);
  }

  public function voiceHook(Request $request) {
    $response = "<?xml version='1.0' encoding='UTF-8'?><Response>".
    "<Dial timeout='30' callerId='".$request->callerId."'><Number>".
    $request->phone."</Number><Client><Identity>".$request->name.
    "</Identity><Parameter name='type' value='".$request->type."'/>
    <Parameter name='roomName' value='".$request->roomName."'/></Client></Dial></Response>";
    return response($response, 200)->header('Content-Type', 'text/xml');
  }
}
