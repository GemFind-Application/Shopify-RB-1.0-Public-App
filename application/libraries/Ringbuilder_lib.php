<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class ringbuilder_lib {

	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('form');
        $this->CI->load->helper('common');
		$this->CI->load->model('general_model');
        $requestData = $this->CI->input->get(NULL, true);
		

	}

    function getRingViewUrl($ringid,$ringname,$shop,$pathprefixshop,$metaltype = '14k-white-gold-metaltype-'){
        $route = "https://".$shop.$pathprefixshop."/settings/view/path/";
        //$metaltype = '14k-white-gold-metaltype-';
		$metaltype = strtolower(str_replace(' ', '-', $metaltype));
		$metaltype = strtolower(str_replace('&', '%26', $metaltype));
        $metaltype = strtolower(str_replace('/', '-', $metaltype));
		$metaltype = $metaltype."-";
        $name = strtolower(str_replace(' ', '-', $ringname));
        $name = strtolower(str_replace('&', '%26', $name));
        $name = strtolower(str_replace('/', '-', $name));
        $sku = '-sku-'.str_replace(' ', '-', $ringid); 
        return $url = $this->getUrl($route, ['path' => $metaltype.$name.$sku, '_secure' => true]);
    }

    
    function getRingById($id,$shop,$isLabSettings){

        $DealerID = 'DealerID='.$this->getUsername($shop).'&';

        $DID = 'SID='.$id;
        if($isLabSettings == 1){
            $add_lab_para = '&IsLabSetting=1';
        }
        $query_string = $DealerID.$DID.$add_lab_para;
        $requestUrl = $this->CI->general_model->getmountingdetailapi($shop).$query_string;
        //echo $requestUrl;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = json_decode($responce);
        if (curl_errno($curl)) {
            return $returnData = ['ringData' => [], 'total' => 0, 'message' =>'Gemfind: An error has occurred.'];
        }
       if(isset($results->message)){
            return $returnData = ['ringData' => [], 'total' => 0, 'message' =>'Gemfind: An error has occurred.'];
        }
        curl_close($curl);
        if($results->settingId != "" && $results->settingId > 0){
            $ringData = (array) $results;
            $returnData = ['ringData' => $ringData];
        } else {
            $returnData = ['ringData' => []];   
        }
        return $returnData;
    }

    /**
     * @return array|product
     */
    public function getProductRing($ring_path,$shop,$isLabSettings)
    {   
        
        $id = getRingSkuByPath($ring_path);
        //$type = $this->CI->uri->segment(4);

        if (!$this->product_ring) {
                $this->product_ring = (array) $this->getRingById($id,$shop,$isLabSettings);    
            }
        
        return $this->product_ring;
    }

    /**
     * @return string
     */
    public function getSubmitUrlRing($settingid,$shop,$pathprefixshop)
    {

        $route = "https://".$shop.$pathprefixshop."/settings/cartaddsetting/";
        return $this->getUrl($route, ['id'=>$settingid,'_secure' => true]);
    }

    /**
     * @return string
     */
    public function getAddDiamondUrl($settingid,$final_shop_url)
    {
        $route = $final_shop_url."/settings/adddiamond/";
        return $this->getUrl($route, ['id'=>$settingid,'_secure' => true]);
    }

    /**
     * @return int
     */
    function getResultPerPage(){
        return 20;
    }

	/**
     * @param $shop
     * @return mixed
     */
	function getDiamondFilters($shop)
	{   
	    parse_str($this->CI->input->post('searchformdata'), $request);
	    $resultUsername = $this->CI->general_model->getUsername($shop);
	    $dealerID = $resultUsername->dealerid;
        echo $dealerID;
        
	    if($dealerID){
		    if($request['filtermode'] == 'navstandard'){
		        $requestUrl = $this->CI->general_model->getFilterApi($shop).'DealerID='.$dealerID;
		    } else if($request['filtermode'] == 'navlabgrown'){
		        $requestUrl = $this->CI->general_model->getFilterApi($shop).'DealerID='.$dealerID.'&IsLabGrown=true';
		    } else if($request['filtermode'] == 'navfancycolored'){
		        $requestUrl = $this->CI->general_model->getFilterApiFancy($shop).'DealerID='.$dealerID;
		    } else {
		        $requestUrl = $this->CI->general_model->getFilterApi($shop).'DealerID='.$dealerID;
		    }
		}else{
			return;
		}
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $requestUrl);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $responce = curl_exec($curl);
	    $results = (array) json_decode($responce);
	    if(sizeof($results) > 1 && $results[0]->message == 'Success'){
	        foreach ($results[1] as $value) {
	            return $value = (array) $value;
	        }
	    }
	    curl_close($curl);
	}

    /**
     * @param $shop
     * @return mixed
     */
    function getRingFiltersRB($shop)
    {   
        
        $resultUsername = $this->CI->general_model->getUsername($shop);
        $dealerID = $resultUsername->dealerid;
        
        if($dealerID){
                $requestUrl = $this->CI->general_model->getFilterApiRB($shop).'DealerID='.$dealerID;
        }else{
            return;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = (array) json_decode($responce);
        if(sizeof($results) > 1 && $results[0]->message == 'Success'){
            foreach ($results[1] as $value) {
                return $value = (array) $value;
            }
        }
        curl_close($curl);
    }

    /**
     * @return mixed
     */
	function getActiveNavigation()
    {
    	$resultUsername = $this->CI->general_model->getUsername($this->CI->input->get('shop'));
	    $DealerID = "DealerID=".$resultUsername->dealerid;
	    $resultNavigationAPI = $this->CI->general_model->getNavigationapi($this->CI->input->get('shop'));
	    $navigation_api = $resultNavigationAPI->navigationapi;


        $requestUrl = $navigation_api.$DealerID;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = (array) json_decode($responce);
        if(isset($results[0])){
        $results = (array) $results[0];
        
        if (curl_errno($curl)) {
            return $returnData = ['navigation' => [], 'total' => 0];
        }

        if(sizeof($results) == 0){
            return $returnData = ['navigation' => [], 'total' => 0];
        }
        
        if(sizeof($results) > 0){
            foreach ($results as $name => $value) {
                if($name != '$id' && $name != 'navAdvanced' && $name != 'navRequest'){
                    $navigation[$name] = $value;
                }
            }
            $returnData = ['navigation' => $navigation, 'total' => sizeof($navigation)];
            return $returnData; 
        }
        } else {
            return $returnData = ['navigation' => [], 'total' => 0];
        }    

    }

     function getActiveNavigationRB($shop)
    {
        if($shop == ''){
            $shop = $this->CI->input->get('shop');
        }

        $resultUsername = $this->CI->general_model->getUsername($shop);
        $DealerID = "DealerID=".$resultUsername->dealerid;
        $resultNavigationAPI = $this->CI->general_model->getNavigationapirb($shop);
        $navigation_api = $resultNavigationAPI->navigationapirb;

        $requestUrl = $navigation_api.$DealerID;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = (array) json_decode($responce);
        if(isset($results[0])){
        $results = (array) $results[0];
        
        if (curl_errno($curl)) {
            return $returnData = ['navigation' => [], 'total' => 0];
        }

        if(sizeof($results) == 0){
            return $returnData = ['navigation' => [], 'total' => 0];
        }
        
        if(sizeof($results) > 0){
            foreach ($results as $name => $value) {
                if($name != '$id' && $name != 'navAdvanced' && $name != 'navRequest'){
                    $navigation[$name] = $value;
                }
            }
            $returnData = ['navigation' => $navigation, 'total' => sizeof($navigation)];
            return $returnData; 
        }
        } else {
            return $returnData = ['navigation' => [], 'total' => 0];
        }    

    }

    /**
     * @param $shop
     * @return mixed
     */
    public function getStyleSettingsRB($shop)
    {

    	$resultUsername = $this->CI->general_model->getUsername($shop);
        $DealerID = 'DealerID='.$resultUsername->dealerid.'&ToolName=RB';
        $query_string = $DealerID;
        $resultStyleAPI = $this->CI->general_model->getStyleSettingRBapi($shop);
        $ringstylesettingapi = $resultStyleAPI->ringstylesettingapi;
        $requestUrl = $ringstylesettingapi.$query_string;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $response = curl_exec($curl);
        $results = (array) json_decode($response);
       if (curl_errno($curl)) {
            return $returnData = ['settings' => [],];
        }
        if(isset($results[0][0])){
            $settings = (array) $results[0][0];
            $returnData = ['settings' => $settings,];
        return $returnData; 
        }    

    }

    /**
     * @param $shop
     * @return int
     */    
    function getUsername($shop){
        $resultUsername = $this->CI->general_model->getUsername($shop);
        return $resultUsername->dealerid;
    }

    /**
     * @param $request
     * @return array
     */
    function getRings($request)
    {   
        /*echo "<pre>";
        print_r($request);
        echo "</pre>";*/
        if ($request == null) {
            $rings = [
                'meta' => ['code' => 400, 'message' => __('No arguments supplied.')],
                'data' => [],
                'pagination' => [],
                'perpage'       => $this->getResultPerPageforRing()
            ];
            return $rings;
        }
        if (!is_array($request)) {
            $rings = [
                'meta' => ['code' => 400, 'message' => $request],
                'data' => [],
                'pagination' => [],
                'perpage'       => $this->getResultPerPageforRing()
            ];
            return $rings;
        }
        
        $shapeValue =  $collection = $metal =  [];
        $shapesContent = $collectionContent = $metalContent = $itemperpage = '';
        // Convert the Shapes list into gemfind form

        if (array_key_exists('selected_shape', $request)) {
            $shapesContent = $request["selected_shape"];
        }
        // Convert the Ring_Collection list into gemfind form

        if (array_key_exists('ring_collection', $request)) {
            $collectionContent = $request["ring_collection"];
        }
        // Convert the Ring_Metal list into gemfind form

        if (array_key_exists('ring_metal', $request)) {
            $metalContent = $request["ring_metal"];
        }
        // Convert the SettingID list into gemfind form

        if(isset($request['settingid'])){
            $settingid = $request['settingid'];
        } else {
            $settingid = '';
        }
        if(isset($request['is_lab_settings']) && $request['is_lab_settings'] == 1 ){
            $is_lab_settings = 1;
        }
        // Convert the SettingID list into gemfind form

        if (array_key_exists('caratvalue', $request)) {
            $caratvalueContent = $request["caratvalue"];
        }
		
		if (array_key_exists('centerstonemincarat', $request)) {
            $centerStoneMinCarat = $request["centerstonemincarat"];
        }
        
        if (array_key_exists('centerstonemaxcarat', $request)) {
            $centerStoneMaxCarat = $request["centerstonemaxcarat"];
        }


        if(isset($request['orderby']) && $request['orderby'] == "cost-h-l"){
            $orderby = 'cost';
            $direction = 'desc';
        } else {
            $orderby = 'cost';
            $direction = 'asc';
        }

        // Create the request array to sumbit to gemfind
        $requestData = [
            'shapes' => $shapesContent,
            'ring_metal' => $metalContent,
            'ring_collection' => $collectionContent,
			'price_from' => (intval(preg_replace('/[^\d.]/', '', $request["price"]["from"]))) ? intval(preg_replace('/[^\d.]/', '', $request["price"]["from"])) : 0,
            'price_to' => (intval(preg_replace('/[^\d.]/', '', $request["price"]["to"]))) ? intval(preg_replace('/[^\d.]/', '', $request["price"]["to"])) : '',
            /*'price_from' => (intval($request["price"]["from"])) ? intval($request["price"]["from"]) : 0,
            'price_to' => (intval($request["price"]["to"])) ? intval($request["price"]["to"]) : '',*/
            'page_number' => ($request['currentpage']) ? $request['currentpage'] : '',
            'page_size' => ($request['itemperpage']) ? $request['itemperpage'] : $this->getResultPerPageforRing(),
            'sort_by' => $orderby,
            'sort_direction' => $direction,
            'settingId' => $settingid,
            'isLabSettings' => $is_lab_settings,
            'Filtermode' => ($request['filtermode'])? $request['filtermode'] : 'navminedsetting'

        ];
        if(isset($caratvalueContent)){
          $requestData['caratvalue'] = $request['caratvalue'];
        }
		
		if (isset($centerStoneMinCarat)) {
            $requestData['centerstonemincarat'] = $request['centerstonemincarat'];
        }
        
        if (isset($centerStoneMaxCarat)) {
            $requestData['centerstonemaxcarat'] = $request['centerstonemaxcarat'];
        }

        $result = $this->sendRingRequest($requestData,$request['shopurl']);
        $num = ceil($result['total'] / $this->getResultPerPageforRing());
        if($request['currentpage'] > $num){
            $requestData['page_number'] = 1;
            $request['currentpage'] = 1;
            $result = $this->sendRingRequest($requestData,$request['shopurl']);
        }
        if ($result['rings'] != null || $result['total'] != 0) {
            $count = 0;
            if ($request['currentpage'] > 1) {
                $count = ($request['itemperpage']) ? $request['itemperpage'] : $this->getResultPerPageforRing() * ($request['currentpage'] - 1);
            }

            $ring = [
                'meta' => ['code' => 200],
                'data' => $result['rings'],
                'pagination' => [
                    'currentpage' => $request['currentpage'],
                    'count'     => $count,
                    'limit'     => count($result['rings']),
                    'total'     => $result['total']
                ],
                'perpage'       => ($request['itemperpage']) ? $request['itemperpage'] : $this->getResultPerPageforRing()    
            ];
        } else {
            $ring = [
                'meta' =>['code' => 404, 'message' => "No Product Found"],
                'data' => [],
                'pagination' =>['total' => $result['total']],
                'perpage'       => $this->getResultPerPageforRing()  
            ];
        }

        return $ring;
    }

    public function sendRingRequest($requestParam,$shop){
        $Shape = $MetalType = $Collection = $PriceMin = $PriceMax = $OrderBy = $OrderType = $PageNumber = $PageSize = $settingId = $caratvalue = $isLabSettings = $caratminvalue = $caratmaxvalue = '';

            //print_r($requestParam);

           if($requestParam) {

                

                $DealerID = 'DealerID='.$this->getUsername($shop).'&';

                

                if (array_key_exists('shapes', $requestParam)) {

                    if($requestParam['shapes']){

                    $Shape = 'Shape='.$requestParam['shapes'].'&';

                    }

                }

                if (array_key_exists('ring_metal', $requestParam)) {

                    if($requestParam['ring_metal']){

                    $ring_metal = str_replace(' ', '+', $requestParam['ring_metal']);

                    $MetalType = 'MetalType='.$ring_metal.'&';

                    }

                }

                if (array_key_exists('ring_collection', $requestParam)) {

                    if($requestParam['ring_collection']){

                    $ring_collection = str_replace(' ', '+', $requestParam['ring_collection']);

                    $Collection = 'Collection='.$ring_collection.'&';

                    }

                }

                if (array_key_exists('price_from', $requestParam)) {

                    if($requestParam['price_from']){

                    $PriceMin = 'PriceMin='.$requestParam['price_from'].'&';

                    } else {

                    $PriceMin = 'PriceMin=0&';    

                    }

                }

                if (array_key_exists('price_to', $requestParam)) {

                    if($requestParam['price_to']){

                    $PriceMax = 'PriceMax='.$requestParam['price_to'].'&';

                    }

                }

                

                if (array_key_exists('sort_by', $requestParam)) {

                    if($requestParam['sort_by']){

                    $OrderBy = 'OrderBy='.$requestParam['sort_by'].'+'.$requestParam['sort_direction'].'&';

                    }

                }                                                                                


                if (array_key_exists('page_number', $requestParam)) {

                    if($requestParam['page_number']){

                    $PageNumber = 'PageNumber='.$requestParam['page_number'].'&';

                    }

                }

                if (array_key_exists('page_size', $requestParam)) {

                    if($requestParam['page_size']){

                    $PageSize = 'PageSize='.$requestParam['page_size'];

                    }

                }

                

                if (array_key_exists('settingId', $requestParam)) {

                    if($requestParam['settingId']){

                    $settingId = 'SID='.$requestParam['settingId'].'&';

                    }

                }


                /*if (array_key_exists('caratvalue', $requestParam)) {

                    if($requestParam['caratvalue']){

                        $caratvalue = 'centerStoneMaxCarat='.$requestParam['caratvalue'].'&';

                    }

                }*/
				
				if (array_key_exists('centerstonemincarat', $requestParam)) {

					if ($requestParam['centerstonemincarat']) {

						$centerStoneMinCarat = 'CenterStoneMinCarat=' . $requestParam['centerstonemincarat'] . '&';
					}
				}
				
				if (array_key_exists('centerstonemaxcarat', $requestParam)) {

					if ($requestParam['centerstonemaxcarat']) {

						$centerStoneMaxCarat = 'CenterStoneMaxCarat=' . $requestParam['centerstonemaxcarat'] . '&';
					}
				}

                // if (array_key_exists('isLabSettings', $requestParam)) {

                //     if($requestParam['isLabSettings']){

                //         $isLabSettings = '&IsLabSetting='.$requestParam['isLabSettings'];

                //     }

                // }

                if (array_key_exists('Filtermode', $requestParam)) {

                    if ($requestParam['Filtermode'] == 'navlabsetting' ) {

                        $isLabSettings = '&IsLabSettingsAvailable=1';
                    }
                    else{
                        $isLabSettings = '&IsLabSettingsAvailable=0';
                    }
                }

                //$query_string = $caratvalue.$DealerID.$Shape.$Collection.$MetalType.$PriceMin.$PriceMax.$settingId.$OrderBy.$PageNumber.$PageSize.$isLabSettings;
				
				$query_string = $DealerID . $Shape . $centerStoneMinCarat. $centerStoneMaxCarat. $Collection . $MetalType . $PriceMin . $PriceMax . $settingId . $OrderBy . $PageNumber . $PageSize. $isLabSettings;

                $requestUrl = $this->CI->general_model->getmountinglistapi($shop).$query_string;

               

            }
        // echo $requestUrl;//end;
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $requestUrl);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HEADER, false);

        $responce = curl_exec($curl);

        $results = json_decode($responce);



        if (curl_errno($curl)) {

            

            return $returnData = ['rings' => [], 'total' => 0];

        }

       if($results->message !='Successfull'){

            

            return $returnData = ['rings' => [], 'total' => 0];

        }

        curl_close($curl);



        if($results->mountingList != "" && $results->count > 0){

            $returnData = ['rings' => $results->mountingList, 'total' => $results->count];

        } else {

            $returnData = ['rings' => [], 'total' => 0];   

        }



        return $returnData;
    }

    

    /**
     * @param $requestParam,$shop
     * @return array
     */
    public function sendRequest($requestParam,$shop)
    {      

        $Shape = $CaratMin = $CaratMax = $PriceMin = $PriceMax = $ColorId = $ClarityId = $CutGradeId = $TableMin = $TableMax = $DepthMin = $DepthMax = $SymmetryId = $PolishId = $FluorescenceId = $Certificate = $OrderBy = $OrderType = $PageNumber = $PageSize = $InHouseOnly = $SOrigin = $query_string = $DID = $FancyColor = $intIntensity = $HasVideo = '';
           if($requestParam) {
                
                $DealerID = 'DealerID='.$this->getUsername($shop).'&';
                
                if (array_key_exists('shapes', $requestParam)) {
                    if($requestParam['shapes']){
                    $Shape = 'Shape='.$requestParam['shapes'].'&';
                    }
                }
                if (array_key_exists('size_from', $requestParam)) {
                    if($requestParam['size_from']){
                    $CaratMin = 'CaratMin='.$requestParam['size_from'].'&';
                    }
                }
                if (array_key_exists('size_to', $requestParam)) {
                    if($requestParam['size_to']){
                    $CaratMax = 'CaratMax='.$requestParam['size_to'].'&';
                    }
                }
                if (array_key_exists('price_from', $requestParam)) {
                    if($requestParam['price_from']){
                    $PriceMin = 'PriceMin='.$requestParam['price_from'].'&';
                    } else {
                    $PriceMin = 'PriceMin=0&';    
                    }
                }
                if (array_key_exists('price_to', $requestParam)) {
                    if($requestParam['price_to']){
                    $PriceMax = 'PriceMax='.$requestParam['price_to'].'&';
                    }
                }
                if (array_key_exists('depth_percent_from', $requestParam)) {
                    if($requestParam['depth_percent_from']){
                    $DepthMin = 'DepthMin='.$requestParam['depth_percent_from'].'&';
                    } else {
                    $DepthMin = 'DepthMin=0&';    
                    }
                }
                if (array_key_exists('depth_percent_to', $requestParam)) {
                    if($requestParam['depth_percent_to']){
                    $DepthMax = 'DepthMax='.$requestParam['depth_percent_to'].'&';
                    }
                }                                                                                
                if (array_key_exists('diamond_table_from', $requestParam)) {
                    if($requestParam['diamond_table_from']){
                    $TableMin = 'TableMin='.$requestParam['diamond_table_from'].'&';
                    } else {
                    $TableMin = 'TableMin=0&';    
                    }
                }
                if (array_key_exists('diamond_table_to', $requestParam)) {
                    if($requestParam['diamond_table_to']){
                    $TableMax = 'TableMax='.$requestParam['diamond_table_to'].'&';
                    }
                }
                if (array_key_exists('color', $requestParam)) {
                    if($requestParam['color']){
                    $ColorId = 'ColorId='.$requestParam['color'].'&';
                    }
                }
                if (array_key_exists('clarity', $requestParam)) {
                    if($requestParam['clarity']){
                    $ClarityId = 'ClarityId='.$requestParam['clarity'].'&';
                    }
                }
                if (array_key_exists('cut', $requestParam)) {
                    if($requestParam['cut']){
                    $CutGradeId = 'CutGradeId='.$requestParam['cut'].'&';
                    }
                }                                                                                
                if (array_key_exists('symmetry', $requestParam)) {
                    if($requestParam['symmetry']){
                    $SymmetryId = 'SymmetryId='.$requestParam['symmetry'].'&';
                    }
                }
                if (array_key_exists('polish', $requestParam)) {
                    if($requestParam['polish']){
                    $PolishId = 'PolishId='.$requestParam['polish'].'&';
                    }
                }
                if (array_key_exists('fluorescence_intensities', $requestParam)) {
                    if($requestParam['fluorescence_intensities']){
                    $FluorescenceId = 'FluorescenceId='.$requestParam['fluorescence_intensities'].'&';
                    }
                }
                if (array_key_exists('labs', $requestParam)) {
                    if($requestParam['labs']){
                    $Certificate = 'Certificate='.$requestParam['labs'].'&';
                    }
                }
                if (array_key_exists('sort_by', $requestParam)) {
                    if($requestParam['sort_by']){
                    $OrderBy = 'OrderBy='.$requestParam['sort_by'].'&';
                    }
                }                                                                                
                if (array_key_exists('sort_direction', $requestParam)) {
                    if($requestParam['sort_direction']){
                    $OrderType = 'OrderType='.$requestParam['sort_direction'].'&';
                    }
                }
                if (array_key_exists('page_number', $requestParam)) {
                    if($requestParam['page_number']){
                    $PageNumber = 'PageNumber='.$requestParam['page_number'].'&';
                    }
                }
                if (array_key_exists('page_size', $requestParam)) {
                    if($requestParam['page_size']){
                    $PageSize = 'PageSize='.$requestParam['page_size'];
                    }
                }
                if (array_key_exists('InHouseOnly', $requestParam)) {
                    if($requestParam['InHouseOnly']){
                    $InHouseOnly = '&InHouseOnly='.$requestParam['InHouseOnly'];
                    }
                }
                if (array_key_exists('origin', $requestParam)) {
                    if($requestParam['origin']){
                    $SOrigin = '&SOrigin='.$requestParam['origin'].'&';
                    }
                }

                if (array_key_exists('did', $requestParam)) {
                    if($requestParam['did']){
                    $DID = 'DID='.$requestParam['did'].'&';
                    }
                }


                if (array_key_exists('hasvideo', $requestParam)) {
                    if($requestParam['hasvideo']){
                    $HasVideo = 'HasVideo='.$requestParam['hasvideo'].'&';
                    }
                }                
                

                if (array_key_exists('Filtermode', $requestParam)) {
                    if($requestParam['Filtermode'] != 'navstandard' && $requestParam['Filtermode'] != 'navlabgrown'){
                        if(array_key_exists('FancyColor', $requestParam)){
                            if($requestParam['FancyColor']){
                                $FancyColor = 'FancyColor='.$requestParam['FancyColor'].'&';
                            }
                        }
                        if(array_key_exists('intIntensity', $requestParam)){
                            if($requestParam['intIntensity']){
                                $requestParam['intIntensity'] = str_replace(' ', '+', $requestParam['intIntensity']);
                                $intIntensity = 'intIntensity='.$requestParam['intIntensity'].'&';

                            }    
                        }
                        $IsLabGrown = '&IsLabGrown=false';
                        $query_string = $DealerID.$Shape.$CaratMin.$CaratMax.$PriceMin.$PriceMax.$ClarityId.$CutGradeId.$TableMin.$TableMax.$DepthMin.$DepthMax.$SymmetryId.$PolishId.$FluorescenceId.$FancyColor.$intIntensity.$Certificate.$SOrigin.$DID.$OrderBy.$OrderType.$PageNumber.$PageSize.$InHouseOnly.$IsLabGrown;
                        $requestUrl = $this->CI->general_model->getdiamondlistapifancy($shop).$query_string;
                    } else {
                        if($requestParam['Filtermode'] == 'navlabgrown'){
                            $IsLabGrown = '&IsLabGrown=true';
                        } else {
                            $IsLabGrown = '&IsLabGrown=false';
                        }
                        $query_string = $DealerID.$Shape.$CaratMin.$CaratMax.$PriceMin.$PriceMax.$ColorId.$ClarityId.$CutGradeId.$TableMin.$TableMax.$DepthMin.$DepthMax.$SymmetryId.$PolishId.$FluorescenceId.$Certificate.$SOrigin.$DID.$OrderBy.$OrderType.$PageNumber.$PageSize.$InHouseOnly.$IsLabGrown;
                        $requestUrl = $this->CI->general_model->getdiamondlistapi($shop).$query_string;
                    }
                }

            }
        //echo $requestUrl;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = json_decode($responce);
        if (curl_errno($curl)) {
            return $returnData = ['diamonds' => [], 'total' => 0, 'message' => 'Gemfind: An error has occurred.'];
        }
       if(isset($results->message)){
            return $returnData = ['diamonds' => [], 'total' => 0, 'message' => 'Gemfind: An error has occurred.'];
        }
        curl_close($curl);

        if($results->diamondList != "" && $results->count > 0){
            $returnData = ['diamonds' => $results->diamondList, 'total' => $results->count];
        } else {
            $returnData = ['diamonds' => [], 'total' => 0];   
        }
        return $returnData;
    }

    /**
     * @return int
     */
    public function getResultsPerPageOptions(){
        return $this->CI->general_model->getAllOptions();
    }

    /**
     * @return int
     */
    public function getResultsPerPageOptionsRings(){
        return $this->CI->general_model->getAllOptionsRings();
    }

    /**
     * @return int
     */
    public function getResultsPerPage(){
        return $this->CI->general_model->getResultsPerPage();
    }

    /**
     * @return int
     */
    public function getResultPerPageforRing(){
        return $this->CI->general_model->getResultsPerPageRB();
    }

    /**
     * @param $param,$type,$shopurl,$pathprefixshop
     * @return string
     */
    public function getDiamondViewUrl($param,$type,$shopurl,$pathprefixshop)
    {
        $route = "https://".$shopurl.$pathprefixshop."/product/";
        return $this->getUrl($route, ['path' => $param, 'type' => $type, '_secure' => true]);
    }

    /**
     * @param $route,$params
     * @return string
     */
    public function getUrl($route = '', $params = []){
        if($params['path']){
            return $route.$params['path'];    
        }else{
            return $route.$params['id'];    
        }
        
    }

    /**
     * @param $shop
     * @return string
     */
    public function getCurrencySymbol($shop) {
        $dealerID = $this->getUsername($shop);
        $requestUrl = $this->CI->general_model->getFilterApi($shop).'DealerID='.$dealerID;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = (array) json_decode($responce);
        if(sizeof($results) > 1 && $results[0]->message == 'Success'){
            foreach ($results[1] as $value) {
                return $value->currencyFrom.$value->currencySymbol;
            }
        }
        curl_close($curl);
    }

    /**
     * @return array
     */
    public function getDiamondAttributes(){
        return $this->CI->general_model->getDiamondAttribute();
    }

    /**
     * @param $color,$shop
     * @return array
     */
    public function getShapeByColor($color,$shop)
    {
        $DealerID = 'DealerID='.$this->getUsername($shop).'&';
        $Color = 'Color='.$color;
        $query_string = $DealerID.$Color;
        $requestUrl = $this->CI->general_model->getdiamondshapeapi($shop).$query_string;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = (array) json_decode($responce);
        
       if (curl_errno($curl)) {
            return $returnData = ['shapes' => [], 'total' => 0];
        }
        if(($results[0]->status == 0)){
            return $returnData = ['shapes' => [], 'total' => 0];
        }
        
        if(($results[0]->status > 0) && ($results[0]->message == 'Success')){
            foreach ($results[1][0]->shapes as $value) {
                $value = (array) $value;
                $shapes[] = strtolower($value['shapeName']);
            }
            $returnData = ['shapes' => $shapes, 'total' => sizeof($shapes)];
        return $returnData; 
        }    

    }

    /**
     * @return array|product
     */
    public function getProduct()
    {   
        $diamond_path = $this->CI->uri->segment(3);
        $id = getDiamondSkuByPath($diamond_path);
        $shop = $this->CI->input->get('shop');
        //$type = $this->CI->uri->segment(4);

        if (!$this->product) {
            if($type == 'labcreated'){
                $this->product = (array)$this->getDiamondByIdtype($id,$type,$shop);
            } else {
                $this->product = (array)$this->getDiamondById($id,$shop);    
            }
            
        }
        return $this->product;
    }

    /**
     * @param $id
     * @param $type
     * @param $shop
     * @return array
     */
    public function getDiamondByIdtype($id,$type,$shop)
    {   
        $IslabGrown = '';
        if($type == 'labcreated'){
            $IslabGrown = '&IslabGrown=true';    
        } else {
            $IslabGrown = "";
        }
        $DealerID = 'DealerID='.$this->getUsername($shop).'&';
        $DID = 'DID='.$id;
        $query_string = $DealerID.$DID.$IslabGrown;
        $requestUrl = $this->getdiamonddetailapi($shop).$query_string;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $responce = curl_exec($curl);
        $results = json_decode($responce);
        
        if (curl_errno($curl)) {
            return $returnData = ['diamondData' => [], 'total' => 0, 'message' => 'Gemfind: An error has occurred.' ];
        }
       if(isset($results->message)){
            return $returnData = ['diamondData' => [], 'total' => 0, 'message' => 'Gemfind: An error has occurred.' ];
        }
        curl_close($curl);
        if($results->diamondId != "" && $results->diamondId > 0){
            $diamondData = (array) $results;
            $returnData = ['diamondData' => $diamondData];
        } else {
            $returnData = ['diamondData' => []];   
        }
        return $returnData;
    }

    /**
     * @param $id
     * @param $shop
     * @return array
     */
    public function getDiamondById($id,$shop)
    {
        $DealerID = 'DealerID='.$this->getUsername($shop).'&';
        $DID = 'DID='.$id;
        $query_string = $DealerID.$DID;
        $requestUrl = $this->CI->general_model->getdiamonddetailapi($shop).$query_string;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $response = curl_exec($curl);
        $results = json_decode($response);
        
        if (curl_errno($curl)) {
            return $returnData = ['diamondData' => [], 'total' => 0, 'message' => 'Gemfind: An error has occurred.' ];
        }
       if(isset($results->message)){
            return $returnData = ['diamondData' => [], 'total' => 0, 'message' => 'Gemfind: An error has occurred.' ];
        }
        curl_close($curl);
        if($results->diamondId != "" && $results->diamondId > 0){
            $diamondData = (array) $results;
            $returnData = ['diamondData' => $diamondData];
        } else {
            $returnData = ['diamondData' => []];   
        }
        return $returnData;
    }

    /**
     * @return int
    */
    public function isHintEnabled($shop) {

        return $this->CI->general_model->isHintEnabled($shop);
    }

    /**
     * @return int
    */
    public function isMoreInfoEnabled($shop) {
        return $this->CI->general_model->isMoreInfoEnabled($shop);
    }

    /**
     * @return int
    */
    public function isEmailtoFriendEnabled($shop) {
        return $this->CI->general_model->isEmailtoFriendEnabled($shop);
    }
    
    /**
     * @return int
    */
    public function isPrintDetailEnabled($shop) {
        return $this->CI->general_model->isPrintDetailEnabled($shop);
    }

    /**
     * @return int
    */
    public function isScheduleViewingEnabled($shop) {
        return $this->CI->general_model->isScheduleViewingEnabled($shop);
    }

    /**
     * @return string
     */
    public function getSubmitUrl($diamondid,$shop,$pathprefixshop)
    {
        $route = "https://".$shop.$pathprefixshop."/cartadd/";
        return $this->getUrl($route, ['id'=>$diamondid,'_secure' => true]);
    }

    /**
     * @return mix
     */
    public function getEmailSender($shop)
    {
        return $this->CI->general_model->getFromEmailAddress($shop);
    }

    /**
     * @return mix
     */
    public function getAdminEmail($shop)
    {
        return $this->CI->general_model->getAdminEmailAddress($shop);
    }

    /**
     * @return json
     */
    public function authenticateDealer($shop,$password,$id,$isLabSettings)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->CI->general_model->dealerAuthapi($shop),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"DealerID": "'.$this->getUsername($shop).'", "DealerPass": "'.$password.'"}',
            CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $settingData = $this->getRingById($id,$shop,$isLabSettings);
        $dealerInfo = $settingData['ringData']['retailerInfo'];

        if ($err) {
            $data = array('status' => 0, 'msg' => $err );
            $result = json_encode(array('output' => $data));
            return $result;
        } else {
          if($response == '"User successfully authenticated."'){
            $data = array('status' => 1, 'msg' => 'User successfully authenticated.', 'dealerInfo' => $dealerInfo );
            $result = json_encode(array('output' => $data));
            return $result;
          }
          if($response == '"User not authenticated."'){
            $data = array('status' => 2, 'msg' => 'User not authenticated.' );
            $result = json_encode(array('output' => $data));
            return $result;
          }
          if($response == '"User not found!"'){
            $data = array('status' => 2, 'msg' => 'User not found!' );
            $result = json_encode(array('output' => $data));
            return $result;
          }          
        }
    }

    /**
     * @return string
     */
    public function getShopAccessToken($shop)
    {
        return $this->CI->general_model->getAccessToken($shop);
    }

    /**
     * @return string
    */
    public function showFilterInfo($shop) {
        return $this->CI->general_model->showFilterInfo($shop);
    }

    /**
     * @return string
    */
    public function showPoweredBy($shop) {
        return $this->CI->general_model->showPoweredBy($shop);
    }

     /**
     * @return array
     */
    public function getRBConfig($shop)
    {
        return $this->CI->general_model->getDiamondConfig($shop);
    }

    /**
     * @return mixed
    */
    public function getMetaltype($metaltype,$data){
       foreach ($data as $value) {
                $value = (array) $value;
                $dataarraymetaltype[$value['centerStoneSize']][$value['metalType']][] = array('gfInventoryId' => $value['gfInventoryId'], 'centerStoneSize' => $value['centerStoneSize'],);
            } 
        ksort($dataarraymetaltype);
        foreach ($dataarraymetaltype as $finkey =>$fiinavalue) {
            foreach ($fiinavalue as $key => $value) {
                $finalmetaldata[$key][] = array('center' => $finkey, 'gfid' => $value[0]['gfInventoryId']);
            }
          }
        foreach ($finalmetaldata as $finalkey => $finalvalue) {
              $finaldata[] = array('metaltype' => $finalkey, 'gfid' => $finalvalue[0]['gfid']);
          }  
        return $finaldata; 
    }  

    /**
     * @return mixed
    */
    public function getSidestone($metaltype,$data){
       foreach ($data as $value) {
                $value = (array) $value;
                $dataarraywithoutsidestone[$value['metalType']][$value['sideStoneQuality']][] = array('gfInventoryId' => $value['gfInventoryId'], 'sideStoneQuality' => $value['sideStoneQuality'], 'centerStoneSize' => $value['centerStoneSize'],);
            }   
        return $dataarraywithoutsidestone[$metaltype];  
    }

    /**
     * @return mixed
    */
    public function getSidestonefinal($sidestone,$data)
    {   
        $keys = array_column($data[$sidestone], 'centerStoneSize');

        array_multisort($keys, SORT_ASC, $data[$sidestone]);

        return array('gfInventoryId' => $data[$sidestone][0]['gfInventoryId'], 'sideStoneQuality' => $data[$sidestone][0]['sideStoneQuality'] );  
    }
        /**
     * @return mixed
    */
    public function getDiamondShape($metaltype,$data){
       foreach ($data as $value) {
                $value = (array) $value;
                $dataarraywithoutsidestone[$value['metalType']][$value['diamondShape']][] = array('gfInventoryId' => $value['gfInventoryId'], 'diamondShape' => $value['diamondShape'], 'centerStoneSize' => $value['centerStoneSize'],);
            }   
        return $dataarraywithoutsidestone[$metaltype];  
    }

    /**
     * @return mixed
    */
    // public function getDiamondShapeFinal($diamondShape,$data)
    // {   
    //     $keys = array_column($data[$diamondShape], 'centerStoneSize');

    //     array_multisort($keys, SORT_ASC, $data[$diamondShape]);

    //     return array('gfInventoryId' => $data[$diamondShape][0]['gfInventoryId'], 'diamondShape' => $data[$diamondShape][0]['diamondShape'] );  
    // }

    public function getDiamondShapeFinal($diamondShape, $data, $currentId)
    {
        // Reference to the specific diamond shape array
        $shapeArray = &$data[$diamondShape];

        // Find the index of the item with the currentId and move it to the 0th position
        foreach ($shapeArray as $index => $item) {
            if ($item['gfInventoryId'] == $currentId) {
                // Remove the item from its current position
                array_splice($shapeArray, $index, 1);
                // Insert the item at the beginning of the array
                array_unshift($shapeArray, $item);
                break;
            }
        }

        // Sort the array by 'centerStoneSize' while keeping the 0th index item in place
        $keys = array_column(array_slice($shapeArray, 1), 'centerStoneSize');
        array_multisort($keys, SORT_ASC, array_slice($shapeArray, 1));
        
        // Reconstruct the array with the 0th item in place
        $shapeArray = array_merge([$shapeArray[0]], array_slice($shapeArray, 1));

        return array('gfInventoryId' => $shapeArray[0]['gfInventoryId'], 'diamondShape' => $shapeArray[0]['diamondShape']);
    }


    /**
     * @return mixed
    */
    public function getCenterstone($metaltype,$sidestone,$data){
        $dataarraywithoutsidestone = array();
        
        if($sidestone == null){
            foreach ($data as $value) {
                $value = (array) $value;
                $dataarraywithoutsidestone[$value['metalType']][] = array('gfInventoryId' => $value['gfInventoryId'], 'centerStoneSize' => $value['centerStoneSize'],);
            }
            usort($dataarraywithoutsidestone[$metaltype], function($a, $b) {
                  return $a['centerStoneSize'] <=> $b['centerStoneSize'];
              }); 
            return $dataarraywithoutsidestone[$metaltype];
        } else {

            foreach ($data as $value) {
                $value = (array) $value;
                $dataarraywithoutsidestone[$value['metalType']][$value['sideStoneQuality']][] = array('gfInventoryId' => $value['gfInventoryId'], 'centerStoneSize' => $value['centerStoneSize'],);
            }
            usort($dataarraywithoutsidestone[$metaltype][$sidestone[0]], function($a, $b) {
                  return $a['centerStoneSize'] <=> $b['centerStoneSize'];
              }); 
            return $dataarraywithoutsidestone[$metaltype][$sidestone[0]];               
        }
    }
}

?>