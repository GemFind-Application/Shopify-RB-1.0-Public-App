<?php
$checkDiamondCookie['diamondid'] = json_decode($check_diamond_cookie)[0];
//$checkDiamondCookie['diamondid'] = '';
/*echo '<pre>';
print_r($checkDiamondCookie);
exit;*/
if($is_lab_settings == 1 ){
   $add_lab_url = 'islabsettings/1';
}
?>
<ul class="tab-ul">
	  <?php if(!$checkDiamondCookie['diamondid']) { ?>
		  <?php if($checkDiamondCookie['diamondid']) { ?>
			  <li class="tab-li"><div><a href="javascript:;" onclick="diamond()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div></li>
			  <?php } else { ?>
			  <li class="tab-li active"><div><a href="javascript:;" onclick="setting()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div></li>
			  <?php } ?>
		  <?php if(!$checkDiamondCookie['diamondid']) { ?>
			  <li class="tab-li"><div><a href="javascript:;" onclick="diamond()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div></li>
			  <?php } else { ?>
			  <li class="tab-li active"><div><a href="javascript:;" onclick="setting()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div></li>
		  <?php } ?>
	  <?php } else {?>
		   <?php if($checkDiamondCookie['diamondid']) { ?>
			  <li class="tab-li"><a href="javascript:;" onclick="diamond()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div></li>
			  <?php } else { ?>
			  <li class="tab-li active"><div><a href="javascript:;" onclick="setting()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div></li>
			  <?php } ?>
		  <?php if(!$checkDiamondCookie['diamondid']) { ?>
			  <li class="tab-li"><div><a href="javascript:;" onclick="diamond()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div></li>
			  <?php } else { ?>
			  <li class="tab-li active"><div><a href="javascript:;" onclick="setting()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div></li>
		  <?php } ?>
	  <?php } ?>
      <li class="tab-li"><div><a href="javascript:;"><span class="tab-title"><?php echo 'Review'; ?><strong><?php echo 'Complete Ring'; ?></strong></span><i class="finalring-icon tab-icon"></i></a></div></li>
</ul>

<script type="text/javascript">
	function setting()
	{
	  jQuery.removeCookie('_shopify_ringsetting', {path: '/'});
	  jQuery.removeCookie('_shopifysaveringbackvalue', {path: '/'});
	  jQuery.removeCookie('_shopifysaveringfiltercookie', {path: '/'});
	  //jQuery.removeCookie('shopifysavebackvalue', {path: '/'});
      window.location.href="<?php echo $final_shop_url.'/settings/'; ?>"
	}

	function diamond()
	{
	  jQuery.removeCookie('_shopify_diamondsetting', {path: '/'});
	  jQuery.removeCookie('shopifysavebackvalue', {path: '/'});
	  jQuery.removeCookie('shopifysavefiltercookie', {path: '/'});
	  window.location.href="<?php echo $final_shop_url.'/diamondtools/'; ?>"
	}

</script>