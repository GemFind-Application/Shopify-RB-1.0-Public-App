<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gemfind Admin Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?=base_url()?>assets/resources/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="<?=base_url()?>assets/resources/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url()?>assets/resources/css/sb-admin.css" rel="stylesheet">
    <style>
    h2 {color: white; }
    p {color: red;}
    </style>
</head>

<body>
 <div class="container admin_login">
      <form class="form-signin" method="POST">
	    <?php if($this->session->flashdata('fail')) { ?>
		<div class="alert alert-danger fade in alert-dismissible show alert-status-container" style="margin-top:18px;">
		 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true" style="font-size:20px">×</span>
		  </button><strong>Failed!</strong> <span class="alert-status"><?php if($this->session->flashdata('fail')) { echo $this->session->flashdata('fail');} ?></span>
		</div>
		<?php } ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <p><?php
            if ($error == 1) { echo "Too Many Login Attempts"; }
            if ($error == 2) { echo "Invalid Login Credentials."; }
        ?></p> 
        <input type="username" name="user_name" class="form-control" placeholder="Username" required autofocus /> 
        <input type="password" name="pass" class="form-control" placeholder="Password" required /> 
        <input class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Login" />
      </form>

    </div> <!-- /container -->

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

</body>

</html>
