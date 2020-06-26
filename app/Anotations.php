<?php

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Gotoconsult API documentation",
 *      description="API description in https://gotoconsult.fantasylab.io",
 *      @OA\Contact(
 *          email="dmitrii@fantasylab.io"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     description="Laravel Swagger API Server",
 *     url=L5_SWAGGER_CONST_HOST, *
 * )
 *
 */

/**
 * @OA\Get(
 *      path="/",
 *      tags={"Pages"},
 *      description="Returns home view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 * @OA\Get(
 *      path="/no",
 *      tags={"Pages"},
 *      description="Returns home view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 */

/**
 * @OA\Get(
 *      path="/category/{id}",
 *      tags={"Pages"},
 *      description="Returns category data",
 *      @OA\Parameter(
 *          name="id",
 *          description="category id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Resource Not Found")
 * )
 * @OA\Get(
 *      path="/no/kategori/{id}",
 *      tags={"Pages"},
 *      description="Returns category data with Norwegian content",
 *      @OA\Parameter(
 *          name="id",
 *          description="category id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Resource Not Found")
 * )
 */

 /**
 * @OA\Get(
 *      path="/become-consultant",
 *      tags={"Pages"},
 *      description="Returns become consultant view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 * @OA\Get(
 *      path="/no/bli-konsulent",
 *      tags={"Pages"},
 *      description="Returns become consultant view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 */

 /**
 * @OA\Get(
 *      path="/about",
 *      tags={"Pages"},
 *      description="Returns about us view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 * @OA\Get(
 *      path="/no/om-oss",
 *      tags={"Pages"},
 *      description="Returns about us view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 */

 /**
 * @OA\Get(
 *      path="/privacy",
 *      tags={"Pages"},
 *      description="Returns privacy view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 * @OA\Get(
 *      path="/no/personvern",
 *      tags={"Pages"},
 *      description="Returns privacy view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 */

 /**
 * @OA\Get(
 *      path="/terms-customer",
 *      tags={"Pages"},
 *      description="Returns customer terms view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 * @OA\Get(
 *      path="/no/vilkar-kunde",
 *      tags={"Pages"},
 *      description="Returns customer terms view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 */

 /**
 * @OA\Get(
 *      path="/terms-provider",
 *      tags={"Pages"},
 *      description="Returns provider terms view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 * @OA\Get(
 *      path="/no/vilkar-tilbyder",
 *      tags={"Pages"},
 *      description="Returns provider terms view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found")
 * )
 */

 /**
 * @OA\Get(
 *      path="/find-consultant",
 *      tags={"Pages"},
 *      description="Returns consultants view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *      }
 * )
 * @OA\Get(
 *      path="/no/finn-konsulent",
 *      tags={"Pages"},
 *      description="Returns consultants view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *      }
 * )
 */

 /**
 * @OA\Get(
 *      path="/find-customer",
 *      tags={"Pages"},
 *      description="Returns customers view",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *      }
 * )
 * @OA\Get(
 *      path="/no/finn-kunde",
 *      tags={"Pages"},
 *      description="Returns customers view with Norwegian content",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=404, description="Page not found"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *      }
 * )
 */

 /**
 * @OA\Post(
 *      path="/api/klarna_checkout",
 *      tags={"Rest APIs"},
 *      description="Get klarna checkout snippet",
 *      @OA\Parameter(
 *          name="merchantId",
 *          description="klarna api merchant id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="sharedSecret",
 *          description="klarna api secret key",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="price",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="name",
 *          description="description",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *      }
 * )
 */

/**
 * @OA\Get(
 *      path="/api/klarna_confirmation",
 *      tags={"Rest APIs"},
 *      description="Get klarna confirmation",
 *      @OA\Parameter(
 *          name="id",
 *          description="klarna checkout id",
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request")
 * )
 */

/**
 * @OA\Post(
 *      path="/api/brain_token",
 *      tags={"Rest APIs"},
 *      description="Get braintree dropin client token",
 *      @OA\Parameter(
 *          name="environment",
 *          description="braintree environment",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="merchantId",
 *          description="braintree merchant id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
  *      @OA\Parameter(
 *          name="publicKey",
 *          description="braintree public key",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="privateKey",
 *          description="braintree private key",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="id",
 *          description="if the payment isn't new, then customer can use his id which is saved in braintree customer service.",
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *      }
 * )
 */

/**
 * @OA\Post(
 *      path="/api/credit_checkout",
 *      tags={"Rest APIs"},
 *      description="Braintree credit card checkout",
 *      @OA\Parameter(
 *          name="currency",
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="customer id",
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="nonce",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="amount",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="float"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request")
 * )
 */

/**
 * @OA\Post(
 *      path="/api/chat_token",
 *      tags={"Rest APIs"},
 *      description="Fetch twilio chat token",
 *      @OA\Parameter(
 *          name="email",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request")
 * )
 */

/**
 * @OA\Post(
 *      path="/api/chat_channel",
 *      tags={"Rest APIs"},
 *      description="Fetch twilio chat channel",
 *      @OA\Parameter(
 *          name="customer email",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="customer id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="consultant email",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="consultant id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request")
 * )
 */

 /**
 * @OA\Post(
 *      path="/api/call_token",
 *      tags={"Rest APIs"},
 *      description="Fetch twilio voice token",
 *      @OA\Parameter(
 *          name="phone number",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request")
 * )
 */

 /**
 * @OA\Post(
 *      path="/api/video_token",
 *      tags={"Rest APIs"},
 *      description="Fetch twilio video token",
 *      @OA\Parameter(
 *          name="user name",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="room name",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request")
 * )
 */

  /**
 * @OA\Post(
 *      path="/api/create_room",
 *      tags={"Rest APIs"},
 *      description="Create video room",
 *      @OA\Parameter(
 *          name="room name",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad Request")
 * )
 */