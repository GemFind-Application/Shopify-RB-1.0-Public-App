<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('header');
?>
<style type="text/css">
	.wrapper{display: flex;align-items: center;flex-direction: column;justify-content: center;width: 100%;min-height: 100%;padding: 20px;}
	.installapp-form{-webkit-border-radius: 10px 10px 10px 10px;border-radius: 10px 10px 10px 10px;background: #fff;padding: 30px;width: 90%;max-width: 450px;position: relative;padding: 45px;-webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);text-align: left;}
	#SubmitInstallApp{background-color: #000;border: none;color: white;padding: 15px 80px;text-align: center;text-decoration: none;display: inline-block;text-transform: uppercase;font-size: 13px;-webkit-box-shadow: 0 10px 30px 0 rgba(255,255,255,0.4);box-shadow: 0 10px 30px 0 rgba(255,255,255,0.4);-webkit-border-radius: 5px 5px 5px 5px;border-radius: 5px 5px 5px 5px;margin: 14px 0px 0 0;-webkit-transition: all 0.3s ease-in-out;-moz-transition: all 0.3s ease-in-out;-ms-transition: all 0.3s ease-in-out;-o-transition: all 0.3s ease-in-out;transition: all 0.3s ease-in-out;}
	body{background-image: url('<?php echo base_url()?>assets/images/gemfind.jpg');background-repeat: no-repeat;background-size: cover;background-position: center; }
	.overlay{position: absolute;z-index: -1;background: rgba(0,0,0,0.35);width: 100%;top: 0;bottom: 0}
	.error{color: red;}
</style>
<div class="container wrapper">
	<div class="installapp-form fadeInDown">
		<h2 style="border-bottom: 1px solid #D0D0D0;padding: 0px 0px 10px 0px;">Ring Builder Install</h2>
	  <form action="" method="post" id="install_app" name="install_app" class="form-horizontal">
			<div class="form-body">
				<div class="form-group">
					<div class="col-md-12">	
						
							<label class="fadeIn first control-label" style="margin-bottom: 13px;">Enter Store URL</label>	
							<p style="font-style: italic;">Enter your myshopify URL here (enter it exactly like this: mystore.myshopify.com)</p>									
						
						<input type="text" id="app_url" name="app_url" value="" class="fadeIn second form-control" maxlength="255">
					</div>
				</div>					
			</div>
			<div class="form-actions right fadeIn third">
				<input type="submit" name="SubmitInstallApp" id="SubmitInstallApp" class="btn green" value="Submit">
			</div>
		</form>
	</div>
</div>
<div class="overlay"></div>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.validate.min.js'></script>
<script type="text/javascript">
jQuery(document).ready(function(){   
   jQuery("#install_app").validate({
	    rules: {        
	      app_url: {
	        required: true
	      }
	  	}
	});
});
</script>