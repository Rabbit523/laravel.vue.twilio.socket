<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use zaporylie\Vipps\Resource\Payment\InitiatePayment;
use zaporylie\Vipps\Client;
use zaporylie\Vipps\Vipps;
use Illuminate\Support\Facades\Auth;

Class VippsCheckout {

  public static function createCheckout(Request $request) {
    $clientId = getenv('VIPPS_CLIENT_ID') ?: '94a326f2-aacb-4cd5-9d07-32203d785892';
    $clientSecret = getenv('VIPPS_CLIENT_SECRET') ?: 'RzlDR1dkUm1yak5XbWNlQnUwVVc=';
    $subscription_key = getenv('VIPPS_SUBSCRIPTION_KEY') ? : '19b70a75494c4a28b8a029fc677e45fe';    
  
    $user = Auth::user();
    $merchantSerialNumber = $user->id.rand(00000000, 99999999).time();
    $order_id = $merchantSerialNumber.$request->name;
    $date = date('m/d/Y h:i:s a', time());
    
    $request  = [
      "customerInfo" => [],
      "merchantInfo" => [
        "authToken" => $request->token,
        "callbackPrefix" => "https://gotoconsult.fantasylab.io/api/vipps/fallback-result-page/".$order_id,
        "consentRemovalPrefix" => "https://gotoconsult.fantasylab.io/api/vipps",
        "fallBack" => "https://gotoconsult.fantasylab.io/api/vipps/fallback-result-page/".$order_id,
        "isApp" => false,
        "merchantSerialNumber" => $merchantSerialNumber,
        "paymentType" => "eComm Regular Payment",
        "shippingDetailsPrefix" => "",
        "staticShippingDetails" => [],
        "transaction" => [
          "amount" => $request->price,
          "orderId" => $order_id,
          "timeStamp" => date('m/d/Y h:i:s a', time()),
          "transactionText" => $request->name,
          "skipLandingPage" => false
        ]
      ]
    ];

    try {
      $resource  = new InitiatePayment($subscription_key, $request);
      $response = $resource->call();
      
      return response()->json($response);
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}
?>