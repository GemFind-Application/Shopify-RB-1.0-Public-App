<?php
class General_model extends CI_Model {
    
    public function getFilterApi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('filterapi');
        $filterapi = $this->db->get('ringbuilder_config')->first_row();
        return $filterapi->filterapi;
    }

    public function getmountinglistapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('mountinglistapi');
        $mountinglistapi = $this->db->get('ringbuilder_config')->first_row();
        return $mountinglistapi->mountinglistapi;
    }

    public function getFilterApiRB($shop){
        $this->db->where('shop',$shop);
        $this->db->select('ringfiltersapi');
        $ringfiltersapi = $this->db->get('ringbuilder_config')->first_row();
        return $ringfiltersapi->ringfiltersapi;
    }

    public function getUsername($shop){

        $this->db->where('shop',$shop);
    	$this->db->select('dealerid');
        return $this->db->get('ringbuilder_config')->first_row();
    }
    public function getFilterApiFancy($shop){
        $this->db->where('shop',$shop);
        $this->db->select('filterapifancy');
        $filterapifancyresult = $this->db->get('ringbuilder_config')->first_row();
        return $filterapifancyresult->filterapifancy;
    }

    public function getNavigationapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('navigationapi');
        return $this->db->get('ringbuilder_config')->first_row();
    }

    public function getStyleSettingapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('stylesettingapi');
        return $this->db->get('ringbuilder_config')->first_row();
    }

    public function getStyleSettingRBapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('ringstylesettingapi');
        return $this->db->get('ringbuilder_config')->first_row();
    }

    public function getdiamondlistapifancy($shop){
        $this->db->where('shop',$shop);
        $this->db->select('diamondlistapifancy');
        $resultlistapifancy = $this->db->get('ringbuilder_config')->first_row();
        return $resultlistapifancy->diamondlistapifancy;
    }

    public function getdiamondshapeapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('diamondshapeapi');
        $resultlistapifancy = $this->db->get('ringbuilder_config')->first_row();
        return $resultlistapifancy->diamondshapeapi;
    }
    
    public function getdiamondlistapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('diamondlistapi');
        $resultlistapi = $this->db->get('ringbuilder_config')->first_row();
        return $resultlistapi->diamondlistapi;
    }

    public function getdiamonddetailapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('diamonddetailapi');
        $resultDetailApi = $this->db->get('ringbuilder_config')->first_row();
        return $resultDetailApi->diamonddetailapi;
    }

    public function dealerAuthapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('dealerauthapi');
        $resultDetailApi = $this->db->get('ringbuilder_config')->first_row();
        return $resultDetailApi->dealerauthapi;
    }

    public function getJCOptionsapi($shop){
        return 'http://api.jewelcloud.com/api/RingBuilder/GetDiamondsJCOptions?';
    }
    
    public function getAccessToken($shop){
        $this->db->where('shop',$shop);
        $this->db->select('shop_access_token');
        $resultDetailApi = $this->db->get('ringbuilder_config')->first_row();
        return $resultDetailApi->shop_access_token;
    }

    public function isHintEnabled($shop){
        $this->db->where('shop',$shop);
        $this->db->select('enable_hint');
        $resultHintEnabled = $this->db->get('ringbuilder_config')->first_row();
        return $resultHintEnabled->enable_hint;
    }

    public function isMoreInfoEnabled($shop){
        $this->db->where('shop',$shop);
        $this->db->select('enable_more_info');
        $resultMoreInfoEnabled = $this->db->get('ringbuilder_config')->first_row();
        return $resultMoreInfoEnabled->enable_more_info;
    }

    public function isEmailtoFriendEnabled($shop){
        $this->db->where('shop',$shop);
        $this->db->select('enable_email_friend');
        $resultEmailtoFriend = $this->db->get('ringbuilder_config')->first_row();
        return $resultEmailtoFriend->enable_email_friend;
    }

    public function isPrintDetailEnabled($shop){
        $this->db->where('shop',$shop);
        $this->db->select('enable_print');
        $resultPrintDetail = $this->db->get('ringbuilder_config')->first_row();
        return $resultPrintDetail->enable_print;
    }

    public function isScheduleViewingEnabled($shop){
        $this->db->where('shop',$shop);
        $this->db->select('enable_schedule_viewing');
        $resultScheduleView = $this->db->get('ringbuilder_config')->first_row();
        return $resultScheduleView->enable_schedule_viewing;
    }

    public function showFilterInfo($shop){
        $this->db->where('shop',$shop);
        $this->db->select('show_filter_info');
        $resultShowFilterInfo = $this->db->get('ringbuilder_config')->first_row();
        return $resultShowFilterInfo->show_filter_info;
    }

    public function showPoweredBy($shop){
        $this->db->where('shop',$shop);
        $this->db->select('show_powered_by');
        $resultShowPoweredBy = $this->db->get('ringbuilder_config')->first_row();
        return $resultShowPoweredBy->show_powered_by;
    }

    public function getStickyHeader($shop){
        $this->db->where('shop',$shop);
        $this->db->select('enable_sticky_header');
        $resultStickyHeader = $this->db->get('ringbuilder_config')->first_row();
        return $resultStickyHeader->enable_sticky_header;
    }
    
    public function getDefaultViewmode($shop){
        $this->db->where('shop',$shop);
        $this->db->select('default_viewmode');
        $resultScheduleView = $this->db->get('ringbuilder_config')->first_row();
        return $resultScheduleView->default_viewmode;
    }
    
    public function getFromEmailAddress($shop){
        $this->db->where('shop',$shop);
        $this->db->select('from_email_address');
        $resultFromEmail = $this->db->get('ringbuilder_config')->first_row();
        return $resultFromEmail->from_email_address;
    }

    public function getAdminEmailAddress($shop){
        $this->db->where('shop',$shop);
        $this->db->select('admin_email_address');
        $resultAdminEmail = $this->db->get('ringbuilder_config')->first_row();
        return $resultAdminEmail->admin_email_address;
    }

    public function getStoreLogo($shop){
        $this->db->where('shop',$shop);
        $this->db->select('shop_logo');
        $resultStoreLogo = $this->db->get('ringbuilder_config')->first_row();
        return $resultStoreLogo->shop_logo;
    }

    public function addData($Data)
    {   
        $this->db->insert('ringbuilder_config',$Data);            
        return $this->db->insert_id();
    }
    // update data common function
    public function updateData($Data,$shop)
    {        
        $this->db->where('shop',$shop);
        $this->db->update('ringbuilder_config',$Data);            
        return $this->db->affected_rows();
    }
     public function addSmtpData($Data)
    {   
        $this->db->insert('smtp_config',$Data);            
        return $this->db->insert_id();
    }
    // update data common function
    public function updateSmtpData($Data,$shop)
    {        
        $this->db->where('shopid',$shop);
        $this->db->update('smtp_config',$Data);            
        return $this->db->affected_rows();
    }

    public function getSmtpData($shop)
    {
        $this->db->where('shop_name',$shop);
        return $this->db->get('smtp_config')->first_row();
    }


    public function getDiamondConfig($shop)
    {
        $this->db->where('shop',$shop);
        return $this->db->get('ringbuilder_config')->first_row();
    }

    public function getAllOptions(){
        return [
            [
                'label' =>20,
                'value' =>20
            ],
            [
                'label' =>50,
                'value' =>50
            ],
            [
                'label' =>100,
                'value' =>100
            ]
        ];
    }

    public function getAllOptionsRings()
    {
        return [
            [
                'label' =>'Records Per Page: 12',
                'value' =>12
            ],
            [
                'label' =>'Records Per Page: 24',
                'value' =>24
            ],
            [
                'label' =>'Records Per Page: 48',
                'value' =>48
            ],
            [
                'label' =>'Records Per Page: 99',
                'value' =>99
            ]
        ];
    }

    public function getDiamondAttribute(){
        $gemDiamondAttributes = array();
        $gemDiamondAttributes['gemfind_diamond_cut'] = array('options' => [[
                'label' =>'Ideal',
                'value' =>1
            ],
            [
                'label' =>'Excellent',
                'value' =>2
            ],
            [
                'label' =>'V.Good',
                'value' =>3
            ],
            [
                'label' =>'Good',
                'value' =>4
            ],
            [
                'label' =>'Fair',
                'value' =>5
            ]]);
        $gemDiamondAttributes['gemfind_diamond_intintensity'] = array(
            'options' => [[
                'label' =>'Faint',
                'value' =>'faint'
            ],
            [
                'label' =>'V.Light',
                'value' =>'very light'
            ],
            [
                'label' =>'Light',
                'value' =>'light'
            ],
            [
                'label' =>'F.Light',
                'value' =>'fancy light'
            ],
            [
                'label' =>'Fancy',
                'value' =>'fancy'
            ],
            [
                'label' =>'Dark',
                'value' =>'fancy dark'
            ],
            [
                'label' =>'Intense',
                'value' =>'fancy intense'
            ],
            [
                'label' =>'Vivid',
                'value' =>'fancy vivid'
            ],
            [
                'label' =>'Deep',
                'value' =>'fancy deep'
            ]]);
        return $gemDiamondAttributes;
    }

    public function getResultsPerPage(){
        return 20;
    }
    public function getResultsPerPageRB(){
        return 12;
    }

    public function getmountingdetailapi($shop){
        $this->db->where('shop',$shop);
        $this->db->select('mountinglistapifancy');
        $mountinglistapifancy = $this->db->get('ringbuilder_config')->first_row();
        return $mountinglistapifancy->mountinglistapifancy;
    }
    
    public function getShopSmtp($shop){
        $this->db->where('shop_name',$shop);
        $this->db->select('*');
        $smptpdata = $this->db->get('smtp_config')->first_row();
        return $smptpdata;
    }

    public function generalAddData($Data,$tablename)
    {   
        $this->db->insert($tablename,$Data);            
        return $this->db->insert_id();
    }

    public function generalGetData($wherevalue,$wherefieldname,$tablename)
    {   
        $this->db->where($wherefieldname,$wherevalue);           
        return $this->db->get($tablename)->first_row();
    }

    // update data common function
    public function generalUpdateData($updatedata,$wherefieldname,$wherevalue,$tablename)
    {        
        $this->db->where($wherefieldname,$wherevalue);
        $this->db->update($tablename,$updatedata);            
        return $this->db->affected_rows();
    }
	
	public function addCustomerData($Data)
	{
		$this->db->insert('customer',$Data);            
        return $this->db->insert_id();
	}
	
	public function getAppChargesData($shop)
	{
		$this->db->where('shop',$shop);
        $this->db->select('*');
        $resultCharges = $this->db->get('app_charges')->first_row();
        return $resultCharges->cid;
	}
    public function modifyAppStatus($shop,$data)
    {
        $this->db->set('status', 'Inactive');
        $this->db->where('shop',$shop);
        $this->db->update('app_charges',$data);            
        return $this->db->affected_rows();
    }

    public function getAppStatus($shop)
    {
        $this->db->where('shop',$shop);
        $this->db->select('*');
        $resultStatus = $this->db->get('app_charges')->first_row();
        return $resultStatus->status;
    }

    public function getAppDetails($shop)
    {
        $this->db->where('shop',$shop);
        return $this->db->get('app_charges')->first_row();
    }

	public function getCustomerData($shop){
        $this->db->where('shop',$shop);
        $this->db->select('*');
        $resultCustomer = $this->db->get('customer')->first_row();
        return $resultCustomer->id;
		/*$this->db->select('*');
		$this->db->join('ringbuilder_config', 'customer.shop = ringbuilder_config.shop');
		$this->db->where('customer.shop', $shop);
		$resultCustomer = $this->db->get('customer')->first_row();
		return $resultCustomer->id;*/
    }
     public function getCustomerDetail($shop)

    {

        $this->db->where('shop',$shop);

        return $this->db->get('customer')->first_row();

    }
     public function getCustomerEmail($shop){
        $this->db->where('shop',$shop);
        $this->db->select('*');
        $resultCustomer = $this->db->get('customer')->first_row();
        return $resultCustomer->email;
    }
	
	public function getDiamondConfigData($shop)
	{
		$this->db->where('shop',$shop);
        $this->db->select('*');
        $resultConfig = $this->db->get('ringbuilder_config')->first_row();
        return $resultConfig->id;
	}

    public function getNavigationapiRb($shop)
    {
        $this->db->where('shop',$shop);
        $this->db->select('navigationapirb');
        return $this->db->get('ringbuilder_config')->first_row();
    }
}
?>