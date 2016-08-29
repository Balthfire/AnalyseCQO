<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.css') ?>"/>
	<link rel="stylesheet" href="<?php echo base_url('/assets/styles/login.css') ?>"/>

	<style>
		body{
			padding: 15px;
		}
	</style>
</head>
<body>
<!-- All the files that are required -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<!-- Where all the magic happens -->
<!-- LOGIN FORM -->
<div class="text-center" style="padding:50px 0">
	<div class="logo">Contrôles Qualité Optimisés</div>
	<!-- Main Form -->
	<div class="login-form-1">
		<form id="login-form" class="text-left" action="<?php echo base_url('index.php/Cconnexion/login')?>" method="Post">
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="NNI" class="sr-only">Username</label>
						<input type="text" class="form-control" id="NNI" name="NNI" placeholder="NNI">
					</div>
					<div class="form-group">
						<label for="pwd" class="sr-only">Password</label>
						<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe">
					</div>
					<div class="form-group login-group-checkbox">
						<input type="checkbox" id="lg_remember" name="lg_remember">
						<label for="lg_remember">remember</label>
					</div>
				</div>
				<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			</div>
		</form>
	</div>
	<?php
	echo $this->session->flashdata('status');
	?>
	<!-- end:Main Form -->
</div>
</body>
</html>

