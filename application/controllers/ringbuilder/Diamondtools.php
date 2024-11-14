<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diamondtools extends CI_Controller {
	
	function __construct()
	{ 

		parent::__construct();
		
		$this->load->library('diamond_lib');
		$this->load->model('general_model');
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
	
	public function smtp()
	{
		$toemail = $this->input->get('email'); 
		//$toemail = "lawrence.bella0005@gmail.com";
		$this->email->from('noreply@kendana.com', 'ken and dana');
		$this->email->to($toemail);
		$this->email->subject('Checking email RB');
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

	/*
	* View List Diamonds
	*/
	public function index()
	{	
		if ($this->input->post('checkdiamondcookie')) {
            $data['check_diamond_cookie'] = $this->input->post('checkdiamondcookie');
        }
        if ($this->input->post('checkringcookie')) {
            $data['check_ring_cookie'] = $this->input->post('checkringcookie');
        }
		
		$this->load->view('list_diamonds',$data);
	}


	public function loadfilter()
	{	

      header('Access-Control-Allow-Origin: *');

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
		if($this->input->post('ringsetting')){
			$data['ring_setting_cookie_data'] = $this->input->post('ringsetting');
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

		if($this->input->post('checkringcookie')){
			$data['check_ring_cookie_data'] = $this->input->post('checkringcookie');
		}

		$data['diamond_path'] = $this->uri->segment(4);
		//file_put_contents('pathinfolog.txt', json_encode($data));
		$this->load->view('view_diamonds',$data);
	}

	public function loadproduct()
	{	//header('Access-Control-Allow-Origin: *');

		if($this->input->post('checkringcookie')){
			$data['check_ring_cookie_data'] = $this->input->post('checkringcookie');

		}
		/*else
		{
			redirect($this->input->post('final_shop_url')."/settings");
		}*/
		$data['shop'] = $this->input->post('shop');
		$data['pathprefixshop'] = $this->input->post('pathprefixshop');
		$data['diamond_path'] = $this->input->post('diamond_path');
		$data['final_shop_url'] =  $this->input->post('final_shop_url');
		$data['is_lab_settings'] =  $this->input->post('is_lab_settings');
		$data['diamond_type'] =  $this->input->post('diamond_type');
		
		$this->load->view('load_product',$data);
	}

	 public function getStoreSmtp($shop){
        return $this->general_model->getShopSmtp($shop);
    }


	public function diamondsearch()
	{	
		header('Access-Control-Allow-Origin: *');
		 $postData = $this->input->post(NULL, true);

          if($postData['inintfilter'] == '1'){
            $postData['diamond_shape'] = json_decode($postData['shapecookie']);
          }

 		$data = array('filter_data' => $postData);
		//$data = array('filter_data'=>$this->input->post(NULL, true));
		//file_put_contents('diamondsearch.log', json_encode($data));
		$this->load->view('results',$data);

	}

	public function loadnav(){
		$data['check_ring_cookie'] = $this->input->post('checkringcookie');
		$data['final_shop_url'] = $this->input->post('final_shop_url');
		$data['is_lab_settings'] = $this->input->post('is_lab_settings');
		$this->load->view('load_nav_dia',$data);
	}

	public function loadcompare()
	{	
		
		if($this->input->post('comparediamondProductrb')){
			$data['compare_diamond_data'] = $this->input->post('comparediamondProductrb');
			$data['shopurl'] = $this->input->post('shop');
			$data['pathprefixshop'] = $this->input->post('pathprefixshop');
			$data['is_lab_settings'] = $this->input->post('is_lab_settings');
		}
		$this->load->view('load_compare',$data);
	}

	public function diamondtype()
	{	
		$data['request_diamond_type'] = $this->uri->segment(4);
		$this->load->view('list_diamonds',$data);
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
 		// $printData = array('diamond_id'=>$print_post_data['diamondid'],'shop'=>$print_post_data['shop']);
 		$printData = array('diamond_id'=>$print_post_data['diamondid'],'shop'=>$print_post_data['shop'], 'diamondtype'=>$print_post_data['diamondtype']);
 		$this->load->view('print_diamond',$printData);
 	}

 	public function authenticate(){
 		$auth_post_data = $this->input->post(NULL, true);
 		if ($auth_post_data) {
 			$result = $this->diamond_lib->authenticateDealer($auth_post_data['shopurl'],$auth_post_data['password'],$auth_post_data['diamondId'],$auth_post_data['diamondtype']);
			echo $result;
			exit;
        }
 	}

 	public function completering(){
 		$data['shop_data'] = $this->input->get(NULL, true);
		$this->load->view('complete_ring',$data);
 	}

 	public function loadcompletering(){
 		if($this->input->post('ringcookie')){
			$data['ring_cookie_data'] = $this->input->post('ringcookie');
			$data['shopurl'] = $this->input->post('shop');
			$data['pathprefixshop'] = $this->input->post('pathprefixshop');
			$data['final_shop_url'] = $this->input->post('final_shop_url');
			$data['is_lab_settings'] = $this->input->post('is_lab_settings');
		}
		if($this->input->post('diamondcookie')){
			$data['diamond_cookie_data'] = $this->input->post('diamondcookie');
		}
		$this->load->view('load_complete_ring',$data);
 	}

 	public function completepurchase(){
 		$this->load->library('user_agent');
 		$shop_data = $this->input->get(NULL, true);
 		$complete_ring_meta = $this->input->post(NULL, true);

 		// echo "<pre>";
   //      print_r($complete_ring_meta['stylenumber']);
   //      exit();

 		$ring_view_url = $complete_ring_meta['ringpath'];
 		$ring_view_url = str_replace('&', '%26', $ring_view_url);

 		$diamond_view_url = $complete_ring_meta['diamondpath'];

 		$diamond_id = $this->uri->segment(4);
 		$setting_id = $this->uri->segment(5);
 		$lab_diamond_type = $this->uri->segment(6);

 		if($lab_diamond_type == "labcreated"){
 			$lab_diamond_type = "labcreated";
 		}elseif($lab_diamond_type == "fancydiamonds"){
 			$lab_diamond_type = "fancydiamonds";
 		}else{
 			$lab_diamond_type = "";
 		}

 		$setting_options = $this->input->post(NULL, true);
 		
 		if (!$diamond_id || !$setting_id) {
            redirect($this->agent->referrer().'/invalid');
        }
        try{

        	$diamondData = $this->diamond_lib->getDiamondById($diamond_id,$lab_diamond_type,$shop_data['shop']);
        	$settingData = $this->diamond_lib->getRingById($setting_id,$shop_data['shop']);

        	$access_token = $this->diamond_lib->getShopAccessToken($shop_data['shop']);
        	$api_version = $this->config->item('shopify_api_version');
        	$shop_base_url = "https://".$shop_data['shop'];
        	$get_product_endpoint_rb = "/admin/api/".$api_version."/products.json?vendor=GemFindRB";
        	$get_product_endpoint = "/admin/api/".$api_version."/products.json?vendor=GemFind";
        	$add_product_endpoint = "/admin/api/".$api_version."/products.json";
        	$get_locations_endpoint = "/admin/api/".$api_version."/locations.json";
        	$update_inventory_endpoint = "/admin/api/".$api_version."/inventory_levels/set.json";
        	$get_cart_endpoint = "/cart.json";

        	$getProductLocationUrl = $shop_base_url.$get_locations_endpoint;
        	$updateInvUrl = $shop_base_url.$update_inventory_endpoint;
        	$getProductRequestUrlRB = $shop_base_url.$get_product_endpoint_rb;
        	$getProductRequestUrl = $shop_base_url.$get_product_endpoint;
        	$addProductRequestUrl = $shop_base_url.$add_product_endpoint;
        	$getCartRequestUrl = $shop_base_url.$get_cart_endpoint;
        	
        	$request_headers = array(
                    "X-Shopify-Access-Token:" . $access_token,
                    "Content-Type:application/json"
                );
			
			$resultProductsRB = getCurlData($getProductRequestUrlRB,$request_headers);
			$resultProducts = getCurlData($getProductRequestUrl,$request_headers);

			/*echo "<pre>";
			print_r($resultProductsRB);
			exit;*/

	        foreach ($resultProducts->products as $main_key => $main_value) {
	        	foreach ($main_value->variants as $var_key => $var_value) {
		        	if($var_value->sku == $diamond_id){
		        		$in_shopify = true;
		        		$product_add = $var_value->id;
		        		$prod_id = $main_value->id;
		        		$inventory_item_id = $var_value->inventory_item_id;
		        	}
	        	}
	        }

	        foreach ($resultProductsRB->products as $rmain_key => $rmain_value) {
	        	foreach ($rmain_value->variants as $rvar_key => $rvar_value) {
		        	if($rvar_value->sku == $setting_id){
		        		$ring_in_shopify = true;
		        		$ring_id_exist = $rvar_value->id;
		        		$product_ring_id = $rmain_value->id;
		        		$rinventory_item_id = $rvar_value->inventory_item_id;
		        	}
	        	}
	        }

	        $resultLocation = getCurlData($getProductLocationUrl,$request_headers);
	        $location_id = $resultLocation->locations[0]->id;

	        if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
        		$location_id = $resultLocation->locations[1]->id;
        		// echo 'one'; echo "<pre>"; print_r($resultLocation); exit();
        	}

		

			// echo $domain; // Outputs: https://nelsoncoleman.com
			// exit;

			// if ($shop_data['shop'] == 'nelsoncoleman.myshopify.com') {
        	// 	$shop_base_url = 'https://nelsoncoleman.com';
        	// 	// echo 'one'; echo "<pre>"; print_r($resultLocation); exit();
        	// }
	        
	        if($in_shopify){

	        	$option_name = $diamondData['diamondData']['mainHeader']." | StockNumber : ".$diamondData['diamondData']['stockNumber']." | Shape : ".$diamondData['diamondData']['shape']." | CaratWeight : ".$diamondData['diamondData']['caratWeight']." | Cut : ".$diamondData['diamondData']['cut']." | Color : ".$diamondData['diamondData']['color']." | Clarity : ".$diamondData['diamondData']['clarity'];

	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultInvUpdate); exit();
        		// }

	        	$update_pricing_endpoint = "/admin/api/".$api_version."/products/".$prod_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;

	        	$pricing_post_data = '{"product": {"id":'.$prod_id.',"variants": [{"id": '.$product_add.',"price": "'.number_format($diamondData['diamondData']['fltPrice']).'","option1":"'.$option_name.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultPricing); exit();
        		// }

	        	$chekcout_url = $shop_base_url."/cart/add?id=".$product_add."&quantity=1";
	        	$diamond_id_exist = $product_add;

        	}else{

        		$option_name = $diamondData['diamondData']['mainHeader']." | StockNumber : ".$diamondData['diamondData']['stockNumber']." | Shape : ".$diamondData['diamondData']['shape']." | CaratWeight : ".$diamondData['diamondData']['caratWeight']." | Cut : ".$diamondData['diamondData']['cut']." | Color : ".$diamondData['diamondData']['color']." | Clarity : ".$diamondData['diamondData']['clarity'];

        		$productTitle = $diamondData['diamondData']['mainHeader'];
        		$productDesc = $diamondData['diamondData']['subHeader'];
        		$productVendor = "GemFindRB";
        		$productType = "GemFindDiamond";
        		$productImage = $diamondData['diamondData']['image2'];
        		$productPrice = number_format($diamondData['diamondData']['fltPrice']);
        		$optionName = $option_name;

        		
        		$product_add_post_data = '{
				  "product": {
				    "title": "'.$productTitle.'",
				    "body_html": "'.$productDesc.'",
				    "vendor": "'.$productVendor.'",
				    "product_type": "'.$productType.'",
					"published_scope" : "web",
				    "tags": "GemfindDiamond",
				    "images": [
				       {
				        "src": "'.$productImage.'"
				      }
				    ],
				    "sales_channels": ["online"]				    
				  }
				}';

				// create product in shopify
	        	$resultProd = postCurlData($addProductRequestUrl,$request_headers,$product_add_post_data,"POST"); 

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultProd); exit();
        		// }

	        	$product_id = $resultProd->product->id;
	        	$variants_id = $resultProd->product->variants['0']->id;
	        	$inventory_item_id = $resultProd->product->variants['0']->inventory_item_id;

	        	// update SKU and stock management in created product
	        	$sku_stock_manage_endpoint = "/admin/api/".$api_version."/inventory_items/".$inventory_item_id.".json";
	        	$skuStockUpdateUrl = $shop_base_url.$sku_stock_manage_endpoint;
	        	$skuAndStockMangePostData = '{"inventory_item": {"id": '.$inventory_item_id.',"sku": '.$diamond_id.',"tracked" : true}}';
	        	$resultSkuStockUpdate = postCurlData($skuStockUpdateUrl,$request_headers,$skuAndStockMangePostData,"PUT");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultSkuStockUpdate); exit();
        		// }

	        	//update inventory in created product
	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultInvUpdate); exit();
        		// }

	        	//update pricing stuff in created product
	        	$update_pricing_endpoint = "/admin/api/".$api_version."/products/".$product_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;
	        	$pricing_post_data = '{"product": {"id":'.$product_id.',"variants": [{"id": '.$variants_id.',"price": "'.$productPrice.'","option1":"'.$optionName.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultPricing); exit();
        		// }

	        	$new_diamond_id = $variants_id;
	        	// product add to cart
	        	/*"newcarturl-".$chekcout_url = $shop_base_url."/cart/add?id=".$variants_id."&quantity=1";*/
	        	//redirect($chekcout_url);
	        	
        	}
        	if($ring_in_shopify){
        		if($complete_ring_meta['sidestonequalityvalue']){
        			$roption_name = $settingData['ringData']['settingName'] . " | " . "Ring Size : ". $complete_ring_meta['ringsizesettingonly']." | Metal Type : ".$complete_ring_meta['metaltype']." | Side Stone  : ".$complete_ring_meta['sidestonequalityvalue']." | Center Stone :  ".$complete_ring_meta['centerstonesizevalue']." | StyleNumber : ".$complete_ring_meta['stylenumber'];
        		}else{
        			$roption_name = $settingData['ringData']['settingName'] . " | " . "Ring Size : ". $complete_ring_meta['ringsizesettingonly']." | Metal type : ".$complete_ring_meta['metaltype']." | Center Stone  : ".$complete_ring_meta['centerstonesizevalue']." | StyleNumber : ".$complete_ring_meta['stylenumber'];
        		}

        		$rinv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$rinventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$rinv_post_data,"POST");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultInvUpdate); exit();
        		// }

	        	$update_pricing_endpoint = "/admin/api/".$api_version."/products/".$product_ring_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;
	        	// $ringprice = number_format($settingData['ringData']['cost']);
				$ringprice = number_format((float)str_replace( ',', '', $settingData['ringData']['cost']), 2, '.', '');
	        	$pricing_post_data = '{"product": {"id":'.$product_ring_id.',"variants": [{"id": '.$ring_id_exist.',"price": "'.$ringprice.'","option1":"'.$roption_name.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultPricing); exit();
        		// }

	        	$ring_id_exist = $ring_id_exist;

        	}else{

        		if($complete_ring_meta['sidestonequalityvalue']){
        			$roption_name = $settingData['ringData']['settingName'] . " | " . "Ring Size : ". $complete_ring_meta['ringsizesettingonly']." | Metal Type : ".$complete_ring_meta['metaltype']." | Side Stone  : ".$complete_ring_meta['sidestonequalityvalue']." | Center Stone :  ".$complete_ring_meta['centerstonesizevalue']." | StyleNumber : ".$complete_ring_meta['stylenumber'];
        		}else{
        			$roption_name = $settingData['ringData']['settingName'] . " | " . "Ring Size : ". $complete_ring_meta['ringsizesettingonly']." | Metal Type : ".$complete_ring_meta['metaltype']." | Center Stone  : ".$complete_ring_meta['centerstonesizevalue']." | StyleNumber : ".$complete_ring_meta['stylenumber'];
        		}

        		$rproductTitle = $settingData['ringData']['settingName'];
        		$rproductDesc = $settingData['ringData']['description'];
        		$rproductVendor = "GemFindRB";
        		$rproductType = "GemFindRing";
        		$rproductImage = $settingData['ringData']['imageUrl'];
        		//$rproductPrice = number_format($settingData['ringData']['cost']);
				$ringprice = number_format((float)str_replace( ',', '', $settingData['ringData']['cost']), 2, '.', '');
        		$roptionName = $roption_name;

        		$path_info = pathinfo($this->agent->referrer());
        		
        		$product_add_post_data = '{
				  "product": {
				    "title": "'.$rproductTitle.'",
				    "body_html": "",
				    "vendor": "'.$rproductVendor.'",
				    "product_type": "'.$rproductType.'",
					"published_scope" : "web",
				    "tags": "GemfindRing",
				    "images": [
				       {
				        "src": "'.$rproductImage.'"
				      }
				    ],
				    "sales_channels": ["online"]				    
				  }
				}';

				// create product in shopify
	        	$resultProd = postCurlData($addProductRequestUrl,$request_headers,$product_add_post_data,"POST"); 

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultProd); exit();
        		// }

	        	$rproduct_id = $resultProd->product->id;
	        	$rvariants_id = $resultProd->product->variants['0']->id;
	        	$rinventory_item_id = $resultProd->product->variants['0']->inventory_item_id;

	        	// update SKU and stock management in created product
	        	$sku_stock_manage_endpoint = "/admin/api/".$api_version."/inventory_items/".$rinventory_item_id.".json";
	        	$skuStockUpdateUrl = $shop_base_url.$sku_stock_manage_endpoint;
	        	$skuAndStockMangePostData = '{"inventory_item": {"id": '.$rinventory_item_id.',"sku": '.$setting_id.',"tracked" : true}}';
	        	$resultSkuStockUpdate = postCurlData($skuStockUpdateUrl,$request_headers,$skuAndStockMangePostData,"PUT");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultSkuStockUpdate); exit();
        		// }

	        	//update inventory in created product
	        	$rinv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$rinventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$rinv_post_data,"POST");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultInvUpdate); exit();
        		// }

	        	//update pricing stuff in created product
	        	$update_pricing_endpoint = "/admin/api/".$api_version."/products/".$rproduct_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;
	        	$pricing_post_data = '{"product": {"id":'.$rproduct_id.',"variants": [{"id": '.$rvariants_id.',"price": "'.$ringprice.'","option1":"'.$roptionName.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");

	        	// if ($shop_data['shop'] == 'earthena-jewelry.myshopify.com') {
	        		
	        	// 	 echo "<pre>"; print_r($resultPricing); exit();
        		// }

	        	$new_ring_id = $rvariants_id;

	        	// product add to cart
	        	//$chekcout_url = $shop_base_url."/cart/add?id=".$variants_id."&quantity=1";
        	}

				// Get the HTTP referer
				$referer = $_SERVER['HTTP_REFERER'] ?? '';

				// Parse the URL to extract only the scheme and host
				$parsedUrl = parse_url($referer);
				$shop_base_url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
				
	        if($in_shopify && $ring_in_shopify){
	        	//echo 'one';
	        	$chekcout_url = $shop_base_url."/cart/add?id[]=".$diamond_id_exist."&id[]=".$ring_id_exist;
	        	redirect($chekcout_url);
	        	exit;
	        }
	        if(!$in_shopify && $ring_in_shopify){
	        	//echo 'two';
	        	$chekcout_url = $shop_base_url."/cart/add?id[]=".$new_diamond_id."&id[]=".$ring_id_exist;
	        	redirect($chekcout_url);
	        	exit;
	        }
	        if($in_shopify && !$ring_in_shopify){
	        	//echo 'three';
	        	$chekcout_url = $shop_base_url."/cart/add?id[]=".$diamond_id_exist."&id[]=".$new_ring_id;
	        	redirect($chekcout_url);
	        	exit;
	        }
	        if(!$in_shopify && !$ring_in_shopify){
	        	//echo 'four';
	        	// echo 'diamond'.$new_diamond_id;
	        	// echo 'ring'.$new_ring_id;
	        	$chekcout_url = $shop_base_url."/cart/add?id[]=".$new_diamond_id."&id[]=".$new_ring_id;
	        	redirect($chekcout_url);
	        	exit;
	        }
        } catch (Exception $e) {
			redirect($this->agent->referrer().'/error');
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

		// echo "<pre>";
	 //    print_r($response);
	 //    exit();

		return $response;

		// Close cURL session
		curl_close($ch);
 	}

 	public function resultdrophint(){
 		$hint_post_data = $this->input->post(NULL, true);

 		  if(isset($hint_post_data['captcha-response-four']) && !empty($hint_post_data['captcha-response-four'])){      
		        $data = array(
		             'secret' => $hint_post_data['secret-key'],
		            'response' => $hint_post_data['captcha-response-four']
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

 		if(empty($hint_post_data['diamondid'])){
 			$message = 'Plase Enter Diamondid.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['shopurl'])){
 			$message = 'Plase Enter shopurl.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['name'])){
 			$message = 'Plase Enter Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['email'])){
 			$message = 'Plase Enter Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['recipient_name'])){
 			$message = 'Plase Enter recipient Name.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['recipient_email'])){
 			$message = 'Plase Enter recipient Email.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['gift_reason'])){
 			$message = 'Plase Enter Gift Reason.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['hint_message'])){
 			$message = 'Plase Enter Hint Message.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}

 		if(empty($hint_post_data['gift_deadline'])){
 			$message = 'Plase Enter Gift Deadline.';
				$data = array('status' => 2, 'msg' => $message );
                $result = json_encode(array('output' => $data));
                echo $result;
                exit;
 		}


 		$shopurl = "https://".$hint_post_data['shopurl'];
 		$store_detail = $this->getStoreName($hint_post_data['shopurl']);
 		$store_logo = $this->general_model->getStoreLogo($hint_post_data['shopurl']);
 		$store_logo = ( $store_logo ? $store_logo :  base_url()."assets/images/no-logo.png");
 		if($hint_post_data){
 			try {
                $diamondData = $this->diamond_lib->getDiamondById($hint_post_data['diamondid'], $hint_post_data['diamondtype'], $hint_post_data['shopurl']);
                
                $storeAdminEmail =  $this->diamond_lib->getAdminEmail($hint_post_data['shopurl']); 
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);

                $templateVars = array(
                    'retailername' => $retailername,
                    'retailerphone' => $diamondData['diamondData']['retailerInfo']->retailerContactNo,
                    'name' => $hint_post_data['name'],
                    'email' => $hint_post_data['email'],
                    'recipient_name' => $hint_post_data['recipient_name'],
                    'recipient_email' => $hint_post_data['recipient_email'],
                    'gift_reason' => $hint_post_data['gift_reason'],
                    'hint_message' => $hint_post_data['hint_message'],
                    'gift_deadline' => $hint_post_data['gift_deadline'],
                    'diamond_url' => $hint_post_data['diamondurl'],
                );

                // Sender email
                $transport_sender_template = $this->load->view('emails/hint_email_template_sender.html','',true);                
                $senderValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $hint_post_data['name'],
					'{{email}}' => $hint_post_data['email'],
					'{{recipient_name}}' => $hint_post_data['recipient_name'],
					'{{recipient_email}}' => $hint_post_data['recipient_email'],
					'{{gift_reason}}' => $hint_post_data['gift_reason'],
					'{{gift_deadline}}' => $hint_post_data['gift_deadline'],
					'{{hint_message}}' => $hint_post_data['hint_message'],
					'{{diamond_url}}' => $hint_post_data['diamondurl'],
					'{{retailerphone}}' => $diamondData['diamondData']['vendorContactNo'],
					'{{retaileremail}}' => $diamondData['diamondData']['vendorEmail'],
				);
				$sender_email_body = str_replace(array_keys($senderValueReplacement), array_values($senderValueReplacement), $transport_sender_template);	
				$sender_subject = "Someone Wants To Drop You A Hint";
				$senderFromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$senderToEmail = $hint_post_data['email'];

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

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
				$this->email->to($senderToEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();

                // Receiver email
                $transport_receiver_template = $this->load->view('emails/hint_email_template_receiver.html','',true);                
                $receiverValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $hint_post_data['name'],
					'{{recipient_name}}' => $hint_post_data['recipient_name'],
					'{{gift_reason}}' => $hint_post_data['gift_reason'],
					'{{gift_deadline}}' => $hint_post_data['gift_deadline'],
					'{{hint_message}}' => $hint_post_data['hint_message'],
					'{{diamond_url}}' => $hint_post_data['diamondurl'],
					'{{retailerphone}}' => $diamondData['diamondData']['vendorContactNo'],
					'{{retaileremail}}' => $diamondData['diamondData']['vendorEmail'],
				);
				$receiver_email_body = str_replace(array_keys($receiverValueReplacement), array_values($receiverValueReplacement), $transport_receiver_template);	
				$receiver_subject = "Someone Wants To Drop You A Hint";
				$receiver_fromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$receiver_toEmail = $hint_post_data['recipient_email'];

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
				$this->email->to($receiver_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($receiver_subject);
				$this->email->message($receiver_email_body);
				$this->email->send();

				// Retailer email
                $transport_retailer_template = $this->load->view('emails/hint_email_template_retailer.html','',true);                
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
					'{{diamond_url}}' => $hint_post_data['diamondurl'],
					'{{recipient_email}}' => $hint_post_data['recipient_email'],
					'{{retaileremail}}' => $diamondData['diamondData']['vendorEmail'],
				);
				$retailer_email_body = str_replace(array_keys($retailerValueReplacement), array_values($retailerValueReplacement), $transport_retailer_template);	
				$retailer_subject = "Someone Wants To Drop You A Hint";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($hint_post_data['shopurl']); 
				$retailer_toEmail = $retaileremail;

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
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
                    'SID' =>  '',
                    'DID' => $hint_post_data['diamondid'] ? $hint_post_data['diamondid'] : '',
                    'Shape' => $diamondData['diamondData']['shape'] ? $diamondData['diamondData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $diamondData['diamondData']['fltPrice'] ? $diamondData['diamondData']['fltPrice'] : '',
                );

               $this->getFormTrackingCurl($postUrl,$formdata);

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

 			if(isset($email_friend_post_data['captcha-response-six']) && !empty($email_friend_post_data['captcha-response-six'])){      
		        $data = array(
		            'secret' => $email_friend_post_data['secret-key'],
		            'response' => $email_friend_post_data['captcha-response-six']
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

 		if(empty($email_friend_post_data['diamondid'])){
 			$message = 'Please Enter Diamondid.';
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
 		$store_logo = ( $store_logo ? $store_logo :  base_url()."assets/images/no-logo.png");
 		$jc_options = $this->diamond_lib->getJCOptions($email_friend_post_data['shopurl']);
 		if($email_friend_post_data){
 			try {
                $diamondData = $this->diamond_lib->getDiamondById($email_friend_post_data['diamondid'], $email_friend_post_data['diamondtype'], $email_friend_post_data['shopurl']);
                
                $storeAdminEmail =  $this->diamond_lib->getAdminEmail($email_friend_post_data['shopurl']);
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);
            	if($diamondData['diamondData']['fancyColorMainBody']){
	                 $color_to_display = $diamondData['diamondData']['fancyColorIntensity'].' '.$diamondData['diamondData']['fancyColorMainBody'];
	              }elseif($diamondData['diamondData']['color'] != '') { 
	                 $color_to_display = $diamondData['diamondData']['color']; 
	              } else { 
	                 $color_to_display = 'NA'; 
	              }
                $templateVars = array(
                    'name' => $email_friend_post_data['name'],
                    'email' => $email_friend_post_data['email'],
                    'friend_name' => $email_friend_post_data['friend_name'],
                    'friend_email' => $email_friend_post_data['friend_email'],
                    'message' => $email_friend_post_data['message'],
                    'diamond_url' => (isset($email_friend_post_data['diamondurl'])) ? $email_friend_post_data['diamondurl'] : '',
                    'diamond_id' => (isset($diamondData['diamondData']['diamondId'])) ? $diamondData['diamondData']['diamondId']: '',
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
                    'wholeSalePrice' => (isset($diamondData['diamondData']['wholeSalePrice'])) ? number_format($diamondData['diamondData']['wholeSalePrice']) : '',
                    'vendorAddress' => (isset($diamondData['diamondData']['vendorAddress'])) ? $diamondData['diamondData']['vendorAddress'] : '',
                    'retailerName' => (isset($diamondData['diamondData']['retailerInfo']->retailerName)) ? $diamondData['diamondData']['retailerInfo']->retailerName : '',
                    'retailerID' => (isset($diamondData['diamondData']['retailerInfo']->retailerID)) ? $diamondData['diamondData']['retailerInfo']->retailerID : '',
                    'retailerEmail' => (isset($diamondData['diamondData']['retailerInfo']->retailerEmail)) ? $diamondData['diamondData']['retailerInfo']->retailerEmail : '',
                    'retailerContactNo' => (isset($diamondData['diamondData']['retailerInfo']->retailerContactNo)) ? $diamondData['diamondData']['retailerInfo']->retailerContactNo : '',
                    'retailerStockNo' => (isset($diamondData['diamondData']['retailerInfo']->retailerStockNo)) ? $diamondData['diamondData']['retailerInfo']->retailerStockNo : '',
                    'retailerFax' => (isset($diamondData['diamondData']['retailerInfo']->retailerFax)) ? $diamondData['diamondData']['retailerInfo']->retailerFax : '',
                    'retailerAddress' => (isset($diamondData['diamondData']['retailerInfo']->retailerAddress)) ? $diamondData['diamondData']['retailerInfo']->retailerAddress : '',
                    'wholeSaleP' => (isset($diamondData['diamondData']['retailerInfo']->wholesalePrice)) ? number_format($diamondData['diamondData']['retailerInfo']->wholesalePrice) : '',
                );

				if($diamondData['diamondData']['currencyFrom'] == 'USD'){
                  $currency_symbol = "$";    
                }else{
                  $currency_symbol = $diamondData['diamondData']['currencyFrom'].$diamondData['diamondData']['currencySymbol']; 
                }

                if($jc_options['jc_options']->show_Certificate_in_Diamond_Search) {
                	$certificate_html  = '<tr><td class="consumer-title">Lab:</td><td class="consumer-name">'.$templateVars['certificateNo'].' <a href="'.$templateVars['certificateUrl'].'">GIA Certificate</a></td></tr>';
                }else{
                	$certificate_html  = '';
                }

                $templateValueReplacement = array(
					'{{shopurl}}' => $shopurl, 
					'{{shop_logo}}' => $store_logo,
					'{{shop_logo_alt}}' => $store_detail->shop->name,
					'{{name}}' => $templateVars['name'],
					'{{email}}' => $templateVars['email'],
					'{{friend_name}}' => $templateVars['friend_name'],
					'{{friend_email}}' => $templateVars['friend_email'],
					'{{message}}' => $templateVars['message'],
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
					'{{price}}' => $currency_symbol.$templateVars['price'],
					'{{wholeSalePrice}}' => $currency_symbol.$templateVars['wholeSalePrice'],
					'{{vendorName}}' => $templateVars['vendorName'],
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
					'{{wholeSaleP}}' => $currency_symbol.$templateVars['wholeSaleP'],
					'{{retailerNameT}}' => $templateVars['retailerName'],

				);


                // Sender email
                $transport_sender_template = $this->load->view('emails/email_friend_email_template_sender.html','',true);                
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

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
				$this->email->to($senderToEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($sender_subject);
				$this->email->message($sender_email_body);
				$this->email->send();

                // Receiver email
                $transport_receiver_template = $this->load->view('emails/email_friend_email_template_receiver.html','',true);                
				$receiver_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_receiver_template);	
				$receiver_subject = "A Friend Wants To Share With You";
				$receiver_fromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$receiver_toEmail = $email_friend_post_data['friend_email'];

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
				$this->email->to($receiver_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($receiver_subject);
				$this->email->message($receiver_email_body);
				$this->email->send();

				// Retailer email
                $transport_retailer_template = $this->load->view('emails/email_friend_email_template_retailer.html','',true);                
				$retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);	
				$retailer_subject = "A Friend Wants To Share With You";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($email_friend_post_data['shopurl']); 
				$retailer_toEmail = $retaileremail;

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
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
                    'SID' =>  '',
                    'DID' => $email_friend_post_data['diamondid'] ? $email_friend_post_data['diamondid'] : '',
                    'Shape' => $diamondData['diamondData']['shape'] ? $diamondData['diamondData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $diamondData['diamondData']['fltPrice'] ? $diamondData['diamondData']['fltPrice'] : '',
                );

                // echo "<pre>";
                // print_r($formdata);
                // exit();

                $this->getFormTrackingCurl($postUrl,$formdata);

               
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

 		if(isset($sch_view_post_data['captcha-response-seven']) && !empty($sch_view_post_data['captcha-response-seven'])){      
		        $data = array(
		            'secret' => $sch_view_post_data['secret-key'],
		            'response' => $sch_view_post_data['captcha-response-seven']
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
 		if(empty($sch_view_post_data['diamondid'])){
 			$message = 'Please Enter Diamondid.';
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
 		$store_logo = ( $store_logo ? $store_logo :  base_url()."assets/images/no-logo.png");
 		$jc_options = $this->diamond_lib->getJCOptions($sch_view_post_data['shopurl']);
 		if($sch_view_post_data){
 			try {
                $diamondData = $this->diamond_lib->getDiamondById($sch_view_post_data['diamondid'], $sch_view_post_data['diamondtype'], $sch_view_post_data['shopurl']);

                $storeAdminEmail =  $this->diamond_lib->getAdminEmail($sch_view_post_data['shopurl']);
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);
                if($diamondData['diamondData']['fancyColorMainBody']){
	                $color_to_display = $diamondData['diamondData']['fancyColorIntensity'].' '.$diamondData['diamondData']['fancyColorMainBody'];
	            }elseif($diamondData['diamondData']['color'] != '') { 
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
                    'diamond_id' => (isset($diamondData['diamondData']['diamondId'])) ? $diamondData['diamondData']['diamondId']: '',
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
                );
				
				if($diamondData['diamondData']['currencyFrom'] == 'USD'){
                  $currency_symbol = "$";    
                }else{
                  $currency_symbol = $diamondData['diamondData']['currencyFrom'].$diamondData['diamondData']['currencySymbol']; 
                }

                if($jc_options['jc_options']->show_Certificate_in_Diamond_Search) {
                	$certificate_html  = '<tr><td class="consumer-title">Lab:</td><td class="consumer-name">'.$templateVars['certificateNo'].' <a href="'.$templateVars['certificateUrl'].'">GIA Certificate</a></td></tr>';
                }else{
                	$certificate_html  = '';
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
					'{{price}}' => $currency_symbol.$templateVars['price'],
					'{{retailerName}}' => $retailername,
					'{{retailerEmail}}' => $templateVars['retailerEmail'],
					'{{retailerContactNo}}' => $templateVars['retailerContactNo'],
					'{{retailerFax}}' => $templateVars['retailerFax'],
					'{{retailerAddress}}' => $templateVars['retailerAddress'],

				);

				// Retailer email
                $transport_retailer_template = $this->load->view('emails/schedule_view_email_template_admin.html','',true);                
				$retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);	
				$retailer_subject = "Request To Schedule A Viewing";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($sch_view_post_data['shopurl']); 
				$retailer_toEmail = $retaileremail;

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

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();
				
				// Sender email
                $transport_sender_template = $this->load->view('emails/ringschedule_email_template_sender.html','',true);                
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
                    'SID' =>  '',
                    'DID' => $sch_view_post_data['diamondid'] ? $sch_view_post_data['diamondid'] : '',
                    'Shape' => $diamondData['diamondData']['shape'] ? $diamondData['diamondData']['shape'] : '',
                    'CTW' => '',
                    'QueryString' => '',
                    'Price' => $diamondData['diamondData']['fltPrice'] ? $diamondData['diamondData']['fltPrice'] : '',
                );

                $this->getFormTrackingCurl($postUrl,$formdata);
               
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

 		if(isset($req_post_data['captcha-response-five']) && !empty($req_post_data['captcha-response-five'])){      
		        $data = array(
		            'secret' => $req_post_data['secret-key'],
		            'response' => $req_post_data['captcha-response-five']
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

 		if(empty($req_post_data['diamondid'])){
 			$message = 'Please Enter Diamond Id.';
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
 		$store_logo = ( $store_logo ? $store_logo :  base_url()."assets/images/no-logo.png");
 		$jc_options = $this->diamond_lib->getJCOptions($req_post_data['shopurl']);
 		if($req_post_data){
 			try {
                $diamondData = $this->diamond_lib->getDiamondById($req_post_data['diamondid'],$req_post_data['diamondtype'], $req_post_data['shopurl']);
                
                $storeAdminEmail =  $this->diamond_lib->getAdminEmail($req_post_data['shopurl']);
                $retaileremail = ( $storeAdminEmail ? $storeAdminEmail : $diamondData['diamondData']['vendorEmail']);
                $retailername = ($diamondData['diamondData']['vendorName'] ? $diamondData['diamondData']['vendorName'] : $store_detail->shop->name);
                if($diamondData['diamondData']['fancyColorMainBody']){
	                $color_to_display = $diamondData['diamondData']['fancyColorIntensity'].' '.$diamondData['diamondData']['fancyColorMainBody'];
	            }elseif($diamondData['diamondData']['color'] != '') { 
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
                    'diamond_id' => (isset($diamondData['diamondData']['diamondId'])) ? $diamondData['diamondData']['diamondId']: '',
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
                );
				
				if($diamondData['diamondData']['currencyFrom'] == 'USD'){
                  $currency_symbol = "$";    
                }else{
                  $currency_symbol = $diamondData['diamondData']['currencyFrom'].$diamondData['diamondData']['currencySymbol']; 
                }

                if($jc_options['jc_options']->show_Certificate_in_Diamond_Search) {
                	$certificate_html  = '<tr><td class="consumer-title">Lab:</td><td class="consumer-name">'.$templateVars['certificateNo'].' <a href="'.$templateVars['certificateUrl'].'">GIA Certificate</a></td></tr>';
                }else{
                	$certificate_html  = '';
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
					'{{price}}' => $currency_symbol.$templateVars['price'],
					'{{wholeSalePrice}}' => $currency_symbol.$templateVars['wholeSalePrice'],
					'{{vendorName}}' => $retailername,
					'{{vendorStockNo}}' => $templateVars['vendorStockNo'],
					'{{vendorEmail}}' => $templateVars['vendorEmail'],
					'{{vendorContactNo}}' => $templateVars['vendorContactNo'],
					'{{vendorFax}}' => $templateVars['vendorFax'],
					'{{vendorAddress}}' => $templateVars['vendorAddress'],
					'{{retailerName}}' =>  $templateVars['retailerName'],
					'{{retailerEmail}}' => $templateVars['retailerEmail'],
					'{{retailerContactNo}}' => $templateVars['retailerContactNo'],
					'{{retailerStockNo}}' => $templateVars['retailerStockNo'],
					'{{retailerFax}}' => $templateVars['retailerFax'],
					'{{retailerAddress}}' => $templateVars['retailerAddress'],

				);

				// Retailer email
                $transport_retailer_template = $this->load->view('emails/info_email_template_retailer.html','',true);                
				$retailer_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_retailer_template);	
				$retailer_subject = "Request For More Info";
				$retailer_fromAddress = $this->diamond_lib->getEmailSender($req_post_data['shopurl']); 
				$retailer_toEmail = $retaileremail;

				//NEED TO GET DATA FROM DATABASE HERE
                $store_detail = $this->getStoreSmtp($req_post_data['shopurl']);
                
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
               $file = 'data_log.txt';
               file_put_contents($file, $config);
               //END FOR DATABASE QUERY

			   
				
				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
				$this->email->to($retailer_toEmail);
				$this->email->reply_to($senderFromAddress,$store_detail->shop->name);
				$this->email->subject($retailer_subject);
				$this->email->message($retailer_email_body);
				$this->email->send();

				// Sender email
                $transport_sender_template = $this->load->view('emails/info_email_template_sender.html','',true);                
				$sender_email_body = str_replace(array_keys($templateValueReplacement), array_values($templateValueReplacement), $transport_sender_template);	
				$sender_subject = "Request For More Info";
				$sender_fromAddress = $this->diamond_lib->getEmailSender($req_post_data['shopurl']); 
				$sender_toEmail = $req_post_data['email'];

				$this->email->from('smtp@gemfind.com', $store_detail->shop->name);
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
                    'Preference' => $req_post_data['contact_pref'] ? $req_post_data['contact_pref'] : '', 
                    'DID' => $req_post_data['diamondid'] ? $req_post_data['diamondid'] : '',                  
                );

                $this->getFormTrackingCurl($postUrl,$formdata);
                //echo $res; exit();
               
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
 		$diamond_id = $this->uri->segment(4);
 		$type = $this->uri->segment(5);
        // echo '<pre>';print_r($type);exit;

 		if($type == "labcreated"){
 			$type = "labcreated";
 		}elseif($type == "fancydiamonds"){
 			$type = "fancydiamonds";
 		}else{
 			$type = "";
 		}

 		if (!$diamond_id) {
            redirect($this->agent->referrer().'/invalid');
        }
        try{
        	$diamondData = $this->diamond_lib->getDiamondById($diamond_id,$type,$shop_data['shop']);
        	$access_token = $this->diamond_lib->getShopAccessToken($shop_data['shop']);
		        		// echo '<pre>';print_r($access_token);exit;
        	$shop_base_url = "https://".$shop_data['shop'];
        	$api_version = $this->config->item('shopify_api_version');
        	$get_product_endpoint = "/admin/api/".$api_version."/products.json";
        	$add_product_endpoint = "/admin/api/".$api_version."/products.json";
        	$get_locations_endpoint = "/admin/api/".$api_version."/locations.json";
        	$update_inventory_endpoint = "/admin/api/".$api_version."/inventory_levels/set.json";
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
		        		// echo 'test';exit;
		        		$in_shopify = true;
		        		$product_add = $var_value->id;
		        		// echo '<pre>';print_r($product_add);
		        		$prod_id = $main_value->id;
		        		$inventory_item_id = $var_value->inventory_item_id;
		        	}
	        	}
	        }
	        // exit;
	        $resultLocation = getCurlData($getProductLocationUrl,$request_headers);
	        $location_id = $resultLocation->locations[0]->id;
	        
	        if($in_shopify){

	        	$option_name = $diamondData['diamondData']['mainHeader']." | StockNumber : ".$diamondData['diamondData']['stockNumber']." | Shape : ".$diamondData['diamondData']['shape']." | CaratWeight : ".$diamondData['diamondData']['caratWeight']." | Cut : ".$diamondData['diamondData']['cut']." | Color : ".$diamondData['diamondData']['color']." | Clarity : ".$diamondData['diamondData']['clarity'];

	        	//update qty for existing product
	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");

	        	//update pricing in existing product
	        	$update_pricing_endpoint = "/admin/api/".$api_version."/products/".$prod_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;
	        	$pricing_post_data = '{"product": {"id":'.$prod_id.',"variants": [{"id": '.$product_add.',"price": "'.number_format($diamondData['diamondData']['fltPrice']).'","option1":"'.$option_name.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");

	        	// add product to cart

	        	$referer = $_SERVER['HTTP_REFERER'] ?? '';

				// Parse the URL to extract only the scheme and host
				$parsedUrl = parse_url($referer);
				$shop_base_url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

	        	$chekcout_url = $shop_base_url."/cart/add?id=".$product_add."&quantity=1";
	        	redirect($chekcout_url);
	        	exit;
        	}else{

        		$option_name =  $diamondData['diamondData']['mainHeader']." |  StockNumber : ". $diamondData['diamondData']['stockNumber']." | Shape : ".$diamondData['diamondData']['shape']." | CaratWeight : ".$diamondData['diamondData']['caratWeight']." | Cut : ".$diamondData['diamondData']['cut']." | Color : ".$diamondData['diamondData']['color']." | Clarity : ".$diamondData['diamondData']['clarity'];

        		$productTitle = $diamondData['diamondData']['mainHeader'];
        		$productDesc = $diamondData['diamondData']['subHeader'];
        		$productVendor = "GemFind";
        		$productType = "GemFindDiamond";
        		$productImage = $diamondData['diamondData']['image2'];
        		$productPrice = number_format($diamondData['diamondData']['fltPrice']);

        		$path_info = parse_url($this->agent->referrer());
        		$urlArray = explode('/', $path_info['path']);
        		
        		if(end($urlArray) == 'labcreated' || end($urlArray) == 'fancydiamonds'){
					$diamond_path = $urlArray[5]."/".$urlArray[6];
        		}else{
        			$diamond_path = $urlArray[5];
        		}
        		
        		$product_add_post_data = '{
				  "product": {
				    "title": "'.$productTitle.'",
				    "body_html": "'.$productDesc.'",
				    "vendor": "'.$productVendor.'",
				    "product_type": "'.$productType.'",
					"published_scope" : "web",
				    "tags": "GemfindDiamond",
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
                    ],
				    "sales_channels": ["online"]				    
				  }
				}';

				// create product in shopify
	        	$resultProd = postCurlData($addProductRequestUrl,$request_headers,$product_add_post_data,"POST"); 
	        	$product_id = $resultProd->product->id;
	        	$variants_id = $resultProd->product->variants['0']->id;
	        	$inventory_item_id = $resultProd->product->variants['0']->inventory_item_id;

	        	// update SKU and stock management in created product
	        	$sku_stock_manage_endpoint = "/admin/api/".$api_version."/inventory_items/".$inventory_item_id.".json";
	        	$skuStockUpdateUrl = $shop_base_url.$sku_stock_manage_endpoint;
	        	$skuAndStockMangePostData = '{"inventory_item": {"id": '.$inventory_item_id.',"sku": '.$diamond_id.',"tracked" : true}}';
	        	$resultSkuStockUpdate = postCurlData($skuStockUpdateUrl,$request_headers,$skuAndStockMangePostData,"PUT");

	        	//update inventory in created product
	        	$inv_post_data = '{"location_id": '.$location_id.', "inventory_item_id": '.$inventory_item_id.', "available":1}';
	        	$resultInvUpdate = postCurlData($updateInvUrl,$request_headers,$inv_post_data,"POST");

	        	//update pricing stuff in created product
	        	$update_pricing_endpoint = "/admin/api/".$api_version."/products/".$product_id.".json";
	        	$updatePriceUrl = $shop_base_url.$update_pricing_endpoint;
	        	$pricing_post_data = '{"product": {"id":'.$product_id.',"variants": [{"id": '.$variants_id.',"price": "'.$productPrice.'","option1":"'.$option_name.'"}]}}';
	        	$resultPricing = postCurlData($updatePriceUrl,$request_headers,$pricing_post_data,"PUT");
	        	
	        	// product add to cart

	        	$referer = $_SERVER['HTTP_REFERER'] ?? '';

				// Parse the URL to extract only the scheme and host
				$parsedUrl = parse_url($referer);
				$shop_base_url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
	        	$chekcout_url = $shop_base_url."/cart/add?id=".$variants_id."&quantity=1";

	        	redirect($chekcout_url);
	        	exit;
        	}
        } catch (Exception $e) {
			redirect($this->agent->referrer().'/error');
		}
 	}

 	public function productTracking(){
 		$diamond = $this->input->post(NULL, true);
 		$final_track_url = $diamond['track_url'];
 		$diamonddata = json_decode(json_decode($diamond['diamond_data']),true);
 		//print_r($diamonddata);
 		//exit;

 		$RetailerID = $VendorID = $DInventoryID= $URL= $StyleNumber= $DealerStockNumber= $RetailerStockNumber= $Price= $DiamondId= $caratWeight= $cut= $color= $clarity= $depth= $table= $polish= $symmetry= $Girdle= $Culet= $Fluorescence= $Measurements= $Certificate= $CertificateNo= $TableMes= $CutGrade= $SellingPrice= $FltPrice= $UsersIPAddress= ''; 
 		
        $RetailerID = 'RetailerID='.($diamonddata['diamondData']['dealerId'] ? $diamonddata['diamondData']['dealerId'].'&':'&');
        $VendorID = 'VendorID='.($diamonddata['diamondData']['retailerInfo']['retailerID'] ? $diamonddata['diamondData']['retailerInfo']['retailerID'].'&':'&');
        $DInventoryID = 'DInventoryID='.$diamonddata['diamondData']['diamondId'].'&';
        $URL = 'URL='.urlencode($final_track_url).'&';
        $DiamondId = 'DiamondID='.$diamonddata['diamondData']['diamondId'].'&';
        $DealerStockNumber = ($diamonddata['diamondData']['retailerInfo']['retailerStockNo'] ? $diamonddata['diamondData']['retailerInfo']['retailerStockNo'].'&':'&');

        $caratWeight = ($diamonddata['diamondData']['caratWeight'] ? $diamonddata['diamondData']['caratWeight'].'&':'&');
        $cut = ($diamonddata['diamondData']['shape'] ? $diamonddata['diamondData']['shape'].'&':'&');
        $color = ($diamonddata['diamondData']['color'] ? $diamonddata['diamondData']['color'].'&':'&');
        $clarity = ($diamonddata['diamondData']['clarity'] ? $diamonddata['diamondData']['clarity'].'&':'&');
        $depth = ($diamonddata['diamondData']['depth'] ? $diamonddata['diamondData']['depth'].'&':'&');
        $table = ($diamonddata['diamondData']['table'] ? $diamonddata['diamondData']['table'].'&':'&');
        $polish = ($diamonddata['diamondData']['polish'] ? $diamonddata['diamondData']['polish'].'&':'&');
        $symmetry = ($diamonddata['diamondData']['symmetry'] ? $diamonddata['diamondData']['symmetry'].'&':'&');
        $Girdle = ($diamonddata['diamondData']['gridle'] ? $diamonddata['diamondData']['gridle'].'&':'&');
        $Culet = ($diamonddata['diamondData']['culet'] ? $diamonddata['diamondData']['culet'].'&':'&');
        $Fluorescence = ($diamonddata['diamondData']['fluorescence'] ? $diamonddata['diamondData']['fluorescence'].'&':'&');
        $Measurements = ($diamonddata['diamondData']['measurement'] ? $diamonddata['diamondData']['measurement'].'&':'&');
        $Certificate = ($diamonddata['diamondData']['certificate'] ? $diamonddata['diamondData']['certificate'].'&':'&');
        $CertificateNo = ($diamonddata['diamondData']['certificateNo'] ? $diamonddata['diamondData']['certificateNo'].'&':'&');
        $TableMes = ($diamonddata['diamondData']['table'] ? $diamonddata['diamondData']['table'].'&':'&');
        $CutGrade = ($diamonddata['diamondData']['cut'] ? $diamonddata['diamondData']['cut'].'&':'&');
        $SellingPrice = ($diamonddata['diamondData']['fltPrice'] ? $diamonddata['diamondData']['fltPrice'].'&':'&');
        $FltPrice = ($diamonddata['diamondData']['fltPrice'] ? $diamonddata['diamondData']['fltPrice'].'&':'&');


        $UsersIPAddress = 'UsersIPAddress='.$this->getRealIpAddr();

		$posturl = str_replace(' ', '+', 'https://platform.jewelcloud.com/DiamondTracking.aspx?'.$RetailerID.$VendorID.$DInventoryID.$URL.'DealerStockNo='.$DealerStockNumber.'Carat='.$caratWeight.'Cut='.$cut.'Color='.$color.'Clarity='.$clarity.'Depth='.$depth.'Polish='.$polish.'Symmetry='.$symmetry.'FltPrice='.$FltPrice.'SellingPrice='.$SellingPrice.'Girdle='.$Girdle.'Culet='.$Culet.'Fluorescence='.$Fluorescence.'Measurements='.$Measurements.'Certificate='.$Certificate.'CertificateNo='.$CertificateNo.'TableMes='.$TableMes.'CutGrade='.$CutGrade.$UsersIPAddress);

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
	public function removeDiamondrb()
    {
        $removeIdrb = $_POST['selectedcheckboxidrb'];
        $cookiseComparerb = $_POST['comparediamondProductrb'];
        $data = json_decode(stripslashes($cookiseComparerb), 1);
        //print_r($data);
        $key = array_search($removeIdrb, array_column($data, 'ID'));
        unset($data[$key]);
        $updatedkeyrb = array_values($data);
        setcookie('comparediamondProductrb', json_encode($updatedkeyrb, true), time() + (86400 * 30), "/");
        $cookiseComparerb = json_decode(stripslashes($_COOKIE['comparediamondProductrb']), 1);
        print_r($cookiseComparerb);
        exit;
    }


    function getDiamondVendorInformation() {

		$diamond = $this->diamond_lib->getDiamondById($_POST['diamondId'], $_POST['diamondtype'], $_POST['shop']);

	    $dealerInfo = $diamond['diamondData']['retailerInfo'];

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

    //  public function storestatus()
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

    public function getDiamondDetails(){
    	$diamondId = $_POST['id'];
    	$type = $_POST['type'];
    	$shop = $_POST['shop'];

    	if($type && $type == 'navlabgrown'){
            $diamondType = 'labcreated';    
        } elseif($type == 'navfancycolored') {
            $diamondType = 'fancydiamonds'; 
        }else{
            $diamondType = $type; 
        }

    	$diamondData = $this->diamond_lib->getDiamondById($diamondId,$diamondType,$shop);

    	echo json_encode($diamondData);
    	exit;
    }

}