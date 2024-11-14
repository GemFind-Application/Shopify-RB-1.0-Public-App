<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<style type="text/css">
    .alert-status-delete{display: none;}
</style>
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>admin">Dashboard</a></li>
            </ol>
            <?php if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success fade in alert-dismissible show alert-status-container" style="margin-top:18px;">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
              </button><strong>Success!</strong> <span class="alert-status"><?php if($this->session->flashdata('success')) { echo $this->session->flashdata('success');} ?></span>
            </div>
            <?php } ?>
			<?php if($this->session->flashdata('fail')) { ?>
			<div class="alert alert-danger fade in alert-dismissible show">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true" style="font-size:20px">×</span>
			  </button><strong>Failed!</strong> <span class="alert-status"><?php echo $this->session->flashdata('fail'); ?></span>
			</div>
			<?php } ?>
            <!-- Example Tables Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-fw fa-tag"></i> Add New Coupon <a href="<?=base_url()?>admin/addcoupon"><button class="btn btn-primary">+</button></a>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-dark" data-toggle="table" id="couponDataTable" width="100%" cellspacing="0" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Shop</th>
									<th>Actual Amount</th>
                                    <th>Discount Code</th>
                                    <th>Discount Value</th>
									<th>Discounted Amount</th>
                                    <th width="110px">Action</th>  
                                </tr>
                            </thead>
                           
                            <tbody>
                            <?php 
                                $i = 1;
								foreach ($coupons as $k => $v) { ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $v->shop;?></td>
									<td><?php echo MONEY_FORMAT.APP_TOTAL_CHARGE;?></td>
                                    <td><?php echo $v->discount_code;?></td>
                                    <td>
									<?php 
										if($v->discount_type == "Percentage")
										{
											echo $v->discount_value."%";
											$discounted_total = APP_TOTAL_CHARGE - (APP_TOTAL_CHARGE * ($v->discount_value/100)); 
										}
										else
										{
											echo $v->discount_value." - Flat rate";
											$discounted_total = APP_TOTAL_CHARGE - $v->discount_value; 
										}
									?>
									</td>
									<td><?php echo MONEY_FORMAT.$discounted_total;?></td>
                                    <td><a href="<?php echo base_url()."admin/updatecoupon/".$v->id;?>" class="btn btn-primary">Edit</a><a href="" class="btn btn-danger delete" data-couponid="<?php echo $v->id;?>">Delete</a></td>
                                </tr>
                            <?php $i++; } ?> 
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>