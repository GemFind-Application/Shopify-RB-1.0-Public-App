<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	function __construct()
	{  	
		parent::__construct();
		
		$this->load->library('diamond_lib');
		$this->load->model('general_model');
		$this->load->library('ringbuilder_lib');
		$this->load->helper('cookie');
		$this->load->library('email');
		$config = array(
		    'protocol' =>PROTOCOL, 
		    'smtp_host' => SMTP_HOST, 
		    'smtp_port' => SMTP_PORT,
		    'smtp_user' => SMTP_USER,
		    'smtp_pass' => SMTP_PASSWORD,
		    'smtp_crypto' => 'tls', 
		    'mailtype' => 'html', 
		    'smtp_timeout' => '4', 
		    'charset' => 'utf-8',
		    'wordwrap' => TRUE,
		    'newline' => "\r\n"
		);
		$this->email->initialize($config);
		if($this->input->get('path_prefix')){
			header('Content-Type: application/liquid');
			
			//header('X-Frame-Options: allow-from https://alltime.fit');
			
		}
		
	}

	public function index()
	{	
		if($this->input->post('checkdiamondcookie')){
			$data['check_diamond_cookie'] = $this->input->post('checkdiamondcookie');
		}
		
		//get from query string
        $data['ring_collection'] = $this->input->get('ring_collection', true);
        $data['selected_shape'] = $this->input->get('selected_shape', true);
        $data['ring_metal'] = $this->input->get('ring_metal', true);
        $data['price_from'] = $this->input->get('price[from]', true);
        $data['price_to'] = $this->input->get('price[to]', true);
        $data['current_url'] = $this->config->item('final_shop_url');
		
		$data['is_lab_settings'] = $this->input->post('is_lab_settings');
		$this->load->view('settings/list_rings', $data);
	}
	
	public function smtp()
	{
		$toemail = $this->input->get('email'); 
		//$toemail = "lawrence.bella0005@gmail.com";
		$this->email->from('smtp@gemfind.com', 'GemFind');
		$this->email->to($toemail);
		$this->email->subject('Checking email RB Setting');
		$this->email->message('<p>It is working!!!</p>');
		if($this->email->send())
		{
		  echo "Success! - An email has been sent to ".$toemail;
		}
		else
		{ 
		  show_error($this->email->print_debugger());
		  return false;
		}
	}

	public function checkvideo(){
		$setting_video_url = '';
		$setting_video_url = $this->input->post('setting_video_url');
		$headers = is_404($setting_video_url);
		echo $headers;
		exit;
	}

	public function getStoreSmtp($shop){
         return $this->general_model->getShopSmtp($shop);
         //file_put_contents('sdata.txt', $sdata);
    }
	
	public function ringsearch()
	{	
		$data = array('filter_data'=>$this->input->post(NULL, true));
		$this->load->view('settings/results',$data);
	}
	public function loadnav()
	{	
		$data['check_diamond_cookie'] = $this->input->post('diamondsettingcookie');
		$data['final_shop_url'] = $this->input->post('finalshopurl');
		$data['is_lab_settings'] = $this->input->post('is_lab_settings');
		$this->load->view('load_nav',$data);
	}
	public function loadringproduct()
	{	
		$data['check_diamond_cookie'] = $this->input->post('diamondsettingcookie');
		$data['ring_path'] = $this->input->post('ring_path');
		$data['shop'] = $this->input->post('shop');
		$data['baseshopurl'] = $this->input->post('baseshopurl');
		$data['pathprefixshop'] = $this->input->post('pathprefixshop');
		$data['final_shop_url'] = $this->input->post('final_shop_url');
		$data['is_lab_settings'] = $this->input->post('is_lab_settings');
		$data['store_detail'] = $this->getStoreName($data['shop']);
		$ring_path = explode("-",$this->input->post('ring_path'));
		$DID = 'SID='.end($ring_path);
		if($isLabSettings == 1){
			$add_lab_para = '&IsLabSetting=1';
		}
		$shop = $this->input->post('shop');
		$DealerID = 'DealerID='.$this->ringbuilder_lib->getUsername($shop).'&';
		$query_string = $DealerID.$DID.$add_lab_para;
		$requestUrl = $this->general_model->getmountingdetailapi($shop).$query_string;
		// echo $requestUrl;
		// exit();
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
		curl_close($curl);
        $results = json_decode($responce);
		$data['showBuySettingOnly'] = $results->showBuySettingOnly;
		$this->load->view('settings/load_ring_product',$data);
	}
	public function ringurl(){
		$shop = $this->input->post('shopurl');
		$pathprefixshop = $this->input->post('path_shop_url');
		$id = $this->input->post('id');
		$route = "https://".$shop.$pathprefixshop."/settings/view/path/";
        if($id){
        $settings = $this->ringbuilder_lib->getRingById($id,$shop);
        $collectionContent = $id = $this->input->post('requesteddata');
        if(sizeof($settings['ringData']) > 0) {
            if(sizeof($settings['ringData']['configurableProduct']) > 0){
                foreach ($settings['ringData']['configurableProduct'] as $value) {
                    $value = (array) $value;
                    $metalarray[strtolower(str_replace(' ', '', $value['metalType']))] = $value['gfInventoryId'];
                }
            }
       
        if($collectionContent != ''){
            $metaltype = strtolower(str_replace(' ', '-', $collectionContent)).'-metaltype-';
            $name = strtolower(str_replace(' ', '-', $settings['ringData']['settingName']));
            $name = strtolower(str_replace('&', '%26', $name));
            $sku = '-sku-'.str_replace(' ', '-', $metalarray[strtolower(str_replace(' ', '', $collectionContent))]);
            if($metalarray[strtolower(str_replace(' ', '', $collectionContent))]){
            	
                $url = $this->ringbuilder_lib->getUrl($route, ['path' => $metaltype.$name.$sku, '_secure' => true]);
            } else {
            	
                $url = $this->ringbuilder_lib->getUrl($route, ['path' => $name.$sku, '_secure' => true]);
            }
        } else {
            $metaltype = '14k-white-gold-metaltype-';
            $name = strtolower(str_replace(' ', '-', $settings['ringData']['settingName']));
            $name = strtolower(str_replace('&', '%26', $name));
            $sku = '-sku-'.str_replace(' ', '-', $metalarray['14kwhitegold']);            
            if(isset($metalarray['14kwhitegold'])){
                $url = $this->ringbuilder_lib->getUrl($route, ['path' => $metaltype.$name.$sku, '_secure' => true]);
            } else {
                $url = $this->ringbuilder_lib->getUrl($route, ['path' => $name.$sku, '_secure' => true]);
            }
        }
        	$returnData = ['diamondviewurl' => $url];
        	echo json_encode($returnData);
        	exit;
        }  else {
        	$returnData = ['diamondviewurl' => ''];
        	echo json_encode($returnData);
        	exit;
        } } else {
        	$main_route = "https://".$shop.$pathprefixshop."/settings/";
        	$returnData = ['diamondviewurl' => $this->ringbuilder_lib->getUrl($main_route, ['_secure' => true])];
        	echo json_encode($returnData);
        	exit;
        }
		
	}
	public function view(){
		$data['ring_path'] = $this->uri->segment(5);
		
		if($this->input->post('checkdiamondcookie')){
			$data['check_diamond_cookie'] = $this->input->post('checkdiamondcookie');
		}
		$this->load->view('settings/view_rings',$data);		
	}
	public function loadringfilter()
	{	
		parse_str($this->input->post('searchringform'), $searcharray);
		$data = array(
			"shop_url" => $searcharray['shopurl'],
			"path_prefix_shop" => $searcharray['path_prefix_shop'],
			"baseurl" => $searcharray['baseurl']
		);
		
		if($this->input->post('ringbackvaluecookie')){
			$data['ring_back_cookie_data'] = $this->input->post('ringbackvaluecookie');
		}
		if($this->input->post('saveringfiltercookie')){
			$data['save_ring_filter_cookie_data'] = $this->input->post('saveringfiltercookie');
		}
		if($this->input->post('diamondsettingcookie')){
			$data['diamond_setting_cookie_data'] = $this->input->post('diamondsettingcookie');
		}
		
		//Pre filter values(query string)
        if ($this->input->post('ringcollection')) {
            $data['ringcollection'] = $this->input->post('ringcollection');
        }
        
        if ($this->input->post('selectedShape')) {
            $data['selectedShape'] = $this->input->post('selectedShape');
        }
        
        if ($this->input->post('selectedMetal')) {
            $data['selectedMetal'] = $this->input->post('selectedMetal');
        }
        
        if ($this->input->post('priceFrom')) {
            $data['priceFrom'] = $this->input->post('priceFrom');
        }
        
        if ($this->input->post('priceTo')) {
            $data['priceTo'] = $this->input->post('priceTo');
        }
		
		$this->load->view('settings/filter',$data);
	}
	public function updatefilter(){
        $data = $this->input->post(NULL,true);
        $collection = $shapes = '';
        if(isset($data['ring_collection'])){
            $collection = $data['ring_collection'];
        }
        if(isset($data['ring_shape'])){
            $shapes = $data['ring_shape'];
        }
        $DealerID = 'DealerID='.$this->ringbuilder_lib->getUsername($data['shopurl']).'&';
        if($collection && $shapes){
            $Collection = 'Collection='.$collection.'&';
            $Shape = 'Shape='.$shapes;    
        } else if($collection){
            $Collection = 'Collection='.$collection;
            $Shape = '';
        } else {
            $Shape = 'Shape='.$shapes;
            $Collection = '';
        }
        
        $query_string = $DealerID.$Collection.$Shape;
        $requestUrl = $this->general_model->getFilterApiRB($data['shopurl']).$query_string;
        $requestUrl = str_replace(' ', '%20', $requestUrl);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = (array) json_decode($responce);
        $hiddenmetaltype = $hiddencollection = $hiddenshape = array();
        
        if(sizeof($results) > 1 && $results[0]->message == 'Success'){
            foreach ($results[1] as $value) {
                $value = (array) $value;
                foreach ($value['collections'] as $collection) {
                    $collection = (array) $collection;
                    if($collection['isActive'] == 0){
                        $hiddencollection[] = '#'.strtolower(str_replace(' ', '', $collection['collectionName']));
                    }
                }
                foreach ($value['shapes'] as $shape) {
                    $shape = (array) $shape;
                    if($shape['isActive'] == 0){
                        $hiddenshape[] = '#'.strtolower(str_replace(' ', '', $shape['shapeName']));
                    }
                }
                foreach ($value['metalType'] as $metaltype) {
                    $metaltype = (array) $metaltype;
                    if($metaltype['isActive'] == 0){
                        $hiddenmetaltype[] = '#ring_metal_'.strtolower(str_replace(' ', '', $metaltype['metalType']));
                    }
                }
            }
        }
        curl_close($curl);
        $hiddenshape = implode(',', $hiddenshape);
        $hiddencollection = implode(',', $hiddencollection);
        $hiddenmetaltype = implode(',', $hiddenmetaltype);
        
        $returnData = ['hiddenshape' => $hiddenshape,'hiddencollection' => $hiddencollection,'hiddenmetaltype' => $hiddenmetaltype];
        echo json_encode($returnData);
    	exit;
	}
	public function cartaddsetting(){
 		$this->load->library('user_agent');
 		$shop_data = $this->input->get(NULL, true);
 		$setting_options = $this->input->post(NULL, true);

 		
 		$setting_id = $this->uri->segment(4);
 		if (!$setting_id) {
            redirect($this->agent->referrer().'/invalid');
        }
        try{
        	$settingData = $this->ringbuilder_lib->getRingById($setting_id,$shop_data['shop'],$setting_options['islabsettings']);
        	$access_token = $this->ringbuilder_lib->getShopAccessToken($shop_data['shop']);
        	$shop_base_url = "https://".$shop_data['shop'];
        	$get_product_endpoint = "/admin/api/2019-07/products.json";
        	$add_product_endpoint = "/admin/api/2019-07/products.json";
        	$get_locations_endpoint = "/admin/api/2019-07/locations.json";
        	$update_inventory_endpoint = "/admin/api/2019-07/inventory_levels/set.json";
        	$get_cart_endpoint = "/cart.json";
        	$getProductLocationUrl = $shop_base_url.$get_locations_endpoint;
        	$updateInvUrl = $shop_base_url.$update_inventory_endpoint;
        	$getProductRequestUrl = $shop_base_url.$get_product_endpoint;
        	$addProductRequestUrl = $shop_base_url.$add_product_endpoint;
        	$getCartRequestUrl = $shop_base_url.$get_cart_endpoint;
        	
        	$request_headers = array(
                    "X-Shopify-Access-Token:" . $access_token,
                    "Content-Type:application/json"
                );
			
			$resultProducts = getCurlData($getProductRequestUrl,$request_headers);
	        foreach ($resultProducts->products as $main_key => $main_value) {
	        	foreach ($main_value->variants as $var_key => $var_value) {
		        	if($var_value->sku == $setting_id){
		        		$in_shopify = true;
		        		$product_add = $var_value->id;
		        		$inventory_item_id = $var_value->inventory_item_id;
		        	}
	        	}
	        }
	        $resultLocation = getCurlData($getProductLocationUrl,$request_headers);
	        $location_id = $resultLocation->locations[0]->id;
	        
	        if($in_shopify){
	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");
	        	$chekcout_url = $shop_base_url."/cart/add?id=".$product_add."&quantity=1";
	        	redirect($chekcout_url);
	        	exit;
        	}else{
        		if($setting_options['sidestonequalityvalue']){
        			$option_name = $setting_options['ringsizesettingonly']." / ".$setting_options['ringmetaltype']." / ".$setting_options['sidestonequalityvalue']." / ".$setting_options['centerstonesizevalue'];
        		}else{
        			$option_name = $setting_options['ringsizesettingonly']." / ".$setting_options['ringmetaltype']." / ".$setting_options['centerstonesizevalue'];
        		}
        		$productTitle = $settingData['ringData']['settingName'];
        		$productDesc = $settingData['ringData']['description'];
        		$productVendor = "GemFind";
        		$productType = "GemFindRing";
        		$productImage = $settingData['ringData']['imageUrl'];
        		$productPrice = number_format($settingData['ringData']['cost']);
        		$optionName = $option_name;
        		$path_info = pathinfo($this->agent->referrer());
        		//echo $path_info['basename'];
        		$product_add_post_data = '{
				  "product": {
				    "title": "'.$productTitle.'",
				    "body_html": "'.$productDesc.'",
				    "vendor": "'.$productVendor.'",
				    "product_type": "'.$productType.'",
					"published_scope" : "web",
				    "tags": "GemfindRing",
				    "images": [
				       {
				        "src": "'.$productImage.'"
				      }
				    ],
                     "metafields": [
                        {
                            "namespace" : "seo",
                            "key" : "hidden",
                            "value" : 1,
                            "type" : "integer"
                        }	
                    ]				    
				  }
				}';
				// create product in shopify
	        	$resultProd = postCurlData($addProductRequestUrl,$request_headers,$product_add_post_data,"POST"); 
	        	$product_id = $resultProd->product->id;
	        	$variants_id = $resultProd->product->variants['0']->id;
	        	$inventory_item_id = $resultProd->product->variants['0']->inventory_item_id;
	        	// update SKU and stock management in created product
	        	$sku_stock_manage_endpoint = "/admin/api/2019-07/inventory_items/".$inventory_item_id.".json";
	        	$skuStockUpdateUrl = $shop_base_url.$sku_stock_manage_endpoint;
	        	$skuAndStockMangePostData = '{"inventory_item": {"id": '.$inventory_item_id.',"sku": '.$setting_id.',"tracked" : true}}';
	        	$resultSkuStockUpdate = postCurlData($skuStockUpdateUrl,$request_headers,$skuAndStockMangePostData,"PUT");
	        	//update inventory in created product
	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");
	        	//update pricing stuff in created product
	        	$update_pricing_endpoint = "/admin/api/2019-07/products/".$product_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;
	        	//$pricing_post_data = '{"product": {"id":'.$product_id.',"variants": [{"id": '.$variants_id.',"price": "'.$productPrice.'","option1":"'.$optionName.'"}]}}';
	        	$pricing_post_data = '{"product": {"id":'.$product_id.',"variants": [{"id": '.$variants_id.',"price": "'.$productPrice.'","option1":"'.$optionName.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");
	        	
	        	// product add to cart
	        	$chekcout_url = $shop_base_url."/cart/add?id=".$variants_id."&quantity=1";
	        	redirect($chekcout_url);
	        	exit;
        	}
        } catch (Exception $e) {
			redirect($this->agent->referrer().'/error');
		}
 	}
 	public function adddiamond(){
 		$setting_id = $this->uri->segment(4);
 		
 		if (!$setting_id) {
            redirect($this->agent->referrer().'/invalid');
        }
        $data =  $this->input->post(NULL, true);
        $final_shop_url = $this->config->item('final_shop_url');
        $ringinfo = array('settingid' => $setting_id, 'ringsize' => $data['ringsizewithdia'], 'shapes' => $setting_id, 'caratmax' => $data['ringmaxcarat'], 'caratmin' => $data['ringmincarat'], 'centerstonefit' => strtolower($data['centerStoneFit']) );
        $ringinfo = json_encode($ringinfo);
        $cookie= array(
           'name'   => '_shopify_ringsetting',
           'value'  => $ringinfo,
           'expire' => '86400',
           'domain' => base_url(),
		   'path'   => '/',
		   'secure' => FALSE
	       );	
       	//$this->input->set_cookie($cookie);
        /*if($this->_cookieManager->getCookie(self::DIAMOND_COOKIE_NAME)){                                                                                                                  
            $this->_redirect("/diamondtools/completering");
        } else {*/
        	echo "cookie set"; exit;
            redirect($final_shop_url."/diamondtools");
        /*}*/
 	}
	/*
	* View List Diamonds
	*/
	
	public function loadfilter()
	{	
		parse_str($this->input->post('searchformdata'), $searcharray);
		$data = array(
			"shop_url" => $searcharray['shopurl'],
			"filtermode" => $searcharray['filtermode'],
			"path_prefix_shop" => $searcharray['path_prefix_shop'],
			"default_shape_filter" => $searcharray['defaultshapevalue'],
			"baseurl" => base_url()
		);
		
		if($this->input->post('savebackvalue')){
			$data['back_cookie_data'] = $this->input->post('savebackvalue');
		}
		if($this->input->post('savedfilter')){
			$data['save_filter_cookie_data'] = $this->input->post('savedfilter');
		}
		$this->load->view('filter',$data);
	}
	
	public function compare()
	{	
		$data['shop_data'] = $this->input->get(NULL, true);
		$this->load->view('compare_diamond',$data);
	}
	public function product()
	{	
		$data['diamond_path'] = $this->uri->segment(3);
		$this->load->view('view_diamonds',$data);
	}
	public function diamondsearch()
	{	
		$data = array('filter_data'=>$this->input->post(NULL, true));
		$this->load->view('results',$data);
	}
	public function loadcompare()
	{	
		
		if($this->input->post('comparediamondProduct')){
			$data['compare_diamond_data'] = $this->input->post('comparediamondProduct');
			$data['shopurl'] = $this->input->post('shop');
			$data['pathprefixshop'] = $this->input->post('pathprefixshop');
		}
		$this->load->view('load_compare',$data);
	}
	public function diamondtype()
	{	
		$data['request_diamond_type'] = $this->uri->segment(3);
		$this->load->view('list_diamonds',$data);
	}

	public function islabsettings()
	{	
		$data['request_setting_type'] = $this->uri->segment(4);
		$this->load->view('settings/list_rings',$data);
	}

	public function loadshape()
	{	
		$post_data = $this->input->post(NULL, true);
		$fancycolorcontent = array();
        $fancycolorcontentContent = '';
        if (array_key_exists('diamond_fancycolor', $post_data)) {
            foreach ($post_data["diamond_fancycolor"] as $value) {
                $fancycolorcontent[] = strtolower($value);
            }
            $fancycolorcontentContent = implode(',', $fancycolorcontent);
        } 
        if($fancycolorcontentContent == ""){
            $fancycolorcontentContent = 'Blue,Pink,Yellow,Brown,Green,Gray,Black,Red,Purple,Chameleon,Violet';   
        }
        $color = $fancycolorcontentContent;
        echo json_encode($this->diamond_lib->getShapeByColor($color,$post_data['shopurl']));
        exit;
 	}
 	public function printdiamond(){
 		$print_post_data = $this->input->post(NULL, true);
 		$printData = array('diamond_id'=>$print_post_data['diamondid'],'shop'=>$print_post_data['shop']);
 		$this->load->view('print_diamond',$printData);
 	}
 	public function authenticate(){
 		$auth_post_data = $this->input->post(NULL, true);
 		if ($auth_post_data) {
 			$result = $this->ringbuilder_lib->authenticateDealer($auth_post_data['shopurl'],$auth_post_data['password'],$auth_post_data['settingId'],$auth_post_data['isLabSetting']);
			echo $result;
			exit;
        }
 	}
 	public function getStoreName($shop){
 		$api_version = $this->config->item('shopify_api_version');
 		$storeDetailUrlEndpoint = "https://".$shop."/admin/api/".$api_version."/shop.json";
 		$access_token = $this->diamond_lib->getShopAccessToken($shop);
 		$request_headers = array(
                    "X-Shopify-Access-Token:" . $access_token,
                    "Content-Type:application/json"
                );
 		return getCurlData($storeDetailUrlEndpoint,$request_headers);
 	}

 	 public function getSettingFormTrackingCurl($url , $data){

 		
 		$jsonData = json_encode($data); // Convert the data array to JSON format

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Send JSON data
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Set content type header
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	    $response = curl_exec($ch);
	    curl_close($ch);

	    // echo '<pre>'; print_r($response); exit;
	 
		return $response;

 	}

 	public function getFormTrackingCurl($url , $data){

 
    	$ch = curl_init($url);

		// Set the cURL options
		curl_setopt($ch, CURLOPT_POST, true); // Send POST request
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Set POST data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

		// Execute the cURL request
		$response = curl_exec($ch);

		// Check for cURL errors
		if(curl_errno($ch)) {
		    $error_message = curl_error($ch);
		    // Handle the error appropriately, e.g., logging, displaying an error message, etc.
		    curl_close($ch);
		    die("cURL Error: $error_message");
		}

		// Close cURL session
		curl_close($ch);

		 // echo '<pre>'; print_r($response); exit;

		return $response;
  
 	}
 	public function resultdrophint(){
 		$hint_post_data = $this->input->post(NULL, true);

 		if(isset($hint_post_data['captcha-response']) && !empty($hint_post_data['captcha-response'])){      
		        $data = array(
		             'secret' => $hint_post_data['secret-key'],
		            'response' => $hint_post_data['captcha-response']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		}
		 	
 		if(empty($hint_post_data['settingid'])){
 			$message = 'Please Enter Setting Id.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['shopurl'])){
 			$message = 'Please Enter Shopurl.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['name'])){
 			$message = 'Please Enter Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['email'])){
 			$message = 'Please Enter Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['recipient_name'])){
 			$message = 'Please Enter Recipient Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}


 		if(empty($hint_post_data['recipient_email'])){
 			$message = 'Please Enter Recipient Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['gift_reason'])){
 			$message = 'Please Enter Gift Reason.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['hint_message'])){
 			$message = 'Please Enter Hint Message.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['gift_deadline'])){
 			$message = 'Please Enter Gift Deadline.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		
 		$shopurl = "https://".$hint_post_data['shopurl'];
 		$store_detail = $this->getStoreName($hint_post_data['shopurl']);
 		$store_logo = $this->general_model->getStoreLogo($hint_post_data['shopurl']);
 		$store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");
 		if($hint_post_data){
 			try {
                $ringData = $this->ringbuilder_lib->getRingById($hint_post_data['settingid'], $hint_post_data['shopurl'], $hint_post_data['islabsettings']);
                $storeAdminEmail =  $this->ringbuilder_lib->getAdminEmail($hint_post_data['shopurl']);
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $ringData['ringData']['vendorEmail']);
                $retailername = ( $ringData['ringData']['vendorName'] ? $ringData['ringData']['vendorName'] : $store_detail->shop->name );
                $templateVars = array(
                    'retailername' => $retailername,
                    'retailerphone' => $ringData['ringData']['vendorPhone'],
                    'name' => $hint_post_data['name'],
                    'email' => $hint_post_data['email'],
                    'recipient_name' => $hint_post_data['recipient_name'],
                    'recipient_email' => $hint_post_data['recipient_email'],
                    'gift_reason' => $hint_post_data['gift_reason'],
                    'hint_message' => $hint_post_data['hint_message'],
                    'gift_deadline' => $hint_post_data['gift_deadline'],
                    'ring_url' => $hint_post_data['ringurl'],
                );
                // Sender email
                $transport_sender_template = $this->load->view('emails/settings/ringhint_email_template_sender.html','',true);                
                $senderValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $templateVars['name'],
					'{{email}}' => $hint_post_data['email'],
					'{{recipient_email}}' => $templateVars['recipient_email'],
					'{{recipient_name}}' => $templateVars['recipient_name'],
					'{{gift_reason}}' => $templateVars['gift_reason'],
					'{{gift_deadline}}' => $templateVars['gift_deadline'],
					'{{hint_message}}' => $templateVars['hint_message'],
					'{{ring_url}}' => $templateVars['ring_url'],
					'{{retailerphone}}' => $templateVars['retailerphone'],
					'{{retaileremail}}' => $ringData['ringData']['vendorEmail']
				);
				$sender_email_body = str_replace(array_keys($senderValueReplacement), array_values($senderValueReplacement), $transport_sender_template);	
				$sender_subject = "Someone Wants To Drop You A Hint";
				$senderFromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$senderToEmail = $templateVars['email'];

				//NEED TO GET DATA FROM DATABASE HERE
                $store_detail = $this->getStoreSmtp($hint_post_data['shopurl']);
                if($store_detail){
                    $config = array(
                        'protocol' =>  'smtp',
                        'smtp_host' => $store_detail->smtphost,
                        'smtp_port' => $store_detail->smtpport,
                        'smtp_user' => $store_detail->smtpusername,
                        'smtp_pass' => $store_detail->smtppassword,
                        'smtp_crypto' => $store_detail->protocol == "none" ? "tls" : $store_detail->protocol,
                        'mailtype' => 'html',
                        'smtp_timeout' => '4',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'newline' => "\r\n"
                    );
                    $this->email->initialize($config);
               }
               //END FOR DATABASE QUERY

				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($senderToEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();
                // Receiver email
                $transport_receiver_template = $this->load->view('emails/settings/ringhint_email_template_receiver.html','',true);                
                $receiverValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $hint_post_data['name'],
					'{{recipient_name}}' => $templateVars['recipient_name'],
					'{{gift_reason}}' => $templateVars['gift_reason'],
					'{{gift_deadline}}' => $templateVars['gift_deadline'],
					'{{hint_message}}' => $templateVars['hint_message'],
					'{{ring_url}}' => $templateVars['ring_url'],
					'{{retailerphone}}' => $templateVars['retailerphone'],
					'{{retaileremail}}' => $ringData['ringData']['vendorEmail']
				);
				$receiver_email_body = str_replace(array_keys($receiverValueReplacement), array_values($receiverValueReplacement), $transport_receiver_template);	
				$receiver_subject = "Someone Wants To Drop You A Hint";
				$receiver_fromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$receiver_toEmail = $hint_post_data['recipient_email'];
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($receiver_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($receiver_subject);
				$this->email->message($receiver_email_body);
				$this->email->send();
				// Retailer email
                $transport_retailer_template = $this->load->view('emails/settings/ringhint_email_template_retailer.html','',true);                
                $retailerValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{retailername}}' => $retailername,
					'{{name}}' => $hint_post_data['name'],
					'{{email}}' => $hint_post_data['email'],
					'{{recipient_name}}' => $hint_post_data['recipient_name'],
					'{{recipient_email}}' => $hint_post_data['recipient_email'],
					'{{gift_reason}}' => $hint_post_data['gift_reason'],
					'{{gift_deadline}}' => $hint_post_data['gift_deadline'],
					'{{hint_message}}' => $hint_post_data['hint_message'],
					'{{ring_url}}' => $templateVars['ring_url'],
					'{{recipient_email}}' => $hint_post_data['recipient_email'],
				);
				$retailer_email_body = str_replace(array_keys($retailerValueReplacement), array_values($retailerValueReplacement), $transport_retailer_template);	
				$retailer_subject = "Someone Wants To Drop You A Hint";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$retailer_toEmail = $retaileremail;
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();
				$this->email->send();


				// Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($hint_post_data['shopurl']);

				$postUrl = 'http://api.jewelcloud.com/api/RingBuilder/DropAHint';

				
				$formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $hint_post_data['name'] ? $hint_post_data['name'] : '',
                    'EmailID' => $hint_post_data['email'] ? $hint_post_data['email'] : '',
                    'RecipientName' => $hint_post_data['recipient_name'] ? $hint_post_data['recipient_name'] : '',
                    'RecipientEmailID' => $hint_post_data['recipient_email'] ? $hint_post_data['recipient_email'] : '',
                    'Reason' => $hint_post_data['gift_reason'] ? $hint_post_data['gift_reason'] : '',
                    'Message' => $hint_post_data['hint_message'] ? $hint_post_data['hint_message'] : '',
                    'DeadlineDate' => $hint_post_data['gift_deadline'] ? $hint_post_data['gift_deadline'] : '',
                    'SID' =>  $hint_post_data['settingid'] ? $hint_post_data['settingid'] : '',
                    'DID' => '',
                    'Shape' => $ringData['ringData']['shape'] ? $ringData['ringData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $ringData['ringData']['cost'] ? $ringData['ringData']['cost'] : '',
                );


             	$this->getSettingFormTrackingCurl($postUrl,$formdata);
            
                // Ending of Form Tracking 

                $message = 'Thanks for your submission.';
				$data = array('status' => 1, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
				$message = $e->getMessage();
			}
			$data = array('status' => 0, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
 		}
 		$message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message );
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
 	}
 	public function resultemailfriend(){
 		$email_friend_post_data = $this->input->post(NULL, true);

 		if(isset($email_friend_post_data['captcha-response-two']) && !empty($email_friend_post_data['captcha-response-two'])){      
		        $data = array(
		            'secret' => $email_friend_post_data['secret-key'],
		            'response' => $email_friend_post_data['captcha-response-two']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		    }
		    
 		if(empty($email_friend_post_data['settingid'])){
 			$message = 'Please Enter Setting Id.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['shopurl'])){
 			$message = 'Please Enter Shopurl.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['name'])){
 			$message = 'Please Enter Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['email'])){
 			$message = 'Please Enter Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['friend_name'])){
 			$message = 'Please Enter Friend Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['friend_email'])){
 			$message = 'Please Enter Friend Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['message'])){
 			$message = 'Please Enter Message.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}


 		$shopurl = "https://".$email_friend_post_data['shopurl'];
		$store_detail = $this->getStoreName($email_friend_post_data['shopurl']);
 		$store_logo = $this->general_model->getStoreLogo($email_friend_post_data['shopurl']);
 		$store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");
 		if($email_friend_post_data){
 			try {
                $ringData = $this->ringbuilder_lib->getRingById($email_friend_post_data['settingid'], $email_friend_post_data['shopurl'], $email_friend_post_data['islabsettings']);

                $storeAdminEmail =  $this->ringbuilder_lib->getAdminEmail($email_friend_post_data['shopurl']);
                $vendorEmail = ( $storeAdminEmail ? $storeAdminEmail : $ringData['ringData']['vendorEmail']);
                $vendorName = ( $ringData['ringData']['vendorName'] ? $ringData['ringData']['vendorName'] : $store_detail->shop->name );
                
                
                $templateVars = array(
                    'name' => $email_friend_post_data['name'],
                    'email' => $email_friend_post_data['email'],
                    'friend_name' => $email_friend_post_data['friend_name'],
                    'friend_email' => $email_friend_post_data['friend_email'],
                    'message' => $email_friend_post_data['message'],
                    'ring_url' => (isset($email_friend_post_data['ringurl'])) ? $email_friend_post_data['ringurl'] : '',
                    'setting_id' => (isset($ringData['ringData']['settingId'])) ? $ringData['ringData']['settingId']: '',
                    'stylenumber' => (isset($ringData['ringData']['styleNumber'])) ? $ringData['ringData']['styleNumber'] : '',
                    'metaltype' => (isset($ringData['ringData']['metalType'])) ? $ringData['ringData']['metalType'] : '',
                    'centerStoneMinCarat' => (isset($ringData['ringData']['centerStoneMinCarat'])) ? $ringData['ringData']['centerStoneMinCarat'] : '',
                    'centerStoneMaxCarat' => (isset($ringData['ringData']['centerStoneMaxCarat'])) ? $ringData['ringData']['centerStoneMaxCarat'] : '',
                    'price' => (isset($ringData['ringData']['cost'])) ? $ringData['ringData']['currencySymbol'].' '.number_format($ringData['ringData']['cost']) : '',
                    'retailerName' => (isset($ringData['ringData']['retailerInfo']->retailerName)) ? $ringData['ringData']['retailerInfo']->retailerName : '',
                    'retailerID' => (isset($ringData['ringData']['retailerInfo']->retailerID)) ? $ringData['ringData']['retailerInfo']->retailerID : '',
                    'retailerEmail' => (isset($ringData['ringData']['retailerInfo']->retailerEmail)) ? $ringData['ringData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo' => (isset($ringData['ringData']['retailerInfo']->retailerContactNo)) ? $ringData['ringData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax' => (isset($ringData['ringData']['retailerInfo']->retailerFax)) ? $ringData['ringData']['retailerInfo']->retailerFax : '',
                    'retailerAddress' => (isset($ringData['ringData']['retailerInfo']->retailerAddress)) ? $ringData['ringData']['retailerInfo']->retailerAddress : '',
                );
                $templateValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $templateVars['name'],
					'{{email}}' => $templateVars['email'],
					'{{friend_name}}' => $templateVars['friend_name'],
					'{{recipient_email}}' => $templateVars['friend_email'],
					'{{message}}' => $templateVars['message'],
					'{{setting_id}}' => $templateVars['setting_id'],
					'{{ring_url}}' => $templateVars['ring_url'],
					'{{stylenumber}}' => $templateVars['stylenumber'],
					'{{metaltype}}' => $templateVars['metaltype'],
					'{{centerStoneMinCarat}}' => $templateVars['centerStoneMinCarat'],
					'{{centerStoneMaxCarat}}' => $templateVars['centerStoneMaxCarat'],
					'{{price}}' => $templateVars['price'],
					'{{retailerName}}' => $templateVars['retailerName'],
					'{{retailerEmail}}' => $ringData['ringData']['vendorEmail'],
					'{{retailerphone}}' => $templateVars['retailerContactNo'],
					'{{retailerFax}}' => $templateVars['retailerFax'],
					'{{retailerAddress}}' => $templateVars['retailerAddress'],
					'{{vendorName}}' => $vendorName,
					'{{vendorEmail}}' => $ringData['ringData']['vendorEmail'],
					'{{vendorPhone}}' => $ringData['ringData']['vendorPhone'],
				);
                // Sender email
                $transport_sender_template = $this->load->view('emails/settings/ringemail_friend_email_template_sender.html','',true);                
				$sender_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_sender_template);	
				$sender_subject = "A Friend Wants To Share With You";
				$senderFromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$senderToEmail = $email_friend_post_data['email'];

				//NEED TO GET DATA FROM DATABASE HERE
                $store_detail = $this->getStoreSmtp($email_friend_post_data['shopurl']);
                if($store_detail){
                    $config = array(
                        'protocol' =>  'smtp',
                        'smtp_host' => $store_detail->smtphost,
                        'smtp_port' => $store_detail->smtpport,
                        'smtp_user' => $store_detail->smtpusername,
                        'smtp_pass' => $store_detail->smtppassword,
                        'smtp_crypto' => $store_detail->protocol == "none" ? "tls" : $store_detail->protocol,
                        'mailtype' => 'html',
                        'smtp_timeout' => '4',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'newline' => "\r\n"
                    );
                    $this->email->initialize($config);
               }
               //END FOR DATABASE QUERY

				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($senderToEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();
                // Receiver email
                $transport_receiver_template = $this->load->view('emails/settings/ringemail_friend_email_template_receiver.html','',true);                
				$receiver_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_receiver_template);	
				$receiver_subject = "A Friend Wants To Share With You";
				$receiver_fromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$receiver_toEmail = $email_friend_post_data['friend_email'];
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($receiver_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($receiver_subject);
				$this->email->message($receiver_email_body);
				$this->email->send();
				// Retailer email
                $transport_retailer_template = $this->load->view('emails/settings/ringemail_friend_email_template_retailer.html','',true);                
				$retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);	
				$retailer_subject = "A Friend Wants To Share With You";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$retailer_toEmail = $vendorEmail;
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();
				// Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($email_friend_post_data['shopurl']);

				$postUrl = 'https://api.jewelcloud.com/api/RingBuilder/EmailAFriend';
				
				$formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $email_friend_post_data['name'] ? $email_friend_post_data['name'] : '',
                    'EmailID' => $email_friend_post_data['email'] ? $email_friend_post_data['email'] : '',
                    'FriendsName' => $email_friend_post_data['friend_name'] ? $email_friend_post_data['friend_name'] : '',
                    'FriendsEmailID' => $email_friend_post_data['friend_email'] ? $email_friend_post_data['friend_email'] : '',
                    'Message' => $email_friend_post_data['message'] ? $email_friend_post_data['message'] : '',
                    'SID' =>  $email_friend_post_data['settingid'] ? $email_friend_post_data['settingid'] : '',
                    'DID' => '',
                    'Shape' => $ringData['ringData']['shape'] ? $ringData['ringData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $ringData['ringData']['cost'] ? $ringData['ringData']['cost'] : '',
                );

				
                $this->getSettingFormTrackingCurl($postUrl,$formdata);
               
                // Ending of Form Tracking

                $message = 'Thanks for your submission.';
				$data = array('status' => 1, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
				$message = $e->getMessage();
			}
			$data = array('status' => 0, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
 		}
 		$message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message );
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
 	}
 	public function resultscheview(){
 		$sch_view_post_data = $this->input->post(NULL, true);

 		 if(isset($sch_view_post_data['captcha-response-three']) && !empty($sch_view_post_data['captcha-response-three'])){      
		        $data = array(
		             'secret' => $sch_view_post_data['secret-key'],
		            'response' => $sch_view_post_data['captcha-response-three']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		    }

 		if(empty($sch_view_post_data['settingid'])){
 			$message = 'Please Enter Setting Id.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['shopurl'])){
 			$message = 'Please Enter Shopurl.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['name'])){
 			$message = 'Please Enter Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['email'])){
 			$message = 'Please Enter Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['phone'])){
 			$message = 'Please Enter Phone.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['hint_message'])){
 			$message = 'Please Enter Hint Message.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['location'])){
 			$message = 'Please Enter Location.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['avail_date'])){
 			$message = 'Please Enter Avail Date.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($sch_view_post_data['appnt_time'])){
 			$message = 'Please Enter Appnt Time.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		$shopurl = "https://".$sch_view_post_data['shopurl'];
		$store_detail = $this->getStoreName($sch_view_post_data['shopurl']);
 		$store_logo = $this->general_model->getStoreLogo($sch_view_post_data['shopurl']);
 		$store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");
 		if($sch_view_post_data){
 			try {
                $ringData = $this->ringbuilder_lib->getRingById($sch_view_post_data['settingid'], $sch_view_post_data['shopurl'], $sch_view_post_data['islabsettings']);

                $storeAdminEmail =  $this->ringbuilder_lib->getAdminEmail($sch_view_post_data['shopurl']);
                $vendorEmail = ( $storeAdminEmail ? $storeAdminEmail : $ringData['ringData']['vendorEmail']);
                $vendorName = ( $ringData['ringData']['vendorName'] ? $ringData['ringData']['vendorName'] : $store_detail->shop->name );
                
                
                $templateVars = array(
                    'name' => $sch_view_post_data['name'],
                    'email' => $sch_view_post_data['email'],
                    'phone' => $sch_view_post_data['phone'],                   
                    'hint_message' => $sch_view_post_data['hint_message'],
                    'location' => $sch_view_post_data['location'],
                    'avail_date' => $sch_view_post_data['avail_date'],
                    'appnt_time' => $sch_view_post_data['appnt_time'],
                    'ring_url' => (isset($sch_view_post_data['ringurl'])) ? $sch_view_post_data['ringurl'] : '',
                    'setting_id' => (isset($ringData['ringData']['settingId'])) ? $ringData['ringData']['settingId']: '',
                    'stylenumber' => (isset($ringData['ringData']['styleNumber'])) ? $ringData['ringData']['styleNumber'] : '',
                    'metaltype' => (isset($ringData['ringData']['metalType'])) ? $ringData['ringData']['metalType'] : '',
                    'centerStoneMinCarat' => (isset($ringData['ringData']['centerStoneMinCarat'])) ? $ringData['ringData']['centerStoneMinCarat'] : '',
                    'centerStoneMaxCarat' => (isset($ringData['ringData']['centerStoneMaxCarat'])) ? $ringData['ringData']['centerStoneMaxCarat'] : '',
                    'price' => (isset($ringData['ringData']['cost'])) ? $ringData['ringData']['currencySymbol'].' '.number_format($ringData['ringData']['cost']) : '',
                    'retailerName' => (isset($ringData['ringData']['retailerInfo']->retailerName)) ? $ringData['ringData']['retailerInfo']->retailerName : '',
                    'retailerID' => (isset($ringData['ringData']['retailerInfo']->retailerID)) ? $ringData['ringData']['retailerInfo']->retailerID : '',
                    'retailerEmail' => (isset($ringData['ringData']['retailerInfo']->retailerEmail)) ? $ringData['ringData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo' => (isset($ringData['ringData']['retailerInfo']->retailerContactNo)) ? $ringData['ringData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax' => (isset($ringData['ringData']['retailerInfo']->retailerFax)) ? $ringData['ringData']['retailerInfo']->retailerFax : '',
                    'retailerAddress' => (isset($ringData['ringData']['retailerInfo']->retailerAddress)) ? $ringData['ringData']['retailerInfo']->retailerAddress : '',
                );
                $templateValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $templateVars['name'],
					'{{email}}' => $templateVars['email'],
					'{{phone}}' => $templateVars['phone'],
					'{{hint_message}}' => $templateVars['hint_message'],
					'{{location}}' => $templateVars['location'],
					'{{appnt_time}}' => $templateVars['appnt_time'],
					'{{avail_date}}' => $templateVars['avail_date'],
					'{{ring_url}}' => $templateVars['ring_url'],
					'{{setting_id}}' => $templateVars['setting_id'],
					'{{stylenumber}}' => $templateVars['stylenumber'],
					'{{metaltype}}' => $templateVars['metaltype'],
					'{{centerStoneMinCarat}}' => $templateVars['centerStoneMinCarat'],
					'{{centerStoneMaxCarat}}' => $templateVars['centerStoneMaxCarat'],
					'{{price}}' => $templateVars['price'],
					'{{retailerName}}' => $templateVars['retailerName'],
					'{{retailerEmail}}' => $templateVars['retailerEmail'],
					'{{retailerContactNo}}' => $templateVars['retailerContactNo'],
					'{{retailerFax}}' => $templateVars['retailerFax'],
					'{{retailerAddress}}' => $templateVars['retailerAddress'],
					'{{vendorName}}' => $vendorName,
					'{{vendorEmail}}' => $ringData['ringData']['vendorEmail'],
					'{{vendorPhone}}' => $ringData['ringData']['vendorPhone'],
				);
				// Retailer email
				if($this->input->post('completering')){
					$transport_retailer_template = $this->load->view('emails/complete_ring/ringschedule_view_email_template_retailer.html','',true);  
				}
				else{
					$transport_retailer_template = $this->load->view('emails/settings/ringschedule_view_email_template_retailer.html','',true);  
				}
				$retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);	
				$retailer_subject = "Request To Schedule A Viewing";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($sch_view_post_data['shopurl']); 
				$retailer_toEmail = $vendorEmail;

				 //NEED TO GET DATA FROM DATABASE HERE
                $store_detail = $this->getStoreSmtp($sch_view_post_data['shopurl']);
                if($store_detail){
                    $config = array(
                        'protocol' =>  'smtp',
                        'smtp_host' => $store_detail->smtphost,
                        'smtp_port' => $store_detail->smtpport,
                        'smtp_user' => $store_detail->smtpusername,
                        'smtp_pass' => $store_detail->smtppassword,
                        'smtp_crypto' => $store_detail->protocol == "none" ? "tls" : $store_detail->protocol,
                        'mailtype' => 'html',
                        'smtp_timeout' => '4',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'newline' => "\r\n"
                    );
                    $this->email->initialize($config);
               }
               //END FOR DATABASE QUERY
               
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();
				
				// Sender email
				if($this->input->post('completering')){
					$transport_sender_template = $this->load->view('emails/complete_ring/ringschedule_email_template_sender.html','',true); 
				}
				else
				{
					$transport_sender_template = $this->load->view('emails/settings/ringschedule_email_template_sender.html','',true);  
				}
				$sender_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_sender_template);	
				$sender_subject = "Request To Schedule A Viewing";
				$sender_fromAddress = $this->diamond_lib->getEmailSender($sch_view_post_data['shopurl']); 
				$sender_toEmail = $sch_view_post_data['email'];
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($sender_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();


				// Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($sch_view_post_data['shopurl']);


				$postUrl = 'https://api.jewelcloud.com/api/RingBuilder/ScheduleAppointment';
				
				$formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $sch_view_post_data['name'] ? $sch_view_post_data['name'] : '',
                    'EmailID' => $sch_view_post_data['email'] ? $sch_view_post_data['email'] : '',
                    'Date' => $sch_view_post_data['avail_date'] ? $sch_view_post_data['avail_date'] : '',
                    'Time' => $sch_view_post_data['appnt_time'] ? $sch_view_post_data['appnt_time'] : '',
                    'Phone' => $sch_view_post_data['phone'] ? $sch_view_post_data['phone'] : '',
                    'Message' => $sch_view_post_data['hint_message'] ? $sch_view_post_data['hint_message'] : '',
                    'SID' =>  $sch_view_post_data['settingid'] ? $sch_view_post_data['settingid'] : '',
                    'DID' => $sch_view_post_data['diamondId'] ? $sch_view_post_data['diamondId'] : '',
                    'Shape' => $ringData['ringData']['shape'] ? $ringData['ringData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $ringData['ringData']['cost'] ? $ringData['ringData']['cost'] : '',
                );

				
                $this->getSettingFormTrackingCurl($postUrl,$formdata);
               
                // Ending of Form Tracking
				
                $message = 'Thanks for your submission.';
				$data = array('status' => 1, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
				$message = $e->getMessage();
			}
			$data = array('status' => 0, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
 		}
 		$message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message );
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
 	}
 	public function resultreqinfo(){
 		$req_post_data = $this->input->post(NULL, true);

		if(isset($req_post_data['captcha-response-one']) && !empty($req_post_data['captcha-response-one'])){      
		        $data = array(
		             'secret' => $req_post_data['secret-key'],
		            'response' => $req_post_data['captcha-response-one']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		    }

		if(empty($req_post_data['settingid'])){
 			$message = 'Please Enter SettingId.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($req_post_data['shopurl'])){
 			$message = 'Please Enter Shopurl.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($req_post_data['name'])){
 			$message = 'Please Enter Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($req_post_data['email'])){
 			$message = 'Please Enter Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}


 		if(empty($req_post_data['phone'])){
 			$message = 'Please Enter Phone.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($req_post_data['hint_message'])){
 			$message = 'Please Enter Hint Message.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($req_post_data['contact_pref'])){
 			$message = 'Please Enter Contact Pref.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		$shopurl = "https://".$req_post_data['shopurl'];
		$store_detail = $this->getStoreName($req_post_data['shopurl']);

 		$store_logo = $this->general_model->getStoreLogo($req_post_data['shopurl']);

 		$store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");

 		if($req_post_data){
 			try {
                $ringData = $this->ringbuilder_lib->getRingById($req_post_data['settingid'], $req_post_data['shopurl'], $req_post_data['islabsettings']);
                
                $storeAdminEmail =  $this->ringbuilder_lib->getAdminEmail($req_post_data['shopurl']);
                $vendorEmail = ( $storeAdminEmail ? $storeAdminEmail : $ringData['ringData']['vendorEmail']);
                $vendorName = ( $ringData['ringData']['vendorName'] ? $ringData['ringData']['vendorName'] : $store_detail->shop->name );
                

                $templateVars = array(
                    'name' => (isset($req_post_data['name'])) ? $req_post_data['name'] : '',
                    'email' => (isset($req_post_data['email'])) ? $req_post_data['email'] : '',
                    'phone' => (isset($req_post_data['phone'])) ? $req_post_data['phone'] : '',                   
                    'hint_message' => (isset($req_post_data['hint_message'])) ? $req_post_data['hint_message'] : '',
                    'contact_pref' => (isset($req_post_data['contact_pref'])) ? $req_post_data['contact_pref'] : '',
                    'ring_url' => (isset($req_post_data['ringurl'])) ? $req_post_data['ringurl'] : '',
                    'price' => (isset($ringData['ringData']['cost'])) ? $ringData['ringData']['currencySymbol'].' '.number_format($ringData['ringData']['cost']) : '',
                    'setting_id' => (isset($ringData['ringData']['settingId'])) ? $ringData['ringData']['settingId'] : '',
                    'stylenumber' => (isset($ringData['ringData']['styleNumber'])) ? $ringData['ringData']['styleNumber'] : '',
                    'metaltype' => (isset($ringData['ringData']['metalType'])) ? $ringData['ringData']['metalType'] : '',
                    'centerStoneMinCarat' => (isset($ringData['ringData']['centerStoneMinCarat'])) ? $ringData['ringData']['centerStoneMinCarat'] : '',
                    'centerStoneMaxCarat' => (isset($ringData['ringData']['centerStoneMaxCarat'])) ? $ringData['ringData']['centerStoneMaxCarat'] : '',
                    'retailerName' => (isset($ringData['ringData']['retailerInfo']->retailerName)) ? $ringData['ringData']['retailerInfo']->retailerName : '',
                    'retailerID' => (isset($ringData['ringData']['retailerInfo']->retailerID)) ? $ringData['ringData']['retailerInfo']->retailerID : '',
                    'retailerEmail' => (isset($ringData['ringData']['retailerInfo']->retailerEmail)) ? $ringData['ringData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo' => (isset($ringData['ringData']['retailerInfo']->retailerContactNo)) ? $ringData['ringData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax' => (isset($ringData['ringData']['retailerInfo']->retailerFax)) ? $ringData['ringData']['retailerInfo']->retailerFax : '',
                    'retailerAddress' => (isset($ringData['ringData']['retailerInfo']->retailerAddress)) ? $ringData['ringData']['retailerInfo']->retailerAddress : '',
                );
                $templateValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => 'Gemfind Diamond Link',
					'{{name}}' => $templateVars['name'],
					'{{email}}' => $templateVars['email'],
					'{{phone}}' => $templateVars['phone'],
					'{{hint_message}}' => $templateVars['hint_message'],
					'{{contact_pref}}' => $templateVars['contact_pref'],
					'{{ring_url}}' => $templateVars['ring_url'],
					'{{setting_id}}' => $templateVars['setting_id'],
					'{{stylenumber}}' => $templateVars['stylenumber'],
					'{{metaltype}}' => $templateVars['metaltype'],
					'{{centerStoneMinCarat}}' => $templateVars['centerStoneMinCarat'],
					'{{centerStoneMaxCarat}}' => $templateVars['centerStoneMaxCarat'],
					'{{price}}' => $templateVars['price'],
					'{{retailerName}}' => $templateVars['retailerName'],
					'{{retailerEmail}}' => $templateVars['retailerEmail'],
					'{{retailerContactNo}}' => $templateVars['retailerContactNo'],
					'{{retailerFax}}' => $templateVars['retailerFax'],
					'{{retailerAddress}}' => $templateVars['retailerAddress'],
					'{{vendorName}}' => $vendorName,
					'{{vendorEmail}}' => $ringData['ringData']['vendorEmail'],
					'{{vendorPhone}}' => $ringData['ringData']['vendorPhone'],
				);
				// Retailer email
				if($this->input->post('completering')){
					$transport_retailer_template = $this->load->view('emails/complete_ring/ringinfo_email_template_retailer.html','',true);    
				}
				else
				{
					$transport_retailer_template = $this->load->view('emails/settings/ringinfo_email_template_retailer.html','',true);
				}
				$retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);	
				$retailer_subject = "Request For More Info";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($req_post_data['shopurl']); 
				$retailer_toEmail = $vendorEmail;

				//NEED TO GET DATA FROM DATABASE HERE
                $store_detail = $this->getStoreSmtp($req_post_data['shopurl']);
                file_put_contents('mail_log.txt', $store_detail);
                if($store_detail){
                    $config = array(
                        'protocol' =>  'smtp',
                        'smtp_host' => $store_detail->smtphost,
                        'smtp_port' => $store_detail->smtpport,
                        'smtp_user' => $store_detail->smtpusername,
                        'smtp_pass' => $store_detail->smtppassword,
                        'smtp_crypto' => $store_detail->protocol == "none" ? "tls" : $store_detail->protocol,
                        'mailtype' => 'html',
                        'smtp_timeout' => '4',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'newline' => "\r\n"
                    );
                    $this->email->initialize($config);
               }
               //END FOR DATABASE QUERY

				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();
				// Sender email
				if($this->input->post('completering')){
					$transport_sender_template = $this->load->view('emails/complete_ring/ringinfo_email_template_sender.html','',true);   
				}
				else
				{
					$transport_sender_template = $this->load->view('emails/settings/ringinfo_email_template_sender.html','',true);   
				}
				$sender_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_sender_template);	
				$sender_subject = "Request For More Info";
				$sender_fromAddress = $this->diamond_lib->getEmailSender($req_post_data['shopurl']); 
				$sender_toEmail = $req_post_data['email'];


				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($sender_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();

				// Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($req_post_data['shopurl']);

				$postUrl = 'https://api.jewelcloud.com/api/RingBuilder/RequestMoreInfo';				

                $formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $req_post_data['name'] ? $req_post_data['name'] : '',
                    'EmailID' => $req_post_data['email'] ? $req_post_data['email'] : '',
                    'Phone' => $req_post_data['phone'] ? $req_post_data['phone'] : '',
                    'Message' => $req_post_data['hint_message'] ? $req_post_data['hint_message'] : '',                   
                    'Preference' => 'Email',
                    'SID' =>  '326102873',                  
                );

                $this->getSettingFormTrackingCurl($postUrl,$formdata);
               
                // Ending of Form Tracking

                $message = 'Thanks for your submission.';
				$data = array('status' => 1, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
				$message = $e->getMessage();
			}
			$data = array('status' => 0, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
 		}
 		$message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message );
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
 	}

 	public function resultreqinfo_cr() {

        $req_post_data = $this->input->post(NULL, true);

        if(isset($req_post_data['captcha-response-nine']) && !empty($req_post_data['captcha-response-nine'])){      
		        $data = array(
		           'secret' => $req_post_data['secret-key'],
		            'response' => $req_post_data['captcha-response-nine']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		    }

        if(empty($req_post_data['settingid'])){
                $message = 'Please Enter SettingId.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
        }

        if(empty($req_post_data['diamondId'])){
            $message = 'Please Enter DiamondId.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }

        if(empty($req_post_data['shopurl'])){
            $message = 'Please Enter Shopurl.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }

        if(empty($req_post_data['completering'])){
            $message = 'Please Enter Completering.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }

        if(empty($req_post_data['name'])){
            $message = 'Please Enter Name.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }

        if(empty($req_post_data['email'])){
            $message = 'Please Enter Email.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }

        if(empty($req_post_data['phone'])){
            $message = 'Please Enter Phone.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }

        if(empty($req_post_data['hint_message'])){
            $message = 'Please Enter Hint Message.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }

        if(empty($req_post_data['contact_pref'])){
            $message = 'Please Enter Contact Pref.';
            $data = array('status' => 2, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }
        

        $shopurl = "https://" . $req_post_data['shopurl'];
        $store_detail = $this->getStoreName($req_post_data['shopurl']);
        $store_logo = $this->general_model->getStoreLogo($req_post_data['shopurl']);


        $store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");


        $jc_options = $this->diamond_lib->getJCOptions($req_post_data['shopurl']);
        if ($req_post_data) {
            try {
                $ringData = $this->ringbuilder_lib->getRingById($req_post_data['settingid'], $req_post_data['shopurl'], $req_post_data['islabsettings']);
                $diamondData = $this->diamond_lib->getDiamondById($req_post_data['diamondId'], $req_post_data['diamondtype'], $req_post_data['shopurl']);

                $storeAdminEmail = $this->diamond_lib->getAdminEmail($req_post_data['shopurl']);
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);
                if ($diamondData['diamondData']['fancyColorMainBody']) {
                    $color_to_display = $diamondData['diamondData']['fancyColorIntensity'] . ' ' . $diamondData['diamondData']['fancyColorMainBody'];
                } elseif ($diamondData['diamondData']['color'] != '') {
                    $color_to_display = $diamondData['diamondData']['color'];
                } else {
                    $color_to_display = 'NA';
                }
                $templateVars = array(
                    'name' => (isset($req_post_data['name'])) ? $req_post_data['name'] : '',
                    'email' => (isset($req_post_data['email'])) ? $req_post_data['email'] : '',
                    'phone' => (isset($req_post_data['phone'])) ? $req_post_data['phone'] : '',
                    'hint_message' => (isset($req_post_data['hint_message'])) ? $req_post_data['hint_message'] : '',
                    'contact_pref' => (isset($req_post_data['contact_pref'])) ? $req_post_data['contact_pref'] : '',
                    'diamond_url' => (isset($req_post_data['diamondurl'])) ? $req_post_data['diamondurl'] : '',
                    'diamond_id' => (isset($diamondData['diamondData']['diamondId'])) ? $diamondData['diamondData']['diamondId'] : '',
                    'size' => (isset($diamondData['diamondData']['caratWeight'])) ? $diamondData['diamondData']['caratWeight'] : '',
                    'cut' => (isset($diamondData['diamondData']['cut'])) ? $diamondData['diamondData']['cut'] : '',
                    'color' => $color_to_display,
                    'clarity' => (isset($diamondData['diamondData']['clarity'])) ? $diamondData['diamondData']['clarity'] : '',
                    'depth' => (isset($diamondData['diamondData']['depth'])) ? $diamondData['diamondData']['depth'] : '',
                    'table' => (isset($diamondData['diamondData']['table'])) ? $diamondData['diamondData']['table'] : '',
                    'measurment' => (isset($diamondData['diamondData']['measurement'])) ? $diamondData['diamondData']['measurement'] : '',
                    'certificate' => (isset($diamondData['diamondData']['certificate'])) ? $diamondData['diamondData']['certificate'] : '',
                    'certificateNo' => (isset($diamondData['diamondData']['certificateNo'])) ? $diamondData['diamondData']['certificateNo'] : '',
                    'certificateUrl' => (isset($diamondData['diamondData']['certificateUrl'])) ? $diamondData['diamondData']['certificateUrl'] : '',
                    'price' => (isset($diamondData['diamondData']['fltPrice'])) ? number_format($diamondData['diamondData']['fltPrice']) : '',
                    'vendorID' => (isset($diamondData['diamondData']['vendorID'])) ? $diamondData['diamondData']['vendorID'] : '',
                    'vendorName' => (isset($diamondData['diamondData']['vendorName'])) ? $diamondData['diamondData']['vendorName'] : '',
                    'vendorEmail' => (isset($diamondData['diamondData']['vendorEmail'])) ? $diamondData['diamondData']['vendorEmail'] : '',
                    'vendorContactNo' => (isset($diamondData['diamondData']['vendorContactNo'])) ? $diamondData['diamondData']['vendorContactNo'] : '',
                    'vendorStockNo' => (isset($diamondData['diamondData']['vendorStockNo'])) ? $diamondData['diamondData']['vendorStockNo'] : '',
                    'vendorFax' => (isset($diamondData['diamondData']['vendorFax'])) ? $diamondData['diamondData']['vendorFax'] : '',
                    'vendorAddress' => (isset($diamondData['diamondData']['vendorAddress'])) ? $diamondData['diamondData']['vendorAddress'] : '',
                    'wholeSalePrice' => (isset($diamondData['diamondData']['wholeSalePrice'])) ? number_format($diamondData['diamondData']['wholeSalePrice']) : '',
                    'vendorAddress' => (isset($diamondData['diamondData']['vendorAddress'])) ? $diamondData['diamondData']['vendorAddress'] : '',
                    'retailerName' => (isset($diamondData['diamondData']['retailerInfo']->retailerName)) ? $diamondData['diamondData']['retailerInfo']->retailerName : '',
                    'retailerID' => (isset($diamondData['diamondData']['retailerInfo']->retailerID)) ? $diamondData['diamondData']['retailerInfo']->retailerID : '',
                    'retailerEmail' => (isset($diamondData['diamondData']['retailerInfo']->retailerEmail)) ? $diamondData['diamondData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo' => (isset($diamondData['diamondData']['retailerInfo']->retailerContactNo)) ? $diamondData['diamondData']['retailerInfo']->retailerContactNo : '',
                    'retailerStockNo' => (isset($diamondData['diamondData']['retailerInfo']->retailerStockNo)) ? $diamondData['diamondData']['retailerInfo']->retailerStockNo : '',
                    'retailerFax' => (isset($diamondData['diamondData']['retailerInfo']->retailerFax)) ? $diamondData['diamondData']['retailerInfo']->retailerFax : '',
                    'retailerAddress' => (isset($diamondData['diamondData']['retailerInfo']->retailerAddress)) ? $diamondData['diamondData']['retailerInfo']->retailerAddress : '',
                    'ring_url'            => ( isset( $req_post_data['diamondurl'] ) ) ? $req_post_data['diamondurl'] : '',
                    'price_rb'               => ( isset( $ringData['ringData']['cost'] ) ) ? $ringData['ringData']['currencySymbol'] . ' ' . number_format( $ringData['ringData']['cost'] ) : '',
                    'setting_id'          => ( isset( $ringData['ringData']['settingId'] ) ) ? $ringData['ringData']['settingId'] : '',
                    'stylenumber'         => ( isset( $ringData['ringData']['styleNumber'] ) ) ? $ringData['ringData']['styleNumber'] : '',
                    'metaltype'           => ( isset( $ringData['ringData']['metalType'] ) ) ? $ringData['ringData']['metalType'] : '',
                    'centerStoneSize'     => ( isset( $ringData['ringData']['configurableProduct'][0]->centerStoneSize ) ) ? $ringData['ringData']['configurableProduct'][0]->centerStoneSize : '',
                    'ringSize'            => $ringSize,
                    'sideStoneQualityhtm' => $sideStoneQualityhtm,
                    'centerStoneMinCarat' => ( isset( $ringData['ringData']['centerStoneMinCarat'] ) ) ? $ringData['ringData']['centerStoneMinCarat'] : '',
                    'centerStoneMaxCarat' => ( isset( $ringData['ringData']['centerStoneMaxCarat'] ) ) ? $ringData['ringData']['centerStoneMaxCarat'] : '',
                    'retailerName'        => ( isset( $ringData['ringData']['vendorName'] ) ) ? $ringData['ringData']['vendorName'] : '',
                    'retailerID'          => ( isset( $ringData['ringData']['retailerInfo']->retailerID ) ) ? $ringData['ringData']['retailerInfo']->retailerID : '',
                    'retailerEmail'       => ( isset( $ringData['ringData']['retailerInfo']->retailerEmail ) ) ? $ringData['ringData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo'   => ( isset( $ringData['ringData']['retailerInfo']->retailerContactNo ) ) ? $ringData['ringData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax'         => ( isset( $ringData['ringData']['retailerInfo']->retailerFax ) ) ? $ringData['ringData']['retailerInfo']->retailerFax : '',
                    'retailerAddress'     => ( isset( $ringData['ringData']['retailerInfo']->retailerAddress ) ) ? $ringData['ringData']['retailerInfo']->retailerAddress : '',
                    'labColumn'           =>'',
                );

                if ($diamondData['diamondData']['currencyFrom'] == 'USD') {
                    $currency_symbol = "$";
                } else {
                    $currency_symbol = $diamondData['diamondData']['currencyFrom'] . $diamondData['diamondData']['currencySymbol'];
                }

                if ($jc_options['jc_options']->show_Certificate_in_Diamond_Search) {
                    $certificate_html = '<tr><td class="consumer-title">Lab:</td><td class="consumer-name">' . $templateVars['certificateNo'] . ' <a href="' . $templateVars['certificateUrl'] . '">GIA Certificate</a></td></tr>';
                } else {
                    $certificate_html = '';
                }

                $templateValueReplacement = array(
                    '{{shopurl}}' => $shopurl,
                    '{{shop_logo}}' => $store_logo,
                    '{{shop_logo_alt}}' => 'Gemfind Diamond Link',
                    '{{name}}' => $templateVars['name'],
                    '{{email}}' => $templateVars['email'],
                    '{{phone}}' => $templateVars['phone'],
                    '{{hint_message}}' => $templateVars['hint_message'],
                    '{{contact_pref}}' => $templateVars['contact_pref'],
                    '{{diamond_id}}' => $templateVars['diamond_id'],
                    '{{diamond_url}}' => $templateVars['diamond_url'],
                    '{{size}}' => $templateVars['size'],
                    '{{cut}}' => $templateVars['cut'],
                    '{{color}}' => $templateVars['color'],
                    '{{clarity}}' => $templateVars['clarity'],
                    '{{depth}}' => $templateVars['depth'],
                    '{{table}}' => $templateVars['table'],
                    '{{measurment}}' => $templateVars['measurment'],
                    '{{certificate}}' => $templateVars['certificate'],
                    '{{certificateUrl}}' => $certificate_html,
                    '{{price}}' => $currency_symbol . $templateVars['price'],
                    '{{wholeSalePrice}}' => $currency_symbol . $templateVars['wholeSalePrice'],
                    '{{vendorName}}' => $retailername,
                    '{{vendorStockNo}}' => $templateVars['vendorStockNo'],
                    '{{vendorEmail}}' => $templateVars['vendorEmail'],
                    '{{vendorContactNo}}' => $templateVars['vendorContactNo'],
                    '{{vendorFax}}' => $templateVars['vendorFax'],
                    '{{vendorAddress}}' => $templateVars['vendorAddress'],
                    '{{retailerName}}' => $templateVars['retailerName'],
                    '{{retailerEmail}}' => $templateVars['retailerEmail'],
                    '{{retailerContactNo}}' => $templateVars['retailerContactNo'],
                    '{{retailerStockNo}}' => $templateVars['retailerStockNo'],
                    '{{retailerFax}}' => $templateVars['retailerFax'],
                    '{{retailerAddress}}' => $templateVars['retailerAddress'],
                    '{{ring_url}}'            => $templateVars['ring_url'],
                    '{{price_rb}}'               => $templateVars['price_rb'],
                    '{{labColumn}}'           => $templateVars['labColumn'],
                    '{{setting_id}}'          => $templateVars['setting_id'],
                    '{{stylenumber}}'         => $templateVars['stylenumber'],
                    '{{metaltype}}'           => $templateVars['metaltype'],
                    '{{centerStoneSize}}'     => $templateVars['centerStoneSize'],
                    '{{ringSize}}'            => $templateVars['ringSize'],
                    '{{sideStoneQualityhtm}}' => $templateVars['sideStoneQualityhtm'],
                    '{{centerStoneMinCarat}}' => $templateVars['centerStoneMinCarat'],
                    '{{centerStoneMaxCarat}}' => $templateVars['centerStoneMaxCarat'],
                    '{{retailerName}}'        => $templateVars['retailerName'],
                    '{{retailerEmail}}'       => $templateVars['retailerEmail'],
                    '{{retailerContactNo}}'   => $templateVars['retailerContactNo'],
                    '{{retailerFax}}'         => $templateVars['retailerFax'],
                    '{{retailerAddress}}'     => $templateVars['retailerAddress'],
                    '{{retailerID}}'          => $templateVars['retailerID'],
                    '{{vendorName}}'          => $vendorName,
                    '{{vendorEmail}}'         => $ringData['ringData']['vendorEmail'],
                    '{{vendorPhone}}'         => $ringData['ringData']['vendorPhone'],
                );

                // echo "<pre>";
                // print_r($templateValueReplacement);
                // exit();

                // Retailer email
                $transport_retailer_template = $this->load->view('emails/complete_ring/ringinfo_email_template_retailer.html', '', true);
                $retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);
                $retailer_subject = "Request For More Info";
                $retailer_fromAddress = $this->diamond_lib->getEmailSender($req_post_data['shopurl']);
                $retailer_toEmail = $retaileremail;

                $this->email->from('smtp@gemfind.com', 'GemFind');
                $this->email->to($retailer_toEmail);
                $this->email->reply_to($senderFromAddress, $store_detail->shop->name);
                $this->email->subject($retailer_subject);
                $this->email->message($retailer_email_body);
                $this->email->send();
                // Sender email
                $transport_sender_template = $this->load->view('emails/complete_ring/ringinfo_email_template_sender.html', '', true);
                $sender_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_sender_template);
                $sender_subject = "Request For More Info";
                $sender_fromAddress = $this->diamond_lib->getEmailSender($req_post_data['shopurl']);
                $sender_toEmail = $req_post_data['email'];

                $this->email->from('smtp@gemfind.com', $store_detail->shop->name);
                $this->email->to($sender_toEmail);
                $this->email->reply_to($senderFromAddress, $store_detail->shop->name);
                $this->email->subject($sender_subject);
                $this->email->message($sender_email_body);
                $this->email->send();

               // Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($req_post_data['shopurl']);

				$postUrl = 'https://api.jewelcloud.com/api/RingBuilder/RequestMoreInfo';
				
				$formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $req_post_data['name'] ? $req_post_data['name'] : '',
                    'EmailID' => $req_post_data['email'] ? $req_post_data['email'] : '',
                    'Phone' => $req_post_data['avail_date'] ? $req_post_data['avail_date'] : '',
                    'Message' => $req_post_data['appnt_time'] ? $req_post_data['appnt_time'] : '',
                    'Phone' => $req_post_data['phone'] ? $req_post_data['phone'] : '',
                    'Preference' => $req_post_data['hint_message'] ? $req_post_data['hint_message'] : '',
                    'SID' =>  $req_post_data['settingid'] ? $req_post_data['settingid'] : '',
                    'DID' =>  $req_post_data['diamondId'] ? $req_post_data['diamondId'] : '',
                   
                );

                $this->getSettingFormTrackingCurl($postUrl,$formdata);
               
                // Ending of Form Tracking

                $message = 'Thanks for your submission.';
                $data = array('status' => 1, 'msg' => $message);
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
            $data = array('status' => 0, 'msg' => $message);
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }
        $message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message);
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
    }

    public function resultscheview_cr() {
        $sch_view_post_data = $this->input->post(NULL, true);

       if(isset($sch_view_post_data['captcha-response-ten']) && !empty($sch_view_post_data['captcha-response-ten'])){      
		        $data = array(
		           'secret' => $sch_view_post_data['secret-key'],
		            'response' => $sch_view_post_data['captcha-response-ten']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		    }
        if(empty($sch_view_post_data['settingid'])){
            $message = 'Please Enter SettingId.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['diamondId'])){
            $message = 'Please Enter DiamondId.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['shopurl'])){
            $message = 'Please Enter Shopurl.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['completering'])){
            $message = 'Please Enter Completering.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['name'])){
            $message = 'Please Enter Name.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['email'])){
            $message = 'Please Enter Email.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['phone'])){
            $message = 'Please Enter Phone.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['hint_message'])){
            $message = 'Please Enter Hint Message.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['location'])){
            $message = 'Please Enter Location.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['avail_date'])){
            $message = 'Please Enter Avail Date.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        if(empty($sch_view_post_data['appnt_time'])){
            $message = 'Please Enter Appnt Time.';
               $data = array('status' => 2, 'msg' => $message );
               $result = json_encode(array('output' => $data));
               echo $result;
               exit;
        }

        $shopurl = "https://" . $sch_view_post_data['shopurl'];
        $store_detail = $this->getStoreName($sch_view_post_data['shopurl']);
        $store_logo = $this->general_model->getStoreLogo($sch_view_post_data['shopurl']);
        $store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");
        $jc_options = $this->diamond_lib->getJCOptions($sch_view_post_data['shopurl']);
        if ($sch_view_post_data) {
            try {
                $ringData = $this->ringbuilder_lib->getRingById($sch_view_post_data['settingid'], $sch_view_post_data['shopurl'], $sch_view_post_data['islabsettings']);
                $diamondData = $this->diamond_lib->getDiamondById($sch_view_post_data['diamondId'], $sch_view_post_data['diamondtype'], $sch_view_post_data['shopurl']);

                $file = 'diamondData_log.txt';
                file_put_contents($file, $diamondData);
                 //print_r($diamondData);

                $storeAdminEmail = $this->diamond_lib->getAdminEmail($sch_view_post_data['shopurl']);
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);
                if ($diamondData['diamondData']['fancyColorMainBody']) {
                    $color_to_display = $diamondData['diamondData']['fancyColorIntensity'] . ' ' . $diamondData['diamondData']['fancyColorMainBody'];
                } elseif ($diamondData['diamondData']['color'] != '') {
                    $color_to_display = $diamondData['diamondData']['color'];
                } else {
                    $color_to_display = 'NA';
                }

                $templateVars = array(
                    'name' => $sch_view_post_data['name'],
                    'email' => $sch_view_post_data['email'],
                    'phone' => $sch_view_post_data['phone'],
                    'hint_message' => $sch_view_post_data['hint_message'],
                    'location' => $sch_view_post_data['location'],
                    'avail_date' => $sch_view_post_data['avail_date'],
                    'appnt_time' => $sch_view_post_data['appnt_time'],
                    'diamond_url' => (isset($sch_view_post_data['diamondurl'])) ? $sch_view_post_data['diamondurl'] : '',
                    'diamond_id' => (isset($diamondData['diamondData']['diamondId'])) ? $diamondData['diamondData']['diamondId'] : '',
                    'size' => (isset($diamondData['diamondData']['caratWeight'])) ? $diamondData['diamondData']['caratWeight'] : '',
                    'cut' => (isset($diamondData['diamondData']['cut'])) ? $diamondData['diamondData']['cut'] : '',
                    'color' => $color_to_display,
                    'clarity' => (isset($diamondData['diamondData']['clarity'])) ? $diamondData['diamondData']['clarity'] : '',
                    'depth' => (isset($diamondData['diamondData']['depth'])) ? $diamondData['diamondData']['depth'] : '',
                    'table' => (isset($diamondData['diamondData']['table'])) ? $diamondData['diamondData']['table'] : '',
                    'measurment' => (isset($diamondData['diamondData']['measurement'])) ? $diamondData['diamondData']['measurement'] : '',
                    'certificate' => (isset($diamondData['diamondData']['certificate'])) ? $diamondData['diamondData']['certificate'] : '',
                    'certificateNo' => (isset($diamondData['diamondData']['certificateNo'])) ? $diamondData['diamondData']['certificateNo'] : '',
                    'certificateUrl' => (isset($diamondData['diamondData']['certificateUrl'])) ? $diamondData['diamondData']['certificateUrl'] : '',
                    'price' => (isset($diamondData['diamondData']['fltPrice'])) ? number_format($diamondData['diamondData']['fltPrice']) : '',
                    'vendorID' => (isset($diamondData['diamondData']['vendorID'])) ? $diamondData['diamondData']['vendorID'] : '',
                    'vendorName' => (isset($diamondData['diamondData']['vendorName'])) ? $diamondData['diamondData']['vendorName'] : '',
                    'vendorEmail' => (isset($diamondData['diamondData']['vendorEmail'])) ? $diamondData['diamondData']['vendorEmail'] : '',
                    'vendorContactNo' => (isset($diamondData['diamondData']['vendorContactNo'])) ? $diamondData['diamondData']['vendorContactNo'] : '',
                    'vendorStockNo' => (isset($diamondData['diamondData']['vendorStockNo'])) ? $diamondData['diamondData']['vendorStockNo'] : '',
                    'vendorFax' => (isset($diamondData['diamondData']['vendorFax'])) ? $diamondData['diamondData']['vendorFax'] : '',
                    'vendorAddress' => (isset($diamondData['diamondData']['vendorAddress'])) ? $diamondData['diamondData']['vendorAddress'] : '',
                    'wholeSalePrice' => (isset($diamondData['diamondData']['wholeSalePrice'])) ? number_format($diamondData['diamondData']['wholeSalePrice']) : '',
                    'vendorAddress' => (isset($diamondData['diamondData']['vendorAddress'])) ? $diamondData['diamondData']['vendorAddress'] : '',
                    'retailerName' => (isset($diamondData['diamondData']['retailerInfo']->retailerName)) ? $diamondData['diamondData']['retailerInfo']->retailerName : '',
                    'retailerID' => (isset($diamondData['diamondData']['retailerInfo']->retailerID)) ? $diamondData['diamondData']['retailerInfo']->retailerID : '',
                    'retailerEmail' => (isset($diamondData['diamondData']['retailerInfo']->retailerEmail)) ? $diamondData['diamondData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo' => (isset($diamondData['diamondData']['retailerInfo']->retailerContactNo)) ? $diamondData['diamondData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax' => (isset($diamondData['diamondData']['retailerInfo']->retailerFax)) ? $diamondData['diamondData']['retailerInfo']->retailerFax : '',
                    'retailerAddress' => (isset($diamondData['diamondData']['retailerInfo']->retailerAddress)) ? $diamondData['diamondData']['retailerInfo']->retailerAddress : '',
                    'ring_url'            => ( isset( $sch_view_post_data['diamondurl'] ) ) ? $sch_view_post_data['diamondurl'] : '',
                   	'price_rb'               => ( isset( $ringData['ringData']['cost'] ) ) ? $ringData['ringData']['currencySymbol'] . ' ' . number_format( $ringData['ringData']['cost'] ) : '',
                    'setting_id'          => ( isset( $ringData['ringData']['settingId'] ) ) ? $ringData['ringData']['settingId'] : '',
                    'stylenumber'         => ( isset( $ringData['ringData']['styleNumber'] ) ) ? $ringData['ringData']['styleNumber'] : '',
                    'metaltype'           => ( isset( $ringData['ringData']['metalType'] ) ) ? $ringData['ringData']['metalType'] : '',
                    'centerStoneSize'     => ( isset( $ringData['ringData']['configurableProduct'][0]->centerStoneSize ) ) ? $ringData['ringData']['configurableProduct'][0]->centerStoneSize : '',
                    'ringSize'            => $ringSize,
                    'sideStoneQualityhtm' => $sideStoneQualityhtm,
                    'centerStoneMinCarat' => ( isset( $ringData['ringData']['centerStoneMinCarat'] ) ) ? $ringData['ringData']['centerStoneMinCarat'] : '',
                    'centerStoneMaxCarat' => ( isset( $ringData['ringData']['centerStoneMaxCarat'] ) ) ? $ringData['ringData']['centerStoneMaxCarat'] : '',
                    'retailerName'        => ( isset( $ringData['ringData']['vendorName'] ) ) ? $ringData['ringData']['vendorName'] : '',
                    'retailerID'          => ( isset( $ringData['ringData']['retailerInfo']->retailerID ) ) ? $ringData['ringData']['retailerInfo']->retailerID : '',
                    'retailerEmail'       => ( isset( $ringData['ringData']['retailerInfo']->retailerEmail ) ) ? $ringData['ringData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo'   => ( isset( $ringData['ringData']['retailerInfo']->retailerContactNo ) ) ? $ringData['ringData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax'         => ( isset( $ringData['ringData']['retailerInfo']->retailerFax ) ) ? $ringData['ringData']['retailerInfo']->retailerFax : '',
                    'retailerAddress'     => ( isset( $ringData['ringData']['retailerInfo']->retailerAddress ) ) ? $ringData['ringData']['retailerInfo']->retailerAddress : '',
                    'labColumn'           =>'',
                );

                if ($diamondData['diamondData']['currencyFrom'] == 'USD') {
                    $currency_symbol = "$";
                } else {
                    $currency_symbol = $diamondData['diamondData']['currencyFrom'] . $diamondData['diamondData']['currencySymbol'];
                }

                if ($jc_options['jc_options']->show_Certificate_in_Diamond_Search) {
                    $certificate_html = '<tr><td class="consumer-title">Lab:</td><td class="consumer-name">' . $templateVars['certificateNo'] . ' <a href="' . $templateVars['certificateUrl'] . '">GIA Certificate</a></td></tr>';
                } else {
                    $certificate_html = '';
                }

                $templateValueReplacement = array(
                    '{{shopurl}}' => $shopurl,
                    '{{shop_logo}}' => $store_logo,
                    '{{shop_logo_alt}}' => $store_detail->shop->name,
                    '{{name}}' => $templateVars['name'],
                    '{{email}}' => $templateVars['email'],
                    '{{phone}}' => $templateVars['phone'],
                    '{{hint_message}}' => $templateVars['hint_message'],
                    '{{location}}' => $templateVars['location'],
                    '{{appnt_time}}' => $templateVars['appnt_time'],
                    '{{avail_date}}' => $templateVars['avail_date'],
                    '{{diamond_id}}' => $templateVars['diamond_id'],
                    '{{diamond_url}}' => $templateVars['diamond_url'],
                    '{{size}}' => $templateVars['size'],
                    '{{cut}}' => $templateVars['cut'],
                    '{{color}}' => $templateVars['color'],
                    '{{clarity}}' => $templateVars['clarity'],
                    '{{depth}}' => $templateVars['depth'],
                    '{{table}}' => $templateVars['table'],
                    '{{measurment}}' => $templateVars['measurment'],
                    '{{certificate}}' => $templateVars['certificate'],
                    '{{certificateUrl}}' => $certificate_html,
                    '{{price}}' => $currency_symbol . $templateVars['price'],
                    '{{retailerName}}' => $retailername,
                    '{{retailerEmail}}' => $templateVars['retailerEmail'],
                    '{{retailerContactNo}}' => $templateVars['retailerContactNo'],
                    '{{retailerFax}}' => $templateVars['retailerFax'],
                    '{{retailerAddress}}' => $templateVars['retailerAddress'],
                    '{{ring_url}}'            => $templateVars['ring_url'],
                    '{{price_rb}}'               => $templateVars['price_rb'],
                    '{{labColumn}}'           => $templateVars['labColumn'],
                    '{{setting_id}}'          => $templateVars['setting_id'],
                    '{{stylenumber}}'         => $templateVars['stylenumber'],
                    '{{metaltype}}'           => $templateVars['metaltype'],
                    '{{centerStoneSize}}'     => $templateVars['centerStoneSize'],
                    '{{ringSize}}'            => $templateVars['ringSize'],
                    '{{sideStoneQualityhtm}}' => $templateVars['sideStoneQualityhtm'],
                    '{{centerStoneMinCarat}}' => $templateVars['centerStoneMinCarat'],
                    '{{centerStoneMaxCarat}}' => $templateVars['centerStoneMaxCarat'],
                    '{{retailerName}}'        => $templateVars['retailerName'],
                    '{{retailerEmail}}'       => $templateVars['retailerEmail'],
                    '{{retailerContactNo}}'   => $templateVars['retailerContactNo'],
                    '{{retailerFax}}'         => $templateVars['retailerFax'],
                    '{{retailerAddress}}'     => $templateVars['retailerAddress'],
                    '{{retailerID}}'          => $templateVars['retailerID'],
                    '{{vendorName}}'          => $vendorName,
                    '{{vendorEmail}}'         => $ringData['ringData']['vendorEmail'],
                    '{{vendorPhone}}'         => $ringData['ringData']['vendorPhone'],
                );

                // Retailer email
                $transport_retailer_template = $this->load->view('emails/complete_ring/ringschedule_view_email_template_retailer.html', '', true);
                $retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);
                $retailer_subject = "Request To Schedule A Viewing";
                $retailer_fromAddress = $this->diamond_lib->getEmailSender($sch_view_post_data['shopurl']);
                $retailer_toEmail = $retaileremail;

                $this->email->from('smtp@gemfind.com', 'GemFind');
                $this->email->to($retailer_toEmail);
                $this->email->reply_to($senderFromAddress, $store_detail->shop->name);
                $this->email->subject($retailer_subject);
                $this->email->message($retailer_email_body);
                $this->email->send();

                // Sender email
                $transport_sender_template = $this->load->view('emails/complete_ring/ringschedule_email_template_sender.html', '', true);
                $sender_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_sender_template);
                $sender_subject = "Request To Schedule A Viewing";
                $sender_fromAddress = $this->diamond_lib->getEmailSender($sch_view_post_data['shopurl']);
                $sender_toEmail = $sch_view_post_data['email'];
                $this->email->from('smtp@gemfind.com', 'GemFind');
                $this->email->to($sender_toEmail);
                $this->email->reply_to($senderFromAddress, $store_detail->shop->name);
                $this->email->subject($sender_subject);
                $this->email->message($sender_email_body);
                $this->email->send();


                // Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($sch_view_post_data['shopurl']);

				$postUrl = 'https://api.jewelcloud.com/api/RingBuilder/ScheduleAppointment';
				
				$formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $sch_view_post_data['name'] ? $sch_view_post_data['name'] : '',
                    'EmailID' => $sch_view_post_data['email'] ? $sch_view_post_data['email'] : '',
                    'Date' => $sch_view_post_data['avail_date'] ? $sch_view_post_data['avail_date'] : '',
                    'Time' => $sch_view_post_data['appnt_time'] ? $sch_view_post_data['appnt_time'] : '',
                    'Phone' => $sch_view_post_data['phone'] ? $sch_view_post_data['phone'] : '',
                    'Message' => $sch_view_post_data['hint_message'] ? $sch_view_post_data['hint_message'] : '',
                    'SID' =>  $sch_view_post_data['settingid'] ? $sch_view_post_data['settingid'] : '',
                    'DID' => $sch_view_post_data['diamondId'] ? $sch_view_post_data['diamondId'] : '',
                    'Shape' => $ringData['ringData']['shape'] ? $ringData['ringData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $ringData['ringData']['cost'] ? $ringData['ringData']['cost'] : '',
                );

				
                $this->getFormTrackingCurl($postUrl,$formdata);
               
                // Ending of Form Tracking
				


                $message = 'Thanks for your submission.';
                $data = array('status' => 1, 'msg' => $message);
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
            $data = array('status' => 0, 'msg' => $message);
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
        }
        $message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message);
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
    }

    public function resultdrophint_cr() {
       $hint_post_data = $this->input->post(NULL, true);

       // echo '<pre>'; print_r($hint_post_data); exit();

 		if(isset($hint_post_data['captcha-response-eleven']) && !empty($hint_post_data['captcha-response-eleven'])){      
		        $data = array(
		            'secret' => $hint_post_data['secret-key'],
		            'response' => $hint_post_data['captcha-response-eleven']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		}
		 	
 		if(empty($hint_post_data['settingid'])){
 			$message = 'Please Enter Setting Id.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['shopurl'])){
 			$message = 'Please Enter Shopurl.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['name'])){
 			$message = 'Please Enter Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['email'])){
 			$message = 'Please Enter Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['recipient_name'])){
 			$message = 'Please Enter Recipient Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}


 		if(empty($hint_post_data['recipient_email'])){
 			$message = 'Please Enter Recipient Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['gift_reason'])){
 			$message = 'Please Enter Gift Reason.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['hint_message'])){
 			$message = 'Please Enter Hint Message.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['gift_deadline'])){
 			$message = 'Please Enter Gift Deadline.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		
 		$shopurl = "https://".$hint_post_data['shopurl'];
 		$store_detail = $this->getStoreName($hint_post_data['shopurl']);
 		$store_logo = $this->general_model->getStoreLogo($hint_post_data['shopurl']);
 		$store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");
 		if($hint_post_data){
 			try {
                $ringData = $this->ringbuilder_lib->getRingById($hint_post_data['settingid'], $hint_post_data['shopurl'], $hint_post_data['islabsettings']);

                 $diamondData = $this->diamond_lib->getDiamondById($hint_post_data['diamondId'], $hint_post_datahint_post_data['diamondtype'], $hint_post_data['shopurl']);

             
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);
                if ($diamondData['diamondData']['fancyColorMainBody']) {
                    $color_to_display = $diamondData['diamondData']['fancyColorIntensity'] . ' ' . $diamondData['diamondData']['fancyColorMainBody'];
                } elseif ($diamondData['diamondData']['color'] != '') {
                    $color_to_display = $diamondData['diamondData']['color'];
                } else {
                    $color_to_display = 'NA';
                }


                $storeAdminEmail =  $this->ringbuilder_lib->getAdminEmail($hint_post_data['shopurl']);
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $ringData['ringData']['vendorEmail']);
                $retailername = ( $ringData['ringData']['vendorName'] ? $ringData['ringData']['vendorName'] : $store_detail->shop->name );
                $templateVars = array(
                    'retailerName' => $retailername,
                    'retailerphone' => $ringData['ringData']['vendorPhone'],
                    'name' => $hint_post_data['name'],
                    'email' => $hint_post_data['email'],
                    'recipient_name' => $hint_post_data['recipient_name'],
                    'recipient_email' => $hint_post_data['recipient_email'],
                    'gift_reason' => $hint_post_data['gift_reason'],
                    'hint_message' => $hint_post_data['hint_message'],
                    'gift_deadline' => $hint_post_data['gift_deadline'],
                    'retailerEmail'       => $retaileremail,
                    'retailerContactNo'   => ( isset( $ringData['ringData']['retailerInfo']->retailerContactNo ) ) ? $ringData['ringData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax'         => ( isset( $ringData['ringData']['retailerInfo']->retailerFax ) ) ? $ringData['ringData']['retailerInfo']->retailerFax : '',
                    'retailerAddress'     => ( isset( $ringData['ringData']['retailerInfo']->retailerAddress ) ) ? $ringData['ringData']['retailerInfo']->retailerAddress : '',
                    'labColumn'           =>'',
                );
                // Sender email
                $transport_sender_template = $this->load->view('emails/complete_ring/ringhint_email_template_sender.html','',true);                
                $senderValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $templateVars['name'],
					'{{email}}' => $hint_post_data['email'],
					'{{recipient_email}}' => $templateVars['recipient_email'],
					'{{recipient_name}}' => $templateVars['recipient_name'],
					'{{gift_reason}}' => $templateVars['gift_reason'],
					'{{gift_deadline}}' => $templateVars['gift_deadline'],
					'{{hint_message}}' => $templateVars['hint_message'],
                    '{{retailerName}}' => $retailername,
                    '{{retailerEmail}}' => $templateVars['retailerEmail'],
                    '{{retailerContactNo}}' => $templateVars['retailerContactNo'],
                    '{{retailerFax}}' => $templateVars['retailerFax'],
                    '{{retailerAddress}}' => $templateVars['retailerAddress'],
                    '{{retailerID}}'          => $templateVars['retailerID'],
                    '{{vendorName}}'          => $vendorName,
                    '{{vendorEmail}}'         => $ringData['ringData']['vendorEmail'],
                    '{{vendorPhone}}'         => $ringData['ringData']['vendorPhone'],
					'{{retailerphone}}' => $templateVars['retailerphone'],
					'{{retaileremail}}' => $ringData['ringData']['vendorEmail']
				);
				$sender_email_body = str_replace(array_keys($senderValueReplacement), array_values($senderValueReplacement), $transport_sender_template);	
				$sender_subject = "Someone Wants To Drop You A Hint";
				$senderFromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$senderToEmail = $templateVars['email'];

				//NEED TO GET DATA FROM DATABASE HERE
                $store_detail = $this->getStoreSmtp($hint_post_data['shopurl']);
                if($store_detail){
                    $config = array(
                        'protocol' =>  'smtp',
                        'smtp_host' => $store_detail->smtphost,
                        'smtp_port' => $store_detail->smtpport,
                        'smtp_user' => $store_detail->smtpusername,
                        'smtp_pass' => $store_detail->smtppassword,
                        'smtp_crypto' => $store_detail->protocol == "none" ? "tls" : $store_detail->protocol,
                        'mailtype' => 'html',
                        'smtp_timeout' => '4',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'newline' => "\r\n"
                    );
                    $this->email->initialize($config);
               }
               //END FOR DATABASE QUERY

				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($senderToEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();
                // Receiver email
                $transport_receiver_template = $this->load->view('emails/complete_ring/ringhint_email_template_receiver.html','',true);                
    
				$receiver_email_body = str_replace(array_keys($senderValueReplacement), array_values($senderValueReplacement), $transport_receiver_template);	
				$receiver_subject = "Someone Wants To Drop You A Hint";
				$receiver_fromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$receiver_toEmail = $hint_post_data['recipient_email'];
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($receiver_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($receiver_subject);
				$this->email->message($receiver_email_body);
				$this->email->send();
				// Retailer email
                $transport_retailer_template = $this->load->view('emails/complete_ring/ringhint_email_template_retailer.html','',true);                
   
				$retailer_email_body = str_replace(array_keys($senderValueReplacement), array_values($senderValueReplacement), $transport_retailer_template);	
				$retailer_subject = "Someone Wants To Drop You A Hint";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$retailer_toEmail = $retaileremail;
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();
				$this->email->send();


				// Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($hint_post_data['shopurl']);

				$postUrl = 'http://api.jewelcloud.com/api/RingBuilder/DropAHint';

				
				$formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $hint_post_data['name'] ? $hint_post_data['name'] : '',
                    'EmailID' => $hint_post_data['email'] ? $hint_post_data['email'] : '',
                    'RecipientName' => $hint_post_data['recipient_name'] ? $hint_post_data['recipient_name'] : '',
                    'RecipientEmailID' => $hint_post_data['recipient_email'] ? $hint_post_data['recipient_email'] : '',
                    'Reason' => $hint_post_data['gift_reason'] ? $hint_post_data['gift_reason'] : '',
                    'Message' => $hint_post_data['hint_message'] ? $hint_post_data['hint_message'] : '',
                    'DeadlineDate' => $hint_post_data['gift_deadline'] ? $hint_post_data['gift_deadline'] : '',
                    'SID' =>  $hint_post_data['settingid'] ? $hint_post_data['settingid'] : '',
                    'DID' => '',
                    'Shape' => $ringData['ringData']['shape'] ? $ringData['ringData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $ringData['ringData']['cost'] ? $ringData['ringData']['cost'] : '',
                );


             	$this->getSettingFormTrackingCurl($postUrl,$formdata);
            
                // Ending of Form Tracking 

                $message = 'Thanks for your submission.';
				$data = array('status' => 1, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
				$message = $e->getMessage();
			}
			$data = array('status' => 0, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
 		}
 		$message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message );
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
    }

    public function resultemailfriend_cr() {
       $email_friend_post_data = $this->input->post(NULL, true);

 		if(isset($email_friend_post_data['captcha-response-twelve']) && !empty($email_friend_post_data['captcha-response-twelve'])){      
		        $data = array(
		            'secret' => $email_friend_post_data['secret-key'],
		            'response' => $email_friend_post_data['captcha-response-twelve']
		        );        
		        $verify = curl_init();
		        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api.js");
		        curl_setopt($verify, CURLOPT_POST, true);
		        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		        $response = curl_exec($verify);       
		        if($response == true){ 
		            // $result='<div class="success">Your request has been successfully received</div>';
		            // echo $result;
		        }else{
		        	$message = 'Verification failed, please try again';
					$data = array('status' => 2, 'msg' => $message );
	                $result = json_encode(array('output' => $data));
	                echo $result;
	                exit;
		        }
		    }
		    
 		if(empty($email_friend_post_data['settingid'])){
 			$message = 'Please Enter Setting Id.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['shopurl'])){
 			$message = 'Please Enter Shopurl.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['name'])){
 			$message = 'Please Enter Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['email'])){
 			$message = 'Please Enter Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['friend_name'])){
 			$message = 'Please Enter Friend Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['friend_email'])){
 			$message = 'Please Enter Friend Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($email_friend_post_data['message'])){
 			$message = 'Please Enter Message.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}


 		$shopurl = "https://".$email_friend_post_data['shopurl'];
		$store_detail = $this->getStoreName($email_friend_post_data['shopurl']);
 		$store_logo = $this->general_model->getStoreLogo($email_friend_post_data['shopurl']);
 		$store_logo = ($store_logo ? $store_logo : base_url() . "assets/images/no-logo.png");
 		if($email_friend_post_data){
 			try {
                $ringData = $this->ringbuilder_lib->getRingById($email_friend_post_data['settingid'], $email_friend_post_data['shopurl'], $email_friend_post_data['islabsettings']);

                 $diamondData = $this->diamond_lib->getDiamondById($email_friend_post_data['diamondId'], $email_friend_post_data['diamondtype'], $email_friend_post_data['shopurl']);

                            
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);
                if ($diamondData['diamondData']['fancyColorMainBody']) {
                    $color_to_display = $diamondData['diamondData']['fancyColorIntensity'] . ' ' . $diamondData['diamondData']['fancyColorMainBody'];
                } elseif ($diamondData['diamondData']['color'] != '') {
                    $color_to_display = $diamondData['diamondData']['color'];
                } else {
                    $color_to_display = 'NA';
                }

                $storeAdminEmail =  $this->ringbuilder_lib->getAdminEmail($email_friend_post_data['shopurl']);
                $vendorEmail = ( $storeAdminEmail ? $storeAdminEmail : $ringData['ringData']['vendorEmail']);
                $vendorName = ( $ringData['ringData']['vendorName'] ? $ringData['ringData']['vendorName'] : $store_detail->shop->name );
                
                
                $templateVars = array(
                    'name' => $email_friend_post_data['name'],
                    'email' => $email_friend_post_data['email'],
                    'friend_name' => $email_friend_post_data['friend_name'],
                    'friend_email' => $email_friend_post_data['friend_email'],
                    'message' => $email_friend_post_data['message'],
                    'ring_url' => (isset($email_friend_post_data['ringurl'])) ? $email_friend_post_data['ringurl'] : '',
                    'setting_id' => (isset($ringData['ringData']['settingId'])) ? $ringData['ringData']['settingId']: '',
                    'stylenumber' => (isset($ringData['ringData']['styleNumber'])) ? $ringData['ringData']['styleNumber'] : '',
                    'metaltype' => (isset($ringData['ringData']['metalType'])) ? $ringData['ringData']['metalType'] : '',
                    'centerStoneMinCarat' => (isset($ringData['ringData']['centerStoneMinCarat'])) ? $ringData['ringData']['centerStoneMinCarat'] : '',
                    'centerStoneMaxCarat' => (isset($ringData['ringData']['centerStoneMaxCarat'])) ? $ringData['ringData']['centerStoneMaxCarat'] : '',
                    'price' => (isset($ringData['ringData']['cost'])) ? $ringData['ringData']['currencySymbol'].' '.number_format($ringData['ringData']['cost']) : '',
                    'retailerName' => (isset($ringData['ringData']['retailerInfo']->retailerName)) ? $ringData['ringData']['retailerInfo']->retailerName : '',
                    'retailerID' => (isset($ringData['ringData']['retailerInfo']->retailerID)) ? $ringData['ringData']['retailerInfo']->retailerID : '',
                    'retailerEmail' => (isset($ringData['ringData']['retailerInfo']->retailerEmail)) ? $ringData['ringData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo' => (isset($ringData['ringData']['retailerInfo']->retailerContactNo)) ? $ringData['ringData']['retailerInfo']->retailerContactNo : '',
                    'retailerFax' => (isset($ringData['ringData']['retailerInfo']->retailerFax)) ? $ringData['ringData']['retailerInfo']->retailerFax : '',
                    'retailerAddress' => (isset($ringData['ringData']['retailerInfo']->retailerAddress)) ? $ringData['ringData']['retailerInfo']->retailerAddress : '',
                    'diamond_id' => (isset($diamondData['diamondData']['diamondId'])) ? $diamondData['diamondData']['diamondId'] : '',
                    'size' => (isset($diamondData['diamondData']['caratWeight'])) ? $diamondData['diamondData']['caratWeight'] : '',
                    'cut' => (isset($diamondData['diamondData']['cut'])) ? $diamondData['diamondData']['cut'] : '',
                    'color' => $color_to_display,
                    'clarity' => (isset($diamondData['diamondData']['clarity'])) ? $diamondData['diamondData']['clarity'] : '',
                    'depth' => (isset($diamondData['diamondData']['depth'])) ? $diamondData['diamondData']['depth'] : '',
                    'table' => (isset($diamondData['diamondData']['table'])) ? $diamondData['diamondData']['table'] : '',
                    'measurment' => (isset($diamondData['diamondData']['measurement'])) ? $diamondData['diamondData']['measurement'] : '',
                    'certificate' => (isset($diamondData['diamondData']['certificate'])) ? $diamondData['diamondData']['certificate'] : '',
                    'certificateNo' => (isset($diamondData['diamondData']['certificateNo'])) ? $diamondData['diamondData']['certificateNo'] : '',
                    'certificateUrl' => (isset($diamondData['diamondData']['certificateUrl'])) ? $diamondData['diamondData']['certificateUrl'] : '',
                    'price' => (isset($diamondData['diamondData']['fltPrice'])) ? number_format($diamondData['diamondData']['fltPrice']) : '',
                    'vendorID' => (isset($diamondData['diamondData']['vendorID'])) ? $diamondData['diamondData']['vendorID'] : '',
                    'vendorName' => (isset($diamondData['diamondData']['vendorName'])) ? $diamondData['diamondData']['vendorName'] : '',
                    'vendorEmail' => (isset($diamondData['diamondData']['vendorEmail'])) ? $diamondData['diamondData']['vendorEmail'] : '',
                    'vendorContactNo' => (isset($diamondData['diamondData']['vendorContactNo'])) ? $diamondData['diamondData']['vendorContactNo'] : '',
                    'vendorStockNo' => (isset($diamondData['diamondData']['vendorStockNo'])) ? $diamondData['diamondData']['vendorStockNo'] : '',
                    'vendorFax' => (isset($diamondData['diamondData']['vendorFax'])) ? $diamondData['diamondData']['vendorFax'] : '',
                    'vendorAddress' => (isset($diamondData['diamondData']['vendorAddress'])) ? $diamondData['diamondData']['vendorAddress'] : '',
                    'wholeSalePrice' => (isset($diamondData['diamondData']['wholeSalePrice'])) ? number_format($diamondData['diamondData']['wholeSalePrice']) : '',
                    'vendorAddress' => (isset($diamondData['diamondData']['vendorAddress'])) ? $diamondData['diamondData']['vendorAddress'] : '',
                   	'price_rb'               => ( isset( $ringData['ringData']['cost'] ) ) ? $ringData['ringData']['currencySymbol'] . ' ' . number_format( $ringData['ringData']['cost'] ) : '',
                    'setting_id'          => ( isset( $ringData['ringData']['settingId'] ) ) ? $ringData['ringData']['settingId'] : '',
                    'stylenumber'         => ( isset( $ringData['ringData']['styleNumber'] ) ) ? $ringData['ringData']['styleNumber'] : '',
                    'metaltype'           => ( isset( $ringData['ringData']['metalType'] ) ) ? $ringData['ringData']['metalType'] : '',
                    'centerStoneSize'     => ( isset( $ringData['ringData']['configurableProduct'][0]->centerStoneSize ) ) ? $ringData['ringData']['configurableProduct'][0]->centerStoneSize : '',
                    'ringSize'            => $ringSize,
                    'sideStoneQualityhtm' => $sideStoneQualityhtm,
                    'centerStoneMinCarat' => ( isset( $ringData['ringData']['centerStoneMinCarat'] ) ) ? $ringData['ringData']['centerStoneMinCarat'] : '',
                    'centerStoneMaxCarat' => ( isset( $ringData['ringData']['centerStoneMaxCarat'] ) ) ? $ringData['ringData']['centerStoneMaxCarat'] : '',
                    'labColumn'           =>'',
                );
                $templateValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $templateVars['name'],
					'{{email}}' => $templateVars['email'],
					'{{friend_name}}' => $templateVars['friend_name'],
					'{{recipient_email}}' => $templateVars['friend_email'],
					'{{message}}' => $templateVars['message'],
					'{{setting_id}}' => $templateVars['setting_id'],
					'{{ring_url}}' => $templateVars['ring_url'],
					'{{stylenumber}}' => $templateVars['stylenumber'],
					'{{metaltype}}' => $templateVars['metaltype'],
					'{{centerStoneMinCarat}}' => $templateVars['centerStoneMinCarat'],
					'{{centerStoneMaxCarat}}' => $templateVars['centerStoneMaxCarat'],
					'{{retailerName}}' => $templateVars['retailerName'],
					'{{retailerphone}}' => $templateVars['retailerContactNo'],
					'{{retailerFax}}' => $templateVars['retailerFax'],
					'{{retailerAddress}}' => $templateVars['retailerAddress'],
					'{{vendorName}}' => $vendorName,
					'{{vendorEmail}}' => $ringData['ringData']['vendorEmail'],
					'{{vendorPhone}}' => $ringData['ringData']['vendorPhone'],
					'{{diamond_id}}' => $templateVars['diamond_id'],
                    '{{diamond_url}}' => $templateVars['diamond_url'],
                    '{{size}}' => $templateVars['size'],
                    '{{cut}}' => $templateVars['cut'],
                    '{{color}}' => $templateVars['color'],
                    '{{clarity}}' => $templateVars['clarity'],
                    '{{depth}}' => $templateVars['depth'],
                    '{{table}}' => $templateVars['table'],
                    '{{measurment}}' => $templateVars['measurment'],
                    '{{certificate}}' => $templateVars['certificate'],
                    '{{certificateUrl}}' => $certificate_html,
                    '{{price}}' => $currency_symbol . $templateVars['price'],                  
                    '{{retailerEmail}}' => $templateVars['retailerEmail'],                  
                    '{{price_rb}}'               => $templateVars['price_rb'],
                    '{{labColumn}}'           => $templateVars['labColumn'],                                                    
                    '{{centerStoneSize}}'     => $templateVars['centerStoneSize'],
                    '{{ringSize}}'            => $templateVars['ringSize'],
                    '{{sideStoneQualityhtm}}' => $templateVars['sideStoneQualityhtm'],                                   
                    '{{retailerContactNo}}'   => $templateVars['retailerContactNo'],                  
                    '{{retailerID}}'          => $templateVars['retailerID'],
				);

				// echo "<pre>"; print_r($templateValueReplacement); exit();
                // Sender email
                $transport_sender_template = $this->load->view('emails/complete_ring/ringemail_friend_email_template_sender.html','',true);                
				$sender_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_sender_template);	
				$sender_subject = "A Friend Wants To Share With You";
				$senderFromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$senderToEmail = $email_friend_post_data['email'];

				//NEED TO GET DATA FROM DATABASE HERE
                $store_detail = $this->getStoreSmtp($email_friend_post_data['shopurl']);
                if($store_detail){
                    $config = array(
                        'protocol' =>  'smtp',
                        'smtp_host' => $store_detail->smtphost,
                        'smtp_port' => $store_detail->smtpport,
                        'smtp_user' => $store_detail->smtpusername,
                        'smtp_pass' => $store_detail->smtppassword,
                        'smtp_crypto' => $store_detail->protocol == "none" ? "tls" : $store_detail->protocol,
                        'mailtype' => 'html',
                        'smtp_timeout' => '4',
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'newline' => "\r\n"
                    );
                    $this->email->initialize($config);
               }
               //END FOR DATABASE QUERY

				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($senderToEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();
                // Receiver email
                $transport_receiver_template = $this->load->view('emails/complete_ring/ringemail_friend_email_template_receiver.html','',true);                
				$receiver_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_receiver_template);	
				$receiver_subject = "A Friend Wants To Share With You";
				$receiver_fromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$receiver_toEmail = $email_friend_post_data['friend_email'];
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($receiver_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($receiver_subject);
				$this->email->message($receiver_email_body);
				$this->email->send();
				// Retailer email
                $transport_retailer_template = $this->load->view('emails/complete_ring/ringemail_friend_email_template_retailer.html','',true);                
				$retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);	
				$retailer_subject = "A Friend Wants To Share With You";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$retailer_toEmail = $vendorEmail;
				$this->email->from('smtp@gemfind.com', 'GemFind');
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();
				// Starting of Form Tracking 
				
				$dealerID = $this->diamond_lib->getUsername($email_friend_post_data['shopurl']);

				$postUrl = 'https://api.jewelcloud.com/api/RingBuilder/EmailAFriend';
				
				$formdata = array(
                    'DealerID' => $dealerID ? $dealerID : '',
                    'Name' => $email_friend_post_data['name'] ? $email_friend_post_data['name'] : '',
                    'EmailID' => $email_friend_post_data['email'] ? $email_friend_post_data['email'] : '',
                    'FriendsName' => $email_friend_post_data['friend_name'] ? $email_friend_post_data['friend_name'] : '',
                    'FriendsEmailID' => $email_friend_post_data['friend_email'] ? $email_friend_post_data['friend_email'] : '',
                    'Message' => $email_friend_post_data['message'] ? $email_friend_post_data['message'] : '',
                    'SID' =>  $email_friend_post_data['settingid'] ? $email_friend_post_data['settingid'] : '',
                    'DID' => '',
                    'Shape' => $ringData['ringData']['shape'] ? $ringData['ringData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $ringData['ringData']['cost'] ? $ringData['ringData']['cost'] : '',
                );

				
                $this->getSettingFormTrackingCurl($postUrl,$formdata);
               
                // Ending of Form Tracking

                $message = 'Thanks for your submission.';
				$data = array('status' => 1, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
            } catch (Exception $e) {
				$message = $e->getMessage();
			}
			$data = array('status' => 0, 'msg' => $message );
            $result = json_encode(array('output' => $data));
            echo $result;
            exit;
 		}
 		$message = 'Not found all the required fields';
        $data = array('status' => 0, 'msg' => $message );
        $result = json_encode(array('output' => $data));
        echo $result;
        exit;
    }

 	public function cartadd(){
 		$this->load->library('user_agent');
 		$shop_data = $this->input->get(NULL, true);
 		$diamond_id = $this->uri->segment(3);
 		if (!$diamond_id) {
            redirect($this->agent->referrer().'/invalid');
        }
        try{
        	$diamondData = $this->diamond_lib->getDiamondById($diamond_id,$shop_data['shop']);
        	$access_token = $this->diamond_lib->getShopAccessToken($shop_data['shop']);
        	$shop_base_url = "https://".$shop_data['shop'];
        	$get_product_endpoint = "/admin/api/2019-07/products.json";
        	$add_product_endpoint = "/admin/api/2019-07/products.json";
        	$get_locations_endpoint = "/admin/api/2019-07/locations.json";
        	$update_inventory_endpoint = "/admin/api/2019-07/inventory_levels/set.json";
        	$get_cart_endpoint = "/cart.json";
        	$getProductLocationUrl = $shop_base_url.$get_locations_endpoint;
        	$updateInvUrl = $shop_base_url.$update_inventory_endpoint;
        	$getProductRequestUrl = $shop_base_url.$get_product_endpoint;
        	$addProductRequestUrl = $shop_base_url.$add_product_endpoint;
        	$getCartRequestUrl = $shop_base_url.$get_cart_endpoint;
        	
        	$request_headers = array(
                    "X-Shopify-Access-Token:" . $access_token,
                    "Content-Type:application/json"
                );
			
			$resultProducts = getCurlData($getProductRequestUrl,$request_headers);
	        foreach ($resultProducts->products as $main_key => $main_value) {
	        	foreach ($main_value->variants as $var_key => $var_value) {
		        	if($var_value->sku == $diamond_id){
		        		$in_shopify = true;
		        		$product_add = $var_value->id;
		        		$inventory_item_id = $var_value->inventory_item_id;
		        	}
	        	}
	        }
	        $resultLocation = getCurlData($getProductLocationUrl,$request_headers);
	        $location_id = $resultLocation->locations[0]->id;
	        
	        if($in_shopify){
	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");
	        	$chekcout_url = $shop_base_url."/cart/add?id=".$product_add."&quantity=1";
	        	redirect($chekcout_url);
	        	exit;
        	}else{
        		$productTitle = $diamondData['diamondData']['mainHeader'];
        		$productDesc = $diamondData['diamondData']['subHeader'];
        		$productVendor = "GemFind";
        		$productType = "GemFindDiamond";
        		$productImage = $diamondData['diamondData']['image2'];
        		$productPrice = number_format($diamondData['diamondData']['fltPrice']);
        		$path_info = pathinfo($this->agent->referrer());
        		
        		$product_add_post_data = '{
				  "product": {
				    "title": "'.$productTitle.'",
				    "body_html": "'.$productDesc.'",
				    "vendor": "'.$productVendor.'",
				    "product_type": "'.$productType.'",
					"published_scope" : "web",
				    "tags": "'.$path_info['basename'].'",
				    "images": [
				       {
				        "src": "'.$productImage.'"
				      }
				    ]				    
				  }
				}';
				// create product in shopify
	        	$resultProd = postCurlData($addProductRequestUrl,$request_headers,$product_add_post_data,"POST"); 
	        	$product_id = $resultProd->product->id;
	        	$variants_id = $resultProd->product->variants['0']->id;
	        	$file = 'common_log.txt';
				file_put_contents($file, $variants_id);
	        	$inventory_item_id = $resultProd->product->variants['0']->inventory_item_id;
	        	// update SKU and stock management in created product
	        	$sku_stock_manage_endpoint = "/admin/api/2019-07/inventory_items/".$inventory_item_id.".json";
	        	$skuStockUpdateUrl = $shop_base_url.$sku_stock_manage_endpoint;
	        	$skuAndStockMangePostData = '{"inventory_item": {"id": '.$inventory_item_id.',"sku": '.$diamond_id.',"tracked" : true}}';
	        	$resultSkuStockUpdate = postCurlData($skuStockUpdateUrl,$request_headers,$skuAndStockMangePostData,"PUT");
	        	//update inventory in created product
	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");
	        	//update pricing stuff in created product
	        	$update_pricing_endpoint = "/admin/api/2019-07/products/".$product_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;
	        	$pricing_post_data = '{"product": {"id":'.$product_id.',"variants": [{"id": '.$variants_id.',"price": "'.$productPrice.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");
	        	
	        	// product add to cart
	        	$chekcout_url = $shop_base_url."/cart/add?id=".$variants_id."&quantity=1";
	        	redirect($chekcout_url);
	        	exit;
        	}
        } catch (Exception $e) {
			redirect($this->agent->referrer().'/error');
		}
 	}

 	public function productTracking(){
 		$setting = $this->input->post(NULL, true);
 		$final_track_url = $setting['track_url'];
 		$settingdata = json_decode(json_decode($setting['setting_data']),true);
 		
 		//print_r($settingdata);
 		

 		$RetailerID = $VendorID = $GFInventoryID= $URL= $MetalType= $MetalColor= $cost = $UsersIPAddress= ''; 
 		
        $RetailerID = 'RetailerID='.($settingdata['ringData']['vendorId'] ? $settingdata['ringData']['vendorId'].'&':'&');
        
        $VendorID = 'VendorID='.($settingdata['ringData']['retailerInfo']['retailerID'] ? $settingdata['ringData']['retailerInfo']['retailerID'].'&':'&');
       
        $GFInventoryID = 'GFInventoryID='.$settingdata['ringData']['settingId'].'&';
        $URL = 'URL='.urlencode($final_track_url).'&';        
        $cost = 'price='.($settingdata['ringData']['cost'] ? $settingdata['ringData']['cost'].'&':'&');
        $MetalType = 'MetalType='.($settingdata['ringData']['metalID'] ? $settingdata['ringData']['metalID'].'&':'&');
        $MetalColor = 'MetalColor='.($settingdata['ringData']['colorID'] ? $settingdata['ringData']['colorID'].'&':'&');
        $UsersIPAddress = 'UsersIPAddress='.$this->getRealIpAddr();

		$posturl = str_replace(' ', '+', 'https://platform.jewelcloud.com/ProductTracking.aspx?'.$RetailerID.$VendorID.$GFInventoryID.$URL.$cost.$MetalType.$MetalColor.$UsersIPAddress);
		

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $posturl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = json_decode($responce);

        if (curl_errno($curl)) {
        	echo "error";
        }else{
        	echo "success";
        }
        curl_close($curl);
 	}

 	public function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
	  		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
	  		$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip; 
	}

	public function getringvideos() {
    $productId = $_POST['product_id'];
    $requestUrl = 'http://api.jewelcloud.com/api/jewelry/GetVideoUrl?InventoryID='.$productId.'&Type=Jewelry';
    $curl         = curl_init();
    curl_setopt( $curl, CURLOPT_URL, $requestUrl);
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl, CURLOPT_HEADER, false );
    $response        = curl_exec( $curl );
    $results         = (array) json_decode( $response );
    
    //echo json_encode($results);
    //print_r($results);

    $resultdata = array();
    $resultdata['videoURL'] = $results['videoURL'];
    $resultdata['showVideo'] = $results['showVideo'];
    
    echo json_encode($resultdata);
    exit;
    }

    public function getdiamondvideos() {
    $productId = $_POST['product_id'];
    $requestUrldb = 'http://api.jewelcloud.com/api/jewelry/GetVideoUrl?InventoryID='.$productId.'&Type=Diamond';
    
    $curl         = curl_init();
    curl_setopt( $curl, CURLOPT_URL, $requestUrldb);
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl, CURLOPT_HEADER, false );
    $response        = curl_exec( $curl );
    $resultsdb         = (array) json_decode( $response );
    
    // echo json_encode($resultsdb);
    // print_r($resultsdb);

    $resultdatadb = array();
    $resultdatadb['videoURL'] = $resultsdb['videoURL'];
    $resultdatadb['showVideo'] = $resultsdb['showVideo'];
    
    echo json_encode($resultdatadb);
    exit;
    }

   function getVendorInformation() {


		$settingData = $this->ringbuilder_lib->getRingById($_POST['settingId'], $_POST['shop'], $_POST['islabsettings']);

	    $dealerInfo = $settingData['ringData']['retailerInfo'];

	    $html = '
				    <div class="modal fade dealer-detail-section" id="dealer-detail-section" role="dialog">
				        <div class="modal-dialog">
				            <div class="modal-content">
				                <div class="modal-header">
				                    <button type="button" class="close" data-dismiss="modal">&times;</button>
				                    <h1 class="modal-title">Vendor Information</h1>
				                </div>
				                <div class="modal-body">
				                    <div class="dealer-info-section" id="dealer-info-section">
				                        <table>
				                            <tr>
				                                <td>Dealer Name:</td>
				                                <td>' . ($dealerInfo->retailerName ? $dealerInfo->retailerName : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer Company:</td>
				                                <td>' . ($dealerInfo->retailerCompany ? $dealerInfo->retailerCompany : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer City/State:</td>
				                                <td>' . ($dealerInfo->retailerCity ? $dealerInfo->retailerCity : '') . '/' . ($dealerInfo->retailerState ? $dealerInfo->retailerState : '') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer Contact No.:</td>
				                                <td>' . ($dealerInfo->retailerContactNo ? $dealerInfo->retailerContactNo : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer Email:</td>
				                                <td>' . ($dealerInfo->retailerEmail ? $dealerInfo->retailerEmail : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer Lot number of the item:</td>
				                                <td>' . ($dealerInfo->retailerLotNo ? $dealerInfo->retailerLotNo : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer Stock number of the item:</td>
				                                <td>' . ($dealerInfo->retailerStockNo ? $dealerInfo->retailerStockNo : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Wholesale Price:</td>
				                                <td>' . ($dealerInfo->wholesalePrice ? '$' . number_format($dealerInfo->wholesalePrice) : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Third Party:</td>
				                                <td>' . ($dealerInfo->thirdParty ? $dealerInfo->thirdParty : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Diamond Id:</td>
				                                <td>' . ($dealerInfo->diamondID ? $dealerInfo->diamondID : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Seller Name:</td>
				                                <td>' . ($dealerInfo->sellerName ? $dealerInfo->sellerName : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Seller Address:</td>
				                                <td>' . ($dealerInfo->sellerAddress ? $dealerInfo->sellerAddress : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer Fax:</td>
				                                <td>' . ($dealerInfo->retailerFax ? $dealerInfo->retailerFax : '-') . '</td>
				                            </tr>
				                            <tr>
				                                <td>Dealer Address:</td>
				                                <td>' . ($dealerInfo->retailerAddress ? $dealerInfo->retailerAddress : '-') . '</td>
				                            </tr>
				                        </table>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				';

	    	echo $html;
	}

    // public function storestatus()
    // {
    //     $store_post_data = $this->input->post(NULL, true);
    //     $shop = $store_post_data['shop'];
    //     $status = $this->general_model->getAppStatus($store_post_data['shop']);

    //     if ($status == active) {
    //        echo "true";
    //     }else{
    //         echo "false";
    //     }
    // }
}