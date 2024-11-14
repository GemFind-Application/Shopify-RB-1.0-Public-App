<?php
defined('BASEPATH') OR exit('No direct script access allowed');
foreach($shop_coupans as $key => $value)
{
	$arrShopCoupans[] = $value->shop;
}
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?=base_url()?>admin">Dashboard</a></li>
	<li class="breadcrumb-item"><a href="<?=base_url()?>admin/coupons">Coupons</a></li>
</ol>
<form method="POST" action="<?=base_url()?>admin/addcoupon" class="frmcoupon">
	<input type="hidden" name="action" value="add">
	<!--<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Select Shop</label>
	  <div class="col-10">
		<select class="form-control" name="shop" required>
			<option value="">Please select shop</option>
			<?php /*
			foreach ($shop_details as $key => $value ) {
				if(!in_array($value->shop,$arrShopCoupans))
				{
					echo "<option value='".$value->shop."'>".$value->shop."</option>";
				}
			} */ ?>
		</select>
	  </div>
	</div>-->
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Shop</label>
	  <div class="col-10">
		<input class="form-control" type="text" placeholder="e.g. gemfind-demo-store-3.myshopify.com" required name="shop" />
	  </div>
	</div>
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Discount code</label>
	  <div class="col-10">
		<input class="form-control" type="text" placeholder="e.g. SPRINGSALE" required name="discount_code" />
	  </div>
	</div>
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Select Discount Type</label>
	  <div class="col-10">
		<select class="form-control" name="discount_type" required>
			<option value="Percentage">Percentage </option>
			<option value="Flat rate">Flat rate </option>
		</select>
	  </div>
	</div> 
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Discount value</label>
	  <div class="col-10">
		<input class="form-control" type="discount_value" placeholder="e.g. 10" required name="discount_value" />
	  </div>
	</div>
	<div class="form-group row"> 
	  <div class="col-10">
		<input type="submit" class="btn btn-primary" name="add_coupon">
	  </div>
	</div> 
</form>
<!--<p>All Registered Stores</p>
<div class="all_stores">
	<ul>
	<?php
		foreach ($shop_details as $key => $value ) {
		  echo "<li value='".$value->shop."'>".$value->shop."</li>";
		} 
	?>
	</ul>
</div>-->