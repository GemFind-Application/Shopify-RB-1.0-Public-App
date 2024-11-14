<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('header'); 

$this->load->helper('common');
$this->load->library('user_agent');


$shop = $this->input->get('shop');
$access_token = $this->ringbuilder_lib->getShopAccessToken($shop); 
$pathprefixshop = $this->input->get('path_prefix');

$final_shop_url = actual_shop_address($access_token,$shop,$pathprefixshop,true);
$base_shop_domain = actual_shop_address($access_token,$shop,$pathprefixshop);

$noimageurl = base_url()."/assets/images/no-image.jpg";
$loadingimageurl = base_url()."/assets/images/loader-2.gif";
$tszview = base_url()."/assets/images/360-view.png";
$printIcon = base_url()."/assets/images/print_icon.gif";

$shopdata = array('shopurl' => $shop);

$this->load->view('settings/head',$shopdata );

if ($this->agent->is_referral())
{
    $referrerUrl = $this->agent->referrer();
}else{
   $referrerUrl = $final_shop_url;
}
?>


<script type="text/javascript">
    var shopurl = '',
      baseurl = '',
      pathprefixshop = '',
      finalshopurl = '';

  shopurl = '<?php echo $shop; ?>';
  base_shop_url = '<?php echo $base_shop_domain; ?>';
  baseurl = '<?php echo base_url()?>';
  pathprefixshop = '<?php echo $pathprefixshop; ?>';
  ringpath = '<?php echo $ring_path; ?>';
  finalshopurl = '<?php echo $final_shop_url; ?>';
</script>
<script src="<?php echo base_url()?>assets/js/getdetailcookie.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>assets/js/ringview.js"></script>
<link href="<?php echo base_url()?>assets/css/sumoselect.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">

<div class="loading-mask gemfind-loading-mask" id="gemfind-loading-mask" style="display: none;">

   <div class="loader gemfind-loader">

      <p>Please wait...</p>

   </div>

</div>
<div class="ringbuilder-settings-view">
<div id="search-rings" class="flow-tabs">

   
   

   

</div>
</div>

<script type="text/javascript">
   jQuery(document).on('submit','form#add_diamondtoring_form',function(e){
      var pathname = window.location.pathname; 
      var pathArr = pathname.split('/');
      var ring_path;
      ring_path =  pathArr[6];

      var final_shop_url = '<?php echo $final_shop_url; ?>';
      var ringData = [];
      var data = {};
      //var caratRange = $("#centerstonesize :selected").text();
      var caratRange = $("form#add_diamondtoring_form #centerstonesizevalue").val();
      
      var caratRangeArray = caratRange.split('-');

      data.ringsizewithdia = jQuery("#ringsizewithdia").val();
      //data.ringmaxcarat = jQuery("#ringmaxcarat").val();
      //data.ringmincarat = jQuery("#ringmincarat").val();
      data.ringmaxcarat = jQuery.trim(caratRangeArray[1]);
      data.ringmincarat = jQuery.trim(caratRangeArray[0]);
      data.centerStoneFit = jQuery("#centerStoneFit").val();
      data.centerStoneSize = caratRange;
      data.sideStoneQuality = jQuery("#sidestonequalityvalue").val();
      data.setting_id = jQuery("#setting_id").val();
      data.isLabSetting = jQuery("#islabsettings").val();
      data.additionalInformation = jQuery("#additionalInformation").val();
      data.ringpath = ring_path;
      console.log(data);
      ringData.push(data);
      var expire = new Date();
      expire.setDate(expire.getDate() + 0.2 * 24 * 60 * 60 * 1000);
      jQuery.cookie("_shopify_ringsetting", JSON.stringify(ringData), {
         path: '/',
         expires: expire
      });
      //console.log('redirecting');
      
       //window.location.href = '<?php echo $final_shop_url.'/diamondtools/'; ?>';
      
   });
      /*var options1 = {
                 type: 'popup',
                 responsive: true,
                 innerScroll: true,
                 modalClass: 'internalusemodel'
            };
            var options2 = {
                 type: 'popup',
                 responsive: true,
                 innerScroll: true,
                 title: 'Vendor Infromation',
                 modalClass: 'dealerinfopopup'
            };
            var popup = modal(options1, $('#auth-section'));
            var popup = modal(options2, $('#dealer-info-section'));*/

</script>

<!-- <div id="popup-modal">
    <div class="note" style="display: none;"></div>
</div>
 -->
<div class="modal fade" id="popup-modal" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"></h4>
    </div>
    <div class="modal-body">
    	<p class="note"></p>
    </div>
  </div>
</div>
</div>
<?php include('footer.php'); ?>