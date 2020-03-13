<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class VideoController extends Controller
{
  public function joinRoom(Request $request) {
    // Create access token, which we will serialize and send to the client
    $token = new AccessToken(env('TWILIO_AUTH_SID'), env('TWILIO_API_SID'), env('TWILIO_API_SECRET'), 3600, $request->userName);
    // Create Voice grant
    $videoGrant  = new VideoGrant();
    $videoGrant->setRoom($request->roomName);
    // Add grant to token
    $token->addGrant($videoGrant);

    return response()->json(['token' => $token->toJWT()]);
  }

  public function createRoom(Request $request) {
    $client = new Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));

    $exists = $client->video->rooms->read([ 'uniqueName' => $request->name]);

    if (empty($exists)) {
      $client->video->rooms->create([
        'uniqueName' => $request->name,
        'type' => 'group',
        'recordParticipantsOnConnect' => false
      ]);
    }
    return response()->json('video room is ready');
  }

  public function videoCallStatus(Request $request) {
    return response($request->all());
  }
}
