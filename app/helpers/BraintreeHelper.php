<?php
class BraintreeHelper {
    private static $environment = BRAINTREE_ENVIRONMENT;
    private static $merchantId = BRAINTREE_MERCHANT_ID;
    private static $publicKey = BRAINTREE_PUBLIC_KEY;
    private static $privateKey = BRAINTREE_PRIVATE_KEY;
    
    public static function getGateway() {
        // This is just a placeholder since we're not using the SDK
        return null;
    }
    
    public static function generateClientToken() {
        $url = self::getApiUrl() . '/client_token';
        
        $response = self::makeApiRequest($url, 'POST', []);
        
        if (isset($response['clientToken'])) {
            return $response['clientToken'];
        }
        
        return null;
    }
    
    private static function getApiUrl() {
        $base = (self::$environment === 'production') 
            ? 'https://api.braintreegateway.com'
            : 'https://api.sandbox.braintreegateway.com';
            
        return $base . '/merchants/' . self::$merchantId;
    }
    
    private static function makeApiRequest($url, $method, $data) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, self::$publicKey . ':' . self::$privateKey);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }
}
