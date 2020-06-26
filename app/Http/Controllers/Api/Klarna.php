<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Klarna\Rest\Transport\Connector;
use Klarna\Rest\Transport\ConnectorInterface;
use Klarna\Rest\Checkout\Order;
use Klarna\Rest\OrderManagement\Order as OrderInStore;
use Illuminate\Support\Facades\Auth;

Class Klarna {

    public static function createCheckout(Request $request) {
        $merchantId = getenv('KLARNA_MERCHANT_ID') ?: 'PK12126_ebf20e785379';
        $sharedSecret = getenv('KLARNA_SHARED_SECRET') ?: 'eDWpqm3sIuKBi8jq';
        
        $connector = Connector::create(
            $merchantId,
            $sharedSecret,
            getenv('APP_ENV') === 'local' ? 
                ConnectorInterface::EU_TEST_BASE_URL :
                ConnectorInterface::EU_BASE_URL
        );
        
        $user = Auth::user();
        $rand_order_id = $user->id.rand(00000000, 99999999).time();
     
        $order = [
            "purchase_country" => 'no',
            "purchase_currency" => $request['currency'],
            "locale" => 'nb-no',
            "order_amount" => $request['price'] * 100,
            "order_tax_amount" => $request['price'] * 100 / 125 * 25,
            "order_lines" => [
                [
                    "type" => "physical",
                    "reference" => $rand_order_id,
                    "name" => $request["name"],
                    "quantity" => 1,
                    "quantity_unit" => "pcs",
                    "unit_price" => $request["price"] * 100,
                    "tax_rate" => 2500,
                    "total_amount" => $request["price"] * 100,
                    "total_tax_amount" => $request['price'] * 100 / 125 * 25,
                    "total_discount_amount" => 0
                ]
            ],
            "merchant_urls" => [
              "terms" => getenv('APP_URL') . "/terms",
              "checkout" => getenv('APP_URL') . "/klarna_checkout?sid={checkout.order.id}",
              "confirmation" => getenv('APP_URL') . "/klarna_confirmation?sid={checkout.order.id}&uid={$user->id}&amount={$request['price']}&currency={$request['currency']}",
              "push" => getenv('APP_URL') . "/api/klarna/push?checkout_uri={checkout.order.id}"
            ],
            "options" => [
                "shipping_countries" => [
                    'no'
                ],
                "radius_border" => "5px",
                "allow_separate_shipping_address" => true,
                "national_identification_number_mandatory" => false,
                "allowed_customer_types" => ["person", "organization"],
            ]
        ];

        // return $order;
        try {
            $checkout = new Order($connector);
            $checkout->create($order);
            
            return response()->json($checkout);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>