<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$shop = $_GET['shop'];
$showPoweredBy = $this->diamond_lib->showPoweredBy($shop);
if($showPoweredBy == 'true'){ ?>
<span class="gemfind_powered_by"><a href="https://gemfind.com/" target="_blank" rel="nofollow">Powered By GemFind</a></span>
<?php } ?>
<input type="hidden" name="gemfind_rb_version" value="2.2" />

<?php 
	
	$api_version = $this->config->item('shopify_api_version');
	$shop_access_token = $this->diamond_lib->getShopAccessToken($shop);
	$storeDetailUrlEndpoint = "https://".$shop."/admin/api/".$api_version."/themes.json";
	$request_headers = array(
            "X-Shopify-Access-Token:" . $shop_access_token,
            "Content-Type:application/json"
        );
	$shopData =  getCurlData($storeDetailUrlEndpoint,$request_headers);
	?><span class="test121" style="display:none;"></span><?php
	$impulse_theme_found = '';
	foreach ($shopData->themes as $key => $value) {
		if($value->role == 'main' && $value->name == 'Impulse'){
			$impulse_theme_found = 'impulse-gemfind';
		}
		if($value->role == 'main' && $value->name == 'Empire'){
			$impulse_theme_found = 'empire-gemfind';
		}
		if($value->role == 'main' && $value->name == 'Carbon Diamonds'){
			$impulse_theme_found = 'impulse-gemfind';
		}
		if($value->role == 'unpublished' && $value->theme_store_id == '796'){
			$impulse_theme_found = 'impulse-gemfind';
		}
	}
	$dealerID = $this->diamond_lib->getUsername($shop);
	$body_class = str_replace('.', '-', $shop);
?>
<script type="text/javascript">
	var theme_class = '';
	var dealerid = '<?php echo $dealerID; ?>';
	var shop = '<?php echo $body_class; ?>';
	theme_class = '<?php echo $impulse_theme_found; ?>';
	jQuery('body').addClass('dealer-'+dealerid);
	jQuery('body').addClass(shop);
	jQuery('body').addClass(theme_class);
</script>

