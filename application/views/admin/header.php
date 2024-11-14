<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
defined('BASEPATH') OR exit('No direct script access allowed');
$current_url = $this->uri->uri_string();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gemfind Admin Panel</title>
	<link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?=base_url()?>assets/resources/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="<?=base_url()?>assets/resources/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url()?>assets/resources/css/sb-admin.css" rel="stylesheet">
    <style type="text/css">
        .all_stores{
            background: #f4f4f4;
            padding-left: 38px;
            padding-top: 20px;
            height: 300px;
            overflow-y: auto;
            padding-bottom: 20px;
        }
		
    </style>
	
</head>

<body id="page-top">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar static-top navbar-toggleable-md bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">GemFind RingBuilder Admin Panel</a>
        <div class="collapse navbar-collapse" id="navbarExample">
            <ul class="sidebar-nav navbar-nav">
                <li class="nav-item <?php if($current_url == 'admin'){echo 'active';} ?>">
                    <a class="nav-link" href="<?=base_url()?>admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="nav-item <?php if($current_url == 'admin/coupons' || $current_url == 'admin/addcoupon' || strpos($current_url, 'updatecoupon') !== false){echo 'active';} ?>">
                    <a class="nav-link" href="<?=base_url()?>admin/coupons"><i class="fa fa-fw fa-tag"></i> Coupons</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url()?>admin/logout"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper py-3">

        <div class="container-fluid">

        