<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($coupon))
{
	$coupon_id = $coupon[0]->id;
	$shop = $coupon[0]->shop;
	$discount_code = $coupon[0]->discount_code;
	$discount_value = $coupon[0]->discount_value;
	$discount_type = $coupon[0]->discount_type;
}
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?=base_url()?>admin">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="<?=base_url()?>admin/coupons">Coupons</a></li>
</ol>
<form method="POST" action="<?=base_url()?>admin/updatecoupon" class="frmcoupon">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="coupon_id" value="<?php echo $coupon_id; ?>"/>
	<!--<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Select Shop</label>
	  <div class="col-10">
		<select class="form-control" name="shop" required disabled>
		<option value="">Please select shop</option>
		<?php /*
		foreach ($shop_details as $key => $value ) {
			if($shop == $value->shop)
			{
				$selected = "selected=selected";
			}
			else
			{
				$selected = "";
			}
		  echo "<option value='".$value->shop."' ".$selected.">".$value->shop."</option>";
		} */ ?>
		</select>
	  </div>
	</div>-->
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Shop</label>
	  <div class="col-10">
		<input class="form-control" type="text" placeholder="e.g. SPRINGSALE" required name="shop" value="<?php echo $shop;?>" readonly="readonly"/>
	  </div>
	</div>
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Discount code</label>
	  <div class="col-10">
		<input class="form-control" type="text" placeholder="e.g. SPRINGSALE" required name="discount_code" value="<?php echo $discount_code;?>"/>
	  </div>
	</div>
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Select Discount Type</label>
	  <div class="col-10">
		<select class="form-control" name="discount_type" required>
			<option value="Percentage" <?php if($discount_type == "Percentage") { echo "selected='selected'"; } ?>>Percentage </option>
			<option value="Flat rate" <?php if($discount_type == "Flat rate") { echo "selected='selected'"; } ?>>Flat rate </option>
		</select>
	  </div>
	</div>
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Discount value(in Percentage)</label>
	  <div class="col-10">
		<input class="form-control" type="discount_value" placeholder="e.g. 10" required name="discount_value" value="<?php echo $discount_value;?>"/>
	  </div>
	</div>
	<div class="form-group row"> 
	  <div class="col-10">
		<input type="submit" class="btn btn-primary" name="update_coupon">
	  </div>
	</div> 
</form>