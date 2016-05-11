<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.css') ?>"/>
	<link rel="stylesheet" href="<?php echo base_url('/assets/styles/login.css') ?>"/>
	<script type="text/javascript">
	/*
		function getXMLHttpRequest() {
			var xhr = null;

			if (window.XMLHttpRequest || window.ActiveXObject) {
				if (window.ActiveXObject) {
					try {
						xhr = new ActiveXObject("Msxml2.XMLHTTP");
					} catch(e) {
						xhr = new ActiveXObject("Microsoft.XMLHTTP");
					}
				} else {
					xhr = new XMLHttpRequest();
				}
			} else {
				alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
				return null;
			}
			return xhr;
		}

		function request(callback) {
			var xhr = getXMLHttpRequest();

			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
					callback(xhr.responseText);
				}
			};

			var nni = encodeURIComponent(document.getElementById("NNI").value);
			var pwd = encodeURIComponent(document.getElementById("pwd").value);
			<?php echo base_url('Cconnexion/login') ?>

			xhr.open("POST",<?php echo base_url('Cconnexion/login') ?>,true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("NNI=nni&pwd=pwd");
		}

		function readData(sData) {
			alert(sData);
		}*/
	</script>

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
		<form id="login-form" class="text-left" action="index.php/Cconnexion/login" method="Post">
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
	<!-- end:Main Form -->
</div>
</body>
</html>

