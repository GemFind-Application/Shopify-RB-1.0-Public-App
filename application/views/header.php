<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	$shop =$_GET["shop"];
   $this->load->model('general_model');
   $shop_data = $this->general_model->getDiamondConfig($shop);

   $current_url = $this->uri->uri_string();

?>
	<meta charset="utf-8">

	<?php if($current_url == 'ringbuilder/settings') :?>
		
		 <?php if(!empty($shop_data->ring_meta_title)) :?>
		   <title> <?php echo $shop_data->ring_meta_title; ?> </title>
		  <?php endif; ?>

		 <?php if(!empty($shop_data->ring_meta_description)) :?>
		   <meta name='description' content='<?php echo $shop_data->ring_meta_description; ?>' />
		 <?php endif; ?>

	<?php endif; ?>

	<?php if(strpos($current_url, 'ringbuilder/settings/view/path') !== false ) :?>
		 <meta name="robots" content="noindex">
	<?php endif; ?>

	<?php if($current_url == 'ringbuilder/diamondtools') :?>

		<?php if(!empty($shop_data->diamond_meta_title)) :?>
		   <title> <?php echo $shop_data->diamond_meta_title; ?> </title>
		  <?php endif; ?>

		 <?php if(!empty($shop_data->diamond_meta_description)) :?>
		   <meta name="description" content="<?php echo $shop_data->diamond_meta_description; ?>" />
		 <?php endif; ?>

	<?php endif; ?>

	<?php if(strpos($current_url, 'ringbuilder/diamondtools/product') !== false ) :?>
			<meta name="robots" content="noindex">
	<?php endif; ?>
	
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css">
	<!-- <link rel="stylesheet" href="<?php //echo base_url()?>assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="<?php echo base_url()?>assets/css/custom.css" rel="stylesheet">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">
    

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	/* body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	} */

	a {
		color:000000;
		/*color: #003399;*/
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	<script type="text/javascript">
		$('body').addClass('gemfind-tool-ringbuilder');
		$('html').addClass('gemfind-ringbuilder-app');
		jQuery('body').addClass('gemfind-tools-common');
		// ken dana website search fix
		jQuery('.search-hover .icon-search').on('click',function(){
			if(jQuery(this).hasClass('icon-arrow-right')){
				jQuery('form#search').submit();
			}
			jQuery('.search-hover > a.icon').removeClass('icon-search');
			jQuery('.search-hover > a.icon').addClass('icon-arrow-right');
			jQuery('.search-hover .search-wrapper').addClass('is-active');
		})
		jQuery('.search-hover .search-wrapper .icon-close').on('click',function(){
			jQuery('.search-hover .search-wrapper').removeClass('is-active');	
			jQuery('.search-hover > a.icon').removeClass('icon-arrow-right');
			jQuery('.search-hover > a.icon').addClass('icon-search');
		})

		// angeluccijewelry
		if(jQuery(window).width() > 1024 ){
			console.log('here');
			jQuery("li.navmenu-item-parent").mouseenter(function(){
				console.log('hover');
				jQuery(this).find(".navmenu-submenu").attr("data-animation-state","open");
				jQuery(this).find(".navmenu-link").attr("aria-expanded","true");
				jQuery(this).find(".navmenu-submenu").attr("data-animation","closed=>open");
				jQuery(".site-main-dimmer").attr("data-animation-state","open");
				jQuery(".site-main-dimmer").attr("data-animation","closed=>open");

			})

			jQuery("li.navmenu-item-parent").mouseleave(function(){
				console.log('hover');
				jQuery(this).find(".navmenu-link").attr("aria-expanded","false");
				jQuery(this).find(".navmenu-submenu").attr("data-animation","open=>closed");
				jQuery(this).find(".navmenu-submenu").attr("data-animation-state","closed");
				jQuery(".site-main-dimmer").removeAttr("data-animation");
				jQuery(".site-main-dimmer").removeAttr("data-animation-state");
			})
		}else{
			
			jQuery(".mobile-nav-content .navmenu-submenu").attr("data-accordion-state","closed");
			
			
			jQuery(".site-header-menu-toggle").on('click',function(){
				jQuery('#site-mobile-nav').attr("data-open", "true");
				jQuery('.mobile-nav-panel').attr("data-animation-state", "open");
				jQuery('.mobile-nav-overlay').attr("data-animation-state", "open");
			})

			jQuery(".mobile-nav-close").on('click',function(){
				jQuery('#site-mobile-nav').attr("data-open", "false");
				jQuery('.mobile-nav-panel').attr("data-animation-state", "closed");
				jQuery('.mobile-nav-overlay').attr("data-animation-state", "closed");
			})

			jQuery(".navmenu-button").click(function() {
				var statedrop = jQuery(this).siblings(".navmenu-submenu").attr("data-accordion-state");
				if(statedrop == "closed"){
			   		jQuery(this).siblings(".navmenu-submenu").attr("data-accordion-state","open");
				}else{
					jQuery(this).siblings(".navmenu-submenu").attr("data-accordion-state","closed");
				}
			});
			jQuery(document).ready(function(){	
				jQuery(".site-footer-block-content ul.navmenu").attr("data-accordion-state","closed");
				jQuery("h2.site-footer-block-title").on('click',function(){
					var statedrop = jQuery(this).next(".site-footer-block-content > ul.navmenu").attr("data-accordion-state");
					console.log(statedrop);
					if(statedrop && statedrop == "closed"){
				   		jQuery(this).siblings(".site-footer-block-content ul.navmenu").attr("data-accordion-state","open");
					}else{
						jQuery(this).siblings(".site-footer-block-content ul.navmenu").attr("data-accordion-state","closed");
					}
				});
			});

		}
		jQuery(document).ready(function(){	
			$("#page_url").html( window.location.href);
		});
	</script>
	<div id="page_url" style="display:none;"></div>
	
  