<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('is_404')){
	function is_404($url) {
	    $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);  
		if($httpcode == 200){
          return true;
        }else {
            return false;
        }
	}
}

if ( ! function_exists('getDiamondSkuByPath')){
	function getDiamondSkuByPath($path) {
	    $urlstring = $path;    	
		$urlarray = explode('-sku-', $urlstring);
		return $urlarray[1];
	}
}

if ( ! function_exists('getCurlData')){
	function getCurlData($url,$headers) {
	    $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
        $response = curl_exec($curl);
        return $results = json_decode($response);
	}
}

if ( ! function_exists('postCurlData')){
	function postCurlData($url,$headers,$data,$method) {
	    $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers
        ));
        $response = curl_exec($curl);
        file_put_contents('post_curl_response.txt', $response);
        file_put_contents('url.txt', $url);
        file_put_contents('headers.txt', $headers);
        file_put_contents('data.txt', $data);
        file_put_contents('method.txt', $method);

        return $results = json_decode($response);
	}
}

if ( ! function_exists('getRingSkuByPath')){
	function getRingSkuByPath($path) {
	    $urlstring = $path;    	
		$urlarray = explode('-sku-', $urlstring);
		return $urlarray[1];
	}
}

if ( ! function_exists('getShopToken')){
    function getShopToken($access_token_url,$query) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $access_token_url);
        curl_setopt($curl, CURLOPT_POST, count($query));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query));
        $result = curl_exec($curl);
        
        curl_close($curl);
        $result = json_decode($result, true);

        return $result['access_token'];
    }
}

if ( ! function_exists('shopify_call')){
    function shopify_call($token, $shop,$shopify_json_endpoint,$data,$method) {
        $shopifycallurl = 'https://'.$shop.$shopify_json_endpoint;
        $request_headers = array(
                    "X-Shopify-Access-Token:" . $token,
                    "Content-Type:application/json"
                );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $shopifycallurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $request_headers
        ));
        $response = curl_exec($curl);
        return $results = json_decode($response);
    }
}

if ( ! function_exists('actual_shop_address')){
    function actual_shop_address($access_token, $shop, $path_prefix, $with_prefix = false) {
        
        $api_base_url = "https://".$shop;
        $get_shop_data_endpoint = "/admin/shop.json";
        $getShopDataRequestURL = $api_base_url.$get_shop_data_endpoint;

        $request_headers = array(
                            "X-Shopify-Access-Token:" . $access_token,
                            "Content-Type:application/json"
                        );
              
        $resultShop = getCurlData($getShopDataRequestURL,$request_headers);
        
        if($resultShop->shop->domain){
          $base_shop_url = $resultShop->shop->domain;
        }else{
          $base_shop_url = $shop;
        }
        if($with_prefix){
            return $final_shop_url = "https://".$base_shop_url.$path_prefix;    
        }else{
            return $base_shop_url;
        }
        
    }
}
?>