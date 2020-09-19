<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CPFI SYSTEM</title>
	<!-- Bootstrap CSS CDN -->
	<link 
		rel="stylesheet" 
		href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="shortcut icon" href="<?= base_url('assets/image/misc/ico.ico') ?>" type="image/x-icon">
	<!-- Our Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css?random=<?php echo mt_rand(); ?>">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css">


	<!-- Font Awesome JS -->
	<script 
		defer 
		src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"></script>
	<script 
		defer 
		src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"></script>
</head>
<body>
	<div class="container pr-0">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#"><img src="<?= base_url('assets/image/misc/logo.png') ?>" width="50"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<!-- <li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Features</a>
					</li> -->
				</ul>
				<span class="navbar-text">
					<a class="nav-link" href="<?php echo base_url('logout-portal'); ?>">Logout</a>
				</span>
			</div>
		</nav>
	</div>
  <div class="wrapper">
		