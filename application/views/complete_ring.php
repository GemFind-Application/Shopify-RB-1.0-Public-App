<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('header');
$this->load->helper('common');


$shopurl = $shop_data['shop'];   
$pathprefixshop = $shop_data['path_prefix'];

$access_token = $this->diamond_lib->getShopAccessToken($shopurl); 
$final_shop_url = actual_shop_address($access_token,$shopurl,$pathprefixshop,true);


$shopdata = array('shopurl' => $shopurl);
$this->load->view('head',$shopdata );
$noimageurl = base_url()."/assets/images/no-image.jpg";
?>
<script type="text/javascript">
	var shopurl = '',
	  	baseurl = '',
	  	pathprefixshop = '',
	  	finalshopurl = '';

  	shopurl = '<?php echo $shopurl; ?>';
  	baseurl = '<?php echo base_url()?>';
  	pathprefixshop = '<?php echo $pathprefixshop; ?>';
  	finalshopurl = '<?php echo $final_shop_url; ?>';
</script>
<script src="<?php echo base_url()?>assets/js/completeringcookie.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.sumoselect.js"></script>
<script src="<?php echo base_url()?>assets/js/touchit.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>assets/js/ringview.js"></script>
<link href="<?php echo base_url()?>assets/css/sumoselect.css" rel="stylesheet">

<div class="loading-mask gemfind-loading-mask" id="gemfind-loading-mask" style="display: none;">
    <div class="loader gemfind-loader">
        <p><?php echo 'Please wait...' ?></p>
    </div>
</div>
<div class="ringbuilder-diamond-completering">
	<div id="search-rings" class="flow-tabs"></div>
</div>

<div class="modal fade" id="popup-modal" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      
    </div>
    <div class="modal-body">
    	<p class="note"></p>
    </div>
  </div>
</div>
</div>
<?php 
$this->load->view('footer'); ?>