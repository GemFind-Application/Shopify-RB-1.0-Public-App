<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charge extends CI_Controller {

	function __construct()
	{  	
		parent::__construct();
		$this->load->model('general_model');
		//header('X-Frame-Options: allow-from https://gemfind-demo-store-8.myshopify.com');
		//header('Set-Cookie: cross-site-cookie=name; SameSite=None; Secure');
	}

	public function index()
	{
		$api_version = '2022-10';
		$params = $_GET; // Retrieve all request parameters
		$shop = $params['shop'];
		if( isset($params['charge_id']) && $params['charge_id'] != '' ) {
		  	$access_tk_session = $this->session->userdata($shop.'_access_tk');
			$charge_id = $params['charge_id'];

			/*$activation_array = array(
				'application_charge' => array(
					"id" => $charge_id,
				    "name" => "Gemfind Basic Plan",
				    "api_client_id" => rand(1000000, 9999999),
				    "price" => "295.00",
				    "status" => "accepted",
				    "return_url" => "https://".$shop."/admin/apps/gemfind-ring-builder/",
				    "test" => null,
				    "charge_type" => null,
				    "decorated_return_url" => "https://".$shop."/admin/apps/gemfind-ring-builder?charge_id=" . $charge_id
				)
			);
			$activation_data = json_encode($activation_array);
			$response_activate = shopify_call($access_tk_session, $shop, "/admin/api/2020-10/application_charges/".$charge_id."/activate.json", $activation_data, 'POST');*/
			$request_headers = array(
		        "X-Shopify-Access-Token:" . $access_tk_session,
		        "Content-Type:application/json"
		    );
		    $charge_detail_endpoint = "https://".$shop."/admin/api/".$api_version."/recurring_application_charges/".$charge_id.".json";
			$charge_details = getCurlData($charge_detail_endpoint,$request_headers);
			
			$result_recurring_charge = $this->general_model->generalGetData($shop,'shop','app_charges');

			$planName = 'Gemfind Basic Plan';
			if($_GET['plantype'] == 'tryon'){
				$planName = 'Gemfind Tryon Plan';
			}

			$recurring_charges_data = array(
	                  'charge_id'  => $charge_id,
	                  'plan'  => $planName,
	                  'api_client_id'  => $charge_details->recurring_application_charge->api_client_id,
	                  'status'    => $charge_details->recurring_application_charge->status,
	                  'price' => $charge_details->recurring_application_charge->price,
	                  'shop' => $shop,
	                  'billing_on' => $charge_details->recurring_application_charge->billing_on
	              );
			if($result_recurring_charge){
				$recurring_charges_update_data = array(
	                  'charge_id'  => $charge_id,
	                  'plan'  => $planName,
	                  'api_client_id'  => $charge_details->recurring_application_charge->api_client_id,
	                  'status'    => $charge_details->recurring_application_charge->status,
	                  'price' => $charge_details->recurring_application_charge->price,
	                  'shop' => $shop,
	                  'billing_on' => $charge_details->recurring_application_charge->billing_on
	              );
				$this->general_model->generalUpdateData($recurring_charges_update_data,'shop',$shop,'app_charges');


				$shop_detail_api_url = "https://" . $shop . "/admin/shop.json";
				$resultShop = getCurlData($shop_detail_api_url,$request_headers);

				$file = "resultShop.txt";
			    file_put_contents($file, json_encode($resultShop));

				$email = $resultShop->shop->email;
				file_put_contents('customer_data.txt', $email);

				$arr = array(
	            'properties' => array(
	                array(
	                    'property' => 'email',
	                    'value' => $email
	                ),
                	array(
	                    'property' => 'ShopifyRB_Service_Fee',
	                    'value' => $recurring_charges_update_data['price']
                	),
	               array(
	                    'property' => 'app_status',
	                    'value' => 'REGISTER-RINGBUILDER'
	                )
	            ));
				$post_json = json_encode($arr);
				file_put_contents('update_data.log', $post_json);

				$email_id=$email;
				//$endpoint ='https://api.hubapi.com/contacts/v1/contact/email/'.$email_id.'/profile?hapikey=ee625d9a-7fde-44b5-b026-d5f771cfc343';

				$endpoint ='https://api.hubapi.com/contacts/v1/contact/email/'.$email_id.'/profile';
			    $headers = [
				    'Content-Type: application/json',	
				    'Authorization: Bearer ' . YOUR_ACCESS_TOKEN,
				];
		        
		        $ch1 = curl_init();
		        curl_setopt($ch1, CURLOPT_POST, true);
		        curl_setopt($ch1, CURLOPT_POSTFIELDS, $post_json);
		        curl_setopt($ch1, CURLOPT_URL, $endpoint);
		        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($ch1);
		        $status_code = curl_getinfo($ch1, CURLINFO_HTTP_CODE);
		        $curl_errors = curl_error($ch1);
		        curl_close($ch1);

		        $file = "update_status_log.txt";
		        file_put_contents($file, $status_code);

		        $file = "update_response_log.txt";
		        file_put_contents($file, $response);

			}else{
				$this->general_model->generalAddData($recurring_charges_data,'app_charges');
			}
			$redirect_to_app = "https://".$shop."/admin/apps/gemfind-ring-builder?charge_id=" . $charge_id;
			header("Location: ".$redirect_to_app);
			exit;
		}else{
			$access_token = $params['code_access'];
			$this->session->set_userdata($shop.'_access_tk', $access_token);
			unset($params['code_access']);
			unset($params['host']);
			unset($params['price']);
			$query_string = http_build_query($params); 

			if($_GET["plantype"] == 'basic'){
				$recurring_charges = array(
					"recurring_application_charge" => array(
						"name" => "GemFind Basic Plan",
						"test" => null, 
						"price" => ($_GET["price"] ? $_GET["price"] : APP_TOTAL_CHARGE),
						"return_url" => base_url()."charge?" . $query_string
					)
				);
			}else{
				$recurring_charges = array(
					"recurring_application_charge" => array(
						"name" => "GemFind Tryon Plan",
						"test" => null, 
						"price" => ($_GET["price"] ? $_GET["price"] : APP_TRYON_CHARGE),
						"return_url" => base_url()."charge?" . $query_string
					)
				);
			}
			$recurring_charge_data = json_encode($recurring_charges);
			$charge = shopify_call($access_token, $shop, "/admin/api/".$api_version."/recurring_application_charges.json", $recurring_charge_data, "POST");
			header("Location: " . $charge->recurring_application_charge->confirmation_url);
			exit;
		}
	}
}