<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

</div>
        <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="<?=base_url()?>assets/resources/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/resources/vendor/tether/tether.min.js"></script>
    <script src="<?=base_url()?>assets/resources/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?=base_url()?>assets/resources/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?=base_url()?>assets/resources/vendor/chart.js/Chart.min.js"></script>
    <script src="<?=base_url()?>assets/resources/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/resources/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for this template -->
    <script src="<?=base_url()?>assets/resources/js/sb-admin.min.js"></script>
	<script src="<?=base_url()?>assets/resources/js/jquery.validate.min.js"></script>
	<script src="<?=base_url()?>assets/resources/js/additional-methods.min.js"></script>
	<script type="text/javascript">
	// just for the demos, avoids form submit
	$(".frmcoupon").validate({
	  rules: {
		field: {
		  required: true,
		  step: 10
		}
	  }
	});
	$(document).ready(function(){
		setTimeout(function(){ 
			$(".alert-danger").hide();
		}, 5400);

		$('#couponDataTable').DataTable();
		setTimeout(function(){ $(".alert-status-container").hide(); }, 3000);
		$('.delete').click(function(){
			var checkstr =  confirm('Are you sure you want to delete this?');
			if(checkstr == true){
				window.location.href = "<?=base_url()?>admin/delete_coupon/"+$(this).data("couponid");
				$.ajax({
					 type: "POST",
					 url: "<?=base_url()?>admin/delete_coupon/"+$(this).data("couponid"), 
					 data: {couponid: $(this).data("couponid")},
					 dataType: "text",  
					 cache:false,
					 success: 
						  function(data){
							//window.location.href = "<?=base_url()?>admin/coupons";
							$(".alert-status-delete").html("Coupon has been deleted successfully!!");
							$(".alert-status-delete").show();
							window.setTimeout(function() {
							    $(".alert-status-delete").fadeTo(500, 0).slideUp(500, function(){
							        $(this).hide(); 
							    });
							}, 4000);
							
						  }
					  });// you have missed this bracket
				 return false;
			}
			else{
				return false;
			}
		});
	});
	</script>
</body>

</html>
