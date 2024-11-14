<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$store_token = $access_token;
$footer_data['shop_access_token'] = $store_token;
$request_headers = array(
        "X-Shopify-Access-Token:" . $store_token,
        "Content-Type:application/json"
    );
$result_charges = '';
$api_version = $this->config->item('shopify_api_version');
if($recurring_charges_data->charge_id){
$get_charges_list_endpoint = $this->config->item('final_shop_url')."/admin/api/".$api_version."/recurring_application_charges/".$recurring_charges_data->charge_id.".json";
$result_charges = getCurlData($get_charges_list_endpoint,$request_headers);
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@4.5.0/styles.min.css" />
<style type="text/css">
 #loader {
	  display: none;
	  position: fixed;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  width: 100%;
	  background: rgba(0,0,0,0.75) url(<?php echo base_url()."assets/images/loading2.gif";?>) no-repeat center center;
	  z-index: 10000;
 }
 body{background-color:#fff;}
.view-in-front, .view-in-front:active, .view-in-front:focus{
    box-sizing: border-box;
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 3.6rem;
    min-width: 3.6rem;
    margin: 0;
    padding: .7rem 1.6rem;
    border: .1rem solid var(--p-border,#c4cdd5);
    box-shadow: 0 1px 0 0 rgba(22,29,37,.05);
    border-radius: 3px;
    line-height: 1;
    color: #212b36;
    text-align: center;
    cursor: pointer;
    user-select: none;
    text-decoration: none;
    background: linear-gradient(180deg,#f9fafb,#f4f6f8);
    border-color: #c4cdd5;
}
.view-in-front:hover{box-shadow: 0 0 0 0 transparent, inset 0 1px 1px 0 rgba(99,115,129,.1), inset 0 1px 4px 0 rgba(99,115,129,.2); text-decoration: none;}
.dearlercode-form, .upgrade_message{padding: 12px 30px}
.alert {position: relative;padding: .75rem 1.25rem;margin-bottom: 1rem;border: 1px solid transparent;border-radius: .25rem;}
.alert-success {color: #155724;background-color: #d4edda;border-color: #c3e6cb;}
.form-body {padding: 2rem;background-color: #f4f4f4;}
form#SystemOption {
    margin-bottom: 45px;
}
.form-actions.right {
    padding: 0 2rem;
}
#SubmitDiamondSetting{
background: linear-gradient(180deg,#6371c7,#5563c1);
border-color: #3f4eae;
box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgba(22,29,37,.05), 0 0 0 0 transparent;
color: #fff;
padding: 6px 25px;
}
#SubmitDiamondSetting:hover{background: linear-gradient(180deg,#5c6ac4,#4959bd);border-color: #3f4eae;color: #fff;text-decoration: none;}
.getting-started-banner{display: flex;}
.getting-started-banner .getting-started-banner--image {
    width: 240px;
    height: auto;
    display: inline-flex;
    padding: 60px 30px;
    background-color: #F9FAFB;
    border: 1px solid #DFE3E8;
}
.getting-started-banner .getting-started-banner--image img {
    max-width: 100%;
    width: 100%;
}
.getting-started-banner .getting-started-banner--content {
    width: 80%;
    padding: 30px;
    background-color: #F9FAFB;
	border: 1px solid #DFE3E8;
}
.getting-started-banner .getting-started-banner--content .banner__title {
    font-size: 16px;
    line-height: 24px;
    color: #31373D;
    font-weight: 500;
}
.getting-started-banner .getting-started-banner--content .banner__content {
    font-size: 14px;
    line-height: 20px;
    color: #212B36;
    margin: 20px 0;
}
.Polaris-Button a, .Polaris-Banner__PrimaryAction a{text-decoration: none;color: #212b36;}
.Polaris-Button a:hover,  .Polaris-Banner__PrimaryAction a:hover{text-decoration: none;}
.Polaris-Button:hover {
    background: linear-gradient(180deg,#f9fafb,#d7dadc);
    border-color: #c4cdd5;
}
#getting_started .Polaris-Layout__Section {
    padding-top: 35px;
    margin: 0;
    max-width: 100%;
}
#knowledge .Polaris-Layout__Section{margin: 0px;}
.Polaris-Layout{
	margin: 0;
	    padding-bottom: 40px;
}
#myTab {
    border: none;
}
.nav-tabs>li.nav-item>a.nav-link{border: none;border-radius: 4px 4px 4px 4px;}
.nav-tabs>li.nav-item.active>a.nav-link, .nav-tabs>li.nav-item.active>a.nav-link:focus, .nav-tabs>li.nav-item.active>a.nav-link:hover{border: none; background: linear-gradient(180deg,#6371c7,#5563c1);border-color: #3f4eae;box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgba(22,29,37,.05), 0 0 0 0 transparent;color: #fff;}
.nav-tabs>li.nav-item>a.nav-link:hover{border: none; background: linear-gradient(180deg,#6371c7,#5563c1);border-color: #3f4eae;box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgba(22,29,37,.05), 0 0 0 0 transparent;color: #fff;}
.help-text{
	    font-size: 29px;
    position: relative;
    display: inline-table;
    padding-top: 25px;
    padding-bottom: 25px;
    font-weight: 600;
}
li.Polaris-ResourceList__ItemWrapper{
	padding: 15px;
    border: 1px solid #ccc;
}
.Polaris-Layout__Section.help_center {
    padding-bottom: 35px;
}
.tab-content>.tab-pane{padding-top: 20px;}
.quick_links{float: right !important;margin-right: 5px;}
li.quick_links > a:active{margin-right: 2px;}
.nav-tabs>li.quick_links>a{border-radius: 4px 4px 4px 4px;padding: .7rem 1.6rem; border: 1px solid #c4cdd5;}
.card-header{font-size: 1rem;line-height: 1.5;color: #212529;text-align: left;font-family: "Roboto",sans-serif;font-weight: 400;box-sizing: border-box;margin-bottom: .25rem !important;box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12) !important;border-radius: 0;padding: 1rem 1.5rem;background: transparent;border: 0;}
.card-header .mb-0 .btn.btn-link{width: 100%;text-align: left;font-weight: 600;color:#212b36;font-size: 16px;}
.card-header .mb-0 .btn.btn-link:hover{text-decoration: none;}
#accordion .card-body{
	text-align: left;
	font-family: "Roboto",sans-serif;
	box-sizing: border-box;
	flex: 1 1 auto;
	min-height: 1px;
	padding: 1.25rem;
	margin-bottom: .25rem !important;
	background-color:rgb(189 189 189 / 30%);
	padding-top: 1.5rem;
	padding-bottom: 1.5rem;
	border-radius: 0 !important;
	font-size: 1em;
    font-weight: 400;
	line-height: 1.7;
	border: 0;
}
.card-header .mb-0 .btn.btn-link:focus {
    outline: none;
    text-decoration: none;
}
.rotate-icon{float: right;font-size: 23px;}
#accordion .card .card-header button:not(.collapsed) .rotate-icon {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
}
.field_usage_section {
    padding: 10px;
    line-height: 25px;
    color: black;
    border: 1px solid #ccc;
    transition: box-shadow .2s cubic-bezier(.64,0,.35,1);
    transition-delay: .1s;
    box-shadow: inset 0 3px 0 0 #47c1bf, inset 0 0 0 0 transparent, 0 0 0 1px rgba(63,63,68,.05), 0 1px 3px 0 rgba(63,63,68,.15);
    background-color: #eef9f9;
}
.field_item h3{font-weight: 600;}

.fieldtooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
      top: -23px;
    left: -133px;
}

.fieldtooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.fieldtooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.gemfind_powered_by {
    float: right;
    width: 100%;
    text-align: right;
    display: block;
    margin-bottom: 30px;
    color: #000;
}
.gemfind_powered_by a{color: inherit;}
.form-submitmsg{display:none;}
.heading-customerform{
	font-size: 29px;
    position: relative;
    display: inline-table;
    padding-top: 25px;
    padding-bottom: 25px;
    font-weight: 600;
}
.frmcustomer .form-actions.right{
    margin-top: 15px;
	padding: 0 !important;
}
#SubmitCustomerInfo {
    background: linear-gradient(180deg,#6371c7,#5563c1);
    border-color: #3f4eae;
    box-shadow: inset 0 1px 0 0 #6774c8, 0 1px 0 0 rgb(22 29 37 / 5%), 0 0 0 0 transparent;
    color: #fff;
    padding: 6px 25px;
	margin: 15px;
}
</style>

<script type="text/javascript">
	setTimeout(function(){
		$(".alert").fadeOut();
	},5000);
	
</script>
<div class="dearlercode-form">
	<?php if($this->session->flashdata('SystemOptionMSG')){?>
		<div class="alert alert-success">
			<strong>Success!</strong> <?php echo $this->session->flashdata('SystemOptionMSG');?>
		</div>
	<?php } ?>
	<div class="alert alert-success form-submitmsg">
		<strong>Success!</strong> <?php echo $this->session->flashdata('SystemOptionMSG');?>
	</div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item active">
    <a class="nav-link active" id="started-tab" data-toggle="tab" href="#getting_started" role="tab" aria-controls="getting_started" aria-selected="true">Getting Started</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="knowledge-tab" data-toggle="tab" href="#knowledge" role="tab" aria-controls="knowledge" aria-selected="false">Knowledge Base</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false">Settings</a>
  </li>
  <li class="quick_links">
  	<a href="<?php echo $this->config->item('final_shop_url')."/admin/apps/"; ?>" target="_top" rel="noopener noreferrer" class="view-in-front">Back to Apps Listing</a>
  </li>
  <?php if($diamondconfigdata->dealerid){?>
	  <li class="quick_links">
	  	<a href="<?php echo $this->config->item('final_shop_url')."/apps/ringbuilder/settings/"; ?>" target="_blank" class="view-in-front">View in Frontend</a>
	  </li>
	<?php }?>
</ul>

<div class="tab-content" id="myTabContent">
	<div class="tab-pane active" id="getting_started" role="tabpanel" aria-labelledby="started-tab">
		<div class="Polaris-Layout">
		   	<div class="Polaris-Layout__Section">
		   		<div class="getting-started-banner">
		   			<div class="getting-started-banner--image">
		   				<img src="<?php echo base_url();?>/assets/images/getting-started.png">
		   			</div>
		   			<div class="getting-started-banner--content">
		   				<h3 class="banner__title">Next Steps for Getting Started with GemFind RingBuilder</h3>
						<p>&nbsp;</p>
						<ul>
							<li>Your RingBuilder app <a href="https://gemfind.com/ringbuilder/#table" target="_blank">requires</a> a Jewelcloud account with GemFind.</li>
							<li>Once your Jewelcloud account has been activated our support team will walk you through the steps of selecting your setting and diamond vendors, and setting your markups.</li>
							<li>Please click the button below and fill out the application for your Jewelcloud account.</li>
						</ul>
		   				<!--<p class="banner__content">RingBuilderⓇ by GemFind expands your online inventory allowing you to display and sell virtual rings and diamonds to your potential customers. RingBuilderⓇ automatically connects retailers with top US ring and diamond suppliers through our proprietary platform JewelCloudⓇ Network or we can connect and add a Rapnet, IDEX, or Polygon data feed.</p>
		   				<p class="banner__content">With this app, you can showcase rings and diamonds from select US diamond suppliers on a retail jewelry websites, and enable your customers to search for rings and diamonds by indicating the specifics of what they are looking for.</p>-->
						<p>&nbsp;</p>
		   				<button type="button" class="Polaris-Button"><a href="https://gemfind.com/ringbuilder-yearly/" target="_blank"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Activate your JewelCloud Account</span></span></a></button>
						<p>&nbsp;</p>
						<p>Got questions? Contact us at <a href="mailto:sales@gemfind.com" target="_blank">sales@gemfind.com</a> or <a href="tel:800-373-4373" target="_blank">800-373-4373</a></p>
		   			</div>
		   		</div>
			</div>
			<!--<div class="Polaris-Layout__Section">
				<div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner28Heading" aria-describedby="Banner28Content"><div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4.1a1.1 1.1 0 1 0 .001 2.201A1.1 1.1 0 0 0 10 13.9M10 4C8.625 4 7.425 5.161 7.293 5.293A1.001 1.001 0 0 0 8.704 6.71C8.995 6.424 9.608 6 10 6a1.001 1.001 0 0 1 .591 1.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path></svg></span></div><div class="Polaris-Banner__ContentWrapper">
				 	<div class="Polaris-Banner__Heading" id="Banner28Heading">
				 		<p class="Polaris-Heading">Need to know more about JewelCloud?</p>
				 	</div>
					 <div class="Polaris-Banner__Content" id="Banner28Content">
					 	<p>JewelCloud® is an app that allows you to showcase products from suppliers and offer your customers an improved shopping experience.</p>
					 	<br>
					 	<p>This cloud-based software provides an account that enables you to leverage your vendors’ product data, product images, client rules, and marketing assets — all managed from a central location.</p>
					 	<br>
					 	<p>JewelCloud® has over 150 jewelry and diamond suppliers for you to choose from, giving you the opportunity to showcase thousands of products from your site. No more taking images, managing prices, or checking to see if a product has been discontinued. You’ll also eliminate the need for vendor microsites, as products will reside within your own website.</p>
					 	<br>
					 	<p>JewelCloud® empowers you to increase your brand awareness, productivity, efficiency, leads and sales conversions — all within one easy-to-use app.</p>
					 	<div class="Polaris-Banner__Actions"><div class="Polaris-ButtonGroup"><div class="Polaris-ButtonGroup__Item"><div class="Polaris-Banner__PrimaryAction"><a target="_blank" class="Polaris-Button Polaris-Button--outline" href="https://gemfind.com/jewelcloud/" rel="noopener noreferrer" data-polaris-unstyled="true"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Request a Free Demo</span></span></a></div></div></div></div>
					 </div></div>
				</div>
			</div>-->
	   	</div>
	</div>
	<div class="tab-pane" id="knowledge" role="tabpanel" aria-labelledby="knowledge-tab">
	<div class="Polaris-Layout">
		<div class="Polaris-Layout__Section help_center">
			<span class="help-text">Help Center</span>
			 <div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner28Heading" aria-describedby="Banner28Content"><div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4.1a1.1 1.1 0 1 0 .001 2.201A1.1 1.1 0 0 0 10 13.9M10 4C8.625 4 7.425 5.161 7.293 5.293A1.001 1.001 0 0 0 8.704 6.71C8.995 6.424 9.608 6 10 6a1.001 1.001 0 0 1 .591 1.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path></svg></span></div><div class="Polaris-Banner__ContentWrapper"><div class="Polaris-Banner__Heading" id="Banner28Heading"><p class="Polaris-Heading">We’d love to hear from you</p></div><div class="Polaris-Banner__Content" id="Banner28Content"><p>Need help? Schedule a Free Consultation by clicking below link</p><div class="Polaris-Banner__Actions"><div class="Polaris-ButtonGroup"><div class="Polaris-ButtonGroup__Item"><div class="Polaris-Banner__PrimaryAction"><a target="_blank" class="Polaris-Button Polaris-Button--outline" href="https://gemfind.com/free-consultation/" rel="noopener noreferrer" data-polaris-unstyled="true"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Free Consultation</span></span></a></div></div></div></div></div></div></div>
			</div>
			<div class="Polaris-Layout__Section">
			<div class="knowledge_base_section">
				<span class="help-text">Knowledge Base</span>
				<div id="accordion">
					  <div class="card">
					    <div class="card-header" id="headingOne">
					      <h5 class="mb-0">
					        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					          What is JewelCloud?
					          <i class="fa fa-angle-down rotate-icon" aria-hidden="true"></i>
					        </button>

					      </h5>
					    </div>

					    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
					      <div class="card-body">
					        JewelCloud® is an app that allows you to showcase products from suppliers and offer your customers an improved shopping experience.
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingTwo">
					      <h5 class="mb-0">
					        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					          What is the use of RingBuilder?
					          <i class="fa fa-angle-down rotate-icon" aria-hidden="true"></i>
					        </button>
					      </h5>
					    </div>
					    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
					      <div class="card-body">
					        RingBuilder ® is a retail ring and diamond sourcing app that allows retailers to curate a list of ring and diamond suppliers for online shopping on their websites.
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingThree">
					      <h5 class="mb-0">
					        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					          Where to get the DealerID?
					          <i class="fa fa-angle-down rotate-icon" aria-hidden="true"></i>
					        </button>
					      </h5>
					    </div>
					    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
					      <div class="card-body">
					        JewelCloud membership need to take to subscribe for RingBuilder. Click link below to access and get more details about your Dealer ID. Dealer ID is required to communicate with JC and display data in store frontend.
					        <div class="Polaris-Banner__PrimaryAction"><a target="_blank" class="Polaris-Button Polaris-Button--outline" href="https://gemfind.com/jewelcloud/" rel="noopener noreferrer" data-polaris-unstyled="true"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Get the credentials</span></span></a></div>
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingFour">
					      <h5 class="mb-0">
					        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
					          How to use the app?
					          <i class="fa fa-angle-down rotate-icon" aria-hidden="true"></i>
					        </button>
					      </h5>
					    </div>
					    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
					      <div class="card-body">
					        <h3><strong>Admin Cases:</strong></h3>
								<p>After installing the app, you will have to enter DealerID in Setting tab. You can adjust other settings according to your preference. You have to subscribe to JewelCloud for get the DealerID and it will be used in this app to function. <a href="https://gemfind.com/jewelcloud/" target="_blank">Click here</a> for more details.</p>
							<hr>
							<h3><strong>Front Cases:</strong></h3>
								<p>After installing and configure the app from Setting tab, you will see View in Frontend button in top right area. By clicking on that button you will be redirected to frontend view of the app. It will be having following steps in order to buy the Ring or Diamond or Both.</p>
								<ul>
									<li>On the first page, it will list down all rings from cloud-based software JewelCloud within your account.</li>
									<li>You can select the ring or you can use the different filters. Click on the selected ring to view the details. </li>
									<li>On the detail page, you will see all the property of ring. </li>
									<li>On the detail page, you can share the ring to your friend via email or you can request for more info from vendor. The detail page also have more features like Drop a Hint, in which you can send the custom message to friend via email if they wants the diamond as a gift or something else.</li>
									<li>On ring detail page. you can buy ring only by clicking on Add to cart button. It will create the product in store first and then add the same to cart for checkout. Or else you can diamond to the ring and move in the process further for selecting diamond</li>
									<li>Once you click on Add Diamond button, it will list down all diamonds based on your selection of ring.</li>
									<li>You can select the diamond of your choice or you can use the different filters. Click on the selected diamond to view the details. </li>
									<li>On the detail page, you will see all the property of diamond. </li>
									<li>On the detail page, you can complete the ring or else buy the diamond only. </li>
									<li>On the complete ring page, you will see the final information of selected ring and selected diamond. With these you can finally purchase the whole ring by adding to cart. </li>
									<li>All the ring and diamond related data are coming via API from JewelCloud within the retailer account, and we are showcasing products inside the store and offer the customers an improved shopping experience.</li>
								</ul>
					        <div class="Polaris-Banner__PrimaryAction"><a target="_blank" class="Polaris-Button Polaris-Button--outline" href="https://gemfind.com/ringbuilder/#table" rel="noopener noreferrer" data-polaris-unstyled="true"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Click here to Subscribe</span></span></a></div>
					      </div>
					    </div>
					  </div>
					</div>
				<ul class="Polaris-ResourceList hide">
					<li class="Polaris-ResourceList__ItemWrapper">
						<div class="Polaris-ResourceItem">
							   <div class="article-row"><div class="details"><h3><span class="Polaris-TextStyle--variationStrong">What is JewelCloud?</span></h3>
							   	<p class="description">JewelCloud® is an app that allows you to showcase products from suppliers and offer your customers an improved shopping experience.</p>
							   </div>
							</div>
						</div>
					</li>
					<li class="Polaris-ResourceList__ItemWrapper">
						<div class="Polaris-ResourceItem">
							   <div class="article-row"><div class="details"><h3><span class="Polaris-TextStyle--variationStrong">What is the use of RingBuilder</span></h3>
							   	<p class="description">RingBuilder® is a retail ring sourcing app that allows retailers to curate a list of ring suppliers for online shopping on their websites.</p>
							   </div>
							</div>
						</div>
					</li>
					<li class="Polaris-ResourceList__ItemWrapper">
						<div class="Polaris-ResourceItem">
							   <div class="article-row"><div class="details"><h3><span class="Polaris-TextStyle--variationStrong">Where to get the DealerID?</span></h3>
							   	<p class="description">JewelCloud membership need to take to subscribe for RingBuilder. Click link below to access and get more details about your Dealer ID. Dealer ID is required to communicate with JC and display data in store frontend.</p>
							   	<div class="Polaris-Banner__PrimaryAction"><a target="_blank" class="Polaris-Button Polaris-Button--outline" href="https://gemfind.com/jewelcloud/" rel="noopener noreferrer" data-polaris-unstyled="true"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Get the credentials</span></span></a></div>
							   </div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		</div>
	</div>
	<div class="tab-pane" id="setting" role="tabpanel" aria-labelledby="setting-tab">
		<?php if($recurring_charges_data->charge_id =='' &&  $recurring_charges_data->status != 'active'){?>
		<div class="Polaris-Card__Section">
			<div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--withinContentContainer" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner8Heading" aria-describedby="Banner8Content">
				<div class="Polaris-Banner__Ribbon">
					<span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
						<svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><circle cx="10" cy="10" r="9" fill="currentColor"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m1-5v-3a1 1 0 0 0-1-1H9a1 1 0 1 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2m-1-5.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2"></path></svg>
					</span>
				</div>
				<div>
					<div class="Polaris-Banner__Heading" id="Banner8Heading">
						<p class="Polaris-Heading">Basic Plan Inactive</p>
					</div>
					<div class="Polaris-Banner__Content" id="Banner8Content">
						<p>You have to subscribe to the GemFind Basic Plan before using the app. Click on below link to activate.</p>
						<p><a href="<?php echo base_url();?>charge?<?php echo $_SERVER['QUERY_STRING']."&code_access=".$access_token; ?>"  target="_top" rel="noopener noreferrer">Activate</a></p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php 
		if(isset($customer) && $customer != "")
		{
			if($recurring_charges_data->charge_id !='' &&  $recurring_charges_data->status == 'active')
			{	
	    ?>
			<form action="" method="post" id="SystemOption" name="SystemOption" class="form-horizontal">
				<input type="hidden" name="sp_access_token" value="<?php echo $store_token?>">
				<div class="form-body">
																					
					<div class="form-group">
						<div class="col-md-6">	
							<label class="control-label">Dealer ID</label>										
							<input type="text" name="dealerid" value="<?php echo $diamondconfigdata->dealerid;?>" class="form-control" maxlength="255">
						</div>
						<div class="col-md-6">
							<label class="control-label">Admin Email Address</label>										
							<input type="text" name="admin_email_address" value="<?php echo $diamondconfigdata->admin_email_address;?>" class="form-control" maxlength="255">
						</div>
					</div>					
													
					<div class="form-group hide">
						<div class="col-md-6">
							<label class="control-label">Dealer Auth API</label>	
							<input type="text" name="dealerauthapi" value="<?php echo ($diamondconfigdata->dealerauthapi ? $diamondconfigdata->dealerauthapi : "http://api.jewelcloud.com/api/RingBuilder/AccountAuthentication");?>" class="form-control" maxlength="255" readonly>	
						</div>
						<div class="col-md-6">
							<label class="control-label">Navigation Api</label>										
							<input type="text" name="navigationapi" value="<?php echo ($diamondconfigdata->navigationapi ? $diamondconfigdata->navigationapi : "http://api.jewelcloud.com/api/RingBuilder/GetNavigation?");?>" class="form-control" maxlength="255" readonly>
						</div>
					</div>

					<div class="form-group hide">
						<div class="col-md-6">
							<label class="control-label">Ring's Filters API URL</label>	
							<input type="text" name="ringfiltersapi" value="<?php echo ($diamondconfigdata->ringfiltersapi ? $diamondconfigdata->ringfiltersapi : "http://api.jewelcloud.com/api/RingBuilder/GetFilters?");?>" class="form-control" maxlength="255" readonly>	
						</div>
						<div class="col-md-6">
							<label class="control-label">Mountinglist API URL</label>										
							<input type="text" name="mountinglistapi" value="<?php echo ($diamondconfigdata->mountinglistapi ? $diamondconfigdata->mountinglistapi : "http://api.jewelcloud.com/api/RingBuilder/GetMountingList?");?>" class="form-control" maxlength="255" readonly>
						</div>
					</div>

					<div class="form-group hide">
						<div class="col-md-6">
							<label class="control-label">MountingDetail API URL(Fancy Diamonds)</label>	
							<input type="text" name="mountinglistapifancy" value="<?php echo ($diamondconfigdata->mountinglistapifancy ? $diamondconfigdata->mountinglistapifancy : "http://api.jewelcloud.com/api/RingBuilder/GetMountingDetail?");?>" class="form-control" maxlength="255" readonly>	
						</div>
						<div class="col-md-6">
							<label class="control-label">Ring's Style Settings API URL</label>										
							<input type="text" name="ringstylesettingapi" value="<?php echo ($diamondconfigdata->ringstylesettingapi ? $diamondconfigdata->ringstylesettingapi : "http://api.jewelcloud.com/api/RingBuilder/GetStyleSetting?");?>" class="form-control" maxlength="255" readonly>
						</div>
					</div>

					<div class="form-group hide">
						<div class="col-md-6">
							<label class="control-label">Filter API</label>	
							<input type="text" name="filterapi" value="<?php echo ($diamondconfigdata->filterapi ? $diamondconfigdata->filterapi : "http://api.jewelcloud.com/api/RingBuilder/GetDiamondFilter?");?>" class="form-control" maxlength="255" readonly>	
						</div>
						<div class="col-md-6">
							<label class="control-label">Filter API Fancy</label>										
							<input type="text" name="filterapifancy" value="<?php echo ($diamondconfigdata->filterapifancy ? $diamondconfigdata->filterapifancy : "http://api.jewelcloud.com/api/RingBuilder/GetColorDiamondFilter?");?>" class="form-control" maxlength="255" readonly>
						</div>
					</div>
					
					<div class="form-group hide">
						<div class="col-md-6">
							<label class="control-label">Diamond List API</label>	
							<input type="text" name="diamondlistapi" value="<?php echo ($diamondconfigdata->diamondlistapi ? $diamondconfigdata->diamondlistapi : "http://api.jewelcloud.com/api/RingBuilder/GetDiamond?");?>" class="form-control" maxlength="255" readonly>	
						</div>
						<div class="col-md-6">
							<label class="control-label">Diamond List API Fancy</label>										
							<input type="text" name="diamondlistapifancy" value="<?php echo ($diamondconfigdata->diamondlistapifancy ? $diamondconfigdata->diamondlistapifancy : "http://api.jewelcloud.com/api/RingBuilder/GetColorDiamond?");?>" class="form-control" maxlength="255" readonly>
						</div>
					</div>

					<div class="form-group hide">
						<div class="col-md-4">
							<label class="control-label">Diamond Shape API</label>	
							<input type="text" name="diamondshapeapi" value="<?php echo ($diamondconfigdata->diamondshapeapi ? $diamondconfigdata->diamondshapeapi : "http://api.jewelcloud.com/api/ringbuilder/GetShapeByColorFilter?");?>" class="form-control" maxlength="255" readonly>	
						</div>
						<div class="col-md-4">
							<label class="control-label">Diamond Detail API</label>										
							<input type="text" name="diamonddetailapi" value="<?php echo ($diamondconfigdata->diamonddetailapi ? $diamondconfigdata->diamonddetailapi : "http://api.jewelcloud.com/api/RingBuilder/GetDiamondDetail?");?>" class="form-control" maxlength="255" readonly>
						</div>
						<div class="col-md-4">
							<label class="control-label">Style Setting API</label>	
							<input type="text" name="stylesettingapi" value="<?php echo ($diamondconfigdata->stylesettingapi ? $diamondconfigdata->stylesettingapi : "http://api.jewelcloud.com/api/RingBuilder/GetStyleSetting?");?>" class="form-control" maxlength="255" readonly>	
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="control-label">Enable Hint</label>										
							<select name="enable_hint" id="enable_hint" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->enable_hint == "true") ? "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->enable_hint == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
						<div class="col-md-6">
							<label class="control-label">Enable Email Friend</label>
							<select name="enable_email_friend" id="enable_email_friend" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->enable_email_friend == "true") ? "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->enable_email_friend == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
					</div>

					<div class="form-group">	
						<div class="col-md-6">
							<label class="control-label">Enable Schedule Viewing</label>
							<select name="enable_schedule_viewing" id="enable_schedule_viewing" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->enable_schedule_viewing == "true") ? "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->enable_schedule_viewing == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
						<div class="col-md-6">
							<label class="control-label">Enable More Info</label>
							<select name="enable_more_info" id="enable_more_info" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->enable_more_info == "true") ? "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->enable_more_info == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4">
							<label class="control-label">Enable Print</label>
							<select name="enable_print" id="enable_print" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->enable_print == "true") ? "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->enable_print == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
						<div class="col-md-4">
							<label class="control-label">Enable Admin Notification</label>
							<select name="enable_admin_notification" id="enable_admin_notification" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->enable_admin_notification == "true") ? "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->enable_admin_notification == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
						<div class="col-md-4">
							<label class="control-label">Show Info Boxes?</label>
							<select name="show_filter_info" id="show_filter_info" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->show_filter_info == "true") ?  "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->show_filter_info == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4">
							<label class="control-label">Diamond Listing Default View</label>
							<select name="default_viewmode" id="default_viewmode" class="form-control">
								<option value="list" <?php echo ($diamondconfigdata->default_viewmode == "list") ? "selected" : "" ?> >List</option>
								<option value="grid" <?php echo ($diamondconfigdata->default_viewmode == "grid") ? "selected" : "" ?> >Grid</option>
							</select>
						</div>
						<div class="col-md-4">
							<label class="control-label">Show Powered By?</label>
							<select name="show_powered_by" id="show_powered_by" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->show_powered_by == "true") ?  "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->show_powered_by == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
						<div class="col-md-4">
							<label class="control-label">Enable Sticky Header?</label>
							<select name="enable_sticky_header" id="enable_sticky_header" class="form-control">
								<option value="true" <?php echo ($diamondconfigdata->enable_sticky_header == "true") ?  "selected" : "" ?> >Yes</option>
								<option value="false" <?php echo ($diamondconfigdata->enable_sticky_header == "false") ? "selected" : "" ?> >No</option>
							</select>
						</div>
						
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="control-label">Shop</label>
							<input type="text" name="shop" value="<?php echo $diamondconfigdata->shop;?>" readonly class="form-control" maxlength="255">	
						</div>
						<div class="col-md-6">
							<label class="control-label">Shop Logo URL</label>										
							<input type="text" name="shop_logo" value="<?php echo $diamondconfigdata->shop_logo;?>" class="form-control" maxlength="255">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="control-label">Settings Carat Ranges</label>
							
							<textarea  name="settings_carat_ranges" class="form-control">
							<?php 
							if($diamondconfigdata->settings_carat_ranges){
								echo stripcslashes($diamondconfigdata->settings_carat_ranges);
							}else{
								echo '{"0.25":[0.2,0.3],"0.33":[0.31,0.4],"0.50":[0.41,0.65],"0.75":[0.66,0.85],"1.00":[0.86,1.14],"1.25":[1.15,1.40],"1.50":[1.41,1.65],"1.75":[1.66,1.85],"2.00":[1.86,2.15],"2.25":[2.16,2.45],"2.50":[2.46,2.65],"2.75":[2.66,2.85],"3.00":[2.85,3.25]}';
							}
							?>
							</textarea>	
						</div>
						
					</div>
				</div>
				<div class="form-actions right">
					<input type="submit" name="SubmitDiamondSetting" id="SubmitDiamondSetting" class="btn green" value="Submit">
				</div>
			</form>
			<div class="field_usage_section">
				<div class="Polaris-Banner__Heading" id="Banner28Heading">
					<p class="Polaris-Heading">Need help for each field what need to do? Below are the description of each field where it is using in app.</p>
				</div>
				<ul>
					<li class="field_item">
						<h3>DealerID </h3>
						<p>This is must required information which will be using to communicate with JewelCloud. You will find the DealerID inside your JewelCloud account. <a href="https://www.jewelcloud.com/" target="_blank">Click here</a> for more detail</p>
					</li>
					<li class="field_item">
						<h3>Admin Email Address </h3>
						<p>This is will be used to received the email notifications from end-user when they are requesting for the Request More Info or sending the Ring or Diamond details to any friend.</p>
					</li>
					<li class="field_item">
						<h3>Enable Hint </h3>
						<p>This will toggle the "Enable Hint" option on Ring and Diamond detail page.</p>
					</li>
					<li class="field_item">
						<h3>Enable Email Friend </h3>
						<p>This will toggle the "Enable Email Friend" option on Ring and Diamond detail page.</p>
					</li>
					<li class="field_item">
						<h3>Enable Schedule Viewing </h3>
						<p>This will toggle the "Enable Schedule Viewing" option on Ring and Diamond detail page.</p>
					</li>
					<li class="field_item">
						<h3>Enable More Info </h3>
						<p>This will toggle the "Enable Schedule Viewing" option on Ring and Diamond detail page.</p>
					</li>
					<li class="field_item">
						<h3>Enable Print </h3>
						<p>This will toggle the "Enable Print:" option on Diamond detail page.</p>
					</li>
					<li class="field_item">
						<h3>Enable Admin Notification </h3>
						<p>This will toggle the "Enable Admin Notification" option whether you want the notification to be receive on Admin Email address.</p>
					</li>
					<li class="field_item">
						<h3>Show Info Boxes? </h3>
						<p>This will toggle the "Info Boxes" on each filters. It will have more information about each filter</p>
					</li>
					<li class="field_item">
						<h3>Show Powered By? </h3>
						<p>This will toggle the "Powered By Gemfind" at the footer of the tool.</p>
					</li>
					<li class="field_item">
						<h3>Enable Sticky Header?</h3>
						<p>This will toggle the sticky table header at diamond listing page.</p>
					</li>
					<li class="field_item">
						<h3>Diamond Listing Default View </h3>
						<p>By this option, you can set whether you want the diamond listing in List or Grid view.</p>
					</li>
					<li class="field_item">
						<h3>Shop</h3>
						<p>It is just information purpose that what is the current store URL we are using inside configuration</p>
					</li>
					<li class="field_item">
						<h3>Settings Carat Ranges</h3>
						<p>The field is used for setting's carat ranges</p>
					</li>
					<li class="field_item">
						<h3>Shop Logo URL</h3>
						<p>It will need to enter the current shop logo URL which will used in emails which will send to end-users and store admin.</p>
					</li>					
				</ul>
	  	</div>
		<?php 
			}
		}
		else
			{
		?>
				<span class="heading-customerform">Customer Registration</span>
				<form action="" method="post" name="frmcustomer" class="frmcustomer">
				  <div class="form-body">
					<div class="form-group form-horizontal">
					  <div class="col-md-6">
						<label for="business">Name of Business:</label>
						<input type="hidden" name="shop" value="<?php echo $shop_url;?>" />	
						<input type="text" class="form-control" id="business" name="business" required />
					  </div>
					  <div class="col-md-6">
						<label for="name">First and Last name of Contact:</label>
						<input type="text" class="form-control" id="name" name="name" required />
					  </div>
					  <div class="col-md-6">
						<label for="address">Address:</label>
						<input type="text" class="form-control" id="address" name="address" required />
					  </div>
					  <div class="col-md-6">
						<label for="address">State:</label>
						<input type="text" class="form-control" id="state" name="state" required />
					  </div>
					  <div class="col-md-6">
						<label for="address">City:</label>
						<input type="text" class="form-control" id="city" name="city" required />
					  </div>
					   <div class="col-md-6">
						<label for="address">Zip code:</label>
						<input type="text" class="form-control" id="zip_code" name="zip_code" required />
					  </div>
					  <div class="col-md-6">
						<label for="telephone">Telephone:</label>
						<input type="text" class="form-control" id="telephone" name="telephone" required />
					  </div>
					  <div class="col-md-6">
						<label for="website_url">Website url:</label>
						<input type="text" class="form-control" id="website_url" name="website_url" required />
					  </div>
					  <div class="col-md-6">
						<label for="email">Email Address:</label>
						<input type="text" class="form-control" id="email" name="email" required />
					  </div>
					  <div class="form-actions right">
						<input type="submit" name="SubmitCustomerInfo" id="SubmitCustomerInfo" class="btn green" value="Submit">
					  </div>
					</div>
			    </div>
		    </form>
		<?php
			}
		?>
	</div>
</div>
</div>
<div id="loader"></div>
<script type="text/javascript">
$('.field_hint').mouseover(function(){
	$(".tooltiptext").css("opacity", "1");
	$(".fieldtooltip").css("opacity", "1");
	$(".tooltiptext").css("visibility", "visible");
});
$('.field_hint').mouseout(function(){
    $(".tooltiptext").css("opacity", "0");
	$(".tooltiptext").css("visibility", "hidden");
});
var spinner = $('#loader');
$(function() {
  $('#loader').hide();
  $('.frmcustomer').submit(function(e) {
	$('#loader').show();
	e.preventDefault();	
	$.ajax({
		url: "<?php echo site_url('Connect/SubmitCustomerInfo');?>",
		method: "POST",
		data: $(this).serialize(),
		dataType: 'JSON',
		success: function(data){
			$('#loader').hide();
			$('.frmcustomer')[0].reset();
			$(".form-submitmsg").show().delay(4000).fadeOut();
			setTimeout(function () { 
				location.reload(true); 
			}, 4000); 
			$(".form-submitmsg").html(data);
		}
	});			
  });
});
</script>
<div id="loader"></div>
<?php $this->load->view('footer', $footer_data); ?>